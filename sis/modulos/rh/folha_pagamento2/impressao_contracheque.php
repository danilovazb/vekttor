<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include("_functions.php");
	include("_ctrl.php");
	global $vkt_id;
	
	$folha_id = $_GET['folha_id'];
	
	$folha = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_folha	WHERE id='$folha_id'"));
	
	
	/*$ferias = mysql_fetch_object(mysql_query($t="SELECT *, DAY(data_inicio) as dia_inicio, DAY(data_fim) as dia_fim, DATEDIFF(data_fim, data_inicio) as qtd_dias_ferias
FROM `rh_ferias` WHERE  funcionario_id ='330' AND month(data_inicio)='".($folha->mes+1)."' AND YEAR(data_inicio)='$folha->ano'"));
	echo $ferias->id." ".$t."<br>";
	
	$configuracao_folha = mysql_fetch_object(mysql_query($t="
	SELECT 
		* 
	FROM
		cliente_fornecedor cf, 
		rh_empresas rh_e,
		rh_folha_ponto_configuracao rh_fc
	WHERE 
		cf.id=rh_e.cliente_fornecedor_id AND
		rh_fc.empresa_id=rh_e.id AND
		cf.id='$folha->empresa_id' 
		"));*/
	
	//echo $t." ".$configuracao_folha->id." ".mysql_error();
	
	
	/*if($ferias->dia_inicio < $configuracao_folha->dia_abertura){
		$primeiro_dia_mes_ferias = $configuracao_folha->dia_abertura;
		$ultimo_dia_mes_ferias   = date("t");		
	}
	
	if($ferias->dia_fim < $configuracao_folha->dia_fim){
		$ultimo_dia_mes_ferias = $configuracao_folha->dia_abertura;		
	}
	
	
	if($ferias->dia_inicio > $configuracao_folha->dia_abertura){
		$primeiro_dia_mes_ferias = $ferias->dia_inicio;		
	}*/
	
	//echo "<br><br>$primeiro_dia_mes_ferias $ultimo_dia_mes_ferias<br><br>";
	
	//echo "<br>Período Férias:  $configuracao_folha->dia_abertura $ferias->dia_inicio $ferias->dia_fim $ferias->qtd_dias_ferias<br>";
	
	//echo "<br>Período Férias2: $configuracao_folha->dia_abertura $ferias->dia_inicio $ferias->dia_fim $ferias->qtd_dias_ferias";
	
	//$folha_funcionarios = mysql_query("SELECT * FROM rh_folha_funcionarios
	//WHERE id='$rh_folha_id'");
	
	//consulta a empresa
	$cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id = '$folha->empresa_id'"));
	
	if(empty($_GET['funcionario_id'])){
		$funcionarios = mysql_query($t="SELECT *,fl.salario_base as salario_funiconario_fim FROM rh_folha_funcionario fl,rh_funcionario f WHERE fl.folha_id = '$folha_id' AND fl.funcionario_id=f.id ORDER BY f.nome");
		
	}else{
		$funcionario_id = $_GET['funcionario_id'];
		$funcionarios = mysql_query($t="SELECT *,fl.salario_base as salario_funiconario_fim FROM rh_folha_funcionario fl,rh_funcionario f WHERE fl.folha_id = '$folha_id' AND fl.funcionario_id=f.id AND f.id='$funcionario_id' ORDER BY f.nome");
	}
	
	//echo $folha->mes;
	if($folha->mes<=11){
		$mes = $folha->mes+1;
		
		$periodo = "01/".($mes)."/".$folha->ano."    a    ".cal_days_in_month(CAL_GREGORIAN, $mes, $folha->ano)."/".$mes."/".$folha->ano;
	}else if($folha->mes==12){
		$periodo = "Ref.50% 13° Integral";
	}
	if($folha->mes==13){
		$periodo = "Ref.50% 13° 1/2";
	}
	if($folha->mes==14){
		$periodo = "Ref.50% 13° 2/2";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Impressão de Contra cheques</title>

<style>
	#contracheque{		width:760px;		height:530px;		border:solid 1px #000000;margin-top:15px;			/* Para Mozilla/Gecko (Firefox etc) */	}
	.quebra_pagina{		page-break-after:always;	}
	#cabecalho,#descricao_salario table, #salario_liquido, #salario_liquido table, #informacao_funcionario, #descontos_salarios{		width:100%;	}
	#cabecalho{					height:60px;		border-bottom:solid 1px #000000;	padding-left:2px;	}
	#descricao_salario{			height:400px;		border-bottom:solid 1px #000000;	}
	#coluna_tributos{			border-bottom:solid 1px #000000;	text-align:center;	font-size:11px;	}
	#coluna_tributos tr td{		border-left:solid 1px #000000;	}
	#tributos_salario{			border-collapse:collapse;		border-bottom:solid 1px #000000;	}
	#tributos_salario tr td{	border-right:solid 1px #000000;	}
	#salario_liquido{			height:80px;		border-bottom:solid 1px #000000;	}
	#informacao_funcionario{	height:25px;		border-bottom:solid 1px #000000;}
	#descontos_salarios{		height:45px;		border-bottom:solid 1px #000000;	}
	#rodape{		height:62px;	}
	.desconto_fgts{		width:100px;		height:100%;		text-align:center;		float:left;	}
	.campos{		margin-top:0px;		font-size:10px;		margin-bottom:5px;			}
	#rodape{		font-size:11px;	}
	.linha_assinatura{		width:100%;		height:2px;		border-bottom:solid 1px #000000;}
	.ultima_coluna{		width:100px;		border-right:none;}
	body,td,th {	font-family: Arial, Helvetica, sans-serif;	font-size: 11px;}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>

</head>

<body>

<?php
	while($funcionario = mysql_fetch_object($funcionarios)){
		
		$info= array();
		
		$rh_folha_funcionario=mysql_fetch_object(mysql_query("SELECT * FROM `rh_folha_funcionario` WHERE funcionario_id='$funcionario->id' AND folha_id='$folha_id'"));
	
		$info[] = array('',"Salário Base",substr($rh_folha_funcionario->horas_trabalhadas,0,-3),moedaUsaToBr($rh_folha_funcionario->salario_base),"");
		
		
		$fgts = $inss = moedaUsaToBr($rh_folha_funcionario->total_inss);
						
								
		$evento_hora_trabalhada = mysql_fetch_object(mysql_query("SELECT * FROM rh_folha_funcionarios_eventos WHERE nome='Horas Trabalhadas' AND funcionario_id='$funcionario->id' AND folha_id='$folha_id'"));
				
		if($evento_hora_trabalhada->id>0){
			$evento_hora_trabalhada = $evento_hora_trabalhada;
		}else{
			$evento_hora_trabalhada = "220:00";		
		}
		
		$eventos_funcionario = mysql_query($t="SELECT * FROM rh_folha_funcionarios_eventos WHERE folha_id='$folha_id' AND funcionario_id='$funcionario->id' AND nome!='Horas Trabalhadas' AND tributaveis='sim' ORDER BY id ");
						
		$total_vencimentos = $rh_folha_funcionario->salario_base;
		
		$valor_hora =@($rh_folha_funcionario->salario_base/$evento_hora_trabalhada->valor);
				
		while($evento_funcionario = @mysql_fetch_object($eventos_funcionario)){
			
			if($evento_funcionario->valor_real>0){
			
				/*if(sizeof(explode(".",$evento_funcionario->referencia))>1){
					$evento_funcionario->referencia='';
				}*/			
				
				if($evento_funcionario->vencimento_ou_desconto=="vencimento"){
					
					if(sizeof(explode(".",$evento_funcionario->referencia))>1){
						$evento_funcionario->referencia="";
					}
				
					$info[] = array('',"$evento_funcionario->nome",$evento_funcionario->referencia,moedaUsaToBr($evento_funcionario->valor_real),"");
					//$total_vencimentos+=$evento_funcionario->valor_real;	
					
				
				}
				if($evento_funcionario->vencimento_ou_desconto=="desconto"){
					
					if(sizeof(explode(".",$evento_funcionario->referencia))>1){
						$evento_funcionario->referencia="";
					}
				
					$info[] = array('',"$evento_funcionario->nome",$evento_funcionario->referencia,"",moedaUsaToBr($evento_funcionario->valor_real));
					//$total_descontos+=$evento_funcionario->valor_real;
				}
			}
			
		}
		
		/*if($rh_folha_funcionario->valor_insalubridade > 0){
			$info[] = array('',"Insalubridade",$rh_folha_funcionario->porcentagem_insalubridade.'%',moedaUsaToBr($rh_folha_funcionario->valor_insalubridade),"");
		}
		
		
		if($rh_folha_funcionario->valor_adiciona_noturno_salario > 0){
			$info[] = array('',"Adicional Noturno",($funcionario->adicional_noturno*1).'%',moedaUsaToBr($rh_folha_funcionario->valor_adiciona_noturno_salario),"");
		}
		if($rh_folha_funcionario->valor_periculosidade > 0){
			$info[] = array('',"Periculosidade",$rh_folha_funcionario->porcentagem_periculosidade.'%',moedaUsaToBr($rh_folha_funcionario->valor_periculosidade),"");
		}
		
		if($rh_folha_funcionario->horas_extras_valor_50 > 0){
			$info[] = array('',"Hora Extra 50%",substr($rh_folha_funcionario->horas_extras_horas_50,0,5),moedaUsaToBr($rh_folha_funcionario->horas_extras_valor_50),"");
		}
		if($rh_folha_funcionario->horas_extras_valor_100 > 0){
			$info[] = array('',"Hora Extra 100%",substr($rh_folha_funcionario->horas_extras_horas_100,0,5),moedaUsaToBr($rh_folha_funcionario->horas_extras_valor_100) ,"");
		}
		if($rh_folha_funcionario->valor_adicional_noturno > 0){
			$info[] = array('',"Adicional Noturno",substr($rh_folha_funcionario->horas_trabalhadas_noite,0,5),moedaUsaToBr($rh_folha_funcionario->valor_adicional_noturno),"");
		}
		if($rh_folha_funcionario->dsr_hora_extra > 0){
			$info[] = array('',"DSR Hora Extra","",moedaUsaToBr($rh_folha_funcionario->dsr_hora_extra),"");
		}
		if($rh_folha_funcionario->comissao > 0){
			$info[] = array('',"Comissão","",moedaUsaToBr($rh_folha_funcionario->comissao),"");
		}
		if($rh_folha_funcionario->dsr_comissao > 0){
			$info[] = array('',"DSR Comissão","",moedaUsaToBr($rh_folha_funcionario->dsr_comissao),"");
		}
		if($rh_folha_funcionario->gratificacao > 0){
			$info[] = array('',"Gratificação","",moedaUsaToBr($rh_folha_funcionario->gratificacao),"");
		}
		if($rh_folha_funcionario->salario_familia_valor > 0){
			$info[] = array('',"Salário Familia",$rh_folha_funcionario->salario_familia_qtd,moedaUsaToBr($rh_folha_funcionario->salario_familia_valor),"");
		}
		if($rh_folha_funcionario->faltas_valor > 0){
			$info[] = array('',"Faltas",qtdUsaToBr_($rh_folha_funcionario->faltas),"",moedaUsaToBr($rh_folha_funcionario->faltas_valor));
		}
		if($rh_folha_funcionario->deducao_adiantamento > 0){
			$info[] = array('',"Adiantamento","","",moedaUsaToBr($rh_folha_funcionario->deducao_adiantamento));
		
		}
		if($rh_folha_funcionario->deducao_irpf > 0){
			$info[] = array('',"Desconto de IR","$rh_folha_funcionario->porcentagem_irpf%","",moedaUsaToBr($rh_folha_funcionario->deducao_irpf));
		
		}
		if($rh_folha_funcionario->deducao_inss > 0){
			$info[] = array('',"INSS",$rh_folha_funcionario->porcentagem_inss."%","",moedaUsaToBr($rh_folha_funcionario->deducao_inss));
		}
		if($rh_folha_funcionario->porcentagem_valetransporte > 0){
			$info[] = array('',"Vale transporte",$rh_folha_funcionario->porcentagem_valetransporte."%","",moedaUsaToBr($rh_folha_funcionario->porcentagem_valetransporte*$rh_folha_funcionario->salario_base/100));
		}*/
		

		for($x=0;$x<2;$x++){
			$s++;
   
  
//echo $t;
if($ferias->id<1){
?>

	<table border="0" cellpadding="1" cellspacing="0" id="contracheque" <?
    if($s==2){echo 'style="margin-bottom:0"';}
	?> >
    	<tr valign="top">
        	<td style="height:50px;border-bottom:solid 1px #000000;" colspan="5">
			 <strong>
			 <?=$cliente_fornecedor->razao_social?>
			 </strong>
            
             <div style="float:right;font-weight:bold; text-align:right">Demonstrativo de Pagamento de Salário<br />
             <?=$periodo?>
             
             </div>
      
      	     <br />
             <?=$cliente_fornecedor->cnpj_cpf?>
      	     <br />
        <?=$cliente_fornecedor->endereco?>
        
            
            </td>
        </tr>
        <tr style="">
        	<td style="width:100%;height:10px;border-bottom:solid 1px #000000" colspan="6">
             <strong>
             <?=$funcionario->nome?>
             </strong>
            
             <div style="float:right;"><?=$funcionario->cargo?></div>
            </td>
        </tr>
        
        <tr style="text-align:center;font-size:11px;">
        	<td width="35" align="center" style="height:10px;border-right:solid 1px #000000;border-bottom:solid 1px #000000;">Item</td>
        	<td width="430" style="width:300px;height:10px;border-right:solid 1px #000000;border-bottom:solid 1px #000000;">Descrição</td>
            <td width="73" style="height:10px;border-right:solid 1px #000000;border-bottom:solid 1px #000000;">Referência</td>
            <td width="143" style="width:100px;height:10px;border-right:solid 1px #000000;border-bottom:solid 1px #000000;">Vencimentos</td>
            <td width="65" style="height:10px;border-bottom:solid 1px #000000;">Descontos</td>
          
      </tr>
        
<?

for($i=0;$i<count($info);$i++){
?>

		
         <tr valign="top" style="height:10px">
           <td align="center" style="border-right:solid 1px #000000; height:10px"><?=$i+1?></td>
           <td style="border-right:solid 1px #000000; height:10px"><?=$info[$i][1]?></td>
           <td align="right" style="border-right:solid 1px #000000; height:10px"><?=$info[$i][2]?></td>
           <td style="border-right:solid 1px #000000; height:10px" align="right"><? if(strlen($info[$i][3])>0){ ?><span style="float:left">R$</span><? } ?><?=$info[$i][3]?></td>
           <td style="height:10px" align="right"><? if(strlen($info[$i][4])>0){ ?><span style="float:left">R$</span><? } ?><?=$info[$i][4]?></td>
      </tr>
<?
}
if($i<15){
?>
         <tr valign="top" style="">
           <td align="center" style="border-right:solid 1px #000000;  border-bottom:solid 1px #000000">&nbsp;</td>
           <td style="border-right:solid 1px #000000;border-bottom:solid 1px #000000">&nbsp;</td>
           <td style="border-right:solid 1px #000000;border-bottom:solid 1px #000000">&nbsp;</td>
           <td style="border-right:solid 1px #000000;border-bottom:solid 1px #000000" align="right">&nbsp;</td>
           <td style="border-bottom:solid 1px #000000" align="right">&nbsp;</td>
      </tr>
        <tr>
<?
}
?>        	<td colspan="3" rowspan="2" style="height:30px;border-bottom:#000 solid 1px;border-right:solid 1px #000000;">&nbsp;<?=$rh_folha_funcionario->obs?></td>
            <td align="right" style="height:30px;border-right:solid 1px #000000;"><span style="float:left">R$</span><?=MoedaUsaToBr($rh_folha_funcionario->salario_base+$rh_folha_funcionario->total_adicional)?></td>
            <td align="right" style="height:30px;"><span style="float:left">R$</span><?=MoedaUsaToBr($rh_folha_funcionario->total_desconto)?></td>
        </tr>
        <tr>
        	<td style="height:30px;border-top:solid 1px #000000;border-bottom:solid 1px #000000;border-right:solid 1px #000000; font-weight:bold; font-size:12px;">Valor Líquido</td>
            <td align="right" style="height:30px;border-top:solid 1px #000000;border-bottom:solid 1px #000000; "><span style="float:left">R$</span><?php echo MoedaUsaToBr($rh_folha_funcionario->salario_liquido)?></td>
        </tr>
        <tr >
        	<td style="height:35px;border-bottom:#000 1px solid;" colspan="5">
            			<div class="desconto_fgts">
            
            	<div class="campos">
           			Sal&aacute;rio Base
           		</div>
                
                <div style="clear:both"></div>
           		<?=MoedaUsaToBr($funcionario->salario_base)?>
           </div>
           <div class="desconto_fgts">
            
            	<div class="campos">
           			Sal. Contri. INSS
           		</div>
                
                <div style="clear:both"></div>
           		<?=MoedaUsaToBr($funcionario->base_inss)?>
           </div>
           
           <div class="desconto_fgts">
            
            	<div class="campos">
           			&nbsp;	
           		</div>
                
                <div style="clear:both"></div>
                
           		8,00
           </div>
           
            <div class="desconto_fgts">
            
            	<div class="campos">
           			Base Cál. FGTS	
           		</div>
                
                <div style="clear:both"></div>
           		<?=MoedaUsaToBr($rh_folha_funcionario->base_fgts)?>
           </div>
           
           <div class="desconto_fgts">
            
            	<div class="campos">
           			F.G.T.S do mês	
           		</div>
                
                <div style="clear:both"></div>
           		<?=MoedaUsaToBr($rh_folha_funcionario->total_fgts)?>
           </div>
           
           <div class="desconto_fgts">
            
            	<div class="campos">
           			Base Cálc. IRRF	
           		</div>
                
                <div style="clear:both"></div>
           		<?=MoedaUsaToBr($rh_folha_funcionario->base_irrf)?>
           </div>
           
           <div class="desconto_fgts">
            
            	<div class="campos">
           			Faixa IRRF	
           		</div>
                <?=MoedaUsaToBr($rh_folha_funcionario->total_irrf)?>
                <div style="clear:both"></div>
           		
           </div>
            
            </td>
        </tr>
        <tr id="rodape">
        	<td style="height:35px; font-size:9px" colspan="5 ">
            	
                DECLARO TER RECEBIDO A IMPORTÂNCIA LÍQUIDA DISCRIMINADA NESTE RECIBO
           
           
           <div style="clear:both"></div>
           
         	 <div style="float:left;margin-top:25px;width:120px;">
        	            
            <div class="linha_assinatura" style="width:35px;float:left;margin-top:10px;">
    		</div>
        	
            <div style="float:left"> / </div>
            
            <div class="linha_assinatura" style="width:35px;float:left;margin-top:10px;">
    		</div>
        	
            <div style="float:left"> / </div>
            
            <div class="linha_assinatura" style="width:35px;float:left;margin-top:10px;">
    		</div>
            
            <div style="clear:both"></div>
            
            
            
            <div style="text-align:center">
            Data
            </div>
    		</div>
            
            
            <div style="float:right;margin-top:35px;width:500px;">
        	            
            <div class="linha_assinatura">
    		</div>
        	
            <div style="clear:both"></div>
            
            <div style="text-align:center">
            Assinatura do Empregado
            </div>
    		</div>
            
            </td>
        </tr>
    </table>
	<?
        }else{?>
		<table border="0" cellpadding="1" cellspacing="0" id="contracheque" <?
    if($s==2){echo 'style="margin-bottom:0"';}
	?> >
    	<tr valign="top">
        	<td style="height:50px;border-bottom:solid 1px #000000;" colspan="5">
			 <strong>
			 <?=$cliente_fornecedor->razao_social?>
			 </strong>
            
             <div style="float:right;font-weight:bold; text-align:right">Demonstrativo de Pagamento de Salário<br />
             <?=$periodo?>
             
             </div>
      
      	     <br />
             <?=$cliente_fornecedor->cnpj_cpf?>
      	     <br />
        <?=$cliente_fornecedor->endereco?>
        
            
            </td>
        </tr>
        <tr style="">
        	<td style="width:100%;height:10px;border-bottom:solid 1px #000000" colspan="6">
             <strong>
             <?=$funcionario->nome?>
             </strong>
            
             <div style="float:right;"><?=$funcionario->cargo?></div>
            </td>
        </tr>
        
        <tr style="text-align:center;font-size:11px;">
        	<td width="35" align="center" style="height:10px;border-right:solid 1px #000000;border-bottom:solid 1px #000000;">Item</td>
        	<td width="430" style="width:300px;height:10px;border-right:solid 1px #000000;border-bottom:solid 1px #000000;">Descrição</td>
            <td width="73" style="height:10px;border-right:solid 1px #000000;border-bottom:solid 1px #000000;">Referência</td>
            <td width="143" style="width:100px;height:10px;border-right:solid 1px #000000;border-bottom:solid 1px #000000;">Vencimentos</td>
            <td width="65" style="height:10px;border-bottom:solid 1px #000000;">Descontos</td>
          
      </tr>
        
<?

for($i=0;$i<1;$i++){
?>

		
         <tr valign="top" style="height:10px">
           <td align="center" style="border-right:solid 1px #000000; height:10px">1</td>
           <td style="border-right:solid 1px #000000; height:10px">Sal&aacute;rio Fam&iacute;lia</td>
           <td align="right" style="border-right:solid 1px #000000; height:10px"><?=$rh_folha_funcionario->salario_familia_qtd?></td>
           <td style="border-right:solid 1px #000000; height:10px" align="right"><span style="float:left">R$</span><?=moedaUsaToBr($rh_folha_funcionario->salario_familia_valor)?></td>
           <td style="height:10px" align="right"><span style="float:left">R$</span></td>
      </tr>
<?
}
if($i<15){
?>
         <tr valign="top" style="">
           <td align="center" style="border-right:solid 1px #000000;  border-bottom:solid 1px #000000">&nbsp;</td>
           <td style="border-right:solid 1px #000000;border-bottom:solid 1px #000000">&nbsp;</td>
           <td style="border-right:solid 1px #000000;border-bottom:solid 1px #000000">&nbsp;</td>
           <td style="border-right:solid 1px #000000;border-bottom:solid 1px #000000" align="right">&nbsp;</td>
           <td style="border-bottom:solid 1px #000000" align="right">&nbsp;</td>
      </tr>
        <tr>
<?
}
?>        	<td colspan="3" rowspan="2" style="height:30px;border-bottom:#000 solid 1px;border-right:solid 1px #000000;">&nbsp;</td>
            <td align="right" style="height:30px;border-right:solid 1px #000000;"><span style="float:left">R$</span><span style="border-right:solid 1px #000000; height:10px">
              <?=moedaUsaToBr($rh_folha_funcionario->salario_familia_valor)?>
            </span></td>
            <td align="right" style="height:30px;"><span style="float:left">R$</span>-</td>
        </tr>
        <tr>
        	<td style="height:30px;border-top:solid 1px #000000;border-bottom:solid 1px #000000;border-right:solid 1px #000000; font-weight:bold; font-size:12px;">Valor Líquido</td>
            <td align="right" style="height:30px;border-top:solid 1px #000000;border-bottom:solid 1px #000000; "><span style="float:left">R$</span><span style="border-right:solid 1px #000000; height:10px">
              <?=moedaUsaToBr($rh_folha_funcionario->salario_familia_valor)?>
            </span></td>
        </tr>
        <tr >
        	<td style="height:35px;border-bottom:#000 1px solid;" colspan="5">
            			<div class="desconto_fgts">
            
            	<div class="campos">
           			Sal&aacute;rio Base
           		</div>
                
                <div style="clear:both"></div>
           		-
           </div>
           <div class="desconto_fgts">
            
            	<div class="campos">
           			Sal. Contri. INSS
           		</div>
                
                <div style="clear:both"></div>
           		-
           </div>
           
           <div class="desconto_fgts">
            
            	<div class="campos">
           			&nbsp;	
           		</div>
                
                <div style="clear:both"></div>
                
           		8,00
           </div>
           
            <div class="desconto_fgts">
            
            	<div class="campos">
           			Base Cál. FGTS	
           		</div>
                
                <div style="clear:both"></div>
           		-
           </div>
           
           <div class="desconto_fgts">
            
            	<div class="campos">
           			F.G.T.S do mês	
           		</div>
                
                <div style="clear:both"></div>
           		-
           </div>
           
           <div class="desconto_fgts">
            
            	<div class="campos">
           			Base Cálc. IRRF	
           		</div>
                
                <div style="clear:both"></div>
           		-
           </div>
           
           <div class="desconto_fgts">
            
            	<div class="campos">
           			Faixa IRRF	
           		</div>
                -
                <div style="clear:both"></div>
           		
           </div>
            
            </td>
        </tr>
        <tr id="rodape">
        	<td style="height:35px; font-size:9px" colspan="5 ">
            	
                DECLARO TER RECEBIDO A IMPORTÂNCIA LÍQUIDA DISCRIMINADA NESTE RECIBO
           
           
           <div style="clear:both"></div>
           
         	 <div style="float:left;margin-top:25px;width:120px;">
        	            
            <div class="linha_assinatura" style="width:35px;float:left;margin-top:10px;">
    		</div>
        	
            <div style="float:left"> / </div>
            
            <div class="linha_assinatura" style="width:35px;float:left;margin-top:10px;">
    		</div>
        	
            <div style="float:left"> / </div>
            
            <div class="linha_assinatura" style="width:35px;float:left;margin-top:10px;">
    		</div>
            
            <div style="clear:both"></div>
            
            
            
            <div style="text-align:center">
            Data
            </div>
    		</div>
            
            
            <div style="float:right;margin-top:35px;width:500px;">
        	            
            <div class="linha_assinatura">
    		</div>
        	
            <div style="clear:both"></div>
            
            <div style="text-align:center">
            Assinatura do Empregado
            </div>
    		</div>
            
            </td>
        </tr>
</table>
<?

		}
		
		
if($s==1){
?>
        <div style="border-bottom:1px dashed #000000; height:15px; margin-bottom:15px;"></div>
<?
}
?> 
    
<?php

			if($s==2){
				$s=0;
				echo "<div class='quebra_pagina'></div>";
			}

		}
	}
	
	
?>
</body>
</html>