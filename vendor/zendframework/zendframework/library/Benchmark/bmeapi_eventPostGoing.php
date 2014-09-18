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

$retval = $api->eventPostGoing("", "", "", "", "");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {

  echo sizeof($retval)." Events Returned:\n";
  print_r ($retval);
  echo "<table>";
    echo "<tr><td> ID </td><td> CODE </td>";
    echo "</tr>";
    foreach($retval as $eventData){
      echo "<tr>";
      echo "<td>".$eventData['id']."</td><td>".$eventData['code']."</td>";
      echo "</tr>";
    }
  echo "</table>";

}
?>



