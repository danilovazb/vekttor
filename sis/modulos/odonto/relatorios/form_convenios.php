<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");

$convenio_id    = $_GET['convenio_id'];
$data_inicio = $_GET['data_inicio'];
$data_fim    = $_GET['data_fim'];
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:600px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Convênio X Serviços</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$_GET['convenio_id']?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	  <fieldset id="campos_1">
<!-- *********************** AQUI FORMULARIO DE CADASTRO DE ITENS****-->
 		<legend>
           <strong>Convenios X Serviços</strong>
          </legend>
            <input type="hidden" name="item_id" id="item_id" style="width:50px;">
             <div style="clear:both;"></div>
             <?
			 	$cliente_fornecedor = mysql_fetch_object(mysql_query($t="
					SELECT 
						* 
					FROM 
						cliente_fornecedor
					WHERE
						id = '$convenio_id'	
				"));
			 	$odontologo_atendimento_item = mysql_query($t="SELECT *,oai.id as item_id FROM 
												  odontologo_atendimentos oa, 
												  odontologo_atendimento_item oai 
											  WHERE 
												  oa.id = oai.odontologo_atendimento_id AND
												  oa.convenio_id = '$convenio_id' AND
												    oai.aprovado   = '1' AND
												  oai.data_cadastro BETWEEN '".$data_inicio."' AND '".$data_fim."'");
												  //echo $t;
												 
			 ?>
            <div><strong>Convenio:</strong> <?=$cliente_fornecedor->razao_social?></div>
            <div style="height:350px;overflow:auto">
          	<table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td width="60">Data</td>
                          <!--<td width="150">Odontologo</td>-->
                          <td width="150">Cliente</td>
                          <td width="200">Procedimento</td>
                          <td width="200">Valor</td>
                           <td width="200"></td>
                                    
                        </tr>
               </thead>
                <tbody id="tbody" style="background-color:white;">
                	<?php
						$cont=0;
						
						//$odontologo_atendimento_item = mysql_query($t="SELECT oa.*, s.nome as servico, s.valor_normal FROM  odontologo_atendimento_item as oa, servico as s WHERE oa.vkt_id='$vkt_id' AND oa.odontologo_id='".$_GET['id']."' AND oa.data_cadastro BETWEEN '".$_GET['data_inicio']."' AND '".$_GET['data_fim']."' AND s.id = oa.servico_id");
						$valor=0;
						while($atendimento=mysql_fetch_object($odontologo_atendimento_item)){	
						$valor+=$atendimento->valor;	
						$cont++;
						if($cont%2==0){$c="al";}else{$c="";}
							$cliente    = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = '$atendimento->cliente_fornecedor_id'"));
							$servico    = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id = '$atendimento->servico_id'"));
							$odontologo = mysql_fetch_object(mysql_query($t="SELECT 
																				* 
																		 FROM 
																		 		odontologo_odontologo oo,
																				cliente_fornecedor cf 
																		WHERE 
																				oo.cliente_fornecedor_id = cf.id AND
																				oo.usuario_id = '$atendimento->odontologo_id'"));
							$valor_total_convenio+=$atendimento->valor_convenio; 
																				
																				//echo $t." ".mysql_error();
					?>
                    		<tr class="<?=$c?>">
                            	<td>
                                	<?=DataUsaToBr($atendimento->data_cadastro)?>
                                    <!--<input type="hidden" class="item_id" value="<?=$atendimento->item_id?>" />-->
                                </td>
                                 <!--<td width="150"><?=$odontologo->razao_social?></td>-->
                                <td >
                                	<?=$cliente->razao_social?>                                                                                         	
                                </td>
                                <td>
                                	<?=$servico->nome?>                                               	
                                </td>
                                <td align="right">
                                	<?=moedaUsaToBR($atendimento->valor)?>                                               	
                                </td>
                                <td>
                                <label style="margin-top:5px;">
                                	<input type="text" name="vlr_convenio"  item_id="<?=$atendimento->item_id?>" class="vlr_convenio" value="<?=MoedaUsaToBr($atendimento->valor_convenio)?>" style="text-align:right" decimal="2"
                                    sonumero="1"/>
                                </label>                                               	
                                </td>                               
                            </tr>
                   <? } ?>
                </tbody>
                <tfoot>
            			<tr>
							  <td></td>
                              <!--<td></td>-->
							  <td></td>
                              <td></td>
                              <td align="right"><?=moedaUsaToBR($valor)?></td>
                              <td id="total_convenio" align="right"><?=moedaUsaToBR($valor_total_convenio)?></td>
						</tr>
                </tfoot> 
             </table>
             </div>    
                        
            <table cellpadding="0" cellspacing="0" width="100%" >
            		
              </table>
      </fieldset>
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="imprimir" id="imprimir_atendimentos" type="button"  value="Imprimir" style="float:left"/>
<input type="hidden" name="data_inicio" id="data_inicio" value="<?=DataUsaToBr($_GET['data_inicio'])?>"/>
<input type="hidden" name="data_fim" id="data_fim" value="<?=DataUsaToBr($_GET['data_fim'])?>"/>
<input name="action" type="submit"  value="Fechar" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>