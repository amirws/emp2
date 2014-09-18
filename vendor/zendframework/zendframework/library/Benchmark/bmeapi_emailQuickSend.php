<?php
/**
 Resend an email campaign to contacts that were added since the campaign was last sent.
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
$emailList = $api->emailGet("", "", 1, 1, "", "");
$ListName="May 17 2011 List3";
$emailID = $emailList[0]['id'];
echo("Email ID ".$emailID);
$scheduleDate = '31 May 2011 15:33:06';//date('d M Y', strtotime('+1 week'));
$records = array();
$contactData = array();
$contactData["email"] ='sf1@yahoo.com';
$records[] = $contactData;
//$emails = array();
//$emails[0]["email"] = "xyz@123.com";
//$emails[1]["email"] = "xyz@124.com";
//$emails[2]["email"] = "xyz@125.com";
$retval = $api->emailQuickSend($emailID, $ListName , $records ,$scheduleDate );

if (!$retval)
{
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
}
else
{
  echo "Email Scheduled \n";
}

?>