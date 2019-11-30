<!-- Include by EditController.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../resources/css/style.css">
  <link rel="stylesheet" href="../resources/css/edit.css">
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
        <li class="description">※全て、もしくは必要な項目のみ変更出来ます。</li>
        <li>
          <label for="file">画像</label>
          <input id="file" type="file" name="upfile">
          <p class="upload-notice">
            ※png, jpeg, gif形式に対応（5MB以下推奨)
            <span class="error"><?php echo h($fileError);?></span>
          </p>
        </li>                 
        <li>
          <label for="title">新しいタイトル ※40文字まで</label>
          <input id="title" type="text" name="title" value="<?php echo h($titleValue)?>">
          <p class="error"><?php echo h($titleError); ?></p>
          <label for="comment">コメント（任意）※100文字まで</label>
          <textarea name="comment" id="comment" cols="30" rows="5"><?php echo h($commentValue);?></textarea>
          <span class="error"><?php echo h($commentError);?></span>
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