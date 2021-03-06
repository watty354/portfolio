<?php
session_start();
require('dbconnect.php');

$id = $_POST['id'];
$message = $_POST['message'];
$reply = $_POST['reply'];

if (!empty($_POST)) {
  if ($_POST['message'] !== '') {
    $message = $db->prepare('INSERT INTO messages SET member_id=?, message=?, reply=?,created=NOW()');
    $message->execute(array(
$_POST['id'],
   $_POST['message'],
   $_POST['reply']
    ));

    $messages = $db->query('SELECT l.name, l.picture, m.* FROM login_member l, messages m WHERE l.id=m.member_id ORDER BY m.created DESC');



    header('Content-Type: application/json; charset=utf-8',);
    echo json_encode(['id' => $id, 'message' => $_POST['message'], 'reply' => $reply]);

} else {
  header('Content-Type: application/json; charset=utf-8',);

}
} 


?>
 
