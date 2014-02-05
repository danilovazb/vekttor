<?

function insere_tipo_atividade($campos){
	global $vkt_id;
	
	mysql_query("
			INSERT INTO projetos_atividades_tipos SET
			vkt_id=' $vkt_id',
			nome='{$campos[nome]}'
	
	");
	
}


function altera_tipo_atividade($campos){
	global $vkt_id;
	
	mysql_query("
			UPDATE projetos_atividades_tipos SET
				vkt_id=' $vkt_id',
				nome='{$campos[nome]}'
			WHERE
				id='{$campos[id]}'
	");
	
}

function deletar_tipo_atividade($id){
	mysql_query("
			DELETE FROM 
				projetos_atividades_tipos
			WHERE
				id='$id'
	");
}

?>