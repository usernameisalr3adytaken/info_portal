<?php
    include "../construct/functions.php";

    $errMsg = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST["login"];
        $password = $_POST["password"];

        if ($login === "" || $password === ""){ 
           $errMsg = '<p style="color: red; text-align: center;">Не все поля заполнены!</p>';
        }
        else
        {
            $existence = selectOne('admins', ['login' => $login]);
            if($existence && ($password === $existence['Pword'])){
                header('location: '."index-admin.php");
            }else{
                $errMsg = '<p style="color: red; text-align: center;">Логин или пароль введены неверно!</p>';
            }
        }
    }
    else{
        $errMsg = "";
    }
?>