<?

function ManipulaFuncionario($dados){
	global $vkt_id;
	
	if(!empty($dados['vendedor'])){
		$vendedor="s";		
	}else{
		$vendedor="n";
	}
	
	if($dados['id']>0){
		$inicio="UPDATE";
		$fim="WHERE id=".$dados['id'];
		$numero_sequencial_empresa = $dados['f_numero_sequencial_empresa'];
	}else{
		$inicio="INSERT INTO";
		$fim="";
		
		if(empty($dados['f_numero_sequencial_empresa'])){
		
			$numero_sequencial = mysql_num_rows(mysql_query("SELECT * FROM rh_funcionario WHERE empresa_id='".$dados['f_empresa_id']."'"));
		
			$numero_sequencial_empresa = $numero_sequencial+1;
		
		}else{
		
			$numero_sequencial_empresa = $dados['f_numero_sequencial_empresa'];
		
		}
	}
	//alert($numero_sequencial_empresa);
	mysql_query($t="
			$inicio  SET
			vkt_id=' $vkt_id',
			nome = '{$campos[nome]}',
			cargo_id = '{$campos[cargo]}',
			vendedor = '$vendedor'
			$fim	
	");
	//alert($dados['f_nome_conjugue']);
	mysql_query($t="
					$inicio rh_funcionario SET
					vkt_id='".$vkt_id."',
					nome='".$dados['f_nome']."',
					filiacao_pai='".$dados['f_filiacao_pai']."',
					filiacao_mae='".$dados['f_filiacao_mae']."',
					telefone1='".$dados['f_telefone1']."',
					telefone2='".$dados['f_telefone2']."',
					data_nascimento='".DataBrToUsa($dados['f_nascimento'])."',
					
					carteira_profissional_numero='".$dados['f_carteira_profissional_numero']."',
					carteira_profissional_serie='".$dados['f_carteira_profissional_serie']."',
					carteira_profissional_estado_emissor='".$dados['f_carteira_profissional_estado_emissor']."',
					carteira_profissional_data_expedicao='".DataBrToUsa($dados['f_carteira_profissional_data_expedicao'])."',
					carteira_reservista='".$dados['f_carteira_reservista']."',
					categoria='".$dados['f_categoria']."',
					pis='".$dados['f_pis']."',
					cpf='".$dados['f_cpf']."',
					rg='".$dados['f_rg']."',
					sexo='".$dados['f_sexo']."',
					cor='".$dados['f_cor']."',
					rg_orgao_emissor='".$dados['f_local_emissao']."',
					rg_data_emissao='".DataBrToUsa($dados['f_data_emissao'])."',
					data_admissao='".DataBrToUsa($dados['f_data_admissao'])."',
					estado_civil='".$dados['f_estado_civil']."',
					tipo_admissao='".$dados['f_tipo_admissao']."',
					sabe_ler_escrever='".$dados['f_ler_escrever']."',
					grau_instrucao='".$dados['f_grau_instrucao']."',
					certificado='".$dados['f_certificado']."',
					filiacao_sindicato='".$dados['f_filiacao_sindicato']."',
					sindicato='".$dados['f_sindicato']."',
					quando_estrangeiro='".$dados['f_quando_estrangeiro']."',
					nome_conjugue='".$dados['f_nome_conjugue']."',					
					data_chegada_brasil='".DataBrToUsa($dados['f_data_chegada_brasil'])."',
					naturalizado='".$dados['f_naturalizado']."',
					estado_naturalizado='".$dados['f_naturalizado_estado']."',
					carteira_estrangeira_modelo='".$dados['f_carteira_estrangeira_modelo']."',
					carteira_estrangeira_numero='".$dados['f_carteira_estrangeira_numero']."',
					carteira_estrangeira_serie='".$dados['f_carteira_estrangeira_serie']."',
					carteira_estrangeira_data_expedicao='".DataBrToUsa($dados['f_carteira_estrangeira_data_expedicao'])."',
					
					naturalidade='".$dados['f_naturalidade']."',
					nacionalidade='".$dados['f_nacionalidade']."',
					email='".$dados['f_email']."',
					cep='".$dados['f_cep']."',
					endereco='".$dados['f_endereco']."',
					casa_numero='".$dados['f_numero']."',
					complemento='".$dados['f_complemento']."',
					bairro='".$dados['f_bairro']."',
					cidade='".$dados['f_cidade']."',
					estado='".$dados['f_estado']."',
					empresa_id='".$dados['f_empresa_id']."',
					cargo_id='".$dados['f_cargo_id']."',
					cbo='".$dados['f_cbo']."',
					salario='".MoedaBrToUsa($dados['f_salario'])."',
					cargo='".$dados['f_cargo']."',
					vendedor='$vendedor',
					passaporte_numero='".$dados['f_passaporte_numero']."',
					passaporte_emissor='".$dados['f_passaporte_emissor']."',
					passaporte_estado_emissor='".$dados['f_passaporte_estado_emissor']."',
					data_emissao_passaporte='".DataBrToUsa($dados['f_data_emissao_passaporte'])."',
					data_validade_passaporte='".DataBrToUsa($dados['f_data_validade_passaporte'])."',
					pais_origem='".$dados['f_pais_origem']."',
					uf_nascimento='".$dados['f_uf_nascimento']."',
					municipio_nascimento='".$dados['f_municipio_nascimento']."',
					pais_emissao_passaporte='".$dados['f_pais_emissao_passaporte']."',
					titulo_eleitor_numero='".$dados['f_titulo_eleitor_numero']."',
					titulo_eleitor_zona='".$dados['f_titulo_eleitor_zona']."',
					titulo_eleitor_secao='".$dados['f_titulo_eleitor_secao']."',
					portaria_naturalizacao_numero='".$dados['f_portaria_naturalizacao_numero']."',
					portaria_naturalizacao_data='".DataBrToUsa($dados['f_portaria_naturalizacao_data'])."',
					ric_numero='".$dados['f_ric_numero']."',
					ric_uf='".$dados['f_ric_uf']."',
					ric_emissor='".$dados['f_ric_emissor']."',
					ric_municipio='".$dados['f_ric_municipio']."',
					ric_data_expedicao='".DataBrToUsa($dados['f_ric_data_expedicao'])."',
					certidao_civil_tipo=	'".$dados['f_certidao_civil_tipo']."',
					certidao_civil_data_emissao=	'".DataBrToUsa($dados['f_certidao_civil_data_emissao'])."',	
					certidao_civil_matricula=	'".$dados['f_certidao_civil_matricula']."',
					certidao_civil_livro =	'".$dados['f_certidao_civil_livro']."',
					certidao_civil_folha=	'".$dados['f_certidao_civil_folha']."',
					certidao_civil_uf=	'".$dados['f_certidao_civil_uf']."',
					certidao_civil_municipio=	'".$dados['f_certidao_civil_municipio']."',
					certidao_civil_cartorio=	'".$dados['f_certidao_civil_cartorio']."',
					cod_sindicato          =    '".$dados['f_cod_sindicato']."',
					cnpj_sindicato         =    '".$dados['f_cnpj_sindicato']."',
					pensao_alimenticia_trct         =    '".MoedaBrToUsa($dados['f_pensao_alimenticia_trct'])."',
					pensao_alimenticia_fgts	        =    '".MoedaBrToUsa($dados['f_pensao_alimenticia_fgts'])."',
					adicional_insalubridade         =    '".MoedaBrToUsa($dados['f_adicional_insalubridade'])."', 
					adicional_periculosidade        =    '".MoedaBrToUsa($dados['f_adicional_periculosidade'])."',
					vale_transporte                 =    '".MoedaBrToUsa($dados['f_vale_transporte'])."',
					hora_inicio_expediente          =    '".$dados['f_inicio_expediente']."',
					hora_fim_expediente          =    '".$dados['f_fim_expediente']."',
					duracao_intervalo            =    '".$dados['f_duracao_intervalo']."',
					numero_sequencial_empresa    =    '$numero_sequencial_empresa',
					livro                        =    '".$dados['f_livro']."'
				
					$fim
					");
					
					//echo $t.mysql_error();
					
						if($dados['id']>0){
							$id=$dados['id'];
						}else{
							$id=mysql_insert_id();
						}
						
						return $id;				
	
	//echo "mysql_insert_id: ".mysql_insert_id();
	
}

function ManipulaDependente($dados){
	
	global $vkt_id;
	
	$nome = str_replace("_"," ",$dados['nome']);
	
	mysql_query($t="INSERT INTO 
							rh_funcionario_dependentes 
						SET 
							vkt_id='$vkt_id',
							funcionario_id='".$dados['funcionario_id']."',
							nome='".$nome."',
							data_nascimento='".DataBrToUsa($dados['data_nascimento'])."',
							grau_parentesco='".$dados['grau_parentesco']."'
							"
						);
	
}

function remove_dependente($dados){
	
	global $vkt_id;
	
	$id = $dados['dependente_id'];
		
	mysql_query($t="DELETE FROM rh_funcionario_dependentes WHERE id='$id'");
	//echo $t;
}

/*function altera_funcionario($campos){
	global $vkt_id;
	
	if(!empty($campos['vendedor'])){
		$vendedor="s";		
	}else{
		$vendedor="n";
	}
	
	mysql_query("
			UPDATE rh_funcionario SET
				vkt_id=' $vkt_id',
				nome='{$campos[nome]}',
			    cargo_id = '{$campos[cargo]}',
				vendedor = '$vendedor'
			WHERE
				id='{$campos[id]}'
	");
	
}*/

function ManipulaDocumento($dados){
	global $vkt_id;
	mysql_query($t="INSERT INTO rh_funcionarios_documentos SET  vkt_id='$vkt_id', funcionario_id='{$dados['id']}',descricao='{$dados['documento_descricao']}'");
	echo $t;

	$arquivo_id=mysql_insert_id();
	
	
	if(strlen($_FILES['documento_arquivo']['name'])>3){
		
		documento_envia_arquivo($arquivo_id);
	}
}

function documento_envia_arquivo($arquivo_id){
	
	$filis_autorizados = array('jpg','gif','png','pdf');
	
	$infomovimento = mysql_fetch_object(mysql_query($f="SELECT * FROM rh_funcionarios_documentos WHERE id='$arquivo_id'"));
	
	if(strlen($_FILES['documento_arquivo']['name'])>4){
	  $pasta 	= 'modulos/rh/funcionarios/documentos/';
	  $extensao = strtolower(substr($_FILES['documento_arquivo']['name'],-3));
	  $arquivo 	= $pasta.$arquivo_id.'.'.$extensao;
	  $arquivodel= $pasta.$arquivo_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['documento_arquivo'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE rh_funcionarios_documentos SET extensao='$extensao' WHERE id='$arquivo_id'");
			 
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
}

function manipulaContrato($dados,$vkt_id){
	
	global $vkt_id;
	
	$texto = $dados[texto];
	
		
	mysql_query($t="UPDATE rh_funcionario SET vkt_id='$vkt_id', contrato='$texto' WHERE id='{$dados['id']}'");
	//echo $t."<br>";
	//echo mysql_error();
}

function remove_documento($dados){
	
	global $vkt_id;
	
	$id = $dados['documento_id'];
	$ultimo = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionarios_documentos WHERE id=".$id));
	//echo $t;
	@unlink("documentos/".$ultimo->id.".".$ultimo->extensao);	
	mysql_query($t="DELETE FROM rh_funcionarios_documentos WHERE id='$id'");
	//echo $t;
}

function deletar_funcionario($id){
	mysql_query("
			DELETE FROM 
				rh_funcionario
			WHERE
				id='$id'
	");
}

?>