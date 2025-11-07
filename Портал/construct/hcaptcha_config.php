<?php
declare(strict_types=1);

// Путь: Портал/construct/hcaptcha_config.php
// Возвращает настройки hCaptcha из окружения. Никаких плейсхолдеров.
// Чтобы включить: выставьте переменные среды, например в .htaccess или конфиге PHP-FPM:
//   SetEnv HCAPTCHA_ENABLED 1
//   SetEnv HCAPTCHA_REQUIRED 1
//   SetEnv HCAPTCHA_SECRET "секрет_из_личного_кабинета_hcaptcha"

function hcaptcha_config(): array {
    $enabled  = getenv('HCAPTCHA_ENABLED') === '1';
    $required = getenv('HCAPTCHA_REQUIRED') === '1';
    $secret   = getenv('HCAPTCHA_SECRET') ?: null;

    return [
        'enabled'  => $enabled,
        'required' => $required,
        'secret'   => $secret,
    ];
}
