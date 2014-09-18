<?php
/**
Create a new contact list.
**/
require_once 'inc/BMEAPI.class.php';
require_once 'inc/config.php'; //contains username & password

$api = new BMEAPI($username, $password, $apiURL);
if ($api->errorCode)
{
  // an error occurred while logging in
  echo "code:".$api->errorCode."\n";
  echo "msg :".$api->errorMessage."\n";
  die();
}

$targetEmailID = "email1@validomain.com,email2@validomain.com";
$retval = $api->confirmEmailAdd( $targetEmailID );

if ( strlen($retval) == 0 )
{
	echo "Emails added successfully for confirmation!";
}
else 
{
	echo "Emails not added " .  $retval ;
}

?>