<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php require 'menu.php'; ?>
<?php require '../connect.php'; 

$purchase_id=1;   //A_Iと同じことやってる
foreach ($pdo->query('SELECT max(id) FROM purchase') as $row) {
	$purchase_id=$row['max(id)']+1;
}
try {
	  //トランザクションの開始 (SELECTには不要)
	$pdo->beginTransaction();
  $sql=$pdo->prepare(
	   'INSERT into purchase(id,customer_id) values(?,?)'
		);

$success = $sql->execute([
	$purchase_id,                  //1
	$_SESSION['customer']['id']    //2
	]) {
		if($success){
		//$purchase_id = $sql->lastInsertId();
		//↑ A_Iで登録されたidの取得
		/*1行実行のINSERT文は非効率なので、1回のINSERTで複数行の注文を入れたい
		  valuesの後ろの()をカンマ区切りでつなげる(未実行)
		*/
	foreach ($_SESSION['product'] as $product_id=>$product) {
		$sql=$pdo->prepare(
			'INSERT into purchase_detail values(?,?,?)'
		);
		$sql->execute([
			$purchase_id,
			$product_id,
			$product['count']]
		);
	}
	
	$pdo->commit();
	//カートをカラにする
	unset($_SESSION['product']);
	echo '購入手続きが完了しました。ありがとうございます。';
} // if end ,elseはいらない
} catch(PDOException $e) {
	echo $e->getMessage();   //エラーメッセージを出力
	echo '購入手続き中にエラーが発生しました。申し訳ございません。';
  $pdo->rollBack();       //ロールバック
}

?>
<?php require '../footer.php'; ?>
