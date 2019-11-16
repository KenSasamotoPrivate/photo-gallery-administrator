<?php
//called by delete.js
//require_once('../config.php');
require_once('../service/DeleteImageService.php');

if($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php');          
  exit;
}

$DeleteImageService = new DeleteImageService();
$DeleteImageService->delete();

?>