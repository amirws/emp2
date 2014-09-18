<?php
/**
This Example shows how to Add the contact details to the given contact list.
Multiple contacts would be added if the details has more than one items.
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

$details[0]["email"] = "tom@____.com";
$details[0]["firstname"] = "Tom";
$details[0]["lastname"] = "Jones";
$details[0]["extra 1"] = "Extra 1";
$details[0]["extra 3"] = "Extra 3";

$details[1]["email"] = "jack@invaliddomain.moc";
$details[1]["firstname"] = "Jack";
$details[1]["lastname"] = "Sawyer";


$retval = $api->listAddContactsOptin($contactListID, $details, "1");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "Total Contacts:". $retval ."\n";
}

?>
