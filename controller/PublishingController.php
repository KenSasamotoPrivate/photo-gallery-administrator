<?php
//called by status_change.js
require_once('../config.php');
require_once('../service/PublishingSettingsService.php');
/*
$status = 'private';
$sql = "UPDATE media SET status = '$status' WHERE id = :id";
//$status = 'private';
var_dump($sql);
exit;
*/

if($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php');          
  exit;
}

$PublishingSettingsService = new PublishingSettingsService();
//$PublishingSettingsService->statusUpdate();
$status =  $PublishingSettingsService->statusUpdate();

header('content-Type: application/json');
echo json_encode($status);

?>