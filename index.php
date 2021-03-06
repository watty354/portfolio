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




$messages = $db->query('SELECT l.name, l.picture, m.* FROM login_member l, messages m WHERE l.id=m.member_id ORDER BY m.created DESC');




if ($_REQUEST['action'] === 'rewrite'  && isset($_SESSION['join'])) {
  $_POST = $_SESSION['join'];
}

if (isset($_REQUEST['res'])) {
  $response = $db->prepare('SELECT l.name, l.picture, m.* FROM login_member l, messages m WHERE l.id=m.member_id AND m.id=?');
  $response->execute(array($_REQUEST['res']));
  $table = $response->fetch();
  $message = '@' . $table['name'] . ' ' . $table['message'];
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
    <div id="return"></div>

    <div class="login">
      <button type="submit" class="btn btn-success"><a href="login.php">ログイン</a></button>
      <p>投稿するにはログインが必要です。</p>
      <button type="submit" class="btn btn-danger"><a href="logout.php">ログアウト</a></button>
    </div>





    <?php if ($member) : ?>
      <!-- modal open -->
      <a class="js-modal-open btn btn-primary mb-3" href="" data-target="modal01">投稿する</a>


      <!-- modal -->
      <div id="modal01" class="c-modal js-modal">
        <div class="c-modal_bg js-modal-close"></div>
        <div class="c-modal_content _lg">
          <div class="c-modal_content_inner">



            <form action="" method="post" class="p-1 post">
              <dl>
                <dt><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>さん、メッセージをどうぞ</dt>
                <dd>
                  <input type="hidden" name="id" id="id" value="<?php print(htmlspecialchars($member['id'], ENT_QUOTES)); ?>" />

                  <textarea name="message" cols="50" rows="5" id="message" autocomplete="on"></textarea>
                  <input type="hidden" name="reply" id="reply" value="<?php print(htmlspecialchars($_REQUEST['res'], ENT_QUOTES)); ?>" />
                </dd>
              </dl>
              <p>
                <input class="btn btn-primary js-modal-close c-modal_close" type="submit" value="投稿する" />
              </p>
            </form>
          </div>
        </div>
      </div>






    <?php endif; ?>

    <div class="mein pt-4" id="mein">

      <?php foreach ($messages as $message) : ?>
        <div class="item">
          <div class="item-left pt-3" id="item-left">
            <img src="member_picture/<?php print(htmlspecialchars($message['picture'], ENT_QUOTES)); ?>" alt="<?php print(htmlspecialchars($message['name'], ENT_QUOTES)); ?>">
          </div>

          <div class="item-right m-lg-3">
            <p><?php print(htmlspecialchars($message['name'], ENT_QUOTES)); ?></p>
            <p><?php print(htmlspecialchars($message['message'], ENT_QUOTES)); ?></p>


            <?php if ($_SESSION['id'] == $message['member_id']) : ?>
            <a href="rewite.php?id=<?php print(htmlspecialchars($message['id'])); ?>">編集</a>
              [<a href="delete.php?id=<?php print(htmlspecialchars($message['id'])); ?>">削除</a>]
            <?php endif; ?>

            <a><?php print(htmlspecialchars($message['created'], ENT_QUOTES)); ?></a>



          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>




  <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>

  <script>
    // ウィンドウを開く
    $('.js-modal-open').each(function() {
      $(this).on('click', function() {
        var target = $(this).data('target');
        var modal = document.getElementById(target);
        $(modal).fadeIn(300);

        return false;
      });
    });

    // ウィンドウを閉じる
    $('.js-modal-close').on('click', function() {
      $('.js-modal').fadeOut(300);
      return false;
    });
  </script>









  <script>
    $(function() {

      // #ajax_addがクリックされた時の処理
      $("[type=submit]").on('click', function() {


        $.ajax({
          // 送信方法
          type: "POST",
          // 送信先ファイル名
          url: "post.php",
          // 受け取りデータの種類
          datatype: "json",
          // 送信データ
          data: {
            // #nameと#priceのvalueをセット
            "id": $('#id').val(),
            "message": $('#message').val(),
            "reply": $('#reply').val()
          },
          // 通信が成功した時
          success: function(data) {

            console.log("通信成功");
            $("#mein").prepend('<div id="ajax" class="item"></div>');
            $("#ajax").prepend('<div id="item-left" class="item-left pt-3"></div>');
            $("#ajax").append('<div id="item-right" class="item-right m-lg-3"></div>');


            $("#item-left").append('<img src="member_picture/<?php print(htmlspecialchars($member['picture'], ENT_QUOTES)); ?>" alt="<?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>">');

            $("#item-right").append('<p><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?></p><p>' + data.message + ' </p> <a><p style="background-color: #0D6EFD;color: #fff;border-radius: 3px;padding: 5px;" >新規投稿しました！</p>');



            console.log(data)


          }
          
        });
      });
    });
  </script>



</body>

</html>