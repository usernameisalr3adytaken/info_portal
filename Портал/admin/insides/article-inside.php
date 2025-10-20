<?php 
    include "../../construct/functions.php";
    $post = selectOne('posts', ['id' => $_GET['post']]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$post['Title']?></title>
    
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://kit.fontawesome.com/01be32f69c.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <?php include("../../construct/Shapka_admin_inside.php"); ?>

    <div class="back" style="border-top: solid #d1cdcd">
        <div style="margin-left: 5%; margin-bottom: 80px;">
            <table style="background: none;">
                <td style="width: 65%;">
                    <p style="font-size: 70px;"><?=$post['Title']?></p>
                </td>
                <td style="width: 10%">
                </td>
                <td style="width: 25%">
                    <p style="font-size: 30px;">Дата публикации</p>
                    <p style="font-size: 30px;"><?echo russianDate($post['Published'])?></p>
                </td>
            </table>    
        </div>

        <div style="width: 80%; margin-left: 10%; font-size: 24px;">
            <img 
                src="<?='../../Info/posts/'. $post['Preview'] ?>"
                style="max-width: 100%; max-height: 100%; height: auto; display: block; object-fit: contain;"
            > 
            <div class="only_text" style="width: 100%; margin-top: 40px; margin-bottom: 40px;">
                <p><?=$post['Info'] ?></p>
            </div>
        </div>

    </div>

    <?php include("../../construct/footer.php"); ?>

</body>
</html>
