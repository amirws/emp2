<?php
/**
This Example shows how to create a new Survey
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

$retval=$api->surveyGetList("", "", 1, 10, "", "");
$SurveyID=$retval[0][id];
$surveyDetail['id']=$SurveyID;
$surveyDetail['name'] = 'Sales Survey1';
$surveyDetail['url'] = 'www.benchmarkemail.com';
$surveyDetail['title'] = 'Shop Survey';
$surveyDetail['intro'] = 'Please take our quick, easy survey on the services we provide.';
$retval = $api->surveyUpdate($SurveyID,$surveyDetail);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "Updated Survey ID:". $retval ."\n";
}
?>
