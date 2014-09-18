<?php
/**
Update the given contact in the list based on the details provided.
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

$contactID = 64755432;
$detail["email"] = "merlin@invaliddomain.moc";
$detail["firstname"] = "Merlin";

$retval = $api->listUpdateContactDetails($contactListID, $contactID, $detail);

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
