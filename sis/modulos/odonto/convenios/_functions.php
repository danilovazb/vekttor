<?php
//Cadastar/Altera na tabela Cliente_Fornecedor
function manipulaFornecedor($dados){
	global $vkt_id;
	//verifica se o cpf já está cadastrado
	/*$cpf=mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor
										WHERE cnpj_cpf='".$dados['f_cnpj_cpf']."' 																												                                        AND cliente_vekttor_id='$vkt_id' ORDER BY id DESC LIMIT 1"));*/
	//echo $t."<br>";
	if(empty($dados['cf_id'])){ $sql_in = " INSERT INTO "; $sql_fim="";}
	else { $sql_in = "UPDATE"; $sql_fim = "WHERE id='".$dados['cf_id']."'";}
												
	mysql_query($t="$sql_in cliente_fornecedor SET 
		cliente_vekttor_id='$vkt_id',
		usuario_id='0',
		tipo='Cliente',
		tipo_cadastro='Jurídico',
		nome_contato='".$dados['j_nome_contato']."',
		razao_social='".$dados['j_razao_social']."',
		nome_fantasia='".$dados['j_nome_fantasia']."',
		ramo_atividade='".$dados['j_ramo_atividade']."',
		nascimento='".DataBrToUsa($dados['j_nascimento'])."',
		estado_civil='".$dados['j_estado_civil']."',
		naturalidade='".$dados['j_naturalidade']."',
		suframa='".$dados['j_suframa']."',
		inscricao_municipal='".$dados['j_inscricao_municipal']."',
		inscricao_estadual='".$dados['j_inscricao_estadual']."',
		nacionalidade='".$dados['j_nacionalidade']."',
		cnpj_cpf='".$dados['j_cnpj_cpf']."',
		rg='".$dados['j_rg']."',
		local_emissao='".$dados['j_local_emissao']."',
		data_emissao='".DataBrToUsa($dados['j_data_emissao'])."',
		email='".$dados['j_email']."',
		telefone1='".$dados['j_telefone1']."',
		telefone2='".$dados['j_telefone2']."',
		fax='".$dados['j_fax']."',
		cep='".$dados['j_cep']."',
		endereco='".$dados['j_endereco']."',
		bairro='".$dados['j_bairro']."',
		cidade='".$dados['j_cidade']."',
		estado='".$dados['j_estado']."',
		grau_instrucao='".$dados['j_grau_instrucao']."',
		limite='".moedaBrtoUsa($dados['j_limite'])."'
		$sql_fim
	");
	//echo $t." ".mysql_error();
	if(empty($dados['cf_id'])){
		$cf_id = mysql_insert_id();
		
	}else{
		$cf_id = $dados['cf_id'];
	}
	
	manipulaConvenio($dados['id'],$cf_id);
}

function manipulaConvenio($id,$cliente_fornecedor_id){
	
	global $vkt_id;
	
	if(!$id>0){$inicio = "INSERT INTO";$fim='';}
	else{$inicio = "UPDATE";$fim=" WHERE id=$id";}

	$sql = mysql_query($t="$inicio odontologo_convenio SET vkt_id='$vkt_id',cliente_fornecedor_id=$cliente_fornecedor_id $fim");
	//echo $t." ".mysql_error(); 
}

function ExcluirFornecedor($id){

	mysql_query("DELETE FROM cliente_fornecedor WHERE id='$id'");
	mysql_query("DELETE FROM odontologo_convenio WHERE cliente_fornecedor_id='$id'");

}
?>