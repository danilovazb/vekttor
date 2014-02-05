<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
		
	$atendimento_id = $_GET['atendimento_id'];
	$atendimento    = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_atendimentos WHERE id = '$atendimento_id'"));
	//echo $t;
	$cliente        = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = $atendimento->cliente_fornecedor_id"));
	$convenio		= mysql_fetch_object(mysql_query($t="SELECT 
														* 
													  FROM 
														odontologo_convenio oc,
														cliente_fornecedor cf 
													  WHERE 
													  oc.cliente_fornecedor_id = cf.id AND	
													  cf.id = $atendimento->convenio_id"));
													  //echo $t;
	global $vkt_id;
	if($vkt_id==1){
		$logo="../../../../fontes/img/vekttor.png";
	}else{
		$logo="modulos/vekttor/clientes/img/".$vkt_id.".png";
	}
	
	if(!@file($logo)){
		$logo="../../../../fontes/img/vekttor.png";
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Odontólogo - Ficha Cadastral</title>
<style>
	*{ margin:0px ; padding:0px;}
	#pagina{
		margin-top:20px;
		border:0px solid #000;
			width:700px;
			height:29cm;
			background:#FFFFFF;
			margin:0px auto;
			box-shadow:0px 0px 0px #333333;
	}
	#foto{
		margin-right:1%;
		border:solid 1px #000000;
		width:100%;
		height:186px;		
		float:right;
	}
	#cabecalho{
		width:100%;
		height:50px;
		
	}
	.tbl_ficha{
		border-collapse:collapse;
		width:100%;
	}
	.titulos_tabela{
		border: #000 solid 1px;
		background-color:#CCC;
		height:10px;
		font-size:13px;
		font-weight:900;
		text-align:center;
	}
	.cel_tabelas td{
		border: #000 solid 1px;
		text-align:left;
		font-size:12px;
		height:35px;
		font-weight:bold;
	}
	.dados{
		font-size:14px;
		text-transform:uppercase;
		font-weight:normal;
	}
	#doencas{
		
		border-collapse:collapse;
		width:100%;
		
	}
	#doencas tr td{
		border:#000 solid 1px;
		text-transform:uppercase;
		width:25%;
		
	}
	.checkbox{
		margin-top:3px;
		float:left;
		border:#000 solid 2px;
		width:10px;
		height:10px;
		font-size:10px;
		text-align:center;
	}
</style>
</head>

<body>
<div id="pagina">
  <div id="cabecalho">
    	<div style="float:left;width:15%">
    		<img src="<?php echo $logo;?>"/>
            
        </div>
        
  		<div style="float:left">
        <?php echo $empresa[nome]?>
        <div style="clear:both"></div>
        <?php echo $empresa[endereco]." ".$empresa[bairro]." ".$empresa[cidade]." ".$empresa[estado]?>   
        </div>
    </div>
    
    <div style="clear:both"></div>
	
    <table class="tbl_ficha">
    	<tr>
        	<td colspan="4" valign="top" class="titulos_tabela">DADOS DO PACIENTE</td>
        </tr>
        <tr class="cel_tabelas">
        	<td colspan="3" valign="top">Nome <div class='dados'><?=$cliente->razao_social?></div></td>
         	<td width="19%" rowspan="4">
            	<div style="width:200px;height:143px;overflow:hidden;">
                	<img src="../../administrativo/clientes/fotos_clientes/<?=$cliente->id.".".$cliente->extensao?>" width="200"/>
            	</div>
            </td>
        </tr>
        <tr class="cel_tabelas">
        	<td colspan="3" valign="top">E-mail <div class='dados'><?=$cliente->email?></div></td>
       	</tr>
        <tr class="cel_tabelas">
        	<td colspan="3" valign="top" >Data de Nascimento <div class='dados'><?=DataUsaToBr($cliente->nascimento)?></div></td>
       	</tr>
        <tr  class="cel_tabelas">
        	<td colspan="3" valign="top">Convenio <div class='dados'><?=$convenio->razao_social?></div></td>
       	</tr>
        <tr  class="cel_tabelas">
        	<td colspan="4" valign="top">Profissão <div class='dados'><?=$cliente->ramo_atividade?></div></td>
       	</tr>
        <tr valign="top" class="cel_tabelas">
        	<td width="25%">CPF <div class='dados'><?=$cliente->cnpj_cpf?></div></td>
        	<td width="25%">RG <div class='dados'><?=$cliente->rg?></div></td>
        	<td width="31%">Naturalidade<div class='dados'><?=$cliente->naturalidade?></div></td>
        	<td width="19%">Nacionalidade <div class='dados'><?=$cliente->nacionalidade?></div></td>       	
       	</tr>
        <tr valign="top" class="cel_tabelas">
        	<td width="25%">Telefone 1 <div class='dados'><?=$cliente->telefone1?></div></td>
        	<td width="25%">Telefone 2 <div class='dados'><?=$cliente->telefone2?></div></td>
        	<td width="31%">Fax <div class='dados'><?=$cliente->fax?></div></td>
        	<td width="19%">Tel. Comercial <div class='dados'><?=$cliente->telefone_comercial?></div></td>       	
       	</tr>
        <tr valign="top" class="cel_tabelas">
        	<td >CEP <div class='dados'><?=$cliente->cep?></div></td>
        	<td colspan="3">Endereco <div class='dados'><?=$cliente->endereco?></div></td>       	
       	</tr>
        <tr valign="top" class="cel_tabelas">
        	<td colspan="1">Bairro <div class='dados'><?=$cliente->bairro?></div></td>
        	<td colspan="1">Cidade <div class='dados'><?=$cliente->cidade?></div></td>
            <td colspan="1">UF <div class='dados'><?=$cliente->estado?></div></td>
            <td colspan="1">Estado Civil <div class='dados'><?=$cliente->estado_civil?></div></td>       	
       	</tr>
    </table>
    <table id="doencas">
    			<tr>
        			<td colspan="4" valign="top" class="titulos_tabela">ANAMNESE</td>
      			</tr>
            	<tr>
                	<td class="col1">Anemia</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_anemia=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_anemia=='n'){ echo "X";}?> </div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"> <? if($atendimento->anamnese_anemia=='ns'){ echo "X";}?> </div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">Hepatite</td>
                    <td><div class="checkbox"><? if(empty($atendimento->anamnese_hepatite)||$atendimento->anamnese_hepatite=='s'){ echo "X";} ?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_hepatite=='n'){ echo "X";} ?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_hepatite=='ns'){ echo "X";} ?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">Sífilis</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_sifilis=='s'){ echo "X";} ?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_sifilis=='n'){ echo "X";} ?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_sifilis=='ns'){ echo "X";} ?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">hiv</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_hiv=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_hiv=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_hiv=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">tuberculose</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tuberculose=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tuberculose=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tuberculose=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">asma</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_asma=='s'){ echo "X";} ?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_asma=='n'){ echo "X";} ?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_asma=='ns'){ echo "X";} ?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">fumante</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_fumante=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_fumante=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_fumante=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">hormônios</td>
                    <td><div class="checkbox"> <? if($atendimento->anamnese_hormonio=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"> <? if($atendimento->anamnese_hormonio=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"> <? if($atendimento->anamnese_hormonio=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">alcolista</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_alcolista=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_alcolista=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_alcolista=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">tatuagens</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tatuagem=='s'){ echo "X";} ?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tatuagem=='n'){ echo "X";} ?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tatuagem=='ns'){ echo "X";} ?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">herpes/aftas</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_herpes=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_herpes=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_herpes=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">gravidez</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_gravidez=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_gravidez=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_gravidez=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">desmaios</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_desmaio=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_desmaio=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_desmaio=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1" style="font-weight:bold;">febre reumática</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_febre_reumatica=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_febre_reumatica=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_febre_reumatica=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1" >Diabetes</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_diabetes=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_diabetes=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_diabetes=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">Epilepsia</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_epilepsia=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_epilepsia=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_epilepsia=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">Cicatriza&ccedil;&atilde;o Ruim</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_febre_reumatica=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_febre_reumatica=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_febre_reumatica=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">disturbios psico</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_disturbios_psico=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_disturbios_psico=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_disturbios_psico=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">endocardite bact.</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_endocardite_bact=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_endocardite_bact=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_endocardite_bact=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">problema hepático</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_problema_hepatico=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_problema_hepatico=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_problema_hepatico=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">problema renal</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_problema_renal=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_problema_renal=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_problema_renal=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">problema cardíaco</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_problema_cardiaco=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_problema_cardiaco=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_problema_cardiaco=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">tensao arterial</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tensao_arterial=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tensao_arterial=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tensao_arterial=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">cirurgia</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_cirurgia=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_cirurgia=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_cirurgia=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">tumor</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tumor=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tumor=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_tumor=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">Internaç&atilde;o Hospital</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_internacao_hospital=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_internacao_hospital=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_internacao_hospital=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
                <tr>
                	<td class="col1">Febre Reum&aacute;tica</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_febre_reumatica2=='s'){ echo "X";}?></div><div style="float:left"> SIM</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_febre_reumatica2=='n'){ echo "X";}?></div><div style="float:left"> N&Atilde;O</td>
                    <td><div class="checkbox"><? if($atendimento->anamnese_febre_reumatica2=='ns'){ echo "X";}?></div><div style="float:left"> N&Atilde;O SEI</td>
				</tr>
            </table>
            <div style="clear:both"></div>
        <div style="width:100%;">
			<div style="float:left;font-weight:bold;">Voc&ecirc; possui alguma doen&ccedil;a / problema significativo n&atilde;o mencionado? </div>
            <?=$atendimento->anamnese_outra_doenca?>
         </div>
         <div style="width:100%;">
			<div style="float:left;font-weight:bold;">Observaçao Geral: </div>
            <?=$atendimento->anamnese_observacao_geral?>
         </div>
            <div style="page-break-before: always"></div>
    <!--<table class="tbl_ficha">
   	  <tr>
        	<td colspan="4" valign="top" class="titulos_tabela">ANÁLISE</td>
      </tr>
      <tr>
        	<td style="border:#000 1px solid">Dente</td>
           	<td style="border:#000 1px solid">Face</td>
            <td style="border:#000 1px solid">Procedimento</td>
           	<td style="border:#000 1px solid">Observação</td>
      </tr>
        <?php
			$analise = mysql_query($t="SELECT * FROM odontologo_atendimento_analise WHERE odontologo_atendimento_id=$atendimento_id");
			
			while($procedimento = mysql_fetch_object($analise)){
				
					$descricao_servico = mysql_fetch_object(mysql_query($t="SELECT nome FROM servico WHERE id='$procedimento->servico_id' AND vkt_id='$vkt_id'"));	
					
		?>
	   
       <tr>
        	<td style="border:#000 1px solid"><?php echo $procedimento->dente_id?></td>
           	<td style="border:#000 1px solid"><?php echo $procedimento->face_id?></td>
            <td style="border:#000 1px solid"><?php echo $descricao_servico->nome?></td>
           	<td style="border:#000 1px solid"><?php echo $procedimento->obs?></td>
      </tr>
        <?php
			}
		?>
    </table>-->
 
</div>
</body>
</html>