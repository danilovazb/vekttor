<?php
function cadastroCobranca($dados){
	
	global $vkt_id;
	//seleciona todas as empresas
	$empresas = mysql_query($t="
	SELECT 
		cf.valor_mensalidade, re.* 
	FROM 
		rh_empresas re,
		cliente_fornecedor cf	
	WHERE
		re.cliente_fornecedor_id = cf.id AND 
		cf.valor_mensalidade > 0 AND
		vkt_id='$vkt_id'");
	//echo $t."<br>";
	//"percorre" as empresas
	while($cliente_fornecedor = mysql_fetch_object($empresas)){
		
		//verifica se já há uma cobrança para esta empresa nesta data
		$ha_cobranca = mysql_query($t="
		SELECT 
			* 
		FROM 
			rh_cobranca_empresas 
		WHERE
			vkt_id='$vkt_id' AND 
			cliente_fornecedor_id='$cliente_fornecedor->cliente_fornecedor_id' AND 
			data_vencimento = '".DataBrToUsa($dados['data_vencimento']).
		"'");
		//echo $t."<br>";
		if(mysql_num_rows($ha_cobranca)<=0){
			mysql_query($t="
			INSERT INTO
				rh_cobranca_empresas
			SET
				vkt_id='$vkt_id',
				data_vencimento = '".DataBrToUsa($dados['data_vencimento'])."',
				cliente_fornecedor_id='$cliente_fornecedor->cliente_fornecedor_id',
				empresa_id='$cliente_fornecedor->id',
				descricao ='$dados[descricao]',
				valor='$cliente_fornecedor->valor_mensalidade', 	
				situacao='0'							
			 ");
			// echo $t." ".mysql_error()."<br>";
		}
	}
	
	//echo $t;
}

function atualizaCobranca($dados){
	
	global $vkt_id;
	//seleciona todas as empresas
	
	if($dados['confirma_pagamento']=='on'){
		$situacao_pagamento=" ,situacao='1', data_pagamento='".DataBrToUsa($dados['data_pagamento'])."'";
	}
	
	mysql_query($t="
		UPDATE 
			rh_cobranca_empresas
		SET
			vkt_id='$vkt_id',
			data_vencimento = '".DataBrToUsa($dados['data_vencimento'])."',
			descricao ='$dados[descricao]',
			valor='".MoedaBrToUsa($dados[valor])."'			
			$situacao_pagamento
			
		WHERE 
			id='$dados[id]' 	
										
	");
	echo mysql_error();
	//echo $t;
}

function excluiCobranca($id){
	mysql_query($t="DELETE FROM rh_cobranca_empresas WHERE id=$id");
	//echo $t;
}

function mes($mes){
	
	switch($mes){
		case '01': $mes="Janeiro";break;
		case '02': $mes="Fevereiro";break;
		case '03': $mes="Março";break;
		case '04': $mes="Abril";break;
		case '05': $mes="Maio";break;
		case '06': $mes="Junho";break;
		case '07': $mes="Julho";break;
		case '08': $mes="Agosto";break;
		case '09': $mes="Setembro";break;
		case '10': $mes="Outubro";break;
		case '11': $mes="Novembro";break;
		case '12': $mes="Dezembro";break;
		
		
	}
	
	echo $mes;
}

/*function excluiCargosSalarios($_POST,$vkt_id){
	mysql_query("DELETE FROM cargo_salario WHERE id='$_POST[id]'");
}*/
?>