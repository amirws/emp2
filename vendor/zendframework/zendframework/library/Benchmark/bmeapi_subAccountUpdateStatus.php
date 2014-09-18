<?php
/**
This example shows how to update the status of your Subaccount
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

$id = "XXXX" ; // put in your subaccount client ID which should be a number
$status = "0"; // Status of the Subaccount, this can be either 1 or 0

$api->subAccountUpdateStatus($id, $status);


?>
