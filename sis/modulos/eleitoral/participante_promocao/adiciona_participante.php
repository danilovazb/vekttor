<?php
	
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");

global $vkt_id;

$promocao_id = $_POST['promocao_id'];
$participante_id = $_POST['promocao_id'];
	
$verifica_existencia = mysql_fetch_object(mysql_query($t="SELECT * FROM eleitoral_participante_promocao WHERE eleitor_id='$participante_id' AND promocao_id='$promocao_id' AND vkt_id='$vkt_id'"));
if($verifica_existencia->id<0){	
	mysql_query($t="INSERT INTO eleitoral_participante_promocao SET vkt_id='$vkt_id', eleitor_id='$participante_id', promocao_id='$promocao_id'");	
	
}
echo $t;
?>