<?php
$sis['geral']['nosso_numero'] 		=str_pad($boleto->num_inicio_boleto,8,"0",STR_PAD_RIGHT);
//echo $sis['geral']['nosso_numero'];
$sis['geral']['nosso_numero'] 	+=$boleto->movimentacao_id; // Numero de 8 dígitos que será somado ao ID da matrícula para ser o ID único no boleto (NÃO MUDE!!!)
		
		$d=$banco;
		
		if($boleto->pago== 'S'){
			echo "<script>alert('Boleto Já foi pago em ".dataUsaToBR($matricula->data_pagamento)."');history.back()</script>";	
			exit();
		}
		
		
		/*if( $d->banco == "Caixa Econômica" ){
	
				$v1 = $d->agencia;
				$v2 = $d->conta;
				$v3 = $d->conta_cedente;
				$v4 = $d->conta_cedente_dv;
			switch($d->tipo_boleto) {
				
				case "80":
				case "81":
				case "82":
					$v5 = "SR";
					break;
				case "90":
					$v5 = "CR";
					break;				
			}
		}else{			
			$v1 = $d->agencia;
			$v2 = $d->conta;
			$v3 = $d->_convenio;
			$v4 = $d->_contrato;
			$v5 = $d->_carteira;
		}
		
		$_POST['v1'] = $v1;
		$_POST['v2'] = $v2;
		$_POST['v3'] = $v3;
		$_POST['v4'] = $v4;
		$_POST['v5'] = $v5;
		$_POST['v6'] = $matricula->id;

		$_POST['valor']=$matricula->valor;
		$_POST['nome'] = $aluno->nome;
		$_POST['endereco'] = $aluno->endereco;
		$_POST['uf']		=$aluno->uf;
		$_POST['cep']		=$aluno->cep;
		$_POST['escola_nome']=$escola->nome;
		$_POST['curso']		=$curso->nome;
		$_POST['tipo_matricula'] =$matricula->tipo_matricula;
		$_POST['vencimento'] = dataUsaToBr($matricula->data_vencimento);
		
		echo "<pre>";
			echo"Matricula";
			print_r($matricula);
			echo"aluno";
			print_r($aluno);
			echo"unidade";
			print_r($unidade);
			echo"curso";
			print_r($curso);
			echo"modulo";
			print_r($modulo);
			echo"horario";
			print_r($horario);
			echo"modulo";
			print_r($modulo);
			echo"banco";
			print_r($banco);
			echo"post";
			print_r($_POST);
		echo "</pre>";
		*/
	
	if(!empty($boleto->doc)){
		$num_documento = $boleto->doc;
	}else{
		$num_documento = $sis['geral']['nosso_numero'] + $movimentacao->movimentacao_id; 
	}
	// DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 1;
	$taxa_boleto = 0;
	//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
	//$data_venc = date("d/m/Y", time() + (1 * 24 * 60 * 60));
	$data_venc = DataUsaToBr($boleto->data_vencimento);
	$valor_cobrado = 1; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	$valor_boleto=number_format($_POST['valor']+$taxa_boleto, 2, ',', '');
	
	$dadosboleto["nosso_numero"] = $num_documento;
	
	$dadosboleto["numero_documento"] = "INS".$num_documento;	// Num do pedido ou do documento
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = number_format($boleto->valor_cadastro,2,',','');; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
	$dadosboleto["local_pagamento"] = "Itaú, Real, Santander, Bradesco, HSBC e Banco do Brasil. "; // String
	
	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] = $internauta->razao_social;
	$dadosboleto["endereco1"] = strtoupper($internauta->endereco." ".$internauta->bairro);
	$dadosboleto["endereco2"] = "{$internauta->cidade}/{$internauta->uf} -  CEP: {$internauta->cep}";
	
	// INFORMACOES PARA O CLIENTE
	$dadosboleto["demonstrativo1"] = "";
	$dadosboleto["demonstrativo2"] = "";
	$dadosboleto["demonstrativo3"] = "";
	
	// INSTRUÇÕES PARA O CAIXA
	$dadosboleto["instrucoes1"] = "-----------------------------";
	$dadosboleto["instrucoes2"] = "Não receber após o vencimento";
	$dadosboleto["instrucoes3"] = "-----------------------------";
	$dadosboleto["instrucoes4"] = "";
	
	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"] = "1";
	$dadosboleto["valor_unitario"] = $_POST['valor'];
	$dadosboleto["aceite"] = "N";		
	$dadosboleto["especie"] = "R$";
	$dadosboleto["especie_doc"] = "DM";
	
	
	// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
	
	
	// DADOS DA SUA CONTA - BANCO DO BRASIL
	$dadosboleto["agencia"] = $boleto->agencia; // Num da agencia, sem digito
	$dadosboleto["conta"] = $boleto->conta; 	// Num da conta, sem digito
	
	// DADOS PERSONALIZADOS - BANCO DO BRASIL
	$dadosboleto["convenio"] = $boleto->_convenio;  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
	$dadosboleto["contrato"] = $boleto->_contrato; // Num do seu contrato
	
	$dadosboleto["carteira"] = $boleto->_carteira;
	$dadosboleto["variacao_carteira"] = "-".$boleto->_variacao_carteira;  // Variação da Carteira, com traço (opcional)
	
	// TIPO DO BOLETO
	$convenio_dig = strlen($dadosboleto["convenio"]);
	$dadosboleto["formatacao_convenio"] = 8; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
	$dadosboleto["formatacao_nosso_numero"] = "2"; 
	//$dadosboleto["cedente"] = "";
	
	// REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for NossoNúmero de até 5 dígitos ou 2 para opção de até 17 dígitos
//echo "<pre>";
//print_r($dadosboleto);
//echo "</pre>";

	/*
	#################################################
	DESENVOLVIDO PARA CARTEIRA 18
	
	- Carteira 18 com Convenio de 8 digitos
	  Nosso número: pode ser até 9 dígitos
	
	- Carteira 18 com Convenio de 7 digitos
	  Nosso número: pode ser até 10 dígitos
	
	- Carteira 18 com Convenio de 6 digitos
	  Nosso número:
	  de 1 a 99999 para opção de até 5 dígitos
	  de 1 a 99999999999999999 para opção de até 17 dígitos
	
	#################################################
	*/
	
	
	// SEUS DADOS
	/*
	$dadosboleto["identificacao"] = "BoletoPhp - Código Aberto de Sistema de Boletos";
	$dadosboleto["cpf_cnpj"] = "";
	$dadosboleto["endereco"] = "Coloque o endereço da sua empresa aqui";
	$dadosboleto["cidade_uf"] = "Cidade / Estado";
	$dadosboleto["cedente"] = "Coloque a Razão Social da sua empresa aqui";
	*/
	
	// NÃO ALTERAR!
	
	include("funcoes_bb.php"); 
	include("layout_bb.php");



?>
