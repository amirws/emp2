<?php
/**
Get the contact lists in your account.
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

$retval = $api->listGet("", 1, 10, "", "");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Lists Returned:\n";
  echo "<table>";
  echo "<tr><td>  </td><td>List ID</td><td> Name </td><td> Count </td>";
  echo "<td> Created Date</td> <td> Modified Date</td></tr>";
  foreach($retval as $listData){
    echo "<tr>";
    echo "<td>".$listData['sequence']."</td><td>".$listData['id']."</td>";
    echo "<td>".$listData['listname']."</td><td>".$listData['contactcount']."</td>";
    echo "<td>".$listData['createdDate']."</td><td>".$listData['modifiedDate']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
