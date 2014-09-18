<?php
/**
This Example shows how to get the list of existing Events
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

$retval = $api->eventGetTicketType("12513");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {

  echo sizeof($retval)." Events Returned:\n";

  echo "<table>";
  echo "<tr><td>ID</td><td> Label </td><td> Price </td><td> Order </td><td> Absorb </td>";
  echo "</tr>";
  foreach($retval as $eventData){
    echo "<tr>";
    echo "<td>".$eventData['id']."</td><td>".$eventData['label']."</td>";
    echo "<td>".$eventData['price']."</td><td>".$eventData['order']."</td>";
    echo "<td>".$eventData['absorb']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>



