<?php
require_once('../config.php');
// session_start();
if(!isset($_SESSION['me']) || empty($_SESSION['me'])){
  header('Location: http://' . $_SERVER['HTTP_HOST'].'/login.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../resources/css/style.css">
  <link rel="stylesheet" href="../resources/css/edit.css">
  <title>管理画面 | 編集完了</title>
</head>
<body id="complete">
  <div>
    <p>編集が完了しました。</p>
    <a href="../controller/IndexController.php">TOPに戻る</a>
  </div>
</body>
</html>