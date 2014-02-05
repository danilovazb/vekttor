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
	
	$inss = mysql_query($t="SELECT * FROM rh_inss WHERE  valor_minimo <= $ferias->salario_base AND valor_maximo >= $ferias->salario_base");
	
	if(mysql_num_rows($inss)<=0){
		$inss = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_inss ORDER BY valor_maximo DESC LIMIT 1"));
		//echo $t."<br>";
				
	}else{
		$inss = mysql_fetch_object($inss);
	}	
	//echo $inss->valor_beneficio;
		
	$irpf = mysql_query($t="SELECT * FROM rh_irpf WHERE  valor_minimo <= $ferias->salario_base AND valor_maximo >= $ferias->salario_base");
	
	$irpf = mysql_fetch_object($irpf);
	
	//echo $irpf->id;
	
	$desconto_inss = $ferias->salario_base*($inss->valor_beneficio/100);
	$desconto_irpf = $ferias->salario_base*($irpf->percentual_aliquota/100)-$irpf->valor_deducao;
	
	$salario_liquido = ($ferias->salario_base+($ferias->salario_base/3)) - $desconto_inss - $desconto_irpf;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Aviso e Recibo de Férias</title>

<style>
	#body{
		margin:0;
	}
	#pagina{		
		font-family:Arial, Helvetica, sans-serif;
		font-size:13px;
		width:230mm;
		height:297mm;
		
	}
	#cabecalho{
		text-align:center;
		line-height:
	}
	h1{
		margin-top:0px;
		font-size:16pt;
	}
	.quebra{
		white-space:normal;		
	}
	
	.campo{
						
		font-size:12px;
		line-height:1px;
		
	}
	
	#remuneracao,#recibo_ferias, #dados_firma, #rodape{
		width:99%;
		
		margin-top:15px;
		border: solid 1px #CCCCCC;
		margin-left:auto;
		margin-right:auto;
	}
	
	#remuneracao,#recibo_ferias{
		font-size:14px;
	}
	
	#dados_firma{
		height:157px;
		
		font-size:12px;
		line-height:17px;
	}
	
	#remuneracao{
		height:410px;
	}
	
	#recibo_ferias{
		height:35px;
	}
	
	#remuneracao > table, #notificacao > table{
		border-collapse:collapse;		
	}
	
	#remuneracao > table{
		width:110px;
		float:right;
		margin-right:50px;
	}
		
	#remuneracao > table tr td, #notificacao > table tr td{
		border:#999 solid 1px;
		
	}
	#notificacao > table tr td{
		text-align:center;
	}
	
	.linha_assinatura{
		width:100%;
		height:2px;
		border-bottom:solid 2px #999999;
		
	}
	
	#recibo_ferias{
		text-align:center;
	}
	
	#rodape{
		height:110px;
		font-size:11px;
		line-height:18px;
	}
	
	.valores{
		font-weight:bold;
	}
</style>

</head>

<body>
<div id="pagina">
	
    <div id="cabecalho">
		
        <h1>AVISO E RECIBO DE FÉRIAS</h1>
		
        <div style="font-size:14px;">        
        	CAPÍTULO VI - TITULO II DA C.L. T.
        </div>
        <div style="font-size:12px;">
        	DEC. LEI N&ordm; 5452 DE 01/05/1943, COM AS ALTERAÇOES DO DEC. LEI N&ordm; 1.535 DE 13/04/1977
		</div>
        
                
        <div style="margin-top:15px;line-height:17px;"> 
        	<span style="font-size:13px;font-weight:bold;"> AVISO PRÉVIO DE FÉRIAS</span>
    	<!--</div>
         <div style="font-size:12px;margin-top:2px;">-->
         	<div class="quebra"></div>
         
        	<span style="font-size:12px">DE ACORDO COM O ART. 135 DA C.L.T., PARTICIPANDO NO MÍNIMO COM 30 DIAS DE ANTECED&Ecirc;NCIA</span>
		</div>
	</div>
    
    <div id="notificacao">
    		<table align="center" width="99%">
            	<tr>
                	<td colspan="5" style="border:none;font-weight:bold;font-size:13px;">NOTIFICA&Ccedil;&Atilde;O</td>                	
                </tr> 
                <tr valign="bottom" style="font-size:12px;">
               	  <td width="300" >NOME EMPREGADO</td>
                	<td width="190">N&ordm; CART. DO TRABALHO</td>
                	<td width="53">S&Eacute;RIE</td>
                	<td colspan="2">REGISTRO DO EMPREGADO</td>
                </tr> 
              <tr style="height:35px;font-weight:bold;" valign="bottom">
                	<td style="text-align:left;"><?=$funcionario->nome?></td>
                	<td><?=$funcionario->carteira_profissional_numero?></td>
                	<td><?=$funcionario->carteira_profissional_serie?></td>
                	<td width="54"></td>
                	<td width="180">&nbsp;</td>
                </tr>                
            </table>
            <table align="center" width="99%">
            	<tr>
                	<td colspan="5" style="border:none;font-weight:bold;font-size:13px;">PER&Iacute;ODO DE AQUISI&Ccedil;&Aring;O</td>                	
                </tr> 
               <tr>
               	<td colspan="5" style="height:30px;text-align:left;font-weight:bold;font-size:14px;padding-left:4px;" valign="bottom">
               		<div style="float:left;width:55px;"><?=$inicio_periodo_aquisicao[2]?></div>
                    <div style="float:left;width:80px;">de</div>
                    <div style="float:left;width:100px;"><?=mes($inicio_periodo_aquisicao[1])?></div>
                    <div style="float:left;width:70px;">de</div>
                    <div style="float:left;width:100px;"><?=$inicio_periodo_aquisicao[0]?></div>
                    <div style="float:left;width:60px;">à</div>
                    <div style="float:left;width:55px;"><?=$fim_periodo_aquisicao[2]?></div>
                    <div style="float:left;width:55px;">de</div>
                    <div style="float:left;width:80px;"><?=mes($fim_periodo_aquisicao[1])?></div>
                    <div style="float:left;width:55px;">de</div>
                    <div style="float:left;width:55px;"><?=$fim_periodo_aquisicao[0]?></div>
               	</td>   
              </tr>          
            </table> 
               <table align="center" width="99%">
            	<tr>
                	<td colspan="5" style="border:none;font-weight:bold;font-size:13px;">PER&Iacute;ODO DE GOZO DAS F&Eacute;RIAS</td>                	
                </tr>
               <tr> 
               	 <td colspan="5" style="height:30px;text-align:left;font-weight:bold;font-size:14px;padding-left:4px;" valign="bottom">
               		<div style="float:left;width:55px;"><?=$inicio_ferias[2]?></div>
                    <div style="float:left;width:80px;">de</div>
                    <div style="float:left;width:100px;"><?=mes($inicio_ferias[2])?></div>
                    <div style="float:left;width:70px;">de</div>
                    <div style="float:left;width:100px;"><?=$inicio_ferias[0]?></div>
                    <div style="float:left;width:60px;">à</div>
                    <div style="float:left;width:55px;"><?=$inicio_ferias[2]?></div>
                    <div style="float:left;width:55px;">de</div>
                    <div style="float:left;width:80px;"><?=mes($inicio_ferias[1])?></div>
                    <div style="float:left;width:55px;">de</div>
                    <div style="float:left;width:55px;"><?=$inicio_ferias[0]?></div>
               	</td>    
               </tr>           
            </table>
            
            </table> 
            
               <table align="center" width="99%">
            	<tr>
                	<td colspan="3" style="border:none;font-weight:bold;">BASE DE C&Aacute;LCULO DA REMUNERA&Ccedil;&Atilde;O DAS F&Eacute;RIAS</td>                	
                </tr> 
                <tr style="font-size:12px;">
               		<td >FALTA N&Atilde;O JUST.</td>
                    <td >SAL. BASE</td>
                    <td >BASE PARA CÁLCULO:  BASE PARA CALCULO: MENSAL-HORÁRIO-TAREFA OU OUTRAS</td>   
				</tr>
                <tr>
           		  <td ><?=$ferias->faltas?></td>
                    <td style="font-weight:bold;font-size:14px;">R$ <?=MoedaUsaToBr($ferias->salario_base)?></td>
                    <td ></td>   
				</tr>                          
            </table>                
    </div>
    
  <div id="remuneracao">
    	<div style="float:left">
        	VALOR DA REMUNERAÇAO.......................................................................<div class="quebra"></div>
        	1/3 FÉRIAS REMUNERADAS (Art. 7&ordm; - Inciso XVII - C.F)................................<div class="quebra"></div>
     	</div>   
        <table class="valores">
        	<tr>
            	<td>R$ <?=MoedaUsaToBr($ferias->salario_base)?></td>
             </tr>
            <tr>
            	<td>R$ <?=MoedaUsaToBr($ferias->salario_base/3)?></td>
             </tr>
             <tr>
            	<td>R$ 0,00</td>
             </tr>
             <tr>
            	<td>R$ <?=MoedaUsaToBr($ferias->salario_base+($ferias->salario_base/3))?></td>
             </tr>
        </table>
        
        <div style="clear:both"></div>
        
        <div style="float:left;margin-top:20px;">
        	<strong>DEDUÇOES</strong><div class="quebra"></div>
        	INSS <strong><?=MoedaUsaToBr($inss->valor_beneficio)?>%</strong>................................<div class="quebra"></div>
     		IMPOSTO DE RENDA NA FONTE <strong><?=MoedaUsaToBr($irpf->percentual_aliquota)?> %</strong>..................
        </div>
        
        <table class="valores" style="float:left;margin-left:50px;margin-top:30px;">
        	<tr>
            	<td>R$ <?=MoedaUsaToBr($desconto_inss)?></td>
             </tr>
            <tr>
            	<td>R$ <?=MoedaUsaToBr($desconto_irpf)?></td>
          </tr>
             <tr>
            	<td>&nbsp;</td>
             </tr>
            
        </table>
        
        <table class="valores" style="width:220px;margin-top:65px;">
        	
            <tr>
            	<td style="width:110px;border:none;text-align:right;"></td>
                <td style="width:110px;border:none;"></td>
             </tr>
            <tr>
            	<td style="width:110px;border:none;text-align:right;font-weight:normal;">L&Iacute;QUIDO</td>
                <td style="width:110px;">R$ <?=MoedaUsaToBr($salario_liquido)?></td>
          </tr>
             
        </table>
        
        <div style="clear:both"></div>
        
        <div style="width:80%;margin-left:auto;	margin-right:auto;margin-top:10px;font-size:12px;line-height:16px;">
        	Pelo  presente  comunicamos-lhes  que,  de  acordo  com  a  lei, ser-lhe-ao concedidas férias relativas
            ao  período   acima  descrito  e  a  sua disposiçao fica  a    importância  Liquída de <?=MoedaUsaToBr($salario_liquido)?>(<?=numero(number_format($salario_liquido,2,',',''),'moeda')?>), a ser paga adiantadamente.
        </div>
        
        <div style="clear:both"></div>
        
        <div style="width:350px;margin-top:20px;">
        	<strong style="font-size:13px;margin-left:3px;"><?=$cliente_fornecedor->cidade?> (<?=$cliente_fornecedor->estado?>),</strong>
        	<div class="linha_assinatura"></div>
            <center>Local e data</center>
        
        </div>
        
        <div style="width:350px;margin-top:25px;float:left;">
        	Ciente
        	<div class="linha_assinatura" style="margin-top:65px;"></div>
            <div style="text-align:center;font-size:12px;">Assinatura do empregado</div>
        
        </div>
        
        <div style="width:300px;margin-top:60px;float:right;">
        	
        	<div class="linha_assinatura" style="margin-top:47px;"></div>
            <div style="text-align:center;font-size:12px;">Assinatura do empregador</div>
        
        </div>
        
    </div>
    
    <div style="clear:both"></div>
    
    <div id="recibo_ferias">
    	<strong>RECIBO DE FÉRIAS</strong> <div class="quebra"></div>
        DE ACORDO COM O PARÁGRAFO ÚNICO DO ARTIGO 145 DA C.L.T.
    </div>
            
  <div id="dados_firma">     		
            
            <div style="float:left;width:170px">Recebi da firma</div>
            <div style="float:left;font-weight:bold;"><?=$cliente_fornecedor->razao_social?></div>
            
            <div style="clear:both"></div>
              
            <div style="float:left;width:170px;">estabelecida à</div>
            <div style="float:left;width:400px;font-weight:bold;"><span class="xl142">
              <?=$cliente_fornecedor->endereco?>
            </span></div>
            <div style="float:left;">em  <font class="font11">
              <?=$cliente_fornecedor->cidade."-".$cliente_fornecedor->estado?>
            </font></div>
            
            <div style="clear:both"></div>
              
            <div style="float:left;width:170px;">a importância de</div>
            <div style="float:left;width:80px;font-weight:bold;">R$ <span class="xl116">
              <?=MoedaUsaToBr($salario_liquido)?>
            </span></div>
            <div style="float:left;font-weight:bold;">(<?=numero(number_format($salario_liquido,2,',',''),'moeda')?>)</div>
            
            <div style="clear:both"></div>
            
            <div style="float:left;width:685px;">
            	que me é paga  adiantadamente por motivo das minhas férias regulamentares, ora concedidas e que vou gozar de acordo com a  		  	 
  				descrição acima, tudo conforme o aviso que recebi em tempo, ao qual dei meu "ciente".
            </div>
            
             <div style="float:left;font-size:13px;width:80%;text-align:center;">
            	Para clareza e documento, firmo o presente recibo, dando a firma plena e geral quitação.
            </div>
            
            <div style="clear:both"></div>
            
            <div style="width:350px;margin-top:19px;float:left;">
        	<strong style="font-size:14px;margin-left:3px;"><?=$cliente_fornecedor->cidade?> (<?=$cliente_fornecedor->estado?>),</strong>
        	<div class="linha_assinatura"></div>
            <div style="text-align:center;font-size:12px;">LOCAL E DATA</div>
            </div>
            
             <div style="width:300px;margin-top:19px;float:right;">
        		
        		<div class="linha_assinatura" style="margin-top:16px;"></div>
            	<div style="text-align:center;font-size:12px;">Assinatura do empregado</div>
        
        	</div>          
     </div>
     
     <div style="clear:both"></div>
     
     <div id="rodape">
     	
Observação: § 1º do Art. 135 da C.L.T.- O empregado não poderá entrar em gozo das feriassem que apresente ao empregador sua carteira profissional,
			<div class="quebra"></div> 	  	  	 
  	  		<div style="margin-left:88px;">
            para que nela seja anotada a respectiva concessão.  							  	 
  	  		<div class="quebra"></div>
            O recibo de Férias deverá ser quitado pelo empregado pelo menos 2(dois) dias antes do período de gozo de férias.</div>  		  	 
  	Do direito a férias e da sua duração: De acordo com o artigo 130 da C.L.T. a proporção ao direito de férias. 
    		
            <div style="clear:both"></div>					  	 
  	  		
            <div style="width:100%;text-align:center">
            	<div style="width:30%;float:left;margin-left:200px;text-align:left">Até 5 faltas - 30 dias corridos</div>
                <div style="width:30%;float:left;text-align:left">15 a 23 faltas - 18 dias corridos</div>
                
                <div style="clear:both"></div>
                 		  	 
  	  	  		<div style="width:30%;float:left;margin-left:200px;text-align:left">6 a 14 faltas - 24 dias</div>
                <div style="width:30%;float:left;text-align:left">24 a 32 faltas - 12 dias corridos.</div>
			</div>
     </div>
</div>
</body>
</html>