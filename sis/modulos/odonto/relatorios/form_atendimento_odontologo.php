<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:750px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Atendimento Odontólogo</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	  <fieldset id="campos_1">
<!-- *********************** AQUI FORMULARIO DE CADASTRO DE ITENS****-->
 		<legend>
           <strong>Atendimentos</strong>
          </legend>
          
             <div style="clear:both;"></div>
             <?
			 	$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM 
																		usuario u,
																		odontologo_odontologo oo
																	WHERE 
																		u.id = oo.usuario_id AND
																		u.id='".$_GET['id']."'"));
			 ?>
            <div style="float:left"><strong>Odontólogo:</strong> <?=$cliente_fornecedor->nome?></div>
            <div style="float:left;margin-left:70px;"><strong>Porcentagem:</strong> <?=$cliente_fornecedor->porcentagem_recebimento."%"?></div>
            <div style="clear:both"></div>
            <div style="height:350px;overflow:auto">
          	<table cellpadding="0" cellspacing="0" width="100%" id="tbl_procedimentos">
                <thead>
                        <tr>
                          <td width="60">Data</td>
                          <td width="150">Cliente</td>
                          <td width="200">Convênio</td>
                          <td width="200">Procedimento</td>
                          <td width="200">Vl Procedimento</td>
                           <td width="200">Vl Porcentagem</td>
                          <td width="200">Observação</td>
                          <td></td>               
                        </tr>
               </thead>
                <tbody id="tbody" style="background-color:white;">
                	<?php
						$cont=0;
						
						$odontologo_atendimento_item = mysql_query($t="SELECT oa.*, s.nome as servico, s.valor_normal FROM  odontologo_atendimento_item as oa, servico as s WHERE oa.vkt_id='$vkt_id' AND oa.odontologo_id='".$_GET['id']."' AND oa.data_cadastro BETWEEN '".$_GET['data_inicio']."' AND '".$_GET['data_fim']."' AND s.id = oa.servico_id ORDER BY oa.id DESC");
						$porcentagem_odontologo = mysql_result(mysql_query($t="SELECT 
																					oo.porcentagem_recebimento as porcentagem_recebimento 
																				FROM 
																					odontologo_odontologo oo,
																					usuario u
																				WHERE
																					u.cliente_vekttor_id AND
																					oo.usuario_id = u.id AND 
																					u.id='".$_GET['id']."'"),0,0);
						//echo $porcentagem_odontologo;
						$valor=0;
						$valor_odontologo = 0;
						while($atendimento=mysql_fetch_object($odontologo_atendimento_item)){	
						$valor+=$atendimento->valor_normal;	
						$cont++;
						
						if($cont%2==0){$c="al";}else{$c="";}
							$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = '$atendimento->cliente_fornecedor_id'"));
							
							if($atendimento->cliente_fornecedor_id==$cliente_anterior){
								$count_cliente++;
							}else{
								$count_cliente=0;
							}
							
							$servico = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id = '$atendimento->servico_id'"));
							$convenio = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_atendimentos oa, cliente_fornecedor cf
																		WHERE
																			oa.vkt_id='$vkt_id' AND 
																			oa.convenio_id=cf.id AND
																			oa.id = '$atendimento->odontologo_atendimento_id'"));
																			//echo $t;
							$valor_odontologo += $servico->valor_colaborador;
							$porcentagem_servico_odontologo = ($porcentagem_odontologo * $servico->valor_normal)/100;
							$porcentagem_servico_odontologo_total+=$porcentagem_servico_odontologo;
							$movimento_financeiro = mysql_fetch_object(mysql_query($t="SELECT 
																						* 
																					FROM 
																						financeiro_movimento 
																					WHERE 
																						internauta_id='$atendimento->cliente_fornecedor_id' AND 
																						doc='$atendimento->odontologo_atendimento_id' AND
																						origem_tipo='odonto'
																						LIMIT $count_cliente,1
																					"));
							$cliente_anterior = $atendimento->cliente_fornecedor_id;
					?>
                    		<tr class="<?=$c?>">
                            	<td>
                                	<?=DataUsaToBr($atendimento->data_cadastro)?>
                                </td>
                                <td >
                                	<?=$cliente->razao_social?>
                                                                                         	
                                </td>
                                <td width="200"><?=$convenio->razao_social?></td>
                                <td>
                                	<?=$servico->nome?>                                               	
                                </td>
                                <td>
                                	<?=moedaUsaToBR($servico->valor_normal)?>                                               	
                                </td>
                                 <td><?=moedaUsaToBR($porcentagem_servico_odontologo)?></td>
                                 <td width="200"><?=$movimento_financeiro->nota?></td>
                                <td></td>
                            </tr>
                   <? } ?>
                </tbody>
                <tfoot>
            			<tr>
							  <td></td>
							  <td></td>
                              <td></td>
                              <td></td>
                              <td><?=moedaUsaToBR($valor)?></td>
                              <td><?=moedaUsaToBR($porcentagem_servico_odontologo_total)?></td>
                              <td></td>
                              <td></td>
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