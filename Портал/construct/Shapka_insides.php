    <?php include("Paths.php"); ?>
    
    <header class="topside">

        <table style="padding-top: 12px; padding-left: 10px;">
            <tr>
                <td style="width: 385px; border-right: solid; border-right-color: #e8e1db;">
                    <a href="<?php echo "../".Main?>">

                        <p style="font-size: 32px; text-align: left; cursor: pointer;">  ПГНИУ </p>
                        <p style="font-size: 20px; text-align: left; cursor: pointer;"> Информационный портал </p>

                    </a> 
                </td>

                <td style="width: 120px;">
                    <a href = "<?php echo "../".Posts?>"><p class="clicker"> Статьи </p></a>
                </td>

                <td style="width: 120px;">
                    <a href = "<?php echo "../".Videos?>"><p class="clicker"> Видео </p></a>
                </td>

                <td style="width: 200px;">
                    <a href = "<?php echo "../".Events?>"><p class="clicker"> Мероприятия </p></a>
                </td>

                <td style="width: 170px;">
                    <a href = "<?php echo "../".WebEvents?>"><p class="clicker"> Вебинары </p></a>
                </td>

                <td style="width: 135px; border-right: solid; border-right-color: #e8e1db;">
                    <a href = "<?php echo "../".Usefull?>"><p class="clicker"> Ссылки </p> </a>
                </td>

                <td style="width: 380px; padding-left: 60px;">
                    <form action="../search.php" method="post">
                        <input type="text" name="searchWord" class="search" placeholder="Поиск"></input> 
                        <button class="glass"> <i class="fa-solid fa-magnifying-glass" style="color: #EAEAEA;"></i> </button>
                    </form>
                </td>

                <td >
                    <div style="height: 70px; width: 70px; background-color: #EAEAEA; border-radius: 5%; margin-left: 25%; cursor: pointer;">
                        <a href = "<?php echo PSU?>"><img class="logo" src="../img/PSU.png"></a>
                    </div>
                </td>

            </tr>
            

        </table>

                <style>
.clicker {
    transition: all 0.3s ease;
    padding: 8px 12px;
    border-radius: 8px;
    display: inline-block;
}

.clicker:hover {
    background-color: #800000;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}


</style>
    </header>