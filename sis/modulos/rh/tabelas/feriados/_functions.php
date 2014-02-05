<?php

function manipulaFeriado($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE"; $fim="WHERE id='$dados[id]'";
	}
	list($dia,$mes) = explode("/",$dados['dia_mes']);
	
	mysql_query($t="
	$inicio 
		rh_feriado SET
			vkt_id='$vkt_id',
			nome = '{$dados[nome]}',
			dia = '$dia',
			mes = '$mes'		
		$fim");
	//echo mysql_error()." ".$t;
}

function excluiFeriado($pst,$vkt_id){
	mysql_query("DELETE FROM rh_feriado WHERE id='{$pst[id]}'");
}
?>