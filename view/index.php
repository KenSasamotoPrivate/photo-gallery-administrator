<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/admin.css">
  <title>管理画面</title>
</head>
<body>
  <header>
    <p>管理画面</p>
  </header>
  <form action="LogoutController.php" method="post" id="logout-form">    
    <button type="submit" class="logout-btn">
      <span>ログアウト</span>
      <a class="site-link" href="https://hiiragi-ya.net/" target="_blank">サイトを見る</a>
    </button>    
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </form>
  <div class="post-area">
    <p class="desc">作品を新規追加する</p>
    <form action="PostController.php" enctype="multipart/form-data" method="post">
      <div class="input-label-wrap">
        <label for="file">画像</label>
        <input type="file" name="upfile">
        <p class="upload-notice">5MB以下推奨&nbsp;<span class="<?php $fileError !== '' ? print 'error' : print ''?>"><?php echo h($fileError);?></span></p>
      </div>
      
      <div class="input-label-wrap">
        <label for="title">作品名</label>
        <input id="title" type="text" name="title" value="<?php echo h($titleValue);?>">
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
      <?php $id = h($record->id); ?>
      <div class="item clearfix" data-id="<?php echo $id ?>">
        <div class="img-wrap">
        <?php 
          // if($record["extension"] == 'image/jpeg' || $record["extension"] == 'image/png' || $record["extension"] == 'image/gif'){
          //     echo "<img src='../import_media.php?id=$id' alt='' width='220px' height='auto'>";
          // } else {            
          //   echo "<img src='' alt='画像を表示出来ません' style='min-width : 220px; min-height: 220px; border: 1px solid;'>";
          // }
          //echo "<img src='../import_media.php?id=$id' alt='' width='220px' height='auto'>";

          echo "<img src='../service/exportImageService.php?id=$id' alt='' width='220px' height='auto'>";          
          echo "<br/><br/>";
        ?>
        </div>
        <ul class="item-data" data-id="<?php echo $id ?>">
          <li class="status <?php echo h($record->status); ?>"></li>
          <li>最終更新日</li>
          <li class="date"><?php echo h($record->updated_at);?></li>
          <li><b><?php echo h($record->title);?></b></li>
          <li class="delete-edit-link">
            <!-- delete >> update-delete.js -->
            <span><a href="EditController.php?id=<?php echo $id ?>">編集</a></span>・<span><a class="deleteLink" href="">削除</a></span>
          </li>
          <li class="status-link">
            <!-- 公開設定 >> update-delete.js -->
            <span><a class="statusLink <?php echo h($record->status); ?>" href=""></a></span>
          </li>
        </ul>
      </div>
    <?php endforeach ?>
  </div>
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/status_change.js"></script>
<script src="/js/delete.js"></script>
</body>
</html>