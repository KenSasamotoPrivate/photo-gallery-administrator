<?php
require_once('../config.php');
require_once('../service/GetImageService.php');
require_once('../service/EditImageService.php');

if(!isset($_GET["id"])){
    header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php'); 
    exit;
}

$GetImageService = new GetImageService();

$image = $GetImageService->findById($_GET['id']);
$titleValue = $image['title'];

if($_SERVER['REQUEST_METHOD']==='POST'){
    // echo 'BEFORE NEW';
    // exit;
    $EditImageService = new EditImageService();
    $EditImageService->editProcess();

    $titleError = $EditImageService->$uploadedData->getErrors('titleError');

    //$titleValue = $titleError === '' ? $image['title'] : '';
    $titleValue = $_POST['title'];

    $fileError = $EditImageService->$uploadedData->getErrors('fileError');
}

require_once('../view/edit.php');

?>