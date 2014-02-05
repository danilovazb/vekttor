<?php
	function trataTxt($var) {

	$var = strtolower($var);
	
	$var = preg_replace("[����]","a",$var);	
	$var = preg_replace("[���]","e",$var);	
	$var = preg_replace("[�]","e",$var);	
	$var = preg_replace("[�����]","o",$var);	
	$var = preg_replace("[����]","u",$var);	
	$var = str_replace("�","c",$var);
	$var = str_replace("/","",$var);
	$var = str_replace("-","",$var);
	$var = str_replace(".","",$var);
	$var = str_replace(",","",$var);
	return $var;
}

function formata_cnpj($cnpj){
	$cnpj = str_replace("/","",$cnpj);
	$cnpj = str_replace(".","",$cnpj);
	$cnpj = str_replace("-","",$cnpj);

	return $cnpj;
}

function formata_campo($campo,$tamanho,$string,$posicao){
	//echo $posicao;
	if(strlen($campo)<$tamanho){
		$campo = str_pad($campo,$tamanho,$string,$posicao);
	}
	
	if(strlen($campo)>$tamanho){
		$campo = substr($campo,0,$tamanho);
	}
	return $campo;
}

//consulta o sal�rio do indiv�duo
function consulta_salario($funcionario_id){
	global $vkt_id;
	
	
	//consulta se houve altera��o no sal�rio
	$salario = mysql_fetch_object(mysql_query("SELECT id,salario FROM rh_alteracao_salario WHERE funcionario_id = '$funcionario_id' AND vkt_id='$vkt_id'"));

	if($salario->id<=0){
		$salario = mysql_fetch_object(mysql_query("SELECT id,salario FROM rh_funcionario WHERE id = '$funcionario_id' AND vkt_id='$vkt_id'"));	
	}
	
	$centavos = explode(",",$salario->salario);
	
	if(sizeof($centavos)>1){
		$salario = $salario->salario;
	}else{
		$salario = $salario->salario."00";
	}
	
	return $salario;
}

?>