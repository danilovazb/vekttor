<?
$id=$_POST[id];
$id=$_GET[id];
if($_POST[acao]=='Salvar'){
	ContaFixa($_POST[id],$_POST[internauta_id],$_POST[descricao],moedaBrToUsa($_POST[valor]),$_POST[centro_custo_id],$_POST[plano_conta_id],$_POST[dia_vencimento]);
}
if($_POST[acao]=='Excluir'){
	ExcluirContaFixa($_POST[id]);
}
if($id>0){
	
	$conta=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_contas_fixas WHERE id='$id'"));
	$cliente=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$conta->fornecedor_id."' LIMIT 1"));
}
?>