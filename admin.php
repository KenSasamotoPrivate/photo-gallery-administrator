<?php
require_once('model/PostWorks.php');
require_once('model/State.php');
require_once('model/DeleteWorks.php');

require_once('model/GetWorks.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
  if($_POST['mode'] === 'change-status'){
    $State = new State();
  
    $status =  $State->stateUpdate();
      
    header('content-Type: application/json');
    echo json_encode($status);
    exit;
  }
  
  if($_POST['mode'] === 'delete'){
    $DeleteWorks = new DeleteWorks();
    $DeleteWorks->delete();
    exit;
  }

  $PostWorks = new PostWorks();
  $PostWorks->postProcess();

}

$GetWorks = new GetWorks();
$records = $GetWorks->findAll();

$fileError = $GetWorks->getErrors(fileError);
$titleError = $GetWorks->getErrors(titleError);


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="admin.css">
  <title>管理画面</title>
</head>
<body>
  <header>
    <p>管理画面</p>
  </header>
  <form action="logout.php" method="post" id="logout-form">    
    <button type="submit" class="logout-btn">
      <span>ログアウト</span>
      <a class="site-link" href="https://hiiragi-ya.net/" target="_blank">サイトを見る</a>
    </button>    
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </form>
  <div class="post-area">
    <p class="desc">作品を新規追加する</p>
    <form action="admin.php" enctype="multipart/form-data" method="post">
      <div class="input-label-wrap">
        <label for="file">画像</label>
        <input type="file" name="upfile">
        <p class="upload-notice">5MB以下推奨&nbsp;<span class="<?php $fileError !== '' ? print 'error' : print ''?>"><?php echo h($fileError);?></span></p>
      </div>
      
      <div class="input-label-wrap">
        <label for="title">作品名</label>
        <input id="title" type="text" name="title" value="<?php echo h($GetWorks->getValues(titleValue));?>">
        <p class="<?php $titleError !== '' ? print 'error' : print ''?>"><?php echo h($titleError);?></p>
      </div>
      
      <div class="btn-wrap">
        <button type="submit">追加して公開</button>
      </div>
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </form>
  </div>
  <div class="items-wrap">
    <!--  each loop-->
    <?php foreach($records as $record): ?>
      <?php $id = h($record["id"]); ?>
      <div class="item clearfix" data-id="<?php echo $id ?>">
        <div class="img-wrap">
        <?php 
          //<img src="images/thumbnail/work_10_thumbnail.jpg" alt="" width="220px" height="auto">
          
          if($record["extension"] == "mp4"){
              echo "<video src=\"import_media.php?id=$id\" width=\"426\" height=\"240\" controls></video>";
          }
          elseif($record["extension"] == "jpeg" || $record["extension"] == "png" || $record["extension"] == "gif"){
              echo "<img src='import_media.php?id=$id' alt='' width='220px' height='auto'>";
          }
          echo "<br/><br/>";
        ?>
        </div>
        <ul class="item-data" data-id="<?php echo $id ?>">
          <li class="status <?php echo h($record["status"]); ?>"></li>
          <li>最終更新日</li>
          <li class="date"><?php echo h($record["updated_at"]);?></li>
          <li><b><?php echo h($record["title"]);?></b></li>
          <li class="delete-edit-link"><span><a href="edit.php?id=<?php echo $id ?>">編集</a></span>・<span><a class="deleteLink" href="">削除</a></span></li>
          <li class="status-link"><span><a class="statusLink <?php echo h($record["status"]); ?>" href=""></a></span></li>
        </ul>
      </div>
    <?php endforeach ?>
  </div>
<script src="jquery-3.3.1.min.js"></script>
<script src="update-delete.js"></script>
</body>
</html>