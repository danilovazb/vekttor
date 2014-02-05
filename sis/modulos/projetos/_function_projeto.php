<?

function insere_projeto($campos){
	global $vkt_id;
	
	mysql_query("
			INSERT INTO projetos SET
			vkt_id=' $vkt_id',
			cliente_fornecedor_id = '{$campos[cliente_fornecedor_id]}',
			nome      = '{$campos[nome_projeto]}',
			descricao = '{$campos[descricao]}',
			tempo     = '{$campos[tempo]}',
			data_limite = '".dataBrToUsa($campos[data_limite])."',
			status ='{$campos[status]}'
	");
	
}


function altera_projeto($campos){
	global $vkt_id;
	
	mysql_query($trace="
			UPDATE projetos SET
				vkt_id=' $vkt_id',
			cliente_fornecedor_id = '{$campos[cliente_fornecedor_id]}',
			nome      = '{$campos[nome_projeto]}',
			descricao = '{$campos[descricao]}',
			tempo     = '{$campos[tempo]}:00:00',
			data_limite = '".dataBrToUsa($campos[data_limite])."',
			status ='{$campos[status]}'

			WHERE
				id='{$campos[id]}'
	");
	
}

function deletar_projeto($id){
			
	
	mysql_query("
			DELETE FROM 
				projetos
			WHERE
				id='$id'
	");
	
}



?>