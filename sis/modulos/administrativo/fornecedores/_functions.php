<?
//Funções 

//Cliente Fornecedor
function cadastraClienteFornecedor($razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$rg,$local_emissao,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro,$estado_civil,$conjugue_nome,$conjugue_ramo_atividade,$conjugue_cpf,$conjugue_rg,$conjugue_local_emissao,$nascimento,$grupo_id,$sexo = ''){
	
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
	if($tipo!="Cliente"&&$tipo!="Fornecedor")return 0;
	if($tipo_cadastro!="Jurídico"&&$tipo_cadastro!="Físico")return 0;
	if($erro==0){
		mysql_query("
					INSERT INTO cliente_fornecedor SET
					cliente_vekttor_id='".$_SESSION['usuario']->cliente_vekttor_id."',
					usuario_id='".$_SESSION['usuario']->id."',
					razao_social='".$razao_social."',
					nome_fantasia='".$nome_fantasia."',
					nome_contato='".$nome_contato."',
					ramo_atividade='".$ramo_atividade."',
					cnpj_cpf='".$cnpj_cpf."',
					rg='".$rg."',
					nascimento='".$nascimento."',
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
					limite='".moedaBrToUsa($limite)."',
					tipo='".$tipo."',
					tipo_cadastro='".$tipo_cadastro."',
					estado_civil='".$estado_civil."',
					conjugue_nome='".$conjugue_nome."',
					conjugue_ramo_atividade='".$conjugue_ramo_atividade."',
					conjugue_cpf='".$conjugue_cpf."',
					conjugue_rg='".$conjugue_rg."',
					conjugue_local_emissao='".$conjugue_local_emissao."',
					grupo_id='".$grupo_id."',
					sexo      ='$sexo'
					");
		salvaUsuarioHistorico("Formulário - ".$tipo,"Cadastrou","cliente_fornecedor",mysql_insert_id());
		
		if(strlen($_FILES['foto_cliente']['name'])>3){
			upload_foto(mysql_insert_id(),$tipo_cadastro);
		
		}
		if(strlen($_FILES['foto_cliente_fisico']['name'])>3){
			upload_foto(mysql_insert_id(),$tipo_cadastro);		
		}
		
		return 1;
	}


	return 0;
}

function alteraClienteFornecedor($id,$razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$rg,$local_emissao,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro,$estado_civil,$conjugue_nome,$conjugue_ramo_atividade,$conjugue_cpf,$conjugue_rg,$conjugue_local_emissao,$nascimento,$grupo_id,$sexo = ''){
	
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
		mysql_query($yu="
					UPDATE cliente_fornecedor SET
					razao_social='".$razao_social."',
					nome_fantasia='".$nome_fantasia."',
					nome_contato='".$nome_contato."',
					ramo_atividade='".$ramo_atividade."',
					cnpj_cpf='".$cnpj_cpf."',
					rg='".$rg."',
					nascimento='".$nascimento."',
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
					conjugue_local_emissao='".$conjugue_local_emissao."',
					grupo_id='".$grupo_id."',
					sexo      ='$sexo'
					WHERE
					id='".$id."'
					");
					
				
		if(strlen($_FILES['foto_cliente']['name'])>3){
			upload_foto($id,$tipo_cadastro);
		}
		if(strlen($_FILES['foto_cliente_fisico']['name'])>3){
			upload_foto($id,$tipo_cadastro);
		}
		return 1;
	}
	
	return 0;
}

function excluiClienteFornecedor($id){
	
	$reserva=mysql_fetch_object(mysql_query("SELECT * FROM reserva WHERE cliente_fornecedor_id='".$id."' LIMIT 1"));
	$financeiro=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE internauta_id='".$id."' AND extorno<>'1' AND status <>'2' LIMIT 1"));
	if($reserva->id>0) return 0;
	if($financeiro->id>0) return 0;
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

function manipulaGrupo($dados){
	global $vkt_id;
	if(!$dados['id']>0){
		$inicio = "INSERT INTO";$fim="";
	}else{
		$inicio = "UPDATE";$fim="WHERE id={$dados['id']}";
	}
	mysql_query($t="$inicio cliente_fornecedor_grupo SET nome='{$dados['nome_grupo']}',vkt_id='$vkt_id',observacao='{$dados['observacao_grupo']}',tipo='F' $fim");
	//echo $t;
}
function ExcluirGrupo($dados){
	global $vkt_id;
	$existe = @mysql_num_rows(mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND grupo_id={$dados['id']}"));
	
	if(!$existe>0){
		mysql_query("DELETE FROM cliente_fornecedor_grupo WHERE id={$dados['id']}");
	}else{
		alert("Grupo não pode ser excluído! Há usuários neste grupo.");
	}
}

function upload_foto($cliente_id,$tipo_cadastro){
	//alert('oi');
	$filis_autorizados = array('jpg','gif','png','jpeg','pdf');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$cliente_id'"));
	
	if(strlen($_FILES['foto_cliente']['name'])>4&&$tipo_cadastro=="Jurídico"){
	  $pasta 	= 'modulos/administrativo/fornecedores/fotos_fornecedores/';
	  $extensao = strtolower(substr($_FILES['foto_cliente']['name'],-3));
	  $arquivo 	= $pasta.$cliente_id.'.'.$extensao;
	  $arquivodel= $pasta.$cliente_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['foto_cliente'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE cliente_fornecedor SET extensao='$extensao' WHERE id='$cliente_id'");
			  //alert($f);
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
	if(strlen($_FILES['foto_cliente_fisico']['name'])>4&&$tipo_cadastro=="Físico"){
	  $pasta 	= 'modulos/administrativo/fornecedores/fotos_fornecedores/';
	  $extensao = strtolower(substr($_FILES['foto_cliente_fisico']['name'],-3));
	  $arquivo 	= $pasta.$cliente_id.'.'.$extensao;
	  $arquivodel= $pasta.$cliente_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['foto_cliente_fisico'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE cliente_fornecedor SET extensao='$extensao' WHERE id='$cliente_id'");
			 // alert($f);
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
}

function ExcluirFoto($dados){
	
	unlink("modulos/administrativo/fornecedores/fotos_fornecedores/".$dados['cliente_fornecedor_id'].".".$dados['extensao']);
	mysql_query($t="UPDATE cliente_fornecedor SET extensao='' WHERE id={$dados['cliente_fornecedor_id']}");
	//alert($t);
}

function adicionarDocumento($dados){
	
	global $usuario_id;
	mysql_query($t="INSERT INTO cliente_fornecedor_arquivo SET usuario_id='$usuario_id', cliente_fornecedor_id=$dados[cliente_fornecedor_id], descricao = '$dados[descricao_documento]'");	
	//alert($t);
	$id = mysql_insert_id();
	
	$filis_autorizados = array('jpg','gif','png','jpeg');
	
	if(strlen($_FILES['arquivo_documento']['name'])>4){
	  $pasta 	= 'modulos/administrativo/fornecedores/arquivos_fornecedores/';
	  $extensao = strtolower(substr($_FILES['arquivo_documento']['name'],-3));
	  $arquivo 	= $pasta.$id.'.'.$extensao;
	  $arquivodel= $pasta.$id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['arquivo_documento'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE cliente_fornecedor_arquivo SET localizacao='$extensao' WHERE id='$id'");
			 
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	return $id;
}
function excluirDocumento($dados){
	$arquivo = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor_arquivo WHERE id='$dados[id_documento_exclusao]'")); 
	unlink("modulos/administrativo/fornecedores/arquivos_fornecedores/".$arquivo->id.".".$arquivo->localizacao);
	mysql_query($t="DELETE FROM cliente_fornecedor_arquivo WHERE id='$dados[id_documento_exclusao]'");
	//alert($t);
}

function ExcluirTodosDocumentos($dados){
	//alert('oi');
	$arquivos = mysql_query("SELECT * FROM cliente_fornecedor_arquivo WHERE cliente_fornecedor_id='$dados[cliente_fornecedor_id]'");
	 while($arquivo = mysql_fetch_object($arquivos)){
		unlink("modulos/administrativo/fornecedores/arquivos_fornecedores/".$arquivo->id.".".$arquivo->localizacao);
		
	 }
	 mysql_query($t="DELETE FROM cliente_fornecedor_arquivo WHERE cliente_fornecedor_id='$dados[cliente_fornecedor_id]'");
	//alert($t);
}

?>