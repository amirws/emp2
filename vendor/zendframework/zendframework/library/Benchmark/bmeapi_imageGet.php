<?php
/**
This Example shows how to get details of an existing video
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

$retval = $api->imageGetList(1, 10);
$imgID=$retval[0]['id'];
$imgData=array();
$imgData=$api->imageGet($imgID);



if ( !$imgData )
{
	echo "Error!";
	echo "\n\tCode=".$api->errorCode;
	echo "\n\tMsg=".$api->errorMessage."\n";
}
else
{
	echo("Image Name:)".$imgData['image_name']);
	echo("image_size:)".$imgData['image_size']);
	echo("image_url:)".$imgData['image_url']);
	echo("image_height:)".$imgData['image_height']);
}
?>
