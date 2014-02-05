<?
require '../../../../_config.php';
require '../../../../_functions_base.php';
require '../_functions_bradesco.php';
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
	font-size: 7px;
}
</style>
</head>
<body>
<?
if(count($_POST['boleto_id'])>0){
	foreach($_POST['boleto_id'] as $i){
		$boleto=mysql_fetch_object(mysql_query($o="SELECT *, DATE_FORMAT(data_registro,'%d/%m/%Y') as data_emitido,DATE_FORMAT(data_vencimento,'%d/%m/%Y') as data_vencimento  FROM financeiro_movimento WHERE id='".$i."'"));
		$matricula=mysql_fetch_object(mysql_query("SELECT * FROM escolar_matriculas WHERE id='".$boleto->doc."'"));
		$conta=mysql_fetch_object(mysql_query("SELECT fc.* FROM escolar_cursos_unidades_contas as ecu, financeiro_contas as fc 
			WHERE ecu.curso_id='".$matricula->curso_id."' AND ecu.unidade_id='".$matricula->unidade_id."' AND ecu.conta_id=fc.id"));
			$responsavel=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$matricula->responsavel_id."'"));
		
		$boleto_atual++;
//	print_r($boleto);
	


//$vkt_cliente=mysql_fetch_object(mysql_query("SELECT * FROM clientes WHERE id='$boleto->cliente_id'"));

//$internauta=mysql_fetch_object(mysql_query("SELECT * FROM internautas WHERE id='$boleto->internauta_id'"));
//print_r($internauta);
//=========Dados Do Cedente ==================
$entra["agencia"]					= $conta->agencia; 				// Numero da Agência 4 Digitos s/DAC
//$entra["conta"] 					= substr($vkt_cliente_boleto->conta_corrente,0,-1); 	 		// Numero da Conta 7 Digitos s/ DAC

$entra["conta"] 					= $conta->conta;
//$entra["digito_conta"]				= substr($vkt_cliente_boleto->conta_corrente,strlen($vkt_cliente_boleto->conta_corrente)-1,1); 					// Digito da Conta Corrente 1 Digito
$entra["digito_conta"]				= $conta->conta_digito; 					// Digito da Conta Corrente 1 Digito
$entra["carteira"]					= $vkt_cliente_boleto->tipo_boleto;  				// Código da Carteira
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
$entra["data_documento"] 		= $boleto->data_emitido; 	// Data de emissão do Boleto  formato DD/MM/AAAA

$entra["data_vencimento"] 		= $boleto->data_vencimento; 	// Data de Vencimento do Boleto formato DD/MM/AAAA
$entra["numero_documento"]		= $boleto->id;	// Numero do Pedido (ou o mesmo valor do Nosso Numero)
$entra["nosso_numero"]	 		= $boleto->id; 	// Nosso Numero S/ DAC (É por meio deste numero que você idenficará o boleto pago)
$entra["valor"] 				= number_format($boleto->valor_cadastro,2,',',''); 		// Valor do Boleto (Utilizar virgula como separador decimal, não use pontos)


//=============Dados do Titular da Conta===============
$entra["cpf_cnpj_cedente"] 	= $responsavel->cnpj_cpf;
$entra["endereco"] 			= $responsavel->endereco;
$entra["cidade"] 			= $responsavel->cidade." - ".$vkt_cliente->estado;
$entra["cedente"] 			= $responsavel->razao_social;

//===Dados do seu Cliente (Opcional)===============
$entra["sacado"]				= $responsavel->razao_social;
$entra["endereco1"] 			= "$internauta->endereco $internauta->bairro";
$entra["endereco2"] 			= "$internauta->cidade - $internauta->estado - CEP:$internauta->cep";

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
$b = new boleto();		
$b->banco_bradesco($entra);

?>
<div class="cobranca">
    <div class="canhoto">
        <img src="../../i/l" class="lb" />
      <div class="dv2"></div>
  <div class='ai'>
        	<div class="d">
                <div class="d1">
                	<b>Parcela</b>
                    <?=$boleto_atual?>/<?=$numero_de_boletos?>
                </div>
                <div class="d2">
                	<b>Venciemento</b>
                   <?=$entra["data_vencimento"]?>
                </div>
            </div>
        	<div class="d">
            	<b>Agência / Cód. Favorecido</b>
               <?=$entra["agencia_codigo"]?> - <?=$boleto->boleto_id?>
            </div>
        	<div class="d">
            	<b>Identificação do Documento</b>
                <?=$entra["numero_documento"]?>
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
                 
            </div>CNPJ/CPF: <?=$internauta->cnpj?> <?=$entra["sacado"]?></strong><br /><?=$entra["endereco1"]?>      
      </div>
        <img src="../../i/at.png"  class="at" />
         <div class="dv2"></div>
        	<b>Comprovante de Pagamento</b>
       
    </div>
  <div class="bl">
        <i id="tp">
        	<img src="../../i/l" />
            <u>Pagável preferencialmente na Rede Bradesco,
Bradesco Expresso ou nas Agências do Banco Postal</u>
        </i>
        <i id="ce">
        	<i>
            <b>Favorecido</b>
            <?=$entra["cedente"]?>
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
                		
                </i>
                    <b>Valor</b>
        </i>
        	<i class="ip">
            <b>Instruções para Pagamento:</b>
            *** VALORES EXPRESSOS EM REAIS ***<br>
            
            Referencia:<?=nl2br($boleto->descricao)?><br>
            <? echo $entra["instrucoes1"]; ?><br> 
<? echo $entra["instrucoes2"]; ?><br> <? echo $entra["instrucoes3"]; ?><br> <? echo $entra["instrucoes4"]; ?><br> 
<? echo $entra["instrucoes5"]; ?> 
            </i>
        	<i id="sc">
            <b>Devedor / Endereço</b>
            	<i class="dc">CNPJ/CPF: <?=$internauta->cnpj?> <?=$entra["sacado"]?></strong><br /><?=$entra["endereco1"]?><br /><?=$entra["endereco2"]?>            	</i>
                <b>Sacado / Avalista</b>
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
            <?=$entra["numero_documento"]?>
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
            <? fbarcode($entra["codigo_barras"]); ?>
        </i>
    </i>
  </div>
</div>
</div>


<?
 $xyz++;
//echo "<div style=\"height:30px;width:100%\">$xyz</div>";
if($xyz==3){
	echo"<div style=\"page-break-before:always; width:100%; clear:both;\"></div>";
	$xyz=0;
}


		
		
		
		
		
		
		
	}
}
?>


</body>
</html>