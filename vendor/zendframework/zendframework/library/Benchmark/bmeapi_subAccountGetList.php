<?php
/**
This example shows how to get the List of Subaccounts for your account
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

$retval = $api->subAccountGetList();

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Subaccounts Returned:\n";
  echo "<table>";

  foreach($retval as $cltData){
    echo "<tr>";
    echo "<td>".$cltData['firstname']."</td><td>".$cltData['lastname']."</td>";
    echo "<td>".$cltData['clientid']."</td><td>".$cltData['login']."</td>";
    echo "<td>".$cltData['plan_email_limit']."</td><td>".$cltData['free_mail_sent']."</td>";
    echo "<td>".$cltData['active']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
