<?php
require_once'inc/BMEAPI.class.php';
require_once'inc/config.php';

$api=new BMEAPI($username,$password,$apiURL);
if($api->errorCode){
echo"Code:".$api->errorCode."\n";
echo"Msg:".$api->errorMessage."\n";
die();
}
$surveyList=$api->surveyGetList("","1",1,10,"","");
$surveyID=$surveyList[0]['id'];
$surveyColor=$api->surveyGetColor($surveyID);

echo $rec['surveyid'] . "]: Survey ID, AnswerFont :" . $rec['answerfont'] . "<br>Answersize".$rec['answersize'];
      echo "\t buttonalign:" . $rec['buttonalign'] . " ButtonText " . $rec['buttontext'] . " Form BackGround " . $rec['formbg'];
      echo "<br />";
      
?>