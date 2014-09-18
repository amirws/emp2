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

$retval = $api->confirmEmailList();



if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
   
} else {
  echo sizeof($retval)." Confirmed Emails Returned:\n";
  echo "<table>";
  echo "<tr><td> </td><td>Sequence</td><td> id </td><td> email </td>";
  echo "<td> confirmed </td> <td> createddate </td>  <td> modifieddate </td> </tr>";
  
  foreach($retval as $listData)
  {
    echo "<tr>";
    echo "<td>".$listData['sequence']."</td><td>".$listData['id']."</td>";
	echo "<td>".$listData['email']."</td>";
    echo "<td>".$listData['confirmed']."</td><td>".$listData['createddate']."</td>";
    echo "<td>".$listData['modifieddate']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
