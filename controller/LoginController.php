<?php
require_once('../config.php');
require_once('../service/LoginService.php');

$loginService = new LoginService();

$loginService->run();

$error = $loginService->getErrors('login');
require_once('../view/login.php');
?>