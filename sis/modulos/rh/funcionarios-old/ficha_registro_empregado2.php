<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
$id = $_GET['id'];
	
$empregado = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id=$id"));
	
$empresa     = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id=$empregado->empresa_id"));

$aumentos_salarios = mysql_query($t="SELECT * FROM rh_alteracao_salario WHERE funcionario_id='$empregado->id' ORDER BY id DESC LIMIT 10");
$alteracao_contratos = mysql_query($t="SELECT * FROM rh_alteracao_contrato WHERE funcionario_id='$empregado->id' ORDER BY id DESC LIMIT 10");

$ferias_gozadas = mysql_query("SELECT * FROM rh_ferias WHERE funcionario_id='$empregado->id' ORDER BY id DESC");
//echo $t;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2" />
<style>
	*{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	#pagina{
		width:1001px;
	}
	
	#esquerda{
		float:left;
	}
	#direita{
		float:right;
	}
	
	#esquerda, #direita{
		
		
		width:500px;
		
	}
	
	#ferias{
		width:100%;
	}
	
	.quadro{
		
		border-bottom:2px #000000 solid;
		
	}
	
	#contribuicao{
		width:100%;
		font-size:13px;
		border-top:#000 solid 2px;
		text-align:center;
		
	}
	.linha_assinatura{
		
		height:2px;
		border-bottom:solid 1px #000000;
		
		
	}
</style>
<title>FIcha de Empregados</title>
</head>

<body>
<div id="pagina">
	<div id="esquerda">
    	<div class="quadro">
        
        	<table id="ferias">
            	<tr>
                	<td colspan="2" style="font-size:13px;"><strong>FÉRIAS GOZADAS</strong></td>
                </tr>
                <?
					
					//while($ferias = mysql_fetch_object($ferias_gozadas)){
						//$ferias_inicio_aquisicao = explode("-",$ferias->data_inicio_aquisicao);
						//$ferias_fim_aquisicao = explode("-",$ferias->data_fim_aquisicao); 
						//$ferias_inicio = explode("-",$ferias->data_inicio);
						//$ferias_fim = explode("-",$ferias->data_fim); 
					
					for($i=0;$i<10;$i++){
				
				?>
                <tr>
                	<td style="width:200px;">De   <?=$ferias_inicio_aquisicao[1]."/".$ferias_inicio_aquisicao[0]?></td>
                    <td style="width:300px;">Gozou de &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=MoedaUsaToBr($ferias->data_inicio)?>       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        <?=MoedaUsaToBr($ferias->data_fim)?></td>
                </tr >
                <?
					}
				?>
              
            </table>
        	
        
        </div>
        
        <div class="quadro">
        
        	<table id="ferias">
            	<tr>
                	<td colspan="2" style="font-size:13px;"><strong>AUMENTOS DE SALÁRIOS</strong></td>
                </tr>
                <?
					//while($aumento_salario=mysql_fetch_object($aumentos_salarios)){
					for($i=0;$i<10;$i++){
				
				?>
                <tr>
                	<td style="width:200px;">Alterado em    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ____/____/____      </td>
                    <td style="width:300px;">para R$ &nbsp;&nbsp;&nbsp;_______&nbsp;&nbsp;<div class="linha_assinatura" style="float:right;margin-top:10px;width:185px;"></div></td>
                </tr >
                <?
					}
				?>
            </table>
        	
        
        </div>
        <div class="quadro">
        
        	<table id="ferias">
            	<tr>
                	<td colspan="2" style="font-size:13px;"><strong>ACIDENTES DE TRABALHO</strong></td>
                </tr>
                <?
					for($i=0;$i<10;$i++){
				?>
                <tr>
                	<td style="width:200px;">Acid. Em &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;____/____/____ </td>
                    <td style="width:300px;">Alta Em &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;____/____/____ </td>
                </tr >
                <?
					}
				?>
            </table>
        	
        
        </div>
         <div class="quadro">
        
        	<table id="ferias">
            	<tr>
                	<td colspan="2" style="font-size:13px;"><strong>ALTERAÇAO DO CONTRATO DE TRABALHO</strong></td>
                </tr>
                <?
					//while($alteracao_contrato=mysql_fetch_object($alteracao_contratos)){
					for($c=0;$c<=10;$c++){
				?>
                <tr>
                	<td style="width:100%;">EM: ____/____/____ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                     Cargo:_________________________</td>
                    
                </tr >
                <?
					}
				?>
            </table>
        	
        
        </div>
    </div>
    <div id="direita">
    	   <div class="quadro">
        
        	<table id="contribuicao">
            	<tr>
                	<td colspan="3" style="border-bottom:#000 2px solid"><strong>CONTRIBUIÇAO SINDICAL</strong></td>
                </tr>
                <tr>
                	<td ><strong>ANO</strong></td>
                    <td ><strong>R$</strong></td>
                    <td ><strong>SINDICATO</strong></td>
                </tr>
                <?
					for($i=0;$i<20;$i++){
				?>
              <tr style="height:16px;">
                	<td ></td>
                    <td ></td>
                    <td ></td>
                </tr>
                <?
					}
				?>
            </table>
        	
        
        </div>
         <div class="quadro" style="height:212px;">
        
        	<div style="text-align:center">FGTS - FUNDO DE GARANTIA DE TEMPO DE SERVIÇO</div>
        
        	<div style="clear:both"></div>
        
        	<div style="float:left;margin-top:30px;margin-left:150px;height:102px;">
        		<table>
                	<tr>
                    	<td colspan="3">OPÇAO</td>
                    </tr>
                    <tr>
                    	<td>01 /</td>
                        <td>11 /</td>
                        <td>2011</td>
                    </tr>
                    <tr>
                    	<td>Dia</td>
                        <td>Mes</td>
                        <td>Ano</td>
                    </tr>
                </table>
        	
        	</div>
        
        	<div style="float:left;margin-top:30px;margin-left:50px;">
        		<table>
                	<tr>
                    	<td colspan="3">RETRATAÇAO</td>
                    </tr>
                    <tr>
                    	<td>........./</td>
                        <td>........./</td>
                        <td>........./</td>
                    </tr>
                    <tr>
                    	<td>Dia</td>
                        <td>Mes</td>
                        <td>Ano</td>
                    </tr>
                </table>
        	
        	</div>    
            
            <div style="clear:both"></div>    	
        	
            <div style="margin-left:100px;">
                    Banco Depositário ____________________________
                    
                    <div style="clear:both"></div>
                    
                    Agencia _____
                    
                    <div style="clear:both"></div>
                    
                    Praça ___________________
                    
                    <div style="clear:both"></div>
                    
                    UF ___
            </div>
        
        
    	</div>    
        
        <div class="quadro">
        
        	<table id="ferias" style="margin-left:60px;">
            	<tr>
                	<td colspan="2" style="font-size:13px;">REGISTROS E LICENÇAS</td>
                </tr>
                <?
					for($i=0;$i<11;$i++){
				?>
               <tr>
                	<td style="width:200px;">Licenciado em    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;____/____/____       </td>
                    <td style="width:300px;">Alta em R$ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_____________</td>
                </tr >
                <?
					}
				?>
            </table>
        	
        
        </div>
        
    </div>
        
</div>
</body>
</html>