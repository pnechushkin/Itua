<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 18.04.2017
 * Time: 12:39
 */
include_once('head.php');
?>
    <div class="row">
        <div class="col-md-4">StartDate: <input onchange="getrez()" type="text" id="StartDate" value="<?=date("Y-m-d",strtotime(date('Y-m-d'))-86400)?>"></div>
        <div class="col-md-4">EndDate: <input onchange="getrez()"type="text" id="EndDate" value="<?=date('Y-m-d')?>"></div>
        <div class="col-md-4"><select id="myselect"onchange="getrez()">
                <option  value="ASC">По возростанию</option>
                <option  value="DESC">По убыванию</option>
            </select>
        </div>
    </div>
    <div id="result_div">
    </div>
<?php include_once('futer.php');?>