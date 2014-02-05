<?
$tabela = 'financeiro_centro_custo_modelo';
$plano_ou_centro = 'plano';
function gerencia_centro_de_custo($ordem,$nome,$descricao,$centro_custo_id,$plano_ou_centro,$id,$acao,$visualiza_soma,$modelo_grupo_id,$visualiza_soma){
	$tabela = 'financeiro_centro_custo_modelo';
	$sql_meio= "SET cliente_id ='".$_SESSION[usuario]->cliente_vekttor_id ."', modelo_grupo_id='$modelo_grupo_id', ordem='$ordem',centro_custo_id='$centro_custo_id',nome='$nome' ,plano_ou_centro='$plano_ou_centro', descricao='$descricao',exibir_soma='$visualiza_soma'";
	
	
	if($id<1){
		$sql_inicio= "INSERT INTO $tabela "; 
		$sql_fim= ""; 
		$erro ='Cadastrar';
		salvaUsuarioHistorico("Formulário - Contas",'cadastrou',$tabela,mysql_insert_id());
	}else{
		$sql_inicio= "UPDATE $tabela "; 
		$sql_fim= "WHERE id='$id' AND cliente_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'"; 
		$erro ='Alterar';
		salvaUsuarioHistorico("Formulário - Contas",'alterou',$tabela,mysql_insert_id());
	}
	
	$sql = $sql_inicio.$sql_meio.$sql_fim;
	
	
	$centro_row = mysql_fetch_object(mysql_query("select * from $tabela WHERE id='$id' "));
	
	if($centro_row->id==$centro_custo_id){
		return "Esse registro não pode ser liago a ele mesmo";
	}
	
	
	if($acao=='Salvar'){
		if(mysql_query($sql)){
			return 'ok';
		}else{
			return "Erro ao $erro".mysql_error();
		}
	}
	if($acao=='Excluir'){
		
		if(mysql_query("DELETE FROM $tabela $sql_fim")){
			return 'ok';
		}else{
			echo mysql_error();
			return 'Erro ao Deletar';
		}
	}
	
}
function autentica_del_conta(){
	
}
function autentica_insert_conta(){
	
}
function autentica_altera_conta(){
	
}




?>