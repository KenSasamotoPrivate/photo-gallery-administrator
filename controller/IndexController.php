<?php
require_once('../config.php');
require_once('../service/GetImageService.php');

$GetImages = new GetImageService();

$totalNumber = $GetImages->getTotalNumber();

$totalNumber = intval($totalNumber['COUNT(title)']);

$current = $_GET['page'] == '' ? 1 : $_GET['page'];

$records = $GetImages->findAll($current);

if($totalNumber <= $current * 10){
    $prev_hidden="v-hidden";
}

if($current == 1){
    $next_hidden="v-hidden";
}

require_once('../view/index.php');
?>