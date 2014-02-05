<?php

$tabela = "matriculas";


	function get_nome($nome = NULL, $tamanho = NULL){
	
			if( !empty($nome) and !empty($tamanho) ){
			if( strlen($nome) > $tamanho )
				echo substr($nome,0,$tamanho)."...";
			else
				echo $nome;
			}
			
	}
	function get_nome_unidade($nome = NULL){
	
			if( strlen($nome) > 20 )
				echo substr($nome,0,20)."...";
			else
				echo $nome;
			
	}

	function cadastra_responsavel(){
		global $vkt_id;
		
		mysql_query ($ty=" INSERT INTO cliente_fornecedor 
		SET
		 cliente_vekttor_id = '$vkt_id', 
		 razao_social       = '{$_POST['nome_responsavel']}',
		 nome_fantasia      = '{$_POST['nome_responsavel']}',
		 nome_contato       = '{$_POST['nome_responsavel']}',
		 ramo_atividade     = '{$_POST['ramo_atividade_responsavel']}',
		 nascimento         = '".dataBrToUsa($_POST['f_nascimento'])."',
		 cnpj_cpf           = '{$_POST['f_cnpj_cpf']}',
		 rg                 = '{$_POST['f_rg']}',
		 local_emissao      = '{$_POST['f_local_emissao']}',
		 data_emissao       = '".dataBrToUsa($_POST['f_data_emissao'])."',
		 email              = '{$_POST['f_email']}',
		 telefone1          = '{$_POST['f_telefone1']}',
		 telefone2          = '{$_POST['f_telefone2']}',
		 fax                = '{$_POST['f_fax']}',
		 cep                = '{$_POST['f_cep']}',
		 endereco           = '{$_POST['f_endereco']}',
		 bairro             = '{$_POST['f_bairro']}',
		 cidade             = '{$_POST['f_cidade']}',
		 estado             = '{$_POST['f_estado']}',
		 tipo               = '{$_POST['tipo']}',
		 tipo_cadastro      = '{$_POST['tipo_cadastro']}',
		 estado_civil       = '{$_POST['f_estado_civil']}',
		 naturalidade       = '{$_POST['f_naturalidade']}',
		 nacionalidade      = '{$_POST['f_nacionalidade']}',
		 grau_instrucao     = '{$_POST['f_grau_instrucao']}',
		 extensao           = '{$_POST['']}' ");
		 
		 $responsavel = mysql_insert_id();
		 
		 return $responsavel;
		
	}

  //Atualiza Responsável
  function atualiza_responsavel($responsavel_id){
	  
	  global $vkt_id;
	  
	  mysql_query ($ty=" UPDATE cliente_fornecedor 
	  SET
		 cliente_vekttor_id = '$vkt_id', 
		 razao_social       = '{$_POST['nome_responsavel']}',
		 nome_fantasia      = '{$_POST['nome_responsavel']}',
		 nome_contato       = '{$_POST['nome_responsavel']}',
		 ramo_atividade     = '{$_POST['ramo_atividade_responsavel']}',
		 nascimento         = '".dataBrToUsa($_POST['f_nascimento'])."',
		 cnpj_cpf           = '{$_POST['f_cnpj_cpf']}',
		 rg                 = '{$_POST['f_rg']}',
		 local_emissao      = '{$_POST['f_local_emissao']}',
		 data_emissao       = '".dataBrToUsa($_POST['f_data_emissao'])."',
		 email              = '{$_POST['f_email']}',
		 telefone1          = '{$_POST['f_telefone1']}',
		 telefone2          = '{$_POST['f_telefone2']}',
		 fax                = '{$_POST['f_fax']}',
		 cep                = '{$_POST['f_cep']}',
		 endereco           = '{$_POST['f_endereco']}',
		 bairro             = '{$_POST['f_bairro']}',
		 cidade             = '{$_POST['f_cidade']}',
		 estado             = '{$_POST['f_estado']}',
		 tipo               = '{$_POST['tipo']}',
		 tipo_cadastro      = '{$_POST['tipo_cadastro']}',
		 estado_civil       = '{$_POST['f_estado_civil']}',
		 naturalidade       = '{$_POST['f_naturalidade']}',
		 nacionalidade      = '{$_POST['f_nacionalidade']}',
		 grau_instrucao     = '{$_POST['f_grau_instrucao']}',
		 extensao           = '{$_POST['']}' 
	  WHERE 
		  id = '$responsavel_id' ");
	  
  } /* Fim da funcao */




function cadastra_matricula(){
	
	global $vkt_id;
	
	if (empty($_POST['matricula_id']) ){
	  
	  mysql_query( $cm=" INSERT INTO escolar2_matriculas SET 
		  vkt_id         = '$vkt_id',
		  turma_id       = '{$_POST['turma_id']}',
		  turma_id_2     = '{$_POST['turma_id_2']}', 
		  aluno_id       = '{$_POST['aluno_id']}',
		  situacao       = 'cursando',
		  responsavel_id = '{$_POST['responsavel_id']}',    
		  matricula_rematricula = '{$_POST['tipo_matricula']}',
		  status         = 'matricula',
		  contrato       = '{$_POST['texto']}',
		  modelo_contrato_id = '{$_POST['modelo_id']}',
		  valor_matricula    = '".moedaBrToUsa($_POST['valor_matricula'])."',
		  valor_mensalidade  = '".moedaBrToUsa($_POST['valor_mensalidade'])."' 
	   ");
		echo mysql_error();
		$id_matricula = mysql_insert_id();
		return $id_matricula;
	} else {
		 mysql_query( $cm=" UPDATE escolar2_matriculas SET 
		  vkt_id         = '$vkt_id',
		  situacao       = 'cursando',
		  responsavel_id = '{$_POST['responsavel_id']}',    
		  matricula_rematricula = '{$_POST['tipo_matricula']}',
		  status         = 'matricula',
		  contrato       = '{$_POST['texto']}',
		  modelo_contrato_id = '{$_POST['modelo_id']}',
		  valor_matricula    = '".moedaBrToUsa($_POST['valor_matricula'])."',
		  valor_mensalidade  = '".moedaBrToUsa($_POST['valor_mensalidade'])."'  WHERE id = ".trim($_POST['matricula_id'])." ");
		  return $_POST['matricula_id'];
		
	}
	
}/* Fim da funcao  */

function cadastra_usuario_login(){

	global $vkt_id;
	$config = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_config "));
	
	$acao = "";
	$where = "";
	
	if (!empty($_POST['aluno_id'])){
		$acao = "UPDATE";
		$where = "WHERE login = '" . mysql_real_escape_string($_POST['aluno_id']) . "'";
	} 
	
	if(!empty($_POST['aluno_id_busca'])){
			
			$acao = "UPDATE";
			$where = "WHERE login = '" . mysql_real_escape_string($_POST['aluno_id_busca']) . "'";
			
			$_POST['aluno_id'] = $_POST['aluno_id_busca'];
	
	}  else {
		$acao = " INSERT INTO ";
		$_POST['aluno_id'] = $_POST['aluno_id_usuario']; 
		$where = "";
	}
	
	mysql_query($t=" $acao usuario SET  
		cliente_vekttor_id = '$vkt_id',
		usuario_tipo_id    = '$config->aluno_usuario_tipo_id',
		nome               = '".$_POST['nome_aluno']."',
		login              = '".$_POST['aluno_id']."',
		senha              = '".$_POST['senha']."',
		status             = '1'
		$where ");
	
	$usuario_id = mysql_insert_id();
	
	if(!empty($usuario_id)){
		mysql_query(" UPDATE escolar2_alunos SET usuario_id = '$usuario_id' WHERE id = '".$_POST['aluno_id']."' ");
	}
		
	//echo $t;  
		
}

  function cadastra_aluno() {
	  
	  global $vkt_id;
	  
	  $acao = "";
	  $where = "";
	  
	  if (!empty($_POST['aluno_id'])){	  
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($_POST['aluno_id']) . "'";
		
		  //verifica responsável
		  if(!empty($_POST['responsavel_id'])){
			  $_POST["responsavel_id"] = $_POST['responsavel_id'];
			  atualiza_responsavel($_POST['responsavel_id']);
		  } else{
			  $_POST["responsavel_id"] =  cadastra_responsavel();
		  }
	  } 
	  
	  else if(!empty($_POST['aluno_id_busca'])){
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($_POST['aluno_id_busca']) . "'";
		
		$_POST['aluno_id'] = $_POST['aluno_id_busca'];
		
		//verifica responsável
		if(!empty($_POST['responsavel_id'])){
			$_POST["responsavel_id"] = $_POST['responsavel_id'];
			atualiza_responsavel($_POST['responsavel_id']);
		} else{
			$_POST["responsavel_id"] =  cadastra_responsavel();
		}
	  } 
	  
	  else {	
		
		$acao = "INSERT INTO";
			//verifica responsável
			if(!empty($_POST['responsavel_id'])){
				$_POST["responsavel_id"] = $_POST['responsavel_id'];
				atualiza_responsavel($_POST['responsavel_id']);
			} else{
				$_POST["responsavel_id"] =  cadastra_responsavel();
			}	
	  }
	  
	  
	  mysql_query ($ty=" $acao escolar2_alunos
	  SET
		  vkt_id = '$vkt_id',
		  codigo_interno     = '{$_POST['codigo_interno']}',
		  cor                = '{$_POST['cor']}',
		  nome               = '{$_POST['nome_aluno']}',
		  data_nascimento    = '".dataBrToUsa($_POST['data_nascimento_aluno'])."',
		  sexo               = '{$_POST['sexo_aluno']}',
		  endereco           = '{$_POST['endereco']}',
		  bairro             = '{$_POST['bairro']}',
		  complemento        = '{$_POST['complemento']}',
		  telefone1          = '{$_POST['telefone1']}',
		  telefone2          = '{$_POST['telefone2']}',
		  cep                = '{$_POST['cep']}',
		  cidade             = '{$_POST['cidade']}',
		  uf                 = '{$_POST['uf']}',
		  rg                 = '{$_POST['rg_aluno']}',
		  rg_dt_expedicao    = '".dataBrToUsa($_POST['rg_dt_expedicao'])."',
		  cpf                = '{$_POST['cpf_aluno']}',
		  escolaridade       = '{$_POST['escolaridade_aluno']}',
		  profissao          = '{$_POST['profissao']}',
		  email              = '{$_POST['email']}',
		  mae                = '{$_POST['mae']}',
		  cpf_mae            = '{$_POST['cpf_mae']}',
		  tel_mae            = '{$_POST['telefone_mae']}',
		  profissao_mae      = '{$_POST['profissao_mae']}',
		  local_trabalho_mae = '{$_POST['local_trabalho_mae']}',
		  tel_trabalho_mae   = '{$_POST['tel_trabalho_mae']}',
		  email_mae          = '{$_POST['email_mae']}',
		  pai                = '{$_POST['pai']}',
		  cpf_pai            = '{$_POST['cpf_pai']}',
		  tel_pai            = '{$_POST['telefone_pai']}',
		  profissao_pai      = '{$_POST['profissao_pai']}',
		  local_trabalho_pai = '{$_POST['local_trabalho_pai']}',
		  tel_trabalho_pai   = '{$_POST['tel_trabalho_pai']}',
		  email_pai          = '{$_POST['email_pai']}',
		  pessoa_trazer_buscar_1 = '{$_POST['pessoa_trazer_buscar_1']}',
		  pessoa_trazer_buscar_2 = '{$_POST['pessoa_trazer_buscar_2']}',
		  pessoa_trazer_buscar_3 = '{$_POST['pessoa_trazer_buscar_3']}',
		  pessoa_trazer_buscar_4 = '{$_POST['pessoa_trazer_buscar_4']}',
		  pessoa_trazer_buscar_5 = '{$_POST['pessoa_trazer_buscar_5']}',
		  doc_trazer_buscar_5    = '{$_POST['doc_trazer_buscar_5']}',
		  pessoa_trazer_buscar_6 = '{$_POST['pessoa_trazer_buscar_6']}',
		  doc_trazer_buscar_6    = '{$_POST['doc_trazer_buscar_6']}',
		  pessoa_caso_emergencia_1   = '{$_POST['pessoa_emergencia_1']}',
		  telefone_caso_emergencia_1 = '{$_POST['fone_emergencia_1']}', 
		  pessoa_caso_emergencia_2   = '{$_POST['pessoa_emergencia_2']}',
		  telefone_caso_emergencia_2 = '{$_POST['fone_emergencia_2']}',
		  restricao_alimentar        = '{$_POST['restricao_alimentar']}',
		  senha                      = '{$_POST['senha']}',
		  observacao			     = '{$_POST['observacao']}',
		  portador_necessidade       = '{$_POST['portador_necessidade']}' 
		  $where ");
	   
	   
	   if($_POST['aluno_id'] > 0){
		   $aluno_id = $_POST['aluno_id'];
	   }else{
		  $aluno_id = mysql_insert_id();
		  $_POST['aluno_id'] = mysql_insert_id();
		  $_POST['aluno_id_usuario'] = mysql_insert_id();
	   }
	   
	   
	  $extensao = getExtensao($_FILES['file']['name'][0]);
	  if($extensao!='php'){
		  if(move_uploaded_file($_FILES['file']['tmp_name'][0], "modulos/escolar2/aluno/img/".$aluno_id.".$extensao")){
			  
			  mysql_query($ql="UPDATE escolar2_alunos set extensao = '$extensao' WHERE id = '$aluno_id' AND vkt_id='$vkt_id'");
		  }
	  }	
	  
  /* CADASTRA MATRÍCULA */	
  $matricula_id = cadastra_matricula();
  
  /* CADASTRA USUARIO PARA LOGIN */
   cadastra_usuario_login();
   
  /* IMPRESSÕES */ 
	if($_POST['imprimir_boleto'] == '1'){
		echo "<script>window.open('modulos/escolar2/matricula_confirmacao/imprimir_boleto.php?matricula_id=$matricula_id','_BLANK');</script>";	
	} if($_POST['imprimir_contrato'] == '1'){
		 echo "<script>window.open('modulos/escolar2/matricula_confirmacao/impressao_contrato.php?matricula_id=$matricula_id','_BLANK');</script>";
	}
	
  /* INSERE NO BANCO DE DADOS DO FINANCEIRO */
	  
	  $select_conta = mysql_fetch_object(mysql_query($tm=" SELECT * FROM escolar2_unidades WHERE id = '".$_POST['unidade']."' AND vkt_id = '$vkt_id' AND cobrar = '1' "));
  
	  if(!empty($select_conta->id)){
	  
	  $aMes = date('Y/m');
	  $data_registro = date('Y-m-d');
			  
			$sql = " INSERT INTO financeiro_movimento 
				 SET
					cliente_id         = '$vkt_id',
					conta_id		     = '".$select_conta->conta_id."',
					internauta_id	     = '".$responsavel_id."',
					data_registro      = '".$data_registro."',
					data_vencimento	 = '".dataBrToUsa($_POST['data_vencimento'])."',
					ano_mes_referencia = '$aMes',
					descricao		     = 'MATRICULA',
					doc				 = '$matricula_id',
					forma_pagamento    = '4',
					valor_cadastro     = '".moedaBRToUsa($_POST['valor_matricula'])."',
					tipo               = 'receber',
					status             = '0' 
				";
				//echo $sql;
				mysql_query($sql);
				
				$movID = mysql_insert_id();
				
				/*- SQL PARA TABELA financeiro_centro_has_movimento -*/
				$sqlCentroAsMov = " INSERT INTO financeiro_centro_has_movimento
										SET
											movimento_id = '$movID',
											plano_id     = '".$select_conta->centro_custo_id."',
											valor        = '".moedaBRToUsa($_POST['valor_matricula'])."'";
				mysql_query($sqlCentroAsMov); 
				//echo $sqlCentroAsMov;
				
				/*- SQL PARA A TABELA financeiro_plano_has_movimento -*/ 
				 $sqlPlanoAsMov = " INSERT INTO financeiro_plano_has_movimento 
										SET
											movimento_id = '$movID',
											plano_id     = '".$select_conta->plano_conta_id."',
											valor        = '".moedaBRToUsa($_POST['valor_matricula'])."'
										";
				mysql_query($sqlPlanoAsMov);
				//echo $sqlPlanoAsMov;
				
				  
	  }
	  
  } /*fim*/


function remove_imgem($id){
	global $tabela,$vkt_id;
	$info = mf(mq("SELECT * FROM escolar2_alunos WHERE id='$id' AND vkt_id='$vkt_id'"));
	$extensao = $info->extensao;
	if($info->id>0){
		unlink("modulos/escolar2/aluno/img/".$id.".$extensao");
		mysql_query($q="UPDATE escolar2_alunos 	SET extensao ='' WHERE id= '$id' AND vkt_id='$vkt_id'");
	}
	
} /* Fim da Funcao */


function Pagamento($campos){ 
	
			global $vkt_id;
					
			if(empty($campos['ContaID'])){
					echo "<script> alert('Selecione uma Conta');</script>";
					exit;
			}
					
		  if($campos['executado'] == 0){ $campos['executado']='3'; }
		  $sqlPag = mysql_query(" UPDATE os SET pago = 'sim', status_os     = '$campos[executado]', data_execucao = '".dataBrToUsa($campos['data_execucao'])."' WHERE id = '$campos[id]'");
		  
		  
		  if($campos['forEntrega'] > 0){
			  Entrega($campos);		
		  }
					
				
			
			
			
			$contaID       = $campos['conta_id'];
			$centroCustoID = $campos['centro_custo_id'];
			$plContaID     = $campos['plano_de_conta_id'];
			
			$valorParcela = $campos['valor_parcela'];
			$desParcela   = $campos['descricao_parcela'];
			$dataVencimento = $campos['data_vencimento_parcela'];
			$aMes = date('Y/m');
			
			//echo "<div id='conteudo'>aqui esta a afuncao</div>";
				for($i=0;$i < sizeof($valorParcela);$i++){
											$sql = " INSERT INTO financeiro_movimento 
												SET
													cliente_id        = '$vkt_id',
													conta_id		  = '$contaID',
													internauta_id	  = '".$campos['cliente_id']."',
													data_registro     = '".dataBrToUsa($campos['data_aprovacao'])."',
													data_vencimento	  = '".dataBrToUsa($dataVencimento[$i])."',
													ano_mes_referencia = '$aMes',
													descricao		  = '".$desParcela[$i]."',
													doc				  = '".$campos['id']."',
													forma_pagamento   = '".$campos['forma_pagamento']."',
													valor_cadastro    = '".moedaBRToUsa($valorParcela[$i])."',
													tipo              = 'receber',
													status            = '0' 
												";
												//echo $sql;
												mysql_query($sql);
												$movID = mysql_insert_id();
												
												/*- SQL PARA TABELA financeiro_centro_has_movimento -*/
												$sqlCentroAsMov = " INSERT INTO financeiro_centro_has_movimento
																		SET
																			movimento_id = '$movID',
																			plano_id     = '$centroCustoID[$i]',
																			valor        = '".moedaBRToUsa($valorParcela[$i])."'";
												mysql_query($sqlCentroAsMov); 
												//echo $sqlCentroAsMov;
												
												/*- SQL PARA A TABELA financeiro_plano_has_movimento -*/ 
												 $sqlPlanoAsMov = " INSERT INTO financeiro_plano_has_movimento 
												 						SET
																			movimento_id = '$movID',
																			plano_id     = '$plContaID[$i]',
																			valor        = '".moedaBRToUsa($valorParcela[$i])."'
																		";
												mysql_query($sqlPlanoAsMov);
												//echo $sqlPlanoAsMov;
				}
	}


?>