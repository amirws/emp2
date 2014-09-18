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

    $contactList=$api->listGet("", 1, 100, "", "");
    $contact[0]['id']=$contactList[0]['id'];
    $contact[1]['id']=$contactList[1]['id'];
    $contact[0]['contactcount']=$contactList[0]['contactcount'];
    $contact[1]['contactcount']=$contactList[1]['contactcount'];
    $contact[0]['listname']=$contactList[0]['listname'];
    $contact[1]['listname']=$contactList[1]['listname'];

    $signup['introduction']='Join our weekly newsletter list. Just enter your email below.';
    $signup['name']='March31 2011SignUpForm4';
    $signup['title']='Join Our Mailing List';
    $signup['list']=$contact;


$retval = $api->signupFormCreate($signup);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "Return Value is:". $retval ."\n";
}
?>