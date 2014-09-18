<?php
/**
This Example shows how to update an existing Autoresponder
**/
require_once 'inc/BMEAPI.class.php';
require_once 'inc/config.php'; //contains username & password

//This hack actually skips the login and lets you choose the API Key to expire.
$api = new BMEAPI($username, $password, $apiURL);

if ($api->errorCode)
{
  // an error occurred while logging in
  echo "code:".$api->errorCode."\n";
  echo "msg :".$api->errorMessage."\n";
  die();
}

$status = "1"; // 1 for making it active , 0 for deactivating it

$Autoresponder = array();
$Autoresponder["autoresponderName"] = "Autoresponder 1 update";
$Autoresponder["fromName"]         =  "Joe de maggio";
$Autoresponder["fromEmail"]         = "yname@yemail.com";
$Autoresponder["webpageVersion"]    = false;
$Autoresponder["permissionReminder"]    = true;
$Autoresponder["permissionReminderMessage"]    = "Please click here to confirm, <a target=_new style='color:#0000ff;' href='CONFIRMURL'>Confirm my subscription</a> .";

$retval = $api->autoresponderUpdate($autoresponderID , $status ,$Autoresponder);

if ( !$retval )
{
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} 
else 
{
  echo "New Email ID:". $retval ."\n";
}
?>
