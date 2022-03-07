<?php session_start(); 
 require '../connect.php'; 
 /*
 1. 顧客idがあるかどうか確認
 2. 注文idがあるか確認
 3. 
*/
?>
<?php


if (empty ( $_SESSION['customer']) ) {
  echo '<p>購入履歴を表示するにはログインしてください</p>',
  exit;

}else if( empty($_POST['purchase_id']) ) {
  echo '<p>注文idがありません</p>';
  exit; //メッセージをだして処理を中断する
}else{
  $sql=
  "SELECT p.id, name, address, customer_id, `date` 
  FROM `purchase` AS p                           
  LEFT JOIN customer AS c ON c.id = customer_id     
  WHERE p.id = ? 
  AND customer_id = ?
	";                        //customer_idはsessionで受け取る   purchase_idはPOSTで受け取る

  
$sql_purchase = $pdo->prepare($sql);
$sql_purchase->execute([
  $_POST['purchase_id'],
  $_SESSION['customer']['id']
  ]);

  $nohin_top = $sql_purchase->fetch();
  //print_r($nohin_top);
  $sql= 
	"SELECT purchase_id, name, `count`, price,
	        `count` * price AS shoke 
	 FROM purchase_detail AS d
   LEFT JOIN product AS p ON id = product_id
	 WHERE purchase_id = ? 
	 ORDER BY product_id";

$sql_detail = $pdo->prepare( $sql );
$sql_detail->execute([ $_POST['purchase_id'] ]);

$tr = '';  //変数$trを空文字で初期化
$total=0;  //
foreach( $sql_detail as $row){
//echo '<pre>'; print_r($row);
$tr .= "<tr>
<td>$row[purchase_id]</td>
<td>$row[name]</td>
<td>$row[count]</td>
<td>$row[price]</td>
<td>$row[shoke]</td>
</tr>";
$total += $row['shoke'];
}

?>

<style>
table.bottom , .bottom td, .bottom th { 
	 border: 1px solid #595959;
	 border-collapse: collapse;
}
td, th {padding: 3px;
	      width: 30px;
    	  height: 25px;
			}
th {background: #f0e6cc;}
.even {background: #fbf8f0;}
.odd {background: #fefcf9;}
.top , .bottom{width:600px; margin:auto; }
</style>

<table class="top">
		<tr>
			<td> <h1>納品書</h1></td>
			<td>伝票番号 <?=$nohin_top['id']?> </td>
		</tr>

		<tr>
			<td rowspan="3"></td>
			<td>受注年月日 
				<?=date('Y年m月d日',strtotime( $nohin_top['date']) )?></td>
		</tr>

		<tr>
			<td></td>
		</tr>

		<tr>
			<td>得意先名  <?=$nohin_top['name']?></td>
		</tr>
		<tr>
			<td>得意先コード  <?=$nohin_top['customer_id']?> </td>
			<td>得意先住所  <?=$nohin_top['address']?> </td>
		</tr>
</table>

<table class="bottom">
	<tr>
<th>商品コード</th>
    <th>商品名</th>
    <th>単価</th>
    <th>数量</th>
    <th>小計</th>
	
  </tr>
	<?= $tr ?>	
	<tr>
	  <td colspan="4">合計</td>
	  <td> <?= $total ?> </td>
	</tr>	
	</table>
<?php 
}
 
