<?php
include("../../../_config.php");
include("../../../_functions_base.php");
	
	$acao = $_POST["acao"];

	
	if($acao == "consultar_aluno"){
		
		$aluno_id = $_POST["aluno_id"];
		
		$sql = mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$aluno_id' ");
		
			$dados = array();
			
	  while($aluno=mysql_fetch_object($sql)){
		  
		  $matricula_aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_matriculas WHERE aluno_id = '$aluno->id' "));
		  
		  $array['id']       = $aluno->id;
		  $array['extensao'] = $aluno->extensao;
		  $array['codigo_interno'] = $aluno->codigo_interno;
		  $array['cor']  = $aluno->cor;
		  $array['nome'] = $aluno->nome;
		  $array['data_nascimento'] = dataUsaToBr($aluno->data_nascimento);
		  $array['sexo']         = $aluno->sexo;
		  $array['endereco']     = utf8_encode($aluno->endereco);
		  $array['bairro']       = utf8_encode($aluno->bairro);
		  $array['complemento']  = utf8_encode($aluno->complemento);
		  $array['telefone1']    = $aluno->telefone1;
		  $array['telefone2']    = $aluno->telefone2;
		  $array['cep']          = $aluno->cep;
		  $array['cidade']       = utf8_encode($aluno->cidade);
		  $array['uf']           = $aluno->uf;
		  $array['rg']           = $aluno->rg;
		  $array['rg_dt_expedicao'] = dataUsaToBr($aluno->rg_dt_expedicao);
		  $array['cpf']          = $aluno->cpf;
		  $array['escolaridade'] = utf8_encode($aluno->escolaridade);
		  $array['profissao']    = utf8_encode($aluno->profissao);
		  $array['email']        = $aluno->email;
		  $array['portador_necessidade'] = $aluno->portador_necessidade;
		  $array['senha'] = $aluno->senha;
		  $array['restricao_alimentar'] = utf8_encode($aluno->restricao_alimentar);
		  $array['img'] = "<img src='modulos/escolar2/aluno/img/".$array['id'].".".$array['extensao']."' height='100' />";
		  
		  /*= FILIAÇÃO =*/
			  
			  /* mae */
			  
			  $array['mae']                = utf8_encode($aluno->mae);
			  $array['cpf_mae']            = $aluno->cpf_mae;
			  $array['tel_mae']            = $aluno->tel_mae;
			  $array['profissao_mae']      = utf8_encode($aluno->profissao_mae);
			  $array['local_trabalho_mae'] = utf8_encode($aluno->local_trabalho_mae);
			  $array['tel_trabalho_mae']   = $aluno->tel_trabalho_mae;
			  $array['email_mae']          = $aluno->email_mae;
			  
			  /* pai */
			  $array['pai']     = utf8_encode($aluno->pai);
			  $array['cpf_pai'] = $aluno->cpf_pai;
			  $array['tel_pai'] = $aluno->tel_pai;
			  $array['profissao_pai']      = utf8_encode($aluno->profissao_pai);
			  $array['local_trabalho_pai'] = utf8_encode($aluno->local_trabalho_pai);
			  $array['tel_trabalho_pai']   = $aluno->tel_trabalho_pai;
			  $array['email_pai']          = $aluno->email_pai;
			  
			  /* transporte */
			  $array['pessoa_trazer_buscar_1'] = utf8_encode($aluno->pessoa_trazer_buscar_1);
			  $array['pessoa_trazer_buscar_2'] = utf8_encode($aluno->pessoa_trazer_buscar_2);
			  $array['pessoa_trazer_buscar_3'] = utf8_encode($aluno->pessoa_trazer_buscar_3);
			  $array['pessoa_trazer_buscar_4'] = utf8_encode($aluno->pessoa_trazer_buscar_4);
			  
			  /* emergencia */
			  $array['pessoa_caso_emergencia_1']   = utf8_encode($aluno->pessoa_caso_emergencia_1);
			  $array['telefone_caso_emergencia_1'] = $aluno->telefone_caso_emergencia_1;
			  $array['pessoa_caso_emergencia_2']   = utf8_encode($aluno->pessoa_caso_emergencia_2);
			  $array['telefone_caso_emergencia_2'] = $aluno->telefone_caso_emergencia_2;
			  
			  /* observação */
			  $array['observacao'] = utf8_encode($aluno->observacao); 
			  $array['contrato']   = utf8_encode($matricula_aluno->contrato);
		  
		  
		  $dados[] = $array;
		  
	  }
	echo json_encode($dados);
		
		
	} else if($acao == "consultar_responsavel" ){
		global $vkt_id;
		$dados_responsavel = array();
		
		$cpf_responsavel = $_POST["cpf_responsavel"];
		
		$sql = mysql_query($ty=" SELECT * FROM cliente_fornecedor WHERE cnpj_cpf = '$cpf_responsavel' AND cliente_vekttor_id = '$vkt_id' ");
			
			while($responsavel=mysql_fetch_object($sql)){
				  
				  $array["id"]   = $responsavel->id;
				  $array["razao_social"]   = utf8_encode($responsavel->razao_social);
				  $array["ramo_atividade"] = utf8_encode($responsavel->ramo_atividade);
				  $array["nascimento"]     = dataUsaToBr($responsavel->nascimento);
				  $array["grau_instrucao"] = $responsavel->grau_instrucao;
				  $array["rg"]             = $responsavel->rg;
				  $array["local_emissao"] = $responsavel->local_emissao;
				  $array["data_emissao"]  = dataUsaToBr($responsavel->data_emissao);
				  $array["estado_civil"]  = $responsavel->estado_civil;
				  $array["naturalidade"]  = utf8_encode($responsavel->naturalidade);
				  $array["nacionalidade"] = utf8_encode($responsavel->nacionalidade);
			      $array["email"]         = $responsavel->email;
				  $array["telefone1"]     = $responsavel->telefone1;
				  $array["telefone2"]     = $responsavel->telefone2;
				  $array["fax"]       = $responsavel->fax;
				  $array["cep"]      = $responsavel->cep;
				  $array["endereco"] = utf8_encode($responsavel->endereco);
				  $array["bairro"] = utf8_encode($responsavel->bairro);
				  $array["cidade"] = utf8_encode($responsavel->cidade);
				  $array["estado"] = utf8_encode($responsavel->estado);
				  
				  $dados_responsavel[] = $array;
			}
			
			echo json_encode($dados_responsavel);
		
	} else if($acao == "remove_serie_has_materia"){
		
		  
	} else if($acao == "remove_serie"){
		
			
		
	}
	









?>