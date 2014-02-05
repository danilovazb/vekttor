<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
$display_reserva = 'none';
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:830px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    <span>Loca&ccedil;&atilde;o</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$aluguel->id?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		 <legend>
            <a onclick="aba_form(this,0)"> <strong>Loca&ccedil;&atilde;o</strong></a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
         	<!--<a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>-->
            <a onclick="aba_form(this,2)">Despesas</a>
            <a onclick="aba_form(this,3)">Contrato</a>
          </legend>
          <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$aluguel->cliente_id?>">
           
          	
           
          <div style="clear:both; padding-top:5px;"></div>
		  <label style="width:311px;">
			Cliente
			  <input type="text" id='cliente' busca="modulos/aluguel/locacao_devolucao/busca_cliente.php,@r1 @r2,@r0-value>cliente_id|@r1-value>cliente" autocomplete='off' name="cliente" maxlength="44"  valida_minlength="3"  retorno='focus|Coloque no minimo 3 caracter' value="<?=$cliente->razao_social?>" />
		</label>
        <label>Descriçao<br/>
        	<input type="text" name="descricao" id="descricao" style="width:310px;" value="<?=$aluguel->descricao?>">
        </label>
       
        <label style="width:100px">Data Loca&ccedil;&atilde;o<br/>
        	<input type="text" name="data_locacao" id="data_locacao" value="<? 
			if($aluguel->data_locacao){ echo dataUsaToBr($aluguel->data_locacao);}
			else{ echo date("d/m/Y");}
			?>" calendario="1" />
        </label>
         <label>Data Devolu&ccedil;&atilde;o<br/>
        	<input type="text" name="data_devolucao" id="data_devolucao" calendario="1" mascara="__/__/____" style="width:70px;" value="<? if($aluguel->data_devolucao){ echo dataUsaToBr($aluguel->data_devolucao); }?>">
        </label>
        <label>
        Dias<br/>
        	<input type="text" name="dias" id="dias" style="width:50px" readonly="readonly" value="<?=$aluguel->qtd_dias?>">
        </label>
         <label id="aqui_reserva" style="display:<?=$display_reserva?>">Data Reserva<br/>
        	<input type="text" name="data_reserva" id="data_reserva" calendario="1" mascara="__/__/____" style="width:70px;" value="<? if($aluguel->data_reserva){echo dataUsaToBr($aluguel->data_reserva);}?>">
        </label>
        <label>Status Loca&ccedil;&atilde;o<br/>
        	<select name="status_locacao" id="status_locacao" disabled="disabled">
            	<option <? if($aluguel->status_locacao == '1'){echo 'selected="selected"';}?>value="1">Or&ccedil;amento</option>
              
            </select>
        </label>
        <label>
        Valor Total R$<br/>
        	<input type="text" name="valor_total" id="valor_total" style="width:100px;" readonly="readonly" value="<?=moedaUsaToBr($aluguel->valor_total)?>">
        </label>
        <div style="clear:both"></div>
        <label style="width:120px;">Forma de Pagamento
        	<select name="forma_pagamento" id="forma_pagamento">
            	<option value="0">Selecione</option>
                <option <? if($aluguel->forma_pagamento == '1'){echo 'selected="selected"';}?>value="1">Dinheiro</option>
                <option <? if($aluguel->forma_pagamento == '2'){echo 'selected="selected"';}?>value="2">Cheque</option>
                <option <? if($aluguel->forma_pagamento == '3'){echo 'selected="selected"';}?>value="3">Cart&atilde;o de Credito</option>
            </select>
        </label>
        
        <!--<label style="width:100px;">
        Pago
        	<select name="pago" id="pago">
            	<option value="0">Selecione</option>
                <option <? if($aluguel->pago == 'sim'){echo 'selected="selected"';}?>value="sim">Sim</option>
                <option <? if($aluguel->pago == 'nao'){echo 'selected="selected"';}?>value="nao">N&atilde;o</option>
            </select>
        </label>
        
        
        <label style="width:350px;">Observa&ccedil;&atilde;o Pagamento
        	<input type="text" name="obs_pagamento" id="obs_pagamento" style="width:350px;" value="<?=$aluguel->obs_pagamento?>">
        </label>-->
        <div style="clear:both"></div>
        <label>
        Oberva&ccedil;&atilde;o Loca&ccedil;&atilde;o <br/>
        	<textarea name="obervacao_locacao" id="obervacao_locacao" cols="35" rows="10"><?php echo $aluguel->obervacao_locacao?></textarea>
        </label>
        <label>
       Oberva&ccedil;&atilde;o Devolu&ccedil;&atilde;o <br/>
        	<textarea name="observacao_devolucao" id="observacao_devolucao" cols="35" rows="10"><?php echo $aluguel->observacao_devolucao?></textarea>
        </label>
	</fieldset>
<!--Fim dos fiels set-->
<fieldset id="campos_2" style="display:none">
		  <legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)"><strong>Equipamento</strong></a>
            <!--<a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>-->
            <a onclick="aba_form(this,2)">Despesas</a>
            <a onclick="aba_form(this,3)">Contrato</a>
          </legend>
           <input type="hidden" name="equipamento_id" id="equipamento_id" style="width:50px;">
           <input type="hidden" name="periodo" id="periodo" style="width:50px;">
           <input type="hidden" name="valor_equipamento" id="valor_equipamento" style="width:50px;">
            <label>
            	Equipamento<br/>
                <input type="text" name="produto" id="produto" style="width:300px;" 
                busca='modulos/aluguel/locacao_devolucao/busca_equipamento.php,@r1 @r6,@r0-value>equipamento_id|@r1-value>produto|@r2-value>qtd_disponivel|@r3-value>total|@r4-value>periodo|@r5-value>valor_equipamento'>
            </label>
            <label>
            Total<br/>
            	<input type="text" name="total" id="total" style="width:50px;" sonumero="1" maxlength="6" readonly="readonly">
            </label>
            <label>
            	Dispon&iacute;vel<br/>
            	<input type="text" name="qtd_disponivel" id="qtd_disponivel" style="width:50px;" sonumero="1" maxlength="6" readonly="readonly">
            </label>
            <label>
            	QTD<br/>
            	<input type="text" name="qtd_selecionada" id="qtd_selecionada" style="width:50px;" sonumero="1" maxlength="6" value="1">
            </label>
            <label style="margin-top:15px;">
            	<!--<button type="button" id="click_equipamento">Buscar</button>-->
            	<img src="../fontes/img/mais.png" id="click_equipamento">
            </label>
            <div style="clear:both"></div>
            <label id="id_label">
            
            </label>
            <div style="clear:both"></div>
          	<table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td style="border-left:1px solid #CCC;">Descri&ccedil;&atilde;o Equipamento</td>
                          <td style="width:45px;">QTD</td>
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
										$status='';
										if($item_equipamento->status==2){
											$status='Locado';
										}
										$descricao = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_equipamentos WHERE id = '$item_equipamento->equipamento_id'"));
						?>
                		<tr <?=$sel?>>
                          <td style="border-left:1px solid #CCC;">
                          <!-- Aqui é o ID da TABELA aluguel_locacao_itens para exclusao do item -->
                          <input type="hidden" name="id_equip_update[]" id="id_equip_update" value="<?=$item_locacao->id?>" size="5">
                          <input type="hidden" name="id_item_equip[]" id="id_item_equip" value="<?=$item_locacao->item_equipamento_id?>" size="5">
						  <?=$descricao->descricao.' - '.$item_equipamento->numero_serie.' - '.$status?>
                          </td>
                          <td style="width:45px;">1</td>
                          <td style="width:65px;">
						  <input type="hidden" name="val_item_update[]" id="val_item_update" value="<?=moedaUsaToBr($item_locacao->valor_unitario)?>" style="width:50px">
						  <?=moedaUsaToBr($item_locacao->valor_unitario)?>
                          </td>
                          <td style="width:65px;">
						  <input type="hidden" name="val_total_item[]" id="val_total_item" style="width:50px" value="<?=moedaUsaToBr($item_locacao->valor_total)?>">
						  <?=moedaUsaToBr($item_locacao->valor_total)?>
                          </td>
                          <td style="width:45px;">
                          	<img src="../fontes/img/menos.png" id="excluir_edit_equip" style="padding-left:4px;">
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
                              <div id="total_locacao_table"><?=moedaUsaToBr($aluguel->valor_total)?></div>
                              </td>
							  <td width="33" style="padding-left:3px;"></td>
						</tr>
                </thead> 
                
                
             </table>
             <div id="excluir_item_produto"></div>            
            
</fieldset>
<!--<fieldset id="campos_3" style="display:none">
		  <legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <a onclick="aba_form(this,2)"><strong>Devolu&ccedil;&atilde;o</strong></a>
            <a onclick="aba_form(this,3)">Despesas</a>
            <a onclick="aba_form(this,4)">Contrato</a>
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
               <!-- <tbody id="tbody">
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
						?>
                		<tr <?=$sel?>>
                          <td style="border-left:1px solid #CCC;">
                          <!-- Aqui é o ID da TABELA aluguel_locacao_itens para exclusao do item -->
                          <!--<input type="hidden" name="id_equip_update[]" id="id_equip_update" value="<?=$item_locacao->id?>" size="5">
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
                              <div id="total_locacao_table"><?=moedaUsaToBr($aluguel->valor_total)?></div>
                              </td>
							  <td width="33" style="padding-left:3px;"></td>
						</tr>
                </thead> 
                
                
             </table>
</fieldset>-->
<fieldset id="campos_4" style="display:none">
		  <legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <!--<a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>-->
            <a onclick="aba_form(this,2)"><strong>Despesas</strong></a>
            <a onclick="aba_form(this,3)">Contrato</a>
          </legend>
          <input type="hidden" name="equipamento_id" id="equipamento_id" style="width:50px;">
           <input type="hidden" name="periodo" id="periodo" style="width:50px;">
           <input type="hidden" name="valor_equipamento" id="valor_equipamento" style="width:50px;">
            <label>
            	Despesas<br/>
                <input type="text" name="despesas" id="despesas" style="width:300px;" 
                >
            </label>
            <label>
            	QTD<br/>
            	<input type="text" name="qtd_despesa" id="qtd_despesa" style="width:50px;" sonumero="1" maxlength="6" value="1">
            </label>
            <label>
            	Valor<br/>
            	<input type="text" name="valor_despesa" id="valor_despesa" style="width:50px;" decimal="2" maxlength="6" value="1">
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
                        		$sql_custo= mysql_query(" SELECT * FROM aluguel_custos WHERE locacao_id = '$aluguel->id' ORDER BY id DESC");
								$total_d=0;
								while($custo_locacao=mysql_fetch_object($sql_custo)){
									$total++;
									if($total%2){$sel='class="al"';}else{$sel='';}
									
						?>
                		<tr <?=$sel?>>
                          <td style="border-left:1px solid #CCC;">
                         			<?=$custo_locacao->nome?>
                                    <input type='hidden' name='despesas[]' class='despesas' value="<?=$custo_locacao->nome?>">
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
                          	<img src="../fontes/img/menos.png" id="excluir_despesa" style="padding-left:4px;">
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
<fieldset id="campos_5" style="display:none">
<legend>
            <a onclick="aba_form(this,0)"> Loca&ccedil;&atilde;o </a>
    		<a onclick="aba_form(this,1)">Equipamento</a>
            <!--<a onclick="aba_form(this,2)">Devolu&ccedil;&atilde;o</a>-->
            <a onclick="aba_form(this,2)">Despesas</a>
           <a onclick="aba_form(this,3)"><strong>Contrato</strong></a>
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
<div style="width:100%; text-align:center" >
<?
if($aluguel->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<input type="button" value="Imprimir" onclick="window.open('modulos/aluguel/locacao_devolucao/impressao_locacao.php?id=<?=$aluguel->id?>','_BLANK')" />
<input name="action" type="submit" id="locar" value="Realizar Locaçao"/>
<?
}

?>
<input name="action" type="button" id='botao_salvar' onclick="html_to_form(); setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500)"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
<input name="salva_formulario_contrato_aluguel" type="hidden" value="1" />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>