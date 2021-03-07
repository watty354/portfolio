<?php
require('dbconnect.php');
session_start();

if(!isset ($_SESSION['join'])) {
	header('Location: index.php');
	exit();
}

if(!empty($_POST)) {
	$statement= $db->prepare('INSERT INTO login_member SET name=?, email=?, password=?, picture=?, created=NOW()');
$statement -> execute(array(
$_SESSION['join']['name'],
$_SESSION['join']['email'],
// 暗号化
sha1($_SESSION['join']['password']),
$_SESSION['join']['image'],
));
// 終わったら削除
unset ($_SESSION['join']);


header('Location: thanks.php');
exit();

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
  <div class="container">
    <section class="top py-5">
      <div class="container py-5">
        <h1 class="text-center display-3 font-weight-bold">新規登録</h1>
        
  
        <form action="" method="post" class="mx-5">
        <input type="hidden" name="action" value="submit" />
  
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">ニックネーム</label>
            <?php print (htmlspecialchars($_SESSION['join']['name'],ENT_QUOTES));?>        </div>
  
  
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">メールアドレス</label>
            <?php print (htmlspecialchars($_SESSION['join']['email'],ENT_QUOTES));?>
          </div>
  
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">パスワードは表示されません</label>
  
          </div>
  
          <div class="mb-3 check">
            <label for="exampleInputPassword1" class="form-label">プロフィール画像</label>
           <?php if($_SESSION['join']['image'] !==''):?>
          <img src="./member_picture/<?php print (htmlspecialchars($_SESSION['join']['image'],ENT_QUOTES));?>" style="width:70px;height: 70px;object-fit: cover;border-radius: 50px;">
              <?php endif ;?>
          </div>
  
          
          <div class="btn btn-success rewited mb-3"><a href="join.php?action=rewrite" style="color: #fff;  text-decoration: none;">&laquo;&nbsp;編集する</a> </div>
          <div><input type="submit" class="btn btn-primary" value=ログインする /></div>
  
        </form>
  
      </div>
    </section>
  
  
  </div>
  
</body>
</html>