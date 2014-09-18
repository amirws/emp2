<?php
/**
This Example shows how to Register a new Subaccount
**/
require_once 'inc/BMEAPI.class.php';
require_once 'inc/config.php'; //contains username & password

//This hack actually skips the login and lets you choose the API Key to expire.
$api = new BMEAPI($username, $password, $apiURL);
if ($api->errorCode){
  // an error occurred while logging in
  echo "code:".$api->errorCode."\n";
  echo "msg :".$api->errorMessage."\n";
  die();
}

$accountstruct = array();

$accountstruct["email"] = "subaccountemail@demo.com";
$accountstruct["firstname"] = "duserfname";
$accountstruct["lastname"]  = "duserlname";
$accountstruct["login"]     = "duserlogin";
$accountstruct["password"] = "duserpassword";
$accountstruct["phone"] = "933323233";


$retval = $api->subAccountCreate($accountstruct);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "New Email ID:". $retval ."\n";
}
?>
