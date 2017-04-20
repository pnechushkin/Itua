<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 19.04.2017
 * Time: 21:49
 */
$mysqli = @new mysqli("localhost", "root", "", "itua");
// Если нет подключения к базе прекращаем работу
if (mysqli_connect_errno()) {
    echo '<h1>Ошибка подключения к БД</h1>', mysqli_connect_error();
    exit();
}
$Sort=$_POST['Sort'];
$StartDate=$_POST['StartDate'].'00:00:00';
$EndDate=$_POST['EndDate'].'23:59:59';
$result = $mysqli->query("SELECT `login`, `name`, `mail`, `message`,`date_reg`,`url_file` FROM `users` WHERE `date_reg` >= '$StartDate'
AND `date_reg` <= '$EndDate' $Sort");
if ($result->num_rows!=0):?>
    <div class="row">
        <div class="col-md-12" style="margin: 10px"></div>
    </div>
    <div class="row">
        <div style="text-align: center" class="col-md-12">Существующие пользователи</div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin: 10px"></div>
    </div>
    <?php while ($row = $result->fetch_assoc()) :?>
        <div class="row">
            <div class="col-md-4">Логин: </br><?=$row["login"]?> (<?=date("d.m.Y", strtotime($row["date_reg"]))?>)</div>
            <div class="col-md-4">Имя: </br><?=$row["name"]?></div>
            <div class="col-md-4">E-mail: </br><?=$row["mail"];
                if (!empty($row["url_file"])): ?>
                <a href="<?=$row["url_file"]?>">  Загруженный файл</a>
                    <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">О себе: </br><?=$row["message"]?></div>
        </div>
        <div class="row">
            <div class="col-md-12" style="margin: 10px"></div>
        </div>
    <?php endwhile;
    $result->free();
else:?>
    <div class="row">
        <div style="text-align: center" class="col-md-12">С <?=$StartDate?> до <?=$EndDate?> регистраций не производилось</div>
    </div>
<?php endif;
$mysqli->close();