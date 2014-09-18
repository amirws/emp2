<?php
/**
This Example shows how to get details of an existing survey
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
$SurveyTemplateList=$api->surveyTemplateGetList();
$NewSurveyId=$api->surveyCopyTemplate($SurveyTemplateList[0]['id'],"BSNL_Test_Survey");


if ( !$NewSurveyId )
{
	echo "Error!";
	echo "\n\tCode=".$api->errorCode;
	echo "\n\tMsg=".$api->errorMessage."\n";
}
else
{

  echo("New Survey Id : ".$NewSurveyId);
  }
?>
