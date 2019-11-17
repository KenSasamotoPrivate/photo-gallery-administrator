<?php
if($_SERVER['REQUEST_METHOD']==='GET'){
    header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php'); 
    exit;
}

require_once('../service/PostImageService.php');
require_once('../service/GetImageService.php');

$PostImageService = new PostImageService();
$PostImageService->postProcess();
$fileError = $PostImageService->getErrors(fileError);
$titleError = $PostImageService->getErrors(titleError);
$titleValue = $PostImageService->getValues(titleValue);

$GetImages = new GetImageService();
$records = $GetImages->findAll();

require_once('../view/index.php');

?>