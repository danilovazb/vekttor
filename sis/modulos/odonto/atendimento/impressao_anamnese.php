<?php
	include('../../../_config.php');
	$atendimento=mysql_fetch_object(mysql_query("SELECT * FROM odontologo_atendimentos WHERE id='".$_GET['atendimento_id']."'"));
	$cliente_fornecedor=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$atendimento->cliente_fornecedor_id'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2" />
<title>Ficha Clínica Simplificada</title>
<style>
	*{
		font-size:16px;
		font-family:"Times New Roman", Times, serif;
	}
	
	#pagina{
			border:0px solid #000;
			width:19cm;
			height:29cm;
			background:#FFFFFF;
			margin:0px auto;
			box-shadow:0px 0px 0px #333333;
			padding: 25px;
	}
	
	#titulo,#dados_pessoais{
		width:100%;
	}
	
	#titulo{
		
		font-size:17px;
		font-weight:bold;
		text-align:center;
	}
	
	#dados_pessoais{
		margin-top:10px;
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
	#consulta{
		width:100%;
		margin-top:4%;
	}
	#inquerito_saude{
		margin-top:3%;
	}
	#doencas table{
		margin-top:2%;
		border-collapse:collapse;
		width:100%;
		
	}
	
	#doencas table tr td{
		border:#000 solid 1px;
		text-transform:uppercase;
		width:25%;
		
	}
	
	.col1{
		font-style:italic;
		
	}
	.linha{
		border-bottom:solid 1px #000000;
	}
	#linha_alergia{
		width:700px;
	}
</style>
</head>

<body>
<div id="pagina">
	<div id="titulo">
		FICHA CLÍNICA SIMPLIFICADA
       </div>
       <div id="dados_pessoais">
			<div style="float:left;min-width:450px;"><strong>Nome:</strong> <?=$cliente_fornecedor->razao_social?></div> <strong>Nasc.:</strong> <?=substr($cliente_fornecedor->nascimento,8,2)?>/<?=substr($cliente_fornecedor->nascimento,5,2)?>/<?=substr($cliente_fornecedor->nascimento,0,4)?> 
            	<strong>Sexo:</strong> <? if($cliente_fornecedor->sexo=='m'){echo "M";}else{echo 'F';}?>
        	<div style="clear:both"></div>
            <div style="float:left;min-width:350px;"><strong>End. Res.:</strong> <?=$cliente_fornecedor->endereco." ".$cliente_fornecedor->bairro." ".$cliente_fornecedor->cidade."-".$cliente_fornecedor->estado?></div>
            <strong>Fone:</strong> <?=$cliente_fornecedor->telefone1?>
            <div style="clear:both"></div>
        	<div style="float:left;min-width:350px;"><strong>End. Prof.:</strong> <?=$cliente_fornecedor->endereco_comercial?></div> 
            <div style="float:left;min-width:200px;"><strong>Profissao:</strong><?=$cliente_fornecedor->ramo_atividade?></div> 
        	<div style="clear:both"></div>
        	 <div style="float:left;min-width:220px;"><strong>Identidade N&ordm;.:</strong> <?=$cliente_fornecedor->rg?></div> 
             <div style="float:left;min-width:220px;"><strong>Órgao Emissor:</strong><?=$cliente_fornecedor->local_emissao?></div> 
             <strong>CPF:</strong> <?=$cliente_fornecedor->cnpj_cpf?>
       	   
                
       </div>
       
       <div id="consulta">
			<table width="100%">
            	<tr style="font-weight:bold;">
                	<td><div style="float:left;margin-left:20%;">Consulta: </div> <div class="checkbox"></div><div style="float:left"> urg&ecirc;ncia</div></td>
                    <td><div class="checkbox"></div><div style="float:left"> tratamento</div></td>
                    <td><div class="checkbox"></div><div style="float:left"> manuten&ccedil;&atilde;o</div></td>
                </tr>
                
            </table>               
       </div>
       	
       <div id="inquerito_saude">
       			<div style="margin-bottom:2%;text-align:center;text-decoration:underline;font-size:18px;font-style:italic">INQUÉRITO DE SAÚDE</div>	
       			
                <div style="float:left">Está em tratamento médico ?</div> 
                <div class="checkbox" style="margin-left:5px;"><? if($atendimento->anamnese_tratamento_medico=='n'){ echo "X";}?></div><div style="float:left;margin-left:5px;"> n&atilde;o</div>
                <div class="checkbox" style="margin-left:15%;"><? if($atendimento->anamnese_tratamento_medico=='s'){ echo "X";}?></div><div style="float:left"> sim: <?=$atendimento->anamnese_obs_tratamento_medico?></div>
 				<div style="clear:both"></div>
                
                <div style="float:left">Está usando medicaçao ?</div> 
                <div class="checkbox" style="margin-left:31px;"><? if($atendimento->anamnese_medicacao=='n'){ echo "X";}?></div><div style="float:left;margin-left:5px;"> n&atilde;o</div>
                <div class="checkbox" style="margin-left:15%;"><? if($atendimento->anamnese_medicacao=='s'){ echo "X";}?></div><div style="float:left"> sim: <?=$atendimento->anamnese_obs_medicacao?></div>
               <div style="clear:both"></div>
               
               <div style="float:left">Alergia :</div> <div class="checkbox" style="margin-left:31px;"><? if($atendimento->anamnese_alergia=='n'){ echo "X";}?></div>
               <div style="float:left;margin-left:5px;"> n&atilde;o</div>
                <div class="checkbox" style="margin-left:15%;"><? if($atendimento->anamnese_alergia=='s'){ echo "X";}?></div><div style="float:left;min-width:200px;"> sim: 
				<?=$atendimento->anamnese_obs_medicacao?></div>
                <div class="checkbox" style="margin-left:31px;"><? if($atendimento->anamnese_alergia=='ns'){ echo "X";}?></div><div style="float:left;margin-left:5px;"> n&atilde;o sei</div>
                <div style="clear:both"></div>
                <div class="linha" id="linha_alergia"><?=$atendimento->anamnese_obs_alergia?></div>
       </div>
       
       <div style="clear:both"></div>
       
       <div id="doencas">
       		<table>
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
       </div>
       <div style="clear:both"></div>
        <div style="width:100%;">
			<div style="float:left;font-weight:bold;">Voc&ecirc; possui alguma doen&ccedil;a / problema significativo n&atilde;o mencionado? </div>
            <?=$atendimento->anamnese_outra_doenca?>
         </div>
         <div style="width:100%;">
			<div style="float:left;font-weight:bold;">Observaçao Geral: </div>
            <?=$atendimento->anamnese_observacao_geral?>
         </div>
</div>
</body>
</html>
