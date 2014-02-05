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
<div style="width:725px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Beneficiamento de Produtos</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" >
    <input type="hidden" name="produto_beneficiado_id" id="produto_beneficiado_id" value="<?=$pedido->produto_beneficiado_id?>">
    <input type="hidden" name="pedido_id" id="pedido_id" value="<?=$pedido->pedido_id;?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		
        <div>
		<label style="width:200px;">
			Produto Beneficiado<br>
            	<div style="margin-left:5px;"><strong><?=$pedido->nome?></strong></div>
        </label>
		
        <label>
        	QTD<br>
            <div><strong><?=moedaUsaToBr($pedido->qtd_pedido)?></strong></div>
             
        </label>
        
         <label>
        	Unidade<br/>
            <div style="margin-left:5px;"><strong><?=$pedido->unidade?></strong></div>
        </label>
        
        <label>
        	Data Pedido<br>
           <strong><?=dataUsaToBr($pedido->data_pedido);?></strong>
        </label><br>
        </div>
		<div style="clear:both"></div>
        <div>
        	 <label>
            		Aparas Kg<br/>
                    <input type="text"  name="aparas" id="aparas"  style="width:80px;" value="<?=moedaUsaToBr($pedido->aparas)?>" <?=$disable?>>
            </label>
             <label>
            		Descarte Kg<br/>
                    <input type="text"  name="descarte" id="descarte"  style="width:80px;" value="<?=moedaUsaToBr($pedido->descarte)?>" <?=$disable?>>
            </label>
        	<label>
            		Perda<br/>
                    <input type="text"  name="perda" id="perda" style="width:80px;" value="<?=moedaUsaToBr($pedido->perda)?>" <?=$disable?>>
            </label>
            <label>
            		Realizada<br/>
                    <input type="text"  name="qtd_realizada" id="qtd_realizada"  style="width:80px;" value="<?=moedaUsaToBr($pedido->qtd_realizada)?>" <?=$disable?>>
            </label>
            <div style="clear:both"></div>
            <label>
            		Desgelo<br/>
                    <input type="text"  name="desgelo" id="desgelo"  style="width:80px;" value="<?=moedaUsaToBr($pedido->desgelo)?>" <?=$disable?>>
            </label>
            <label style="width:150px;" valida_minlength="1" retorno="focus|Selecione uma Unidade">
              Almoxarifado
              <select id="almoxarifado_id_filt" name="almoxarifado_id_filt" <?=$disable?>>
              <option value="">Selecione uma Unidade</option>
             
              <? 
              $almoxarifados_q=mysql_query($t="SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY id ASC"); 
              while($almoxarifado=mysql_fetch_object($almoxarifados_q)){
              ?>
                  <option value="<?=$almoxarifado->id?>" <? if(isset($_POST['almoxarifado_id_filt'])&&$_POST['almoxarifado_id_filt']==$almoxarifado->id){echo "selected=selected";}?>><?=$almoxarifado->nome?></option>
              <? } ?>
              </select>
          </label>
            <div style="clear:both"></div>
            <label>
         		<strong>Obs Envio:</strong><br>
                <div style="width:150px;"><?=$pedido->obs?></div>
       		</label>
            <label>
            	<strong>Obs Recebimento</strong>
                <input type="text" name="obs_recebimento" id="obs_recebimento" value="<?=$pedido->obs_recebimento?>" <?=$disable?>>
            </label>
           
        </div>
        
        <div style="clear:both"></div>
		<div id="result_beneficiado"></div>

	<div style="margin-top:23px;"></div>
  
   <div style="display:block">
      <table cellpadding="0" cellspacing="0" width="625">
        <thead>
            <tr >
                <td width="200" style="border-left:1px solid #CACACA">Produto</td>
                <td width="35">QTD</td>
                <td width="55">Realizado</td>
                <td width="130">Obs Item</td>
            </tr>
        </thead>
     </table>
    <table cellpadding="0" cellspacing="0" width="625" >
            <tbody id="result_derivado">
            	<?php
                		while($itens=mysql_fetch_object($item)){
				?>
                <tr>
                    <td width="200" style="border-left:1px solid #CACACA"><?=$itens->nome?></td>
                    <td width="35"><input type="hidden" name="item_id" id="item_id" value="<?=$itens->item_id?>">
						<?=moedaUsaToBr($itens->qtd_pedida)." ".substr($itens->unidade_embalagem,0,2)?>
                    </td>
                    <td width="55"><input  style="height:10px;font-size:11px;" size="5" type="text" name="qtd_realizado" id="qtd_realizado" value="<?=moedaUsaToBr($itens->qtd_realizada)?>" <?=$disable?>> <?=substr($itens->unidade_embalagem,0,2)?></td>
                    <td width="130"><input type="text" lang="<?=$itens->produto_id?>" name="obs_item" id="obs_item" style="height:14px; width:124px;" value="<?=$itens->obs_recebimento?>" <?=$disable?>></td>
                </tr>
                <?
						}
				?>
    		</tbody>
	</table>
   <!--<input type="hidden" name="produto_derivado_id" id="produto_derivado_id">     
        <label style="width:250px;">
			Produto Derivado
			<input type="text" name="produto_derivado" id="produto_derivado"  value="" busca='modulos/estoque/beneficiamento/busca_produtos.php,@r0,@r1-value>produto_derivado_id,0'>
        </label>
        <label>
			QTD
			<input type="text" name="qtd_derivado" id="qtd_derivado"  size="2"/>
        </label>
        <label>
			Obs:
			<input type="text" name="obs_derivado" id="obs_derivado"  size="15"/>
        </label>
       
  
      <img src="../fontes/img/mais.png"  width="18" height="18" style=" margin-top:20px" id="derivado_mais"  /> -->
      
    </div> <br />
    <div id="derivado_produto"></div>
    <div id="result_derivado"></div>			
	</fieldset>	
<!--Fim dos fiels set-->

<div>
<input  type="submit"  value="Imprimir" onclick="window.open('modulos/estoque/beneficiamento/impressao_pagina.php?produto_id=<?=$pedido->produto_beneficiado_id?>&pedido_id=<?=$pedido->pedido_id?>&beneficiamento_id=<?=$beneficiamento_id?>','_BLANK')" />
<? if($pedido->status==1){?>
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