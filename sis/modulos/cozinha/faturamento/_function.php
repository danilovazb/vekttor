<?
session_start();

function insere_faturamento($campos){
	global $vkt_id;
			
			$data_ini = dataBrToUsa($campos['data_inicio']);
			$data_fim = dataBrToUsa($campos['data_fim']);
			$valor    = moedaBrToUsa($campos['valor']);
			
		$sql=mysql_query(" INSERT INTO cozinha_faturamento
					SET
						vkt_id      = '$vkt_id',
						contrato_id = '$campos[contrato_id]',
						nota_fiscal = '$campos[nota_fiscal]',
						descricao   = '$campos[descricao]',
						data_inicio = '$data_ini',
						data_fim    = '$data_fim',
						vencimento  = '$campos[vencimento]',
						valor       = '$campos[valor]' 
		");
		//echo $sql;
	
}

function deletar_faturamento($id){
	mysql_query("
			DELETE FROM 
				cozinha_faturamento
			WHERE
				id='$id'
	");
}

function altera_faturamento($campos){
		
		global $vkt_id;
		
		$data_ini = dataBrToUsa($campos['data_inicio']);
		$data_fim = dataBrToUsa($campos['data_fim']);
		$valor    = moedaBrToUsa($campos['valor']);
		
		$sql=mysql_query(" UPDATE cozinha_faturamento
					SET
						vkt_id      = '$vkt_id',
						contrato_id = '$campos[contrato_id]',
						data_inicio = '$data_ini',
						data_fim    = '$data_fim',
						vencimento  = '$campos[vencimento]',
						valor       = '$valor'
					WHERE id = $campos[id] 
		");
		//echo $sql;
		
}

?>