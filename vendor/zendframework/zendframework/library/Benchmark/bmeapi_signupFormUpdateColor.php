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
    $singup['border']='1';
    $singup['formFont']='Arial';
    $signup['formSize']='25';
    $singup['introAlign']='Middle';
    $signup['formBackground']='#ff0000';
    $singup['headerFont']='sans-serif';
    $signup['headerSize']='14px';


$retval = $api->signupFormUpdateColor($signupID,$signup);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "Return Value is:". $retval ."\n";
}
?>