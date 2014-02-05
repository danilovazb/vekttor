<?
//Funções 

//Cliente Fornecedor
function cadastraClienteFornecedor($razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro,$telefone_comercial,$estado_civil,$naturalidade,$rg,$local_emissao,$data_emissao,$nacionalidade,$conjugue_nome,$conjugue_data_nascimento,$conjugue_ramo_atividade,$conjugue_cpf,$conjugue_rg,$conjugue_local_emissao,$conjugue_data_emissao,$conjugue_telefone,$conjugue_email,$conjugue_naturalidade,$conjugue_nacionalidade,$conjugue_endereco_comercial,$conjugue_telefone_comercial,$nascimento,$endereco_comercial){
	$fj;
	$erro=0;
	$razao_social=limitaTexto($razao_social,255);
	$nome_fantasia=limitaTexto($nome_fantasia,255);
	$nome_contato=limitaTexto($nome_contato,255);
	$ramo_atividade=limitaTexto($ramo_atividade,255);
	
	$cnpj_cpf_procura=mysql_num_rows(mysql_query("SELECT cnpj_cpf FROM cliente_fornecedor WHERE cnpj_cpf='$cnpj_cpf'"));
	if($cnpj_cpf_procura>0){
		if($tipo_cadastro=='Jurídico'){
			echo "<script>alert('CNPJ já existe')</script>";
			return 0;
		}
		if($tipo_cadastro=='Físico'){
			echo "<script>alert('CPF já existe')</script>";
			return 0;
		}
		
	}
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
	
	if($erro==0){
		mysql_query($t="
					INSERT INTO cliente_fornecedor SET
					cliente_vekttor_id='".$_SESSION['usuario']->cliente_vekttor_id."',
					usuario_id='".$_SESSION['usuario']->id."',
					razao_social='".$razao_social."',
					nome_fantasia='".$nome_fantasia."',
					nome_contato='".$nome_contato."',
					ramo_atividade='".$ramo_atividade."',
					cnpj_cpf='".$cnpj_cpf."',
					nascimento='".$nascimento."',
					rg='".$rg."',
					local_emissao='".$local_emissao."',
					data_emissao='".$data_emissao."',
					nacionalidade='".$nacionalidade."',
					naturalidade='".$naturalidade."',
					endereco_comercial='".$endereco_comercial."',
					telefone_comercial='".$telefone_comercial."',
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
					conjugue_data_nascimento='".$conjugue_data_nascimento."',
					conjugue_ramo_atividade='".$conjugue_ramo_atividade."',
					conjugue_cpf='".$conjugue_cpf."',
					conjugue_rg='".$conjugue_rg."',
					conjugue_local_emissao='".$conjugue_local_emissao."',
					conjugue_data_emissao='".$conjugue_data_emissao."',
					conjugue_telefone='".$conjugue_telefone."',
					conjugue_email='".$conjugue_email."',
					conjugue_naturalidade='".$conjugue_naturalidade."',
					conjugue_nacionalidade='".$conjugue_nacionalidade."',
					conjugue_endereco_comercial='".$conjugue_endereco_comercial."',
					conjugue_telefone_comercial='".$conjugue_telefone_comercial."'
					");
					//echo $t;
					//echo "<br>";
					//echo mysql_error();
		salvaUsuarioHistorico("Formulário - ".$tipo,"Cadastrou","cliente_fornecedor",mysql_insert_id());
		return 1;
	}
	
	return 0;
}

function alteraClienteFornecedor($id,$razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro,$telefone_comercial,$estado_civil,$naturalidade,$rg,$local_emissao,$data_emissao,$nacionalidade,$conjugue_nome,$conjugue_data_nascimento,$conjugue_ramo_atividade,$conjugue_cpf,$conjugue_rg,$conjugue_local_emissao,$conjugue_data_emissao,$conjugue_telefone,$conjugue_email,$conjugue_naturalidade,$conjugue_nacionalidade,$conjugue_endereco_comercial,$conjugue_telefone_comercial,$nascimento,$endereco_comercial){
	
	$erro=0;
	$razao_social=limitaTexto($razao_social,255);
	$nome_fantasia=limitaTexto($nome_fantasia,255);
	$nome_contato=limitaTexto($nome_contato,255);
	$ramo_atividade=limitaTexto($ramo_atividade,255);
	
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
	$limite=moedaBrToUsa($limite);
	
	
	if($erro==0){
		salvaUsuarioHistorico("Formulário - ".$tipo,"Alterou","cliente_fornecedor",$id);
		mysql_query($t="
					UPDATE cliente_fornecedor SET
					razao_social='".$razao_social."',
					nome_fantasia='".$nome_fantasia."',
					nome_contato='".$nome_contato."',
					ramo_atividade='".$ramo_atividade."',
					cnpj_cpf='".$cnpj_cpf."',
					nascimento='".$nascimento."',
					rg='".$rg."',
					local_emissao='".$local_emissao."',
					data_emissao='".$data_emissao."',
					nacionalidade='".$nacionalidade."',
					naturalidade='".$naturalidade."',
					endereco_comercial='".$endereco_comercial."',
					telefone_comercial='".$telefone_comercial."',
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
					conjugue_data_nascimento='".$conjugue_data_nascimento."',
					conjugue_ramo_atividade='".$conjugue_ramo_atividade."',
					conjugue_cpf='".$conjugue_cpf."',
					conjugue_rg='".$conjugue_rg."',
					conjugue_local_emissao='".$conjugue_local_emissao."',
					conjugue_data_emissao='".$conjugue_data_emissao."',
					conjugue_telefone='".$conjugue_telefone."',
					conjugue_email='".$conjugue_email."',
					conjugue_naturalidade='".$conjugue_naturalidade."',
					conjugue_nacionalidade='".$conjugue_nacionalidade."',
					conjugue_endereco_comercial='".$conjugue_endereco_comercial."',
					conjugue_telefone_comercial='".$conjugue_telefone_comercial."'
					WHERE
					id='".$id."'
					");
					//echo $t;
		return 1;
	}
	
	return 0;
}

function excluiClienteFornecedor($id){
	
	$reserva=mysql_fetch_object(mysql_query("SELECT * FROM reserva WHERE cliente_fornecedor_id='".$id."' LIMIT 1"));
	$financeiro=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE internauta_id ='".$id."' LIMIT 1"));
	if($reserva->id>0) return 0;
	if($financeiro->id>0) return 0;
	if($id>0){
		
		$cliente_fornecedor=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$id' LIMIT 1"));
		
		salvaUsuarioHistorico("Formulário - ".$cliente_fornecedor->tipo,"Excluiu","cliente_fornecedor",$id);
		
		mysql_query($trace="
					DELETE FROM cliente_fornecedor
					WHERE id='".$id."'
					");

		return 1;
	}
	
	return 0;
}

?>