<?php
/**
Unsubscribe the contacts from the given contact list.
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

$removeEmails = array("tom@invaliddomain.moc", "jack@invaliddomain.moc");

$retval = $api->listUnsubscribeContacts($contactListID, $removeEmails);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo $retval . " Contacts Active";
}
?>
