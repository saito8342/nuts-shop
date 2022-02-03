<?php require '../header.php';?>

<link rel="stylesheet" href="style2.css">

<div class="th0">商品番号</div>
<div class="th1">商品名</div>
<div class="th1">商品価格</div>

<?php
  require_once '../connect.php';

if(isset($_REQUEST['command'])){
   switch ($_REQUEST['command']){
   case 'insert':
       if(empty($_REQUEST[ 'name' ]) ||
           !preg_match('/[0-9]+/', $_REQUEST[ 'price' ])) break;
       $sql=$pdo -> prepare('insert into product values(null,?,?)');
       $sql ->execute(
            [htmlspecialchars($_REQUEST[ 'name' ]), $_REQUEST['price']]);
       break;

   case 'update':
        if (empty($_REQUEST['name'])  ||
            !preg_match('/[0-9]+/', $_REQUEST['price'])) break;
        $sql=$pdo -> prepare(
             'update product set name=?, price=? where id=?');
        $sql -> execute(
             [htmlspecialchars($_REQUEST[ 'name' ]), $_REQUEST[ 'price' ],
             $_REQUEST[ 'id' ]]);
        break;

   case 'delete':
        $sql=$pdo -> prepare ( 'delete from product where id=?');
        $sql -> execute([$_REQUEST['id']]);
        break;
   }
}


foreach ($pdo -> query('select * from product') as $row) {  
?>
  <form class= "ib" action="edit3.php" method="post">
  <input type="hidden" name="command"  value="update">
  <input type="hidden" name= "id"      value="<?= $row['id']?>">
  <div class="td0">
  <?= $row['id'] ?>
  </div>
  <div class="td1"> 
  <input type= "text" name="name" value="<?= $row['name']?>">
  </div>
  <div class="td1">
  <input type ="text" name="price" value="<?= $row['price']?>">
  </div>      
  <div class="td2">
  <input type="submit" value="更新">
  </div>
  </form>
  <form class= "ib" action="edit3.php" method="post">
  <input type="hidden" name="command" value="delete">
  <input type="hidden" name="id" value="<?= $row['id']?>">
  <input type="submit" value= "削除">
  </form>

<?php }
?>
<form action="edit3.php" method = "post">
<input type= "hidden" name= "command" value="insert">
<div class="td0"></div>
<div class="td1"><input type="text" name="name"></div>
<div class="td1"><input type="text" name="price"></div>
<dic class="td2"><input type="submit" value="追加"></div>
</form>

<?php '../footer.php';?> 