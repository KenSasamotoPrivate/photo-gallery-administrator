<?php
require_once('../model/Model.php');
require_once('../model/EditWorks.php');

if(!isset($_GET["id"])){
    header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php'); 
    exit;
}

$EditWorks = new EditWorks;

$work = $EditWorks->editProcess();

$titleError = $EditWorks->getErrors('titleError');
$titleError === '' ? $titleValue = $work['title'] : $titleValue = '';

require_once('../view/edit.php');

?>