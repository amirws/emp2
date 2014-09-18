<?php
/**
  * Create Autoresponder email template and Returns the ID of the newly created Autoresponder email template
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

$HTML = "<html><body> <b> Hello World </b> </body></html>";
$TEXT = "text version";


$retval = $api->autoresponderGetList ( 1, 5, "","","", "");
$autoresponderID = $retval[0]["id"];  //Fetch latest autoresponder id.

$AutoresponderDetail = array();
$AutoresponderDetail["subject"] = "My Autoresponder day 1";
$AutoresponderDetail["templateContent"] = $HTML;
$AutoresponderDetail["templateText"]    = $TEXT;
$AutoresponderDetail["us_address"]      = "Bellhop street, amydale avenue";
$AutoresponderDetail["us_state"]        = "California";
$AutoresponderDetail["us_city"]         = "San hose";
$AutoresponderDetail["us_zip"]          = "7000043";
$AutoresponderDetail["intl_address"]    = "";
$AutoresponderDetail["type"]            = "annual email"; //  valid values are "one off email" , "annual email" , "new subscriber email"
$AutoresponderDetail["days"]            = "0";
$AutoresponderDetail["whentosend"]      = "before"; // valid values are "after" , "before", ignore if this is not applicable
$AutoresponderDetail["fieldtocompare"]  = "bday"; // label of the date field
$retval = $api->autoresponderDetailCreate( $autoresponderID , $AutoresponderDetail );

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "New Email ID:". $retval ."\n";
}
?>
