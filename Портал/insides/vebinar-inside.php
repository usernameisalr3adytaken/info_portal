<?php 
    include "../construct/functions.php";
    $event = selectOne('activities', ['id' => $_GET['activ']]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$event['Title'] ?></title>
    
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://kit.fontawesome.com/01be32f69c.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <?php include("../construct/Shapka_insides.php"); ?>

    <div class="back" style="border-top: solid #d1cdcd">
        <div style="margin-left: 5%; margin-bottom: 80px;">
            <table style="background: none;">
                <td style="width: 65%;">
                    <p style="font-size: 70px;"> <?=$event['Title'] ?> </p>
                </td>
                <td style="width: 10%">
                </td>
                <td style="width: 25%">
                    <p style="font-size: 30px;"> Дата проведения:</p>
                    <p style="font-size: 30px;"> <? echo russianDate($event["ArrangedAt"])?> </p>
                </td>
            </table>    
        </div>

        <div style="width: 80%; margin-left: 10%; font-size: 24px;">
            <div class="only_text" style="width: 100%; margin-top: 40px; margin-bottom: 40px;">
                <?=$event['Info'] ?>
            </div>
        </div>

    </div>

    <?php include("../construct/footer.php"); ?>

</body>
</html>
