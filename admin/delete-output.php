<?php require '../header.php';?>

<?php
  require '../connect.php';

$sql = $pdo->prepare(
    "SELECT count(*)
     FROM  `favorite`
     WHERE `product_id` =?"
  );
$sql->execute( [$_REQUEST['id']] );

$count1=$sql->fetch();
  // var_dump( $count, empty ($sql));

 //foreach( $sql as $k => $val);
  //var_dump( $val, empty($val));
$sql=$pdo->prepare(
    "SELECT count(*)
     FROM  `favorite`
     WHERE `product_id` =?"
  );

$sql->execute( [$_REQUEST['id']] ) ;
$count2=$sql->fetch();
 if(!empty($count1["count(*)"]) || !empty($count2["count(*)"] )){
    echo "あるので消せない";
   }else{
  $sql=$pdo -> prepare('delete from product where id=?');
   if($sql -> execute ([$_REQUEST['id']]) ) {
   echo '削除に成功しました。' ;
    }else{
   echo '削除に失敗しました。' ;
    }
  }
?>
<?php require '../footer.php';?>




$sql->execute( [$_REQUEST['id']]);

if(empty($count["count(*)"]) ){
    echo "あるので消せない";
  }else{

$count=$sql -> fetch();/* フェッチ関数は結果が1行しか無いときに
		                       ループせず"配列"に変換する
	                                    */
 var_dump( $count, empty ($sql));

foreach( $sql as $k => $val);
 var_dump( $val, empty($val));