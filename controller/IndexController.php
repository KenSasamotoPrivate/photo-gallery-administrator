<?php
require_once('../config.php');
//require_once('../model/Model.php');
require_once('../service/PostImageService.php');
require_once('../service/PublishingSettingsService.php');
require_once('../service/DeleteImageService.php');
require_once('../service/GetImageService.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

  $mode = $_POST['mode'];

  switch($mode){

    case 'change-status':
      $PublishingSettingsService = new PublishingSettingsService();

      $status =  $PublishingSettingsService->stateUpdate();

      header('content-Type: application/json');
      echo json_encode($status);
      exit;
      //break;

    case 'delete':
      
      $DeleteImageService = new DeleteImageService();
      $DeleteImageService->delete();

      break;
      exit;
  }

  $PostImageService = new PostImageService();
  $PostImageService->postProcess();
  $fileError = $PostImageService->getErrors(fileError);
  $titleError = $PostImageService->getErrors(titleError);
  $titleValue = $PostImageService->getValues(titleValue);

}

$GetImages = new GetImageService();
$records = $GetImages->findAll();

require_once('../view/index.php');

?>