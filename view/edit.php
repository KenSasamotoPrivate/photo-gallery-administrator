<!-- Include by EditController.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../resources/css/admin.css">
  <title>管理画面 | 編集</title>
</head>
<body>

  <form action="" enctype="multipart/form-data" class="edit-form" method="post">
    <div class="edit-target">
      <div class="img-wrap">
        <?php $id = h($image->id); ?>
        <p>現在の画像</p>
        <?php         
        echo "<img src='../service/exportImageService.php?id=$id' alt='' width='220px' height='auto'>";
        echo "<br/><br/>";
        ?>
      </div>
      <ul class="item-data">
        <?php $image->status === 'public' ? $status="公開中" : $status="非公開" ?>
        <li><?php echo  $status;?></li>
        <li>更新日時</li>
        <li class="date"><?php echo h($image->updated_at);?></li>
        <li class="description">※画像を選択しない場合、タイトルのみ変更されます。</li>
        <li>
          <input id="file" type="file" name="upfile">
          <span class="file-error-msg"><?php echo h($fileError);?></span>
        </li>                 
        <li>
          <label for="title" class="<?php $titleError !== '' && $titleError !== NULL ? print 'error' : print ''?>">タイトルを入力してください</label>
          <input id="title" type="text" name="title" value="<?php echo h($titleValue)?>">
        </li>
      </ul>
    </div>
    <div class="btn-wrap">
      <button type="submit">上書きする</button>
      <div><a href="IndexController.php">キャンセルして戻る</a></div>
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
      <input type="hidden" name="mode" value="edit">
    </div>
  </form>
</body>
</html>