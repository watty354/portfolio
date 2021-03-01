<?php
session_start();
require('dbconnect.php');

if (empty($_REQUEST['id'])) {
  header('Location:index.php');
  exit();
}
//URLから取得したパラメータでメッセージを一件取得 

$posts = $db->prepare('SELECT l.name, l.picture, m.* FROM login_member l, messages m  WHERE  l.id=m.member_id AND m.id=?');
$posts ->execute(array($_REQUEST['id']));

if(!empty($_POST)){
  if ($_POST['rewite'] !== '') {
    $statment = $db->prepare('UPDATE messages SET message=?, modefile=NOW() WHERE id=?');
    $statment->execute(array(
      $_POST['rewite'],
      $_REQUEST['id']
    ));


    header('Location: index.php');
    exit();
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


<body>
  <div class="container rewite">
    <section class="top py-5">
      <div class="container">
        <h1 class="text-center display-3 font-weight-bold">編集</h1>
        
        <?php if($post = $posts->fetch()):?>
          <div class="item">
          <div class="item-left pt-3">
          <img class="rewite_image" src="member_picture/<?php print (htmlspecialchars($post['picture'],ENT_QUOTES));?> " alt="<?php print (htmlspecialchars($post['name'],ENT_QUOTES));?>"/>
          </div>
          <div class="item-right m-lg-3">
          <p><?php print (htmlspecialchars($post['name'],ENT_QUOTES));?></p>
          <form action="rewite.php?id=<?php print(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)); ?>" method="post">
<textarea name="rewite" cols="120" rows="10"><?php print (htmlspecialchars($post['message'],ENT_QUOTES));?></textarea>
<div><input type="submit" class="btn btn-primary" value=編集確定 /></div>
</form>
          <?php endif;?>
          
          
          
        </div>
  
  
        
        
        
      </section>
      <div class="btn btn-secondary mt-3"><a href="index.php">&laquo;&nbsp;ホームに戻る</a> </div>
      
      
  </div>
  
</body>
</html>