<?php
include_once("../../../_config.php");
include_once("functions_sefip.php");
	
	$mes_competencia = htmlspecialchars($_GET["mes_competencia"]);
	$ano_competencia = $_GET["ano_competencia"];
	$empresa_id      = $_GET["empresa_id"];
	$salario_maternidade = $_GET['salario_maternidade'];
	
    $modalidade_arquivo          = $_GET["modalidade_arquivo"]; // vem do formulario de exporta��o
    $indicador_recolhimento_ps   = $_GET["indicador_recolhimento_ps"]; //"1"; // vem do formulario de exporta��o
    $tipo_remessa                = $_GET["tipo_remessa"]; //"1"; // vem do formulario de esporta��o
	 	
	
	$array_opcoes = array( 0 => "00", 1 => "10", 2 => "30", 3 => "90");
	
	$sql_folha_empresa = mysql_fetch_object(mysql_query(" SELECT * FROM rh_folha_empresa WHERE vkt_id = '$vkt_id' AND mes = '".($mes_competencia - 1)."' AND ano = '$ano_competencia' AND empresa_id = '$empresa_id' "));
	$empresa_folha_id = $sql_folha_empresa->id; 
    
	$sql_cliente_empresa = mysql_fetch_object(mysql_query( "SELECT * FROM rh_empresas WHERE cliente_fornecedor_id = '$empresa_id' "));
	
	/*===================: Dados para preenchimento do arquivo :======================*/
	
	/* LEGENDA DE VARI�VEL
	* ps  = Previdencia Social;
	* fp  = Folha de Pagamento;
	* t00 = Registro Tipo 00
	* t10 = Registro Tipo 10
	* t30 = Registro Tipo 30
	* t32 = Registro Tipo 32
	*/ 
	
	/*-: REGISTRO TIPO 00 :-*/
		
	$tipo_incricao_responsavel = "1";
	
	
  /*  Se o arquivo nao existir ele cria, se j� existir � Subscrevido */  
  $sefip = fopen("SEFIP.RE", "w");
  	
  /* SQL EMPRESA */
  $empresa = mysql_fetch_object(mysql_query(" SELECT * FROM rh_empresas WHERE id = '$sql_cliente_empresa->id' AND vkt_id = '$vkt_id' "));
  $indicador_recolhimento_fgts = $empresa->indicador_recolhimento_fgts;
  $codigo_outras_entidades     = $empresa->codigo_outras_entidades; //"0000";
  $codigo_centralizacao        = $empresa->codigo_centralizacao;
  $codigo_pagamento_gps        = $empresa->codigo_pagamento_gps;
  $codigo_recolhimento         = $empresa->codigo_recolhimento;
  $cnae_empresa                = $empresa->cnae_principal;
  $alicota_rat                 = $empresa->porcentagem_rat;
  $simples                     = $empresa->simples;
  $fpas                        = $empresa->fpas;
  $percentual_isencao_filantropia = "";
  
   /* SQL RESPONSAVEL */
   $responsavel = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$empresa->cliente_fornecedor_id' "));
   $inscricao_fornecedor_fp = retirar_caracter($responsavel->cnpj_cpf); /* Registro Tipo 10 */
   $competencia             = $ano_competencia.$mes_competencia;
   
   /* SQL FUNCIONARIO */
   $sql_funcionario = mysql_query($tt="SELECT * FROM rh_funcionario WHERE empresa_id = '$empresa->cliente_fornecedor_id' AND status = 'admitidos' ORDER BY pis ");
   		
		/* Variaveis Global */
		$inscricao_empresa_cnpj = retirar_caracter($responsavel->cnpj_cpf);
		$inscricao_empresa_cei = "";
		$tipo_inscricao_empresa = "1";
		$espaco_branco = "";
		$final_linha = "*";
		$movimentacao = "";
  
  $indice_recolhimento_atraso_ps = ""; // Campo deve ficar em Branco
  $tipo_inscricao_fornecedor_fp  = "1"; // S� poder ser 1(CNPJ), 2(CEI) ou 3(CPF)
  
   
   /* Salario Familia*/
   $salario_familia_valor = mysql_result(mysql_query(" SELECT sum(salario_familia_valor) FROM rh_folha_funcionarios WHERE rh_folha_id = '$empresa_folha_id' "),0,0); 
  
  /* Tratamento para data de Recolhimento da PrevidenciaSocial */
  if($empresa->data_recolhimento_previdencia_social == "0000-00-00"){
	$data_recolhimento_ps = "";  
  } else{
	 list($ano_recolhimento_ps,$mes_recolhimento_ps,$dia_recolhimento_ps) = explode("-",$empresa->data_recolhimento_previdencia_social);
	 $data_recolhimento_ps = $dia_recolhimento_ps.$mes_recolhimento_ps.$ano_recolhimento_ps;
  }
  
  /* Tratamento para data de Recolhimento FGTS */
  if($empresa->data_recolhimento_fgts == "0000-00-00"){
	 $data_recolhimento_fgts = ""; 
  } else {
	list($ano_recolhimento_fgts,$mes_recolhimento_fgts,$dia_recolhimento_fgts) = explode("-",$empresa->data_recolhimento_fgts); 
	 $data_recolhimento_fgts = $dia_recolhimento_fgts.$mes_recolhimento_fgts.$ano_recolhimento_fgts;
  }
   
  
  for($i=0;$i < count($array_opcoes); $i++) {
	  
	/*======: REGISTRO TIPO 00 - Informa��esdo do respons�vel :=======*/
	
	if($array_opcoes[$i] == "00"){
		 
		 /* 1. Tipo de registro, Campo Obrigat�rio sempre "00", Tam. 2 */
		fwrite($sefip, $array_opcoes[$i]); 	
		
		/* 2. Brancos, Campo Obrigat�rio preencher com brancos, Tam. 51 */
		fwrite($sefip,str_pad($espaco_branco,51)); 
		
		/* 3. Tipo de Remessa, Campo Obrigatorio s� pode ser 1 (GFIP), ou 3(DERF), Tam. 1 */
		fwrite($sefip,str_pad($tipo_remessa,1)); 
		
		/* 4. Tipo de inscri�ao - Responsavel, Campo obrigatorio s� poder ser 1(CNPJ), 2(CEI) ou 3(CPF), Tam. 1 */
		fwrite($sefip,str_pad($tipo_incricao_responsavel,1)); 		
		
		/* 5. Inscri�ao do Respons�vel, Campo obrigat�rio se tipo 1 = CNPJ, se tipo 2 = CEI, se tipo 3 = CPF, Tam 14 */
		if($tipo_incricao_responsavel == 1){
			fwrite($sefip,str_pad(substr(retirar_caracter('04.629.267/0001-01'),0,14),14));
		} else if($tipo_incricao_responsavel == 2){
			fwrite($sefip,str_pad(substr($inscricao_empresa_cei,0,14),14));
		}
		
		/* 6. Nome Respons�vel (Razao Social), Campo obrigat�rio, Tam. 30 */		
		fwrite($sefip,str_pad(substr(trim(strtoupper(retirar_caracter("A DA S NOVO"))),0,30),30));
		
		/* 7. Nome Pessoa de Contato, Campo obrigat�rio nao pode conter n�mero, Tam. 20 */
		fwrite($sefip, str_pad(substr(trim(strtoupper(retirar_caracter("MARIO FLAVIO SIMAS N"))),0,20),20));			
		
		/* 8. Logradouro, rua, n�, andar, apartamento, Campo obrigatorio, Tam. 50  */
		fwrite($sefip,str_pad(substr(trim(strtoupper(retirar_caracter("AV AMAZONAS 2038"))),0,50),50));
		
		/* 9. Bairro, Campo obrigatorio, Tam. 20 */
		fwrite($sefip, str_pad(substr(strtoupper(retirar_caracter("CENTRO")),0,20),20));
		
		/* 10. CEP, Campo obrigatorio, Numero de CEP v�lido somente n�mero, Tam. 8 */
		fwrite($sefip, str_pad(substr(retirar_caracter("69151000"),0,8),8));
		
		/* 11. Cidade, Campo obrigatorio permitido apenas [A-Z][0-9], Tam. 20 */
		fwrite($sefip, str_pad(substr(strtoupper(retirar_caracter("PARINTINS")),0,20),20));
		
		/* 12. Unidade da Federa�ao, Campo obrigatorio, Tam. 2 */
		fwrite($sefip,str_pad(substr(strtoupper("AM"),0,2),2));
		
		/* 13. Telefone Contato, Campo obrigatorio 02 d�gitos v�lidos no DDD e 07 d�gitos no telefone, Tam. 12 */
		fwrite($sefip,str_pad(retirar_caracter("9235331183"),12,"0"));
		
		/* 14. Endere�o INTERNET Contato, Campo opcional endere�o INTERNET v�lido, Tam. 60 */
		fwrite($sefip,str_pad(substr("mfnovodac@hotmail.com",0,60),60));
		
		/* 15. Competencia, Campo Obrigat�rio, o mes informado de ser de 1 a 13, Tam. 6 */
		fwrite($sefip,str_pad(substr($competencia,0,6),6));
		
		/* 16. C�digo de recolhimento, Campo obrigatorio c�digo de recolhimento 418 e 604 sao utilizados na entrada de dados do SEFIP, Tam. 3 */
		fwrite($sefip,str_pad(substr($codigo_recolhimento,0,3),3));
		
		/* 17. Indicador de recolhimento FGTS, pode ser 1(GRF no prazo), 2(GRF em atraso), 3(GRF em atraso - A�ao Fiscal), Tam. 1*/
		fwrite($sefip,str_pad(substr($indicador_recolhimento_fgts,0,1),1));
		
		/* 18. Modalidade do arquivo, Pode ser Branco, 1, 9, Tam. 1 */
		fwrite($sefip,str_pad(substr($modalidade_arquivo,0,1),1));
		
		/* 19. Data de recolhimento do FGTS, Formato DDMMAAAA, Tam. 8 */
		fwrite($sefip,str_pad(substr($data_recolhimento_fgts,0,8),8));
		
		/* 20. Indicador de recolhimento da previdencia social, Campo obrigatorio pode ser 1, 2 e 3, Tam. 1 */
		fwrite($sefip,str_pad(substr($indicador_recolhimento_ps,0,1),1));
		
		/* 21. Data de recolhimento da previdencia social, Formato DDMMAAAA */
		fwrite($sefip,str_pad(substr($data_recolhimento_ps,0,8),8));
		
		/* 22. Indice de Recolhimento em atraso da previdencia social, Campo deve ser em branco, Tam. 7 */
		fwrite($sefip,str_pad(substr($indice_recolhimento_atraso_ps,0,7),7));
		
		/* 23. Tipo de Inscricao - Fornecedor Folha de Pagamento, Campo obrigatorio pode ser 1(CNPJ), 2(CEI) ou 3(CPF), Tam. 1 */
		fwrite($sefip,str_pad(substr($tipo_inscricao_fornecedor_fp,0,1),1));
		
		/* 24. Inscri�ao do fornecedor Folha de Pagamento, Campo obrigatorio 
		*  se Tipo de Inscricao 1, entao numero esperado CNPJ
		*  se Tipo de Inscricao 2, entao numero esperado CEI
		*  se Tipo de Inscricao 3, entao numero esperado CPF
		*/
		fwrite($sefip,str_pad(substr($inscricao_fornecedor_fp,0,14),14));
		
		/* 25. Brancos, Preenchidos com Brancos */
		fwrite($sefip,str_pad($espaco_branco,18));
		
		/* 26. Final de Linha */
		fwrite($sefip,str_pad($final_linha,1));
		
		/* Quebra de Linha */
		fwrite($sefip,"\r");		
		
	}
	
	if($array_opcoes[$i] == "10"){
		
		$tipo_inscricao_empresa_t10       = "1";	 
		$indicador_alteracao_endereco_t10 = "N";
		$indicador_alteracao_cnae_t10     = "N";
		
		
		/* 1. Tipo de registro, Campo Obrigat�rio sempre "10", Tam. 2 */
		fwrite($sefip, $array_opcoes[$i]);
		
		/* 2. Tipo de Inscricao - Empresa, Campo obrigat�rio, S� poder ser 1 ou 2, Tam. 1 */
		fwrite($sefip,str_pad(substr($tipo_inscricao_empresa_t10,0,1),1));
		
		/* 3. Inscri�ao da Empresa, Campo obrigat�rio, Tam. 14 
		* se tipo Inscri�ao = 1, n�mero esperado CNPJ
		* se tipo Inscricao = 2, n�mero esperado CEI
		*/
	    fwrite($sefip,str_pad(substr($inscricao_empresa_cnpj,0,14),14));
		
		/* 4. Zeros, Campo obrigatorio, Preencher com zeros, Tam. 36 */
		fwrite($sefip,str_pad($espaco_branco,36,"0"));
		
		/* 5. Nome Empresa / Razao Sccial, Campo obrigat�rio, Tam. 40 */
		fwrite($sefip,str_pad(substr(retirar_caracter($responsavel->razao_social),0,40),40));
		
		/* 6. Logradouro, rua, no, andar, apartamento, Campo obrigatorio, Tam. 50 */
		fwrite($sefip,str_pad(substr(retirar_caracter($responsavel->endereco),0,50),50));
		
		/* 7. Bairro, Campo obrigatorio [A-Z][0-9], Tam. 20 */
		fwrite($sefip,str_pad(substr(strtoupper($responsavel->bairro),0,20),20));
		
		/* 8. CEP, Campo obrigatorio, numero de CEP v�lido apenas numero, Tam. 8 */
		fwrite($sefip,str_pad(substr(retirar_caracter($responsavel->cep),0,8),8));
		
		/* 9. Cidade , Campo obrigat�rio [A-Z][0-9], Tam. 20 */
		fwrite($sefip,str_pad(substr(strtoupper($responsavel->cidade),0,20),20));
		
		/* 10. Unidade da Federa�ao, Campo obrigat�rio, Tam. 2*/
		fwrite($sefip,str_pad(substr(strtoupper($responsavel->estado),0,2),2));
		
		/* 11. Telefone, Campo obrigatorio DDD e 07 d�gitos no telefone, Tam 12 */
		fwrite($sefip,str_pad(substr(retirar_caracter($responsavel->telefone1),0,12),12,"0"));
		
		/* 12. Indicador de altara�oes de endere�o, Campo obrigatorio, S� pode ser "S" ou "s" "N" ou "n", Tam. 1*/
		fwrite($sefip,str_pad(substr($indicador_alteracao_endereco_t10,0,1),1));
		
		/* 13. CNAE, Campo obrigatorio, N�mero v�lido de CNAE, Tam. 7  */
		fwrite($sefip,str_pad(substr($cnae_empresa,0,7),7));
		
		/* 14. Indicador de altera�ao CNAE, Campo obrigat�rio, Tam. 1 */
		fwrite($sefip,str_pad(substr($indicador_alteracao_cnae_t10,0,1),1));
		
		/* 15. Al�quota RAT, Campo obrigatorio, sempre que nao informado o campo deve ficar em branco, Tam. 2 */
		foreach($array_rat_cod_recolhimento as $key => $value){
	    	if($codigo_recolhimento == $value){
				$set_aliquota_rat = 0;	
			} else {
				$set_aliquota_rat = 1;
			}
		} // fim de foreach
		
		if($set_aliquota_rat == 1){
			if($alicota_rat == 0){
			   $alicota_rat = "0";
			}
		 fwrite($sefip,str_pad(substr(number_format($alicota_rat,1,"",""),0,2),2));
		
		} else {
		 fwrite($sefip,str_pad(substr($espaco_branco,0,2),2));
		}			
				
		/* 16. C�digo de Centraliza�ao, Campo obrigatorio, pode ser 0(nao centraliza), 1(centralizadora) ou 2(centralizada), Tam. 1 */
		fwrite($sefip,str_pad(substr($codigo_centralizacao,0,1),1));
		
		/* 17. Simples, Campo obrigat�rio, s� poder ser 1, 2, 3, 4, 5 e 6, Tam. 1 */
		fwrite($sefip,str_pad(substr($simples,0,1),1));
		
		/* 18. FPAS, Campo obrigatorio, deve ser um FPAS v�lido, Tam. 3 */
		fwrite($sefip,str_pad(substr($fpas,0,3),3));
		
		/* 19. C�digos de outras entidades, Campo obrigatorio , sempre que nao informado o campo deve ficar em branco, Tam. 4 */
		foreach($array_cod_recolhimento_informa as $key => $value){
			if($codigo_recolhimento == $value){
				$set_cod_outras_entidades = 1;	
			}
		} // fim de foreach 
		foreach($array_cod_recolhimento_ninforma as $key => $value){
			if($codigo_recolhimento == $value){
				$set_cod_outras_entidades = 0;	
			}
		} // fim de foreach 
		
			if($set_cod_outras_entidades == 1){
				fwrite($sefip,str_pad(substr($codigo_outras_entidades,0,4),4));	
			} else {
				fwrite($sefip,str_pad(substr($espaco_branco,0,4),4));
			}
		
		/* 20. C�digo de pagamento GPS, Campo obrigat�rio, sempre que nao informado o campo deve ficar em branco, Tam. 4 */
		foreach($array_cod_recolhimento_gps as $key => $value){
			if($codigo_recolhimento == $value){
				$set_cod_gps = 1;
			}
		} // fim de foreach
			if($set_cod_gps == 1){
				fwrite($sefip,str_pad(substr($codigo_pagamento_gps,0,4),4));
			} else{
				fwrite($sefip,str_pad(substr($espaco_branco,0,4),4));
			}	
		
		/* 21. Percentual de Isen�ao de Filantropia, valor composto por tres inteiros e duas decimais, Tam. 5 */
		fwrite($sefip,str_pad(substr($percentual_isencao_filantropia,0,5),5));
		
		/* 22. Sal�rio Familia, sempre que nao informado preencher com zeros, Tam. 15 */
		//fwrite($sefip,str_pad(substr($salario_familia_valor,0,15),15,"0"));
		fwrite($sefip,str_pad(number_format($salario_familia_valor,2,'',''),15,"0",STR_PAD_LEFT));
//		fwrite($sefip,number_format($salario_familia_valor,2,'',''),15,"0");
		
		/* 23. Sal�rio Maternidade, sempre que nao informado preencher com zeros, Tam. 15 */
		//fwrite($sefip,str_pad(substr("",0,15),15,"0"));
		fwrite($sefip,str_pad(number_format($salario_maternidade,2,'',''),15,"0",STR_PAD_LEFT));
		
		/* 24. Contribui�cao Descontado empregado referente a competencia 13, Nao dever� ser informado, preencher com zeros, tam. 15 */
		fwrite($sefip,str_pad(substr("",0,15),15,"0"));
		
		/* 25. Indicador de valor negativo ou positivo, nao dever� ser informado, preencher com zeros, Tam. 1*/
		fwrite($sefip,str_pad(substr("",0,1),1,"0"));
		
		/* 26. Valor devido a previdencia social referente � Comp. 13, Nao dever� ser informado, Preencher com zeros, Tam. 14 */
		fwrite($sefip,str_pad(substr("",0,14),14,"0"));
		
		/* 27. Banco " Para debito em conta corrente", campo opcional, sempre que nao informado o campo deve ficar em branco, Tam. 3 */
		fwrite($sefip,str_pad(substr("",0,3),3));
		
		/* 28. Agencia " Para d�bito em conta corrente ", sempre que nao informado o campo deve ficar em branco, tam. 4 */
		fwrite($sefip,str_pad(substr("",0,4),4));
		
		/* 29. Conta corrente, sempre que nao informado o campo deve ficar em branco, Tam. 9 */
		fwrite($sefip,str_pad(substr("",0,9),9));
		
		/* 30. Zeros, para implementa�ao futura, Tam. 45 */
		fwrite($sefip,str_pad(substr("",0,45),45,"0"));
		
		/* 31. Brancos , Campo obrigat�rio Tam. 4 */
		fwrite($sefip,str_pad(substr($espaco_branco,0,4),4));
		
		/* 32 Final de Linha, campo obrigat�rio deve ser uma constante "*" Tam. 1 */
		fwrite($sefip,str_pad($final_linha,1));
		
		/* Quebra de Linha */
		fwrite($sefip,"\r");		

	}
	
	if($array_opcoes[$i] == "30"){
		
		$tipo_inscricao_empresa_t30 = "1";
		$tipo_inscricao_to_const_civil = "1";
		$inscricao_to_const_civil = "";
		
		
		while($funcionario = mysql_fetch_object($sql_funcionario)){
		  
		  $folha_funcionario = mysql_fetch_object(mysql_query(" SELECT * FROM rh_folha_funcionarios WHERE rh_folha_id = '$empresa_folha_id' AND funcionario_id = '$funcionario->id'")); 
		 
		 //mes = '".($mes_competencia - 1)."' AND ano = '$ano_competencia'
		 /* Se ta de ferias*/

	//	 $info = mysql_fetch_object(mysql_query("SELECT * FROM rh_ferias WHERE funcionario_id='$folha_funcionario' AND MONTH(data_inicio)='$mes_competencia' AND YEAR(data_inicio)='$ano_competencia' "));
		// if(){
		//	 
		//}
		 
		  /* Campos opcionais */
		  $basecalculo_decimo_previdencia = "";
		  if($sql_folha_empresa->mes==12||$sql_folha_empresa->mes==13){
		  	$remuneracao_sem_decimo = 0;
		  	$remuneracao_decimo = number_format($folha_funcionario->base_calculo_inss,2,'','');
		  }else if($sql_folha_empresa->mes==14){
			//pesquisa primeira parcela do d�cimo terceiro, de acordo com esta folha
			$primeira_parcela   = mysql_result(mysql_query("
				SELECT 
					rhf.base_calculo_inss 
				FROM 
					rh_folha_funcionarios rhf, 
					rh_folha_empresa rfe 
				WHERE 
					rhf.rh_folha_id = rfe.id AND
					rfe.mes='13' AND 
					rfe.ano='$sql_folha_empresa->ano' AND
					rhf.funcionario_id = '$funcionario->id'"),0,0);
			$primeira_parcela   = (float)$primeira_parcela;
			$segunda_parcela    = (float)$folha_funcionario->base_calculo_inss;
			$decimo_terceiro    = $primeira_parcela + $segunda_parcela;
			$remuneracao_decimo = number_format($decimo_terceiro,2,'','');
			$remuneracao_sem_decimo = 0;		  	
		  }else{
			$remuneracao_sem_decimo = number_format($folha_funcionario->base_calculo_inss,2,'','');
		  	$remuneracao_decimo = 0;
		  }
		  //$remuneracao_sem_decimo = number_format($folha_funcionario->base_calculo_inss,2,'','');
		  //$remuneracao_decimo     = retirar_caracter($folha_funcionario->sub_total_valor);
		  //$remuneracao_decimo = 0;
		  $classe_contribuicao    = "";
		  $ocorrencia_trabalhador = "";
		  $base_calculo_decimo_ps  = "";
		  
		  $val_descontado_segurado  = retirar_caracter($folha_funcionario->total_deducoes);
		  $remuneracao_base_calculo = retirar_caracter($folha_funcionario->base_calculo_inss); // linha 21
	
		/* Data Admissao */
		if($funcionario->data_admissao == "0000-00-00"){
			$data_admissao = "";	
		} else{
			list($ano_admissao,$mes_admissao,$dia_admissao) = explode("-",$funcionario->data_admissao); //0000-00-00
			$data_admissao = $dia_admissao.$mes_admissao.$ano_admissao;
		} 
		
		/* Data Nascimento */
		list($ano_nascimento,$mes_nascimento,$dia_nascimento) = explode("-",$funcionario->data_nascimento);
		$data_nascimento       = $dia_nascimento.$mes_nascimento.$ano_nascimento;
		
		$categoria_trabalhador = $funcionario->categoria;
		$nome_trabalhador      = strtoupper(retirar_caracter($funcionario->nome));
		$matricula_empregado   = "";
		$numero_ctps           = $funcionario->carteira_profissional_numero;
		$serie_ctps            = $funcionario->carteira_profissional_serie;
		$data_opcao_fgts       = $data_admissao;
		$cbo_trabalhador       = '0'.substr($funcionario->cbo*1,0,4);
		
		
		/*==================== INICIO DA LINHA DE N�MERO 30 =====================*/
		
		/* 1. Tipo de registro, Campo Obrigat�rio sempre "30", Tam. 2 */
		fwrite($sefip, str_pad($array_opcoes[$i],2));
		
		/* 2. Tipo de inscri�ao empresa, Campo obrigat�rio, so pode ser 1(CNPJ) ou 2(CEI), Tam. 1 */
		fwrite($sefip,str_pad(substr($tipo_inscricao_empresa_t30,0,1),1));
		
		/* 3. Inscri�ao da Empresa, Campo obrigat�rio, Tam. 14 
		* se tipo Inscri�ao = 1, n�mero esperado CNPJ V�lido
		* se tipo Inscricao = 2, n�mero esperado CEI V�lido
		*/
		if($tipo_inscricao_empresa_t30 == 1){
	    	fwrite($sefip,str_pad(substr($inscricao_empresa_cnpj,0,14),14));
		}
		
		/* 4. Tipo de Inscricao - Tomador/obra de const. Civil, Campo obrigat�rio, s� pode ser 1(CNPJ) ou 2(CEI), Tam. 1*/
		$set_tipo_inscricao_to_const_civil = 0;
		foreach($array_tomador_obra_const_civil as $key => $value){
		  if($codigo_recolhimento == $value){
		   	$set_tipo_inscricao_to_const_civil = 1;
		  }
		} // Fim Foreach
		
		if($set_tipo_inscricao_to_const_civil == 1){
		  fwrite($sefip,str_pad(substr($tipo_inscricao_to_const_civil,0,1),1));	
		} else {
		  fwrite($sefip,str_pad(substr($espaco_branco,0,1),1));
		}
			
		/* 5. Inscri�ao Tomador/obra de const. civil(*), Campo obrigatorio, Tam. 14
		* se tipo Inscri�ao = 1, n�mero esperado CNPJ V�lido
		* se tipo Inscricao = 2, n�mero esperado CEI V�lido
		*/
		$set_inscricao_to_const_civil = 0;
		foreach($array_tomador_obra_const_civil as $key => $value){
			if($codigo_recolhimento == $value){
				$set_inscricao_to_const_civil = 1;
			}		
		} //Fim de foreach
			
			if($set_inscricao_to_const_civil == 1){
				fwrite($sefip,str_pad(substr($inscricao_empresa_cnpj,0,14),14));
			} else {
				fwrite($sefip,str_pad(substr($espaco_branco,0,14),14));
			}
		
		/* 6. PIS/PASEP/CI, Campo obrigat�rio, o n�mero informado deve ser v�lido. */
		fwrite($sefip,str_pad(substr(retirar_caracter($funcionario->pis),0,11),11));
		
		/* 7. Data Admissao, Formato DDMMAAAA, sempre que nao informado o campo deve ficar em branco, Tam. 8 */
		fwrite($sefip,str_pad(substr($data_admissao,0,8),8));
		
		/* 8. Categoria do Trabalhador, Campo obrigatorio, Tam. 2 */
		fwrite($sefip,str_pad(substr($categoria_trabalhador,0,2),2));
		
		/* 9. Nome trabalhador, Campo obrigatorio, pode conter caracteres apenas de [A-Z], Tam. 70 */
		fwrite($sefip,str_pad(substr(retirar_caracter($nome_trabalhador),0,70),70));
		
		/* 10. Matr�cula do empregado, sempre que nao informado o campo deve ficar em branco, Tam. 11 */
		fwrite($sefip,str_pad(substr($matricula_empregado,0,11),11));
		
		/* 11. N�mero CTPS, Tam. 7 */
		fwrite($sefip,str_pad(substr($numero_ctps,0,7),7,"0",STR_PAD_LEFT));
		
		/* 12. S�rie CTPS, Tam. 5*/
		fwrite($sefip,str_pad(substr($serie_ctps,0,5),5,"0",STR_PAD_LEFT));
		
		/* 13. Data de op�ao (Indicar a data em que o trabalhador optou pelo FGTS), se nao informado o campo deve ficar em branco, Tam. 8*/
		fwrite($sefip,str_pad(substr($data_opcao_fgts,0,8),8));
		
		/* 14. Data de nascimento, Tam. 8 */
		fwrite($sefip,str_pad(substr($data_nascimento,0,8),8));
		
		/* 15. CBO, campo obrigatorio Tam. 5*/
		fwrite($sefip,str_pad(substr(retirar_caracter($cbo_trabalhador),0,5),5,"0",STR_PAD_LEFT));
		
		/* 16. Remunera�ao sem 13�, sempre que nao informado preencher com zeros Tam. 15 */
		fwrite($sefip,str_pad(substr(($remuneracao_sem_decimo),0,15),15,"0",STR_PAD_LEFT));
		
		/* 17. Remunera�ao 13�, Tam. 15 */
		fwrite($sefip,str_pad(substr($remuneracao_decimo,0,15),15,"0",STR_PAD_LEFT));
		
		/* 18. Classe de contribui�ao, Tam. 2 */
		fwrite($sefip,str_pad(substr($classe_contribuicao,0,2),2));
		
		/* 19. Ocorrencia, Tam. 2 */
		fwrite($sefip,str_pad(substr($ocorrencia_trabalhador,0,2),2));
		
		/* 20. Valor descontado do segurado, Tam. 15 */
		if($ocorrencia_trabalhador == NULL){
			$val_descontado_segurado = 0;
			fwrite($sefip,str_pad(substr(substr($val_descontado_segurado,0,-1),0,15),15,"0",STR_PAD_LEFT));
		} else {
			fwrite($sefip,str_pad(substr(substr($val_descontado_segurado,0,-1),0,15),15,"0",STR_PAD_LEFT));
		}
		
		/* 21. remunera�ao base de calculo da contribui�ao previdenci�ria */
		if(!empty($movimentacao)){
			fwrite($sefip,str_pad(substr($remuneracao_base_calculo,0,15),15,"0",STR_PAD_LEFT));
		} else{
			$remuneracao_base_calculo = 0;
			fwrite($sefip,str_pad(substr($remuneracao_base_calculo,0,15),15,"0",STR_PAD_LEFT));
		}
		/* 22. Base de Calculo 13� Sal�rio Previdencia Social - referente a competencia do movimento */
		fwrite($sefip,str_pad(substr($base_calculo_decimo_ps,0,15),15,"0",STR_PAD_LEFT));
		
		/* 23. Base de Calculo 13� Sal�rio Previdencia  - Referente a GPS */
		fwrite($sefip,str_pad(substr($basecalculo_decimo_previdencia,0,15),15,"0"));
		
		/* 24. Brancos, Tam. 98 */
		fwrite($sefip,str_pad(substr($espaco_branco,0,98),98));
		
		/* 25. Final de Linha */
		fwrite($sefip,str_pad($final_linha,1));
		
		/* Quebra de Linha */
		fwrite($sefip,"\r");
		
		} /*Fim de while*/
		
	} /*Fim de for 30 */
	
	if($array_opcoes[$i] == "32"){
		
		$tipo_insc_t32 = "1";
		$codigo_trabalhador = "01";
		$codigo_movimentacao = "I1";
		$data_movimentacao = retirar_caracter("01/11/2012");
		$nome_trabalhador = strtoupper(retirar_caracter("Ricardo Monteiro e Lima"));
		$indicativo_recolhimento_fgts = "S";
		
		/* 1. Tipo de registro, Campo Obrigat�rio sempre "32", Tam. 2 */
		fwrite($sefip, str_pad($array_opcoes[$i],2));
		
		/* 2. Tipo de inscri�ao empresa, Campo obrigat�rio, so pode ser 1(CNPJ) ou 2(CEI), Tam. 1 */
		fwrite($sefip,str_pad(substr($tipo_inscricao_empresa,0,1),1));
		
		/* 3. Inscri�ao da Empresa, Tam. 14 */
		if($tipo_inscricao_empresa == 1){
			fwrite($sefip,str_pad(substr($inscricao_empresa_cnpj,0,14),14));
		} else if($tipo_inscricao_empresa == 2){
			fwrite($sefip,str_pad(substr($inscricao_empresa_cei,0,14),14));
		}
		
		/* 4. Tipo de Inscricao - Tomador/Obra Const. Civil(*), Tam. 1 */
		$set_const_civil_t32 = 0;
		foreach($tipo_const_civil_t32 as $key => $value){
			if($codigo_recolhimento == $value){
				$set_const_civil_t32 = 1;
				$tipo_insc_obra_const_civil = $tipo_insc_t32;	
			}
		} // fim de foreach
			
			if($set_const_civil_t32 == 1){
				fwrite($sefip,str_pad(substr($tipo_insc_obra_const_civil,0,1),1));	
			} else {
				fwrite($sefip,str_pad(substr($espaco_branco,0,1),1));
			}
					
		/* 5. Inscri�ao Tomador/Obra Const. Civil (*), Tam. 14 */
		if(!empty($set_const_civil_t32)){ // condicao para o codigo de recolhimento 
			if($tipo_insc_obra_const_civil == 1){
				fwrite($sefip,str_pad(substr($inscricao_empresa_cnpj,0,14),14));
			} else if($tipo_insc_obra_const_civil == 2){
				fwrite($sefip,str_pad(substr($inscricao_empresa_cnpj,0,14),14));
			} 
		} else {
				fwrite($sefip,str_pad(substr($espaco_branco,0,14),14));
		}
		
		/* 6. PIS/PASEP/CI, Campo obrigatorio, Tam. 11 */
		fwrite($sefip,str_pad(substr($pis_pasep,0,11),11));
		
		/* 7. Data Admissao, Tam. 8*/
		fwrite($sefip,str_pad(substr($data_admissao,0,8),8));
		
		/* 8. Categoria do Trabalhador, Campo obrigatorio, Tam. 2 */
		fwrite($sefip,str_pad(substr($codigo_trabalhador,0,2),2));
		
		/* 9. Nome Trabalhador, Campo obrigat�rio, tam. 70 */
		fwrite($sefip,str_pad(substr($nome_trabalhador,0,70),70));
		
		/* 10. C�digo de Movimenta�ao, Campo obrigatorio, Tam. 2 */
		fwrite($sefip,str_pad(substr($codigo_movimentacao,0,2),2));
		
		/* 11. Data de Movimenta�ao, Campo obrigaorio para movimenta�ao do trabalhador, Tam. 8*/
		fwrite($sefip,str_pad(substr($data_movimentacao,0,8),8));
		
		/* 12. Indicativo de recolhimento do FGTS, Tam. 1*/
		fwrite($sefip,str_pad(substr($indicativo_recolhimento_fgts,0,1),1));
		
		/* 13. Brancos, Campo obrigatorio, Preencher com Brancos, Tam. 225 */
		fwrite($sefip,str_pad(substr($espaco_branco,0,225),225));
		
		/* 14. Final de Linha */
		fwrite($sefip,str_pad($final_linha,1));
		
		/* Quebra de Linha */
		fwrite($sefip,"\r");
	}
	
	if($array_opcoes[$i] == "90"){
		
		/*==================== INICIO DA LINHA DE N�MERO 90 - Registro Totalizador do Arquivo =====================*/
		
		/* 1. Tipo de registro, Campo Obrigat�rio sempre "30", Tam. 2 */
		fwrite($sefip, str_pad($array_opcoes[$i],2));
		
		/* 2. Marca de Final de Registro */
		fwrite($sefip,str_pad(substr("9",0,51),51,"9"));
		
		/* 3. Brancos */
		fwrite($sefip,str_pad(substr($espaco_branco,0,306),306));
		
		/* 4. Final de Linha */
		fwrite($sefip,str_pad($final_linha,1));
	}
  
  } /* Fim de FOR */
  
  /* Fecha o arquivo */
  fclose($sefip); 
  
    $file = "SEFIP.RE";

  
    header('Content-type: octet/stream');
    header('Content-disposition: attachment; filename="'.basename($file).'";');
    header('Content-Length: '.filesize($file));
	
    readfile($file);
	/*
	
	
//    <script>
//    location = '<?=$file?>';
 //   </script>*/
	?>