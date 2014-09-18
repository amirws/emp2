<?php

	function Get_Iframe_Url()
	{
		$encoded_url="https://facebook.benchmarkemail.com/asp/subscriber_add_general.php?";
		foreach($_POST as $name=>$value){
		$encoded_url .= urlencode($name).'='.urlencode($value).'&';
		}
		foreach($_GET as $name => $value) {
		  $encoded_url .= urlencode($name).'='.urlencode($value).'&';
		}
		$encoded_url=substr($encoded_url,0,strlen($encoded_url)-1);

		return($encoded_url);
	}

?>
