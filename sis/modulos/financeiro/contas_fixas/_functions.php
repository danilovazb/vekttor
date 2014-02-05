<?

function ContaFixa($id,$fornecedor_id,$descricao,$valor,$centro_custo_id,$plano_conta_id,$dia_vencimento){
	global $vkt_id;
	$tabela="financeiro_contas_fixas";
	if($id!=''){$acao='UPDATE '; $sql_final=" WHERE id='$id' ";}else{$acao='INSERT INTO ';}
	$sql=mysql_query(
	"
	$acao 
	$tabela 
	SET vkt_id='$vkt_id',
	fornecedor_id='$fornecedor_id', descricao='$descricao', valor='$valor', centro_custo_id='$centro_custo_id',
	plano_conta_id='$plano_conta_id',dia_vencimento='$dia_vencimento'
	$sql_final
	");
}

function ExcluirContaFixa($id){
	$sql=mysql_query("DELETE FROM financeiro_contas_fixas WHERE id='$id'");
}

?>