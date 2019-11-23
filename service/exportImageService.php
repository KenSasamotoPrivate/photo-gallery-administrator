<?php
require_once('../config.php');
require_once('GetImageService.php');

$GetImageService = new GetImageService();

if(!isset($_GET["id"]) || $_GET["id"] == ""){
    header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php');          
    exit;
}

$image = $GetImageService->findById($_GET['id']);

header("Content-Type: ".$image->extension);
echo ($image->raw_data);

?>