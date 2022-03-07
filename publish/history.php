<?php session_start(); ?>
<?php require '../header.php'; ?>
<?php require 'menu.php'; ?>
<?php require '../connect.php'; ?>

<?php
if (isset($_SESSION['customer'])) {
	//購入履歴テーブルから顧客idで絞り込み、降順で取得
	//購入履歴テーブルと購入明細と商品一覧を3つ結合
	$sql = "SELECT purchase_id ,product_id, name, count ,price,
	count * price AS shokei ,`date`
	FROM `purchase_detail` AS d
	LEFT JOIN purchase AS p ON purchase_id = p.id
	LEFT JOIN product as s ON product_id = s.id
	WHERE customer_id = ?
	ORDER BY purchase_id DESC";

	$sql_purchase = $pdo->prepare($sql);
	 //プレースホルダー?に顧客idを結束
	$sql_purchase->execute([$_SESSION['customer']['id']]);
	$prev_purchase_id=0; //初回ループの注文id

	foreach ($sql_purchase as $row_detail) {

		//最初に注文番号が、上の行と同じか比較する
	if($prev_purchase_id !=$row_detail['purchase_id']){
		//違ってたら注文のループ開始
		if($prev_purchase_id !== 0){
			ob_start(); 
  ?>

		<tr>
	<td colspan="4">合計</td>
	<td><?= $total ?></td>
</tr>
</table>
<form action="nohin.php" method="post">
	<input type="hidden" name="purchase_id"
	value="<?=$prev_purchase_id?>">
<button>納品書発行</button> 
		</form>
<hr>

<?php 
    $table_close = ob_get_contents();
    ob_end_clean();
    echo $table_close;
  }
	$total=0; 
  ?>
<table>
		<tr>
			<th>注文番号</th>
			<th>商品名</th> 
			<th>価格</th>
			<th>個数</th>
			<th>小計</th>
		</tr>

<?php
		}
			//同じだったら詳細のループだけ行う
  ?>
		 <tr>
			<td> <?=$row_detail['purchase_id']?> </td>
			<td>
				<a href="detail.php?id='<?=$row_detail['purchase_id']?>"> <?=$row_detail['name']?> </a>
			</td>
			<td><?=$row_detail['price']?> </td>
			<td><?=$row_detail['count']?> </td>
<?php
		$subtotal=$row_detail['price']*$row_detail['count'];
		$total+=$subtotal;
  ?>
			<td> <?=$subtotal?> </td>
		</tr>
<?php // 注文idが違ってたら
  if($prev_purchase_id != $row_detail['purchase_id']
	 && $prev_purchase_id !== 0){
	 }
	  //直前のIDが出てくる
	 $prev_purchase_id = $row_detail['purchase_id'];
	} //foreach end 
	?>
			<tr>
				 <td colspan="4">合計</td>
			   <td><?= $total ?></td>
		  </tr>
		</table>
		<form action="nohin.php" method="post">
			<input type="hidden" name="purchase_id"
			value="<?=$prev_purchase_id?>">
		<button>納品書発行</button>
</form>
		<hr>
<?php

} else {
	echo '購入履歴を表示するには、ログインしてください。';
}
  ?>
<?php require '../footer.php'; ?>

<!--
purchase_id	product_id	count 
id	customer_id	date 
id	name	price

SELECT purchase_id ,product_id, name, count ,price
,count * price AS shokei ,`date`
FROM `purchase_detail` AS d
LEFT JOIN purchase AS p ON purchase_id = p.id
LEFT JOIN product as s ON product_id = s.id
WHERE customer_id = 12
ORDER BY purchase_id DESC


問4
SELECT denpyo.tokui_id,denpyo_id ,juchu_bi,tokui_mei,jusho
FROM `denpyo`
LEFT JOIN tokui USING(tokui_id)
WHERE denpyo_id = 21

問6
SELECT s.shohin_id ,shohin_mei ,suryo
 ,tanka ,suryo*tanka as 小計
FROM  shosai as s
LEFT JOIN shohin as h USING (shohin_id )
WHERE denpyo_id = 20;
-->
