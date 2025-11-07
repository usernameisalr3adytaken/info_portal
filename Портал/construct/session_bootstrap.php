<?php
declare(strict_types=1);

// Путь: Портал/construct/session_bootstrap.php
// Единая инициализация сессии с безопасными cookie-параметрами и щадящим таймаутом.

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);

// Жёсткие cookie-флаги
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', $secure ? '1' : '0');
ini_set('session.cookie_samesite', 'Lax');

session_name('PORTALSESSID');
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',  // если админка на поддомене, поставьте общий домен '.example.com'
    'secure'   => $secure,
    'httponly' => true,
    'samesite' => 'Lax',
]);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Щадящий таймаут по неактивности (30 минут)
$SESSION_INACTIVITY_TTL = 1800;
$now = time();

if (isset($_SESSION['last_activity'])) {
    $last = (int)$_SESSION['last_activity'];
    if ($last > 0 && ($now - $last) > $SESSION_INACTIVITY_TTL) {
        // Просрочено — чистим и просим перелогиниться
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'] ?? false, $params['httponly'] ?? true);
        }
        session_destroy();
        header('Location: ../admin/reg.php', true, 302);
        exit();
    }
}
// Обновляем/устанавливаем метку активности
$_SESSION['last_activity'] = $now;
