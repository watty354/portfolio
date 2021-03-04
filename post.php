<?php
session_start();
require 'dbconnect.php';

$id = $_POST['id'];
$message = $_POST['message'];
$reply = $_POST['reply'];

if (!empty($_POST)) {
    if ($_POST['message'] !== '') {
        $message = $db->prepare('INSERT INTO messages SET member_id=?, message=?, reply=?,created=NOW()');
        $message->execute(array(
            $_POST['id'],
            $_POST['message'],
            $_POST['reply'],
        ));
        header('Content-Type: application/json; charset=utf-8', );

        echo json_encode(['id' => $id, 'message' => $_POST['message'], 'reply' => $reply]);

    }
}

// $_SESSION = array();
// if (ini_set('session.use_cookies')) {
//  $params = session_get_cookie_params();
//  setcookie(session_name() . '' , time() - 42000,
//  $params['path'],$params['domain'],$params['secure'],$params['httponly']);
// }
// session_destroy();

// setcookie('email','', time()-3600);

// header('Location:index.php');
// exit();
