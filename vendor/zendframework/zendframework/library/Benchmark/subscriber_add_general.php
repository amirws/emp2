<?php
$ch = curl_init("http://lb.benchmarkemail.com//code/lbform");
$encoded = '';
// include GET as well as POST variables; your needs may vary.
foreach($_GET as $name => $value) {
  $encoded .= urlencode($name).'='.$value.'&';
}
foreach($_POST as $name => $value) {
  $encoded .= urlencode($name).'='.$value.'&';
}
// chop off last ampersand
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
//echo($result);
?>
