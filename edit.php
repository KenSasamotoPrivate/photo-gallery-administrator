<?php
require_once('Controller.php');
require_once('controller/EditController.php');
$EditController = new EditController();
$work = $EditController->editProcess();
// var_dump($work);
// exit;
$titleError = $EditController->getErrors('titleError');
$titleError === '' ? $titleValue = $work['title'] : $titleValue = '';


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="admin.css">
  <title>管理画面 | 編集</title>
</head>
<body>

  <form action="" enctype="multipart/form-data" class="edit-form" method="post">
    <div class="edit-target">
      <div class="img-wrap">
        <?php $id = h($work['id']); ?>
        <p>現在の画像</p>
        <?php 
          //<img src="images/thumbnail/work_10_thumbnail.jpg" alt="" width="220px" height="auto">
          
          if($work["extension"] == "mp4"){
              echo "<video src=\"import_media.php?id=$id\" width=\"426\" height=\"240\" controls></video>";
          }
          elseif($work["extension"] == "jpeg" || $work["extension"] == "png" || $work["extension"] == "gif"){
              echo "<img src='import_media.php?id=$id' alt='' width='220px' height='auto'>";
          }
          echo "<br/><br/>";
        ?>
      </div>
      <ul class="item-data">
        <?php $work["status"] === 'public' ? $status="公開中" : $status="非公開" ?>
        <li><?php echo  $status;?></li>
        <li>更新日時</li>
        <li class="date"><?php echo h($work['updated_at']);?></li>
        <li><input id="file" type="file" name="upfile"></li>
         
        <li>
          <label for="title" class="<?php $titleError !== '' ? print 'error' : print ''?>">新しいタイトルを入力してください</label>
          <input id="title" type="text" name="title" value="<?php echo h($titleValue)?>">
        </li>
        <li class="description">※画像を選択しない場合、タイトルのみ変更されます。</li>
      </ul>
    </div>
    <div class="btn-wrap">
      <button type="submit">上書きする</button>
      <div><a href="admin.php">キャンセルして戻る</a></div>
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <input type="hidden" name="mode" value="edit">
    </div>
  </form>
  
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
<script src="jquery-3.3.1.min.js"></script>
<script src="update-delete.js"></script>
</body>
</html>