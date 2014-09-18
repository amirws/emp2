<?php
/**
This Example shows how to update an existing Email
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

	/**
		Fetch the latest contact list ID, so we can retrieve the target contact list ID.
	**/ 
	$contactList = $api->listGet("", 1, 1, "", "");
	$listID = $contactList[0]['id'];

	/**
	Fetch the latest webhook, so we can retrieve the webhook ID.
	**/
	$webhookList = $api->webhookGet($listID);
	$webhookID = $webhookList[0]['id'];
	
	$webhookDetails["id"] = $webhookID;
	$webhookDetails["contact_list_id"] = $listID;
	$webhookDetails["subscribes"] = "false";
	$webhookDetails["unsubscribes"] = "false";
	$webhookDetails["profile_updates"] = "false";
	$webhookDetails["email_changed"] = "false";
	$webhookDetails["cleaned_address"] = "false";
	$webhookDetails["url"] = 'http://www.webhook-url.com';

	$retval = $api->webhookUpdate($webhookDetails);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "Webhook Updated\n";
}
?>
