<?
include("../../../_functions_base.php");
?><link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />


<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="$('#<?=$_GET[linhan]?>').find('.qtd').focus();form_x(this)"></a>
    
    <span>Fatores de Conversão</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Fatores de Conversão</strong>
		</legend>
       
		<div style="float:left;margin-bottom:20px;">
        <strong>Produto: </strong> <?=$_GET[produto_nome]?>
        </div>
        
        <div style="clear:both"></div>
        
        <div style="float:left;min-width:40px;max-width:70px;">
        <?=$_GET[unidade_compra]?>
        </div>
        <label style="width:70px;">
        	<input type="text" name="fator_conversao1" id="fator_conversao1" value="<?=qtdUsaToBr($_GET[fator1])?>"/>
       	</label>
        
        <div style="float:left;min-width:40px;max-width:70px;">
        <?=$_GET[unidade_embalagem]?>
        </div>
        <label style="width:70px;">
        	<input type="text" name="fator_conversao2" id="fator_conversao2" value="<?=qtdUsaToBr($_GET[fator2])?>"/>
       	</label>
        
        <div style="float:left;min-width:40px;max-width:70px;">
        <?=$_GET[unidade_uso]?>
        </div>
        
       </fieldset>
    <input name="linhan" id="linhan" type="hidden" value="<?=$_GET[linhan]?>" />


<style type="text/css">
.add_sub{ margin-top:2px; margin-bottom:2px; height:18px; width:18px;}
.n{ font-weight:bold;}
</style>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>