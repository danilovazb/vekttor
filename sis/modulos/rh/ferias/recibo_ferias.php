<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	
function mes($mes){
	
	switch($mes){
		case '01': $mes="Janeiro";break;
		case '02': $mes="Fevereiro";break;
		case '03': $mes="Março";break;
		case '04': $mes="Abril";break;
		case '05': $mes="Maio";break;
		case '06': $mes="Junho";break;
		case '07': $mes="Julho";break;
		case '08': $mes="Agosto";break;
		case '09': $mes="Setembro";break;
		case '10': $mes="Outubro";break;
		case '11': $mes="Novembro";break;
		case '12': $mes="Dezembro";break;
		
		
	}
	
	echo $mes;
}

	
	$ferias = mysql_fetch_object(mysql_query("SELECT * FROM rh_ferias WHERE id=".$_GET['id']));
	
	$funcionario = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id=".$ferias->funcionario_id));
	
	$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=".$ferias->empresa_id));
		
	$inicio_periodo_aquisicao = explode("-",$ferias->data_inicio_aquisicao);
	$fim_periodo_aquisicao = explode("-",$ferias->data_fim_aquisicao);	
	$inicio_ferias = explode("-",$ferias->data_inicio);
	$fim_ferias    = explode("-",$ferias->data_fim);
	$total_bruto = $ferias->salario_base+($ferias->salario_base/3);
	$inss = mysql_query($t="SELECT * FROM rh_inss WHERE  valor_minimo <= '$total_bruto' AND valor_maximo >= '$total_bruto'");
	
	if(mysql_num_rows($inss)<=0){
		$inss = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_inss ORDER BY valor_maximo DESC LIMIT 1"));
		//echo $t."<br>";
				
	}else{
		$inss = mysql_fetch_object($inss);
	}	
	//echo $inss->valor_beneficio;
	$desconto_inss = $total_bruto*($inss->valor_beneficio/100);
	$irpf = mysql_query($t="SELECT * FROM rh_irpf WHERE  valor_minimo <= '".($total_bruto-$desconto_inss ). "' AND valor_maximo >= '".($total_bruto-$desconto_inss ). "'");
	
	if(mysql_num_rows($irpf)<=0){
		$irpf = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_irpf WHERE  valor_minimo <= $ferias->salario_base AND valor_maximo =0"));
		//echo $t."<br>";
				
	}else{
		$irpf = mysql_fetch_object($irpf);
	}
	//echo $irpf->id;
	
	$desconto_inss = $total_bruto*($inss->valor_beneficio/100);
	$desconto_irpf = ($total_bruto-$desconto_inss )*($irpf->percentual_aliquota/100)-$irpf->valor_deducao;
	if($desconto_irpf<0){
		$desconto_irpf = 0;
	}
	$salario_liquido = ($ferias->salario_base+($ferias->salario_base/3)) - $desconto_inss - $desconto_irpf;
?>
<html>

<head>
<title>AVISO E RECIBO DE FÉRIAS</title>
<meta http-equiv=Content-Type content="text/html; charset=ISO-8859-1">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="file:///VekttorDesignHD/Users/vekttordesign/Documents/Table_files/filelist.xml">
<style>
<!--table
	{mso-displayed-decimal-separator:"\,";
	mso-displayed-thousand-separator:"\.";}
@page
	{margin:.51in .24in .98in .51in;
	mso-header-margin:.28in;
	mso-footer-margin:.51in;
	mso-horizontal-page-align:center;
	mso-vertical-page-align:center;}
.font8
	{color:#333333;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.font10
	{color:#333333;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.font11
	{color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.font12
	{color:#333333;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.style48
	{mso-number-format:"_\(\0022R$ \0022* \#\,\#\#0\.00_\)\;_\(\0022R$ \0022* \\\(\#\,\#\#0\.00\\\)\;_\(\0022R$ \0022* \0022-\0022??_\)\;_\(\@_\)";
	mso-style-name:Currency;
	mso-style-id:4;}
.style0
	{mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	white-space:nowrap;
	mso-rotate:0;
	mso-background-source:auto;
	mso-pattern:auto;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	border:none;
	mso-protection:locked visible;
	mso-style-name:Normal;
	mso-style-id:0;}
td
	{mso-style-parent:style0;
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial;
	mso-generic-font-family:auto;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border:none;
	mso-background-source:auto;
	mso-pattern:auto;
	mso-protection:locked visible;
	white-space:nowrap;
	mso-rotate:0;}
.xl65
	{mso-style-parent:style0;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt dot-dash-slanted #969696;
	border-left:1.0pt dot-dash-slanted #969696;}
.xl66
	{mso-style-parent:style0;
	color:gray;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt dot-dash-slanted #969696;
	border-bottom:none;
	border-left:none;}
.xl67
	{mso-style-parent:style0;
	color:gray;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt dot-dash-slanted #969696;
	border-bottom:none;
	border-left:none;}
.xl68
	{mso-style-parent:style0;
	color:gray;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt dot-dash-slanted #969696;
	border-left:none;}
.xl69
	{mso-style-parent:style0;
	color:gray;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt dot-dash-slanted #969696;
	border-bottom:1.0pt dot-dash-slanted #969696;
	border-left:none;}
.xl70
	{mso-style-parent:style0;
	color:gray;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl71
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl72
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl73
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:none;
	border-left:none;}
.xl74
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt dot-dash-slanted #969696;}
.xl75
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl76
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl77
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt solid #969696;
	border-bottom:none;
	border-left:none;}
.xl78
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl79
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl80
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl81
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:.5pt solid #969696;
	border-left:none;}
.xl82
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:.5pt solid #969696;
	border-left:.5pt solid #969696;}
.xl83
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:.5pt solid #969696;
	border-left:none;}
.xl84
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:.5pt solid #969696;
	border-bottom:none;
	border-left:none;}
.xl85
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl86
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl87
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt solid #969696;
	border-bottom:none;
	border-left:none;}
.xl88
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl89
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl90
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl91
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl92
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl93
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl94
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border:.5pt solid #969696;}
.xl95
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:.5pt solid #969696;
	border-left:none;}
.xl96
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl97
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:Percent;}
.xl98
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl99
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:.5pt solid #969696;
	border-left:.5pt solid #969696;}
.xl100
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl101
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl102
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl103
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl104
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl105
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl106
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl107
	{mso-style-parent:style0;
	color:#333333;
	font-size:7.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl108
	{mso-style-parent:style0;
	color:#333333;
	font-size:7.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl109
	{mso-style-parent:style0;
	color:#333333;
	font-size:7.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:none;
	border-left:none;}
.xl110
	{mso-style-parent:style0;
	color:#333333;
	font-size:7.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl111
	{mso-style-parent:style0;
	color:#333333;
	font-size:7.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl112
	{mso-style-parent:style0;
	color:#333333;
	font-size:7.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:1.0pt solid #969696;
	border-bottom:none;
	border-left:none;}
.xl113
	{mso-style-parent:style0;
	color:#333333;
	font-size:7.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl114
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"_\(\0022R$ \0022* \#\,\#\#0\.00_\)\;_\(\0022R$ \0022* \\\(\#\,\#\#0\.00\\\)\;_\(\0022R$ \0022* \0022-\0022??_\)\;_\(\@_\)";}
.xl115
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl116
	{mso-style-parent:style48;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"_\(\0022R$ \0022* \#\,\#\#0\.00_\)\;_\(\0022R$ \0022* \\\(\#\,\#\#0\.00\\\)\;_\(\0022R$ \0022* \0022-\0022??_\)\;_\(\@_\)";
	text-align:left;}
.xl117
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt dot-dash-slanted #969696;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt dot-dash-slanted #969696;}
.xl118
	{mso-style-parent:style0;
	color:gray;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:1.0pt dot-dash-slanted #969696;
	border-right:1.0pt dot-dash-slanted #969696;
	border-bottom:none;
	border-left:none;}
.xl119
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl120
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl121
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt dot-dash-slanted #969696;}
.xl122
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"\0022R$ \0022\#\,\#\#0\.00_\)\;\[Red\]\\\(\0022R$ \0022\#\,\#\#0\.00\\\)";
	border-top:.5pt solid #969696;
	border-right:.5pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl123
	{mso-style-parent:style48;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"_\(\0022R$ \0022* \#\,\#\#0\.00_\)\;_\(\0022R$ \0022* \\\(\#\,\#\#0\.00\\\)\;_\(\0022R$ \0022* \0022-\0022??_\)\;_\(\@_\)";
	text-align:left;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:.5pt solid #969696;
	border-left:.5pt solid #969696;}
.xl124
	{mso-style-parent:style48;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"_\(\0022R$ \0022* \#\,\#\#0\.00_\)\;_\(\0022R$ \0022* \\\(\#\,\#\#0\.00\\\)\;_\(\0022R$ \0022* \0022-\0022??_\)\;_\(\@_\)";
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:.5pt solid #969696;
	border-left:.5pt solid #969696;}
.xl125
	{mso-style-parent:style48;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"_\(\0022R$ \0022* \#\,\#\#0\.00_\)\;_\(\0022R$ \0022* \\\(\#\,\#\#0\.00\\\)\;_\(\0022R$ \0022* \0022-\0022??_\)\;_\(\@_\)";
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl126
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl127
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl128
	{mso-style-parent:style0;
	color:gray;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:1.0pt dot-dash-slanted #969696;
	border-bottom:none;
	border-left:none;}
.xl129
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"0\.0%";}
.xl130
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl131
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl132
	{mso-style-parent:style48;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"\0022R$ \0022\#\,\#\#0\.00_\)\;\[Red\]\\\(\0022R$ \0022\#\,\#\#0\.00\\\)";
	text-align:left;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:.5pt solid #969696;
	border-left:.5pt solid #969696;}
.xl133
	{mso-style-parent:style48;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:"\0022R$ \0022\#\,\#\#0\.00_\)\;\[Red\]\\\(\0022R$ \0022\#\,\#\#0\.00\\\)";
	text-align:left;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl134
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl135
	{mso-style-parent:style0;
	text-align:left;}
.xl136
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid #969696;
	border-left:.5pt solid #969696;}
.xl137
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid #969696;
	border-left:none;}
.xl138
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;}
.xl139
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:1.0pt solid #969696;
	border-bottom:none;
	border-left:none;}
.xl140
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.xl141
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;}
.xl142
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;}
.xl143
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:1.0pt solid #969696;
	border-bottom:none;
	border-left:none;}
.xl144
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl145
	{mso-style-parent:style0;
	color:#333333;
	font-size:16.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:1.0pt dot-dash-slanted #969696;
	border-right:none;
	border-bottom:none;
	border-left:none;}
.xl146
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:.5pt solid #969696;}
.xl147
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl148
	{mso-style-parent:style0;
	color:#333333;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:none;
	border-right:.5pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
.xl149
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:.5pt solid #969696;
	border-left:.5pt solid #969696;}
.xl150
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid #969696;
	border-right:1.0pt solid #969696;
	border-bottom:.5pt solid #969696;
	border-left:none;}
.xl151
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt dot-dash-slanted #969696;}
.xl152
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;}
.xl153
	{mso-style-parent:style0;
	color:#333333;
	font-size:9.0pt;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:1.0pt dot-dash-slanted #969696;
	border-bottom:none;
	border-left:none;}
.xl154
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;}
.xl155
	{mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:1.0pt dot-dash-slanted #969696;
	border-bottom:none;
	border-left:none;}
.xl156
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt dot-dash-slanted #969696;}
.xl157
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;}
.xl158
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:none;
	border-right:1.0pt dot-dash-slanted #969696;
	border-bottom:none;
	border-left:none;}
.xl159
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:left;
	border-top:.5pt solid #969696;
	border-right:.5pt solid #969696;
	border-bottom:.5pt solid #969696;
	border-left:none;}
.xl160
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:.5pt solid #969696;
	border-left:.5pt solid #969696;}
.xl161
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:.5pt solid #969696;
	border-left:none;}
.xl162
	{mso-style-parent:style0;
	color:#333333;
	font-size:8.0pt;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	border-top:.5pt solid #969696;
	border-right:.5pt solid #969696;
	border-bottom:.5pt solid #969696;
	border-left:none;}
.xl163
	{mso-style-parent:style0;
	font-weight:700;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid #969696;
	border-bottom:1.0pt solid #969696;
	border-left:none;}
body,td,th {
	font-size: 10pt;
}
.xl711 {mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:.5pt solid #969696;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
.font81 {color:#333333;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.font82 {color:#333333;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.font811 {color:#333333;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;}
.xl751 {mso-style-parent:style0;
	color:#333333;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid #969696;}
-->
</style>
</head>

<body link="#0000D4" vlink="#6711FF">

<table border=0 cellpadding=0 cellspacing=0 width=592 style='border-collapse:
 collapse;table-layout:fixed;width:592pt'>
 <col width=9 style='mso-width-source:userset;mso-width-alt:384;width:9pt'>
 <col width=18 style='mso-width-source:userset;mso-width-alt:768;width:18pt'>
 <col width=36 style='mso-width-source:userset;mso-width-alt:1536;width:36pt'>
 <col width=53 style='width:53pt'>
 <col width=79 style='mso-width-source:userset;mso-width-alt:3370;width:79pt'>
 <col width=43 style='mso-width-source:userset;mso-width-alt:1834;width:43pt'>
 <col width=42 style='mso-width-source:userset;mso-width-alt:1792;width:42pt'>
 <col width=76 style='mso-width-source:userset;mso-width-alt:3242;width:76pt'>
 <col width=33 style='mso-width-source:userset;mso-width-alt:1408;width:33pt'>
 <col width=44 style='mso-width-source:userset;mso-width-alt:1877;width:44pt'>
 <col width=75 style='mso-width-source:userset;mso-width-alt:3200;width:75pt'>
 <col width=30 style='mso-width-source:userset;mso-width-alt:1280;width:30pt'>
 <col width=45 style='mso-width-source:userset;mso-width-alt:1920;width:45pt'>
 <col width=9 style='mso-width-source:userset;mso-width-alt:384;width:9pt'>
 <tr height=18 style='mso-height-source:userset;height:18.0pt'>
  <td height=18 class=xl117 width=9 style='height:18.0pt;width:9pt'>&nbsp;</td>
  <td colspan=12 class=xl145 width=574 style='width:574pt'>AVISO E RECIBO DE
  FÉRIAS</td>
  <td class=xl118 width=9 style='width:9pt'>&nbsp;</td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:12.75pt'>
  <td colspan=14 height=12 class=xl121 style='border-right:1.0pt dot-dash-slanted #969696;
  height:12.75pt'>CAPÍTULO VI - TITULO II DA C.L.T.</td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:10.5pt'>
  <td colspan=14 height=10 class=xl156 style='border-right:1.0pt dot-dash-slanted #969696;
  height:10.5pt'>DEC. LEI Nº 5452 DE 01/05/1943, COM AS ALTERAÇÕES DO DEC. LEI
  Nº 1.535 DE 13/04/1977</td>
 </tr>
 <tr height=6 style='mso-height-source:userset;height:6.0pt'>
  <td height=6 class=xl74 style='height:6.0pt'>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td colspan=14 height=12 class=xl151 style='border-right:1.0pt dot-dash-slanted #969696;
  height:12.0pt'>AVISO PRÉVIO DE FÉRIAS</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td colspan=14 height=12 class=xl156 style='border-right:1.0pt dot-dash-slanted #969696;
  height:12.0pt'>DE ACORDO COM O ART. 135 DA C.L.T., PARTICIPANDO NO MÍNIMO COM
  30 DIAS DE ANTECEDÊNCIA</td>
 </tr>
 <tr height=2 style='mso-height-source:userset;height:2.25pt'>
  <td height=2 class=xl74 style='height:2.25pt'>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:10.5pt'>
  <td colspan=14 height=10 class=xl151 style='border-right:1.0pt dot-dash-slanted #969696;
  height:10.5pt'>NOTIFICAÇÃO</td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:12.75pt'>
  <td height=12 class=xl74 style='height:12.75pt'>&nbsp;</td>
  <td colspan=5 class=xl160 style='border-right:.5pt solid #969696'>NOME
  EMPREGADO</td>
  <td colspan=2 class=xl149 style='border-right:.5pt solid #969696;border-left:
  none'><span style="mso-spacerun:yes">&nbsp;</span>Nº CART. DO TRABALHO</td>
  <td class=xl83><span style="mso-spacerun:yes">&nbsp;</span>SÉRIE</td>
  <td colspan=4 class=xl149 style='border-right:1.0pt solid #969696'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>REGISTRO DO EMPREGADO</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl75>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl75>&nbsp;</td>
  <td class=xl84>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl85>FICHA</td>
  <td class=xl86 style='border-top:none'>LIVRO</td>
  <td class=xl76></td>
  <td class=xl87>FLS.</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td colspan=5 class=xl146 style='border-right:.5pt solid #969696'><?=$funcionario->nome?></td>
  <td colspan=2 class=xl120 style='border-right:.5pt solid #969696;border-left:
  none'><?=$funcionario->carteira_profissional_numero?></td>
  <td class=xl119><?=$funcionario->carteira_profissional_serie?></td>
  <td class=xl120><?=$funcionario->numero_sequencia_empresa?></td>
  <td class=xl88>Nº <?=$funcionario->livro?></td>
  <td class=xl79>&nbsp;</td>
  <td class=xl89>Nº<span style="mso-spacerun:yes">&nbsp;</span> <?=$funcionario->numero_sequencia_empresa?></td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:11.25pt'>
  <td colspan=14 height=11 class=xl151 style='border-right:1.0pt dot-dash-slanted #969696;
  height:11.25pt'>PERÍODO DE AQUISIÇÃO</td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:18.75pt'>
  <td height=18 class=xl121 style='height:18.75pt'>&nbsp;</td>
  <td class=xl126><?=$inicio_periodo_aquisicao[2]?></td>
  <td class=xl115>de</td>
  <td colspan=2 class=xl115><?=mes($inicio_periodo_aquisicao[1])?></td>
  <td class=xl115>de</td>
  <td class=xl115><?=$inicio_periodo_aquisicao[0]?></td>
  <td class=xl115>à</td>
  <td class=xl115><?=$fim_periodo_aquisicao[2]?></td>
  <td class=xl115>de</td>
  <td class=xl115><?=mes($fim_periodo_aquisicao[1])?></td>
  <td class=xl115>de</td>
  <td class=xl127><?=$fim_periodo_aquisicao[0]?></td>
  <td class=xl128>&nbsp;</td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:11.25pt'>
  <td colspan=14 height=11 class=xl151 style='border-right:1.0pt dot-dash-slanted #969696;
  height:11.25pt'><span style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;
  </span>PERÍODO DE GOZO DAS FÉRIAS</td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:18.0pt'>
  <td height=18 class=xl121 style='height:18.0pt'>&nbsp;</td>
  <td class=xl126><?=$inicio_ferias[2]?></td>
  <td class=xl115>de</td>
  <td colspan=2 class=xl115><?=mes($inicio_ferias[1])?></td>
  <td class=xl115>de</td>
  <td class=xl115><?=$inicio_ferias[0]?></td>
  <td class=xl115>à</td>
  <td class=xl115><?=$fim_ferias[2]?></td>
  <td class=xl115>de</td>
  <td class=xl115><?=mes($fim_ferias[1])?></td>
  <td class=xl115>de</td>
  <td class=xl127><?=$inicio_ferias[0]?></td>
  <td class=xl128>&nbsp;</td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:11.25pt'>
  <td colspan=14 height=11 class=xl151 style='border-right:1.0pt dot-dash-slanted #969696;
  height:11.25pt'>BASE PARA CÁLCULO DA REMUNERAÇÃO DAS FÉRIAS</td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:11.25pt'>
  <td height=11 class=xl74 style='height:11.25pt'>&nbsp;</td>
  <td class=xl82 colspan=3 style='mso-ignore:colspan'>FALTA NÃO JUSTF.</td>
  <td class=xl94>SAL. BASE</td>
  <td class=xl82 colspan=6 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>BASE PARA CALCULO: MENSAL-HORÁRIO-TAREFA OU OUTRAS</td>
  <td class=xl81>&nbsp;</td>
  <td class=xl95>&nbsp;</td>
  <td class=xl67>&nbsp;</td>
 </tr>
 <tr height=13 style='height:13.0pt'>
  <td height=13 class=xl74 style='height:13.0pt'>&nbsp;</td>
  <td class=xl90 style='border-top:none'><?=$ferias->faltas?></td>
  <td class=xl91 style='border-top:none'>&nbsp;</td>
  <td class=xl91 style='border-top:none'>&nbsp;</td>
  <td class=xl122 align=right style='border-top:none'>R$ <?=MoedaUsaToBr($ferias->salario_base)?> </td>
  <td class=xl82 style='border-top:none;border-left:none'><span
  style='display:none'>ASE PARA CALCULO: MENSAL-HORÁRIO-TAREFA O</span></td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl80>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=6 style='mso-height-source:userset;height:6.0pt'>
  <td height=6 class=xl74 style='height:6.0pt'>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:12.75pt'>
  <td height=12 class=xl74 style='height:12.75pt'>&nbsp;</td>
  <td class=xl71 colspan=9 style='mso-ignore:colspan'>VALOR DA
  REMUNERAÇÃO........................................................................................................
  <td class=xl132>R$ <?=MoedaUsaToBr($ferias->salario_base)?> </td>
  <td class=xl72>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl75 colspan=9 style='mso-ignore:colspan'>1/3 FÉRIAS REMUNERADAS
  (Art. 7º - Inciso XVII - C.F).................................................................</td>
  
  <td class=xl123 align=right style='border-top:none'> R$ <?=MoedaUsaToBr($ferias->salario_base/3)?> </td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:11.25pt'>
  <td height=11 class=xl74 style='height:11.25pt'>&nbsp;</td>
  <td class=xl75 colspan=9 style='mso-ignore:colspan'>.......................................................................................................................................................</td>
  
  <td class=xl124 align=left style='border-top:none'>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=13 style='mso-height-source:userset;height:13.5pt'>
  <td height=13 class=xl74 style='height:13.5pt'>&nbsp;</td>
  <td class=xl75>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76 align=right style='border-top:none'><span style="mso-spacerun:yes"><strong>TOTAL</strong></span></td>
  <td class=xl133 style='border-top:none'>R$ <?=MoedaUsaToBr($ferias->salario_base+($ferias->salario_base/3))?> </td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:10.5pt'>
  <td height=10 class=xl74 style='height:10.5pt'>&nbsp;</td>
  <td class=xl96 colspan=3 style='mso-ignore:colspan'>DEDUÇÕES</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:12.75pt'>
  <td height=12 class=xl74 style='height:12.75pt'>&nbsp;</td>
  <td class=xl75 colspan=6 style='mso-ignore:colspan'>INSS <font class="font12"><?=MoedaUsaToBr($inss->valor_beneficio)?> %</font><font
  class="font8">.............................................................................</font></td>
  
  <td class=xl123 align=right> R$ <?=MoedaUsaToBr($desconto_inss)?> </td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:11.25pt'>
  <td height=11 class=xl74 style='height:11.25pt'>&nbsp;</td>
  <td class=xl75 colspan=6 style='mso-ignore:colspan'>IMPOSTO DE RENDA NA FONTE
  <font class="font12"><?=MoedaUsaToBr($irpf->percentual_aliquota)?> %</font><font class="font8">................</font><font
  class="font81">..................</font></td>
  <td class=xl124 align=left style='border-top:none'> R$ <?=MoedaUsaToBr($desconto_irpf)?> </td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:11.25pt'>
  <td height=11 class=xl74 style='height:11.25pt'>&nbsp;</td>
  <td class=xl75 colspan=6 style='mso-ignore:colspan'>.................................................................................................</td>
  
  <td class=xl98 style='border-top:none'>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl99 align=left style="font-weight:bold">R$<?=MoedaUsaToBr($desconto_inss+$desconto_irpf)?></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:12.75pt'>
  <td height=12 class=xl74 style='height:12.75pt'>&nbsp;</td>
  <td class=xl75>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76 colspan=2 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span><strong>LÍQUIDO</strong></td>
  <td class=xl125 align=right style='border-top:none'> R$ <?=MoedaUsaToBr($salario_liquido)?> </td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl75>&nbsp;</td>
  <td class=xl76></td>
  <td colspan=10 class=xl138 style='border-right:1.0pt solid #969696'>Pelo<span
  style="mso-spacerun:yes">&nbsp; </span>presente<span
  style="mso-spacerun:yes">&nbsp; </span>comunicamos-lhes<span
  style="mso-spacerun:yes">&nbsp; </span>que,<span
  style="mso-spacerun:yes">&nbsp; </span>de<span
  style="mso-spacerun:yes">&nbsp; </span>acordo<span
  style="mso-spacerun:yes">&nbsp; </span>com<span
  style="mso-spacerun:yes">&nbsp; </span>a<span style="mso-spacerun:yes">&nbsp;
  </span>lei, ser-lhe-ão concedidas férias relativas</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td colspan=9 class=xl140>ao<span style="mso-spacerun:yes">&nbsp;
  </span>período<span style="mso-spacerun:yes">&nbsp;&nbsp; </span>acima<span
  style="mso-spacerun:yes">&nbsp; </span>descrito<span
  style="mso-spacerun:yes">&nbsp; </span>e<span style="mso-spacerun:yes">&nbsp;
  </span>a<span style="mso-spacerun:yes">&nbsp; </span>sua disposição fica<span
  style="mso-spacerun:yes">&nbsp; </span>a<span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp; </span>importância<span
  style="mso-spacerun:yes">&nbsp; </span>Liquída de</td>
  <td class=xl114 align=right> R$ <?=MoedaUsaToBr($salario_liquido)?> </td>
  <td colspan=2 class=xl142 style='border-right:1.0pt solid #969696'>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl130 colspan=7 style='mso-ignore:colspan'>(<?=numero(number_format($salario_liquido,2,',',''),'moeda')?>), <font class="font10">a ser paga
  adiantadamente.</font></td>
  <td class=xl131></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=9 style='mso-height-source:userset;height:9.75pt'>
  <td height=9 class=xl74 style='height:9.75pt'>&nbsp;</td>
  <td class=xl75>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=0 style='display:none'>
  <td class=xl74>&nbsp;</td>
  <td class=xl75>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td colspan=5 class=xl136><span
  style="mso-spacerun:yes">&nbsp;</span><?=$cliente_fornecedor->cidade?> (<?=$cliente_fornecedor->estado?>),<span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl71 style='border-top:none'>&nbsp;</td>
  <td class=xl72 style='border-top:none'>&nbsp;</td>
  <td class=xl101 colspan=2 style='mso-ignore:colspan'>Local e data</td>
  <td class=xl72 style='border-top:none'>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl100 colspan=2 style='mso-ignore:colspan'>CIENTE</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl75>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=6 style='mso-height-source:userset;height:6.75pt'>
  <td height=6 class=xl74 style='height:6.75pt'>&nbsp;</td>
  <td class=xl75 colspan=2 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=13 style='height:13.0pt'>
  <td height=13 class=xl74 style='height:13.0pt'>&nbsp;</td>
  <td class=xl90>&nbsp;</td>
  <td class=xl102 colspan=3 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Assinatura do empregado</td>
  <td class=xl91>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl102 colspan=2 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Assinatura do empregador</td>
  <td class=xl91>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=6 style='mso-height-source:userset;height:6.75pt'>
  <td height=6 class=xl74 style='height:6.75pt'>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=13 style='mso-height-source:userset;height:13.5pt'>
  <td height=13 class=xl74 style='height:13.5pt'>&nbsp;</td>
  <td class=xl71>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl103 colspan=2 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp; </span>RECIBO DE FÉRIAS</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:11.25pt'>
  <td height=11 class=xl74 style='height:11.25pt'>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl105 colspan=5 style='mso-ignore:colspan'>DE ACORDO COM O
  PARÁGRAFO ÚNICO DO ARTIGO 145 DA C.L.T.<span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl80>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=6 style='mso-height-source:userset;height:6.75pt'>
  <td height=6 class=xl74 style='height:6.75pt'>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl106 colspan=3 style='mso-ignore:colspan'>Recebi da firma</td>
  <td colspan=4 class=xl144><?=$cliente_fornecedor->razao_social?></td>
  <td class=xl101>&nbsp;</td>
  <td class=xl101>&nbsp;</td>
  <td class=xl101>&nbsp;</td>
  <td class=xl72>&nbsp;</td>
  <td class=xl73>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl100 colspan=3 style='mso-ignore:colspan'>estabelecida à</td>
  <td colspan=4 class=xl142><?=$cliente_fornecedor->endereco?> - <?=$cliente_fornecedor->bairro?></td>
  <td class=xl93></td>
  <td colspan=2 class=xl138>em <font class="font11"><?=$cliente_fornecedor->cidade."-".$cliente_fornecedor->estado?></font></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl100 colspan=3 style='mso-ignore:colspan'>a importância de<span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
  <td class=xl116 align=right> R$ <?=MoedaUsaToBr($salario_liquido)?> </td>
  <td colspan=7 class=xl142>(<?=numero(number_format($salario_liquido,2,',',''),'moeda')?>)</td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl85 colspan=10 style='mso-ignore:colspan'>que me é paga<span
  style="mso-spacerun:yes">&nbsp; </span>adiantadamente por motivo das minhas
  férias regulamentares, ora concedidas e que vou gozar de acordo com a<span
  style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl100 colspan=8 style='mso-ignore:colspan'>descrição acima, tudo
  conforme o aviso que recebi em tempo, ao qual dei meu
  &quot;ciente&quot;.<span style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl93></td>
  <td class=xl93></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl100>&nbsp;</td>
  <td class=xl93></td>
  <td class=xl93 colspan=8 style='mso-ignore:colspan'>Para clareza e documento,
  firmo o presente recibo, dando a firma plena e geral quitação.</td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:10.5pt'>
  <td height=10 class=xl74 style='height:10.5pt'>&nbsp;</td>
  <td class=xl75>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td colspan=6 class=xl134><?=$cliente_fornecedor->cidade?> (<?=$cliente_fornecedor->estado?>),</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=13 style='height:13.0pt'>
  <td height=13 class=xl74 style='height:13.0pt'>&nbsp;</td>
  <td class=xl90>&nbsp;</td>
  <td class=xl91 colspan=3 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Local e data</td>
  <td class=xl91>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl102 colspan=2 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Assinatura do empregado</td>
  <td class=xl91>&nbsp;</td>
  <td class=xl92>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=6 style='mso-height-source:userset;height:6.75pt'>
  <td height=6 class=xl74 style='height:6.75pt'>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl107 colspan=10 style='mso-ignore:colspan'>Observação: § 1º do
  Art. 135 da C.L.T.- O empregado não poderá entrar em gozo das feriassem que
  apresente ao empregador sua carteira profissional,</td>
  <td class=xl108>&nbsp;</td>
  <td class=xl109>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl110>&nbsp;</td>
  <td class=xl111></td>
  <td class=xl111 colspan=3 style='mso-ignore:colspan'>para que nela seja
  anotada a respectiva concessão.<span style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl111></td>
  <td class=xl111></td>
  <td class=xl111></td>
  <td class=xl111></td>
  <td class=xl111></td>
  <td class=xl111></td>
  <td class=xl112>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl110>&nbsp;</td>
  <td class=xl111></td>
  <td class=xl111 colspan=8 style='mso-ignore:colspan'>O recibo de Férias
  deverá ser quitado pelo empregado pelo menos 2(dois) dias antes do período de
  gozo de férias.<span style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl111></td>
  <td class=xl112>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl110 colspan=7 style='mso-ignore:colspan'>Do direito a férias e da
  sua duração: De acordo com o artigo 130 da C.L.T. a proporção ao direito de
  férias.</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 class=xl74 style='height:12.0pt'>&nbsp;</td>
  <td class=xl75>&nbsp;</td>
  <td class=xl76></td>
  <td class=xl76></td>
  <td class=xl111 colspan=2 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>Até 5 faltas - 30 dias corridos</td>
  <td class=xl111></td>
  <td class=xl76></td>
  <td class=xl111 colspan=3 style='mso-ignore:colspan'>15 a 23 faltas - 18 dias
  corridos</td>
  <td class=xl111></td>
  <td class=xl77>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=13 style='height:13.0pt'>
  <td height=13 class=xl74 style='height:13.0pt'>&nbsp;</td>
  <td class=xl78>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl113 colspan=2 style='mso-ignore:colspan'><span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>6 a 14 faltas - 24 dias<span style="mso-spacerun:yes">&nbsp;</span></td>
  <td class=xl113>&nbsp;</td>
  <td class=xl79>&nbsp;</td>
  <td class=xl113 colspan=3 style='mso-ignore:colspan'>24 a 32 faltas - 12 dias
  corridos.</td>
  <td class=xl113>&nbsp;</td>
  <td class=xl80>&nbsp;</td>
  <td class=xl66>&nbsp;</td>
 </tr>
 <tr height=7 style='mso-height-source:userset;height:7.5pt'>
  <td height=7 class=xl65 style='height:7.5pt'>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl68>&nbsp;</td>
  <td class=xl69>&nbsp;</td>
 </tr>
 <tr height=12 style='page-break-before:always;height:12.0pt'>
  <td height=12 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
 </tr>
 <tr height=12 style='height:12.0pt'>
  <td height=12 style='height:12.0pt'></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
  <td class=xl70></td>
 </tr>
</table>

</body>

</html>
