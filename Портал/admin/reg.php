<?php
declare(strict_types=1);
// Путь: Портал/admin/reg.php — форма входа.

require_once '../construct/session_bootstrap.php';

// Запрет кэширования формы
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

// Генерация одноразовой капчи на каждую загрузку формы
$alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$code = '';
for ($i = 0; $i < 5; $i++) {
    $code .= $alphabet[random_int(0, strlen($alphabet)-1)];
}
$_SESSION["captcha_code"] = $code;
$_SESSION["captcha_generated_at"] = time();

$errMsg = $_SESSION["errMsg"] ?? "";
unset($_SESSION["errMsg"]);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Информационный портал — вход</title>
    
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://kit.fontawesome.com/01be32f69c.js" crossorigin="anonymous"></script>

</head>
<body>
    <?php include("../construct/Shapka_insides.php"); ?>

    <div class="back" style="border-top: solid #d1cdcd; height: 700px;">
        <div class="back_child">
            <h2 style="text-align: center; margin-top: 0; margin-bottom: 0;">Вход в админ-панель</h2>
            
            <form method="post" action="../construct/login.php" autocomplete="off" novalidate id="loginForm">
                <h3 style="text-align: center; margin-top: 20px; margin-bottom: 0;">Логин</h3>
                <input type="text" name="login" class="login-input" placeholder="Введите логин" required> 
                
                <h3 style="text-align: center; margin-top: 20px; margin-bottom: 0;">Пароль</h3>
                <input type="password" name="password" class="login-input" placeholder="Введите пароль" required> 
                
                
                <div class="captcha-container-horizontal">
                    <div class="captcha-display">
                        <?php echo htmlspecialchars($_SESSION["captcha_code"], ENT_QUOTES|ENT_SUBSTITUTE, "UTF-8"); ?>
                    </div> 
                    <input type="text" name="captcha" class="captcha-input" placeholder="Введите код" required maxlength="5">
                </div>

                <input type="hidden" name="csrf_token" value="<?php
                    if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); }
                    echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
                ?>" />

                <button class="btn" type="submit">Войти</button>
            </form>
            <div class="error-message"><?=$errMsg?></div>
        </div>
    </div>

    <style>
    .back_child {
        max-width: 400px;
        height: 420px;
        margin: 40px auto;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', Roboto, sans-serif;
    }

    h3 {
        color:rgb(72, 45, 45);
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 16px;
    }
    h2 { color:rgb(72, 45, 45); }

    #loginForm {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .login-input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .login-input:focus {
        border-color:rgb(229, 70, 70);
        box-shadow: 0 0 0 3px rgba(229, 70, 70, 0.2);
        outline: none;
    }

    .login-input::placeholder {
        color: #a0aec0;
        opacity: 1;
    }

    .captcha-container-horizontal {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 20px 0;
    }

    .captcha-display {
        background: linear-gradient(135deg, #495057 0%, #212529 100%);
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        padding: 12px 20px;
        border-radius: 8px;
        letter-spacing: 6px;
        font-family: 'Courier New', monospace;
        user-select: none;
        min-width: 140px;
        flex-shrink: 0;
    }

    .captcha-input {
        flex: 1;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-sizing: border-box;
        width: 160px;
    }

    .captcha-input:focus {
        border-color:rgb(229, 70, 70);
        box-shadow: 0 0 0 3px rgba(229, 70, 70, 0.2);
        outline: none;
    }

    .captcha-input::placeholder {
        color: #a0aec0;
        opacity: 1;
    }

    .btn {
        width: 100%;
        height: 40px;
        padding: 0px;
        background-color: #3775dd;
        box-shadow: 0 2px #21487f;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 10px 0 0 0;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn:disabled {
        background-color:rgb(224, 203, 203);
        box-shadow: 0 2px rgb(127, 33, 33);
        cursor: not-allowed;
        transform: none;
    }

    .error-message {
        display: block;
        margin-top: 20px;
        color:rgb(229, 62, 62);
        text-align: center;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .captcha-note {
        text-align: center;
        color: #6b7280;
        font-size: 0.8rem;
        margin-top: 15px;
        font-style: italic;
    }
    </style>

    <?php include("../construct/footer.php"); ?>

</body>
</html>