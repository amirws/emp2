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

$retval = $api->eventGet("12513");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {

  //print_r ($retval);
  //echo sizeof($retval)." Events Returned:\n";

  echo "<table>";
  echo "<tr><td>Event ID</td><td>Event Name </td><td> status</td><td> venue </td><td> location </td><td> ispublic </td><td> repeat </td><td> timezone </td><td> contactname </td>";
  echo "<td> contactemail </td><td> contactphone </td><td> contactorganization </td><td> eventurl </td><td> Start date : End Date </td><td>Ticket details</td></tr>";



    echo "<tr>";
    echo "<td>".$retval['eventid']."</td><td>".$retval['eventname']."</td>";
    echo "<td>".$retval['status']."</td><td>".$retval['venue']."</td>";
    echo "<td>".$retval['location']."</td><td>".$retval['ispublic']."</td>";
    echo "<td>".$retval['repeat']."</td>";
    echo "<td>".$retval['timezone']."</td><td>".$retval['contactname']."</td>";
    echo "<td>".$retval['contactemail']."</td><td>".$retval['contactphone']."</td>";
    echo "<td>".$retval['contactorganization']."</td><td>".$retval['eventurl']."</td>";
    foreach($retval['dates'] as $key => $val)
    {
    	echo "<td>".$val['startdate'] . " " .  $val['enddate']."</td>";

    }
    foreach($retval['tickets'] as $key => $val)
    {
    	echo "<td>id -".$val['id'] . "label -" .  $val['label'] . " Price - " .  $val['price']. " Order - " .  $val['order']. " Ticket Type -" .  $val['ticketType']. " Quantity -" .  $val['qty']. "  Sold -" .  $val['sold']. " Attendee count -" .  $val['attendeeCount']."</td>";


    }

    echo "</tr>";


  echo "</table>";
}
?>



