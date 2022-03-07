<?php 
session_start();
require '../header.php';
require 'menu.php';

/*
$name='';
$address='';
$email='';
$login='';
$password='';

if (isset($_SESSION['customer'])) {
  $name=$_SESSION['customer']['name'];
  $address=$_SESSION['customer']['address'];
  $email=$_SESSION['customer']['email'];
  $login=$_SESSION['customer']['login'];
  $password=$_SESSION['customer']['password'];
}
*/

?>
<style>
	input[type="number"]::-webkit-outer-spin-button,
	input[type="number"]::-webkit-inner-spin-button {
	  -webkit-appearance: none;
	}

	/* Firefox */
	input[type="number"] {
	  -moz-appearance: textfield;
	}
  .result{color: #a44;
  display: block;   /* ブロック要素になる、全幅*/
  }
</style>

<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

<form action="newcustomer-output.php" method="post">
<table>
<tr>
  <td>お名前(*)</td>
  <td>
     <input type="text" name="name"  required>
  </td>
</tr>

<tr>
  <td>郵便番号(*)</td>
  <td>
     <input type="text" name="postcode"
     <span class="p-country-name" style="display:none;"></span>
     <input type="text" class="p-postal-code" size="8" maxlength="8" name="zip" >
  </td>
</tr>

<tr>
  <td>ご住所(*)</td>
  <td>
    <input type="text" name="address" 
    class="p-region p-locality p-street-address p-extended-address" required>
   </td>
</tr>

<tr>
  <td>メールアドレス(*)</td>
  <td>
     <input type="email" name="email" required>
  </td>
</tr>

<tr>
  <td>ログイン名(*)</td>
  <td>
   <input type="text" name="login" autocomplete="off" required>
   <b class="result"><!--警告を埋め込む所--></b>
  </td>
</tr>

<tr>
  <td>パスワード(*)</td>
  <td>
  <input type="password" name="password"  required>
  </td>
</tr>

</table>
<input type="submit" value="確定">
</form>


<script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>

    <script>
    $(function(){
        //.sampleをクリックしてajax通信を行う
        $('[name="login"]').change(function(){
          var login = $(this).val();

          $.ajax({
                url:'newcustomer-check.php',
                /* ブラウザにクロスオリジン制約というのがあって自サーバーにおいたファイルしか読めません。
                他のサーバーであれば、そっち側に許可が必要
                 */
                type: 'GET',
                dataType: 'html',
                data:{login:login}
            }).done(function(res){
                /* 通信成功時 */
                $('.result').html(res); //取得したHTMLを.resultに反映
                
            }).fail(function(data){
                /* 通信失敗時 */
                alert('通信失敗！');
                        
            });
        });
    });
    </script>

<?php require '../footer.php'; ?>