<?
//Funções 

//Cliente Fornecedor
function cadastraClienteFornecedor($razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro,$telefone_comercial,$estado_civil,$naturalidade,$rg,$local_emissao,$data_emissao,$nacionalidade,$conjugue_nome,$conjugue_data_nascimento,$conjugue_ramo_atividade,$conjugue_cpf,$conjugue_rg,$conjugue_local_emissao,$conjugue_data_emissao,$conjugue_telefone,$conjugue_email,$conjugue_naturalidade,$conjugue_nacionalidade,$conjugue_endereco_comercial,$conjugue_telefone_comercial,$nascimento,$endereco_comercial,$grupo_id,$sexo = ''){
	global $vkt_id;
	$fj;
	$erro=0;
	$razao_social=limitaTexto($razao_social,255);
	$nome_fantasia=limitaTexto($nome_fantasia,255);
	$nome_contato=limitaTexto($nome_contato,255);
	$ramo_atividade=limitaTexto($ramo_atividade,255);
	/*
	$cnpj_cpf_procura=mysql_num_rows(mysql_query("SELECT cnpj_cpf FROM cliente_fornecedor WHERE cnpj_cpf='$cnpj_cpf' AND cliente_vekttor_id='$vkt_id'"));
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
	*/
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
					conjugue_telefone_comercial='".$conjugue_telefone_comercial."',
					grupo_id = '".$grupo_id."',
					sexo='$sexo'");
					
					//echo "<br>";
					//echo mysql_error();
		$cliente_id=mysql_insert_id();
		salvaUsuarioHistorico("Formulário - ".$tipo,"Cadastrou","cliente_fornecedor",mysql_insert_id());
		
		
		if(strlen($_FILES['foto_cliente']['name'])>3){
			upload_foto($cliente_id,$tipo_cadastro);
		
		}
		if(strlen($_FILES['foto_cliente_fisico']['name'])>3){
			upload_foto($cliente_id,$tipo_cadastro);		
		}
		return $cliente_id;
	}
	
	return 0;
}

function alteraClienteFornecedor($id,$razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro,$telefone_comercial,$estado_civil,$naturalidade,$rg,$local_emissao,$data_emissao,$nacionalidade,$conjugue_nome,$conjugue_data_nascimento,$conjugue_ramo_atividade,$conjugue_cpf,$conjugue_rg,$conjugue_local_emissao,$conjugue_data_emissao,$conjugue_telefone,$conjugue_email,$conjugue_naturalidade,$conjugue_nacionalidade,$conjugue_endereco_comercial,$conjugue_telefone_comercial,$nascimento,$endereco_comercial,$grupo_id,$sexo = ''){
	
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
					conjugue_telefone_comercial='".$conjugue_telefone_comercial."',
					grupo_id = '".$grupo_id."',
					sexo='$sexo'
					WHERE
					id='".$id."'
					");
					//echo $t;
					//alert('oi');
					
		if(strlen($_FILES['foto_cliente']['name'])>3){
			upload_foto($id,$tipo_cadastro);
		}
		if(strlen($_FILES['foto_cliente_fisico']['name'])>3){
			upload_foto($id,$tipo_cadastro);
		}
		return $id;
	}
	
	return 0;
}

function excluiClienteFornecedor($id){
	
	$reserva=mysql_fetch_object(mysql_query("SELECT * FROM reserva WHERE cliente_fornecedor_id='".$id."' LIMIT 1"));
	$financeiro=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE internauta_id ='".$id."' AND extorno<>'1' AND status <>'2' LIMIT 1"));
	if($reserva->id>0) return 0;
	if($financeiro->id>0) return 0;
	if($id>0){
		
		$cliente_fornecedor=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$id'  LIMIT 1"));
		
		salvaUsuarioHistorico("Formulário - ".$cliente_fornecedor->tipo,"Excluiu","cliente_fornecedor",$id);
		
		mysql_query($trace="
					DELETE FROM cliente_fornecedor
					WHERE id='".$id."'
					");echo $trace;
	
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
	mysql_query($t="$inicio cliente_fornecedor_grupo SET nome='{$dados['nome_grupo']}',vkt_id='$vkt_id',observacao='{$dados['observacao_grupo']}',tipo='C' $fim");
	//echo $t;
}
function ExcluirGrupo($dados){
	global $vkt_id;
	$existe = @mysql_num_rows(mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND grupo_id={$dados['id']}"));
	//echo $existe;
	
	if(!$existe>0){
		mysql_query($t="DELETE FROM cliente_fornecedor_grupo WHERE vkt_id='$vkt_id' AND  id={$dados['id']}");
		//echo $t;
	}else{
		alert("Grupo não pode ser excluído! Há usuários neste grupo.");
	}
}

function upload_foto($cliente_id,$tipo_cadastro){
	
	$filis_autorizados = array('jpg','gif','png','jpeg');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$cliente_id'"));
	
	if(strlen($_FILES['foto_cliente']['name'])>4&&$tipo_cadastro=="Jurídico"){
	  $pasta 	= 'modulos/administrativo/clientes/fotos_clientes/';
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
	  $pasta 	= 'modulos/administrativo/clientes/fotos_clientes/';
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
	
	unlink("modulos/administrativo/clientes/fotos_clientes/".$dados['cliente_fornecedor_id'].".".$dados['extensao']);
	mysql_query($t="UPDATE cliente_fornecedor SET extensao='' WHERE id={$dados['cliente_fornecedor_id']}");
}

function adicionarDocumento($dados){
	
	global $usuario_id;
	mysql_query($t="INSERT INTO cliente_fornecedor_arquivo SET usuario_id='$usuario_id', cliente_fornecedor_id=$dados[cliente_fornecedor_id], descricao = '$dados[descricao_documento]'");	
	
	$id = mysql_insert_id();
	
	$filis_autorizados = array('jpg','gif','png','jpeg','pdf');
	
	if(strlen($_FILES['arquivo_documento']['name'])>4){
	  $pasta 	= 'modulos/administrativo/clientes/arquivos_clientes/';
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
	unlink("modulos/administrativo/clientes/arquivos_clientes/".$arquivo->id.".".$arquivo->localizacao);
	mysql_query($t="DELETE FROM cliente_fornecedor_arquivo WHERE id='$dados[id_documento_exclusao]'");
	//alert($t);
}

function ExcluirTodosDocumentos($dados){
	//alert('oi');
	$arquivos = mysql_query("SELECT * FROM cliente_fornecedor_arquivo WHERE cliente_fornecedor_id='$dados[cliente_fornecedor_id]'");
	 while($arquivo = mysql_fetch_object($arquivos)){
		unlink("modulos/administrativo/clientes/arquivos_clientes/".$arquivo->id.".".$arquivo->localizacao);
		
	 }
	 mysql_query($t="DELETE FROM cliente_fornecedor_arquivo WHERE cliente_fornecedor_id='$dados[cliente_fornecedor_id]'");
	//alert($t);
}

/*--------USADA NO MÓDULO COBRANÇA MENSAL------*/
function exibe_option_sub_plano_ou_centro2($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null){
  
  $pai = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo WHERE id='$pai_id'"));
  
  $q= mysql_query($r="SELECT * FROM 
  							financeiro_centro_custo 
						WHERE 
							cliente_id ='".$_SESSION[usuario]->cliente_vekttor_id ."' 
						AND 
							plano_ou_centro='$plano_ou_centro'  
						AND  
							centro_custo_id = '$pai_id'  
						ORDER BY ordem,nome");
  $nivel++;
  if(strlen($pai_ordem)>0){
  	$pai_ordem = $pai_ordem.'.'.$pai->ordem;
  }else{
  	$pai_ordem = $pai->ordem;
  }
	
  while($r= mysql_fetch_object($q)){
	$filhos = @mysql_result(mysql_query("SELECT count(*) FROM 
  							financeiro_centro_custo 
						WHERE 
							cliente_id ='".$_SESSION['usuario']->cliente_vekttor_id."' 
						AND 
							plano_ou_centro='$plano_ou_centro'  
						AND  
							centro_custo_id = '$r->id'  
						"),0,0);
	
	if($id_do_selecionado==$r->id){		
		$sel="selected='selected'";
	}else{
		$sel='';
	}
	if(strlen($pai_ordem)>0){
		$paiordem= "$pai_ordem.$r->ordem";
	}else{
		$paiordem= "$r->ordem";
	}
	$disabled='';
	if($filhos>0){
		$disabled="disabled='disabled'";
	}
	echo  "<option style=\"padding-left:".($nivel*10)."px\" ordenacao='$paiordem' value='$r->id' $sel $disabled >$paiordem $r->nome</option>";
	
	if($filhos>0){
		exibe_option_sub_plano_ou_centro2($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem);
	}
  }
}
?>