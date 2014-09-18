<?php
/**
This Example shows how to get details of an existing Email
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

$emailStructure = $api->emailGet("", -1, 1, 5, "", "");
$emailID=$emailStructure[0]['id'];
$newName="Welcome";
$retval = $api->emailCheckName($emailID,$newName);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
echo($retval);

  }
?>
