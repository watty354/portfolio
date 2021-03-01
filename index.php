<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])  && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();

  $gests = $db->prepare('SELECT * FROM login_member WHERE id=?');
  $gests->execute(array($_SESSION['id']));
  $member = $gests->fetch();
} else {
$gests = $db->prepare('SELECT * FROM login_member WHERE id=6');
$gests->execute(array($_SESSION['id']));
$gest = $gests->fetch();


}
  

if (!empty($_POST)) {
  if ($_POST['message'] !== '') {
    $message = $db->prepare('INSERT INTO messages SET member_id=?, message=?, reply=?, created=NOW()');
    $message->execute(array(
      $member['id'],
      $_POST['message'],
      $_POST['reply']

    ));
    // 再読み込みして重複しないようにするため
    header('Location: index.php');
    exit();
  }
}

$messages = $db->query('SELECT l.name, l.picture, m.* FROM login_member l, messages m WHERE l.id=m.member_id ORDER BY m.created DESC');




if ($_REQUEST['action']=== 'rewrite'  && isset($_SESSION['join'])) {
	$_POST = $_SESSION['join'];
}

if(isset($_REQUEST['res'])) {
  $response = $db->prepare('SELECT l.name, l.picture, m.* FROM login_member l, messages m WHERE l.id=m.member_id AND m.id=?');
  $response ->execute(array($_REQUEST['res'] ));
  $table = $response-> fetch();
  $message = '@' . $table['name']. ' '.$table['message'];
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
  
  
  <body>
  <div class="container mt-5 content">
      <h1 class="mb-5">みんなの掲示板</h1>


<div class="login">
    <button type="submit" class="btn btn-success"><a href="login.php">ログイン</a></button>
    <p>投稿するにはログインが必要です。</p>
    <button type="submit" class="btn btn-danger"><a href="logout.php">ログアウト</a></button>
    </div>


<?php if($member):?>
    <form action="" method="post">
      <dl>
        <dt><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>さん、メッセージをどうぞ</dt>
        <dd>
          <textarea name="message" cols="50" rows="5"><?php print(htmlspecialchars($message, ENT_QUOTES)); ?></textarea>
          <input type="hidden" name="reply" value="<?php print(htmlspecialchars($_REQUEST['res'], ENT_QUOTES)); ?>" />
        </dd>
      </dl>
      <p>
        <input type="submit" value="投稿する" />
      </p>
    </form>
<?php endif;?>
  
    <div class="mein pt-4">


      <?php foreach ($messages as $message) : ?>
        <div class="item">
          <div class="item-left pt-3">
            <img src="member_picture/<?php print(htmlspecialchars($message['picture'], ENT_QUOTES)); ?>" alt="<?php print(htmlspecialchars($message['name'], ENT_QUOTES)); ?>">
          </div>

          <div class="item-right m-lg-3">
            <p><?php print(htmlspecialchars($message['name'], ENT_QUOTES)); ?></p>
            <p><?php print(htmlspecialchars($message['message'], ENT_QUOTES)); ?></p>
            <a href="rewite.php?id=<?php print (htmlspecialchars($message['id']));?>">編集</a>


            <?php if($_SESSION['id'] == $message['member_id']):?>
[<a href="delete.php?id=<?php print (htmlspecialchars($message['id']));?>">削除</a>]
  <?php endif;?>

            <a href="view.php?id=<?php print (htmlspecialchars($message['id']));?>"><?php print(htmlspecialchars($message['created'], ENT_QUOTES));?></a>

            [<a href="index.php?res=<?php print(htmlspecialchars($message['id'],ENT_QUOTES));?>">Re</a>]
          </div>
        </div>
        <?php endforeach; ?>
    </div>
  </div>





</body>

</html>