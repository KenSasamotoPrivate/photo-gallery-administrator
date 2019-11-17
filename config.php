<?php
//ini_set('display_errors',1);

require_once('functions.php');
define('DSN','mysql:host=127.0.0.1;dbname=hiiragiya;charset=utf8');
define('DSN_LOGIN_TABLE', 'mysql:host=localhost;dbname=dotinstall_sns_php');
define('user','kensasamoto');
define('pass','1957');
define('post_max_size', 10 * 1024 * 1024);

$extensions = array(
    'image/png',
    'image/jpeg',
    'image/gif',
);

define('EXTENSIONS', $extensions);
session_start();
?>