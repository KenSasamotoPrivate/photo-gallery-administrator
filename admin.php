<?php

require_once('model/PostWorks.php');
require_once('model/State.php');
require_once('model/DeleteWorks.php');

require_once('model/GetWorks.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

  $mode = $_POST['mode'];

  switch($mode){

    case 'change-status':
      $State = new State();

      $status =  $State->stateUpdate();

      header('content-Type: application/json');
      //return to update-delete.js line 14
      echo json_encode($status);
      exit;
      //break;

    case 'delete':

      $DeleteWorks = new DeleteWorks();
      $DeleteWorks->delete();
      break;
      exit;
  }

  $PostWorks = new PostWorks();
  $PostWorks->postProcess();
  $fileError = $PostWorks->getErrors(fileError);
  $titleError = $PostWorks->getErrors(titleError);
  $titleValue = $PostWorks->getValues(titleValue);

}

$GetWorks = new GetWorks();
$records = $GetWorks->findAll();

require_once('view/index.php');

?>