<?php
/**
Get the contact lists in your account.
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

$retval = $api->listGet("", 1, 10, "", "");
$listID=$retval[2]['id'];
echo("The list id is :".$listID);
$retval = $api->listGetContactsCount($listID,"");
if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
echo("The number of contacts in the list are".$retval);
}

?>
