<?
function gerencia_conta($id,$nome,$comentario,$preferencial,$id,$acao,$agencia, $agencia_digito,$conta,$conta_digito,$tipo_boleto,$dados){
	
	global $bancos_codigos;
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
		_variacao_carteira='{$dados[variacao_carteira]}',
		_banco='".$bancos_codigos[$dados[banco]]."',
		codigo_cedente='{$dados['codigo_cedente']}',
		cnr='{$dados[cnr]}',
		codigo_banco='".$dados[banco]."',
		num_inicio_boleto='{$dados[num_inicio_boleto]}',
		instruncao1='{$dados[instruncao][0]}',
		instruncao2='{$dados[instruncao][1]}',
		instruncao3='{$dados[instruncao][2]}',
		instruncao4='{$dados[instruncao][3]}',
		instruncao5='{$dados[instruncao][4]}'
		 ";
	
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

	$e_a_preferencial = mysql_num_rows(mysql_query($x="SELECT * from $tabela WHERE cliente_vekttor_id='".$_SESSION[usuario]->cliente_vekttor_id."' AND preferencial='1'"));
	
	if($acao=='Salvar'){
		if($preferencial==1){
			mysql_query($a="UPDATE $tabela SET preferencial='0' WHERE cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'");
			//mysql_query($sql);
			echo mysql_error();
		}else{
			if($e_a_preferencial==0&&$id>0){
				return 'Você não pode ficar sem Conta Preferencial - Alteração Não foi efetuada';
			}
		}
		if(mysql_query($sql)){
			if(!$id>0){
				$conta_id = mysql_insert_id();
				if(moedaBrToUsa($dados['saldo_inicial'])>0){
					mysql_query($t="INSERT INTO financeiro_movimento SET descricao='Saldo Inicial',cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."', conta_id='$conta_id', internauta_id='0', data_registro=NOW(),data_vencimento=now(), data_movimento=now() , data_info_movimento =now(), saldo='".moedaBrToUsa($dados['saldo_inicial'])."', valor_cadastro='".moedaBrToUsa($dados['saldo_inicial'])."',ano_mes_referencia=DATE_FORMAT(now(),'%m/%Y'), movimentacao='fisico',status='1'");
				}
				//echo $t;
			}
			return 'ok';
			
		}else{
			return "Erro ao $erro".mysql_error();
		}
	}
	if($acao=='Excluir'){
		
		$verifica_se_tem= mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE conta_id='$id' AND extorno<>'1' AND status <>'2' AND movimentacao <> 'fisico'"));
		
		if($verifica_se_tem->id<1){
			if(mysql_query("DELETE FROM $tabela $sql_fim")){
				return 'ok';
			}else{
				echo mysql_error();
				return 'Erro ao Deletar';
			}
		}else{
				return 'Existem movimentos nessa conta e não pode ser deletada';
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