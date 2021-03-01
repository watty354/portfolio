<?php 
try {

  $db = new PDO('mysql:dbname=portfolio;host=localhost;charset=utf8;port=3307', 'root' , 'root');
} catch(PDOException $e) {
  print('DB接続エラー：' .$e ->getMessage());
}

