<?php
declare(strict_types=1);

// Путь: Портал/construct/admin_guard.php
// Подключайте первой строкой КАЖДОЙ admin-страницы.

require_once 'session_bootstrap.php';

// Минимальная проверка авторизации
$okFlag  = isset($_SESSION['is_admin']) && ($_SESSION['is_admin'] === true || $_SESSION['is_admin'] === 1 || $_SESSION['is_admin'] === '1');
$okLogin = isset($_SESSION['admin_login']) && $_SESSION['admin_login'] !== '';

// Необязательный отладочный режим (только при ALLOW_DEBUG_GUARD=1 и ?dbg=1)
$allowDebug = getenv('ALLOW_DEBUG_GUARD') === '1';
$wantDebug  = isset($_GET['dbg']) && $_GET['dbg'] === '1';

if (!($okFlag && $okLogin)) {
    if ($allowDebug && $wantDebug) {
        header('Content-Type: text/plain; charset=utf-8');
        echo "DEBUG admin_guard:\n";
        echo "session_id=" . session_id() . "\n";
        echo "is_admin=" . var_export($_SESSION['is_admin'] ?? null, true) . "\n";
        echo "admin_login=" . var_export($_SESSION['admin_login'] ?? null, true) . "\n";
        echo "last_activity=" . var_export($_SESSION['last_activity'] ?? null, true) . "\n";
        echo "__FILE__=" . __FILE__ . "\n";
        exit();
    }
    $_SESSION['errMsg'] = '<p style="color: red; text-align: center;">Требуется вход в систему.</p>';
    header('Location: ../admin/reg.php', true, 302);
    exit();
}

// Периодическая смена session_id каждые 10 минут (НЕ во время логина)
if (empty($_SESSION['regen_at']) || (time() - (int)$_SESSION['regen_at'] >= 600)) {
    session_regenerate_id(true);
    $_SESSION['regen_at'] = time();
}
