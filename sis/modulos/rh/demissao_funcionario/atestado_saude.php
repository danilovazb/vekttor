<?php
include("../../../_config.php");
//include("../../../_functions_base.php");
	
	 
	$id = $_GET['id'];
	
	 $empregado = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id=$id"));
	
	 $cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='$empregado->empresa_id'"));
	 //echo $t;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Atestado de Saúde Ocupacional</title>
<style>
.page{
	 height: 842px;
     width: 980px;
     /*height: 842px;
     width: 595px;
	 /*margin-left: auto;
     margin-right: auto;*/
}
<!--
 /* Font Definitions */
.font-normal{
	font-family:"Courier New";
	mso-bidi-font-family:"Courier New";
}
.font-normal div{
	text-align:center;
}
.font-title{
	font-size:13.0pt;
	font-family:"Courier New";
	mso-bidi-font-family:"Courier New";
	font-weight:bold;
}

.font-title div{
	text-align:center;
}
@font-face
	{font-family:"Courier New";
	panose-1:2 7 3 9 2 2 5 2 4 4;
	mso-font-charset:0;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:3 0 0 0 1 0;}
@font-face
	{font-family:"Courier New";
	panose-1:2 7 3 9 2 2 5 2 4 4;
	mso-font-charset:0;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:3 0 0 0 1 0;}
@font-face
	{font-family:Tahoma;
	panose-1:0 0 0 0 0 0 0 0 0 0;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-format:other;
	mso-font-pitch:variable;
	mso-font-signature:3 0 0 0 1 0;}
 /* Style Definitions */
p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:Arial;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:Arial;
	mso-fareast-language:PT-BR;}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-unhide:no;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:center 220.95pt right 441.9pt;
	font-size:10.0pt;
	font-family:Arial;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:Arial;
	color:black;
	mso-fareast-language:PT-BR;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:Tahoma;
	mso-fareast-language:PT-BR;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:10.0pt;
	mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;
	mso-fareast-language:PT-BR;}
 /* Page Definitions */
@page WordSection1
	{size:21.0cm 842.0pt;
	margin:19.85pt 35.45pt 36.85pt 35.45pt;
	mso-header-margin:14.2pt;
	mso-footer-margin:14.2pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
-->
.xl144{
		text-align:left;
	vertical-align:top;	
}
.xl145{
	vertical-align:bottom;
	margin-top:8px;
	text-transform:uppercase;	
}	
td{
	border:1px solid #333;
	line-height:5px;
	height:25px;
	padding-left:4px;
}
.table-sem-linha td{ border:none;}
.table td{border-bottom:none;}
.font-mini{
	font-size:5.0pt
}
.font-mini-small{
	font-size:7.0pt
}
.borda-linha{
	border:1px solid #666;
	position:relative;
	bottom:3px;
	font-size:5.0pt;
}
.title{
	text-align:center; margin-top:13px; margin-bottom:35px;
}
</style>
</head>
<body>

<div class="page">
<table style="border-collapse:collapse;" width="100%">
	<tr>
    	<td class="font-title" colspan="3"> <div>ATESTADO DE SA&Uacute;DE OCUPACIONAL (ASO)</div> </td>
    </tr>
    <tr>
    	<td class="font-title" colspan="3"> Nome: <?=$empregado->nome?></td>
    </tr>
     <tr>
    	<td class="font-title" style="width:450px;"> Cargo Fun&ccedil;&atilde;o: <?=utf8_encode($empregado->cargo)?></td>
        <td class="font-title" style="width:180px;"> RG: <?=$empregado->rg?></td>
        <td class="font-title"> Empresa: <?=$cliente_fornecedor->razao_social?></td>
    </tr>
    <tr>
    	<td colspan="3"> 
        	<div style="clear:both; margin-top:13px;"></div>
        	<div class="font-title title">Natureza do Exame:</div>  
            <div style="width:800px; margin:0 auto; margin-top:15px;" class="font-normal"> 
            	
                <span style="padding-left:50px;"> <span class="borda-linha">&nbsp;&nbsp;</span> Admissional</span> 
                <span style="float:right; padding-right:110px;"> <span class="borda-linha">&nbsp;&nbsp;</span> Demissional</span>
                 
            	<div style="clear:both; margin-top:20px;"></div>
                
                <span style="padding-left:50px;"> <span class="borda-linha">&nbsp;&nbsp;</span> Mudan&ccedil;a de Fun&ccedil;&atilde;o</span>
                
                <div style="clear:both; margin-top:20px;"></div>
                
                <span style="padding-left:50px;"> <span class="borda-linha">&nbsp;&nbsp;</span> Retorno ao Trabalho</span> 
                <span style="float:right; padding-right:130px;"> <span class="borda-linha">&nbsp;&nbsp;</span> Peri&oacute;dico</span>
                <div style="clear:both; margin-top:20px;"></div> 
            </div> 
        </td>
    </tr>
</table>
<!-- * -->
<div style="clear:both; margin-top:27px;"></div>
<table style="border-collapse:collapse;" width="100%">
	<tr>
    	<td  colspan="3"> 
           <div class="font-title title">RISCOS / SETOR / EMPRESA </div>
           <div class="font-normal" style="margin:0 auto; width:920px; margin-bottom:25px; margin-top:13px;">     
                <div style="clear:both; margin-top:20px;"></div>  
        		<div style="float:left; width:180px;" class="font-normal">
                	<span class="borda-linha">&nbsp;&nbsp;</span> F&iacute;sico
                    <div style="clear:both; margin-top:23px;"></div>
                     <div>...........</div>
                     	<div style="clear:both; margin-top:18px;"></div>
                     <div>...........</div>
                </div>
            	<div style="float:left;width:180px;">
                	<span class="borda-linha">&nbsp;&nbsp;</span> Qu&iacute;mico
                    <div style="clear:both; margin-top:23px;"></div>
                	 <div>...........</div>
                     	<div style="clear:both; margin-top:18px;"></div>
                     <div>...........</div>
                </div>
            	<div style="float:left;width:180px;">
                	<span class="borda-linha">&nbsp;&nbsp;</span> Biol&oacute;gico
                    <div style="clear:both; margin-top:23px;"></div>
                	<div>...........</div>
                    	<div style="clear:both; margin-top:18px;"></div>
                    <div>...........</div>
                </div>
                <div style="float:left;width:180px;">
                	<span class="borda-linha">&nbsp;&nbsp;</span> Ergon&ocirc;micos
                    <div style="clear:both; margin-top:23px;"></div>
                    <div>...........</div>
                    	<div style="clear:both; margin-top:18px;"></div>
                    <div>...........</div>
                </div>
                
                <div style="float:left;width:180px;">
                	<span class="borda-linha">&nbsp;&nbsp;</span> Ausentes
                    <div style="clear:both; margin-top:23px;"></div>
                	<div>...........</div>
                    	<div style="clear:both; margin-top:18px;"></div>
                    <div>...........</div>
                </div>
                
                <div style="clear:both; margin-top:20px;"></div>
            </div>
           
        </td>
    </tr>
    <!--<tr>
    	<td class="font-title" colspan="3"> <div>RISCOS / SETOR / EMPRESA </div> </td>
    </tr>-->
</table>

<!-- * -->
<div style="clear:both; margin-top:27px;"></div>
<table style="border-collapse:collapse;" width="100%">
	<tr>
    	<td  colspan="2" class="font-title"> 
           <div>EXAMES COMPLEMENTARES / PROCEDIMENTOS </div>
        </td>
        <td class="font-title" style="width:120px;">
        	<div>DATA</div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:390px;">Vdrl <span class="borda-linha">&nbsp;&nbsp;</span></div>
            <div class="font-normal" style="padding-left:12px;">Hemograma <span class="borda-linha">&nbsp;&nbsp;</span></div>
        </td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px;">Tipo Sangu&iacute;neo</div>
        </td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">Ex. Par. Fezes <span class="borda-linha">&nbsp;&nbsp;</span></div>
            <div class="font-normal" style="padding-left:12px; float:left;width:330px;">P. Baar no Escarro <span class="borda-linha">&nbsp;&nbsp;</span></div>
            <div class="font-normal" style="padding-left:12px;">Urin&aacute;lise <span class="borda-linha">&nbsp;&nbsp;</span></div>
        </td>
        <td></td>
    </tr>
     <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">Teleradiografia de T&oacute;rax <span class="borda-linha">&nbsp;&nbsp;</span></div>
        </td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">Exame Oftalmol&oacute;gico <span class="borda-linha">&nbsp;&nbsp;</span></div>
        </td>
        <td></td>
    </tr>
     <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">E. C. G. <span class="borda-linha">&nbsp;&nbsp;</span></div>
        </td>
        <td></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">Audiometria <span class="borda-linha">&nbsp;&nbsp;</span></div>
        </td>
        <td></td>
    </tr>
     <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">E. E. G. <span class="borda-linha">&nbsp;&nbsp;</span></div>
        </td>
        <td></td>
    </tr>
     <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">Outros</div>
        </td>
        <td></td>
    </tr>
     <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">&nbsp;</div>
        </td>
        <td></td>
    </tr>
     <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">&nbsp;</div>
        </td>
        <td></td>
    </tr> 
     <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">Avalia&ccedil;&atilde;o Cl&iacute;nica <span class="borda-linha">&nbsp;&nbsp;</span></div>
        </td>
        <td></td>
    </tr>
    
    <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">Imuniza&ccedil;&atilde;o</div>
        </td>
        <td></td>
    </tr>
    
    <tr>
    	<td colspan="2">
        	<div class="font-normal" style="padding-left:12px; float:left; width:180px;">Conclus&atilde;o:</div>
            <div class="font-normal" style="padding-left:12px; float:left;width:100px;"> <span class="borda-linha">&nbsp;&nbsp;</span> Apto </div>
            <div class="font-normal" style="padding-left:12px;"> <span class="borda-linha">&nbsp;&nbsp;</span> Inapto Temporariamente </div>
        </td>
        <td></td>
    </tr>
     
    <tr>
    	<td colspan="3"  style=" line-height:20px; border-left:1px solid #666;">
        	<div class="font-normal" style="padding-left:40px;"><span class="borda-linha">&nbsp;&nbsp;</span> 
            Apto com restri&ccedil;&atilde;o para exposi&ccedil;&atilde;o a ru&iacute;dos cujos os n&iacute;veis sejam superiores aos limites de toler&acirc;ncia estabelecidos pelo anexo 1 da NR 15
           </div>
           <div class="font-normal" style="padding-left:40px;">
           <span class="borda-linha">&nbsp;&nbsp;</span> Deve ser encaminhado a Previd&ecirc;ncia Social (NR-7 item 7.4.3.C)
           </div>
        </td>
    </tr>
    
    <tr>
    	<td colspan="3">
        	<div class="font-normal" style="padding-left:12px; float:left; width:330px;">Observa&ccedil;&atilde;o:</div>
        </td>
    </tr>
      
    <tr>
    	<td colspan="3" style="padding:8px;">
        	<div class="font-normal" style="padding-left:12px; float:left; width:430px;">M&eacute;d. Coordenador</div>
            <div class="font-normal" style="padding-left:12px; float:left;width:100px;"> Data </div>
            <div style="clear:both; margin-top:20px;"></div>
            <div class="font-normal" style="padding-left:12px;">M&eacute;d. Encarregado</div>
        </td>
    </tr>
    
    <tr>
    	<td colspan="3" style="padding:8px;" class="font-title">
        	<div >Para uso do Minist&eacute;rio do Trabalho</div>
        </td>
    </tr> 
    
    <tr>
    	<td colspan="3" style="line-height:20px;">
        	<div class="font-normal" style="padding-left:12px; float:left; ">Visto em <br/>Ag. Inspe&ccedil;&atilde;o</div>
            <div class="font-normal" style="padding-left:12px; float:right; padding-right:220px;">  Visto em <br/>Ag. Inspe&ccedil;&atilde;o </div>
        </td>
    </tr>
    
    <tr>
    	<td colspan="3">
        	<div class="font-normal" style="padding-left:12px; float:left; width:430px;">Recebi c&oacute;pia em:</div>
            <div class="font-normal" style="padding-left:12px; float:left;width:100px;"> Ass. </div>
        </td>
    </tr>
          
</table>
<div style="margin-top:50px;"></div>
</div> <!-- DIV FINAL -->

</body>
</html>