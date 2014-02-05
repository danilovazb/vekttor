<?php
	
	include("../../../_config.php");
	
	$vkt_id='169';
	$emails = mysql_query($t="SELECT email FROM eleitoral_eleitores WHERE vkt_id='$vkt_id'  AND recebe_email='sim' AND email like '%hotmail%'  AND email LIKE '%@%.%'");
	$info[] = strtoupper("Email\n");
	while($email=mysql_fetch_object($emails)){
		
		$info[] = strtoupper("$email->email,\n");	
		
	 }
	 
	$infos = implode("",$info);
	
	$file = "email_hotmail.csv";
	@unlink("$file");
	$handle = fopen($file, 'a');
	fwrite($handle,$infos);
	fclose($handle);

	$i =date("Ymdhis");
	echo "<script>location='$file?$i'</script>";
	exit();					
?> 