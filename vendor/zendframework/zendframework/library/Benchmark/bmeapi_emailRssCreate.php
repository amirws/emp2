<?php
/**
This Example shows how to create a new rss Email
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

$HTML = "<html><body> <b> Hello World </b> </body></html>";
$emailDetails["fromName"] = "demo";
$emailDetails["fromEmail"] = $test_email;
$emailDetails["emailName"] = "Demo Email";
$emailDetails["replyEmail"] = $test_email;
$emailDetails["subject"] = "Hello World";
$emailDetails["templateContent"] = $HTML;
$emailDetails["toListID"] =  $contactListID;
$emailDetails["rssurl"]   =  "http://www.myressfeed.com/";
$scheduleDate = date('d M Y', strtotime('+1 week'));
$emailDetails["scheduleDate"] =  $scheduleDate;
$emailDetails["rssinterval"] =  "30";

$retval = $api->emailRssCreate($emailDetails);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "New Email ID:". $retval ."\n";
}
?>
