<?php
/**
This Example shows how to get Get the event Ticket
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

$retval = $api->ticketGetByID("12513","4220");

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {


  echo sizeof($retval)." Events Returned:\n";
  /*
  echo "<table>";
  echo "<tr><td>Ticket Item id</td><td> Ticket Id</td><td> Event Id </td><td> Event Fee Id </td><td> Ticket Quantity </td><td> Checkin Quantity </td>";
  echo "<td> Price </td><td> Feelable </td><td> status </td><td> Discount Amount </td><td> Discount Percentage </td><td> Charges </td><td> Firstname </td><td> Lastname </td><td> Email </td></tr>";
  foreach($retval as $eventData){
    echo "<tr>";
    echo "<td>".$eventData['ticketitemID']."</td><td>".$eventData['ticketID']."</td>";
    echo "<td>".$eventData['eventID']."</td><td>".$eventData['eventfeeID']."</td>";
    echo "<td>".$eventData['ticketqty']."</td><td>".$eventData['checkinqty']."</td>";
    echo "<td>".$eventData['price']."</td>";
    echo "<td>".$eventData['feelabel']."</td><td>".$eventData['status']."</td>";
    echo "<td>".$eventData['discountamt']."</td><td>".$eventData['discountperc']."</td>";
    echo "<td>".$eventData['charges']."</td><td>".$eventData['firstname']."</td>";
    echo "<td>".$eventData['lastname']."</td><td>".$eventData['email']."</td>";
    echo "</tr>";
  }
  echo "</table>";
  */
  echo "<table>";
  echo "<tr><td>Serail</td><td>Ticket Item id</td><td> Ticket Id</td><td> Event Id </td><td> Event Fee Id </td><td> Ticket Quantity </td><td> Checkin Quantity </td>";
  echo "<td> Price </td><td> Feelable </td><td> status </td><td> Discount Amount </td><td> Discount Percentage </td><td> Charges </td><td> Firstname </td><td> Lastname </td><td> Email </td></tr>";
  	  foreach($retval as $k=>$v)
  	  {
  	  	echo("<tr>");
  		if ( !is_array($v) )
  			{
  			   echo "<td>" . $k . "</td><td>" . $v ."</td>";
  			}
  			else
  			{
  			  foreach($v as $key=>$val)
			  {
			    if ( !is_array($val) )
			    			{
			    			   echo "<td>" . $val ."</td>";
			    			}
			    			else
			    			{
			    			   echo "<td>" . print_r($val) ."</td>";
			    			}
  	  		   }

  			}
  			echo("</tr>");
  	  }
	     echo "</table>";
}
?>



