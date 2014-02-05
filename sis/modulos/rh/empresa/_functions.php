<?
//Funções 

//Cliente Fornecedor
function ManipulaEmpresa($dados,$tipo_cadastro){
	
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
	
	if(!$dados['cliente_fornecedor_id']>0){
		$inicio ="INSERT INTO";
		$fim='';
	}else{
		$inicio ="UPDATE";
		$fim="WHERE id='{$dados['cliente_fornecedor_id']}'";
		$fim_empresa="WHERE cliente_fornecedor_id='{$dados['cliente_fornecedor_id']}'";
	}
	
	if($erro==0){
		
		mysql_query($t="
					$inicio cliente_fornecedor SET
					cliente_vekttor_id='".$_SESSION['usuario']->cliente_vekttor_id."',
					usuario_id='".$_SESSION['usuario']->id."',
					razao_social='".$dados['j_razao_social']."',
					nome_fantasia='".$dados['j_nome_fantasia']."',
					nome_contato='".$dados['j_nome_contato']."',
					ramo_atividade='".$dados['j_ramo_atividade']."',
					cnpj_cpf='".$dados['j_cnpj_cpf']."',
					nascimento='".$dados['j_nascimento']."',
					rg='".$dados['j_rg']."',
					local_emissao='".$$dados['j_local_emissao']."',
					data_emissao='".$dados['j_data_emissao']."',
					nacionalidade='".$dados['j_nacionalidade']."',
					naturalidade='".$dados['j_naturalidade']."',
					endereco_comercial='".$dados['j_endereco_comercial']."',
					telefone_comercial='".$dados['j_telefone_comercial']."',
					suframa='".$dados['j_suframa']."',
					inscricao_municipal='".$dados['j_inscricao_municipal']."',
					inscricao_estadual='".$dados['j_inscricao_estadual']."',
					email='".$dados['j_email']."',
					telefone1='".$dados['j_telefone1']."',
					telefone2='".$dados['j_telefone2']."',
					fax='".$dados['j_fax']."',
					cep='".$dados['j_cep']."',
					endereco='".$dados['j_endereco']."',
					bairro='".$dados['j_bairro']."',
					cidade='".$dados['j_cidade']."',
					estado='".$dados['j_estado']."',
					limite='0',
					tipo='cliente',
					tipo_cadastro='".$tipo_cadastro."',
					status='1',
					valor_mensalidade='".MoedaBrToUsa($dados['vlr_mensalidade'])."'
					
					$fim
					");
					echo mysql_error()."<br>";
					
								
					
										//alert($t);
					//echo "<br>";
					
			
			if($dados['cliente_fornecedor_id']>0){
				$cliente_id = $dados['cliente_fornecedor_id'];
			}else{
				$cliente_id = mysql_insert_id();
			}
			
					  mysql_query($t="
					  $inicio rh_empresas SET vkt_id='$vkt_id', 		    																										   				                      cliente_fornecedor_id='$cliente_id', 
					  codigo_interno='{$dados['j_codigo_interno']}',
					    
					  fpas='{$dados['j_fpas']}',
					  nire='".$dados['f_nire']."',
					  nire_filial='".$dados['f_nire_filial']."',
	 				  valor_capital='".MoedaBrToUsa($dados['f_valor_capital'])."',
					  dt_inicio_atividades='".DataBrToUsa($dados['f_inicio_atividades'])."',
					  porte_empresa='{$dados['porte_empresa']}',
					  codigo_recolhimento='{$dados['codigo_recolhimento']}',
					  indicador_recolhimento_fgts='{$dados['indicador_recolhimento_fgts']}',
					  data_recolhimento_fgts='".DataBrToUsa($dados['data_recolhimento_fgts'])."',
					  data_recolhimento_previdencia_social='".DataBrToUsa($dados['data_recolhimento_previdencia_social'])."',
					  porcentagem_rat='".MoedaBrToUsa($dados['porcentagem_rat'])."',
					  codigo_outras_entidades='{$dados['codigo_outras_entidades']}',
					  codigo_pagamento_gps='{$dados['codigo_pagamento_gps']}',
					  codigo_centralizacao='{$dados['codigo_centralizacao']}',
					  simples='{$dados['simples']}'
					  $fim_empresa");
	 				 //echo mysql_error();
					 //echo $t;
					 //alert($cliente_id);
					 return $cliente_id;
			
		
		//salvaUsuarioHistorico("Formulário - ".$tipo,"Cadastrou","cliente_fornecedor",mysql_insert_id());
		
		
		
		}
			
	//return 0;
}

function ManipulaRequerimento($dados){
	
	mysql_query($t="
	UPDATE
	rh_empresas 
	SET
		codigo_ato1='{$dados['codigo_ato1']}',
		descricao_ato1='{$dados['descricao_ato1']}',
		codigo_evento1='{$dados['codigo_evento1']}',
		descricao_evento1='{$dados['descricao_evento1']}',
		codigo_evento2='{$dados['codigo_evento2']}',
		descricao_evento2='{$dados['descricao_evento2']}',
		codigo_evento3='{$dados['codigo_evento3']}',
		descricao_evento3='{$dados['descricao_evento3']}',
		cnae_principal='{$dados['cnae_principal']}',
		objectivo_principal='{$dados['objectivo_principal']}',
		cnae_secundaria_1='{$dados['cnae_secundaria_1']}',
		objectivo_secundaria_1='{$dados['objectivo_secundaria_1']}',
		cnae_secundaria_2='{$dados['cnae_secundaria_2']}',
		objectivo_secundaria_2='{$dados['objectivo_secundaria_2']}'
		WHERE cliente_fornecedor_id='{$dados['cliente_fornecedor_id']}'
	");
	echo $t."<br>".mysql_error();
}

function ManipulaSocio($dados,$tipo_cadastro){
	
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
	
	if(!$dados['socio_id']>0){
		$inicio ="INSERT INTO";
		$fim='';
		$fim_empresa='';
	}else{
		$inicio ="UPDATE";
		$fim="WHERE id='{$dados['socio_id']}'";
		$fim_socio= "WHERE cliente_fornecedor_id='{$dados['socio_id']}'";
	}
	
		
	if($erro==0){
		
		mysql_query($t="
					$inicio cliente_fornecedor SET
					cliente_vekttor_id='".$_SESSION['usuario']->cliente_vekttor_id."',
					usuario_id='".$_SESSION['usuario']->id."',
					razao_social='".$dados['f_nome_contato']."',
					nome_fantasia='".$dados['f_nome_contato']."',
					nome_contato='".$$dados['f_nome_contato']."',
					ramo_atividade='".$dados['f_ramo_atividade']."',
					cnpj_cpf='".$dados['f_cnpj_cpf']."',
					nascimento='".DataBrToUsa($dados['f_nascimento'])."',
					rg='".$dados['f_rg']."',
					local_emissao='".$dados['f_local_emissao']."',
					grau_instrucao='".$dados['f_grau_instrucao']."',
					data_emissao='".DataBrToUsa($dados['f_data_emissao'])."',
					nacionalidade='".$dados['f_nacionalidade']."',
					naturalidade='".$dados['f_naturalidade']."',
					endereco_comercial='".$dados['f_endereco_comercial']."',
					telefone_comercial='".$dados['f_telefone_comercial']."',
					suframa='".$dados['f_suframa']."',
					inscricao_municipal='".$dados['f_inscricao_municipal']."',
					inscricao_estadual='".$dados['f_inscricao_estadual']."',
					email='".$dados['f_email']."',
					telefone1='".$dados['f_telefone1']."',
					telefone2='".$dados['f_telefone2']."',
					fax='".$dados['f_fax']."',
					cep='".$dados['f_cep']."',
					endereco='".$dados['f_endereco']."',
					bairro='".$dados['f_bairro']."',
					cidade='".$dados['f_cidade']."',
					estado='".$dados['f_estado']."',
					limite='0',
					tipo='cliente',
					tipo_cadastro='".$tipo_cadastro."',
					filiacao_mae='".$dados['f_nome_mae']."',
					filiacao_pai='".$dados['f_nome_pai']."',
					casa_numero ='".$dados['f_numero']."',
					complemento ='".$dados['f_complemento']."'	
					$fim
					");
					echo $t."<br>".mysql_error();
					
					if(!$dados['socio_id']>0){
						$socio_id = mysql_insert_id();
					}else{
						$socio_id = $dados['socio_id'];
					}
					
				mysql_query($t="$inicio 
				rh_socios
				SET
				vkt_id='$vkt_id',
				cliente_fornecedor_id='$socio_id',
				valor_contribuicao='".MoedaBrToUsa($dados['f_valor_contribuicao'])."',
				data_assinatura		='".DataBrToUsa($dados['f_data_assinatura'])."'		
				$fim_socio");
					echo $t;
					
										
					$socios = mysql_query($t="SELECT * FROM  rh_empresa_has_socios WHERE vkt_id='$vkt_id' AND empresa_id='{$dados['cliente_fornecedor_id']}' AND socio_id='$socio_id'");
					echo $t;
					if(mysql_num_rows($socios)<=0){
			       		mysql_query($t="$inicio 
				   							rh_empresa_has_socios 
									   SET 
									   		vkt_id = '$vkt_id',
									   		empresa_id='{$dados['cliente_fornecedor_id']}',
											socio_id='$socio_id',
											
										$fim
									");
						echo $t;
					}
					//echo "<br>";
					//echo mysql_error();
		//$cliente_id=mysql_insert_id();
		//salvaUsuarioHistorico("Formulário - ".$tipo,"Cadastrou","cliente_fornecedor",mysql_insert_id());
		
		
		if(strlen($_FILES['foto_cliente']['name'])>3){
			upload_foto($cliente_id,$tipo_cadastro);
		
		}
		if(strlen($_FILES['foto_cliente_fisico']['name'])>3){
			upload_foto($cliente_id,$tipo_cadastro);		
		}
		return 1;
	}
	
	return 0;
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
	mysql_query($t="INSERT INTO cliente_fornecedor_arquivo SET usuario_id='$usuario_id', cliente_fornecedor_id=$dados[cliente_fornecedor_id], descricao = '$dados[documento_descricao]'");	
	echo $t;
	$id = mysql_insert_id();
	
	$filis_autorizados = array('jpg','gif','png','jpeg');
	
	if(strlen($_FILES['documento_arquivo']['name'])>4){
	  $pasta 	= 'modulos/administrativo/clientes/arquivos_clientes/';
	  $extensao = strtolower(substr($_FILES['documento_arquivo']['name'],-3));
	  $arquivo 	= $pasta.$id.'.'.$extensao;
	  $arquivodel= $pasta.$id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['documento_arquivo'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE cliente_fornecedor_arquivo SET localizacao='$extensao' WHERE id='$id'");
			 
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	return $id;
}

function adicionarDocumentoSocio($dados){
	
	global $usuario_id;
	
	$filis_autorizados = array('jpg','gif','png','jpeg');
	
	
	if(strlen($_FILES['documento_arquivo_socio']['name'])>4){
		//alert('oi');
	  mysql_query($t="INSERT INTO cliente_fornecedor_arquivo SET usuario_id='$usuario_id', cliente_fornecedor_id=$dados[socio_id], descricao = '$dados[documento_descricao]'");	
		//echo $t;
	  $id = mysql_insert_id();
	
	  $pasta 	= 'modulos/administrativo/clientes/arquivos_clientes/';
	  //$pasta    = 'arquivos_clientes/';
	  $extensao = strtolower(substr($_FILES['documento_arquivo_socio']['name'],-3));
	  $arquivo 	= $pasta.$id.'.'.$extensao;
	  //alert($arquivo);
	  $arquivodel= $pasta.$id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  
		  if(move_uploaded_file($_FILES['documento_arquivo_socio'][tmp_name],$arquivo)){
			  
			  mysql_query($f="UPDATE cliente_fornecedor_arquivo SET localizacao='$extensao' WHERE id='$id'");
			  //alert($f);
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	return $id;
}

function liga_socio_a_empresa(){
	global $vkt_id;
	$empresa_id = $_GET['empresa_id'];
	$novo_socio = $_GET['novo_socio'];
	
	$verifica_existencia_socio_empresa = mysql_query($t="SELECT * FROM rh_empresa_has_socios WHERE empresa_id='$empresa_id' AND socio_id='$novo_socio' AND vkt_id='$vkt_id'");
	//echo $t;
	if(mysql_num_rows($verifica_existencia_socio_empresa)<=0){
		mysql_query($t="INSERT INTO rh_empresa_has_socios SET empresa_id='$empresa_id', socio_id='$novo_socio', vkt_id='$vkt_id'");
	}else{
		$mensagem = utf8_encode('Este Sócio Já Está Cadastrado Nesta Empresa');
		alert($mensagem);
	}
}


function desliga_socio_a_empresa(){
	
	global $vkt_id;
	
	$empresa_id = $_GET['empresa_id'];
	$novo_socio = $_GET['novo_socio'];
	
	mysql_query($t="DELETE FROM rh_empresa_has_socios WHERE empresa_id='$empresa_id' AND socio_id='$novo_socio' AND vkt_id='$vkt_id'");
	//echo $t;
}

function excluirDocumento($dados){
	$arquivo = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor_arquivo WHERE id='$dados[documento_id]'")); 
	//echo $t;
	@unlink("modulos/administrativo/clientes/arquivos_clientes/".$arquivo->id.".".$arquivo->localizacao);
	mysql_query($t="DELETE FROM cliente_fornecedor_arquivo WHERE id='$dados[documento_id]'");
	//alert($t);
}

function manipulaContrato($dados,$vkt_id,$tipo){
	
	global $vkt_id;
	
	$texto = $dados[texto];
	
	if($dados['contrato_id']>0){
	
		$inicio ="UPDATE";	
		$fim="WHERE id='{$dados['contrato_id']}'";
		
		
	}else{
		
		$inicio ="INSERT INTO";	
		$fim="";
		
	}
	
	$modelo_contrato='';
	if($tipo=='social'){
		$modelo_contrato=", modelo_id='{$dados['modelo_id']}'";
	}
	
	mysql_query($t="$inicio rh_empresa_has_contratos SET vkt_id='$vkt_id', empresa_id='{$dados['cliente_fornecedor_id']}', tipo='$tipo', contrato='$texto' $modelo_contrato $fim");
	//echo $t;
}

function alteraStausEmpresa($status,$id){
	mysql_query($t="UPDATE cliente_fornecedor SET status='0' WHERE id='$id'");
	mysql_query($t="UPDATE rh_empresas SET status='0' WHERE cliente_fornecedor_id='$id'");
	//echo $t;
}
?>