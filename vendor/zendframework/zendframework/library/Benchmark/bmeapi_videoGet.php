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

	$retval = $api->videoGetList(1, 10);
	$videoID=$retval[0]['id'];
	$videoData=array();
	$videoData=$api->videoGet($videoID);




if ( !$videoData )
{
	echo "Error!";
	echo "\n\tCode=".$api->errorCode;
	echo "\n\tMsg=".$api->errorMessage."\n";
}
else
{
	echo($videoData['sequence'].".)Videos:)".$videoData['client_videos']);
	echo("VideosDescription:)".$videoData['video_description']);
	echo("VideosEmbed:)".$videoData['video_embed']);
	echo("VideoHeight:)".$imgData['video_height']);
}
?>
