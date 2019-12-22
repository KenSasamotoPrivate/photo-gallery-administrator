<?php
if($_SERVER['REQUEST_METHOD']==='GET'){
    header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php'); 
    exit;
}
require_once('../config.php');
require_once('../service/PostImageService.php');
require_once('../service/GetImageService.php');

$PostImageService = new PostImageService();
$PostImageService->postProcess();

$fileError = $PostImageService->$uploadedData->getErrors('fileError');
$titleError = $PostImageService->$uploadedData->getErrors('titleError');
$commentError = $PostImageService->$uploadedData->getErrors('commentError');

$titleValue = $PostImageService->$uploadedData->getValues('titleValue');
$commentValue = $PostImageService->$uploadedData->getValues('commentValue');

$GetImages = new GetImageService();
$records = $GetImages->findAll(1);

require_once('../view/index.php');

?>