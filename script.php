<?php 
if($_POST['summa'])$summa = $_POST['summa']; 
if($_POST['number'])$number = $_POST['number']; 
if($_POST['token'])$token = $_POST['token']; 
$time = date("His"); 
$idgen = $time * 100 + 5; 


$ch = curl_init(); 

curl_setopt($ch, CURLOPT_URL, "https://edge.qiwi.com/sinap/api/v2/terms/99/payments"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n \"id\":\"$idgen\",\n \"sum\": {\n \"amount\":$summa,\n \"currency\":\"643\"\n },\n \"paymentMethod\": {\n \"type\":\"Account\",\n \"accountId\":\"643\"\n },\n \"comment\":\"QIWI by MaksPaver\",\n \"fields\": {\n \"account\":\"+$number\"\n }\n }"); 
curl_setopt($ch, CURLOPT_POST, 1); 

$headers = array(); 
$headers[] = "Content-Type: application/json"; 
$headers[] = "Accept: application/json"; 
$headers[] = "Authorization: Bearer $token"; 
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 

$result = curl_exec($ch); 
if (curl_errno($ch)) { 
echo 'Error:' . curl_error($ch); 
} 
if(!empty($result)){ 
echo('Перевод выполнен'); 
}else{ 
echo('Ошибка перевода'); 
} 
curl_close ($ch);