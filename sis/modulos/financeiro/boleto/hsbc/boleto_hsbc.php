<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto HSBC: Bruno Leonardo M. F. Gonçalves          |
// +----------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0;
$data_venc = DataUsaToBr($boleto->data_vencimento);  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $boleto->valor_cadastro; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
//$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=MoedaUsaToBr($valor_cobrado+$taxa_boleto);

if(!empty($boleto->doc)){
	$dadosboleto["numero_documento"] = str_pad($boleto->doc,13,"0",STR_PAD_LEFT);	// Número do documento - REGRA: Máximo de 13 digitos
}else{
	$dadosboleto["numero_documento"] = str_pad($boleto->movimentacao_id,13,"0",STR_PAD_LEFT);	// Número do documento - REGRA: Máximo de 13 digitos
}
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $internauta->razao_social;
$dadosboleto["endereco1"] = "$internauta->endereco $internauta->bairro";
$dadosboleto["endereco2"] = strtoupper("$internauta->cidade - $internauta->estado -  CEP: $internauta->cep");

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "$boleto->descricao";
$dadosboleto["demonstrativo2"] = "Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS PERSONALIZADOS - HSBC
$dadosboleto["codigo_cedente"] = $boleto->codigo_cedente; // Código do Cedente (Somente 7 digitos)
$dadosboleto["carteira"] = $movimentacao->carteira;  // Código da Carteira

// SEUS DADOS
$dadosboleto["identificacao"] = "$vkt_cliente_boleto->nome";
$dadosboleto["cpf_cnpj"] = "$vkt_cliente_boleto->cnpj";
$dadosboleto["endereco"] = "$vkt_cliente_boleto->endereco $vkt_cliente_boleto->bairro";
$dadosboleto["cidade_uf"] = strtoupper("$vkt_cliente_boleto->cidade / $vkt_cliente_boleto->estado");
$dadosboleto["cedente"] = "$vkt_cliente_boleto->nome";

// NÃO ALTERAR!
include("funcoes_hsbc.php"); 
include("layout_hsbc.php");
?>
