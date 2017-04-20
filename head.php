<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 18.04.2017
 * Time: 12:39
 */
error_reporting(E_ALL);
ob_start();
$mysqli = @new mysqli("localhost", "root", "", "itua");
// Если нет подключения к базе прекращаем работу
if (mysqli_connect_errno()) {
    echo '<h1>Ошибка подключения к БД</h1>', mysqli_connect_error();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!--Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script language="JavaScript" type="text/JavaScript">
        function ShowHideDiv(id) {
            if (document.getElementById(id).style.display == "none") {
                document.getElementById(id).style.display = "block"
            }
            else {
                document.getElementById(id).style.display = "none"
            }
        }
        function ClassDiv(id,cl) {
            document.getElementById(id).setAttribute("class", cl);
        }
        function getrez() {
            StartDate=$("#StartDate").val();
            EndDate=$("#EndDate").val();
            Sort = $("#myselect").val();
            Sort='ORDER BY `date_reg` ' +Sort;
            $.ajax({
                type:"POST",
                url:"user data.php",
                data: {"StartDate":StartDate, "EndDate":EndDate,"Sort":Sort},
                success: function(responce){
                    $('div#result_div').html(responce);
                }
            })
        }
        $( function() {
            $( "#StartDate" ).datepicker({dateFormat:'yy-mm-dd'});
        } );
        $( function() {
            $( "#EndDate" ).datepicker({dateFormat:'yy-mm-dd'});
        } );
        window.onload = function () {
            getrez();
        }
    </script>

</head>
<body>
<nav>
    <ul class="nav nav-pills nav-justified">
        <li><a href="/"><H3>Главная</H3></a></li>
        <li><a href="/users.php"><H3>Users</H3></a></li>
    </ul>
</nav>
<div class="container">

