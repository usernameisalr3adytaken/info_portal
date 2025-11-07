<?php
declare(strict_types=1);

// Путь: Портал/construct/hcaptcha_verify.php
// Серверная верификация hCaptcha.

function verify_hcaptcha(string $secret, string $token): bool {
    if ($secret === '' || $token === '') {
        return false;
    }
    $url = 'https://hcaptcha.com/siteverify';
    $postData = http_build_query([
        'secret'   => $secret,
        'response' => $token,
        // 'remoteip' => $_SERVER['REMOTE_ADDR'] ?? null, // можно добавить при желании
    ], '', '&', PHP_QUERY_RFC3986);

    $context = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
                         "Content-Length: " . strlen($postData) . "\r\n",
            'content' => $postData,
            'timeout' => 5,
        ]
    ]);

    $res = @file_get_contents($url, false, $context);
    if ($res === false) {
        return false;
    }
    $data = json_decode($res, true);
    if (!is_array($data)) {
        return false;
    }
    return !empty($data['success']);
}
