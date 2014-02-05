<?php
/*=========================================================================================
Desenvolvimento:
Luciano Lima
www.netdinamica.com.br/boleto
Suporte: boleto@netdinamica.com.br

Licença de uso:
A licença deste script é para uso próprio em seu site.
Não é permitida a revenda do mesmo, estando sujeito às penas prevista em lei.
A netdinamica, não se responsabiliza por quaisquer prejuízos causados pelo uso deste script.
Bem como imperícia ou alterações indevidas no código fonte do mesmo.
O mesmo segue os padrões definidos por cada banco, cabendo ao comprador apenas a configuração e instalação do script em seu site, bem como fazer todos os testes, para verificação do correto funcionamento do sistema.
Caso necessite da licença para revenda entre em contato.

Instruções de Instalação do Script
Leia o arquivo Boleto Bancário em PHP ou ASP que acompanha este script, antes de iniciar a instalação.
=============================================================================================*/
//=========Dados Obrigatórios para gerar o Boleto =================

$entra["data_documento"] 		= date("d/m/Y"); 	// Data de emissão do Boleto  formato DD/MM/AAAA
$entra["data_vencimento"] 		= DataUsaToBr($boleto->data_vencimento); 	// Data de Vencimento do Boleto formato DD/MM/AAAA
if(!empty($boleto->doc)){
	$entra["numero_documento"]		= $boleto->doc;	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
}else{
	//$entra["numero_documento"]		= $boleto->num_inicio_boleto+$boleto->movimentacao_id;	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
	//$entra["nosso_numero"]	 		= $boleto->num_inicio_boleto+$boleto->movimentacao_id; 	// Nosso Numero S/ DAC (É por meio deste numero que você idenficará o boleto pago)
	$entra["numero_documento"]		=  $boleto->num_inicio_boleto+$boleto->movimentacao_id;	// Numero do Pedido (ou o mesmo valor do Nosso Numero)

}
$entra["nosso_numero"]	 		= $boleto->movimentacao_id;
$entra["valor"] 				= number_format($boleto->valor_cadastro,2,',',''); 		// Valor do Boleto (Utilizar virgula como separador decimal, não use pontos)


//=============Dados do Titular da Conta===============
$entra["cpf_cnpj_cedente"] 	= $vkt_cliente_boleto->cnpj; 
$entra["endereco"] 			= $vkt_cliente_boleto->endereco;
$entra["cidade"] 			= $vkt_cliente_boleto->cidade." - ".$vkt_cliente->estado;
$entra["cedente"] 			= $vkt_cliente_boleto->nome;

//===Dados do seu Cliente (Opcional)===============
$entra["sacado"]				= $internauta->razao_social;
$entra["endereco1"] 			= "$internauta->endereco $internauta->bairro";
$entra["endereco2"] 			= "$internauta->cidade - $internauta->estado - CEP:$internauta->cep";

//==Os Campos Abaixo são Opcionais=================
$entra["instrucoes"] 				= $instrucoes; //Instruçoes para o Cliente
$entra["instrucoes1"] 				= nl2br($vkt_cliente_boleto->instrucao_boleto); // Por exemplo "Não receber apos o vencimento" ou "Cobrar Multa de 1% ao mês"Após o Vencimento Cobrar Multa de 2% e Juros de R$0,02 ao Dia
$entra["instrucoes2"] 				= "1- Cobrar multa de 2%";
$entra["instrucoes3"] 				= "2- Juros de 033% ao dia";
$entra["instrucoes4"] 				= "3- Protestar após 5 dias após o vencimento";
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
include("funcoes-bradesco.php"); 
//echo "<pre>";print_r($entra);echo "</pre>";
$b = new boleto();		
$b->banco_bradesco($entra);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Boleto de Cobran&ccedil;a Vekttor - Boleto Com Regitro</title>
<style type="text/css">
<!--
body,td,th {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;}
#principal,#barCod{clear:both; display:block;width:670px;margin:10px auto 0px auto; background:#FFFFFF;}
.c1{clear:both;}
p{	display:block; border-bottom:1px solid #000000;padding:2px ; float:left; height:25px;	padding:2px;margin:0px; border-left:1px solid #000000;}
p b,.min{ FONT: 10px "Arial Narrow"; COLOR: #000033;display:block;}
b{font-weight:normal; display:block;}
.c1 b{padding:4px ;float:left;height:38px;line-height: 38px;}
.bb{ border-bottom:2px solid #000000;}
.bl{width:100%;}
#n{ padding:4px 10px 4px 10px; border-left:#000000 2px solid;border-right:#000000 2px solid; font-size:18px;}
#nn{ width:464px; text-align:center; font-size:12px; font-weight:bolder;}
.p1{width:290px;}.p2{width:130px;}.p3{width:40px;}.p4{width:60px;}.p5{width:115px;}.p6{width:270px;}.p7{width:180px;}.p8{width:114px;}.pl{width:657px;}.p10{width:108px;}
#d p { width:180px; text-align:right;}
#d b {text-align:left;}
#barCod img{ height:50px; border:0;}
.pli{width:468px}
-->
</style>
</head>
<body>
<div id='principal'>
<div style="border:1px solid #999999; height:140px; margin-bottom:20px;padding:10px;">
	<img src="../../vekttor/clientes/img/<?=$vkt_cliente_boleto->id;?>.png" style="float:left; margin-right:20px;" /><strong><?=$vkt_cliente_boleto->nome;?></strong><br />
<?=$vkt_cliente_boleto->cnpj;?><br />
<?=$vkt_cliente_boleto->endereco.' '.$vkt_cliente_boleto->bairro;?><br />
<?=strtoupper($vkt_cliente_boleto->cidade." - ".$vkt_cliente_boleto->estado);?>
<br />
<br />
<span class="min" style="margin-left:180px">Instru&ccedil;&otilde;es:<br />
  Imprima e pague pelo HOME BANKING ou em uma ag&ecirc;ncia banc&aacute;ria de sua prefer&ecirc;ncia. Use impresora jato de tinta ou laser em qualidade normal. N&atilde;o use modo econ&ocirc;mico.<br />
</span></div>
<div class='c1'>
<b class="bb"><img src="i/logo-bradesco.jpg" /></b>
<b class="bb" id="n">237-2</b>
<b class="bb" id='nn'><?=$entra["linha_digitavel"]?></b>
</div><div>
<p class="p1"><b>Cliente</b><?=$entra["cedente"]?></p>
<p class="p2"><b>Ag./Cod. do cadente</b><?=$entra["agencia_codigo"]?></p>
<p class="p3"><b>Esp&eacute;cie</b><?=$entra["especie"]?> </p>
<p class="p4"><b>Quantidade</b><?=$entra["quantidade"]?></p>
<p class="p5"><b>Numero</b><?=$entra["nosso_numero"]?></p>

<p class="p6"><b>Numero do Documento</b><?=$entra["numero_documento"]?></p>
<p class="p2"><b>CPF/CNPJ</b><?=$entra["cpf_cnpj_cedente"]?></p>
<p class="p4"><b>Vencimento</b><?=$entra["data_vencimento"]?></p>
<p class="p7" style="text-align:right;"><b style="text-align:left;">Valor do Documento</b><?=$entra["valor"]?></p>

<p class="p8"><b>	(-) Desconto / Abatimentos</b></p>
<p class="p8"><b>(-) Outras dedu&ccedil;&otilde;es</b></p>
<p class="p8"><b>(+) Mora / Multa</b></p>
<p class="p8"><b>(+) Outros acr&eacute;scimos</b></p>
<p class="p7"><b>(=) Valor Cobrado</b></p>
<p class="pl" style="height:auto;"><b>Sacado</b><strong><?=$entra["sacado"]?></strong>
<br />CNPJ: <?=$internauta->cnpj_cpf?><br />
<?=$entra["endereco1"]?><br />
<?=$entra["endereco2"]?>
  <br /><strong>Referente</strong>
  <br />
<?=nl2br($boleto->descricao)?></p>
<b class="min">Instru&ccedil;&otilde;es</b><?=$entra["instrucoes"]?>
<img src="i/cut.gif" />
</div>

<div class='c1' style="margin-top:20px;">
<b class="bb"><img src="i/logo-bradesco.jpg" /></b>
<b class="bb" id="n">237-2</b>
<b class="bb" id='nn'><?=$entra["linha_digitavel"]?></b>
</div>
<div style="float:left; width:473px; height:300px;">
<p class="pli"><b>Local e Pagamento</b> Pag&aacute;vel preferencialmente na Rede Bradesco, ou nas Ag&ecirc;ncias do Banco Postal</p>
<p class="pli"><b>Cedente</b><?=$entra["cedente"]?></p>
<p class="p2"><b>Data Documento</b><?=$entra["data_documento"]?></p>
<p class="p2"><b>Numero do Documento</b><?=$entra["numero_documento"]?></p>
<p class="p3"><b>Esp&eacute;cie</b><?=$entra["especie_doc"]?></p>
<p class="p3"><b>Aceite</b><?=$entra["aceite"]?></p>
<p class="p10"><b>Data do Processamento</b><?=$entra["data_processamento"]?></p>
<p class="p2"><b>Uso do Banco</b><?=$entra["uso_banco"]?></p>
<p class="p3"><b>Carteira</b><?=$entra["carteira"]?></p>
<p class="p3"><b>Esp&eacute;cie</b><?=$entra["especie"]?></p>
<p class="p2"><b>Quantidade</b><?=$entra["quantidade"]?></p>
<p class="p10"><b>Valor</b><?=$entra["valor_unitario"]?></p>
<p class="pli" style="height:145px;"><b>Instru&ccedil;&otilde;es (Texto de responsabilidade do cedente)</b><? echo $entra["instrucoes1"]; ?><br> 
<? echo $entra["instrucoes2"]; ?><br> <? echo $entra["instrucoes3"]; ?><br> <? echo $entra["instrucoes4"]; ?><br> 
<? echo $entra["instrucoes5"]; ?><br></p>
</div>
<div id="d"  style="float:left; width:140px;">
<p><b>Vencimento</b><?=$entra["data_vencimento"]?></p>
<p><b>Ag&ecirc;ncia/C&oacute;digo cedente</b><?=$entra["agencia_codigo"]?></p>
<p><b>Nosso n&uacute;mero</b><?=$entra["nosso_numero"]?></p>
<p><b>(=) Valor documento</b><?=$entra["valor"]?></p>
<p><b>(-) Desconto / Abatimentos</b></p>
<p><b>(-) Outras dedu&ccedil;&otilde;es</b></p>
<p><b>(+) Mora / Multa</b></p>
<p><b>(+) Outros acr&eacute;scimos</b></p>
<p><b>	(=) Valor cobrado</b></p>
</div>
<p class="pl" style="margin:-30px 0px 20px 0px;clear:both;height:auto;"><b>Sacado</b><?=$entra["sacado"]?><br /><?=$entra["endereco1"]?><br /><?=$entra["endereco2"]?></p>
<div id='barCod'><? fbarcode($entra["codigo_barras"]); ?></div><img src="i/cut.gif" />
<img src='http://postWeb.com.br//boleto/confirma.php?boleto_id=<?=$_GET[fatura]?>&impressao=1&email=<?=$_GET[email]?>' height='1'width='1'>

</div>
</body>
</html>