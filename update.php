<?php
require_once('WorksDataSource.php');
$WorksDataSource = new WorksDataSource();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $status =  $WorksDataSource->stateUpdate();
    
    //改行コードはダブルクォートで
    //echo 'post id is '.$_POST['id']."\n";
    
    header('content-Type: application/json');
    echo json_encode($status);
    exit;
}
?>