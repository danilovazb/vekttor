<?
function manipulaResponsavel($dados,$vkt_id,$id){
	if($id==''){ $sql_in = " INSERT INTO "; $sql_fim="";}
	if($id>0){ $sql_in = " UPDATE "; $sql_fim = " WHERE id='$id'";}
	
	mysql_query($t="$sql_in cliente_fornecedor SET 
	cliente_vekttor_id='$vkt_id',
	usuario_id='$usuario_id',
	razao_social='".$dados['f_nome_contato']."',
	tipo='Cliente',
	tipo_cadastro='Físico',
	nome_fantasia='".$dados['f_nome_contato']."',
	nome_contato='".$dados['f_nome_contato']."',
	ramo_atividade='".$dados['f_ramo_atividade']."',
	nascimento='".DataBrToUsa($dados['f_nascimento'])."',
	estado_civil='".$dados['f_estado_civil']."',
	naturalidade='".$dados['f_naturalidade']."',
	nacionalidade='".$dados['f_nacionalidade']."',
	cnpj_cpf='".$dados['f_cnpj_cpf']."',
	rg='".$dados['f_rg']."',
	local_emissao='".$dados['f_local_emissao']."',
	data_emissao='".DataBrToUsa($dados['f_data_emissao'])."',
	email='".$dados['f_email']."',
	telefone1='".$dados['f_telefone1']."',
	telefone2='".$dados['f_telefone2']."',
	fax='".$dados['f_fax']."',
	cep='".$dados['f_cep']."',
	endereco='".$dados['f_endereco']."',
	bairro='".$dados['f_bairro']."',
	cidade='".$dados['f_cidade']."',
	estado='".$dados['f_estado']."',
	grau_instrucao='".$dados['f_grau_instrucao']."'
	$sql_fim
	");
	//echo $t."<br>";
	//echo mysql_error();
}
function excluiResponsavel($id){
	global $vkt_id;
		$info = mf(mq("SELECT * FROM escolar_matriculas WHERE id='{$_POST[id]}' AND vkt_id='$vkt_id'"));
	if($info->id<1){

	mysql_query($t="DELETE FROM cliente_fornecedor WHERE id='$id'");
	}//echo $t;
}
?>