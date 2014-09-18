<?php
/**
Get the list of sent campaign using the filter and paging limits, ordered by the name or date of the campaign.
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

$retval = $api->reportGet("", 1, 50, "", "");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Reports Returned:\n";
  echo "<table border=1>";
  echo "<tr><td>  </td><td>Email ID</td><td> Name </td><td> Is Segment </td>";
  echo "<td> To List ID</td> <td> List Name </td> <td> Status </td>";
  echo "<td> Created Date</td> <td> Modified Date</td></tr>";
  foreach($retval as $reportData){
    echo "<tr>";
    echo "<td>".$reportData['sequence']."</td><td>".$reportData['id']."</td>";
    echo "<td> ".$reportData['emailName']."</td><td> ".$reportData['isSegment']."</td>";
    echo "<td> ".$reportData['toListID']."</td><td>".$reportData['toListName']."</td>";
    echo "<td> ".$reportData['status']."</td>";
    echo "<td> ".$reportData['createdDate']."</td><td> ".$reportData['modifiedDate']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
