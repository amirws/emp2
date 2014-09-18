<?php
/**
Get the email statistics for a campaign
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

$retval = $api->reportGetSummary($emailID);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "<table>";
  foreach($retval as $k=>$v) {
    echo "<tr><td><b>" . $k . "</b></td><td>" . $v ."</td></tr>";
  }
  echo "</table>";
}
?>
