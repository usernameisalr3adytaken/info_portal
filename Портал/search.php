<?php
    include "construct/functions.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchWord'])){
        $posts = searchInTitleShort($_POST['searchWord'], 'posts');
        $videos = searchInTitleShort($_POST['searchWord'], 'videos');
        $activs = searchInTitleShort($_POST['searchWord'], 'activities');
        $events = searchInTitleShort($_POST['searchWord'], 'events_');
    }
    
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Информационный портал</title>

        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <script src="https://kit.fontawesome.com/01be32f69c.js" crossorigin="anonymous"></script>

    </head>
    <body>
        
        <?php include("construct/Shapka.php"); ?>

        <table style="height: 110px; width: 1690px;">
            <tr>
                <td>
                    <div class="filters">
                        <div class="themes">
                            <p style="margin-left: 20px; padding-top: 15px;"> Категория </p>
                            <select style="font-size: 20px; width: 160px; margin-left: 20px;" disabled>
                                <option value=""> Все </option>
                                <option>Посты</option>
                                <option>Видео</option>
                                <option>Мероприятия</option>
                                <option>Вебинары</option>
                            </select>
                        </div>
                        <div class="dates">
                            <p style="margin-left: 20px; padding-top: 10px;"> Дата публикации </p>

                            <p style="margin-left: 20px; margin-top: 15px; font-size: 14px;">Год</p>
                                <select name="Year" style="font-size: 20px; width: 160px; margin-left: 20px;" onchange="this.form.submit()" disabled>
                                    <option value=""> Все </option>
                                    <?php foreach($years as $year): ?>
                                        <option value="<?=$year?>" <?= ($year == $selectedYear) ? 'selected' : '' ?>>
                                            <?=$year?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                            <p style="margin-left: 20px; margin-top: 5px; font-size: 14px;">Месяц</p>
                                <select name="Month" style="font-size: 20px; width: 160px; margin-left: 20px;"  onchange="this.form.submit()"disabled>
                                    <option value="" > Все </option>
                                    <?php
                                        for ($m = 1; $m <= 12; $m++) {
                                            $monthNames = [1=>'Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
                                            $selected = ($selectedMonth == $m) ? 'selected' : '';
                                            echo "<option value=\"$m\" $selected>{$monthNames[$m]}</option>";
                                        }
                                    ?>
                                </select>
                    </div>
                    
                    
                </td>

                <td>
                    <div class="plate">
                        <h1 style="text-align: center;"> Результат поиска по запросу "<?php echo $_POST['searchWord']?>" </h1> 

                        <h1 style="text-align: left; margin-left: 120px;">Статьи</h1>
                        
                            <?php if ($posts == null): ?>
                                <p style="margin-left: 120px;">Статьи не найдены</p>
                            <?php endif; ?>
                            <?php foreach ($posts as $post): ?>
                                <div class="article">
                                    <a href="<?php echo "insides/article-inside.php?post=". $post['Id'] ?>" style="text-decoration: none; display: block;">
                                        <table class="inside_table" style="width: 100%; border-collapse: collapse; transition: all 0.3s ease;">
                                            <tr style="transition: all 0.3s ease;">
                                                <td style="width: 50%; max-width: 50%; height: 300px; vertical-align: top; padding: 1.75%; transition: all 0.3s ease;">
                                                    <img 
                                                        src="<?='Info/Posts/'. $post['Preview'] ?>" 
                                                        alt="Изображение статьи" 
                                                        style="max-width: 100%; max-height: 100%; height: auto; display: block; object-fit: contain; transition: all 0.3s ease;"
                                                    >
                                                </td>
                                                <td style="width: 35%; vertical-align: middle; text-align: center; padding: 0 15px; transition: all 0.3s ease;">
                                                    <p style="font-size: 28px; margin-bottom: 25px; color: #333; font-weight: 600; transition: all 0.3s ease;">
                                                        <?=$post['Title'] ?>
                                                    </p>
                                                    <p style="font-size: 18px; line-height: 1.5; color: #555; margin-bottom: 40px; transition: all 0.3s ease;">
                                                        <?=$post['Short'] ?>
                                                    </p>

                                                    <div style="background: #f9f9f9; padding: 12px; border-radius: 6px; display: inline-block; transition: all 0.3s ease;">
                                                        <p style="font-size: 16px; margin: 0; color: #777; font-weight: 500;">
                                                            Дата публикации
                                                        </p>
                                                        <p style="font-size: 16px; margin: 5px 0 0; color: #444; font-weight: 600;">
                                                            <? echo russianDate($post['Published']) ?>
                                                        </p>
                                                    </div>
                                                </td>
                                                <td style="width: 5%;"></td>
                                            </tr>
                                        </table>
                                    </a>
                                </div>

                            <?php endforeach; ?>

                        
                        <h1 style="text-align: left; margin-left: 120px;">Видео</h1>
                            <?php if ($videos == null): ?>
                                <p style="margin-left: 120px;">Видео не найдены</p>
                            <?php endif;?>
                            <?php foreach ($videos as $video): ?>
                            <div class="article">
                                <a href = "<?php echo "insides/video-inside.php?video=". $video['Id'] ?>" style="text-decoration: none; display: block;">
                                    <table class="inside_table" style="width: 100%; border-collapse: collapse; transition: all 0.3s ease;">
                                        <tr style="transition: all 0.3s ease;">
                                            <td style="width: 50%; max-width: 50%; height: 300px; vertical-align: top; padding: 1.75%; transition: all 0.3s ease;">
                                                <img 
                                                    src="<?='Info/Videos/'. $video['Preview'] ?>" 
                                                    alt="Изображение статьи" 
                                                    style="max-width: 100%; max-height: 100%; height: auto; display: block; object-fit: contain; transition: all 0.3s ease;"
                                                >
                                            </td>
                                            <td style="width: 35%; vertical-align: middle; text-align: center; padding: 0 15px; transition: all 0.3s ease;">
                                                <p style="font-size: 28px; margin-bottom: 25px; color: #333; font-weight: 600; transition: all 0.3s ease;">
                                                    <?=$video['Title'] ?>
                                                </p>
                                                <p style="font-size: 18px; line-height: 1.5; color: #555; margin-bottom: 40px; transition: all 0.3s ease;">
                                                    <?=$video['Short'] ?>
                                                </p>

                                                <div style="background: #f9f9f9; padding: 12px; border-radius: 6px; display: inline-block; transition: all 0.3s ease;">
                                                    <p style="font-size: 16px; margin: 0; color: #777; font-weight: 500;">
                                                        Дата публикации
                                                    </p>
                                                    <p style="font-size: 16px; margin: 5px 0 0; color: #444; font-weight: 600;">
                                                        <? echo russianDate($video['Published']) ?>
                                                    </p>
                                                </div>
                                            </td>
                                            <td style="width: 5%;"></td>
                                        </tr>
                                    </table>
                                </a>
                            </div>
                        <?php endforeach; ?>

                        
                        <h1 style="text-align: left; margin-left: 120px;">Мероприятия</h1>
                            <?php if ($events == null) :?>
                                <p style="margin-left: 120px;">Мероприятия не найдены</p>
                            <?php endif; ?>
                            <?php foreach ($events as $event): ?>
                            <div class="article">
                                <a href="<?php echo "insides/event-inside.php?event=". $event['Id'] ?>" style="text-decoration: none; display: block;">
                                    <table class="inside_table" style="width: 100%; border-collapse: collapse; transition: all 0.3s ease;">
                                        <tr style="transition: all 0.3s ease;">
                                            <td style="width: 50%; max-width: 50%; height: 300px; vertical-align: top; padding: 0.85%; transition: all 0.3s ease;">
                                                <img 
                                                    src="<?='Info/Events/'. $event['Preview'] ?>" 
                                                    alt="Изображение статьи" 
                                                    style="max-width: 100%; max-height: 100%; height: auto; display: block; object-fit: contain; transition: all 0.3s ease;"
                                                >
                                            </td>
                                            <td style="width: 30%; vertical-align: middle; transition: all 0.3s ease;">
                                                <p style="font-size: 28px; margin-left: 15px; margin-bottom: 20px; color: #333; font-weight: 600; transition: all 0.3s ease;">
                                                    <?=$event['Title'] ?>
                                                </p>
                                                <p style="font-size: 18px; margin-left: 15px; line-height: 1.5; color: #555; transition: all 0.3s ease;">
                                                    <?=$event['Short'] ?>
                                                </p>
                                            </td>
                                            <td style="width: 20%; vertical-align: middle; transition: all 0.3s ease;">
                                                <p style="font-size: 86px; text-align: center; margin-left: 20px; color: #333; font-weight: 700; transition: all 0.3s ease;">
                                                    <?= date('d', strtotime($event["ArrangedAt"])) ?>
                                                </p>
                                                <p style="font-size: 30px; text-align: center; margin-left: 20px; color: #555; font-weight: 600; transition: all 0.3s ease;">
                                                    <? echo rusMonthYear($event["ArrangedAt"]) ?>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </a>
                            </div>

                        <?php endforeach; ?>


                        <h1 style="text-align: left; margin-left: 120px;">Вебинары</h1>

                        
                            <?php if ($activs == null):?>
                                <p style="margin-left: 120px; margin-bottom: 40px;">Вебинары не найдены</p> 
                            <?php endif; ?>   

                            <?php foreach ($activs as $activ): ?>
                            <div class="article">
                                <a href = "<?php echo "insides/vebinar-inside.php?activ=". $activ['Id'] ?>" style="text-decoration: none; display: block;">
                                <table class="inside_table" style="width: 100%; border-collapse: collapse; transition: all 0.3s ease;">
                                    <tr style="transition: all 0.3s ease;">    
                                        <td style="width: 50%; max-width: 50%; height: 300px; vertical-align: top; padding: 0.85%; transition: all 0.3s ease;">
                                        
                                            <img 
                                                        src="<?='Info/Activities/'. $activ['Preview'] ?>"
                                                        alt="Изображение статьи" 
                                                        style="max-width: 100%; max-height: 100%; height: auto; display: block; object-fit: contain; transition: all 0.3s ease;"
                                                    >
                                        </td>
                                        <td style="width: 30%; vertical-align: middle; transition: all 0.3s ease;">
                                            
                                            <p style="font-size: 28px; margin-left: 15px; margin-bottom: 20px; color: #333; font-weight: 600; transition: all 0.3s ease;">
                                                <?=$activ['Title'] ?>
                                            </p>
                                            <p style="font-size: 18px; margin-left: 15px; line-height: 1.5; color: #555; transition: all 0.3s ease;">
                                                <?=$activ['Short'] ?>
                                            </p>
                                        </td>
                                        <td style="width: 20%; vertical-align: middle; transition: all 0.3s ease;">
                                            <p style="font-size: 86px; text-align: center; margin-left: 20px; color: #333; font-weight: 700; transition: all 0.3s ease;">
                                                <?= date('d', strtotime($activ["ArrangedAt"])) ?>
                                            </p>
                                            <p style="font-size: 30px; text-align: center; margin-left: 20px; color: #555; font-weight: 600; transition: all 0.3s ease;">
                                                <? echo rusMonthYear($activ["ArrangedAt"]) ?>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </td>
            </tr>
        </table>

    <?php include("construct/footer.php"); ?>


    </body>
    </html>