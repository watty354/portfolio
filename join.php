<?php 

session_start();
require('dbconnect.php');


if(!empty($_POST)) {

if($_POST['name'] === ''){
  $error['name'] = 'blank';
}
if($_POST['email'] === ''){
  $error['email'] = 'blank';
}
if(strlen ($_POST['password'])< 4){
  $error['password'] = 'length';
  }
if($_POST['password'] === ''){
  $error['password'] = 'blank';
}


$fileName = $_FILES['image']['name'];
if(!empty($fileName)) {
$ext = substr($fileName, -3);
//写真のタイプを選定し、エラーを作る//
if($ext != 'jpg' && $ext !='gif' && $ext!='jpeg') {
$error['image'] = 'type';
} 
}


if(empty($error) ) {
  $member = $db-> prepare('SELECT COUNT(*) AS cnt FROM login_member WHERE email=?');
  $member ->execute(array($_POST['email']));
  $record = $member->fetch();
  if($record['cnt'] > 0) {
    $error['email'] = 'duplicate';
  }
  }


if(empty($error)){
  $image = date('YmdHis') . $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], './member_picture/' . $image);
  $_SESSION['join'] = $_POST;
  $_SESSION['join']['image'] = $image;
  header('Location:check.php');
  exit();
}
}

if ($_REQUEST['action']=== 'rewrite'  && isset($_SESSION['join'])) {
	$_POST = $_SESSION['join'];
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
        
  
        <form action="" method="post" class="mx-5" enctype="multipart/form-data">
  
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">ニックネーム</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" value="<?php print (htmlspecialchars($_POST['name'],ENT_QUOTES));?>">
            <?php if ($error['name']==='blank'):?>
              <p class="error">ニックネームを入力してください</p>
            <?php endif ;?>
          </div>
  
  
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">メールアドレス</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?php print (htmlspecialchars($_POST['email'],ENT_QUOTES));?>">
            <?php if ($error['email']==='blank'):?>
              <p class="error">メールアドレスを入力してください</p>
            <?php endif ;?>
            <?php if ($error['email'] === 'duplicate'):?>
              <p class="error">アカウントあるよ</p>
            <?php endif ;?>


          </div>
  
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">パスワード</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="<?php print (htmlspecialchars($_POST['password'],ENT_QUOTES));?>">
            <?php if ($error['password']==='blank'):?>
              <p class="error">パスワードを入力してください</p>
            <?php endif ;?>
            <?php if ($error['password'] === 'length'):?>
              <p class="error">パスワードは4文字以上入力してください</p>
            <?php endif ;?>
  
  
  
          </div>
  
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">プロフィール画像</label>
            <input type="file"  id="exampleInputPassword1" name="image">
           <?php if($error['image'] === 'type'):?>
  <p class="error">写真の種類を変えてください</p>
  <?php endif;?>
          </div>
  
          <div><input type="submit" class="btn btn-primary" value="入力内容を確認する" /></div>
  
        </form>
  
      </div>
    </section>
  
  
  </div>
  
  
</body>
</html>