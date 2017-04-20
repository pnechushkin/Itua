<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 18.04.2017
 * Time: 12:39
 */
include_once('head.php');
$rezalt='';
$qerors=0;
$uploaddir = 'files/';
function cleen ($val){
    $val=trim($val);
    $val=strip_tags($val,'<br></br>');
    $val=htmlspecialchars ($val,ENT_QUOTES);
    $val=stripslashes($val);
    return $val;
}
if (!empty($_POST)){
    $user_name=cleen($_POST['user_name']);
    $name =cleen($_POST['name']);
    $email=cleen($_POST['email']);
    $text=cleen($_POST['text']);
    $file=$_FILES['file'];
    //проверка логина
    if (!preg_match('/^[a-zA-Z0-9]{3,16}$/', $user_name)) :
        $qerors++;
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('user_name')
            });
        </script>
        <?php
        $user_name_text_eror='Логин должен начинается с латинской буквы длинной от 3 до 16 символов и состоять только из латинских букв и цифр';
    endif;
    //проверка Имени
    if (!preg_match('/^[a-zа-яё\s]+$/iu', $name)) {
        $qerors++;
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('name')
            });
        </script>
        <?php
        $name_text_eror='Ошибка имени';
    }
    //проверка email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $qerors++;
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('email')
            });
        </script>
        <?php
        $email_text_eror=$email.' некорректный';
    }
    //проверка text на маты (к примеру)
    $bedwords = array('bla','blin');
    $regex = '/\b(' .implode('|', $bedwords) .')\b/si';
    if (preg_match($regex, $text)){
        $qerors++;
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('text')
            });
        </script>
        <?php
        $text_text_eror='В тексте обнаружены запрещенные слова';
    }
    //проверка Файла
    if (!empty($_FILES['file'])&&$_FILES['file']['error']==0){
        $move=@move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . basename($_FILES['file']['name']));
        if (!$move) {
            $qerors++;
            ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    ShowHideDiv('file')
                });
            </script>
            <?php
            $file_text_eror='Ошибка загрузки файла';
        }
    }
    //проверим на существование логина
    $loginsql=$mysqli->prepare("SELECT `ID` FROM `users` WHERE `login` LIKE ? ");
    $loginsql->bind_param("s", $user_name);
    $loginsql->execute();
    $loginsql->store_result();
    $login_row=$loginsql->num_rows;
    if ($login_row!=0){
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('rezalt')
                ClassDiv('rezalt','alert alert-danger col-md-6');
            });
        </script>
        <?php
        $rezalt.='Пользователь с логином '.$user_name.' уже существует</br>';
    }
    $loginsql->close();
    //проверим на существование mail
    $mailsql=$mysqli->prepare("SELECT `ID` FROM `users` WHERE `mail` LIKE ? ");
    $mailsql->bind_param("s", $email);
    $mailsql->execute();
    $mailsql->store_result();
    $mail_row=$mailsql->num_rows;
    if ($mail_row!=0){
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                ShowHideDiv('rezalt')
                ClassDiv('rezalt','alert alert-danger col-md-6');
            });
        </script>
        <?php
        $rezalt.='Пользователь с email '.$email.' уже существует</br>';
    }
    $mailsql->close();
    if ($login_row==0&&$mail_row==0&&$qerors==0)
    {
        $sql_ins=$mysqli->prepare("INSERT INTO `users`(`login`, `name`, `mail`, `message`,`date_reg`) VALUES (?,?,?,?,now())");
        $sql_ins->bind_param('ssss', $user_name,$name,$email,$text);
        $sql_ins->execute();
        if($sql_ins->errno==0){
            ?>
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
        $sql_ins->close();
    }
}

?>
    <form method="post" enctype="multipart/form-data" class="form-horizontal" xmlns="http://www.w3.org/1999/html">
        <div class="form-group">
            <label class="col-md-3 control-label">Логин</br> (От 6 до 20 латинских символов)</label>
            <div class="col-md-9">
                <input minlength="6" maxlength="20" class="form-control" type="text" name="user_name" value="<?=@$user_name?>" required>
            </div>
        </div>
        <div class="row " id='user_name' style="display: none;">
            <div class="alert alert-danger col-md-9 col-md-offset-3 "><?=@$user_name_text_eror?></div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Ваше имя</label>
            <div class="col-md-9">
                <input class="form-control" type="text" name="name" value="<?=@$name?>" required>
            </div>
        </div>
        <div class="row "  id='name' style="display: none;">
            <div class="alert alert-danger col-md-9 col-md-offset-3 "><?=@$name_text_eror?></div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Ваш email</label>
            <div class="col-md-9">
                <input class="form-control" type="email" name="email" value="<?=@$email?>" required>
            </div>
        </div>
        <div class="row " id='email' style="display: none;">
            <div class="alert alert-danger col-md-9 col-md-offset-3 "><?=@$email_text_eror?></div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">О себе (От 20 до 250 символов)</label>
            <div class="col-md-9">
                <textarea maxlength="250" minlength="20" class="form-control" name="text" required> <?=@$text?></textarea>
            </div>
        </div>
        <div class="row " id='text' style="display: none;">
            <div class="alert alert-danger col-md-9 col-md-offset-3 "><?=@$text_text_eror?></div>
        </div>
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
    <div class="row ">
        <div class="col-md-3"></div>
        <div id="rezalt" style="display: none;">
            <?=@$rezalt?>
        </div>
        <div class="col-md-3"></div>
    </div>
<?php include_once('futer.php');?>