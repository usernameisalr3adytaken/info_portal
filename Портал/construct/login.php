<?php
declare(strict_types=1);

// Путь: Портал/construct/login.php
// Контроллер аутентификации без агрессивной смены session_id на входе.
// После установки флагов — session_write_close() и redirect.

require_once 'session_bootstrap.php';
require_once 'functions.php';


function redirect(string $url): void { header("Location: " . $url, true, 302); exit(); }

// Разрешаем только POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") { redirect("../admin/reg.php"); }

// CSRF
if (empty($_POST["csrf_token"]) || empty($_SESSION["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])) {
    $_SESSION["errMsg"] = '<p style="color: red; text-align: center;">Сессия устарела. Обновите страницу и попробуйте ещё раз.</p>';
    redirect("../admin/reg.php");
}

// Капча (одноразовая)
$captchaProvided = isset($_POST["captcha"]) ? (string)$_POST["captcha"] : "";
$captchaSession  = isset($_SESSION["captcha_code"]) ? (string)$_SESSION["captcha_code"] : "";
if ($captchaProvided === "" || $captchaSession === "" || strtolower($captchaProvided) !== strtolower($captchaSession)) {
    $_SESSION["errMsg"] = '<p style="color: red; text-align: center;">Капча введена неверно.</p>';
    redirect("../admin/reg.php");
}
unset($_SESSION["captcha_code"]);

// Поля
$login    = isset($_POST["login"]) ? trim((string)$_POST["login"]) : "";
$password = isset($_POST["password"]) ? (string)$_POST["password"] : "";
if ($login === "" || $password === "") {
    $_SESSION["errMsg"] = '<p style="color: red; text-align: center;">Не все поля заполнены!</p>';
    redirect("../admin/reg.php");
}

// Пользователь
try { $user = selectOne('admins', ['login' => $login]); }
catch (Throwable $e) {
    $_SESSION["errMsg"] = '<p style="color: red; text-align: center;">Временная ошибка. Попробуйте позже.</p>';
    redirect("../admin/reg.php");
}
if (!$user) {
    $_SESSION["errMsg"] = '<p style="color: red; text-align: center;">Логин или пароль введены неверно!</p>';
    redirect("../admin/reg.php");
}

// Проверка пароля (хеш/открытый текст)
$stored = (string)($user['Pword'] ?? "");
$isHash = str_starts_with($stored, '$2y$') || str_starts_with($stored, '$argon2');
$ok     = $isHash ? password_verify($password, $stored) : hash_equals($stored, $password);
if (!$ok) {
    $_SESSION["errMsg"] = '<p style="color: red; text-align: center;">Логин или пароль введены неверно!</п>';
    redirect("../admin/reg.php");
}

// Авторизация
$_SESSION['is_admin']    = true;
$_SESSION['admin_login'] = (string)$user['Login'];
$_SESSION['regen_at']    = time();

//echo " ".$_SESSION['is_admin']." ".$_SESSION['admin_login']." ".$_SESSION['regen_at'];

session_write_close(); // гарантированная запись на диск перед редиректом

redirect("../admin/index-admin.php");
