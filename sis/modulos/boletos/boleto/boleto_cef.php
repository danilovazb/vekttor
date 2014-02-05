<?php

include ("../_config.php");

if(isset($_POST)){

$num_documento = $sis['geral']['nosso_numero'] + $_POST['v6']; 

	// DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 1;
	$taxa_boleto = 0;
	$data_venc = date("d/m/Y", time() + (1 * 24 * 60 * 60));
	$valor_cobrado = $_POST['valor']; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
	
	$dadosboleto["inicio_nosso_numero"] = "{$_POST['v1']}";  // Carteira SR: 80, 81 ou 82  -  Carteira CR: 90 (Confirmar com gerente qual usar)
	$dadosboleto["nosso_numero"] = $sis['geral']['nosso_numero'] + $_POST['v5']."-1";  // Nosso numero sem o DV - REGRA: M�ximo de 8 caracteres!
	$dadosboleto["numero_documento"] = $_POST['matricula'];;	// Num do pedido ou do documento
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula
	
	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] = $_POST['nome'];
	$dadosboleto["endereco1"] = $_POST['endereco'];
	$dadosboleto["endereco2"] = "{$_POST['cidade']}/{$_POST['estado']} -  CEP: {$_POST['cep']}";
	
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
	$dadosboleto["quantidade"] = "";
	$dadosboleto["valor_unitario"] = "";
	$dadosboleto["aceite"] = "N";		
	$dadosboleto["especie"] = "R$";
	$dadosboleto["especie_doc"] = "";
	
	
	// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //
	
	
	// DADOS DA SUA CONTA - CEF
	$dadosboleto["agencia"] = $_POST['v1']; // Num da agencia, sem digito
	$ag_conta = explode("-", $_POST['v2']);
	$dadosboleto["conta"] = $ag_conta[0]; 	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = $ag_conta[1]; 	// Digito do Num da conta
	
	// DADOS PERSONALIZADOS - CEF
	$dadosboleto["conta_cedente"] = $_POST['v3']; // ContaCedente do Cliente, sem digito (Somente N�meros)
	$dadosboleto["conta_cedente_dv"] = $_POST['v4']; // Digito da ContaCedente do Cliente
	$dadosboleto["carteira"] = "{$_POST['v5']}";  // C�digo da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)
	
	// SEUS DADOS
	$dadosboleto["identificacao"] = "Funda��o de Apoio Institucional Muraki";
	$dadosboleto["cpf_cnpj"] = "";
	$dadosboleto["endereco"] = "Av. Professor Nilton Lins, 1699";
	$dadosboleto["cidade_uf"] = "Manaus / AM";
	$dadosboleto["cedente"] = "Funda��o de Apoio Institucional Muraki";
	
	// N�O ALTERAR!
	include("include/funcoes_cef.php");
	include("include/layout_cef.php");

} else {
	echo "<script>
	
	alert(\"O sistema encontrou dificuldades em gerar o boleto.\\nUtilize a op��o de re-impress�o de boleto na p�gina principal.\");
	window.location='../../cursos.php';
	
	</script>";	
}
?>
