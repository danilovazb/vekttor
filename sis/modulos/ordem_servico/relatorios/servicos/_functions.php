<?php
function manipulaServico($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio servico SET
		vkt_id='$vkt_id',
		nome='$dados[descricao]',
		und='$dados[unidade]',
		valor_normal='".moedaBrToUsa($dados[vl_normal])."',
		valor_colaborador='".moedaBrToUsa($dados[vl_colaborador])."',
		tempo_execucao='$dados[tempo_execucao]',
		observacao='$dados[obs]'
		$fim");
		//echo $t."<br>";
		
}

function excluiServico($_POST,$vkt_id){
	$t=mysql_query("DELETE FROM servico WHERE id='$_POST[id]'");
}
?>