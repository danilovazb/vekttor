<?php
include("../../../_config.php");
	
	$sexo = $_POST["sexo"];
	$id   = $_POST["id"];
	//echo "chegou aqui";
	
	$sql= mysql_query($r=" UPDATE eleitoral_eleitores SET sexo = '$sexo' WHERE vkt_id = '$vkt_id' AND id = '$id' ");
	echo $r;

?>