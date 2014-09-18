<?php
/**
This Example shows how to create a new Email
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
	If you want to create the email for the Segment then use this code:-
	$segmentList=$api->segmentGet("",1,1,"","");
	$contactListID=$segmentList[0]['id'];
	$emailDetails["isSegment"]="true";
**/

	/**
			Fetch the latest contact list ID, so we can retrieve the target contact list ID.
	**/ 
	$contactList = $api->listGet($token, "", 1, 1, "", "");
	$listID = $contactList[0]['id']; 

	$webhookDetails["contact_list_id"] = $listID;
	$webhookDetails["subscribes"] = "1";
	$webhookDetails["unsubscribes"] = "y";
	$webhookDetails["profile_updates"] = "True";
	$webhookDetails["email_changed"] = "21";
	$webhookDetails["cleaned_address"] = "s";
	$webhookDetails["url"] = 'www.webhook-url.com';
	$retval = $api->webhookCreate($webhookDetails);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "New Webhook ID:". $retval ."\n";
}
?>
