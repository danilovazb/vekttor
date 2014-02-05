<?
require '../../../../_config.php';
require '../../../../_functions_base.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Impressão de boletos</title>
<style type="text/css">
@charset "ISO-8859-1";
/* CSS Document */
body {
	margin: 0px;
}
.cobranca{ width:100%;height:315px;  clear:both; margin-bottom:15px;}
.canhoto {width:190px; float:left; height:315px; border-right:1px dotted #000; border-bottom:1px dotted #000; }

.canhoto .dv2{width:180px;border-bottom:2px solid #000; clear:both;}

.canhoto .ai{ width:150px; border-right:2px solid #000; height:250px;float:left;}
.canhoto .ai .d{ height:19px; border-bottom:0.1mm solid #000}
.canhoto .ai .d1{ width:74px; height:19px;border-right:1px solid #000; float:left;}
.canhoto .ai .d2{ width:74px; height:19px;float:left;}
.canhoto .ai b{ display:block; }


.lb{ margin:2px 0 5px 0;}
 .at { float:left; margin:50px 0 0 0;}
.bl{width:500px; margin-left:4px; float:left; height:315px;border-bottom:1px dotted #000; }

#tp{border-bottom:2px solid #000; height:30px;}
#tp u{text-decoration:none; display:block; float:left; width:200px; text-align:center; margin-left:50px; font-weight:bold; margin-top:5px;}
.bl i{display:block; font-style:normal;  border-bottom:1px solid #000;}
.bl i i i{border-bottom:0;}
.bl .l1{height:25px;}

.bl .c1{ float:left; height:25px; border-right:1px solid #000; width:90px; padding-left:2px}
.bl .c2{ float:left; height:25px; border-right:1px solid #000; width:93px;padding-left:2px}
.bl .c3{ float:left; height:25px; border-right:1px solid #000; width:45px;padding-left:2px}
.bl .c4{ float:left; height:25px; padding-left:3px}

#tp img{float:left; margin:2px 5px 2px 10px;}
.bl i b{ display:block;}
#ce{width:360px; border-right:1px solid #000; border-bottom:0; float:left;}

i.dc{ height:35px;}

.ip{ height:80px;}


#cd{float:left; width:130px; border:0;}
#cd i{ height:22px; width:100% }
#ld{ border-bottom:none; border:none; margin-left:5px; clear:both;}
#ld img{ height:50px;}
#ld b{font-size:10px}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	/*font-size: 7px;*/
	font-size: 7px;
}
</style>
</head>
<body>
<?

$cliente=mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='".$_SESSION['usuario']->cliente_vekttor_id."' "));
$busca_pago = " AND m.pago='N'";


$q= mysql_query($t="
  SELECT
	 fm.*, DATE_FORMAT(fm.data_registro,'%d/%m/%Y') as data_emitido,DATE_FORMAT(fm.data_vencimento,'%d/%m/%Y') as data_vencimento,
	fc.agencia as agencia,fc.conta as conta,fc.conta_digito as conta_digito, fc.codigo_banco as codigo_banco, fc._banco as banco, fc.conta_digito as conta_digito, fc.tipo_boleto as tipo_boleto, fc._carteira as carteira, fc.codigo_cedente as codigo_cedente, fc.num_inicio_boleto as num_inicio_boleto, cf.razao_social as responsavel, cf.cnpj_cpf as cnpj_cpf, cf.endereco as endereco, cf.cidade as cidade, cf.estado as estado, cf.bairro as bairro
  FROM
	  financeiro_movimento as fm, financeiro_contas as fc, cliente_fornecedor as cf
  WHERE
  	fm.id = '{$_GET['filtro_movimentacao']}'
  AND 
	  fm.cliente_id='$vkt_id'
  AND
  	 fc.id=fm.conta_id
AND
	cf.id=fm.internauta_id
  ORDER BY fm.doc, fm.data_vencimento ASC
   ");
   //echo $t." ".mysql_error();
   $banco=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento as fm, financeiro_contas as fc WHERE fm.cliente_id='$vkt_id' AND fm.id='{$_GET['filtro_movimentacao']}' AND fc.id = fm.conta_id "));
   
   echo mysql_error();
   //BB
   //echo $banco->codigo_banco;
   if($banco->codigo_banco==104){
	   $imagem="../../../boletos/imagens/logobb.jpg";
	   include("../../boletos/include/funcoes_bb.php");
   }
   //hsbc
   if($banco->codigo_banco==399){
	   $imagem="../../../boletos/imagens/logohsbc.jpg";
	   include("../../boletos/include/funcoes_hsbc.php");
   }
   //itau
   if($banco->codigo_banco==409){
	   $imagem="../../../boletos/imagens/logoitau.jpg";
	   include("../../boletos/include/funcoes_itau.php");
   }
   //bradesco
   if($banco->codigo_banco==237){
	   
	   $imagem="../../i/l";
	   include_once '../../boletos/include/_functions_bradesco.php';
   }
   
   $doc='';
while($r=mysql_fetch_object($q)){/*
$boleto=mysql_fetch_object(mysql_query($b="
SELECT 
	fm.*, DATE_FORMAT(fm.data_registro,'%d/%m/%Y') as data_emitido,DATE_FORMAT(fm.data_vencimento,'%d/%m/%Y') as data_vencimento,
	fc.agencia as agencia, fc.conta as conta, fc.conta_digito as conta_digito, fc.tipo_boleto as tipo_boleto, cf.razao_social as responsavel
FROM 
	financeiro_movimento as fm, financeiro_contas as fc, cliente_fornecedor as cf
WHERE 
	fm.id='".$r->id."'
AND
	fc.id=fm.conta_id
AND
	cf.id=fm.internauta_id "));*/
	$qtd=mysql_result(mysql_query($a="SELECT COUNT(*) FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND doc='".$r->doc."'"),0);
	if($r->doc!=$doc){
		$doc= $r->doc;
		$boleto_atual=0;	
	}
	
	$matricula=mysql_fetch_object(mysql_query("SELECT * FROM escolar2_matriculas as em, escolar2_turmas as et, escolar2_unidades as eu, cliente_fornecedor as cf 
	WHERE 
		em.id='".$r->doc."'
	AND
		et.id=em.turma_id
	AND
		eu.id=et.unidade_id
	AND
		cf.id=em.responsavel_id"));
	//$escola=mysql_fetch_object(mysql_query("SELECT * FROM escolar2_escolas WHERE id='".$r->escola_id."'"));
	//$conta=mysql_fetch_object(mysql_query($t="SELECT fc.* FROM escolar_cursos_unidades_contas as ecu, financeiro_contas as fc
	//WHERE ecu.curso_id='".$matricula->curso_id."' AND ecu.unidade_id='".$matricula->escola_id."' AND ecu.conta_id=fc.id"));
	//$responsavel=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$matricula->responsavel_id."'"));
		$boleto_atual++;
	if($boleto_atual>$qtd){
		$boleto_atual=1;
	}
	//HSBC
	if($r->codigo_banco==399){
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
		$taxa_boleto = 2.95;
		$data_venc = date($r->data_vencimento, time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
		$valor_cobrado = number_format($r->valor_cadastro,2,',',''); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
		
		$dadosboleto["numero_documento"] = str_pad($r->id,13,0);;	// Número do documento - REGRA: Máximo de 13 digitos
		$dadosboleto["data_vencimento"] = $r->data_vencimento; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$dadosboleto["data_documento"] = $r->data_emitido; // Data de emissão do Boleto
		$dadosboleto["data_processamento"] = $r->data_emitido; // Data de processamento do boleto (opcional)
		$dadosboleto["valor_boleto"] = moedaUsaToBR($r->valor_cadastro); 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
		
		// DADOS DO SEU CLIENTE
		$dadosboleto["sacado"] = $r->responsavel;
		$dadosboleto["endereco1"] = "$r->endereco $r->bairro";
		$dadosboleto["endereco2"] = "$r->cidade - $r->estado - CEP:$r->cep";
		
		// INFORMACOES PARA O CLIENTE
		$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Nonononono";
		$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
		$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
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
		$dadosboleto["codigo_cedente"] = $r->codigo_cedente; // Código do Cedente (Somente 7 digitos)
		$dadosboleto["carteira"] = "CNR";  // Código da Carteira
		
		// SEUS DADOS
		$dadosboleto["identificacao"] = "BoletoPhp - Código Aberto de Sistema de Boletos";
		$dadosboleto["cpf_cnpj"] = $r->cnpj_cpf;
		$dadosboleto["endereco"] = "Coloque o endereço da sua empresa aqui";
		$dadosboleto["cidade_uf"] = "Cidade / Estado";
		$dadosboleto["cedente"] = "Coloque a Razão Social da sua empresa aqui";
		
		// NÃO ALTERAR!
		$codigobanco = "399";
		$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
		$nummoeda = "9";
		$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);
		
		//valor tem 10 digitos, sem virgula
		$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
		//carteira é CNR
		$carteira = $dadosboleto["carteira"];
		//codigocedente deve possuir 7 caracteres
		$codigocedente = formata_numero($dadosboleto["codigo_cedente"],7,0);
		
		$ndoc = $dadosboleto["numero_documento"];
		$vencimento = $dadosboleto["data_vencimento"];
		
		// número do documento (sem dvs) é 13 digitos
		$nnum = formata_numero($dadosboleto["numero_documento"],13,0);
		// nosso número (com dvs) é 16 digitos
		$nossonumero = geraNossoNumero($nnum,$codigocedente,$vencimento,'4');
		
		$vencjuliano = dataJuliano($vencimento);
		$app = "2";
		
		// 43 numeros para o calculo do digito verificador do codigo de barras
		$barra = "$codigobanco$nummoeda$fator_vencimento$valor$codigocedente$nnum$vencjuliano$app";
		$dv = digitoVerificador_barra($barra, 9, 0);
		// Numero para o codigo de barras com 44 digitos
		$linha = substr($barra,0,4) . $dv . substr($barra,4);
		
		$agencia_codigo = $codigocedente;
		
		$dadosboleto["codigo_barras"] = $linha;
		$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha);
		$dadosboleto["agencia_codigo"] = $agencia_codigo;
		$dadosboleto["nosso_numero"] = $nossonumero;
		$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;
		$codigo_barras = fbarcodeHSBC($dadosboleto["codigo_barras"]);
		
			//=========Dados Obrigatórios para gerar o Boleto =================
		$entra["data_documento"] 		= $r->data_emitido; 	// Data de emissão do Boleto  formato DD/MM/AAAA
		$entra["data_vencimento"] 		= $r->data_vencimento; 	// Data de Vencimento do Boleto formato DD/MM/AAAA
		$entra["numero_documento"]		= $nossonumero;	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
		$entra["nosso_numero"]	 		= $nossonumero; 	// Nosso Numero S/ DAC (É por meio deste numero que você idenficará o boleto pago)
		$entra["valor"] 				= number_format($r->valor_cadastro,2,',','');  		// Valor do Boleto (Utilizar virgula como separador decimal, não use pontos)
		$entra["linha_digitavel"] 				= $dadosboleto["linha_digitavel"];
		$entra["carteira"] 				= $dadosboleto["carteira"];
		//=============Dados do Titular da Conta===============
		$entra["cpf_cnpj_cedente"] 	= $cliente->cnpj;
		$entra["endereco"] 			= $cliente->endereco;
		$entra["cidade"] 			= "$cliente->cidade - $cliente->estado";
		$entra["cedente"] 			= $cliente->nome_fantasia;
		//=========Dados Do Cedente ==================
		$entra["agencia"]					= $r->agencia; 				// Numero da Agência 4 Digitos s/DAC
		//$entra["conta"] 					= substr($vkt_cliente_boleto->conta_corrente,0,-1); 	 		// Numero da Conta 7 Digitos s/ DAC
		
		$entra["conta"] 					= $r->conta;
		//$entra["digito_conta"]				= substr($vkt_cliente_boleto->conta_corrente,strlen($vkt_cliente_boleto->conta_corrente)-1,1); 					// Digito da Conta Corrente 1 Digito
		$entra["digito_conta"]				= $r->conta_digito; 					// Digito da Conta Corrente 1 Digito
		$entra["carteira"]					= "CNR";  				// Código da Carteira

		
		//===Dados do seu Cliente (Opcional)===============
		$entra["sacado"]				= $r->responsavel;
		$entra["cnpj_cpf"]				= $r->cnpj_cpf;
		$entra["endereco1"] 			= "$r->endereco $r->bairro";
		$entra["endereco2"] 			= "$r->cidade - $r->estado - CEP:$r->cep";
		
		//==Os Campos Abaixo são Opcionais=================
		$entra["instrucoes"] 				= $instrucoes; //Instruçoes para o Cliente
		$entra["instrucoes1"] 				= @nl2br($vkt_cliente_boleto->instrucao_boleto); // Por exemplo "Não receber apos o vencimento" ou "Cobrar Multa de 1% ao mês"Após o Vencimento Cobrar Multa de 2% e Juros de R$0,02 ao Dia
		$entra["instrucoes2"] 				= "";
		$entra["instrucoes3"] 				= "";
		$entra["instrucoes4"] 				= "";
		$entra["instrucoes5"] 				= "";
		$entra["data_processamento"]		= date("d/m/Y");
		$entra["quantidade"]				= "";
		$entra["valor_unitario"] 			= "";
		
		//==Dados com valores padrões ===================
		$entra["aceite"]					= "";			
		$entra["uso_banco"] 				= ""; 	
		$entra["especie"] 					= "R$"; 
		$entra["especie_doc"] 				= "DS";
		//======================================
		
		$entra["agencia_codigo"] 				= $entra["agencia"].'/'.$entra["conta"].'-'.$entra["digito_conta"];

	}
	
	//ITAÚ teste
	/*if($r->codigo_banco==409){
		
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
		// | Desenvolvimento Boleto Itaú: Glauber Portella                        |
		// +----------------------------------------------------------------------+
		
		
		// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
		// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//
		
		// DADOS DO BOLETO PARA O SEU CLIENTE
		$dias_de_prazo_para_pagamento = 5;
		$taxa_boleto = 2.95;
		$data_venc = date('05/12/2013', time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
		$valor_cobrado = number_format("1500,00",2,',',''); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
		
		$dadosboleto["nosso_numero"] = "36560844";  // Nosso numero - REGRA: Máximo de 8 caracteres!
		$dadosboleto["numero_documento"] = $r->id;	// Num do pedido ou nosso numero
		$dadosboleto["data_vencimento"] = "05/12/2013"; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$dadosboleto["data_documento"] = "26/06/2013"; // Data de emissão do Boleto
		$dadosboleto["data_processamento"] = "26/06/2013"; // Data de processamento do boleto (opcional)
		$dadosboleto["valor_boleto"] = "1500,00"; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
		
		// DADOS DO SEU CLIENTE
		$dadosboleto["sacado"] = "Teste";
		$dadosboleto["endereco1"] = $r->endereco;
		$dadosboleto["endereco2"] = $r->cidade.' - '.$r->estado.' - CEP: $r->cep';//"Cidade - Estado -  CEP: 00000-000";
		
		// INFORMACOES PARA O CLIENTE
		$dadosboleto["demonstrativo1"] = "Pagamento de Mensalidade";
		$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
		$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
		$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
		$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
		$dadosboleto["instrucoes3"] = "";
		$dadosboleto["instrucoes4"] = "";
		
		// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
		$dadosboleto["quantidade"] = "";
		$dadosboleto["valor_unitario"] = "";
		$dadosboleto["aceite"] = "";		
		$dadosboleto["especie"] = "R$";
		$dadosboleto["especie_doc"] = "";
		
		
		// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
		
		
		// DADOS DA SUA CONTA - ITAÚ
		$dadosboleto["agencia"] ="7221"; // Num da agencia, sem digito
		$dadosboleto["conta"] = "12000";	// Num da conta, sem digito
		$dadosboleto["conta_dv"] = "4"; 	// Digito do Num da conta
		
		// DADOS PERSONALIZADOS - ITAÚ
		//$dadosboleto["carteira"] = $r->carteira;  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157
		$dadosboleto["carteira"] = 157;
		
		// SEUS DADOS
		$dadosboleto["identificacao"] = $cliente->nome_fantasia;
		$dadosboleto["cpf_cnpj"] = $cliente->cnpj;
		$dadosboleto["endereco"] = $cliente->endereco;
		$dadosboleto["cidade_uf"] = "$cliente->cidade - $cliente->estado";
		$dadosboleto["cedente"] = $cliente->nome_fantasia;
		$codigobanco = "341";
		$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
		$nummoeda = "9";
		$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);
		
		//valor tem 10 digitos, sem virgula
		$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
		//agencia é 4 digitos
		$agencia = formata_numero($dadosboleto["agencia"],4,0);
		//conta é 5 digitos + 1 do dv
		$conta = formata_numero($dadosboleto["conta"],5,0);
		$conta_dv = formata_numero($dadosboleto["conta_dv"],1,0);
		//carteira 175
		$carteira = $dadosboleto["carteira"];
		//nosso_numero no maximo 8 digitos
		$nnum = formata_numero($dadosboleto["nosso_numero"],8,0);
		
		$codigo_barras = $codigobanco.$nummoeda.$fator_vencimento.$valor.$carteira.$nnum.modulo_10($agencia.$conta.$carteira.$nnum).$agencia.$conta.modulo_10($agencia.$conta).'000';
		// 43 numeros para o calculo do digito verificador
		$dv = digitoVerificador_barra($codigo_barras);
		// Numero para o codigo de barras com 44 digitos
		$linha = substr($codigo_barras,0,4).$dv.substr($codigo_barras,4,43);
		
		$nossonumero = $carteira.'/'.$nnum.'-'.modulo_10($agencia.$conta.$carteira.$nnum);
		$agencia_codigo = $agencia." / ". $conta."-".modulo_10($agencia.$conta);
		
		$dadosboleto["codigo_barras"] = $linha;
		$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha); // verificar
		$dadosboleto["agencia_codigo"] = $agencia_codigo ;
		$dadosboleto["nosso_numero"] = $nossonumero;
		$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

		$codigo_barras=fbarcodeITAU($dadosboleto["codigo_barras"]);
		$entra['linha_digitavel']=$dadosboleto["linha_digitavel"];
		//=========Dados Do Cedente ==================
	$entra["agencia"]					= $r->agencia; 				// Numero da Agência 4 Digitos s/DAC
	//$entra["conta"] 					= substr($vkt_cliente_boleto->conta_corrente,0,-1); 	 		// Numero da Conta 7 Digitos s/ DAC
	
	$entra["conta"] 					= $r->conta;
	//$entra["digito_conta"]				= substr($vkt_cliente_boleto->conta_corrente,strlen($vkt_cliente_boleto->conta_corrente)-1,1); 					// Digito da Conta Corrente 1 Digito
	$entra["digito_conta"]				= $r->conta_digito; 					// Digito da Conta Corrente 1 Digito
	$entra["carteira"]					= $r->carteira;  						// Código da Carteira
	
	//=========Dados Obrigatórios para gerar o Boleto =================
	$entra["data_documento"] 		= $r->data_emitido; 	// Data de emissão do Boleto  formato DD/MM/AAAA
	$entra["data_vencimento"] 		= $r->data_vencimento; 	// Data de Vencimento do Boleto formato DD/MM/AAAA
	$entra["numero_documento"]		= $r->id;	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
	$entra["nosso_numero"]	 		= $dadosboleto["nosso_numero"]; 	// Nosso Numero S/ DAC (É por meio deste numero que você idenficará o boleto pago)
	$entra["valor"] 				= number_format($r->valor_cadastro,2,',',''); 		// Valor do Boleto (Utilizar virgula como separador decimal, não use pontos)
	//=============Dados do Titular da Conta===============
	$entra["cpf_cnpj_cedente"] 	= $cliente->cnpj;
	$entra["endereco"] 			= $cliente->endereco;
	$entra["cidade"] 			= "$cliente->cidade - $cliente->estado";
	$entra["cedente"] 			= $cliente->nome_fantasia;
	
	//===Dados do seu Cliente (Opcional)===============
		$entra["sacado"]				= $r->responsavel;
		$entra["cnpj_cpf"]				= $r->cnpj_cpf;
		$entra["endereco1"] 			= "$r->endereco $r->bairro";
		$entra["endereco2"] 			= "$r->cidade - $r->estado - CEP:$r->cep";
	
	//==Os Campos Abaixo são Opcionais=================
	$entra["instrucoes"] 				= $instrucoes; //Instruçoes para o Cliente
	$entra["instrucoes1"] 				= @nl2br($vkt_cliente_boleto->instrucao_boleto); // Por exemplo "Não receber apos o vencimento" ou "Cobrar Multa de 1% ao mês"Após o Vencimento Cobrar Multa de 2% e Juros de R$0,02 ao Dia
	$entra["instrucoes2"] 				= "";
	$entra["instrucoes3"] 				= "";
	$entra["instrucoes4"] 				= "";
	$entra["instrucoes5"] 				= "";
	$entra["data_processamento"]		= date("d/m/Y");
	$entra["quantidade"]				= "";
	$entra["valor_unitario"] 			= "";
	
	//==Dados com valores padrões ===================
	$entra["aceite"]					= "N";			
	$entra["uso_banco"] 				= ""; 	
	$entra["especie"] 					= "R$"; 
	$entra["especie_doc"] 				= "DS";
	//======================================
	$entra["agencia_codigo"] 			= $entra["agencia"].'/'.$entra["conta"].'-'.$entra["digito_conta"];
	//echo "<pre>";print_r($entra);echo "</pre>";
	}*/
	
	//ITAÚ
	if($r->codigo_banco==409){ 
		
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
		// | Desenvolvimento Boleto Itaú: Glauber Portella                        |
		// +----------------------------------------------------------------------+
		
		
		// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
		// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//
		
		// DADOS DO BOLETO PARA O SEU CLIENTE
		$dias_de_prazo_para_pagamento = 5;
		$taxa_boleto = 2.95;
		$data_venc = date('d/m/Y', time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
		$valor_cobrado = number_format($r->valor_cadastro,2,',',''); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
		
		$dadosboleto["nosso_numero"] = str_pad($r->id,8,0);  // Nosso numero - REGRA: Máximo de 8 caracteres!
		$dadosboleto["numero_documento"] = $r->id;	// Num do pedido ou nosso numero
		$dadosboleto["data_vencimento"] = $r->data_vencimento; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$dadosboleto["data_documento"] = $r->data_emitido; // Data de emissão do Boleto
		$dadosboleto["data_processamento"] = $r->data_emitido; // Data de processamento do boleto (opcional)
		$dadosboleto["valor_boleto"] = number_format($r->valor_cadastro,2,',',''); 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
		
		// DADOS DO SEU CLIENTE
		$dadosboleto["sacado"] = $r->data_emitido;
		$dadosboleto["endereco1"] = $r->endereco;
		$dadosboleto["endereco2"] = $r->cidade.' - '.$r->estado.' - CEP: $r->cep';//"Cidade - Estado -  CEP: 00000-000";
		
		// INFORMACOES PARA O CLIENTE
		$dadosboleto["demonstrativo1"] = "Pagamento de Mensalidade";
		$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
		$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
		$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
		$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
		$dadosboleto["instrucoes3"] = "";
		$dadosboleto["instrucoes4"] = "";
		
		// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
		$dadosboleto["quantidade"] = "";
		$dadosboleto["valor_unitario"] = "";
		$dadosboleto["aceite"] = "";		
		$dadosboleto["especie"] = "R$";
		$dadosboleto["especie_doc"] = "";
		
		
		// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
		
		
		// DADOS DA SUA CONTA - ITAÚ
		$dadosboleto["agencia"] =$r->agencia; // Num da agencia, sem digito
		$dadosboleto["conta"] = $r->conta;	// Num da conta, sem digito
		$dadosboleto["conta_dv"] = $r->conta_digito; 	// Digito do Num da conta
		
		// DADOS PERSONALIZADOS - ITAÚ
		$dadosboleto["carteira"] = $r->carteira;  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157
		
		// SEUS DADOS
		$dadosboleto["identificacao"] = $cliente->nome_fantasia;
		$dadosboleto["cpf_cnpj"] = $cliente->cnpj;
		$dadosboleto["endereco"] = $cliente->endereco;
		$dadosboleto["cidade_uf"] = "$cliente->cidade - $cliente->estado";
		$dadosboleto["cedente"] = $cliente->nome_fantasia;
		$codigobanco = "341";
		$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
		$nummoeda = "9";
		$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);
		
		//valor tem 10 digitos, sem virgula
		$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
		//agencia é 4 digitos
		$agencia = formata_numero($dadosboleto["agencia"],4,0);
		//conta é 5 digitos + 1 do dv
		$conta = formata_numero($dadosboleto["conta"],5,0);
		$conta_dv = formata_numero($dadosboleto["conta_dv"],1,0);
		//carteira 175
		$carteira = $dadosboleto["carteira"];
		//nosso_numero no maximo 8 digitos
		$nnum = formata_numero($dadosboleto["nosso_numero"],8,0);
		
		$codigo_barras = $codigobanco.$nummoeda.$fator_vencimento.$valor.$carteira.$nnum.modulo_10($agencia.$conta.$carteira.$nnum).$agencia.$conta.modulo_10($agencia.$conta).'000';
		// 43 numeros para o calculo do digito verificador
		$dv = digitoVerificador_barra($codigo_barras);
		// Numero para o codigo de barras com 44 digitos
		$linha = substr($codigo_barras,0,4).$dv.substr($codigo_barras,4,43);
		
		$nossonumero = $carteira.'/'.$nnum.'-'.modulo_10($agencia.$conta.$carteira.$nnum);
		$agencia_codigo = $agencia." / ". $conta."-".modulo_10($agencia.$conta);
		
		$dadosboleto["codigo_barras"] = $linha;
		$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha); // verificar
		$dadosboleto["agencia_codigo"] = $agencia_codigo ;
		$dadosboleto["nosso_numero"] = $nossonumero;
		$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

		$codigo_barras=fbarcodeITAU($dadosboleto["codigo_barras"]);
		$entra['linha_digitavel']=$dadosboleto["linha_digitavel"];
		//=========Dados Do Cedente ==================
	$entra["agencia"]					= $r->agencia; 				// Numero da Agência 4 Digitos s/DAC
	//$entra["conta"] 					= substr($vkt_cliente_boleto->conta_corrente,0,-1); 	 		// Numero da Conta 7 Digitos s/ DAC
	
	$entra["conta"] 					= $r->conta;
	//$entra["digito_conta"]				= substr($vkt_cliente_boleto->conta_corrente,strlen($vkt_cliente_boleto->conta_corrente)-1,1); 					// Digito da Conta Corrente 1 Digito
	$entra["digito_conta"]				= $r->conta_digito; 					// Digito da Conta Corrente 1 Digito
	$entra["carteira"]					= $r->carteira;  						// Código da Carteira
	
	
	//=========Dados Obrigatórios para gerar o Boleto =================
	$entra["data_documento"] 		= $r->data_emitido; 	// Data de emissão do Boleto  formato DD/MM/AAAA
	$entra["data_vencimento"] 		= $r->data_vencimento; 	// Data de Vencimento do Boleto formato DD/MM/AAAA
	$entra["numero_documento"]		= $r->id;	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
	$entra["nosso_numero"]	 		= $dadosboleto["nosso_numero"]; 	// Nosso Numero S/ DAC (É por meio deste numero que você idenficará o boleto pago)
	$entra["valor"] 				= number_format($r->valor_cadastro,2,',',''); 		// Valor do Boleto (Utilizar virgula como separador decimal, não use pontos)
	//=============Dados do Titular da Conta===============
	$entra["cpf_cnpj_cedente"] 	= $cliente->cnpj;
	$entra["endereco"] 			= $cliente->endereco;
	$entra["cidade"] 			= "$cliente->cidade - $cliente->estado";
	$entra["cedente"] 			= $cliente->nome_fantasia;
	
	//===Dados do seu Cliente (Opcional)===============
		$entra["sacado"]				= $r->responsavel;
		$entra["cnpj_cpf"]				= $r->cnpj_cpf;
		$entra["endereco1"] 			= "$r->endereco $r->bairro";
		$entra["endereco2"] 			= "$r->cidade - $r->estado - CEP:$r->cep";
	
	//==Os Campos Abaixo são Opcionais=================
	$entra["instrucoes"] 				= $instrucoes; //Instruçoes para o Cliente
	$entra["instrucoes1"] 				= @nl2br($vkt_cliente_boleto->instrucao_boleto); // Por exemplo "Não receber apos o vencimento" ou "Cobrar Multa de 1% ao mês"Após o Vencimento Cobrar Multa de 2% e Juros de R$0,02 ao Dia
	$entra["instrucoes2"] 				= "";
	$entra["instrucoes3"] 				= "";
	$entra["instrucoes4"] 				= "";
	$entra["instrucoes5"] 				= "";
	$entra["data_processamento"]		= date("d/m/Y");
	$entra["quantidade"]				= "";
	$entra["valor_unitario"] 			= "";
	
	//==Dados com valores padrões ===================
	$entra["aceite"]					= "N";			
	$entra["uso_banco"] 				= ""; 	
	$entra["especie"] 					= "R$"; 
	$entra["especie_doc"] 				= "DS";
	//======================================
	$entra["agencia_codigo"] 			= $entra["agencia"].'/'.$entra["conta"].'-'.$entra["digito_conta"];
	//echo "<pre>";print_r($entra);echo "</pre>";
	}
	
	//BRADESCO
	if($r->codigo_banco==237){
	
	//	print_r($boleto);
	
	//$vkt_cliente=mysql_fetch_object(mysql_query("SELECT * FROM clientes WHERE id='$boleto->cliente_id'"));
	
	//$internauta=mysql_fetch_object(mysql_query("SELECT * FROM internautas WHERE id='$boleto->internauta_id'"));
	//print_r($internauta);
	//=========Dados Do Cedente ==================
	$entra["agencia"]					= $r->agencia; 				// Numero da Agência 4 Digitos s/DAC
	//$entra["conta"] 					= substr($vkt_cliente_boleto->conta_corrente,0,-1); 	 		// Numero da Conta 7 Digitos s/ DAC
	
	$entra["conta"] 					= $r->conta;
	//$entra["digito_conta"]				= substr($vkt_cliente_boleto->conta_corrente,strlen($vkt_cliente_boleto->conta_corrente)-1,1); 					// Digito da Conta Corrente 1 Digito
	$entra["digito_conta"]				= $r->conta_digito; 					// Digito da Conta Corrente 1 Digito
	$entra["carteira"]					= $r->tipo_boleto;  				// Código da Carteira
	/*
	if( $boleto->vencido>0){
		$multa = $boleto->valor*($vkt_cliente_boleto->multa/100);
		$juros = $boleto->valor*pow((1+($vkt_cliente_boleto->juros/100)),$boleto->vencido);
		$instrucoes = "<span style='color:red'>Fatura vencida dia  <strong>$boleto->data_vencimentoF </strong>, Valores Atualizados para (".date("d/m/Y").")</span><br />
	Estão Inclusos Multa de R$ ".number_format($multa,2,',','')."<br />
	Estão Inclusos Juros de $boleto->vencido Dias R$ ".number_format($juros-$boleto->valor,2,',','')."
	";
		$boleto->data_vencimentoF = date("d/m/Y");
		$boleto->valor = $juros+$multa;
	}
	*/
	
	//=========Dados Obrigatórios para gerar o Boleto =================
	$entra["data_documento"] 		= $r->data_emitido; 	// Data de emissão do Boleto  formato DD/MM/AAAA
	$entra["data_vencimento"] 		= $r->data_vencimento; 	// Data de Vencimento do Boleto formato DD/MM/AAAA
	$entra["numero_documento"]		= $r->id;	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
	$entra["nosso_numero"]	 		= $r->id; 	// Nosso Numero S/ DAC (É por meio deste numero que você idenficará o boleto pago)
	$entra["valor"] 				= number_format($r->valor_cadastro,2,',',''); 		// Valor do Boleto (Utilizar virgula como separador decimal, não use pontos)
	//=============Dados do Titular da Conta===============
	$entra["cpf_cnpj_cedente"] 	= $cliente->cnpj;
	$entra["endereco"] 			= $cliente->endereco;
	$entra["cidade"] 			= "$cliente->cidade - $cliente->estado";
	$entra["cedente"] 			= $cliente->nome_fantasia;
	
	//===Dados do seu Cliente (Opcional)===============
		$entra["sacado"]				= $r->responsavel;
		$entra["cnpj_cpf"]				= $r->cnpj_cpf;
		$entra["endereco1"] 			= "$r->endereco $r->bairro";
		$entra["endereco2"] 			= "$r->cidade - $r->estado - CEP:$r->cep";
	
	//==Os Campos Abaixo são Opcionais=================
	$entra["instrucoes"] 				= $instrucoes; //Instruçoes para o Cliente
	$entra["instrucoes1"] 				= @nl2br($vkt_cliente_boleto->instrucao_boleto); // Por exemplo "Não receber apos o vencimento" ou "Cobrar Multa de 1% ao mês"Após o Vencimento Cobrar Multa de 2% e Juros de R$0,02 ao Dia
	$entra["instrucoes2"] 				= "";
	$entra["instrucoes3"] 				= "";
	$entra["instrucoes4"] 				= "";
	$entra["instrucoes5"] 				= "";
	$entra["data_processamento"]		= date("d/m/Y");
	$entra["quantidade"]				= "";
	$entra["valor_unitario"] 			= "";
	
	//==Dados com valores padrões ===================
	$entra["aceite"]					= "N";			
	$entra["uso_banco"] 				= ""; 	
	$entra["especie"] 					= "R$"; 
	$entra["especie_doc"] 				= "DS";
	//======================================
	//echo "<pre>";print_r($entra);echo "</pre>";
	$b = new boletoBradesco();		
	$b->banco_bradesco($entra);
	$codigo_barras = fbarcode($entra["codigo_barras"]);
	}
	//BB
	if($r->codigo_banco==104){
		
		
		$dias_de_prazo_para_pagamento = 5;
		$taxa_boleto = 2.95;
		$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
		$valor_cobrado = number_format($r->valor_cadastro,2,',',''); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
		$valor_cobrado = str_replace(",", ".",$valor_cobrado);
		$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
		
		$dadosboleto["nosso_numero"] = "87654";
		$dadosboleto["numero_documento"] = $r->id;	// Num do pedido ou do documento
		$dadosboleto["data_vencimento"] = $r->data_vencimento; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
		$dadosboleto["data_documento"] = $r->emitido; // Data de emissão do Boleto
		$dadosboleto["data_processamento"] = $r->emitido; // Data de processamento do boleto (opcional)
		$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
		
		// DADOS DO SEU CLIENTE
		$dadosboleto["sacado"] = $r->razao_social;
		$dadosboleto["endereco1"] = "$r->endereco $r->bairro";
		$dadosboleto["endereco2"] = "$r->cidade - $r->estado - CEP:$r->cep";
		
		// INFORMACOES PARA O CLIENTE
		$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Nonononono";
		$dadosboleto["demonstrativo2"] = "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
		$dadosboleto["demonstrativo3"] = "BoletoPhp - http://www.boletophp.com.br";
		
		// INSTRUÇÕES PARA O CAIXA
		$dadosboleto["instrucoes1"] = @nl2br($vkt_cliente_boleto->instrucao_boleto);
		$dadosboleto["instrucoes2"] = "";
		$dadosboleto["instrucoes3"] = "";
		$dadosboleto["instrucoes4"] = "";
		
		// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
		$dadosboleto["quantidade"] = "10";
		$dadosboleto["valor_unitario"] = "10";
		$dadosboleto["aceite"] = "N";		
		$dadosboleto["especie"] = "R$";
		$dadosboleto["especie_doc"] = "DM";
		
		
		// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
		
		
		// DADOS DA SUA CONTA - BANCO DO BRASIL
		$dadosboleto["agencia"] = $r->agencia; // Num da agencia, sem digito
		$dadosboleto["conta"] = $r->conta; 	// Num da conta, sem digito
		
		// DADOS PERSONALIZADOS - BANCO DO BRASIL
		$dadosboleto["convenio"] = $r->_convenio;  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
		$dadosboleto["contrato"] = $r->_contrato; // Num do seu contrato
		$dadosboleto["carteira"] = "18";
		$dadosboleto["variacao_carteira"] = "";  // Variação da Carteira, com traço (opcional)
		
		// TIPO DO BOLETO
		$dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
		$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for NossoNúmero de até 5 dígitos ou 2 para opção de até 17 dígitos
		
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
		$dadosboleto["identificacao"] = $cliente->cnpj;
		$dadosboleto["cpf_cnpj"] = $cliente->cnpj;
		$dadosboleto["endereco"] = $cliente->endereco;
		$dadosboleto["cidade_uf"] = "$cliente->cidade / $cliente->estado";
		$dadosboleto["cedente"] = $cliente->nome_fantasia;
		
		$entra['linha_digitavel']=$dadosboleto["linha_digitavel"];
		$codigobanco = "001";
		$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
		$nummoeda = "9";
		$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);
		
		//valor tem 10 digitos, sem virgula
		$valor = formata_numero($dadosboleto["valor_boleto"],10,0,"valor");
		//agencia é sempre 4 digitos
		$agencia = formata_numero($dadosboleto["agencia"],4,0);
		//conta é sempre 8 digitos
		$conta = formata_numero($dadosboleto["conta"],8,0);
		//carteira 18
		$carteira = $dadosboleto["carteira"];
		//agencia e conta
		$agencia_codigo = $agencia."-". modulo_11($agencia) ." / ". $conta ."-". modulo_11($conta);
		//Zeros: usado quando convenio de 7 digitos
		$livre_zeros='000000';
		
		// Carteira 18 com Convênio de 8 dígitos
		if ($dadosboleto["formatacao_convenio"] == "8") {
			$convenio = formata_numero($dadosboleto["convenio"],8,0,"convenio");
			// Nosso número de até 9 dígitos
			$nossonumero = formata_numero($dadosboleto["nosso_numero"],9,0);
			$dv=modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira");
			$linha="$codigobanco$nummoeda$dv$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira";
			//montando o nosso numero que aparecerá no boleto
			$nossonumero = $convenio . $nossonumero ."-". modulo_11($convenio.$nossonumero);
		}
		
		// Carteira 18 com Convênio de 7 dígitos
		if ($dadosboleto["formatacao_convenio"] == "7") {
			$convenio = formata_numero($dadosboleto["convenio"],7,0,"convenio");
			// Nosso número de até 10 dígitos
			$nossonumero = formata_numero($dadosboleto["nosso_numero"],10,0);
			$dv=modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira");
			$linha="$codigobanco$nummoeda$dv$fator_vencimento$valor$livre_zeros$convenio$nossonumero$carteira";
		  $nossonumero = $convenio.$nossonumero;
			//Não existe DV na composição do nosso-número para convênios de sete posições
		}
		
		// Carteira 18 com Convênio de 6 dígitos
		if ($dadosboleto["formatacao_convenio"] == "6") {
			$convenio = formata_numero($dadosboleto["convenio"],6,0,"convenio");
			
			if ($dadosboleto["formatacao_nosso_numero"] == "1") {
				
				// Nosso número de até 5 dígitos
				$nossonumero = formata_numero($dadosboleto["nosso_numero"],5,0);
				$dv = modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$convenio$nossonumero$agencia$conta$carteira");
				$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$convenio$nossonumero$agencia$conta$carteira";
				//montando o nosso numero que aparecerá no boleto
				$nossonumero = $convenio . $nossonumero ."-". modulo_11($convenio.$nossonumero);
			}
			
			if ($dadosboleto["formatacao_nosso_numero"] == "2") {
				
				// Nosso número de até 17 dígitos
				$nservico = "21";
				$nossonumero = formata_numero($dadosboleto["nosso_numero"],17,0);
				$dv = modulo_11("$codigobanco$nummoeda$fator_vencimento$valor$convenio$nossonumero$nservico");
				$linha = "$codigobanco$nummoeda$dv$fator_vencimento$valor$convenio$nossonumero$nservico";
			}
		}
		
		$dadosboleto["codigo_barras"] = $linha;
		$dadosboleto["linha_digitavel"] = monta_linha_digitavel($linha);
		$dadosboleto["agencia_codigo"] = $agencia_codigo;
		$dadosboleto["nosso_numero"] = $nossonumero;
		$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;
		
		
		$codigo_barras= fbarcode($dadosboleto['codigo_barras']);
		$entra['linha_digitavel']=$dadosboleto["linha_digitavel"];
		//=========Dados Do Cedente ==================
	$entra["agencia"]					= $r->agencia; 				// Numero da Agência 4 Digitos s/DAC
	//$entra["conta"] 					= substr($vkt_cliente_boleto->conta_corrente,0,-1); 	 		// Numero da Conta 7 Digitos s/ DAC
	
	$entra["conta"] 					= $r->conta;
	//$entra["digito_conta"]				= substr($vkt_cliente_boleto->conta_corrente,strlen($vkt_cliente_boleto->conta_corrente)-1,1); 					// Digito da Conta Corrente 1 Digito
	$entra["digito_conta"]				= $r->conta_digito; 					// Digito da Conta Corrente 1 Digito
	$entra["carteira"]					= $r->tipo_boleto;  				// Código da Carteira
	/*
	if( $boleto->vencido>0){
		$multa = $boleto->valor*($vkt_cliente_boleto->multa/100);
		$juros = $boleto->valor*pow((1+($vkt_cliente_boleto->juros/100)),$boleto->vencido);
		$instrucoes = "<span style='color:red'>Fatura vencida dia  <strong>$boleto->data_vencimentoF </strong>, Valores Atualizados para (".date("d/m/Y").")</span><br />
	Estão Inclusos Multa de R$ ".number_format($multa,2,',','')."<br />
	Estão Inclusos Juros de $boleto->vencido Dias R$ ".number_format($juros-$boleto->valor,2,',','')."
	";
		$boleto->data_vencimentoF = date("d/m/Y");
		$boleto->valor = $juros+$multa;
	}
	*/
	
	//=========Dados Obrigatórios para gerar o Boleto =================
	$entra["data_documento"] 		= $r->data_emitido; 	// Data de emissão do Boleto  formato DD/MM/AAAA
	$entra["data_vencimento"] 		= $r->data_vencimento; 	// Data de Vencimento do Boleto formato DD/MM/AAAA
	$entra["numero_documento"]		= $r->id;	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
	$entra["nosso_numero"]	 		= $r->id; 	// Nosso Numero S/ DAC (É por meio deste numero que você idenficará o boleto pago)
	$entra["valor"] 				= number_format($r->valor_cadastro,2,',',''); 		// Valor do Boleto (Utilizar virgula como separador decimal, não use pontos)
	//=============Dados do Titular da Conta===============
	$entra["cpf_cnpj_cedente"] 	= $cliente->cnpj;
	$entra["endereco"] 			= $cliente->endereco;
	$entra["cidade"] 			= "$cliente->cidade - $cliente->estado";
	$entra["cedente"] 			= $cliente->nome_fantasia;
	
	//===Dados do seu Cliente (Opcional)===============
		$entra["sacado"]				= $r->responsavel;
		$entra["cnpj_cpf"]				= $r->cnpj_cpf;
		$entra["endereco1"] 			= "$r->endereco $r->bairro";
		$entra["endereco2"] 			= "$r->cidade - $r->estado - CEP:$r->cep";
	
	//==Os Campos Abaixo são Opcionais=================
	$entra["instrucoes"] 				= $instrucoes; //Instruçoes para o Cliente
	$entra["instrucoes1"] 				= @nl2br($vkt_cliente_boleto->instrucao_boleto); // Por exemplo "Não receber apos o vencimento" ou "Cobrar Multa de 1% ao mês"Após o Vencimento Cobrar Multa de 2% e Juros de R$0,02 ao Dia
	$entra["instrucoes2"] 				= "";
	$entra["instrucoes3"] 				= "";
	$entra["instrucoes4"] 				= "";
	$entra["instrucoes5"] 				= "";
	$entra["data_processamento"]		= date("d/m/Y");
	$entra["quantidade"]				= "";
	$entra["valor_unitario"] 			= "";
	
	//==Dados com valores padrões ===================
	$entra["aceite"]					= "N";			
	$entra["uso_banco"] 				= ""; 	
	$entra["especie"] 					= "R$"; 
	$entra["especie_doc"] 				= "DS";
	//======================================
	$entra["agencia_codigo"] 			= $entra["agencia"].'/'.$entra["conta"].'-'.$entra["digito_conta"];
	//echo "<pre>";print_r($entra);echo "</pre>";
	}
	
	 $xyz++;
	//echo "<div style=\"height:30px;width:100%\">$xyz</div>";
	
	if($xyz==3){
		echo"<div style=\"page-break-before:always; width:100%; clear:both;\"></div>";
		$xyz=0;
	}
	
	
	?>
    
    <div class="cobranca">
		<div class="canhoto">
			<img src="<?=$imagem?>" height="24" class="lb" />
			<div class="dv2"></div>
	  <div class='ai'>
				<div class="d">
					<div class="d1">
						<b>Parcela</b>
						<?=$boleto_atual?>/<?=$qtd?>
					</div>
					<div class="d2">
						<b>Vencimento</b>
					   <?=$entra["data_vencimento"]?>
					</div>
				</div>
				<div class="d">
					<b>Agência / Cód. Favorecido</b>
				   <?=$entra["agencia_codigo"]?> - <?=$r->boleto_id?>
				</div>
				<div class="d">
					<b>Identificação do Documento</b>
					<?=$entra["nosso_numero"]?>
				</div>
				<div class="d">
					<b>Número do documento</b>
					 <?=$entra["numero_documento"]?>
				</div>
				<div class="d">
					<div class="d1">
						<b>Espécie Moeda</b>
						R$
					</div>
					<div class="d2">
						<b>Quantidade</b>
						 
					</div>
		  </div>
				<div class="d">
					<b>Valor Documento</b>
					 <?=$entra["valor"]?>
				</div>
				<div class="d">
					<b>Desconto / Abatimento</b>
					 
				</div>
				<div class="d">
					<b>Outras Deduções</b>
					 
				</div>
				<div class="d">
					<b>Mora / Multa</b>
					 
				</div>
				<div class="d">
					<b>Outros Acréscimos</b>
					 
				</div>
				<div class="d">
					<b>Valor Cobrado</b>
					 
				</div>CNPJ/CPF: <?=$r->cnpj_cpf?> <?=$entra["sacado"]?></strong><br /><?=$entra["endereco1"]?>      
		  </div>
			<img src="../../../boletos/i/at.png"  class="at" />
			 <div class="dv2"></div>
				<b>Comprovante de Pagamento</b>
		   
		</div>
	  <div class="bl">
			<i id="tp">
				<img src="<?=$imagem?>" height="24" />
				<u></u>
			</i>
			<i id="ce">
				<i>
				<b>Favorecido</b>
				<?=$entra["cedente"]?> / <?=$entra["cpf_cnpj_cedente"]?>
				</i>
				<i class="l1">
					<i class="c1">
					<b>Data Emissão</b>
					<?=$entra["data_processamento"]?>
					</i>
					<i class="c2">
					<b>Número do documento</b>
					<?=$entra["numero_documento"]?>
					</i>
					<i class="c3">
					<b>Espécie doc.</b>
					DM
					</i>
					<i class="c4">
					<b>Data do Processamento</b>
					<?=$entra["data_processamento"]?>
					</i>
				</i>
				<i class="l1">
					<i class="c1">
						<b>Uso do banco</b>
						<?=$entra["uso_banco"]?>
					</i>
					<i class="c3">
						<b>Carteira</b>
						<?=$entra["carteira"]?>
					</i>
					<i class="c3">
						<b>Espécie Moeda</b>
						R$
					</i>
					<i class="c3">
						<b>Quantidade</b>
                        1
							
					</i>
						<b>Valor</b>
                         <?=$entra["valor"]?>
					</i>
				<i class="ip">
				<b>Instruções para Pagamento:</b>
				*** VALORES EXPRESSOS EM REAIS ***<br>
				
				Referencia:<?=nl2br($r->nota)?><br>
				<? echo $entra["instrucoes1"]; ?><br> 
	<? echo $entra["instrucoes2"]; ?><br> <? echo $entra["instrucoes3"]; ?><br> <? echo $entra["instrucoes4"]; ?><br> 
	<? echo $entra["instrucoes5"]; ?> 
				</i>
				<i id="sc">
				<b>Devedor / Endereço</b>
					<i class="dc">CNPJ/CPF: <?=$r->cnpj_cpf?> <?=$entra["sacado"]?></strong><br /><?=$entra["endereco1"]?><br /><?=$entra["endereco2"]?>            	</i>
					<b>Sacado / Avalista:</b> 
				</i>
			</i>
			<i id="cd">
				<i>
				<b>Data do Vencimento</b>
				<?=$entra["data_vencimento"]?>
				</i>
				<i>
				<b>Agência / Conta Favorecido</b>
				<?=$entra["agencia_codigo"]?>
				</i>
				<i>
				<b>Identificação do Documento</b>
				<?=$entra["nosso_numero"]?>
				</i>
				<i>
				<b>Valor Documento</b>
				<?=$entra["valor"]?>
				</i>
				<i>
				<b>Desconto / Abatimento</b>
				
				</i>
				<i>
				<b>Outras Deduções</b>
				
				</i>
				<i>
				<b>Mora / Multa</b>
				
				</i>
				<i>
				<b>Outros Acréscimos</b>
				
				</i>
				<i>
				<b>Valor Cobrado</b>
				
				</i>
			</i>
			<i id="ld">
				<b><?=$entra["linha_digitavel"]?></b>
				<?=$codigo_barras?>
			</i>
		</i>
	  </div>
	</div>
	</div>
    
    <?
}

?>


</body>
</html>