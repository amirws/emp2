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
  echo "<table>";
  echo "<tr><td>  </td><td>Criteria ID</td><td>Segment ID </td><td> Field </td><td> Filter </td><td> Filter Type</td> <td> Start Date</td> <td> End Date</td></tr>";
  foreach($retval as $listData){
    echo "<tr>";
    echo "<td>".$listData['sequence']."</td><td>".$listData['id']."</td>";
    echo "<td>".$listData['segmentid']."</td><td>".$listData['field']."</td><td>".$listData['filter']."</td>";
    echo "<td>".$listData['filtertype']."</td><td>".$listData['startdate']."</td><td>".$listData['enddate']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
