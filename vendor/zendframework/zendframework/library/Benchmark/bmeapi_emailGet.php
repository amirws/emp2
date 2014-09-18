<?php
/**
This Example shows how to get the list of existing Emails
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

$retval = $api->emailGet("", -1, 1, 5, "", "");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Emails Returned:\n";
  echo "<table>";
  echo "<tr><td>Email ID</td><td> Name </td><td> From Name </td><td> Subject </td><td> List ID </td><td> List Name </td>";
  echo "<td> Status </td><td> Created Date</td> <td> Modified Date</td></tr>";
  foreach($retval as $emailData){
    echo "<tr>";
    echo "<td>".$emailData['id']."</td><td>".$emailData['emailName']."</td>";
    echo "<td>".$emailData['fromName']."</td><td>".$emailData['subject']."</td>";
    echo "<td>".$emailData['toListID']."</td><td>".$emailData['toListName']."</td>";
    echo "<td>".$emailData['status']."</td>";
    echo "<td>".$emailData['createdDate']."</td><td>".$emailData['modifiedDate']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
