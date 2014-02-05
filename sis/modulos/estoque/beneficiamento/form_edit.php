<?
print_r($_POST);
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
?>
<style>
input,select,textarea{display:block; }
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:750px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Beneficiamento de Produtos</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" >
    <input type="hidden" name="id_pedido" id="id_pedido" value="<?=$pedido->beneficiamento_id;?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	
    <fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		
        <div>
		<label style="width:250px;">
			Produto Beneficiado
			  <input <?=$readonly?>  name="produto_beneficiado" id="produto_beneficiado" value="<?=$pedido->nome?>" <?=$disable?>>
        </label>
		
        <label>
        	QTD
              <input type="text" name="qtd_produto_beneficiado" id="qtd_produto_beneficiado"  size="2"  maxlength="8" value="<?=moedaUsaToBr($pedido->qtd_pedido)?>" <?=$disable?>>
        </label>
        <label style="width:50px;">
        	Unidade
              <input <?=$readonly?> type="text" name="unidade_produto_beneficiado" id="unidade_produto_beneficiado" maxlength="8" value="<?=$pedido->unidade?>" <?=$disable?>>
        </label>
        <label>
        	Data
             <input <?=$readonly?> type="text" name="data_pedido" id="data_pedido"  size="3"  maxlength="8" value="<?=DataUsaToBr($pedido->data_pedido_beneficiamento)?>" <?=$disable?>>
        </label>
        
        <label>
        	<?php
            $item_compra = mysql_query($c="SELECT *,i.id as id_compra 
												FROM estoque_compras_item as i,
												estoque_compras as c,
												cliente_fornecedor cf 
														WHERE
															i.vkt_id='$vkt_id' AND
															c.fornecedor_id = cf.id AND  
															c.id=i.pedido_id AND
															i.produto_id = '$pedido->produto_beneficiado_id'
														");
            ?>
            
            	<label>Pedido
         					<select name="pedido_id" id="pedido_id" <?=$disable?>>
                            		<option value="0">Selecione</option>
                    				<?
                        				while($itens_pedido=mysql_fetch_object($item_compra)){
											
												if($itens_pedido->id_compra == $pedido->item_pedido_id){$sel='selected="selected"';$data_compra = $itens_pedido->data_inicio;$pedido_item=$itens_pedido->id_compra;}else{$sel='';}
												
									?>
                        
                  	<option  <?=$sel?> value="<?=$itens_pedido->id_compra?>"><?=$itens_pedido->pedido_id." - ".$itens_pedido->marca." ".$itens_pedido->razao_social?></option>
                    				<?
										}
					
									?>
                    		</select>
        
         				
                        </label>
        </label>
        <div id="info_pedido">                    
                          
                                    
                            <label id="cd_data" style="width:70px;">Data Pedido
                                <input type="text" size="6" name="data_pedido" id="data_pedido" value="<?=dataUsaToBr($data_compra)?>" <?=$disable?>>
                            </label><br><br/>
                            
                           
                                <input type="hidden" size="6" name="pedido_beneficiamento_id" id="pedido_beneficiamento_id" value="<?=$pedido_item?>">
                            
                        
                		</div>
         <!--<label>
        	Fornecedor
            	<input <?=$readonly?> type="text" name="pedido" id="pedido" value="<?=$fornecedor->razao_social?>">
        </label>
         <label>
        	Marca
            	<input type="text" name="marca" id="marca" size="5" value="<?=$pedido->marca?>">
        </label>
        <label>
        	Data Pedido<br>
            	<input type="text" name="data_pedido" id="data_pedido" style="width:80px;" value="<?=dataUsaToBr($pedido->data_pedido)?>">
        </label>-->
        
        <div style="clear:both"></div>
         <label id="teste_r">
         	Desperdicio % <br/>
            	<input type="text" name="desperdicio" id="desperdicio" style="width:80px;" value="<?=moedaUsaToBr($pedido->desperdicio)?>" sonumero="1" decimal="2" <?=$disable?>>
         </label>
         <label id="teste_r">
         	Saldo(Kg)  <br/>
            	<input type="text" name="saldo" id="saldo" style="width:80px;" value="<?=moedaUsaToBr($saldo)?>" sonumero="1" decimal="2" <?=$disable?>>
         </label>
        <div style="clear:both"></div>
         <label>
         	Obs Pedido
              <textarea name="obs_pedido" id="obs_pedido" <?=$disable?>><?=$pedido->obs?></textarea>
         </label><br/>
      
        </div>
        
        <div style="clear:both"></div>
		<div id="result_beneficiado"></div>
	<div>
    
    </div>
	<div style="margin-top:25px;"></div>
    <div style="display:block">
    	 <div style="display:block">
   <input type="hidden" name="produto_derivado_id" id="produto_derivado_id">     
        <label style="width:255px;">
			Produto Derivado
			<input type="text" name="produto_derivado" id="produto_derivado"  value="" busca='modulos/estoque/beneficiamento/busca_produtos.php,@r0,@r1-value>produto_derivado_id|@r2-value>unidade_produto_derivado|@r3-value>fatorconversao|@r4-value>conversao2,0' size="25" <?=$disable?>>
        </label>
        <label>
			QTD
			<input type="text" name="qtd_derivado" id="qtd_derivado"  size="2" <?=$disable?>/>
        </label>
        <label style="width:50px;">
        	Unidade
            <input type="text" name="unidade_produto_derivado" id="unidade_produto_derivado" readonly="readonly" maxlength="8" <?=$disable?>>
            <input type="hidden" name="fatorconversao" id="fatorconversao" readonly="readonly" maxlength="8">
            <input type="hidden" name="conversao2" id="conversao2" /> 
        </label>
        <label>
			Obs
			<input type="text" name="obs_derivado" id="obs_derivado"  size="22" <?=$disable?>/>
        </label>
       
  		<label><br/>
      		<div style="margin-top:3px;">
            <? if($status=='1'){?>
            	<img src="../fontes/img/mais.png"  width="18" height="18"  id="derivado_mais"  />
            <? }?>
            </div>
      	</label><br/>
    </div> <br /><br/>
        <div style="margin-top:2px;"></div>
  
      <div>
             <table cellpadding="0" cellspacing="0" width="640">
                <thead>
                    <tr>
                        <td width="200" style="border-left:1px solid #CACACA">Produto Derivado</td>
                        <td width="100">Quantia</td>
                        <td>Obs</td>
                        <td width="20"></td>
                    </tr>
                </thead>
             </table>
       </div>
     <div>
    <table cellpadding="0" cellspacing="0" width="640" >
            <tbody id="result_derivado">
            	<?php
						if(!empty($item))
							
                		while($itens=mysql_fetch_object($item)){
														
							$total_qtd_pedida +=$total_qtd_pedida_uso = $itens->qtd_pedida*$itens->conversao2;
							
				?>
                <tr>
                    <td width="200" style="border-left:1px solid #CACACA"><?=$itens->nome?></td>
                    <td width="100">
						<input type="hidden" name="item_id" id="item_id" value="<?=$itens->item_id?>">
						<?="<span class='qtd_pedida'>".moedaUsaToBr($itens->qtd_pedida)."</span> ".substr($itens->unidade_embalagem,0,2)." - <span class='qtd_pedida_uso'>
						".moedaUsaToBr($total_qtd_pedida_uso)."</span> $itens->unidade_uso"?>
                    </td>
                    <td>
					<?=$itens->obs_item_pedido?>
                   
                    </td>
                   <td width="20"><? if($status==1){?><a href="#" class="delete_item"><img src="modulos/estoque/transferencia/menos.png"></a><? } ?></td>
                </tr>
                <?
						}
						$qtd_restante_derivado = $saldo - $total_qtd_pedida;
				?>
    		</tbody>
	</table> 
      
    </div>
   <div>
           <table cellpadding="0" cellspacing="0" width="640">
              <thead>
                  <tr>
                      <td width="200" style="border-left:1px solid #CACACA"></td>
                      <td width="100" id="qtd_total_derivado"><?=moedaUsaToBr($total_qtd_pedida)?></td>
                      <td > Restante <span id="qtd_restante_derivado"><?=moedaUsaToBr($qtd_restante_derivado)?></span></td>
                      <td width="20"></td>
                  </tr>
              </thead>
           </table>
     </div>
       
    <div id="derivado_produto"></div>
    <div id="result_derivado"></div>			
	</fieldset>	
<!--Fim dos fiels set-->

<div>
<input type="button" value="Imprimir" onclick="window.open('modulos/estoque/beneficiamento/impressao_pagina.php?produto_id=<?=$produto_id?>&pedido_id=<?=$pedido_id?>&beneficiamento_id=<?=$beneficiamento_id?>','_BLANK')" />
<? if($status==1){?>
<button <?=$disable?> id="cancelar" type="button">Cancelar</button>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<? }?>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()
</script>