<?php
/**
This Example shows how to create a new Poll
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

 $pollDetail['name'] = 'Resturant Poll 2';
 $pollDetail['question'] = 'Do you eat out regularly';
 $pollDetail['answer1'] = 'Never';
 $pollDetail['answer2'] = 'Once a year';
 $pollDetail['answer3'] = 'Every Month';
 $pollDetail['answer4'] = 'Every Week';
 $pollDetail['answer5'] = 'Daily';
 $pollDetail['answercolor'] = '#0000ff';
 $pollDetail['answerfont'] = 'Comic Sans Ms';
 $pollDetail['borderbg'] = '#777700';
 $pollDetail['buttontext'] = 'Submit';
 $pollDetail['formbg'] = '#FDF000';
$retval = $api->pollCreate($pollDetail);
if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "New Poll ID:". $retval ."\n";
}
?>
