<?php

include ("../_config.php");
if( isset($_POST) ){

	$num_documento = $sis['geral']['nosso_numero'] + $_POST['v6']; 
	
	// DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 1;
	$taxa_boleto = 0;
	//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
	$data_venc = date("d/m/Y", time() + (1 * 24 * 60 * 60));
	$valor_cobrado = 1; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	$valor_boleto=number_format($_POST['valor']+$taxa_boleto, 2, ',', '');
	
	$dadosboleto["nosso_numero"] = $num_documento;
	$dadosboleto["numero_documento"] = "INS".$num_documento;	// Num do pedido ou do documento
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula
	$dadosboleto["local_pagamento"] = "Ita�, Real, Santander, Bradesco, HSBC e Banco do Brasil. "; // String
	
	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] = $_POST['nome'];
	$dadosboleto["endereco1"] = $_POST['endereco'];
	$dadosboleto["endereco2"] = "{$_POST['cidade']}/{$_POST['uf']} -  CEP: {$_POST['cep']}";
	
	// INFORMACOES PARA O CLIENTE
	$dadosboleto["demonstrativo1"] = "";
	$dadosboleto["demonstrativo2"] = "";
	$dadosboleto["demonstrativo3"] = "";
	
	// INSTRU��ES PARA O CAIXA
	$dadosboleto["instrucoes1"] = "-----------------------------";
	$dadosboleto["instrucoes2"] = "N�o receber ap�s o vencimento";
	$dadosboleto["instrucoes3"] = "-----------------------------";
	$dadosboleto["instrucoes4"] = "";
	
	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"] = "1";
	$dadosboleto["valor_unitario"] = $_POST['valor'];
	$dadosboleto["aceite"] = "N";		
	$dadosboleto["especie"] = "R$";
	$dadosboleto["especie_doc"] = "DM";
	
	
	// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //
	
	
	// DADOS DA SUA CONTA - BANCO DO BRASIL
	$dadosboleto["agencia"] = $_POST['v1']; // Num da agencia, sem digito
	$dadosboleto["conta"] = $_POST['v2']; 	// Num da conta, sem digito
	
	// DADOS PERSONALIZADOS - BANCO DO BRASIL
	$dadosboleto["convenio"] = $_POST['v3'];  // Num do conv�nio - REGRA: 6 ou 7 ou 8 d�gitos
	$dadosboleto["contrato"] = $_POST['v4']; // Num do seu contrato
	$dadosboleto["carteira"] = "";
	$dadosboleto["variacao_carteira"] = $_POST['v5'];  // Varia��o da Carteira, com tra�o (opcional)
	
	// TIPO DO BOLETO
	$convenio_dig = strlen($dadosboleto["convenio"]);
	$dadosboleto["formatacao_convenio"] = $convenio_dig; // REGRA: 8 p/ Conv�nio c/ 8 d�gitos, 7 p/ Conv�nio c/ 7 d�gitos, ou 6 se Conv�nio c/ 6 d�gitos
	$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Conv�nio c/ 6 d�gitos: informe 1 se for NossoN�mero de at� 5 d�gitos ou 2 para op��o de at� 17 d�gitos
	
	/*
	#################################################
	DESENVOLVIDO PARA CARTEIRA 18
	
	- Carteira 18 com Convenio de 8 digitos
	  Nosso n�mero: pode ser at� 9 d�gitos
	
	- Carteira 18 com Convenio de 7 digitos
	  Nosso n�mero: pode ser at� 10 d�gitos
	
	- Carteira 18 com Convenio de 6 digitos
	  Nosso n�mero:
	  de 1 a 99999 para op��o de at� 5 d�gitos
	  de 1 a 99999999999999999 para op��o de at� 17 d�gitos
	
	#################################################
	*/
	
	
	// SEUS DADOS
	/*
	$dadosboleto["identificacao"] = "BoletoPhp - C�digo Aberto de Sistema de Boletos";
	$dadosboleto["cpf_cnpj"] = "";
	$dadosboleto["endereco"] = "Coloque o endere�o da sua empresa aqui";
	$dadosboleto["cidade_uf"] = "Cidade / Estado";
	$dadosboleto["cedente"] = "Coloque a Raz�o Social da sua empresa aqui";
	*/
	
	// N�O ALTERAR!
	include("include/funcoes_bb.php"); 
	include("include/layout_bb.php");

} else {
	echo "<script>
	
	alert(\"O sistema encontrou dificuldades em gerar o boleto.\\nUtilize a op��o de re-impress�o de boleto na p�gina principal.\");
	window.location='../../index.php';
	
	</script>";	
}


?>
