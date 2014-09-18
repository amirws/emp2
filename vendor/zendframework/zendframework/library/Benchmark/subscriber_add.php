<?php
$ch = curl_init("http://lb.benchmarkemail.com//code/lbform");
$encoded = '';
$Dict = array();
$Dict["token"]  = "mFcQnoBFKMQDuRRnlHswWOoNbCMyivkXESzzoUUT7i83Ih4P1WxctQ%3D%3D";
$Dict["fldEmail"]=$_GET['address'];

foreach($Dict as $name => $value) {
  $encoded .= urlencode($name).'='.$value.'&';
}

$encoded = substr($encoded, 0, strlen($encoded)-1);
curl_setopt($ch, CURLOPT_POSTFIELDS,  $encoded);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$result=curl_exec($ch);
curl_close($ch);
if(strripos($result,"error")||strripos($result,"offline"))
{
echo"Error";
}
else
{
echo"Success";
}

?>

