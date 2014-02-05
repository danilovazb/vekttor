<?
/*
*	Ricardo Monteiro e Lima
*	08/10/13
*/
function manipulaFormaPagamento($dados){
	global $vkt_id;
	if($dados['id']>0){
		$inicio_query="UPDATE ";	
		$fim_query=" WHERE id='{$dados['id']}'";
	}else{
		$inicio_query="INSERT INTO ";
		$fim_query="";	
	}
	
	$nome=$dados['nome'];
	$valor_percentual=moedaBrToUsa($dados['valor_percentual']);
	$valor_fixo=moedaBrToUsa($dados['valor_fixo']);
	$prazo_efetivacao=$dados['prazo_efetivacao'];
	$plano_conta_id=$dados['plano_conta_id'];
	$centro_custo_id=$dados['centro_custo_id'];
	$obs=$dados['obs'];
	$forma_pagamento_id=$dados['forma_pagamento_id'];
	
	$query="
	$inicio_query financeiro_formas_pagamento 
	SET 
		nome				='$nome', 
		prazo_efetivacao	='$prazo_efetivacao', 
		valor_percentual	='$valor_percentual', 
		valor_fixo			='$valor_fixo', 
		plano_conta_id		='$plano_conta_id', 
		centro_custo_id		='$centro_custo_id', 
		obs					='$obs', 
		forma_pagamento_id	='$forma_pagamento_id' ,
		vkt_id				='$vkt_id' 
	$fim_query";
	mysql_query($query);
	
}

function excluirFormaPagamento($forma_pagamento_id){
	global $vkt_id;
	$excluiu=mysql_query($a="DELETE FROM financeiro_formas_pagamento WHERE id='$forma_pagamento_id' AND vkt_id='$vkt_id'");
	return $excluiu;
}
