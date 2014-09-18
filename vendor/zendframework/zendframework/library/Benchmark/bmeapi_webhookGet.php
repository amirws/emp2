<?php
/**
This Example shows how to get the list of existing Emails
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
$contactList = $api->listGet($token, "", 1, 1, "", "");
$listID = $contactList[0]['id']; 

$retval = $api->webhookGet($listID);
		

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Webhooks Returned:\n"; 
   echo "<table border='1'>";
   echo "<tr>";
   echo "<td>WebhookID</td><td>URL</td><td>subscribes</td><td>unsubscribes</td><td>profile_updates</td><td>cleaned_address</td><td>email_changed</td><td>Created Date</td><td>Modified Date</td>";
    echo "</tr>";
  foreach($retval as $webhookData){
    echo "<tr>";
    echo "<td>".$webhookData['id']."</td><td>".$webhookData['url']."</td><td>".$webhookData['subscribes']."</td><td>".$webhookData['unsubscribes']."</td><td>".$webhookData['profile_updates']."</td><td>".$webhookData['cleaned_address']."</td><td>".$webhookData['email_changed']."</td><td>".$webhookData['modifiedDate']."</td><td>".$webhookData['createdDate']."</td>";   
    echo "</tr>";
  }
  echo "</table>";
}
?>
