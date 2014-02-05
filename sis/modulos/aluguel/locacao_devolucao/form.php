<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
include("../../../modulos/financeiro/_functions_financeiro.php");
// funções do modulo empreendimento
$display_reserva = 'none';
$DisaPago = '';
include("_functions.php");
include("_ctrl.php"); 
$sqlDevolucao = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS QtdLocacao FROM aluguel_locacao_itens WHERE locacao_id = '".$aluguel->id."'"));
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:820px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    <span>Loca&ccedil;&atilde;o</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$aluguel->id?>">
    <input type="hidden" name="data_hoje" id="data_hoje" value="<?=date('d/m/Y')?>">
    <input type="hidden" name="StatusLocacao" id="StatusLocacao" value="1">
    <input type="hidden" name="StatusLocacaoUpdate" id="StatusLocacaoUpdate" value="<?=$aluguel->status_locacao?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
    <!-- ABA LOCAÇAO -->
	<fieldset>
		 <legend>
            <a onclick="aba_form(this,0)"> <strong>Loca&ccedil;&atilde;o</strong></a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <? if($sqlDevolucao->QtdLocacao > 0) {?>
         	<a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>
            <? } ?>
            <a onclick="aba_form(this,3)">Despesas</a>
            <a onclick="aba_form(this,4)">Contrato</a>
            <a onclick="aba_form(this,5)">Resumo</a>
          </legend>
          <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$aluguel->cliente_id?>">
           
          <div style="clear:both; padding-top:5px;"></div>
		  <label style="width:270px;">
			Cliente
			  <input type="text" busca="modulos/aluguel/locacao_devolucao/busca_cliente.php,@r1 @r2,@r0-value>cliente_id|@r1-value>cliente" autocomplete='off' name="cliente" id="cliente" maxlength="44"  valida_minlength="3"  retorno='focus|Selecione o Cliente' value="<?=$cliente->razao_social?>" <?=$DisaPago?> />              
		</label>
        <label style="width:32px;"><br/>
          	<button type="button" name="cad_cliente"  id="cad_cliente" title="Cadastro de Clientes" rel="tip" ><img  src="../fontes/img/adm.png" ></button>
         </label>
            <!-- modal -->
           <div style="position:absolute; left:140px; margin-top:50px;">
              <div class="modal" style="display:none">
              <div class="modal-header-2">
              	<a href="#" style="color:#CCC; font-weight:bold; float:right;" class="modal_close">x</a>
                <span>Cadastro de Cliente</span>
              </div>
                    <div class="modal-body">
                    	<p>
                        	<div class="atl_natureza" style="padding:3px;">
                            	<div style="float:left"><input type="radio" name="natureza" id="cpf" value="1" style="width:20px;">CPF</div>
                            	<div><input type="radio" name="natureza" id="cnpj" value="2" style="width:20px;">CNPJ</div>
                            </div>
                            <div style="clear:both;"></div>
                        	<div style=" float:left;"><label style="width:175px;">Nome<br/><input type="text" name="atl_nome" id="atl_nome" style="height:15px;" disabled="disabled"></label></div>
                            <div><label style="width:120px;">CNPJ/CPF <br/><input type="text" name="atl_cnpf_cpf" id="atl_cnpf_cpf" style="height:15px;" disabled="disabled"></label></div>      
                         </p>
                         <!--<button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" style="margin-top:8px;" >cadastrar</button>-->
                          <div><small style=" color:#999999; font-size:11px;">ap&oacute;s cadastro v&aacute; para tela cliente para completar as informa&ccedil;&otilde;es </small></div>
                    </div>
              <div class="modal-footer">
              	<!--<div style="padding:3px;"><span>ap&oacute;s o cadastro vá para tela cliente</span></div>999999-->
                <button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" >cadastrar</button>
               
              </div>
			</div>
    		</div>
        	<!-- fim modal -->
        
         <label>Status Loca&ccedil;&atilde;o<br/>
        	<select name="status_locacao" id="status_locacao" disabled="disabled">
                <option <? if($aluguel->status_locacao == '1'){echo 'selected="selected"';}?>value="1">Loca&ccedil;&atilde;o</option>
                <option <? if($aluguel->status_locacao == '2'){echo 'selected="selected"';}?>value="2">Devolvido</option>
                <option <? if($aluguel->status_locacao == '3'){echo 'selected="selected"';}?>value="3">Parcialmente Devolvido</option>
                <option <? if($aluguel->status_locacao == '4'){echo 'selected="selected"';}?>value="4">Cancelado</option>
                <option <? if($aluguel->status_locacao == '5'){echo 'selected="selected"';}?>value="5">Em Andamento</option>
                <option <? if($aluguel->status_locacao == '6'){echo 'selected="selected"';}?>value="6">Reserva</option>
            </select>
        </label>
         
        <label>
        Valor Total <br/>
        	<input type="hidden" name="valor_total" id="valor_total" style="width:100px;" readonly="readonly" value="<?=moedaUsaToBr($aluguel->valor_total)?>">
            <div style="padding:5px; margin-top:0px;"><?=moedaUsaToBr($aluguel->valor_total)?></div>
        </label>
        <div style="clear:both"></div>
        <label style="width:270px;">Descriçao
        	<input type="text" name="descricao" id="descricao"  value="<?=$aluguel->descricao?>" <?=$DisaPago?> >
        </label>
       
        <label style="width:75px">Data Loca&ccedil;&atilde;o<br/>
        	<input type="text" style="width:70px;" <?=$DisaPago?> name="data_locacao" id="data_locacao" value="<? 
			if($aluguel->data_locacao){ echo dataUsaToBr($aluguel->data_locacao);}
			else{ echo date("d/m/Y");}
			?>" calendario="1" />
        </label>
         <label>Data Devolu&ccedil;&atilde;o<br/>
        	<input type="text" name="data_devolucao" id="data_devolucao" <?=$DisaPago?> calendario="1" mascara="__/__/____" style="width:70px;" value="<? if($aluguel->data_devolucao){ echo dataUsaToBr($aluguel->data_devolucao); }?>">
        </label>
        <label>
        Dias<br/>
        	<input type="text" name="dias" id="dias" style="width:50px" value="<?=$aluguel->qtd_dias?>" <?=$DisaPago?>>
        </label>
        <label style="width:70px;">
        	<?php
				if(!empty($aluguel->comissao_vendedor)){
						$comissao = $aluguel->comissao_vendedor;	
				} else{
            			$sqlConf = mysql_fetch_object(mysql_query(" SELECT * FROM  aluguel_configuracao WHERE id =  '$vkt_id' "));
						$comissao = $sqlConf->comissao_vendedor;
				}
			?>
        	Vendedor <br/>
            <input type="text" name="comissao_vendedor"  decimal="1" id="comissao_vendedor" style="width:50px;float:left; text-align:right;" value="<?=substr(moedaUsaToBr($comissao),0,4);?>"><div style="margin-top:5px;">%</div>
        </label>
        <div style="clear:both"></div>
         <label id="aqui_reserva" style="display:<?=$display_reserva?>">Data Reserva<br/>
        	<input type="text" name="data_reserva" id="data_reserva" calendario="1" mascara="__/__/____" style="width:70px;" value="<? if($aluguel->data_reserva){echo dataUsaToBr($aluguel->data_reserva);}?>" <?=$DisaPago?> >
        </label>
       
        <!--<label style="width:120px;">Forma de Pagamento
        	<select name="forma_pagamento" id="forma_pagamento">
            	<option value="0">Selecione</option>
                <option <?if($aluguel->forma_pagamento == '1'){echo 'selected="selected"';}?>value="1">Dinheiro</option>
                <option <?if($aluguel->forma_pagamento == '2'){echo 'selected="selected"';}?>value="2">Cheque</option>
                <option <?if($aluguel->forma_pagamento == '3'){echo 'selected="selected"';}?>value="3">Cart&atilde;o de Credito</option>
            </select>
        </label>-->
        
        <!--<label style="width:100px;">
        Pago
        	<select name="pago" id="pago">
            	<option value="0">Selecione</option>
                <option <?if($aluguel->pago == 'sim'){echo 'selected="selected"';}?>value="sim">Sim</option>
                <option <?if($aluguel->pago == 'nao'){echo 'selected="selected"';}?>value="nao">N&atilde;o</option>
            </select>
        </label>-->
        
        
        <!--<label style="width:350px;">Observa&ccedil;&atilde;o Pagamento
        	<input type="text" name="obs_pagamento" id="obs_pagamento" style="width:350px;" value="<?$aluguel->obs_pagamento?>">
        </label>-->
       
        <div style="clear:both"></div>
        <label>
        Observa&ccedil;&atilde;o Loca&ccedil;&atilde;o <br/>
        	<textarea name="obervacao_locacao" id="obervacao_locacao" cols="28" rows="7" <?=$DisaPago?> ><?php echo $aluguel->obervacao_locacao?></textarea>
        </label>
        <label>
       Observa&ccedil;&atilde;o Devolu&ccedil;&atilde;o <br/>
        	<textarea name="observacao_devolucao" id="observacao_devolucao" cols="28" rows="7" <?=$DisaPago?> ><?php echo $aluguel->observacao_devolucao?></textarea>
        </label>
	</fieldset>
<!--Fim dos fiels set-->
<!-- ABA EQUIPAMENTO -->
<fieldset id="campos_2" style="display:none">
		  <legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)"><strong>Equipamento</strong></a>
            <? if($sqlDevolucao->QtdLocacao > 0) {?>
            <a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>
            <? } ?>
            <a onclick="aba_form(this,3)">Despesas</a>
            <a onclick="aba_form(this,4)">Contrato</a>
           <a onclick="aba_form(this,5)">Resumo</a>
          </legend>
           <input type="hidden" name="equipamento_id" id="equipamento_id" style="width:50px;">
           <input type="hidden" name="periodo" id="periodo" style="width:50px;">
           <input type="hidden" name="valor_equipamento" id="valor_equipamento" style="width:50px;">
            <label>
            	Equipamento<br/>
                <input type="text" name="produto" id="produto" style="width:300px;" <?=$DisaPago?>  
                busca='modulos/aluguel/locacao_devolucao/busca_equipamento.php,@r1 @r6,@r0-value>equipamento_id|@r1-value>produto|@r2-value>qtd_disponivel|@r3-value>total|@r4-value>periodo|@r5-value>valor_equipamento'>
            </label>
            <label>
            Total<br/>
            	<input type="text" name="total" id="total" style="width:50px;" sonumero="1" maxlength="6" readonly="readonly" <?=$DisaPago?> >
            </label>
            <label>
            	Dispon&iacute;vel<br/>
            	<input type="text" name="qtd_disponivel" id="qtd_disponivel" style="width:50px;" sonumero="1" maxlength="6" readonly="readonly" <?=$DisaPago?> >
            </label>
            <label>
            	QTD<br/>
            	<input type="text" name="qtd_selecionada" id="qtd_selecionada" style="width:50px;" sonumero="1" maxlength="6" value="1" <?=$DisaPago?> >
            </label>
            <label style="margin-top:15px;">
            	<!--<button type="button" id="click_equipamento">Buscar</button>--> 
				<img src="../fontes/img/mais.png" id="click_equipamento">
            </label>
            <div style="clear:both"></div>
            <label id="id_label">
            
            </label>
            <div style="clear:both"></div>
            <!--<div style="max-height:100px; overflow:auto; width:100%; padding:0; margin:0; left:0;">-->
          	<table cellpadding="0" cellspacing="0" style="width:98%;">
                <thead>
                        <tr>
                          <td style="border-left:1px solid #CCC;">Descri&ccedil;&atilde;o Equipamento</td>
                          <td style="width:45px;">QTD</td>
                          <td style="width:35px;">Dias</td>
                          <td style="width:123px;">Valor/Periodicidade</td>
                          <td style="width:65px;">Valor Total</td>
                          <td style="width:45px;">A&ccedil;&atilde;o</td>
                        </tr>
               </thead>
			<!--</table>-->
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
			
            <!--<table cellpadding="0" cellspacing="0" width="100%" >-->
               
                <tbody id="tbody">
                	
                </tbody>
               
                <tbody>
                		<?php
						//echo $aluguel->id;
                        		$sql_item = mysql_query(" SELECT * FROM aluguel_locacao_itens WHERE locacao_id = '$aluguel->id'");
								while($item_locacao=mysql_fetch_object($sql_item)){
									$total++;
									if($total%2){$sel='class="al"';}else{$sel='';}
										$item_equipamento = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_equipamentos_itens WHERE  id ='$item_locacao->item_equipamento_id'"));
										$equipamento = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_equipamentos WHERE id = '$item_equipamento->equipamento_id'"));
										$TotalEquip += $item_locacao->valor_total; 
						?>
                		<tr <?=$sel?>>
                          <td style="border-left:1px solid #CCC;">
                          <!-- Aqui é o ID da TABELA aluguel_locacao_itens para exclusao do item -->
                          <input type="hidden" name="id_equip_update[]" id="id_equip_update" value="<?=$item_locacao->id?>" size="5">
                          <input type="hidden" name="id_item_equip[]" id="id_item_equip" value="<?=$item_locacao->item_equipamento_id?>" size="5">
						  <?=$equipamento->descricao.' - '.$item_equipamento->numero_serie?>
                          </td>
                          <td style="width:45px;">1</td>
                          <td><?=$aluguel->qtd_dias;?></td>
                          <td style="width:65px;">
						  <input type="hidden" name="val_item_update[]" id="val_item_update" value="<?=moedaUsaToBr($item_locacao->valor_unitario)?>" style="width:50px">
						  <?=moedaUsaToBr($item_locacao->valor_unitario)?> / <?=$equipamento->periodo?>
                          </td>
                          <td style="width:65px;">
						  <input type="hidden" name="val_total_item[]" id="val_total_item" style="width:50px" value="<?=moedaUsaToBr($item_locacao->valor_total)?>">
						  <?=moedaUsaToBr($item_locacao->valor_total)?>
                          </td>
                          <td style="width:45px;">
                          	<? if(empty($DisaPago)) {?>
                          			<img src="../fontes/img/menos.png" id="excluir_edit_equip" style="padding-left:4px;">
                          	<?  }?>
                          </td>
                        </tr>
                        <?php
								}
						?>
                </tbody>
                <thead>
            			<tr>
							  <td style="border-left:1px solid #CCC; padding-right:10px;" colspan="4" align="right"> Total R$ </td>
							  <td width="88">
                              <div id="total_locacao_table"><?=moedaUsaToBr($TotalEquip)?></div>
                              </td>
							  <td width="33" style="padding-left:3px;"></td>
						</tr>
                </thead> 
             </table>
             <!--</div>-->
             <div id="excluir_item_produto"></div>            
            
</fieldset>
<!-- ABA DEVOLUÇAO -->
<fieldset id="campos_3" style="display:none">
		  <legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <? if($sqlDevolucao->QtdLocacao > 0) {?>
            <a onclick="aba_form(this,2)"><strong>Devolu&ccedil;&atilde;o</strong></a>
            <? }?>
            <a onclick="aba_form(this,3)">Despesas</a>
            <a onclick="aba_form(this,4)">Contrato</a>
            <a onclick="aba_form(this,5)">Resumo</a>
          </legend>
          	<? if($aluguel->id > 0 and $aluguel->status_locacao == '1'){?>
          <input type="checkbox" name="todos" id="todos" value="<?=$aluguel->id?>"> Devolver Todos
          <? } ?>
          <table cellpadding="0" cellspacing="0" width="100%" id="devolucao">
                <thead>
                        <tr>
                          <td style="border-left:1px solid #CCC;">Descri&ccedil;&atilde;o Equipamento</td>
                          <td style="width:45px;">Status</td>
                          <td style="width:65px;">Valor</td>
                          <td style="width:65px;">Valor Total</td>
                          <td style="width:45px;">A&ccedil;&atilde;o</td>
                        </tr>
               </thead>
			<!--</table>-->
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
			
            <!--<table cellpadding="0" cellspacing="0" width="100%" >-->
                <tbody id="tbody">
                </tbody>
                <tbody>
                		<?php
						//echo $aluguel->id;
                        		$sql_item = mysql_query(" SELECT * FROM aluguel_locacao_itens WHERE locacao_id = '$aluguel->id'");
								while($item_locacao=mysql_fetch_object($sql_item)){
									$total++;
									if($total%2){$sel='class="al"';}else{$sel='';}
										$item_equipamento = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_equipamentos_itens WHERE  id ='$item_locacao->item_equipamento_id'"));
										$descricao = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_equipamentos WHERE id = '$item_equipamento->equipamento_id'"));
										$TotalEquipDev += $item_locacao->valor_total; 
						?>
                		<tr <?=$sel?>>
                          <td style="border-left:1px solid #CCC;">
                          <!-- Aqui é o ID da TABELA aluguel_locacao_itens para exclusao do item -->
                          <input type="hidden" name="id_equip_update[]" id="id_equip_update" value="<?=$item_locacao->id?>" size="5">
                          <input type="hidden" name="id_item_equip[]" id="id_item_equip" value="<?=$item_locacao->item_equipamento_id?>" size="5">
						  <?=$descricao->descricao.' - '.$item_equipamento->numero_serie?>
                          </td>
                          <td style="padding-left:5px" id="status_item">
                          		<?
                                	if($item_locacao->status_item == '1'){
										echo "Locado";  	
									} else{
									   echo "Devolvido";	
									}
								?>
                          </td>
                          <td style="width:65px;">
						  <input type="hidden" name="val_item_update[]" id="val_item_update" value="<?=moedaUsaToBr($item_locacao->valor_unitario)?>" style="width:50px">
						  <?=moedaUsaToBr($item_locacao->valor_unitario)?>
                          </td>
                          <td style="width:65px;">
						  <input type="hidden" name="val_total_item[]" id="val_total_item" style="width:50px" value="<?=moedaUsaToBr($item_locacao->valor_total)?>">
						  <?=moedaUsaToBr($item_locacao->valor_total)?>
                          </td>
                          <td style="padding-left:6px" id="acao_item">
                          	<?
                            	if($item_locacao->status_item == '1'){
							?>
                          	<a href="#" id="devolver"> Devolver </a>
                            <?
								}
							?>
                          </td>
                        </tr>
                        <?php
								}
						?>
                </tbody>
                <thead>
            			<tr>
							  <td style="border-left:1px solid #CCC; padding-right:10px;" colspan="3" align="right"> Total R$ </td>
							  <td width="88">
                              <div id="total_locacao_table"><?=moedaUsaToBr($TotalEquipDev)?></div>
                              </td>
							  <td width="33" style="padding-left:3px;"></td>
						</tr>
                </thead> 
                
                
             </table>
</fieldset>
<!-- ABA DESPESAS -->
<fieldset id="campos_4" style="display:none">
		  <legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <? if($sqlDevolucao->QtdLocacao > 0) {?>
            <a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>
            <? } ?>
            <a onclick="aba_form(this,3)"><strong>Despesas</strong></a>
            <a onclick="aba_form(this,4)">Contrato</a>
            <a onclick="aba_form(this,5)">Resumo</a>
          </legend>
          <input type="hidden" name="equipamento_id" id="equipamento_id" style="width:50px;">
           <input type="hidden" name="periodo" id="periodo" style="width:50px;">
           <input type="hidden" name="valor_equipamento" id="valor_equipamento" style="width:50px;">
            <label>
            	Despesas<br/>
                <input type="text" name="despesas" id="despesas" style="width:300px;" <?=$DisaPago?> >
            </label>
            <label>
            	QTD<br/>
            	<input type="text" name="qtd_despesa" id="qtd_despesa" style="width:50px;" sonumero="1" maxlength="6" value="1" <?=$DisaPago?>>
            </label>
            <label style="width:90px;">
            	Valor<br/>
            	<input type="text" name="valor_despesa" id="valor_despesa" style="width:80px;" decimal="2" maxlength="6" value="0,00" onfocus="$(this).val('')" onblur="if($(this).val()== ''){$(this).val('0,00')}" <?=$DisaPago?>>
            </label>
            <label style="margin-top:15px;">
            	<!--<button type="button" id="click_equipamento">Buscar</button>-->
            	<img src="../fontes/img/mais.png" id="click_despesa">
            </label>
            <div style="clear:both"></div>
            <label id="id_label">
            
            </label>
            <div style="clear:both"></div>
          	<table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td style="border-left:1px solid #CCC;">Descri&ccedil;&atilde;o Despesas</td>
                          <td style="width:45px;">QTD</td>
                          <td style="width:65px;">Valor</td>
                          <td style="width:65px;">Valor Total</td>
                          <td style="width:45px;">A&ccedil;&atilde;o</td>
                        </tr>
               </thead>
			<!--</table>-->
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
			
            <!--<table cellpadding="0" cellspacing="0" width="100%" >-->
                <!--<tbody id="tbody">
                </tbody>-->
                <tbody id="tbody_despesa">
                		<?php
						//echo $aluguel->id;
                        		$sql_custo= mysql_query(" SELECT * FROM aluguel_custos WHERE locacao_id = '$aluguel->id' ORDER BY id ASC");
								$total_d=0;
								while($custo_locacao=mysql_fetch_object($sql_custo)){
									$total++;
									if($total%2){$sel='class="al"';}else{$sel='';}
									
						?>
                		<tr <?=$sel?>>
                          <td style="border-left:1px solid #CCC;">
                         			<?=$custo_locacao->nome?>
                                    <input type='hidden' name='despesas_tbl[]' class='despesas_tbl' value="<?=$custo_locacao->nome?>">
                                    <input type='hidden' name='id_despesa[]' class='id_despesas' value="<?=$custo_locacao->id?>">
                          </td>
                          <td style="width:45px;">
						  	<?=$custo_locacao->qtd?>
                           	<input type='hidden' name='qtd_despesas[]' class='qtd_despesas' value="<?=$custo_locacao->qtd?>">
                           </td>
                          <td style="width:65px;">
						  	<?=moedaUsaToBr($custo_locacao->valor)?>			
                          	<input type='hidden' name='valor_despesa[]' class='valor_despesa' value="<?=$custo_locacao->valor?>">
                          </td>
                          <td style="width:65px;" class="valor_t">
						  	<?php
								$valor_total = $custo_locacao->qtd*$custo_locacao->valor;
                            	$total_d+=$valor_total;
								echo moedaUsaToBr($valor_total);
								
							?>
                            
                          </td>
                          <td style="width:45px;">
                            <? if(empty($DisaPago)){?>
                          	<img src="../fontes/img/menos.png" id="excluir_despesa" style="padding-left:4px;">
                          	<? }?>
                          </td>
                        </tr>
                        <?php
								}
						?>
                </tbody>
                <thead>
            			<tr>
							  <td style="border-left:1px solid #CCC; padding-right:10px;" colspan="3" align="right"> Total R$ </td>
							  <td width="88">
                              <div id="total_despesa_table"><?=moedaUsaToBr($total_d)?></div>
                              </td>
							  <td width="33" style="padding-left:3px;"></td>
						</tr>
                </thead> 
                
                
             </table>
             <div id="excluir_item_produto"></div>
</fieldset>
<!-- ABA CONTRATO -->
<fieldset id="campos_5" style="display:none">
<legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <? if($sqlDevolucao->QtdLocacao > 0) { ?>
            <a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>
            <? }?>
            <a onclick="aba_form(this,3)">Despesas</a>
            <a onclick="aba_form(this,4)"><strong>Contrato</strong></a>
            <a onclick="aba_form(this,5)">Resumo</a>
</legend>
<label>
<textarea name="texto" cols="80" rows="29" id="tx_html" style="display:none">
<?php
	
	if(!empty($aluguel->contrato)){
		$texto = $aluguel->contrato;

		echo $texto;
	}else{
		$contrato = mysql_fetch_object(mysql_query("SELECT * FROM aluguel_contrato WHERE id='$vkt_id'"));
		echo $contrato->contrato;
		
	}
?>
</textarea>
</label>
 <label style="width:40px">
<select name="select"class="in"style="margin-right:5px; w"onchange="ti('fontsize',this.options[this.selectedIndex].value)"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null)" href="#" class='btf bold'></a>
<a onclick="ti('italic',null)" href="#" class='btf italic'></a>
<a onclick="ti('underline',null)" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null)" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null)" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null)" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null)" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null)" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null)" href="#" class='btf insertorderedlist'></a>

<div style="clear:both"></div>
 <iframe id='ed' name='ed' width="75%" style="height:345px; background:#FFF;  overflow:scroll" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0" class="edtx"></iframe>
 <div id="esquerda" style="float:right;overflow:auto">
        	<a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cpf</strong></a>
</div>
<div style="clear:both"></div> 
<?
if($aluguel->id > 0){
		echo "<input type='button' value='Imprimir Contrato' onclick=\"window.open('modulos/aluguel/locacao_devolucao/impressao_contrato.php?id=$aluguel->id','_BLANK')\"/>";
}
?>
</fieldset>
<!-- ABA RESUMO -->
<fieldset id="campos_6" style="display:none">
		<legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <? if($sqlDevolucao->QtdLocacao > 0) { ?>
            <a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>
            <? }?>
            <a onclick="aba_form(this,3)">Despesas</a>
            <a onclick="aba_form(this,4)">Contrato</a>
            <a onclick="aba_form(this,5)"><strong>Resumo</strong></a>              
          </legend>
           <label>
           		<?
                	$valTotalEquip = mysql_fetch_object(mysql_query("SELECT SUM(valor_total) AS TotalEquip  FROM   aluguel_locacao_itens WHERE locacao_id = '".$aluguel->id."'"));
					$TotalGeral = $valTotalEquip->TotalEquip;
				?>
          		Total Equipamento<br/>
                	<div id="TotalEquipamentoView" style="font-weight:bold; padding-left:5px; margin-left:3px; padding:5px;"><?=moedaUsaToBr($valTotalEquip->TotalEquip)?></div>
                	<input type="hidden" name="TotalEquipamento" id="TotalEquipamento" readonly="readonly" value="<?=moedaUsaToBr($valTotalEquip->TotalEquip)?>">
          </label>
          <div style="clear:both"></div>
          <?
          		$valTotalDespesa = mysql_fetch_object(mysql_query("SELECT SUM(valor) AS ValDespesa  FROM aluguel_custos WHERE locacao_id = '".$aluguel->id."'"));
		  ?>
          <div style="clear:both"></div>
          <?
		 		/* Para gerar o valor de Porcentagem*/
				if($TotalGeral > 0){
				$porcentDesconto = ($aluguel->desconto) / ($TotalGeral); 
				$PorcetVal = ($porcentDesconto  * 100);
				}
			
		  ?>
          <label style="width:80px;">
          	(-)Descontos<br/>
            	<input type="text" name="desconto" id="desconto" decimal="2" maxlength="14" value="<?=moedaUsaToBr($aluguel->desconto);?>" <?=$disabled?>>
          </label>
          <label><br/>
          	<input type="text" name="descontoPorcentagem" id="descontoPorcentagem" style="width:40px;" maxlength="5" decimal="2" value="<?=moedaUsaToBr($PorcetVal);?>" >%
          </label>
           <div style="clear:both"></div>
          <label style="width:80px;">
          	(+)Acrescimo<br/>
            	<input type="text" name="acrescimo" id="acrescimo" decimal="2" maxlength="14" value="<?
                	if($aluguel->acrescimo > 0){
							echo moedaUsaToBr($aluguel->acrescimo);
					}
				?>" <?=$disabled?>>
          </label>
          <div style="clear:both"></div>
          <label>
          	<strong>Subtotal</strong><br/>
            <span id="TotalGeralView" style="padding-left:5px; margin-left:3px"><?=moedaUsaToBr($TotalGeral);?></span>
          </label>
          <div style="clear:both;"></div>
          <label>
          <?
             		$TotalAluguel = ($aluguel->valor_total + $aluguel->acrescimo) - $aluguel->desconto;
		  ?>
          	<strong>Total</strong><br/>
            	<span id="ValTotalAluguel" style="padding-left:5px; margin-left:3px"><?=moedaUsaToBr($TotalAluguel);?></span>
                <!-- Aqui está sendo representado por Sub-Total -->
            	<input type="hidden" name="TotalAluguel" id="TotalAluguel" readonly="readonly" value="<?=moedaUsaToBr($TotalAluguel);?>">
                <!-- Aqui está sendo representado por Total-Geral -->
                <input type="hidden" name="TotalGeral" id="TotalGeral" readonly="readonly" value="<?=moedaUsaToBr($aluguel->valor_total);?>">
               
          </label>
          
          
</fieldset>
<!-- ABA PAGAMENTO -->
<?php $sqlConta = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_conta WHERE vkt_id = '$vkt_id'"));?>
<fieldset id="campos_7" style="display:none">
		<legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>
            <? if($sqlDevolucao->QtdLocacao > 0) {?>
            <a onclick="aba_form(this,3)">Despesas</a>
            <? } ?>
            <a onclick="aba_form(this,4)">Contrato</a>
            <a onclick="aba_form(this,5)">Resumo</a>
            <a onclick="aba_form(this,6)"> <strong>Pagamento</strong> </a>
          </legend>
          <!-- Qtd de parcelas do pagamento -->
          	<input type="hidden" name="QtdParcelaPg" id="QtdParcelaPg" value="<?=$aluguel->qpPagamento?>">
          <!-- ATENÇAO!! Aqui nao inserir o valida_minlength="1" porque esta via javascript -->
          <input type="hidden" name="ContaID" id="ContaID" value="<?=$sqlConta->id?>"  retorno='focus|Nao Existe Conta Cadastrada'>
          <!-- forma de pagamento -->
          <!--<div style="padding:5px;"><button type="button" name="importPg"  id="importPg">Importar Pagamento do Or&ccedil;amento</button></div>-->
          <div id="pg">
          <?
		  	if(!empty($aluguel->forma_pagamento)){
				$formaPagamento['forma_pagamento'] = $aluguel->forma_pagamento;	
			} else{
          	$formaPagamento = mysql_fetch_array(mysql_query(" SELECT * FROM financeiro_movimento WHERE doc = '".$aluguel->id."' AND cliente_id = '$vkt_id' AND internauta_id = '".$aluguel->cliente_id."'"));
			}
			
		  ?>
           <label style="width:120px;">Forma de Pagamento
        	<select name="forma_pagamento" id="forma_pagamento" <?=$DisaPago?>>
            	
                <option <? if($formaPagamento['forma_pagamento'] == '1'){echo 'selected="selected"';}?>value="1">Dinheiro</option>
                <option <? if($formaPagamento['forma_pagamento'] == '2'){echo 'selected="selected"';}?>value="2">Cheque</option>
                <option <? if($formaPagamento['forma_pagamento'] == '3'){echo 'selected="selected"';}?>value="3">Cart&atilde;o de Credito</option>
                <option <? if($formaPagamento['forma_pagamento'] == '4'){echo 'selected="selected"';}?>value="4">Boleto</option>
                <option <? if($formaPagamento['forma_pagamento'] == '5'){echo 'selected="selected"';}?>value="5">Permuta</option>
                <option <? if($formaPagamento['forma_pagamento'] == '6'){echo 'selected="selected"';}?>value="6">Transfer&ecirc;ncia</option>
                <option <? if($formaPagamento['forma_pagamento'] == '7'){echo 'selected="selected"';}?>value="7">Outros</option>
            </select>
        </label>
        <?
				$parcelas = mysql_fetch_object(mysql_query($y="SELECT COUNT(id) AS qtdParcelaOS FROM financeiro_movimento WHERE doc = '".$aluguel->id."' AND cliente_id = '$vkt_id' AND internauta_id = '".$aluguel->cliente_id."'"));
				//echo $y;
        		//$parcelas=mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM os_pagamento_parcela WHERE os_id = '".$reg_os->id."' AND vkt_id = '$vkt_id' "));
		?>
        <label>Parcelas<br/>          
   			<select name="parcelas" id="parcelas" <?=$DisaPago?>>
                <option value="0"></option>
            	<option <? if($parcelas->qtdParcelaOS == '1'){echo 'selected="selected"';}?>value="1">1 x</option>
                <option <? if($parcelas->qtdParcelaOS == '2'){echo 'selected="selected"';}?>value="2">2 x</option>
                <option <? if($parcelas->qtdParcelaOS == '3'){echo 'selected="selected"';}?>value="3">3 x</option>
                <option <? if($parcelas->qtdParcelaOS == '4'){echo 'selected="selected"';}?>value="4">4 x</option>
                <option <? if($parcelas->qtdParcelaOS == '5'){echo 'selected="selected"';}?>value="5">5 x</option>
                <option <? if($parcelas->qtdParcelaOS == '6'){echo 'selected="selected"';}?>value="6">6 x</option>
                <option <? if($parcelas->qtdParcelaOS == '7'){echo 'selected="selected"';}?>value="7">7 x</option>
                <option <? if($parcelas->qtdParcelaOS == '8'){echo 'selected="selected"';}?>value="8">8 x</option>
            </select>
            
        </label>
        <label style="width:150px;visibility:hidden;">
			Conta
			  <select name="conta_id" id="conta_id" >
					<option value='0'  >Selecione 1 Conta</option> 
              <?
              $q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
			  while($r= mysql_fetch_object($q)){
				$saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
				$saldo=number_format($saldo,2,',','.');
				if($obj->id>0){
					if($r->id==$obj->conta_id){$sel = "selected='selected'";}else{$sel = "";}
				}else{
					if($r->id==$sqlConta->conta_id){$sel = "selected='selected'";}else{$sel = "";}
				}
					echo "<option value='$r->id' $sel >$r->nome   $saldo</option>";  
				}
			  ?>
			    
		    </select>
        </label>
        <label style="width:120px;visibility:hidden;">
            
			Centro de Custos
			<select name="centro_custo_id[]" id=''>
              	<?
    
				exibe_option_sub_plano_ou_centro('centro',0,$sqlConta->centro_custo_id ,0);

				?>
              </select>
        </label>
        <label style="width:120px; visibility:hidden;">
			Plano de Conta
			<select name="plano_de_conta_id[]">
              	<?
					exibe_option_sub_plano_ou_centro('plano',0,$sqlConta->plano_conta_id,0);
				?>
              </select>
        </label>
        <!-- fim campos do pagamento -->
        <label>
        	
        </label>
         <div style="clear:both"></div>
        <label style="border-bottom:1px solid #C9C9C9; width:360px; display:none; padding:3px" id="titulo_parcela">Informa&ccedil;&otilde;es da Parcela:</label>
        
        <div style="clear:both"></div>
        <!--<div id="info_parcela_1" style="float:left;"></div>-->
        <div style="clear:both;"></div>
        <div id="info_parcela" style="float:left; max-height:150px; width:420px; overflow:auto"></div>
        <!--<div style="float:left;" id="ParcelasData"></div>-->
        <div style="clear:both;"></div>
        
        <? if ($parcelas->qtdParcelaOS > 0) {?>
        <label style="border-bottom:1px solid #C9C9C9; width:390px; display:block; padding:3px" id="tableDescricaoParcela">Detalhes da Parcela:</label>
        <div style="clear:both;"></div>
        
        <div>
        	<table cellpadding="0" cellspacing="0" width="55%" >
                <thead>
                        <tr >
                          <td width="300" style="border-left:1px solid #CCC;">Descri&ccedil;&atilde;o</td>
                          <td width="140">Vencimento</td>
                          <td width="160">Valor Parcela</td>
                          <td width="70">Status</td>
                        </tr>
               </thead>
               <tbody>
               <?
               		$sql = mysql_query(" SELECT * FROM financeiro_movimento WHERE doc = '".$aluguel->id."' AND cliente_id = '$vkt_id' ORDER BY data_vencimento ");				
						while($item_parcela=mysql_fetch_object($sql)){
							$totalAluguel += $item_parcela->valor_cadastro;
							$cor++;
							if($cor%2){$sel='class="al"';}else{$sel='class="odd"';}
			   ?>
               			<tr <?=$sel?>>
                          <td style="border-left:1px solid #CCC;" width="300"><?=$item_parcela->descricao?></td>
                          <td width="140"><?=dataUsaToBr($item_parcela->data_vencimento)?></td>
                          <td width="160"><?=moedaUsaToBr($item_parcela->valor_cadastro)?></td>
                          <td width="70">
						  	<?
                          		if($item_parcela->status == '0')
									echo 'N&atilde;o Pago';
								else if($item_parcela->status == '1')
									echo 'Pago'
						  	?>
                          </td>
                        </tr>
               <?
						}
			   ?>
               </tbody>
               <thead>
                        <tr>
                          <td colspan="2" style="padding-right:8px" align="right">Total</td>
                          <td><?=moedaUsaToBr($totalAluguel)?></td>
                          <td></td>
                        </tr>         
               </thead>
           </table>
        </div>
        <? }?>
</fieldset>
<!-- ABA CANCELAMENTO -->
<fieldset id="campos_8" style="display:none">
		<legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>
            <? if($sqlDevolucao->QtdLocacao > 0) {?>
            <a onclick="aba_form(this,3)">Despesas</a>
            <? } ?>
            <a onclick="aba_form(this,4)">Contrato</a>
            <a onclick="aba_form(this,5)">Resumo</a>
            <!--<a onclick="aba_form(this,6)"> <strong>Pagamento</strong> </a>-->
            <a onclick="aba_form(this,7)"> <strong>Cancelar</strong> </a>
          </legend>
          <label> 
          		Motivo
                <textarea name="motivoCancelamento" id="motivoCancelamento"></textarea>
          </label>
</fieldset>

<div style="width:100%; text-align:center; " >
<?
if($aluguel->pago == 'sim'){
	echo "<a href='#' style='float:left;' id='ExInfoPg'>Informa&ccedil;&otilde;es Pagamento</a>";
	//echo '<input type="button" value="Enviar por E-mail" style="float:left;" onclick="aba_form(this,4)">';
	/*echo '<input type="button" name="aprovar" id="aprovar" value="Aprova&ccedil;&atilde;o" style="float:left" onclick="aba_form(this,5)">';
	echo '<input type="button" value="Cancelamento" id="cancelamento" style="float:left;" onclick="">';*/
	//echo '<input type="button" value="Pagamento" id="pagamento" style="float:left;" onclick="">';
}
if($aluguel->pago != 'sim' and $aluguel->id != 0){
	echo '<input type="button" name="pagamento" id="pagamento" value="Pagamento" style="float:left;">';
	echo '<button type="button" name="CancelaAlg" id="CancelaAlg" style="float:left;">Cancelamento</button>';	
}
 
if($aluguel->id == 0){
		echo '<div style="float:left"><input type="checkbox" name="imprimir_ok" id="imprimir_ok" checked="checked" value="1">Imprimir ap&oacute;s cadastro</div>'; 
}
if($aluguel->id > 0){
?>
<!--<input name="action" type="submit" value="Excluir" style="float:left" />-->
<!--<input type="button" value="Imprimir Orçamento" onclick="window.open('modulos/aluguel/orcamento/impressao_orcamento.php?id=<?=$aluguel->id?>','_BLANK')" />-->
<input type="button" value="Imprimir" onclick="window.open('modulos/aluguel/locacao_devolucao/impressao_locacao.php?id=<?=$aluguel->id?>','_BLANK')" />
<?
}

?>

<input name="action" type="button" id='botao_salvar' onclick="html_to_form(); setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500)" <?=$DisaPago?>  value="Salvar" style="float:right; display:inline"  />
<div style="float:right;" id="info_add">
</div>
<div style="clear:both"></div>
</div>
<input name="salva_formulario_contrato_aluguel" type="hidden" value="1" />
</form>
</div>
</div>
</div>
<script>top.openForm()</script>