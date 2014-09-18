<?php
/**
Get the contacts from the contact list.
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
$contactListID='XXXXXX';//Contact LIst ID
$retval = $api->listGetContactsAllFields($contactListID, "", 1, 5, "", "");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Contacts Returned:\n";
   foreach($retval as $rec) {
	 foreach($rec as $key => $value) {
      echo $key . ": " . $value . "<br />";
    }
    }
}
?>
