<?php
declare(strict_types=1);
// Путь: Портал/construct/logout.php — корректный выход.
require_once 'session_bootstrap.php';

$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'] ?? false, $params['httponly'] ?? true);
}
session_destroy();

header('Location: ../admin/reg.php', true, 302);
exit();
