<?php
require_once('../config.php');
require_once('GetImageService.php');


if(isset($_GET["id"]) && $_GET["id"] !== ""){
    $id = $_GET["id"];
}
else{
    header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php');          
    exit;
}

$GetImageService = new GetImageService();

$image = $GetImageService->findById($_GET['id']);


header("Content-Type: ".$image->extension);
echo ($image->raw_data);

?>