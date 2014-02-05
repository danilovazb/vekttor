<?
//Funções 

//Cliente Fornecedor
function cadastraClienteFornecedor($razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$rg,$local_emissao,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro,$estado_civil,$conjugue_nome,$conjugue_ramo_atividade,$conjugue_cpf,$conjugue_rg,$conjugue_local_emissao){
	
	$erro=0;
	$razao_social=limitaTexto($razao_social,255);
	$nome_fantasia=limitaTexto($nome_fantasia,255);
	$nome_contato=limitaTexto($nome_contato,255);
	$ramo_atividade=limitaTexto($ramo_atividade,255);
	if($cnpj_cpf!=""){
		$cnpj_cpf=limitaTexto($cnpj_cpf,20);
	}else return 0;
	$rg=limitaTexto($rg,20);
	$suframa=limitaTexto($suframa,255);
	$inscricao_municipal=limitaTexto($inscricao_municipal,255);
	$inscricao_estadual=limitaTexto($inscricao_estadual,255);
	$email=limitaTexto($email,255);
	$telefone1=limitaTexto($telefone1,20);
	$telefone2=limitaTexto($telefone2,20);
	$fax=limitaTexto($fax,20);
	$cep=limitaTexto($cep,20);
	$endereco=limitaTexto($endereco,255);
	$bairro=limitaTexto($bairro,255);
	$cidade=limitaTexto($cidade,255);
	$estado=limitaTexto($estado,255);
	$limite=limitaTexto($limite,255);
	
	if($tipo!="Cliente"&&$tipo!="Fornecedor")return 0;
	if($tipo_cadastro!="Jurídico"&&$tipo_cadastro!="Físico")return 0;

	if($erro==0){
		mysql_query("
					INSERT INTO cliente_fornecedor SET
					razao_social='".$razao_social."',
					nome_fantasia='".$nome_fantasia."',
					nome_contato='".$nome_contato."',
					ramo_atividade='".$ramo_atividade."',
					cnpj_cpf='".$cnpj_cpf."',
					rg='".$rg."',
					local_emissao='".$local_emissao."',
					suframa='".$suframa."',
					inscricao_municipal='".$inscricao_municipal."',
					inscricao_estadual='".$inscricao_estadual."',
					email='".$email."',
					telefone1='".$telefone1."',
					telefone2='".$telefone2."',
					fax='".$fax."',
					cep='".$cep."',
					endereco='".$endereco."',
					bairro='".$bairro."',
					cidade='".$cidade."',
					estado='".$estado."',
					limite='".$limite."',
					tipo='".$tipo."',
					tipo_cadastro='".$tipo_cadastro."',
					estado_civil='".$estado_civil."',
					conjugue_nome='".$conjugue_nome."',
					conjugue_ramo_atividade='".$conjugue_ramo_atividade."',
					conjugue_cpf='".$conjugue_cpf."',
					conjugue_rg='".$conjugue_rg."',
					conjugue_local_emissao='".$conjugue_local_emissao."'
					");
		salvaUsuarioHistorico("Formulário - ".$tipo,"Cadastrou","cliente_fornecedor",mysql_insert_id());
		return 1;
	}
	
	return 0;
}

function alteraClienteFornecedor($id,$razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$rg,$local_emissao,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro,$estado_civil,$conjugue_nome,$conjugue_ramo_atividade,$conjugue_cpf,$conjugue_rg,$conjugue_local_emissao){
	
	$erro=0;
	$razao_social=limitaTexto($razao_social,255);
	$nome_fantasia=limitaTexto($nome_fantasia,255);
	$nome_contato=limitaTexto($nome_contato,255);
	$ramo_atividade=limitaTexto($ramo_atividade,255);
	echo "<script>alert('".$cnpj_cpf."');</script>";
	if($cnpj_cpf!=""){
		$cnpj_cpf=limitaTexto($cnpj_cpf,20);
	}else return 0;
	
	$rg=limitaTexto($rg,20);
	$suframa=limitaTexto($suframa,255);
	$inscricao_municipal=limitaTexto($inscricao_municipal,255);
	$inscricao_estadual=limitaTexto($inscricao_estadual,255);
	$email=limitaTexto($email,255);
	$telefone1=limitaTexto($telefone1,20);
	$telefone2=limitaTexto($telefone2,20);
	$fax=limitaTexto($fax,20);
	$cep=limitaTexto($cep,20);
	$endereco=limitaTexto($endereco,255);
	$bairro=limitaTexto($bairro,255);
	$cidade=limitaTexto($cidade,255);
	$estado=limitaTexto($estado,255);
	$limite=limitaTexto($limite,255);
	
	if($tipo!="Cliente"&&$tipo!="Fornecedor")return 0;
	if($tipo_cadastro!="Jurídico"&&$tipo_cadastro!="Físico")return 0;
	
	if($erro==0){
		salvaUsuarioHistorico("Formulário - ".$tipo,"Alterou","cliente_fornecedor",$id);
		mysql_query("
					UPDATE cliente_fornecedor SET
					razao_social='".$razao_social."',
					nome_fantasia='".$nome_fantasia."',
					nome_contato='".$nome_contato."',
					ramo_atividade='".$ramo_atividade."',
					cnpj_cpf='".$cnpj_cpf."',
					rg='".$rg."',
					local_emissao='".$local_emissao."',
					suframa='".$suframa."',
					inscricao_municipal='".$inscricao_municipal."',
					inscricao_estadual='".$inscricao_estadual."',
					email='".$email."',
					telefone1='".$telefone1."',
					telefone2='".$telefone2."',
					fax='".$fax."',
					cep='".$cep."',
					endereco='".$endereco."',
					bairro='".$bairro."',
					cidade='".$cidade."',
					estado='".$estado."',
					limite='".$limite."',
					tipo='".$tipo."',
					tipo_cadastro='".$tipo_cadastro."',
					estado_civil='".$estado_civil."',
					conjugue_nome='".$conjugue_nome."',
					conjugue_ramo_atividade='".$conjugue_ramo_atividade."',
					conjugue_cpf='".$conjugue_cpf."',
					conjugue_rg='".$conjugue_rg."',
					conjugue_local_emissao='".$conjugue_local_emissao."'
					WHERE
					id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

function excluiClienteFornecedor($id){
	
	$reserva=mysql_fetch_object(mysql_query("SELECT * FROM reserva WHERE cliente_fornecedor_id='".$id."' LIMIT 1"));
	if($reserva->id>0) return 0;
	if($id>0){
		
		$cliente_fornecedor=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$id' LIMIT 1"));
		
		salvaUsuarioHistorico("Formulário - ".$cliente_fornecedor->tipo,"Excluiu","cliente_fornecedor",$id);
		
		mysql_query("
					DELETE FROM cliente_fornecedor
					WHERE id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

?>