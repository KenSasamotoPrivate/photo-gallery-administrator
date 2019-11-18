<?php
//called by status_change.js
require_once('../config.php');
require_once('../service/PublishingSettingsService.php');

if($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php');          
  exit;
}

$PublishingSettingsService = new PublishingSettingsService();

$status =  $PublishingSettingsService->stateUpdate();

header('content-Type: application/json');
echo json_encode($status);

?>