<?php
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");
			
	$sql = mysql_query($t1=" UPDATE contrato SET situacao = '".$_GET['status']."', data_fechamento=NOW() WHERE id = '".$_GET['contrato_id']."'");
	$sql = mysql_query($t2=" UPDATE disponibilidade SET situacao = '".$_GET['status']."' WHERE id = '".$_GET['disponibilidade_id']."'");
		
		if($sql){
			alert("$t1 $t2");
		}