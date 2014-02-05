<?php
include("GExtenso.php");
include("../../../_config.php");	
include("../../../_functions_base.php");

	$empresario_id = $_GET["empresario_id"];
	
	/*: Informações da Empresa :*/
	$sql_empresa = mysql_fetch_object(mysql_query($ty=" SELECT * FROM cliente_fornecedor AS cliente  
	JOIN rh_empresas AS empresa ON empresa.cliente_fornecedor_id = cliente.id
	WHERE empresa.cliente_fornecedor_id = '".$_GET["empresa_id"]."' "));
	
	$nire              = $sql_empresa->nire;
	$nire_filial       = $sql_empresa->nire_filial;
	$codigo_ato1       = $sql_empresa->codigo_ato1;
	$descricao_ato1    = utf8_encode($sql_empresa->descricao_ato1);
	$codigo_evento1    = $sql_empresa->codigo_evento1;
	$descricao_evento1 = utf8_encode($sql_empresa->descricao_evento1);			  
	$codigo_evento2    = $sql_empresa->codigo_evento2;
	$descricao_evento2 = utf8_encode($sql_empresa->descricao_evento2);			  
	$codigo_evento3    = $sql_empresa->codigo_evento3;
	$descricao_evento3 = utf8_encode($sql_empresa->descricao_evento3);
	$razao_social      = utf8_encode($sql_empresa->razao_social);
	$empresa_endereco  = $sql_empresa->endereco;
	$empresa_numero    = $sql_empresa->casa_numero;
	$empesa_complemento = $sql_empresa->complemento;
	$empresa_bairro     = $sql_empresa->bairro;
	$empresa_cep        = $sql_empresa->cep;
	$empresa_municipio  = $sql_empresa->cidade;
	$empresa_estado     = $sql_empresa->estado;
	$empresa_pais       = $sql_empresa->nacionalidade;
	$empresa_email      = $sql_empresa->email;
	$atividade_principal = $sql_empresa->cnae_principal; 
	$cnae_secundaria_1 = $sql_empresa->cnae_secundaria_1;
	$cnae_secundaria_2 = $sql_empresa->cnae_secundaria_2;
	$objetivo_principal = $sql_empresa->objectivo_principal;
	$objetivo_secundaria_1 = $sql_empresa->objectivo_secundaria_1;
	$objetivo_secundaria_2 = $sql_empresa->objectivo_secundaria_2;
	$valor_capital = $sql_empresa->valor_capital;
	list($atividade_ano, $atividade_mes, $atividade_dia) = explode("-",$sql_empresa->dt_inicio_atividades);
	$empresa_cnpj = $sql_empresa->cnpj_cpf;
	
	
	/*: Informações do Empresario :*/
	$empresario = mysql_fetch_object(mysql_query($t=" SELECT * FROM cliente_fornecedor WHERE id = '$empresario_id' "));
		$NomeEmpresario = utf8_encode($empresario->razao_social);
		$Nacionalidade  = utf8_encode($empresario->nacionalidade);
		$EstadoCivil    = $empresario->estado_civil;
		$Sexo           = $empresario->sexo;
		$Nascimento     = $empresario->nascimento;
		$Rg             = $empresario->rg;
		$UF             = $empresario->estado;
		$Cpf            = $empresario->cnpj_cpf;
		$Endereco       = $empresario->endereco;
		$Bairro         = $empresario->bairro; 
		$Cep            = $empresario->cep;
		$Municipio      = $empresario->cidade;
		$localEmissao   = $empresario->local_emissao;
		$Pai            = $empresario->filiacao_pai;
		$Mae            = $empresario->filiacao_mae;
		$CasaNumero     = $empresario->casa_numero;
		$Complemento    = $empresario->complemento;
		
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Documento sem título</title>
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
@font-face
	{font-family:Arial;
	panose-1:2 11 6 4 2 2 2 2 2 4;
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
@page
	{mso-footnote-separator:url(":Requerimento de Empresa\0301rio1_files:header.htm") fs;
	mso-footnote-continuation-separator:url(":Requerimento de Empresa\0301rio1_files:header.htm") fcs;
	mso-endnote-separator:url(":Requerimento de Empresa\0301rio1_files:header.htm") es;
	mso-endnote-continuation-separator:url(":Requerimento de Empresa\0301rio1_files:header.htm") ecs;}
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
	line-height:14px;
	height:40px;
}
.table-sem-linha td{ border:none;}
.table td{border-bottom:none;}
.font-mini{
	font-size:5.0pt
}
.font-mini-small{
	font-size:7.0pt
}
.font-max{
	font-size:11.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New";
}
</style>
</head>

<body>
<div class="page">
  <!-- HEADER -->
  	<div>
    		<div style="float:left; width:400px;">
              <table class="table-sem-linha">
                <tr>
                    <td>
                    <img src="../../../../fontes/img/image002.gif" style="width:38px;" />
                    </td>
                    <td> 
                      <div class="MsoNormal" style='font-size:7.7pt'>Ministério do Desenvolvimento, Indústria e Comércio Exterior</div>
                      <div class="MsoNormal" style='font-size:7.7pt'>Secretaria do Desenvolvimento da Produção</div>
                      <div class="MsoNormal" style='font-size:7.7pt'>Departamento Nacional de Registro do Comércio</div>
                    </td>
                </tr>
              </table>

            </div>
          <table cellpadding="0" cellspacing="0" style="border:none;" width="100%">
          <tr>
        <td width="243" height="32" align=left valign=top style='vertical-align:top; border:none;'><span
        style='position:absolute;left:0pt;z-index:2'>
        <table cellpadding=0 cellspacing=0 width="100%">
         <tr>
          <td style="border:none; width:480px;">
</td>
          <td style="border:none;">
          <div style='padding:0pt 0pt 0pt 0pt;text-align:left; margin-top:17px;' >
          <p class="MsoNormal" align=center style='text-align:center'><b><span
          style='font-size:15.0pt'>REQUERIMENTO DE EMPRESÁRIO<br>
          </span></b><span style='font-size:6.0pt;letter-spacing:-.2pt'>INSTRUÇÕES DE
          PREENCHIMENTO NO VERSO</span><b><span style='font-size:6.0pt'><o:p></o:p></span></b></p>
          </div>
          <![if !mso]></td>
         </tr>
        </table>
        </span></td>
       </tr>
      </table>
   </div>
  <!-- FIM HEADER -->
  <div style="margin-top:15px;"></div>
 <div style="background:silver; padding:18px;">
  <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
  	<tr>
    	<td class="xl144" style="width:397px;">
        <div class="MsoNormal"><span class="font-mini-small">NÚMERO DE IDENTIFICAÇÃO DO REGISTRO DE EMPRESA - NIRE DA SEDE</span></div>
        <div class="font-max xl145" style="text-align:center"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$nire?></span></div>
        </td>
        <td class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">NIRE DA FILIAL (preencher somente se ato referente a filial)</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$nire_filial?></span></div>
        </td>
    </tr>
    <tr>
    	<td class="xl144" colspan="2">
        <div class="MsoNormal"><span class="font-mini-small">NOME DO EMPRESÁRIO (completo sem abreviaturas)</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"; padding-left:3px;' ><?=$NomeEmpresario;?></span></div>
        </td>
    </tr>
    <tr>
    	<td class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">NACIONALIDADE</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Nacionalidade?></span></div>
        </td>
        <td class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">ESTADO CIVIL</span></div>
        <div class="font-max" style="text-align:center"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$EstadoCivil?>(a)</span></div>
        </td>
    </tr>
  </table>
  <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
    <tr>
    	<td style="width:95px;" class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">SEXO</span></div>
        	 <div style="font-size:5.8pt; height:23px;">
        	<table>
            	<tr>
                	<td style="border:none;"> <div style="font-weight:bold; margin-top:-16px;" class="font-max">M</div></td>
                    <td align="center" style="width:14px; height:12px; border:1px solid #666;float:left; ">
					<?
                    if($Sexo=="m"){
                        echo '<div style="font-weight:bold" class="font-max">X</div>';
                    }
                    ?>
                    </td>
                    <td style="border:none;"> <div style="font-weight:bold;margin-top:-16px;" class="font-max">F</div></td>
                    <td align="center" style="width:14px; height:12px; border:1px solid #666;float:left;">
                    <?
                    if($Sexo == "f"){
                     	echo '<div style="font-weight:bold" class="font-max">X</div>';
                    }
                    ?>

                    </td>
                </tr>
            </table> 
         </div>
        </td>
        <td class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">REGIME DE BENS (se casado)</span></div>
        <div><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;</span></div>
        </td>
    </tr>
  </table>
  <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
  	<tr >
    	<td style="width:397px;" class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">FILHO DE (pai)</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Pai?></span></div>
        </td>
        <td class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">(mãe)</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Mae?><!--LOURDES SIMAS NOVO--></span></div>
        </td>
    </tr>
  </table>
  <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
  	<tr>
    	<td class="xl144" style=" width:170px;">
        <div class="MsoNormal"><span class="font-mini-small">NASCIDO EM (data de nascimento)</span></div>
        <div class="font-max xl145"><span style=';font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=dataUsaToBr($Nascimento);?></span></div>
        </td>
        <td class="xl144" style="width:224px;">
        <div class="MsoNormal"><span class="font-mini-small">IDENTIDADE número</span></div>
        <div style="text-align:center" class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Rg?></span></div>
        </td>
        <td class="xl144" style="width:138px;">
        <div class="MsoNormal"><span class="font-mini-small">Órgão emissor</span></div>
        <div style="text-align:center" class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$localEmissao?></span></div> 
        </td>
        <td class="xl144" style="width:80px;text-transform:uppercase;">
        <div class="MsoNormal"><span class="font-mini-small">UF</span></div>
        <div style="text-align:center" class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$UF?></span></div>
        </td>
        <td class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">CPF (número)</span></div>
        <div style="text-align:center" class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Cpf?></span></div>
        </td>
    </tr>
    
    <tr>
    	<td style=" width:100px;" colspan="6">
        <div class="MsoNormal"><span class="font-mini-small"> EMANCIPADO POR (forma de emancipação &#8211; somente no caso de menor)</span></div>
        <div style="text-align:center"><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;</span></div>
        </td>
    </tr>
    </table>
   <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
     <tr>
    	<td class="xl144" style=" width:110px;" colspan="4">
        <div class="MsoNormal"><span class="font-mini-small">DOMICILIADO NA<span
  style="mso-spacerun:yes">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>(LOGRADOURO &#8211; rua, av, etc.)</span></div>
        <div><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Endereco?></span></div>
        </td>   
        <td style="width:180px;" class="xl144">
        <div class="MsoNormal"><span class="font-mini-small"> NÚMERO </span></div>
        <div class="font-max xl145" style="text-align:center"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$CasaNumero?></span></div>
        </td>
     </tr>
  </table>
  
  <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
  	<tr>
    	<td class="xl144" style=" width:110px;">
        <div class="MsoNormal"><span class="font-mini-small">COMPLEMENTO</span></div>
        <div class="font-max xl145" style="text-align:center"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Complemento?></span></div>
        </td>
        <td class="xl144" style="width:199px;">
        <div class="MsoNormal"><span class="font-mini-small">BAIRRO / DISTRITO</span></div>
        <div class="font-max xl145"><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Bairro;?></span></div>
        </td>
        <td class="xl144" style="width:50px;">
        <div class="MsoNormal"><span class="font-mini-small">CEP</span></div>
        <div style="text-align:center;" class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Cep;?></span></div> 
        </td>
        <td class="xl144" style="width:80px;">
        <div class="MsoNormal"><span class="font-mini-small">CÓDIGO DO MUNICÍPIO<br> <b>(Uso da Junta Comercial)</b></span></div>
        <div style="text-align:center"><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;</span></div>
        </td>
    </tr>
    <tr>
    	<td class="xl144" style=" width:110px;" colspan="3">
        <div class="MsoNormal"><span class="font-mini-small">MUNICÍPIO</span></div>
        <div><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$Municipio?></span></div>
        </td>
        <td class="xl144" style="width:80px; text-transform:uppercase;">
        <div class="MsoNormal"><span class="font-mini-small">UF</b></span></div>
        <div style="text-align:center" class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$UF?></span></div>
        </td>
    </tr>
    <tr>
    	<td class="xl144" style=" width:110px;" colspan="4">
        <div class="MsoNormal">  <span style='font-size:11.0pt;letter-spacing:-.1pt'>declara, sob as penas da lei, não estar impedido de exercer atividade empresária, que não possui outro registro de empresário e requer à Junta Comercial do</span><b><span style='font-size:9.0pt'> </span></b>
  <span
  style='mso-bookmark:Texto24'><b><span style='font-size:10.0pt;font-family:
  "Courier New";mso-bidi-font-family:"Courier New"'><span style='mso-no-proof:
  yes'>ESTADO DO AMAZONAS</span><span
  style='mso-bookmark:Texto24'></span></div>
        </td>
    </tr>
    </table>
	
     <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
     <tr>
    	<td style=" width:115px;" class="xl144" >
        <div class="MsoNormal"><span class="font-mini-small">CÓDIGO DO ATO</span></div>
        <div style="text-align:center" class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$codigo_ato1?></span></div>
        </td>   
        <td style="width:278px;" class="xl144">
        <div class="MsoNormal"><span class="font-mini-small"> DESCRIÇÃO DO ATO </span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$descricao_ato1?></span></div>
        </td>
        <td style="width:100px;" class="xl144">
        <div class="MsoNormal" style="text-align:center"><span class="font-mini-small"> CÓDIGO DO EVENTO </span></div>
        <div style="text-align:center" class="font-max xl145"><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$codigo_evento1?></span></div>
        </td>
        <td style="width:298px;">
        <div class="MsoNormal"><span class="font-mini-small"> DESCRIÇÃO DO EVENTO </span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$descricao_evento1;?></span></div>
        </td>
     </tr>
     
     <tr>
    	<td style=" width:115px;" class="xl144" >
        <div class="MsoNormal"><span class="font-mini-small">CÓDIGO DO EVENTO</span></div>
        <div style="text-align:center"><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$codigo_evento2?></span></div>
        </td>   
        <td style="width:278px;" class="xl144">
        <div class="MsoNormal"><span class="font-mini-small"> DESCRIÇÃO DO EVENTO </span></div>
        <div><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$descricao_evento2?></span></div>
        </td>
        <td style="width:100px;" class="xl144">
        <div class="MsoNormal" style="text-align:center"><span class="font-mini-small"> CÓDIGO DO EVENTO </span></div>
        <div style="text-align:center"><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$codigo_evento3;?></span></div>
        </td>
        <td style="width:298px;" class="xl144">
        <div class="MsoNormal"><span class="font-mini-small"> DESCRIÇÃO DO EVENTO </span></div>
        <div><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$descricao_evento3?></span></div>
        </td>
     </tr>
  	</table>
 
     <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
       <tr>
    	<td style=" width:147px;" colspan="5">
        <div class="MsoNormal"><span class="font-mini-small">NOME EMPRESARIAL</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$razao_social;?></span></div>
        </td>   
     </tr>
     <tr>
    	<td style=" width:147px;" class="xl144" colspan="4">
        <div class="MsoNormal"><span class="font-mini-small">LOGRADOURO (rua, av, etc.)</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empresa_endereco;?></span></div>
        </td>   
        <td class="xl144">
        <div class="MsoNormal"><span class="font-mini-small"> NÚMERO </span></div>
        <div class="font-max xl145" style="text-align:center"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empresa_numero?></span></div>
        </td>
     </tr>
  </table>
  
  <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
  	<tr>
    	<td class="xl144" style=" width:110px;">
        <div class="MsoNormal"><span class="font-mini-small">COMPLEMENTO</span></div>
        <div style="text-align:center" class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empesa_complemento?></span></div>
        </td>
        <td class="xl144" style="width:199px;">
        <div class="MsoNormal"><span class="font-mini-small">BAIRRO / DISTRITO</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empresa_bairro?></span></div>
        </td>
        <td class="xl144" style="width:50px;">
        <div class="MsoNormal"><span class="font-mini-small">CEP</span></div>
        <div class="font-max xl145" style="text-align:center"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empresa_cep?></span></div> 
        </td>
        <td class="xl144" style="width:80px;">
        <div class="MsoNormal"><span class="font-mini-small">CÓDIGO DO MUNICÍPIO<br> <b>(Uso da Junta Comercial)</b></span></div>
        <div style="text-align:center"><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;</span></div>
        </td>
    </tr>
    </table>
    <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
  	<tr>
    	<td class="xl144" style=" width:208px;">
        <div class="MsoNormal"><span class="font-mini-small">MUNICÍPIO</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empresa_municipio?></span></div>
        </td>
        <td class="xl144" style="width:20px;">
        <div class="MsoNormal"><span class="font-mini-small">UF</span></div>
        <div class="font-max xl145" style="text-align:center"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empresa_estado?></span></div>
        </td>
        <td class="xl144" style="width:54px;">
        <div class="MsoNormal"><span class="font-mini-small">PAÍS</span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empresa_pais?></span></div> 
        </td>
        <td class="xl144" style="width:95px;">
        <div class="MsoNormal"><span class="font-mini-small">CORREIO ELETRÔNICO (E-MAIL)</span></div>
        <div style="text-align:center" class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empresa_email?></span></div>
        </td>
    </tr>
    </table>
    
    <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
  	<tr>
    	<td class="xl144" style=" width:190px;">
        <div class="MsoNormal"><span class="font-mini-small">VALOR DO CAPITAL - R$</span></div>
        <div class="font-max xl145" style="text-align:center;" ><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=moedaUsaToBr($valor_capital);?></span></div>
        </td>
        <td class="xl144">
        <div class="MsoNormal"><span class="font-mini-small"> VALOR DO CAPITAL (por extenso) </span></div>
        <div class="font-max xl145"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'>
		<? 
		if(!empty($valor_capital)){
			echo GExtenso::numero($valor_capital); // oitocentos e trinta e dois
		}
		?></span></div>
        </td>
    </tr>
    </table>
    
    <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
  	 <tr style='mso-yfti-irow:23;page-break-inside:avoid;height:22.9pt'>
  	  <td  colspan="2" valign=top style='width:50px;mso-border-left-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
  background:white;padding:0cm 0cm 0cm 0cm;height:22.9pt'>
  <p class="MsoNormal" style='margin-top:1.0pt;margin-right:0cm;margin-left:1.4pt;margin-bottom:.0001pt'><span class="font-mini-small">CÓDIGO DE ATIVIDADE ECONÔMICA <o:p></o:p></span></p>
  <p class="MsoNormal" align=center style='margin-top:1.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:1.4pt;margin-bottom:.0001pt;text-align:center'><span
  class="font-mini-small">(CNAE Fiscal)<o:p></o:p></span></p>
  <p class=MsoNormal style='margin-top:1.0pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:1.4pt;margin-bottom:.0001pt'><span class="font-mini-small">Atividade
  principal</span><span style='font-size:10.0pt'><o:p></o:p></span></p>
  </td>
  <td width=430 colspan="12" rowspan="3" valign=top style='width:430.35pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-left-alt:solid windowtext .5pt; background:white;padding:0cm 0cm 0cm 0cm;height:22.9pt'>
  <p class=MsoNormal style='margin-top:1.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:1.4pt;margin-bottom:.0001pt'>
  <span class="font-mini-small">DESCRIÇÃO DO OBJETO<o:p></o:p></span></p>
  
  <div style="height:48px;"><p class=MsoNormal style='margin-top:2.0pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:1.4pt;margin-bottom:.0001pt'><span>
  <span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"; '> 
 
  <? if(!empty($objetivo_principal)){echo $objetivo_principal;}else{echo "&nbsp;";} ?>
  
  </span></span></p></div>
  <p class=MsoNormal style='margin-top:2.0pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:1.4pt;margin-bottom:.0001pt'><span style='mso-bookmark:Texto45'><span
  style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><o:p>&nbsp;</o:p></span></span></p>
  <p class=MsoNormal style='margin-top:2.0pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:1.4pt;margin-bottom:.0001pt'><span style='mso-bookmark:Texto45'><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><? if(!empty($objetivo_secundaria_1)){ echo $objetivo_secundaria_1; } else { echo "&nbsp;"; } ?> <o:p></o:p></span></span></p>
  <p class=MsoNormal style='margin-top:2.0pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:1.4pt;margin-bottom:.0001pt'><span style='mso-bookmark:Texto45'><span
  style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'> <? if(!empty($objetivo_secundaria_2)){ echo $objetivo_secundaria_2; } else{ echo "&nbsp;";}  ?> <span
  style='mso-bookmark:Texto45'></span><span style='font-size:10.0pt;font-family:
  "Courier New";mso-bidi-font-family:"Courier New"'><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:24;page-break-inside:avoid;height:17.0pt'>
  <td  colspan="2" valign=top style='border-top:none;border-bottom:none;background:white;padding:0cm 0cm 0cm 0cm;height:17.0pt'>
  <p class="MsoNormal" align=center style='margin-top:3.0pt;margin-right:0cm; margin-bottom:0cm;margin-left:1.4pt;margin-bottom:.0001pt;text-align:center'><span
  style='mso-bookmark:Texto59'><span style='font-size:10.0pt;font-family:"Courier New"; mso-bidi-font-family:"Courier New"'><?=$atividade_principal?><span
  style='mso-bookmark:Texto59'></span><span style='font-size:5.0pt;font-family:
  "Courier New";mso-bidi-font-family:"Courier New"'><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:25;page-break-inside:avoid;height:70.9pt'>
  <td  colspan=2 valign=top style='width:79.95pt;
  border-top:none;mso-border-left-alt:solid windowtext .5pt;mso-border-bottom-alt:
  solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;background:
  white;padding:0cm 0cm 0cm 0cm;height:70.9pt'>
  <p class="MsoNormal" style='margin-top:1.0pt;margin-right:0cm;margin-bottom:0cm;margin-left:1.4pt;margin-bottom:.0001pt'><span class="font-mini-small">Atividades secundárias<o:p></o:p></span></p>
  <p class=MsoNormal align=center style='margin-top:3.0pt;margin-right:0cm;
  margin-bottom:0cm;margin-left:1.4pt;margin-bottom:.0001pt;text-align:center'>
  <span ><span style='font-size:10.0pt;font-family:"Courier New";
  mso-bidi-font-family:"Courier New"'><?=$cnae_secundaria_1;?>
  <span style='mso-bookmark:Texto60'></span><span style='font-size:10.0pt;font-family:
  "Courier New";mso-bidi-font-family:"Courier New"'><o:p></o:p></span></p>
  <p class=MsoNormal align=center style='margin-top:1.0pt;margin-right:0cm; margin-bottom:0cm;margin-left:1.4pt;margin-bottom:.0001pt;text-align:center'>
  	<span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$cnae_secundaria_2;?><span
  style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><o:p></o:p></span></p>
  <p class=MsoNormal align=center style='margin-top:1.0pt;margin-right:0cm;
  margin-bottom:0cm;margin-left:1.4pt;margin-bottom:.0001pt;text-align:center'><span
  style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
  style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><o:p></o:p></span></p>
  <p class=MsoNormal align=center style='margin-top:1.0pt;margin-right:0cm;
  margin-bottom:0cm;margin-left:1.4pt;margin-bottom:.0001pt;text-align:center'><span
  style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
  style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'><o:p></o:p></span></p>
  <p class=MsoNormal align=center style='margin-top:1.0pt;margin-right:0cm;
  margin-bottom:0cm;margin-left:1.4pt;margin-bottom:.0001pt;text-align:center'><span
  style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span
  style='font-size:10.0pt'><o:p></o:p></span></p>
  </td>
 </tr>
  </table>
  
  <table class="MsoNormalTable table" style="background:#FFF;border-collapse:collapse;" width="100%">
       <tr>
    	<td style=" width:120px;" class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">DATA DE INÍCIO DAS ATIVIDADES</span></div>
        <div class="font-max xl145" style="text-align:center;"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$atividade_dia."-".$atividade_mes."-".$atividade_ano;?></span></div>
        </td>
        
        <td style=" width:130px;" class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">NÚMERO DE INSCRIÇÃO NO CNPJ</span></div>
        <div class="font-max xl145" style="text-align:center;"><span style='font-family:"Courier New";mso-bidi-font-family:"Courier New"'><?=$empresa_cnpj?></span></div>
        </td>
         <td class="xl144" style=" width:173px;">
        <div class="MsoNormal"><span class="font-mini-small"><span class="font-mini-small">TRANSFERÊNCIA DE SEDE OU DE FILIAL DE OUTRA UF<br>NIRE anterior</span>
        <span style='font-size:10.0pt'><o:p></o:p></span></span></div>
        <div><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;</span></div>
        </td>
         <td style="width:30px;">
        <div class="MsoNormal"><span class="font-mini-small">UF</span></div>
        <div><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;</span></div>
        </td>
         <td style=" width:110px;" class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">USO DA JUNTA COMERCIAL</span></div>
        
        <div>
        <div style='font-size:5.8pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"; text-transform:uppercase; width:70px; float:left; line-height:10px;'>dependente de autoriza&ccedil;&atilde;o governamental</div>
        <div style="font-size:5.8pt; height:24px;">
        	<table>
            	<tr>
                	<td style="width:25px; height:14px; border:1px solid #666;float:left; margin-top:2px;"></td>
                    <td style="border:none;line-height:10px; vertical-align:top; ">1 - SIM <br/>3 - N&Atilde;O</td>
                </tr>
            </table>
         </div>
        </div>
        </td>   
     </tr>
     
     <tr>
    	<td colspan="5">
        <div class="MsoNormal"><span class="font-mini-small">ASSINATURA DA FIRMA PELO EMPRESÁRIO (ou pelo representante/assistente/gerente)</span></div>
        <div><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;</span></div>
        </td>   
     </tr>
  </table>
  
   <table class="MsoNormalTable" style="background:#FFF;border-collapse:collapse;" width="100%">
  	<tr>
    	<td class="xl144" style=" width:190px;">
        <div class="MsoNormal"><span class="font-mini-small">DATA DA ASSINATURA</span></div>
        <div style="text-align:center;"><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>29-01-2010</span></div>
        </td>
        <td class="xl144">
        <div class="MsoNormal"><span class="font-mini-small">ASSINATURA DO EMPRESÁRIO</span></div>
        <div><span style='font-size:10.0pt;font-family:"Courier New";mso-bidi-font-family:"Courier New"'>&nbsp;</span></div>
        </td>
    </tr>
    </table>
    	<div>	<p class="MsoNormal" style='margin-top:1.0pt;text-align:justify'><b>
    <span style='font-size:8.0pt'>PARA USO EXCLUSIVO DA JUNTA COMERCIAL<o:p></o:p></span></b></p>
    	</div>
        <table class="MsoNormalTable" style="background:#FFF;border-collapse:collapse;" width="100%">
        	<tr style='mso-yfti-irow:32;mso-yfti-lastrow:yes;page-break-inside:avoid;
  height:85.25pt;mso-height-rule:exactly'>
  <td width=152 colspan=6 valign=top style='width:151.55pt;border:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:white;padding:0cm 0cm 0cm 0cm;height:85.25pt;mso-height-rule:exactly'>
  <p class=MsoNormal style='margin-top:2.0pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:1.4pt;margin-bottom:.0001pt;text-align:justify'><span
  style='font-size:8.0pt'>DEFERIDO.<o:p></o:p></span></p>
  <p class=MsoNormal style='margin-left:1.4pt;text-align:justify'><span
  style='font-size:8.0pt'>PUBLIQUE-SE E ARQUIVE-SE.<o:p></o:p></span></p>
  <p class=MsoNormal style='text-align:justify'><span style='font-size:7.0pt'><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal style='text-align:justify'><span style='font-size:7.0pt'><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:8.0pt'>_________________________<o:p></o:p></span></p>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:8.0pt'><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:8.0pt'><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal align=center style='margin-top:3.0pt;text-align:center'><span
  style='font-size:7.0pt'><o:p>&nbsp;</o:p></span></p>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:8.0pt'>______/______/______<o:p></o:p></span></p>
  </td>
  <td width=359 colspan=8 valign=top style='width:358.75pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:white;padding:0cm 0cm 0cm 0cm;
  height:85.25pt;mso-height-rule:exactly'>
  <p class=MsoNormal style='margin-top:2.0pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:1.4pt;margin-bottom:.0001pt;text-align:justify'><span
  style='font-size:8.0pt'>AUTENTICAÇÃO<o:p></o:p></span></p>
  </td>

        </table>
 </div>
</div>
</body>
</html>