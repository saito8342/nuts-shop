<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

<style>
ul.row { list-style: none;}

img { width: 100%; height: auto;}

button { border: none}

li.product { padding: 19px;}

a { color: #999; text-decoration: none}

a.pg { border: solid 1px; padding: 0 6px;}
</style>

<?php require '../header.php'; ?>
<?php require 'menu.php'; ?>

<?php require '../connect.php'; ?>

<form action="index.php" method="post">商品検索
  <input type="text" name="keyword">
  <input type="submit" value="検索">
</form>

<hr>
<article class="container">
  <button class="fas fa-th-large" style="color: #09aaf3;font-size: 2em;"></button>
  <button class="fas fa-list" style="font-size: 2em;"></button>
  <ul class="row">

<?php


$item_count=6 ; //1pに6商品
if(isset($_REQUEST['page'])){
  $current_page=($_REQUEST['page'] - 1) * $item_count;
}else{
  $current_page=0 ;
}
//商品一覧ページ

if (isset($_REQUEST['keyword'])) {
  //検索条件が来てたらこっち
  $sql=$pdo->prepare('select * from product where name like ?');
  $sql->execute(['%'.$_REQUEST['keyword'].'%']);
} else {
  //無条件ならこっち
  $sql=$pdo->prepare("SELECT * from product LIMIT ? , $item_count");
  $sql->execute([$current_page]);
}
foreach ($sql as $row) {
  $id=$row['id'];

?>

    <li class="product col-4" >
      <img class="" src="image/<?=$id?>.jpg">
      <p>
        <a href="detail.php?id=<?=$id?>">
          <span><?=$row['name']?></span>
          <br><span><?=$row['price']?></span>
        </a>
      </p>
    </li>
 
    <?php } ?>
  </ul>
  <!-- ページャーをつけてみる -->
 <!-- <a class="pg" href="./?page=1">1</a>
  <a class="pg" href="./?page=2">2</a>
  <a class="pg" href="./?page=3">3</a>  
-->
  <?php
  $sql = $pdo->query(
  "SELECT count(*) as ct FROM product");
  //最初の1行だけ取り出す
  $count = $sql->fetch(); //14

  //1ページの件数で割って切り上げる
  $count=ceil($count['ct'] / $item_count); 
  // 1から始めたほうが効率がいい
  for( $i=1 ;$i <= $count ;$i++){
    ?>
  <a class="pg" href="./?page=<?=$i ?>"><?=$i ?></a>
<?php } ?>

</article>

<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>

<script>
$('.fa-list').click(function() {
  $(this).css('color', '#09aaf3').prev().css('color', '#000');
  //↑自分の色を変える               →自分の前の要素の色を変える

  $('li.product').addclass('row').removeClass('col-4');
  //↑この要素にrowクラスを付与       →col-4を削除

  $('li.product img').addClass('col-3');
  // ↑この要素の子のimgにcol-3付与

  $('li.product img + p').addClass('col-9');
  // ↑この要素の子のimgに隣接した pにcol-9を付与
});

$('.fa-th-large').click(function(){
  $(this).css('color','#000').next().css('color','#09aaf3');
  $('li.product').addClass('col-4').removeClass('row');
  $('li.product img').removeClass('col-3');
  $('li.product img + p').removeClass('col-9');
});
</script>

<?php require '../footer.php';?>