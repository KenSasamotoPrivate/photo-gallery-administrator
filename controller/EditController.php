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

$titleValue = $image->title;
$commentValue = $image->comment;

if($_SERVER['REQUEST_METHOD']==='POST'){

    $EditImageService = new EditImageService();
    $EditImageService->editProcess();

    $titleError = $EditImageService->$uploadedData->getErrors('titleError');

    $titleValue = $_POST['title'];
    $commentValue = $_POST['comment'];

    $fileError = $EditImageService->$uploadedData->getErrors('fileError');
    $commentError = $EditImageService->$uploadedData->getErrors('commentError');
}

require_once('../view/edit.php');

?>