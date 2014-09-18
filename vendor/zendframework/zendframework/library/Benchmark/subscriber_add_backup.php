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

<?php
/*
This Example shows how to Add the contact details to the given contact list.
Multiple contacts would be added if the details has more than one items.
**/
require_once 'inc/BMEAPI.class.php';
require_once 'inc/config.php'; //contains username & password

$api = new BMEAPI($username, $password, $apiURL);
if ($api->errorCode){
  // an error occurred while logging in
  echo "code:".$api->errorCode."\n";
  echo "msg :".$api->errorMessage."\n";
  die();
}

$contactListID="463494";
if (!empty($_REQUEST)) {
if(!empty($_REQUEST["address"]))
{
$mail=$_REQUEST["address"];
$details[0]['email']=$mail;
$details[0]['firstname']="";
$details[0]['lastname']="";

$retval = $api->listAddContacts($contactListID, $details);
}}


if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "Success";
}

?>
