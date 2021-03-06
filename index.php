<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 18.04.2017
 * Time: 12:39
 */
include_once('head.php');
// результат обработки формы
$rezalt='';
// количество ошибок в форме
$qerors=0;
// папка загрузки файлов
$uploaddir = 'upload'.DIRECTORY_SEPARATOR;
// очистка переданных значений из формы
/**
 * @param $val
 * @return string
 */
function cleen ($val){
    $val=trim($val);
    $val=strip_tags($val,'<br></br>');
    $val=htmlspecialchars ($val,ENT_QUOTES);
    $val=stripslashes($val);
    return $val;
}
if (!empty($_POST)){
    /* получаем данные по переданому логину пользователя из формы */
    $user_name=cleen($_POST['user_name']);
    /* получаем данные по переданому имени пользователя из формы */
    $name =cleen($_POST['name']);
    /* получаем данные по переданому email пользователя из формы */
    $email=cleen($_POST['email']);
    /* получаем данные по переданому тексту из формы */
    $text=cleen($_POST['text']);
    /* получаем данные по переданому файлу из формы*/
    $file=$_FILES['file'];
    //проверка логина
    if (!preg_match('/^[a-zA-Z0-9]{3,16}$/', $user_name)) :
        $qerors++;
        ?>
        <!-- отображение ошибки-->
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('user_name')
            });
        </script>
        <?php
        /** @var string $user_name_text_eror */
        $user_name_text_eror='Логин должен начинается с латинской буквы длинной от 3 до 16 символов и состоять только из латинских букв и цифр';
        if (empty($user_name)){
            $user_name_text_eror='Поле не может быть пустым';
        }
    endif;
    //проверка Имени
    if (!preg_match('/^[a-zа-яё\s]+$/iu', $name)||empty($name)) {
        $qerors++;
        ?>
        <!-- отображение ошибки-->
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('name')
            });
        </script>
        <?php
        /** @var string $name_text_eror */
        $name_text_eror='Ошибка имени. ';
        if (empty($name)){
            $name_text_eror='Поле не может быть пустым';
        }
    }
    //проверка email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $qerors++;
        ?>
        <!-- отображение ошибки-->
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('email')
            });
        </script>
        <?php
        /** @var string $email_text_eror */
        $email_text_eror=$email.' некорректный';
        if (empty($name)){
            $email_text_eror='Поле не может быть пустым';
        }
    }
    //проверка text на маты (к примеру) и длину текста
    $bedwords = array('bla','blin');
    $regex = '/\b(' .implode('|', $bedwords) .')\b/si';
    if (strlen($text)<20||strlen($text)>250){
        $qerors++;
        /** @var string $text_text_eror */
        $text_text_eror='Длина текста должна быть от 20 до 250 символов</br>';
        if (preg_match($regex, $text)){
            /** @var string $text_text_eror */
            $text_text_eror.='В тексте обнаружены запрещенные слова</br>';
        }
        ?>
        <!-- отображение ошибки-->
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('text')
            });
        </script>
        <?php
    }
    //проверка Файла
    $url_file=null;
    if (!empty($_FILES['file'])&&$_FILES['file']['error']==0){
        /** @var string $filename */
        $filename=$_FILES['file']['name'];
        // получаем формат файла.
        $ext = substr($filename, 1 + strrpos($filename, "."));
        //дата в формате день-месяц-год-часы-минуты-секунды
        $today = date("d-m-Y-H-i-s");
        //создание имени файла
        $filename =$today . "." . $ext;
        //зпгрузка и сохранение файла под новым именем
        $move=@move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $filename);
        //при ошибке загрузки
        if (!$move) {
            $qerors++;
            ?>
            <!-- отображение ошибки-->
            <script type="text/javascript">
                $(document).ready(function() {
                    ShowHideDiv('file')
                });
            </script>
            <?php
            $file_text_eror='Ошибка загрузки файла';
        }
        else {
            $url_file=$uploaddir . $filename;
        }
    }
    //проверим на существование логина
    /*  подготовка запроса */
    $loginsql=$mysqli->prepare("SELECT `ID` FROM `users` WHERE `login` LIKE ? ");
    /*  Привязка переменных к параметрам подготавливаемого запроса */
    $loginsql->bind_param("s", $user_name);
    /* выполнение подготовленного запроса */
    $loginsql->execute();
    /* сохранение результатов запроса */
    $loginsql->store_result();
    /* количество строк запроса */
    $login_row=$loginsql->num_rows;
    if ($login_row!=0){
        ?>
        <!-- отображение ошибки-->
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('rezalt');
                ClassDiv('rezalt','alert alert-danger col-md-6');
            });
        </script>
        <?php
        $rezalt.='Пользователь с логином '.$user_name.' уже существует</br>';
    }
    $loginsql->close();
    //проверим на существование mail
    /*  подготовка запроса */
    $mailsql=$mysqli->prepare("SELECT `ID` FROM `users` WHERE `mail` LIKE ? ");
    /*  Привязка переменных к параметрам подготавливаемого запроса */
    $mailsql->bind_param("s", $email);
    /* выполнение подготовленного запроса */
    $mailsql->execute();
    /* сохранение результатов запроса */
    $mailsql->store_result();
    /* количество строк запроса */
    $mail_row=$mailsql->num_rows;
    if ($mail_row!=0){
        ?>
        <!-- отображение ошибки-->
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('rezalt');
                ClassDiv('rezalt','alert alert-danger col-md-6');
            });
        </script>
        <?php
        $rezalt.='Пользователь с email '.$email.' уже существует</br>';
    }
    /* закрываем запрос */
    $mailsql->close();
    /* при отсутсвии ошибок валидации и отстсвии полученного логина и  email*/
    if ($login_row==0&&$mail_row==0&&$qerors==0)
    {
        /*  подготовка запроса добавления клиента*/
        $sql_ins=$mysqli->prepare("INSERT INTO `users`(`login`, `name`, `mail`, `message`, `IP`, `url_file`) VALUES (?,?,?,?,?,?)");
        /* выполнение подготовленного запроса */
        $sql_ins->bind_param('ssssss', $user_name,$name,$email,$text,$_SERVER['REMOTE_ADDR'],$url_file);
        /* выполнение подготовленного запроса */
        $sql_ins->execute();
        /* при отсутсвии ошибок запроса */
        if($sql_ins->errno==0){
            ?>
            <!-- отображение успешной регистрации-->
            <script type="text/javascript">
                $(document).ready(function() {
                    ShowHideDiv('rezalt')
                    ClassDiv('rezalt','alert alert-success col-md-6');
                });
            </script>
            <?php
            $rezalt='Регистрация прошла успешно';
            unset($user_name,$name,$email,$text);
        }
        /* закрываем запрос */
        $sql_ins->close();
    }
}

?>
    <form method="post" enctype="multipart/form-data" class="form-horizontal" xmlns="http://www.w3.org/1999/html">
        <!--блок логина-->
        <div class="form-group">
            <label class="col-md-3 control-label">Логин</br> (От 6 до 20 латинских символов)</label>
            <div class="col-md-9">
                <input class="form-control" type="text" name="user_name" value="<?=@$user_name?>">
            </div>
        </div>
        <div class="row " id='user_name' style="display: none;">
            <div class="alert alert-danger col-md-9 col-md-offset-3 "><?=@$user_name_text_eror?></div>
        </div>
        <!--блок имени-->
        <div class="form-group">
            <label class="col-md-3 control-label">Ваше имя</label>
            <div class="col-md-9">
                <input  class="form-control" type="text" name="name" value="<?=@$name?>">
            </div>
        </div>
        <div class="row "  id='name' style="display: none;">
            <div class="alert alert-danger col-md-9 col-md-offset-3 "><?=@$name_text_eror?></div>
        </div>
        <!--блок email-->
        <div class="form-group">
            <label class="col-md-3 control-label">Ваш email</label>
            <div class="col-md-9">
                <input class="form-control" type="email" name="email" value="<?=@$email?>">
            </div>
        </div>
        <div class="row " id='email' style="display: none;">
            <div class="alert alert-danger col-md-9 col-md-offset-3 "><?=@$email_text_eror?></div>
        </div>
        <!--блок О себе-->
        <div class="form-group">
            <label class="col-md-3 control-label">О себе (От 20 до 250 символов)</label>
            <div class="col-md-9">
                <textarea class="form-control" name="text" required> <?=@$text?></textarea>
            </div>
        </div>
        <div class="row " id='text' style="display: none;">
            <div class="alert alert-danger col-md-9 col-md-offset-3 "><?=@$text_text_eror?></div>
        </div>
        <!--блок отправяемого файла-->
        <div class="form-group">
            <label class="col-md-3 control-label">Прикрипить файл</label>
            <div class="col-md-9">
                <input type="file" name="file" />
            </div>
        </div>
        <div class="row " id='file' style="display: none;">
            <div class="alert alert-danger col-md-9 col-md-offset-3 "><?=@$file_text_eror?></div>
        </div>
        <div class="form-group">
            <div class="col-xs-9 col-xs-offset-3">
                <button type="submit" id="contactForm" class="btn btn-primary">Отправить</button>
            </div>
        </div>
    </form>
    <!--блок результата-->
    <div class="row ">
        <div class="col-md-3"></div>
        <div id="rezalt" style="display: none;">
            <?=@$rezalt?>
        </div>
        <div class="col-md-3"></div>
    </div>
<?php include_once('futer.php');?>