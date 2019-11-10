<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //debug
  // var_dump($_POST['token']);
  // echo "<br>";
  // var_dump($_SESSION['token']);
  // echo "<br>";

  if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    echo "Invalid Token!";
    exit;
  }
  
  $_SESSION = [];

  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/');
  }

  session_destroy();

}
header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/LoginController.php');

 
?>