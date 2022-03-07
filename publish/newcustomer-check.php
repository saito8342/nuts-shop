<?php session_start(); 
 require '../connect.php'; 

   $sql=$pdo->prepare('
      select count(*) from customer
      where login=?');

    $sql->execute([$_REQUEST['login']]);

    if ( $sql->fetch()['count(*)'] > 0 ) {
echo 'ログイン名がすでに使用されていますので変更してください。';
    }

