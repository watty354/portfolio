<?php
require('dbconnect.php');
session_start();

if(!empty($_POST)) {
$forget= $db->prepare('SELECT * FROM login_member WHERE email=?');
$forget ->execute(array(
  $_POST['email'],
));
$user = $forget->fetch();

if(empty($user)) {
  $error['login'] = 'none';
}

// メール送信

header('Location:mail_send.php');
exit;


}




?>



<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <title>ポートフォリオ</title>
    
  </head>
  <body>
  <div class="container mt-5">
    <section class="top py-5">
    <div class="container py-5">
      <h1 class="text-center display-3 font-weight-bold">パスワードリセット</h1>
      <p class="text-center">ご入力されたメールのURLをクリックして、パスワードの再設定をお願いします。</p>

      <form action="" method="POST" class="mx-5">

        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">メールアドレス</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
          <?php if($error['login'] === 'none'):?>
<p class="error">ご登録のアカウントはありません</p>

            <?php endif;?>
        </div>

        
        <input type="submit" value="ログインする" class="btn btn-primary" />

      </form>

    </div>
  </section>


</div>


  
</body>
</html>