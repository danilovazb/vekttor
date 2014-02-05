<?php
function __autoload($classe){
	   require_once "control/{$classe}.class.php";	   
}

	$sms    = new EnviaSMS;
	$config = new Config;
	
?>
