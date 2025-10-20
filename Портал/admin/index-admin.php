<?php

    include "../construct/functions.php";

    $tables = ["posts", "videos", "events_", "activities"];
    $fresh = getFreshSix($tables);

?>

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

</head>
<body>
    
    <?php include("../construct/Shapka_admin.php"); ?>

    <table style="height: 110px; width: 1690px;">
        <tr>
            <td >
                <div class="links">
                    <h2 class="section-title" style="text-align: center; margin-top: 30px;">Полезные ссылки</h2>
                    <ul style="margin-left: 20px;">
                        <a href="<?php echo PSU?>"><li class="useful">Сайт ПГНИУ</li></a>
                        <li class="useful">Чат-Бот для студентов</li>
                        <li class="useful">Чат-Бот для сотрудников</li>
                        <li class="useful">Психологическое тестирование</li>
                    </ul>

                    <h2 class="section-title" style="text-align: center; margin-top: 90px;">Социальные сети</h2>
                    <table class="social-links">
                        <tr>
                            <td class="social-cell"> 
                                <a href="<?php echo VK?>">
                                    <div class="social-content">
                                        <img src="../img/vk-icon.png" class="social-icon" alt="VK">
                                    </div>
                                </a>
                            </td>
                            <td class="social-cell"> 
                                <a href="<?php echo TG?>">
                                    <div class="social-content">
                                        <img src="../img/telegram-icon-1024x862-5ov8mojz.png" class="social-icon" alt="Telegram">
                                    </div>
                                </a>
                            </td>
                            <td class="social-cell"> 
                                <a href="<?php echo DZ?>">
                                    <div class="social-content">
                                        <img src="../img/yandex-zen.png" class="social-icon" alt="Yandex Zen">
                                    </div>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="social-cell"> 
                                <a href="<?php echo OK?>">
                                    <div class="social-content">
                                        <img src="../img/odnoklassniki-logo.svg" class="social-icon" alt="Odnoklassniki">
                                    </div>
                                </a>
                            </td>
                            <td class="social-cell"> 
                                <a href="<?php echo YT?>">
                                    <div class="social-content">
                                        <img src="../img/152810.png" class="social-icon" alt="YouTube">
                                    </div>
                                </a>
                            </td>
                            <td class="social-cell"> 
                                <a href="<?php echo RT?>">
                                    <div class="social-content">
                                        <img src="../img/3522624.png" class="social-icon" alt="Rutube">
                                    </div>
                                </a>
                            </td>
                        </tr>
                    </table>

<style>
    /* Стили для таблицы социальных ссылок */
    .social-links {
        margin-left: 7.5px;
        border-collapse: separate;
        border-spacing: 15px;
        margin-left: -15px;
    }
    
    .social-cell {
        width: 60px;
        height: 60px;
        background: #eeeeee;
        border-radius: 50%;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .social-cell:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .social-cell::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(200, 50, 50, 0.15) 0%, rgba(255, 100, 100, 0) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .social-cell:hover::after {
        opacity: 0.8;
    }
    
    .social-content {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
    }
    
    .social-icon {
        width: 25px;
        height: 25px;
        vertical-align: middle;
        transition: transform 0.3s ease;
    }
    
    .social-cell:hover .social-icon {
        transform: scale(1.1);
    }
    
    /* Специальные размеры для отдельных иконок */
    .social-cell:nth-child(1) .social-icon {
        width: 30px;
        height: 30px;
    }
    
    .social-cell:nth-child(2) .social-icon {
        width: 25px;
        height: 25px;
    }
    
    .social-cell:nth-child(3) .social-icon {
        width: 27px;
        height: 27px;
    }
</style>
                </div>
            </td>

            <td>
                <div class="plate" style="height: 800px;">
                    <p style="font-size: 40px; margin-left: 100px; margin-top: 30px;"> О нас </p>
                    <p style="font-size: 20px; margin-left: 120px; margin-top: 10px;"> 
                        Информационный портал Пермского государственного национально исследовательского университета. <br>
                        Этот сайт предназначен для размещения контента об информационной безопасности в виде статей и роликов, <br>
                        также для публикации сведений о соответствующих мероприятиях и вебинарах.
                    </p>

                    <p style="font-size: 40px; margin-left: 100px; margin-top: 60px;"> Последние публикации </p>
                    <table style="width: 1200px; height: 400px; margin-left: 120px; margin-top: 30px;">
                        <tr>
                            <td class="publication-cell">
                                <div class="publication-content">
                                    <?php $type = openType($fresh[0]['Type']); ?>
                                    
                                    <a href="<?php echo "insides/".$type.$fresh[0]["Id"] ?>">
                                        <div class="publication-title"><?=$fresh[0]["Title"]?></div>
                                        <div class="publication-text"><?=$fresh[0]["Short"]?></div>
                                    </a>
                                </div>
                            </td>

                            <td style="width: 10px;"></td>
                            
                            <td class="publication-cell">
                                <div class="publication-content">
                                    <?php $type = openType($fresh[1]['Type']); ?>
                                    
                                    <a href="<?php echo "insides/".$type.$fresh[1]["Id"] ?>">
                                        <div class="publication-title"><?=$fresh[1]["Title"]?></div>
                                        <div class="publication-text"><?=$fresh[1]["Short"]?></div>
                                    </a>
                                </div>
                            </td>
                            <td style="width: 10px;"></td>
                            <td class="publication-cell">
                                <div class="publication-content">
                                    <?php $type = openType($fresh[2]['Type']); ?>
                                    
                                    <a href="<?php echo "insides/".$type.$fresh[2]["Id"] ?>">
                                        <div class="publication-title"><?=$fresh[2]["Title"]?></div>
                                        <div class="publication-text"><?=$fresh[2]["Short"]?></div>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <tr style="height: 10px;"></tr>

                        <tr>
                           <td class="publication-cell">
                                <div class="publication-content">
                                    <?php $type = openType($fresh[3]['Type']); ?>
                                    
                                    <a href="<?php echo "insides/".$type.$fresh[3]["Id"] ?>">
                                        <div class="publication-title"><?=$fresh[3]["Title"]?></div>
                                        <div class="publication-text"><?=$fresh[3]["Short"]?></div>
                                    </a>
                                </div>
                            </td>
                            <td style="width: 10px;"></td>
                            <td class="publication-cell">
                                <div class="publication-content">
                                    <?php $type = openType($fresh[4]['Type']); ?>
                                    
                                    <a href="<?php echo "insides/".$type.$fresh[4]["Id"] ?>">
                                        <div class="publication-title"><?=$fresh[4]["Title"]?></div>
                                        <div class="publication-text"><?=$fresh[4]["Short"]?></div>
                                    </a>
                                </div>
                            </td>
                            <td style="width: 10px;"></td>
                            <td class="publication-cell">
                                <div class="publication-content">
                                    <?php $type = openType($fresh[5]['Type']); ?>
                                    
                                    <a href="<?php echo "insides/".$type.$fresh[5]["Id"] ?>">
                                        <div class="publication-title"><?=$fresh[5]["Title"]?></div>
                                        <div class="publication-text"><?=$fresh[5]["Short"]?></div>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <?php include("../construct/footer.php"); ?>


</body>
</html>