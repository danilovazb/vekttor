<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include("_functions.php");
	global $vkt_id;
	$cliente_vekttor = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='$vkt_id'"));
	$caminho_logo = "http://vkt.srv.br/~nv/sis/modulos/vekttor/clientes/img/".$cliente_vekttor->id.".png";
	
	$atendimento_id = $_GET['atendimento_id'];
	$atendimento    = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_atendimentos WHERE id = '$atendimento_id'"));
	//echo $t;
	$cliente        = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = $atendimento->cliente_fornecedor_id"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Impressão Orçamento Odontológico</title>
<style>
	#principal{
		margin-top:40px;
		border:#000 0px solid;		
		width:650px;
		color:#3CB371;
	}
	
	#header{		
		border-collapse: collapse;
		height:70px;
		color:#000;
	}
	
	#logo{
		width:100px;
		float:left;
		height:95%;
		text-align:center;
	}
	
	#info_clinica{
		width:540px;
		float:right;
		padding: 5px 0 0 5px;
	}
	
	#arcada{
		border-radius: 1em;
		width:72.8%;
		height:101%;
		border:#000 1px solid;
				
		float:left;		
	}
	
	#arcada_infantil{
		width:26%;
		height:65%;
		border:#000 1px solid;		
		float:left;		
		border-top-left-radius: 1em;
		border-top-right-radius: 1em;
	}
	
	#radiografias{
		
		width:23%;
		height:35%;
		border:#000 1px solid;
		border-bottom-left-radius: 1em;
		border-bottom-right-radius: 1em;
		float:left;
		padding:0 0 0 3%;		
	}
	
	
	#orcamento{				
		width:100%;
		height:110px;
	}
	
	#validade_orcamento{
		font-weight:900;
		font-size:15px;		
		color:#006400;
		background-color:#3FC;
		border:#000 solid 1px;
		border-right:none;
		border-top-left-radius: 1em;		
		width:24.2%;;
		height:40px;
		float:left;
		
	}
	
	#dias_tratamento{
		width:75%;
		border:#000 solid 1px;
		
		border-top-right-radius: 1em;
		height:40px;
		float:right;
		font-size:10px;
	}
	
	.dia_s{
		margin-top:10px;
		width:50px;
		float:left;
	}
	
	.dia_semana,.check_radiografias{
		float:left;
		border:solid #3CB371 1px;				
	}
	
	.dia_semana{
		width:10px;
		height:10px;
	}
	
	.check_radiografias{
		width:4px;
		height:4px;
		margin-bottom:3px;
		
	}
	
	.info_cli{
		padding:0 15px;		
		height:18px;
		border:solid 1px;
		border-top:none;
	}
	
	#procedimentos{
		margin-top:10px;
		margin-bottom:10px;
	}
	
	#tbl_procedimentos{
		border-collapse: collapse;
		width:100%;
	}
	
	#tbl_procedimentos tr td{
		text-align:center;
		
		border:solid 1px #3CB371;
		text-transform:uppercase;
		font-size:12px;
		font-weight:bold;
		
	}
	
	#footer{
		text-align:center;
		font-size:12px;
		border:solid #000 1px;
		border-radius: 1em;
		margin-top:3px;
		height:185px;
	}
	#f_direita{
		border-right:solid 1px #3CB371;
		text-align:center;
		float:left;
		width:39.8%;
		height:100%;
	}
	#f_esquerda{
		float:right;
		width:59.8%;
		
	}
	.linhas{
		margin-left:auto;
		margin-right:auto;		
		margin-top:18px;
	}
	#arcada,#arcada_infantil,#radiografias,#validade_orcamento,#dias_tratamento,info_cli,#footer{
		border-color:#3CB371;
	}
</style>
</head>

<body>
<div id="principal">
<div id="header">
	<div id="logo">
    	<img src="<?=$caminho_logo?>" />
    </div>
	<div id="info_clinica">
		<?=$cliente_vekttor->nome?>
        <div style="clear:both"></div>
        Fone: <?=$cliente_vekttor->telefone?>
        <div style="clear:both"></div>
        Endereço: <?=$cliente_vekttor->endereco." - ".$cliente_vekttor->bairro." - ".$cliente_vekttor->estado." - ".$cliente_vekttor->estado?>
     </div>
     <div style="clear:both"></div>
</div>	
  <!--<div id="header">
		<div id="arcada"></div>
        <div id="arcada_infantil"></div>
        <div id="radiografias">
        	<div style="text-align:center;margin-top:4%; margin-bottom:4%; font-size:13px;font-weight:900;">RADIOGRAFIAS</div>
        
            <div style="width:45%;border-bottom:#3CB371 solid 1px;border-right:#3CB371 solid 1px;height:20px;float:left;">
            <table width="100%" cellpadding="0" cellspacing="0" style="float:left;">
            	<tr>
                	<?php
						for($i=8;$i>=1;$i--){
							echo "<td style='width:5px;font-size:10px;'><div class='check_radiografias'></div><dvi style='clear:both'></div>$i</td>";
						}
					?>                
                </tr>
                
            </table>
            </div>
            <div style="width:45%;border-bottom:#3CB371 solid 1px;height:20px;float:left;padding:0 0 0 2%;">
            <table width="100%" cellpadding="0" cellspacing="0" style="float:left;">
            	<tr>
                	<?php
						for($i=1;$i<=8;$i++){
							echo "<td style='width:5px;font-size:10px;'><div class='check_radiografias'></div><dvi style='clear:both'></div>$i</td>";
						}
					?>                
                </tr>
                
            </table>       
           </div>
           <div style="width:45%;border-right:#3CB371 solid 1px;height:20px;float:left;padding:2% 0 0 0;">
            <table width="100%" cellpadding="0" cellspacing="0" style="float:left;">
            	<tr>
                	<?php
						for($i=8;$i>=1;$i--){
							echo "<td style='width:5px;font-size:10px;'>$i<div style='clear:both'></div><div class='check_radiografias'></div></td>";
						}
					?>                
                </tr>
                
            </table>
            </div>
            <div style="width:45%;height:20px;float:left;padding:2% 0 0 2%;">
            <table width="100%" cellpadding="0" cellspacing="0" style="float:left;">
            	<tr>
                	<?php
						for($i=1;$i<=8;$i++){
							echo "<td style='width:5px;font-size:10px;'>$i<div style='clear:both'></div><div class='check_radiografias'></div></td>";
						}
					?>                
                </tr>
                
            </table>       
           </div>
        
        </div>
	</div>-->
    
  <div style="clear:both"></div>
    
    <div id="orcamento">
    
		<div id="validade_orcamento">
        	<div style="border-bottom:#000 solid 1px;text-align:center;">ORÇAMENTO</div>
            <div style="font-size:12px;text-align:center;margin-top:10px;">Válido por ______ dias</div>
        </div>
        
        <?php
			$dia_semana = array("Segunda","Terça","Quarta","Quinta","Sexta","Sábado");
		?>
        
        <div id="dias_tratamento">
        	<div style="float:left;height:20px;width:18%;">
            	DIAS DE TRATAMENTO: 
            </div>
            
			<div id="dias" style="float:right;"> 
			<?php
				foreach($dia_semana as $dia){
            		echo "<div class='dia_s'>$dia<div class='dia_semana'></div></div>";
				}
        	?>
            </div>
            
            <div style="clear:both"></div>
            
            <div style="float:left;height:20px;width:18%;margin-top:7px;">
            	HORÁRIO: 
            </div>
		</div>
        
        <div id="informacoes_clientes">
        	<div style="clear:both"></div>
        	<div class="info_cli">Nome: <font color="#000000"><?=$cliente->razao_social?></font></div>
            <div style="clear:both"></div>
            <div class="info_cli">Residência: <font color="#000000"><?="$cliente->endereco - $cliente->cidade/$cliente->estado"?></font></div>
            <div style="clear:both"></div>
            <div class="info_cli" style="border-bottom-left-radius:1em;border-bottom-right-radius:1em;">Indicação: <font color="#000000"><?="$atendimento->indicacao"?></font></div>
        </div>
	
    </div>
    
    <div style="clear:both"></div>
    
    <div id="procedimentos">
		<table id="tbl_procedimentos">
        	<thead>
            	<tr>
                	<td width="55%">TRATAMENTOS A SEREM REALIZADOS</td>
                    <td width="45%" colspan="4">HONORÁRIOS</td>
                </tr>
                <tr>
                	<td></td>
                    <td width="15%">DATA</td>
                    <td>VALOR</td>
                    <td>PGTO.</td>
                    <td>SALDO</td>
                </tr>
            </thead>
            <tbody>
            	<?php
					if($_GET['acao']=='comprovante'){
						$filtro = "aprovado='2'";
					}else{
						$filtro = "aprovado='1'";
					}
					$procedimentos = mysql_query("SELECT * FROM odontologo_atendimento_item WHERE odontologo_atendimento_id=$atendimento_id AND $filtro");
					while($procedimento = mysql_fetch_object($procedimentos)){
						$saldo += ($procedimento->valor);
						
						$descricao_servico = mysql_fetch_object(mysql_query("SELECT nome FROM servico WHERE id='$procedimento->servico_id'AND vkt_id='$vkt_id'"));	
				?>
                <tr style="color:#000;">
                	<td><?=$procedimento->dente_id."(".$face[$procedimento->face_id].")&nbsp;&nbsp; |&nbsp;&nbsp; ".$descricao_servico->nome?></td>
                   <td><?=DataUsaToBr($procedimento->data_cadastro)?></td>
                    <td><?=MoedaUsaToBr($procedimento->valor)?></td>
                    <td></td>
                    <td><?=MoedaUsaToBr($saldo)?>&nbsp;</td>
                    
                </tr>
                <?php
					}
				?>
                <tr>
                	<td style="background-color:#3FC;color:#006400;font-size:10px;">APRESENTE ESTE ORÇAMENTO NA PRÓXIMA CONSULTA</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="color:#000;font-weight:bold;"><?=MoedaUsaToBr($saldo)?>&nbsp;</td>
                </tr>
            </tbody>
        </table>
	</div>
    
    <div style="clear:both"></div>
    
    <div id="footer">
		<div id="f_direita">
        	IMPORTANTE
            
            <div style="clear:both"></div>
            
            <div style="background:#3FC;text-transform:uppercase;color:#006400;height:70px;margin-top:10px;font-family:Arial, Helvetica, sans-serif;font-size:10px;font-weight:900;margin-bottom:10px;padding:5px;text-align:justify;">
            	OS TRATAMENTOS SERÃO INICIADOS 
                MEDIANTE PAGAMENTO DE 50% (OU O QUE
                FOR COMBINADO) E CONCLUÍDOS QUANDO TOTALMENTE
                PAGOS
            </div>
            
            <div style="clear:both"></div>
            
            <div style="margin-bottom:35px;">
            DATA <?=date('d')?>/<?=date('m')?>/<?=date('Y')?>
            </div>
            <div style="width:95%;margin-left:auto;margin-right:auto;border-top:#3CB371 solid 1px;"></div>
            CD
                        
        </div>
        <div id="f_esquerda">
        	PLANO DE PAGAMENTO
            
            <div style="clear:both"></div>
            
            <div style="width:94%;border-top:#3CB371 solid 1px;" class="linhas">
            </div>
            <div style="width:94%;border-top:#3CB371 solid 1px;" class="linhas">
            </div>
            <div style="width:94%;border-top:#3CB371 solid 1px;" class="linhas">
            </div>
            <div style="width:94%;border-top:#3CB371 solid 1px;" class="linhas">
            </div>
            
             <div style="width:85%;border-top:#3CB371 solid 1px;margin-top:8%;margin-left:auto;margin-right:auto;">
            </div>
            <div style="clear:both"></div>
            <div style="width:85%;margin-left:auto;margin-right:auto;margin-bottom:10%;font-size:9px;">
            	(Autorização do paciente ou seu responsável pelos tratamentos a realizar)
            </div>
            
            <div style="clear:both"></div>
            <div style="float:left;width:49%">
            	<div style="float:left;">RG: <?=$cliente->rg?></div>
                
            </div>
            <div style="float:left;width:49%">
               	<div style="float:left;">CPF: <?=$cliente->cnpj_cpf?></div>
                
           </div>
            </div>                      
        </div>
	</div>
</div>
</body>
</html>