<?
include("../../../_config.php");
include("../../../_functions_base.php");
include("../../../modulos/financeiro/_functions_financeiro.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
input,textarea{ display:block;}
tbody tr{ background:#999;}
</style>

<div>
<div id='aSerCarregado'>
<div style="width:700px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Aprova&ccedil;&atilde;o e Pagamento</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" id="form_compras_pagamento" method="post" enctype="multipart/form-data">
    <input name="id" id="id" type="hidden" value="<?=$compra_id?>" />
    <input type="hidden" name="cliente_id" value="10">
    <input type="hidden" name="fornecedor_id"  id="fornecedor_id" value="<?=$fornecedor_id?>" />
    <input type="hidden" name="compra_id" value="<?=$compra_id?>">
     <input type="hidden" name="nro_nota_fiscal" id="nro_nota_fiscal" value="<?=$_GET['nro_nota_fiscal']?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend><strong>Pagamento</strong></legend>
        <div style="clear:both;"></div>    
		<!--<label style="width:150px;">
			Conta
			  <select name="conta_id" id="conta_id">
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
        </label>-->
        <label style="width:120px;">
            
			Centro de Custos
			<select name="centro_custo_id[]" id=''>
              	<?
				exibe_option_sub_plano_ou_centro('centro',0,$sqlConta->centro_custo_id,0);
				?>
              </select>
        </label>
        <label style="width:120px;">
			Plano de Conta
			<select name="plano_de_conta_id[]">
              	<?

			exibe_option_sub_plano_ou_centro('plano',0,$sqlConta->plano_conta_id,0);

				?>
              </select>
        </label>
	<div style="clear:both;"></div>
        <div style="padding:5px;">
		<label style="width:120px;">Forma de Pagamento
        	<select name="forma_pagamento" id="forma_pagamento">
                <option <? if($formaPagamento->forma_pagamento == '1'){echo 'selected="selected"';}?>value="1">Dinheiro</option>
                <option <? if($formaPagamento->forma_pagamento == '2'){echo 'selected="selected"';}?>value="2">Cheque</option>
                <option <? if($formaPagamento->forma_pagamento == '3'){echo 'selected="selected"';}?>value="3">Cart&atilde;o de Credito</option>
                <option <? if($formaPagamento->forma_pagamento == '4'){echo 'selected="selected"';}?>value="4">Boleto</option>
                <option <? if($formaPagamento->forma_pagamento == '5'){echo 'selected="selected"';}?>value="5">Permuta</option>
                <option <? if($formaPagamento->forma_pagamento == '6'){echo 'selected="selected"';}?>value="6">Transfer&ecirc;ncia</option>
                <option <? if($formaPagamento->forma_pagamento == '7'){echo 'selected="selected"';}?>value="7">Outros</option>
            </select>
        </label>
<label style="width:65px;">Valor
	
	<input type="text" name="valor_total[]" id="valor_total" value="<?php echo moedaUsaToBr(trim($total,'-'));?>" style="text-align:right;">
</label>
<label style="width:88px;" id="um_parcela">Primeira Parcela
    <input type="text" name="pri_parcela[]" id="pri_parcela" value="<?php echo date('d/m/Y');?>">
</label>
<label>Parcelas<br/>
	<select name="parcelas" id="parcelas" style="width:85px;">
        <option value="1">1x</option>
        <option value="2">2x</option>
        <option value="3">3x</option>
        <option value="4">4x</option>
        <option value="5">5x</option>
        <option value="6">6x</option>
        <option value="7">7x</option>
        <option value="8">8x</option>
    </select>
</label>
</div>

<div id="info_parcela"></div>

<div style="clear:both"></div>
<?php
	$status_compra = mysql_fetch_object(mysql_query("SELECT * FROM estoque_compras WHERE id='$compra_id'"));
	if($status_compra->status!='Finalizado'){
?>
<input type="checkbox" name="enviar_boleto_financeiro" id="enviar_boleto_financeiro" /> Não Enviar Boleto ao Financeiro
<?php
	}
?>
</fieldset>
<div style="display:none;" id="result_loading"><span><strong>Carregando...</strong></span></div>
<div id="result" style=" float:left;"></div>     	
<!--Fim dos fiels set-->
<div style="width:100%; text-align:center; height:20px;" id="btn_info" >
<!--<button type="button" onclick="window.open('modulos/ordem_servico/ordem_servico/rel_os.php?id=<?$reg_os->id?>','_BLANK')" style="float:left;">Imprimir Or&ccedil;amento </button>-->
<input type="button" style="float:left;" name="acao" value="Imprimir" onclick="window.open('modulos/estoque/compras/imprimir_compra.php?compra_id=<?=$compra_id?>',carregador)" />
<input type="hidden" name="action" id="action" value="MandarFinanceiro">
<button type="button" id='botao_salvar'  style="float:right"  />Enviar ao Financeiro e Finalizar</button>
<button type="button" id='botao_salvar2'  style="float:right;display:none"  />Finalizar</button>
</div>
<div style="clear:both"></div>
</form>
</div>
</div>
</div>
<script>
top.openForm();

</script>