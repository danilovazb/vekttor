<?php
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");

	call_user_func_array($_POST["funcao"],array($_POST));
	
	function CancelarItemParcela($dados){
		$sql = " UPDATE ".PARCELA." SET status = '3' WHERE id = '".$dados["id"]."' ";
		mysql_query($sql);
	}
	
	function calculaDataParcela($dados){
		
		$data_split=explode("/",$dados["dataParcela"]);
		
		$contador = $dados["contador"];
		
		$data_venc = mysql_result(mysql_query($q="SELECT DATE_FORMAT( DATE_ADD('{$data_split[2]}-{$data_split[1]}-{$data_split[0]}', INTERVAL {$contador} MONTH ),'%Y-%m-%d')"),0,0);
		
		echo dataUsaToBr($data_venc);
	}