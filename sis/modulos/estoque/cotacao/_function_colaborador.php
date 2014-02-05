<?
session_start();

function altera_colaborador($campos){
	global $vkt_id;
	
		if(($campos[rd])){
				altera_situacao($campos);
		}
		
		else{
			
		if(!isset($campos[tempo_gasto])){
				$campos[tempo_gasto] = '00:00:00';
		}
		//------------------------------------
		if(isset($campos[data_fim]) && $campos[hora_fim]){
			$dataHora = dataBrToUsa($campos[data_fim])." ".$campos[hora_fim];
		}
		else{
			$dataHora = '0000-00-00 00:00:00';
		}
		
		//------------------------------------
		if(isset($campos[data_inicio]) && $campos[hora_inicio]){
			$dataHoraInicio = dataBrToUsa($campos[data_inicio])." ".$campos[hora_inicio];
		}else{
			$dataHoraInicio = '0000-00-00 00:00:00';
		}
		
		
	if(mysql_query($t="
			UPDATE projetos_atividades SET
				vkt_id ='$vkt_id',
				tempo_finalizado_hora = '{$campos[tempo_gasto]}',
				data_hora_fim         = '{$dataHora}',
				data_hora_inicio      = '{$dataHoraInicio}',				
				situacao		      = '{$campos['situacao']}'
			WHERE
				id='{$campos[id]}'
	")){} else{
		echo mysql_error();
	}
		} //fim de else
	
}

function deletar_atividade($id){
	mysql_query("
			DELETE FROM 
				projetos_atividades
			WHERE
				id='$id'
	");
}

function altera_situacao($campos){
		
		if(mysql_query($t="
			UPDATE projetos_atividades SET				
				situacao		      = '{$campos['rd']}'
			WHERE
				id='{$campos[id]}'
	")){} else{
		echo mysql_error();
	}
		
}

?>