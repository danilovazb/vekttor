<?php
function manipulaINSS($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio rh_inss SET
		valor_minimo='".MoedaBrToUsa($dados[menor_salario])."',
		valor_maximo='".MoedaBrToUsa($dados[maior_salario])."',	
		valor_beneficio='".MoedaBrToUsa($dados[valor_beneficio])."'	
		$fim");
	//echo $t." ".mysql_error();
}

function excluiinss($dados){
	mysql_query("DELETE FROM rh_inss WHERE id='$dados[id]'");
} 

function soma_horas($hora1="00:00",$hora2="00:00"){
	$min_hora_1 = substr($hora1,-2,2);
	$hora_hora_1 = substr($hora1,0,2);
	$min_hora_2 = substr($hora2,-2,2);
	$hora_hora_2 = substr($hora2,0,2);
	$minutos_totais = $min_hora_1+$min_hora_2;
	$hora_em_minutos = floor($minutos_totais/60);
	
	$minutos_restantes = ($minutos_totais%60);
	if($minutos_restantes<10){
		$minutos_restantes="0".$minutos_restantes;
	}
	$hora_total = $hora_hora_1 + $hora_hora_2 + $hora_em_minutos;
	if($hora_total<10){
		$hora_total="0".$hora_total;
	}
	return $hora_total.":".$minutos_restantes;
}

function atualiza_horas($dados){

	global $vkt_id;
	
	$horas_noturnas = explode(":",$dados['horas_noturnas']);
	$horas_noturnas = ($horas_noturnas[0]*60*60)+($horas_noturnas[1]*60);
	
	$hora_extra = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_hora_extra WHERE empresa_id='$dados[empresa_id]' AND funcionario_id='$dados[funcionario_id]' AND data='".DataBrToUsa($dados[data_hora_extra])."' AND vkt_id='$vkt_id'"));

	if($hora_extra->id>0){
		$sql_inicio = "UPDATE";
		$sql_fim    = "WHERE id=".$hora_extra->id;	
	}else{
		$sql_inicio = "INSERT INTO";
		$sql_fim    = "";
	}
	
	mysql_query($t="$sql_inicio rh_hora_extra SET vkt_id='$vkt_id', empresa_id='$dados[empresa_id]', funcionario_id='$dados[funcionario_id]', data='".DataBrToUsa($dados[data_hora_extra])."',
	hora_extra50='$dados[horas_50]',hora_extra_100='$dados[horas_100]', adicional_noturno='$horas_noturnas' $sql_fim");
	echo mysql_error();
}
function decimal_hora($hora){
	$hora =$hora*60*60;
	$horas=mysql_result(mq("SELECT SEC_TO_TIME($hora)"),0,0);
	return substr($horas,0,5);
}

function hora_decimal($hora){
	$horas=mysql_result(mq("SELECT TIME_TO_SEC('$hora')"),0,0);
	$horas =$horas/60/60;
	
	return qtdUsaToBr($horas,$limitador=2);
}
?>