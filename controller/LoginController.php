<?php
require_once('../model/Login.php');
$login = new Login();
$login->run();
// $inputValue = $login->getValues();
$error = $login->getErrors('login');

require_once('../view/login.php');
?>