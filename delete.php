<?php
session_start();
require('dbconnect.php');



if(isset($_SESSION['id'])) {
  $id = $_REQUEST['id'];

  $message = $db->prepare('SELECT * FROM messages WHERE id=?');
  $message ->execute(array($id));
  $message = $message->fetch();

  if($message['member_id'] == $_SESSION['id']) {
    $del = $db->prepare('DELETE FROM messages WHERE id=?');
    $del ->execute(array($id));
  }
}

header('Location: index.php');
exit();
?>