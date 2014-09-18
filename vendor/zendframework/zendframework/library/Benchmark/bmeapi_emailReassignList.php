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


echo "Here";
$contacts = Array();

$retval = $api->listGet("", 1, 10, "", "");
if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {

  $contacts[0]['listid'] =  $retval[0]['id'];


}

$retval = $api->segmentGet("", 1, 10, "");
$contacts[1]['segmentid'] =  $retval[0]['id'];


$retval = $api->emailGet("", -1, 1, 5, "", "");
$emailID = $retval[0]['id'];


echo "Email ID : " . $emailID;

$api->emailReassignList($emailID, $contacts);

?>