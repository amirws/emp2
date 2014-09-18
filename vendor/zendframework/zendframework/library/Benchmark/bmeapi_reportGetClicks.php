<?php
/**
Get the click URL stats for the given campaign.
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

$retval = $api->reportGetClicks($emailID);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Clicks Returned:\n";
  echo "<table border=1>";
  echo "<tr><td>  </td><td>URL </td><td> Clicks </td><td> Percent </td></tr>";
  foreach($retval as $reportData){
    echo "<tr>";
    echo "<td>".$reportData['sequence']."</td><td>".$reportData['URL']."</td>";
    echo "<td> ".$reportData['clicks']."</td><td> ".$reportData['percent']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
