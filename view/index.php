<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../resources/css/style.css">
  <script src="/resources/js/ofi.min.js"></script>
  <title>管理画面</title>
</head>
<body id="main">
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
        <label class="require" for="file">画像</label>
        <input type="file" name="upfile">
        <p class="upload-notice">※png, jpeg, gif形式に対応（5MB以下推奨)<span class="<?php $fileError !== '' ? print 'error' : print ''?>"><?php echo h($fileError);?></span></p>        
          
      </div>
      
      <div class="input-label-wrap clearfix p-relative">
        <img id="preview">
        <p class="preview-comment"></p>
        <label  class="require" for="title">タイトル ※40文字まで</label>
        <input id="title" type="text" name="title" value="<?php echo h($titleValue);?>">
        <span class="error"><?php echo h($titleError);?></span>
        <label for="comment">コメント（任意）※100文字まで</label>
        <textarea name="comment" id="comment" cols="30" rows="5"><?php echo h($commentValue);?></textarea>
        <span class="error"><?php echo h($commentError);?></span>
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
          echo "<img src='../service/exportImageService.php?id=$id' alt='' >";         
          echo "<br/><br/>";
        ?>
        </div>
        <ul class="item-data" data-id="<?php echo $id ?>">
          <li class="status <?php echo h($record->status); ?>"></li>
          <li>最終更新日</li>
          <li class="date"><?php echo h($record->updated_at);?></li>
          <li><b><?php echo h($record->title);?></b></li>
          <li><?php echo h($record->comment);?></li>
          <li class="delete-edit-link">
            <!-- delete ajax >> delete.js -->
            <span><a href="EditController.php?id=<?php echo $id ?>">編集</a></span>・<span><a class="deleteLink" href="">削除</a></span>
          </li>
          <li class="status-link">
            <!-- ajax >> status_change.js -->
            <span><a class="statusLink <?php echo h($record->status); ?>" href=""></a></span>
          </li>
        </ul>
      </div>
    <?php endforeach ?>
  </div>
  <div id="pagination-area">
    <?php
      if($totalNumber <= $current * 10){
        $prev_hidden="v-hidden";
      } 
      if($current == 1){
        $next_hidden="v-hidden";
      }
    ?>    
    <div class="prev-link <?php echo h($prev_hidden);?>"><a href="/controller/IndexController.php?page=<?php echo h($current + 1)?>">前の10件</a></div>
    <div class="next-link <?php echo h($next_hidden);?>"><a href="/controller/IndexController.php?page=<?php echo h($current - 1)?>">次の10件</a></div>    
  </div>
<script src="/resources/js/jquery-3.3.1.min.js"></script>
<script src="/resources/js/status_change.js"></script>
<script src="/resources/js/delete.js"></script>
<script src="/resources/js/drag.js"></script>
<script>
  objectFitImages();
</script>
</body>
</html>