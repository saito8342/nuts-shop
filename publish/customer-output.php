<?php session_start(); 
   //既存ユーザーの情報変更
 require '../header.php'; 
 require 'menu.php'; 
 require '../connect.php'; 

 //var_dimp($sql->fetch()['count(*)']);
 //exit;

if(isset($_SESSION['customer'])) {
      //ログインしてるか
    $id=$_SESSION['customer']['id'];

    if($_REQUEST['login'] != $_SESSION['customer']['login']){
          //ログイン名を変更しようとしてる
          $sql = $pdo->prepare(
                 'SELECT count(*) from customer
                 WHERE login = ?
                 AND id != ? ' //自分のIDではない
             );
          //自分のidと一致しない,かつログイン名が一致する行
          $sql->execute([ $_REQUEST['login'],  $_SESSION['customer']['id'] ]);
           if( $sql->fetch()['count(*)'] > 0 ){
                 echo "ログイン名が使われてるので戻って入れ直してください。";
                 exit;
           }    
      }

} elseif( [$_REQUEST['login'] != $_SESSION['customer']['login'] ] ) {
       //メールを変更しようとしてる
       $sql = $pdo->prepare(
            'SELECT count(*) from customer 
            WHERE email = ?
            AND id != ? ' //自分のidではない
      );
      // 
      $sql->execute([ $_REQUEST['email'],  $_SESSION['customer']['id'] ]);

      if( $sql->fetch()['count(*)'] > 0 ){
            echo "そのメールアドレスは使われてます";
            exit; // 中断
      }
}
$sql=$pdo->prepare(
      '	UPDATE customer set 
                        name=?,
                        postcode=?, 
                        address=? ,
                        login=?, 
                        email=?,
                        password=? 
            WHERE id=?');

 /* $id=$_SESSION['customer']['id'];
  $sql=$pdo->prepare(
          'select * from customer 
           where id!=? 
          and login=?');
*/
  //$sql->execute([$id,$_REQUEST['login']]);

//}else {
      //ログインしてない場合
  /*$sql=$pdo->prepare('
  select count(*) from customer
  where login=?');
  $sql->execute([$_REQUEST['login']]);
} 同じログイン名があるかないか(重複不許可のため)
*/
//var_dump( isset($_SESSION['customer']) ), ( empty($sql->fetchAll()) );//exit;        //←追記
//var_dump($sql->fetch()['count(*)']);
//exit;
/*
if ( $sql->fetch()['count(*)'] == 0 ) {
      //ログインしてるユーザーなら1件がかならずある
// 作ろうとしてる(変更しようとしてる)ログイン名がない場合
  if (isset($_SESSION['customer'])) {
$id = $_SESSION['customer']['id'];
      $sql=$pdo->prepare(
      ' UPDATE customer set 
              name=?, 
              postcode=?,
              address=? ,
              email=?, 
              login=?, 
              password=? 
      WHERE id=?');
  
*/
// 既存顧客情報の上書き
      $sql->execute([   // ?の数だけ書く
            $_REQUEST['name'],
            $_REQUEST['postcode'],
            $_REQUEST['address'],
            $_REQUEST['email'], //変更があってもなくても上書きする
            $_REQUEST['login'], //          ``
            $_REQUEST['password'],
            $id]
           );
//ログインセッションに値を代入
      $_SESSION['customer']=[
            'id'=>$id, //配列全体が上書きされるのでいれる
            'name'=>$_REQUEST['name'],
            'postcode'=>$_REQUEST['postcode'],
            'address'=>$_REQUEST['address'],
            'email'=>$_REQUEST['email'],
            'login'=>$_REQUEST['login'],
            'password'=>$_REQUEST['password']
         ];
      echo 'お客様情報を更新しました。';
           //既存ユーザーの処理は終わり

      
?>

<?php require '../footer.php'; ?>
