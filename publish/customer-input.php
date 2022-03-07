<?php
session_start();
require '../header.php';
require 'menu.php';


$name= '';
$postcode= '';
$address= '';
$email= '';
$login= '';
$password= '';

if (isset($_SESSION['customer'])) {
  $name=$_SESSION['customer']['name'];
  
  $address=$_SESSION['customer']['address'];
  $email=$_SESSION['customer']['email'];
  $login=$_SESSION['customer']['login'];
//パスワード消去
}
?>

<form action="customer-output.php" method="post">
<table>
<tr>
  <td>お名前(*)</td>
  <td>
<input type="text" name="name" value="<?=$name?>" required>
   </td>
  </tr>

<tr>
  <td>郵便番号(*)</td>
  <td>
  <input type="text" name="postcode" value="<?=$postcode?>" required>
   </td>
  </tr>
<tr>
  <td>ご住所(*)</td>
  <td>
<input type="text" name="address" value="<?=$address?>" required>
   </td>
</tr>
<tr>
  <td>メールアドレス(*)</td>
  <td>
<input type="email" name="email" values="<?=$email?>" required>
</td>
</tr>
<tr>
  <td>ログイン名(*)</td>
  <td>
<input type="text" name="login" value="<?=$login?>" required>
</td></tr>

<tr>
  <td>パスワード(*)</td>
<td>
<input type="password" name="password" value="<?=$password?>" required>
</td>
</tr>

</table>
<input type="submit" value="確定">
</form>

<?php require '../footer.php'; ?>