<?php
/**
This Example shows how to get the list of existing Autoresponders
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

$retval = $api->autoresponderGetList ( 1, 5, "","","", "");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Autoresponders Returned:\n";
  echo "<table>";
  echo "<tr><td> ID</td><td>Autoresponder Name </td><td> Total emails </td><td> Status </td>";
  echo "<td> Modified Date</td></tr>";
  foreach($retval as $autoresponderData)
  {
    echo "<tr>";
    echo " <td>".$autoresponderData['id']."</td><td>".$autoresponderData['autorespondername']."</td>";
    echo " <td>".$autoresponderData['totalemails']."</td><td>".$autoresponderData['status']."</td>";
    echo " <td>".$autoresponderData['modifieddate']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
