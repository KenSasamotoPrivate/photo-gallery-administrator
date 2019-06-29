<?php
require_once('WorksDataSource.php');
$WorksDataSource = new WorksDataSource();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $WorksDataSource->delete();
    
    // header('content-Type: application/json');
    // echo json_encode($status);
    exit;
}
?>