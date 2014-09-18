<?php
/**
Get the signup forms in your account.
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

$retval = $api->listGetSignupForms(1, 10, "","asc");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Signup Forms Returned:\n";
  echo "<table>";
  echo "<tr><td>  </td><td>List ID</td><td> Name </td><td> List Name</td> </tr>";
  foreach($retval as $listData){
    echo "<tr>";
    echo "<td>".$listData['sequence']."</td><td>".$listData['id']."</td>";
    echo "<td>".$listData['name']."</td><td>".$listData['listname']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
