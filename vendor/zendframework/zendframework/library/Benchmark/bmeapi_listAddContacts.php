<?php
/**This Example shows how to Add the contact details to the given contact list.
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
$contactListID="438562";
$mail="antriksh@cybermaxsolutions.com";
$details[0]["email"] = $mail;
$details[0]["firstname"] = "";
$details[0]["lastname"] = "";
$mail="kishore@cybermaxsolutions.com";
$details[1]["email"]=$mail;
$details[1]["firstname"] = "";
$details[1]["lastname"] = "";
$mail="swapnil.chile@cybermaxsolutions.com";
$details[2]["email"]=$mail;
$details[2]["firstname"]="";
$details[2]["lastname"]="";
$retval = $api->listAddContacts($contactListID, $details);
/*
$details[0]["email"] = "tom@____.moc";
$details[0]["firstname"] = "Tom";
$details[0]["lastname"] = "Jones";
$details[0]["extra 1"] = "Extra 1";
$details[0]["extra 3"] = "Extra 3";

$details[1]["email"] = "jack@___.moc";
$details[1]["firstname"] = "Jack";
$details[1]["lastname"] = "Sawyer";


$retval = $api->listAddContacts($contactListID, $details);
*/

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "Total Contacts:". $retval ."\n";
}

?>
