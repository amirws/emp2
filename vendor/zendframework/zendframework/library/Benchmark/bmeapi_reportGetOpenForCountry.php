<?php
/**
Get the email addresses which were opened in a given campaign,using the paging limits, ordered by the email or date of the opened record.
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
$campaignDetail=$api->reportGet("", 1,2, "", "");
$emailID=$campaignDetail[0]['id'];
$emailID="2503";
$countryData=$api->reportGetOpenCountry($emailID);
$CountryCode=$countryData[98]['country_region'];

$retval = $api->reportGetOpenForCountry($emailID,$CountryCode);

if (!$retval){
  echo "Error!";
  echo "\n\tCode=".$api->errorCode;
  echo "\n\tMsg=".$api->errorMessage."\n";
} else {
  echo sizeof($retval)." Records Returned:\n";
  echo "<table border=1>";
  echo "<tr><td>  </td><td> CountryRegionCode </td><td> State </td><td> Open Count </td></tr>";
  foreach($retval as $reportData){
    echo "<tr>";
    echo "<td>".$reportData['sequence']."</td><td>".$reportData['country_name']."</td>";
    echo "<td> ".$reportData['country_region']."</td><td> &nbsp;".$reportData['openCount']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
?>
