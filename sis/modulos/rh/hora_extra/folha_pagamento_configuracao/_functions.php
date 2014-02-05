<?

function manipularConfiguracaoFolhaPonto($dados){
	global $vkt_id;
	$id=$dados['id'];
	if($id>0){
		$sql_inicio=" UPDATE ";
		$sql_fim=" WHERE id = '$id' ";
	}else{
		$sql_inicio=" INSERT INTO ";
		$sql_fim="";
	}
	$sql="
	$sql_inicio 
		rh_folha_ponto_configuracao 
	SET 
		vkt_id='$vkt_id', 
		empresa_id='{$dados['empresa_id']}', 
		dia_abertura='{$dados['dia_abertura_folha']}', 
		semana_inicio='{$dados['semana_inicio']}', 
		recibo_hora_extra='{$dados['recibo_hora_extra']}' 
	$sql_fim";
	//echo $sql."<br>";
	mysql_query($sql);echo mysql_error();
}

function deletarConfiguracaoFolhaPonto($id){
	mysql_query("DELETE FROM rh_folha_ponto_configuracao WHERE vkt_id='$vkt_id' AND id='$id'");
}