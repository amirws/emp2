<?php
/**
This Example shows how to Add the contact details to the given signup form
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

$signupForms = $api->listGetSignupForms(1, 10, "");
$signupFormID = $signupForms[0]["id"];

$details["email"] = "tom@____.com";
$details["firstname"] = "Tom";
$details["lastname"] = "Jones";


$retval = $api->listAddContactsForm($signupFormID, $details);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "Total Contacts:". $retval ."\n";
}

?>
