<?
function gerencia_conta($id,$nome,$comentario,$preferencial,$id,$acao,$agencia, $agencia_digito,$conta,$conta_digito,$tipo_boleto,$dados){
	$tabela = 'financeiro_contas';
	$sql_meio= 
	"SET 
		cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."',
		nome='$nome',
		comentario='$comentario',
		preferencial='$preferencial', 
		agencia='$agencia', 
		agencia_digito='$agencia_digito', 
		conta='$conta',
		conta_digito='$conta_digito', 
		tipo_boleto='$tipo_boleto',
		_tipo_boleto_='{$dados[tipo_boleto_]}',
		_conta_cedente='{$dados[conta_cedente]}',
		_conta_cedente_dv='{$dados[conta_cedente_dv]}',
		_convenio='{$dados[convenio]}',
		_contrato='{$dados[contrato]}',
		_carteira='{$dados[carteira]}',
		_banco='{$dados[banco]}' ";
	
	//echo $sql_meio;
	if($id<1){
		$sql_inicio= "INSERT INTO $tabela "; 
		$sql_fim= ""; 
		$erro ='Cadastrar';
		salvaUsuarioHistorico("Formulário - Contas",'cadastrou',$tabela,mysql_insert_id());
	}else{
		$sql_inicio= "UPDATE $tabela "; 
		$sql_fim= "WHERE id='$id'"; 
		$erro ='Alterar';
		//echo $erro;
		salvaUsuarioHistorico("Formulário - Contas",'alterou',$tabela,mysql_insert_id());
	}
	
	$sql = $sql_inicio.$sql_meio.$sql_fim;
	//echo $sql;
	$e_a_preferencial = mysql_num_rows(mysql_query($x="SELECT * from $tabela WHERE cliente_vekttor_id='".$_SESSION[usuario]->cliente_vekttor_id."' AND preferencial='1'"));
	//echo $x;
	
	if($acao=='Salvar'){
		if($preferencial==1){
			mysql_query($a="UPDATE $tabela SET preferencial='0' WHERE cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'");
			//mysql_query($sql);
			echo mysql_error();
		}else{
			if($e_a_preferencial==0){
				return 'Você não pode ficar sem Conta Preferencial - Alteração Não foi efetuada';
			}
		}
		if(mysql_query($sql)){
			return 'ok';
		}else{
			return "Erro ao $erro".mysql_error();
		}
	}
	if($acao=='Excluir'){
		
		$verifica_se_tem= mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE conta_id='$id' AND extorno<>'1' AND status <>'2'"));
		
		if($verifica_se_tem->id<1){
			if(mysql_query("DELETE FROM $tabela $sql_fim")){
				return 'ok';
			}else{
				echo mysql_error();
				return 'Erro ao Deletar';
			}
		}else{
				return 'Existe movimentos nessa conta e não pode ser deletada';
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