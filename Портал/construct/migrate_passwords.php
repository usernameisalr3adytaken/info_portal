<?php
declare(strict_types=1);

// Путь: Портал/scripts/migrate_passwords.php
// Скрипт миграции паролей админов из открытого текста в хеш (PASSWORD_DEFAULT).
// Запускать из браузера авторизованным админом или из CLI: php migrate_passwords.php
//
// Логика:
// - Проверяем, что пользователь — админ (в вебе) или что скрипт запущен из CLI.
// - Выбираем все записи, где Pword НЕ начинается с "$2y$" или "$argon2".
// - Для каждой: считаем $hash = password_hash($plain, PASSWORD_DEFAULT) и обновляем.
// - Поддерживает dry-run: добавьте ?dry_run=1 (в вебе) или аргумент --dry-run (в CLI).

$IS_CLI = (PHP_SAPI === 'cli');

if (!$IS_CLI) {
    session_start();
    if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
        http_response_code(403);
        echo "Forbidden";
        exit();
    }
}

require_once __DIR__ . '/../construct/functions.php';

function is_hash_like(string $value): bool {
    return str_starts_with($value, '$2y$') || str_starts_with($value, '$argon2');
}

$dryRun = false;
if ($IS_CLI) {
    $dryRun = in_array('--dry-run', $argv ?? [], true);
} else {
    $dryRun = isset($_GET['dry_run']) && $_GET['dry_run'] === '1';
}

// Попытка получить подключение или универсальные хелперы
$db = null;
if (function_exists('db')) {
    // если у вас есть функция db(), которая возвращает PDO
    $db = db();
} elseif (function_exists('selectAll') && function_exists('updateOne')) {
    // будем использовать существующие хелперы
} else {
    // Попробуем найти PDO в глобальном скоупе, если его создаёт functions.php
    if (isset($GLOBALS['pdo']) && $GLOBALS['pdo'] instanceof PDO) {
        $db = $GLOBALS['pdo'];
    }
}

$rows = [];
if (function_exists('selectAll')) {
    $rows = selectAll('admins'); // ожидается массив записей с ключами id/login/Pword
} elseif ($db instanceof PDO) {
    $stmt = $db->query("SELECT id, login, Pword FROM admins");
    $rows = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
} else {
    echo "Не найдены подходящие хелперы БД (selectAll/updateOne) или PDO соединение.\n";
    exit(1);
}

$toMigrate = [];
foreach ($rows as $r) {
    $plain = (string)($r['Pword'] ?? '');
    if ($plain === '') {
        continue;
    }
    if (!is_hash_like($plain)) {
        $toMigrate[] = ['id' => $r['id'], 'login' => $r['login'], 'plain' => $plain];
    }
}

$updated = 0;
$skipped = 0;

if ($IS_CLI) {
    echo "Найдено к миграции: " . count($toMigrate) . " записей\n";
} else {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Найдено к миграции: " . count($toMigrate) . " записей\n";
}

foreach ($toMigrate as $r) {
    $newHash = password_hash($r['plain'], PASSWORD_DEFAULT);
    if ($dryRun) {
        $skipped++;
        $line = "DRY-RUN: id={$r['id']} login={$r['login']} -> хеш не записан\n";
        if ($IS_CLI) { echo $line; } else { echo $line; }
        continue;
    }

    if (function_exists('updateOne')) {
        updateOne('admins', $r['id'], ['Pword' => $newHash]);
        $updated++;
    } elseif ($db instanceof PDO) {
        $stmt = $db->prepare("UPDATE admins SET Pword = :hash WHERE id = :id");
        $stmt->execute([':hash' => $newHash, ':id' => $r['id']]);
        $updated++;
    } else {
        $skipped++;
    }
}

$summary = "Обновлено: {$updated}, пропущено: {$skipped}\n";
if ($IS_CLI) {
    echo $summary;
} else {
    echo $summary;
}

exit(0);
