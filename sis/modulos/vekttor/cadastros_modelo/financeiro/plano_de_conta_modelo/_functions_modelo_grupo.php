<?
function manipulaModeloGrupoPlanoConta($dados){
	$id=$dados['id_grupo'];
	$acao=$dados['action'];
	$tabela=" financeiro_centro_custo_modelo_grupo";
	$sql_meio= " SET nome='{$dados['nome']}', descricao='{$dados['descricao']}' ";
	if($id<1){
		$sql_inicio= "INSERT INTO $tabela "; 
		$sql_fim= ""; 
		$erro ='Cadastrar';
		salvaUsuarioHistorico("Formulário - Grupo de modelos de plano de conta",'cadastrou',$tabela,mysql_insert_id());
	}else{
		$sql_inicio= "UPDATE $tabela "; 
		$sql_fim= " WHERE id='$id' "; 
		$erro ='Alterar';
		salvaUsuarioHistorico("Formulário - Grupo de modelos de plano de conta",'alterou',$tabela,$id);
	}
	
	$sql = $sql_inicio.$sql_meio.$sql_fim;
	if($acao=='Salvar'){
		if(mysql_query($sql)){
			return 'ok';
		}else{
			return "Erro ao $erro".mysql_error();
		}
	}
}

function excluiModeloGrupoPlanoConta($dados){
	$id=$dados['id_grupo'];
	$acao=$dados['action'];
	$tabela=" financeiro_centro_custo_modelo_grupo";
	if($id>0)
	{
		$sql_inicio= "UPDATE $tabela "; 
		$sql_fim= " WHERE id='$id' "; 
		$erro ='Alterar';
	}
	if($acao=='Excluir'){
		if(mysql_query("DELETE FROM $tabela $sql_fim")){
			return 'ok';
			salvaUsuarioHistorico("Formulário - Grupo de modelos de plano de conta",'deletou',$tabela,$id);
		}else{
			echo mysql_error();
			return 'Erro ao Deletar';
		}
	}
	
}