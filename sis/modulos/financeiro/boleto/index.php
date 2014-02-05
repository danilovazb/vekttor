<?
require'../../../_config.php';
include("../../../_functions_base.php");


$movimentacao_id=$_GET['filtro_movimentacao'];
$boleto=mysql_fetch_object(mysql_query($t="
	SELECT 
		*, fm.id as movimentacao_id, fc.id as conta_id, cf.id as cliente_fornecedor_id, fm.status as status_movimentacao 
	FROM
		financeiro_movimento fm,
		financeiro_contas fc,
		cliente_fornecedor cf
	WHERE
		fm.id='$movimentacao_id' AND
		fm.conta_id = fc.id AND
		fm.internauta_id = cf.id
	"));
$vkt_cliente_boleto=mysql_fetch_object(mysql_query($t="SELECT * FROM clientes_vekttor WHERE id='$boleto->cliente_id' "));
$internauta=mysql_fetch_object(mysql_query($g="SELECT * FROM cliente_fornecedor WHERE id='$boleto->internauta_id'"));

if($boleto->status_movimentacao=='1'){ echo "Esse Boleto Já Foi Pago";exit();}


//$vkt_cliente=mysql_fetch_object(mysql_query("SELECT * FROM clientes WHERE id='$boleto->cliente_id'"));

//print_r($internauta);
//=========Dados Do Cedente ==================
$entra["agencia"]					= $boleto->agencia;  				// Numero da Agência 4 Digitos s/DAC
//$entra["conta"] 					= substr($vkt_cliente_boleto->conta_corrente,0,-1); 	 		// Numero da Conta 7 Digitos s/ DAC

//$entra["conta"] 					=  str_pad(substr($boleto->conta,0,-1), 7, "0", STR_PAD_LEFT);echo $entra["conta"];
$entra["conta"] 					= str_pad($boleto->conta, 7, "0", STR_PAD_LEFT);
$entra["digito_conta"]				= $boleto->conta_digito; 					// Digito da Conta Corrente 1 Digito
$entra["carteira"]					= str_pad($boleto->_carteira,2, "0", STR_PAD_LEFT);;  				// Código da Carteira

if( $boleto->vencido>0){
	$multa = $boleto->valor_cadastro*($vkt_cliente_boleto->multa/100);
	$juros = $boleto->valor_cadastro*pow((1+($vkt_cliente_boleto->juros/100)),$boleto->vencido);
	$instrucoes = "<span style='color:red'>Fatura vencida dia  <strong>$boleto->data_vencimentoF </strong>, Valores Atualizados para (".date("d/m/Y").")</span><br />
Estão Inclusos Multa de R$ ".number_format($multa,2,',','')."<br />
Estão Inclusos Juros de $boleto->vencido Dias R$ ".number_format($juros-$boleto->valor,2,',','')."
";
	$boleto->data_vencimentoF = date("d/m/Y");
	$boleto->valor = $juros+$multa;
}

//se o banco for bradesco
if($boleto->codigo_banco=='237'){
	include "bradesco/index.php";
}
//se o banco for bradesco
if($boleto->codigo_banco=='1'){
	
	include "banco_brasil/index.php";
}

if($boleto->codigo_banco=='409'){
	
	include "itau/boleto_itau.php";
}
if($boleto->codigo_banco=='399'){
	
	include "hsbc/boleto_hsbc.php";
}