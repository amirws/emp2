<?php
/**
This Example shows how to create a new Survey
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

$signUpList=$api->listGetSignupForms(1,10,"","asc");


    $signupID=$signUpList[0]["id"];
    $signup['welcomeEmailConfirmationText']='Thanks For Joining Us';
    $signup['welcomeEmailFromEmail']='goswamiantriksh@gmail.com';
    $signup['welcomeEmailFromName']='Join our Mailing List';
    $signup['welcomeEmailMessage']='Welcome to our List';
    $signup['welcomeEmailSubject']='Confirmation Mail';


$retval = $api->signupFormUpdateMessage($signupID,$signup);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "Return Value is:". $retval ."\n";
}
?>