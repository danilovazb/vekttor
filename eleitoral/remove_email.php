<?
	include("../sis/_config.php");
	$file = file("emails.csv");
	$file = explode("\r",$file[0]);
	$cont=count($file);
	echo $cont;
	//print_r($file);
	for($l=0;$l<$cont;$l++){
		$linha = $file[$l]; 
		mysql_query($t="DELETE FROM eleitoral_eleitores WHERE email='$linha'");
		echo $t."<br>";
	}
?>