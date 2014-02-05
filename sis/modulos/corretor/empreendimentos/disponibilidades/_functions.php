<?
//Negociação
function cadastraDisponibilidade($empreedimento_id,$disponibilidade_tipo_id,$identificacao,$obs,$valor){
	
	$valor = moedaBrToUsa($valor);
	if(mysql_query($trace="
					INSERT INTO disponibilidade SET
					empreendimento_id='".$empreedimento_id."',
					disponibilidade_tipo_id='$disponibilidade_tipo_id',
					identificacao='".$identificacao."',
					obs='".$obs."',
					valor='".$valor."'
					")){
		salvaUsuarioHistorico("Formulário - Disponibilidade",'cadastrou','disponibilidade',mysql_insert_id());
		return 1;
	}
	
	return 0;
}

function alteraDisponibilidade($id,$empreedimento_id,$disponibilidade_tipo_id,$identificacao,$obs,$valor){
	
	
		salvaUsuarioHistorico("Formulário - Tipo de Disponibilidade",'alterou','disponibilidade_tipo',$id);
	$valor = moedaBrToUsa($valor);
		if(mysql_query("
					UPDATE disponibilidade SET
						empreendimento_id='".$empreedimento_id."',
						disponibilidade_tipo_id='$disponibilidade_tipo_id',
						identificacao='".$identificacao."',
						obs='".$obs."',
						valor='".$valor."'
					WHERE
						id='".$id."'
					")){
		return 1;
	}
	
	return 0;
}

function excluiDisponibilidade($id){
	
	//$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE disponibilidade_tipo_id='".$id."' LIMIT 1"));
	$reservas=0;
	if($reservas==0){
		salvaUsuarioHistorico("Formulário - Disponibilidade",'deletou','disponibilidade',$id);
		mysql_query("
					DELETE FROM disponibilidade
					WHERE id='".$id."'
					");
		return 1;
	}else{
		echo "<script>alert('Não Pode Deletar')</script>";	
	}
	
	return 0;
}
?>