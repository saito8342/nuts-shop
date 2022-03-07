<?php require '../header.php'; ?>
<?php require '../connect.php'; ?>
<div class="container">
	<aside>
		<?php require 'sidebar.php'; ?>
  </aside>
<main>

<?php
/*
	購入履歴テーブルと顧客と購入明細と商品台帳を結合
	伝票idでグループ化して小計をグループ集計する｡
*/	

	$sql = 
"SELECT purchase_id,name,g.goke,date
FROM `purchase` AS p 
LEFT JOIN `customer` AS c ON c.id = p.customer_id
LEFT JOIN (
SELECT purchase_id ,sum(count * price) goke
FROM `purchase_detail` AS d
LEFT JOIN `product` AS t ON t.id = d.product_id
GROUP BY purchase_id
ORDER BY purchase_id
) AS g ON p.id = g.purchase_id
ORDER BY date DESC
LIMIT 50";

	$sql_purchase = $pdo->prepare($sql);
	$sql_purchase->execute();
// $sql_purchase = $dbh->query($sql);  ?がないならこれでもいい

?>
<h2>注文一覧</h2>
<table>
		 <tr>
		 <th>注文番号</th>
			<th>顧客名</th> 
			<th>合計金額</th>
			<th>日付</th>
</tr>
<tr>
	<?php
		foreach ($sql_purchase as $row_detail) {
		?>
			<td><a href="order_detail.php?id='<?=$row_detail['purchase_id']?>"> <?=$row_detail['purchase_id']?> </a></td>
			<td><?=$row_detail['name']?> </td>
			<td><?=$row_detail['goke']?> </td>
			<td><?=$row_detail['date']?> </td>
		  </tr>
<?php } ?>

		</table>
	</main>
</div>
<?php require '../footer.php'; ?>
