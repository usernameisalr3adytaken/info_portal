
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информационный портал</title>
    
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://kit.fontawesome.com/01be32f69c.js" crossorigin="anonymous"></script>
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
</head>
<body>
    
    <?php include("../construct/Shapka_insides.php"); ?>

    <div class="back" style="border-top: solid #d1cdcd; height: 700px;">
        <div class="back_child">
            <h3 style="text-align: center; margin-top: 0; margin-bottom: 0;">Логин</h3>
            <form method="post" id="loginForm">
                <input type="text" name="login" class="login-input" placeholder="Введите логин" required> 
                <h3 style="text-align: center; margin-top: 20px; margin-bottom: 0;">Пароль</h3>
                <input type="password" name="password" class="login-input" placeholder="Введите пароль" required> 
                <div class="h-captcha" 
                    data-sitekey="a6beaef4-76a4-4470-bac2-9d0c4ad447ee"
                    data-callback="onCaptchaSuccess"
                    data-expired-callback="onCaptchaExpired">
                </div>
                <button onclick="<?php include("../construct/login.php"); ?>" id="loginBtn" class="btn" type="submit" disabled>Войти</button>
            </form>
            <div class="error-message"><?=$errMsg?></div>
        </div>
    </div>
    

    <style>
    .back_child {
        max-width: 400px;
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

    .h-captcha {
        margin: 20px 0;
        display: flex;
        justify-content: center;
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
    </style>

    <script>
    // Разблокируем кнопку при успешной капче
    function onCaptchaSuccess(token) {
        document.getElementById("loginBtn").disabled = false;
    }

    // Блокируем кнопку, если капча сброшена/истекла
    function onCaptchaExpired() {
        document.getElementById("loginBtn").disabled = true;
    }

    // (Опционально) Проверка перед отправкой формы
    document.getElementById("loginBtn").addEventListener("click", function(e) {
        if (this.disabled) {
            e.preventDefault();
            alert("Сначала пройдите капчу!");
            return false;
        }
        // Ваш код для входа (например, submit формы)
    });
    </script>
  
    <?php include("../construct/footer.php"); ?>

</body>
</html>
