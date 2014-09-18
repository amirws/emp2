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

 $emailLists = $api->emailGet("", "", 1, 10, "", "");
 $emailID=$emailLists[0]['id'];
 $HtmlContent = "<html><body>hello</body></html>";
 $TextContent = "Buy our product and get Profit";
 $emailAddress = "antriksh@cybermaxsolutions.com";
 $PersonalMessage = "Hi! Are you want Profit";
 $retVal = $api->emailPreviewTest($emailID, $emailAddress, $HtmlContent, $TextContent, $PersonalMessage);

if (!$retVal){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
 echo("The email sent to ".$retVal);
  }

?>
