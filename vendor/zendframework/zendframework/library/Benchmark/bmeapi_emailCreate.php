<?php
/**
This Example shows how to create a new Email
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


/**
	If you want to create the email for the Segment then use this code:-
	$segmentList=$api->segmentGet("",1,1,"","");
	$contactListID=$segmentList[0]['id'];
	$emailDetails["isSegment"]="true";
**/

$contactList=$api->listGet("", 1, 1, "", "");
$contactListID=$contactList[0]['id'];
$HTML = "<html><body> <b> Hello World </b> </body></html>";
$emailDetails["fromName"] = "demo";
$emailDetails["fromEmail"] = $test_email;
$emailDetails["emailName"] = "Demo1 Email";
$emailDetails["replyEmail"] = $test_email;
$emailDetails["subject"] = "Hello World";
$emailDetails["templateContent"] = $HTML;
$emailDetails["webpageversion"]="true";
$emailDetails["toListID"] =  intval($contactListID);

$retval = $api->emailCreate($emailDetails);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "New Email ID:". $retval ."\n";
}
?>
