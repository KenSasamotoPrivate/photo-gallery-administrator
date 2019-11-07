<?php
require_once('../model/Model.php');
require_once('../model/EditWorks.php');


$EditWorks = new EditWorks;

$work = $EditWorks->editProcess();

// var_dump('edit');
// exit;

$titleError = $EditWorks->getErrors('titleError');
$titleError === '' ? $titleValue = $work['title'] : $titleValue = '';

require_once('../view/edit.php');

?>