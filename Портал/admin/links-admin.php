
<?php
    require_once '../construct/admin_guard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ: Ссылки</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://kit.fontawesome.com/01be32f69c.js" crossorigin="anonymous"></script>

</head>
<body>
    
    <?php include("../construct/Shapka_admin.php"); ?>

    <div class="back" style="border-top: solid #d1cdcd; height: 700px;">
        <h1 style="margin-left: 200px;"> Социальные сети </h1>
        
        <div style="width: auto; height: auto; margin-left: 200px;">
            <table style="width: 900px; height: 150px; margin-left: 200px;">
                <tr>
                    <td class="social-cell" style="width: 300px;">
                        <a href="<?php echo VK?>">
                            <div class="social-content">
                                <p class="u_links"><img src="../img/vk-icon.png" class="social-icon"> Вконтакте</p>
                            </div>
                        </a>
                    </td>
                    
                    <td class="social-cell" style="width: 300px;">
                        <a href="<?php echo TG?>">
                            <div class="social-content">
                                <p class="u_links"><img src="../img/telegram-icon-1024x862-5ov8mojz.png" class="social-icon"> Телеграм</p>
                            </div>
                        </a>
                    </td>
                    
                    <td class="social-cell" style="width: 300px;">
                        <a href="<?php echo DZ?>">
                            <div class="social-content">
                                <p class="u_links"><img src="../img/yandex-zen.png" class="social-icon"> Дзен</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="social-cell">
                        <a href="<?php echo OK?>">
                            <div class="social-content">
                                <p class="u_links"><img src="../img/odnoklassniki-logo.svg" class="social-icon"> Одноклассники</p>
                            </div>
                        </a>
                    </td>
                    
                    <td class="social-cell">
                        <a href="<?php echo YT?>">
                            <div class="social-content">
                                <p class="u_links"><img src="../img/152810.png" class="social-icon"> YouTube</p>
                            </div>
                        </a>
                    </td>
                    
                    <td class="social-cell">
                        <a href="<?php echo RT?>">
                            <div class="social-content">
                                <p class="u_links"><img src="../img/3522624.png" class="social-icon"> Rutube</p>
                            </div>
                        </a>
                    </td>
                </tr>     
            </table>
            
        </div>

        <h1 style="margin-left: 200px; margin-top: 50px;"> Дополнительные ресурсы </h1>
        

        <div style="width: auto; height: auto; margin-left: 200px;">
            <table style="width: 900px; height: 300px; margin-left: 200px;">
                <tr>
                    <td class="service-cell" style="width: 215px; height: 150px;">
                        <a href="<?php echo PSU?>">
                            <div class="service-content">
                                <p class="u_links"><img src="../img/book-209.png" class="service-icon"> Сайт университета</p>
                            </div>
                        </a>
                    </td>
                    <td class="service-cell" style="width: 215px;">
                        <a href="<?php echo TELE?>">
                            <div class="service-content">
                                <p class="u_links"><img src="../img/831360.png" class="service-icon"> Телефонный справочник</p>
                            </div>
                        </a>
                    </td>
                    <td class="service-cell" style="width: 215px;">
                        <a href="<?php echo MAP?>">
                            <div class="service-content">
                                <p class="u_links"><img src="../img/32364.png" class="service-icon"> Карта университета</p>
                            </div>
                        </a>
                    </td>
                    <td class="service-cell" style="width: 215px;">
                        <a href="<?php echo RESOURCES?>">
                            <div class="service-content">
                                <p class="u_links"><img src="../img/weblogo.png" class="service-icon"> Интернет ресурсы<br>ПГНИУ</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="service-cell" style="width: 215px;">
                        <a href="<?php echo CHAT1?>">
                            <div class="service-content">
                                <p class="u_links"><img src="../img/14558.png" class="service-icon"> Чат-бот для студентов</p>
                            </div>
                        </a>
                    </td>
                    <td class="service-cell" style="width: 215px;">
                        <a href="<?php echo CHAT2?>">
                            <div class="service-content">
                                <p class="u_links"><img src="../img/14558.png" class="service-icon"> Чат-бот для сотрудников</p>
                            </div>
                        </a>
                    </td>
                    <td class="service-cell" style="width: 215px;">
                        <a href="<?php echo TEST?>">
                            <div class="service-content">
                                <p class="u_links"><img src="../img/test.png" class="service-icon"> Тестирование</p>
                            </div>
                        </a>
                    </td>
                    <td class="service-cell" style="width: 215px;">
                        <a href="<?php echo ETIS?>">
                            <div class="service-content">
                                <p class="u_links"><img src="../img/e-logo.png" class="service-icon"> ЕТИС</p>
                            </div>
                        </a>
                    </td>
                </tr>
            </table>
    
            
        </div>

    </div>

    <?php include("../construct/footer.php"); ?>

</body>
</html>