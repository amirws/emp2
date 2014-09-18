<?php
/**
Get the contacts from the contact list.
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

$retval = $api->segmentGet("", 1, 1, "");
foreach($retval as $listData){
    $segmentID = $listData['id'];
}

$retval = $api->segmentGetCriteriaList($segmentID);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Criteria Returned:\n";
  foreach($retval as $listData){
    $criteriaID = $listData['id'];
  }

  $api->segmentDeleteCriteria($segmentID, $criteriaID);
}
?>
