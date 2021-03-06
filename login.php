<?php
require('dbconnect.php');
session_start();

if ($_COOKIE['email']  !='' ) {
  $email = $_COOKIE['email'];
}

if (!empty($_POST)) {
  $email = $_POST['email'];


  if ($_POST['email']  != '' && $_POST['password']  !== '') {
    $login = $db->prepare('SELECT * FROM login_member WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])
    ));

    $member = $login->fetch();

    if ($member) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      if ($_POST['save'] ==='on') {
        setcookie('email' , $_POST['email'],time()+60*60*24*14);
      }
      
      header('Location: index.php');
      exit();
    } else {
      $error['login'] = 'failed';
    }
  } else {
  $error['login'] = 'blank';
}
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
<div class="container mt-5">
  <section class="top py-5">
    <div class="container py-5">
      <h1 class="text-center display-3 font-weight-bold">会員登録</h1>



      <form action="" method="post" class="mx-5">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">メールアドレス</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">

          <?php if ($error['login'] === 'blank') : ?>
            <p class="error">項目を入力してください</p>
          <?php endif; ?>

          <?php if ($error['login'] === 'failed') : ?>
            <p class="error">登録がないか、入力が間違っています</p>
          <?php endif; ?>




        </div>



        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">パスワード</label>
          <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </div>


        <input type="submit" value="ログインする" class="btn btn-primary" />
        <button type="submit" class="btn btn-secondary"><a href="index.php">ゲストとしてログイン</a></button>

      </form>

      <div class="my-3"><a href="join.php">新規登録はこちらから</a></div>
    </div>
  </section>


</div>


<body>

</body>

</html>