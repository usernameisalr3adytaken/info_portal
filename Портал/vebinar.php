    <?php 
        include "construct/functions.php";

        $selectedTheme = isset($_GET['Theme']) ? $_GET['Theme'] : '';
        $selectedYear = isset($_GET['Year']) ? $_GET['Year'] : '';
        $selectedMonth = isset($_GET['Month']) ? $_GET['Month'] : '';

        $years = getTime2("activities");
        $Themes = getThemes("activities");

        $activities = getWithFilter2("activities", $selectedTheme, $selectedYear, $selectedMonth);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вебинары</title>

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
                        <form action="vebinar.php" method="GET">
                            <p style="margin-left: 20px; padding-top: 15px;"> Темы </p>
                            <select name="Theme" style="font-size: 20px; width: 160px; margin-left: 20px;" onchange="this.form.submit()">
                                <option value=""> Все </option>
                                <?php foreach($Themes as $Theme): ?>
                                    <option value="<?=$Theme["Theme"]?>" <?= ($Theme["Theme"] === $selectedTheme) ? 'selected' : '' ?>>
                                        <?=$Theme["Theme"]?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            </div>
                        
                            <div class="dates">
                                    <p style="margin-left: 20px; padding-top: 10px;"> Дата проведения </p>

                                    <p style="margin-left: 20px; margin-top: 15px; font-size: 14px;">Год</p>
                                        <select name="Year" style="font-size: 20px; width: 160px; margin-left: 20px;" onchange="this.form.submit()">
                                            <option value=""> Все </option>
                                            <?php foreach($years as $year): ?>
                                                <option value="<?=$year?>" <?= ($year == $selectedYear) ? 'selected' : '' ?>>
                                                    <?=$year?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                    <p style="margin-left: 20px; margin-top: 5px; font-size: 14px;">Месяц</p>
                                        <select name="Month" style="font-size: 20px; width: 160px; margin-left: 20px;"  onchange="this.form.submit()">
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
                        </form>
                </div>
            </td>

            <td>
                <div class="plate">
                    <h1 style="text-align: center;"> Вебинары</h1>

                    <?php if (count($activities) > 0): ?>
                        <?php foreach ($activities as $activ): ?>
                            <div class="article">
                                <a href = "<?php echo "insides/vebinar-inside.php?activ=". $activ['Id'] ?>" style="text-decoration: none; display: block;">
                                <table class="inside_table" style="width: 100%; border-collapse: collapse; transition: all 0.3s ease;">
                                    <tr style="transition: all 0.3s ease;">    
                                        <td style="width: 42%; max-width: 45%; height: 300px; vertical-align: top; padding: 0.85%; transition: all 0.3s ease;">
                                        
                                            <img 
                                                        src="<?='Info/Activities/'. $activ['Preview'] ?>"
                                                        alt="Изображение статьи" 
                                                        style="max-width: 100%; max-height: 100%; height: auto; display: block; object-fit: contain; transition: all 0.3s ease;"
                                                    >
                                        </td>
                                        <td style="width: 33%; vertical-align: middle; transition: all 0.3s ease;">
                                            
                                            <p style="font-size: 28px; margin-left: 10px; margin-bottom: 20px; color: #333; font-weight: 600; transition: all 0.3s ease;">
                                                <?=$activ['Title'] ?>
                                            </p>
                                            <p style="font-size: 18px; margin-left: 10px; line-height: 1.5; color: #555; transition: all 0.3s ease;">
                                                <?=$activ['Short'] ?>
                                            </p>
                                        </td>
                                        <td style="width: 25%; vertical-align: middle; transition: all 0.3s ease;">
                                            <p style="font-size: 86px; text-align: center; margin-left: -5px; color: #333; font-weight: 700; transition: all 0.3s ease;">
                                                <?= date('d', strtotime($activ["ArrangedAt"])) ?>
                                            </p>
                                            <p style="font-size: 30px; text-align: center; margin-left: -5px; color: #555; font-weight: 600; transition: all 0.3s ease;">
                                                <? echo rusMonthYear($activ["ArrangedAt"]) ?>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                </a>
                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center; font-size: 18px; margin-top: 50px;">По вашему запросу ничего не найдено.</p>
                    <?php endif; ?>
                </div>
                
            </td>
        </tr>
    </table>

    <?php include("construct/footer.php"); ?>

</body>
</html>