<?php
require_once('../service/GetImageService.php');

$GetImages = new GetImageService();
$records = $GetImages->findAll();

require_once('../view/index.php');

?>