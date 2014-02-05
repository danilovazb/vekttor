<?
//Negociação
function cadastraDisponibilidade_tipo($empreedimento_id,$nome,$descricao,$valor,$area_privativa,$fracao_ideal){
	
	if(mysql_query($trace="
					INSERT INTO disponibilidade_tipo SET
					empreendimento_id='".$empreedimento_id."',
					nome='".$nome."',
					area_privativa='$area_privativa',
					fracao_ideal='$fracao_ideal',
					descricao='".$descricao."',
					valor='".moedaBrToUsa($valor)."'
					")){
		salvaUsuarioHistorico("Formulário - disponibilidade_tipo",'cadastrou','disponibilidade_tipo',mysql_insert_id());
		return 1;
	}
	
	return 0;
}

function alteraDisponibilidade_tipo($id,$empreedimento_id,$nome,$descricao,$valor,$area_privativa,$fracao_ideal){
	
	
		salvaUsuarioHistorico("Formulário - Tipo de disponibilidade_tipo",'alterou','disponibilidade_tipo',$id);
		if(mysql_query("
					UPDATE disponibilidade_tipo SET
						empreendimento_id='".$empreedimento_id."',
						nome='".$nome."',
						area_privativa='$area_privativa',
						fracao_ideal='$fracao_ideal',
						descricao='".$descricao."',
						valor='".moedaBrToUsa($valor)."'
					WHERE
						id='".$id."'
					")){
		return 1;
	}
	
	return 0;
}

function excluiDisponibilidade_tipo($id){
	
	//$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE disponibilidade_tipo_id='".$id."' LIMIT 1"));
	$reservas=0;
	if($reservas==0){
		salvaUsuarioHistorico("Formulário - disponibilidade_tipo",'deletou','disponibilidade_tipo',$id);
		mysql_query("
					DELETE FROM disponibilidade_tipo
					WHERE id='".$id."'
					");
		return 1;
	}else{
		echo "<script>alert('Não Pode Deletar')</script>";	
	}
	
	return 0;
}
?>