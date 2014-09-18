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
//$retval = $api->listGet("", 1, 10, "", "");
//$contactListID=$retval[0]['id'];
//"ID of the contact list in which you want to add contacts.For getting list ID you can use listGet method of BME API";
$contactListID="";
//$listID="";
$mail="XXXXXXXXXX";
for($i=0;$i<3;$i++)
{
$details[$i]['email']='XXX@XXXX.com';
$details[$i]['Extra 3'] = "Test";
$details[$i]['Extra 4'] = "Test";
$details[$i]['Extra 5'] = "Test";
$details[$i]['Extra 6'] = "Test";
$details[$i]['Notes'] = "Test";
}
$contactID = $api->listAddContactsRetID($listID, $details); 


if (!$contactID){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
print_r($contactID);
  //echo "Total Contacts:". $retval . $contactID ."\n";
}

?>