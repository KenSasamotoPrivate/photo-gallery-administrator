<?php ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log In</title>
  <link rel="stylesheet" href="../resources/css/login.css">
</head>
<body>
  <div id="container">
    <form action="" method="post" id="login">
      <p>
        <!-- <input type="text" name="email" placeholder="email" value="<?php isset($loginService->getValues(email)->email) ? print h($loginService->getValues(email)->email) : print '' ?>"> -->
        <input type="text" name="email" placeholder="email">
      </p>
      <p>
        <input type="password" name="password" placeholder="password">
      </p>
      <p class="err"><?php echo h($error); ?></p> 
      <div class="login-btn" onclick="document.getElementById('login').submit();">ログイン</div>
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    </form>
  </div>
</body>
</html>