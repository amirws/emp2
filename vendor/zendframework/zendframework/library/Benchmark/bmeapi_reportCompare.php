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
$campaignList = $api->reportGet("", 1, 10, "", "");
$emailIDs=$campaignList[0]['id'].",".$campaignList[1]['id'].",".$campaignList[2]['id'];
$retval = $api->reportCompare($emailIDs);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo "<table>";
  foreach($retval as $k=>$v) {
    if ( !is_array($v) )
		    {
		       echo "<tr><td>" . $k . "</td><td>" . $v ."</td></tr>";
			}
			else
	        {
		       echo "<tr><td>" . $k . "</td><td>" . print_r($v) ."</td></tr>";
		};
  }
  echo "</table>";
}
?>
