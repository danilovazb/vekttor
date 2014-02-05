<?
function manipulaConfiguracaoReserva($dados){
	global $vkt_id;
	if($dados['id']>0){
		$sql_inicio="UPDATE ";
		$sql_fim="WHERE id='{$dados['id']}'";
	}else{
		$sql_inicio="INSERT INTO ";
	}
	$sql="
	$sql_inicio
		campo_futebol_reserva_config_pagamento
	SET
		vkt_id='$vkt_id',
		conta_id='{$dados['conta_id']}',
		plano_conta_id='{$dados['plano_conta_id']}',
		centro_custo_id='{$dados['centro_custo_id']}'
	 $sql_fim";
	 return mysql_query($sql);
}

function deletaConfiguracaoReserva($id){
	return mysql_query("DELETE FROM campo_futebol_reserva_config_pagamento WHERE id='$id'");
	
}