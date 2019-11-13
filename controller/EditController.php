<?php
require_once('../config.php');
require_once('../service/GetImageService.php');
require_once('../service/EditImageService.php');

if(!isset($_GET["id"])){
    header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php'); 
    exit;
}

$GetImageService = new GetImageService();

$image = $GetImageService->findById();
$titleValue = $image['title'];

if($_SERVER['REQUEST_METHOD']==='POST'){
    
    $EditImageService = new EditImageService();
    $EditImageService->editProcess();

    $titleError = $EditImageService->getErrors('titleError');
    $titleValue = $titleError === '' ? $image['title'] : '';
}

require_once('../view/edit.php');

?>