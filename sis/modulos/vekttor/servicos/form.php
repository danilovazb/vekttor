<?php
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
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:450px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Servi&ccedil;os</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        <label style="width:108px;">C&oacute;digo
        	<input type="text" name="codigo" id="codigo" sonumero="1">
        </label>
		<label style="width:330px;">
        Descriçao
		<input type="text" name="descricao" valida_minlength="3" 
        retorno="focus|Digite no mínimo 3 caracteres no campo descriçao"
        value="<?=$servico->nome?>"/>
        </label>
        
               
        <label style="width:100px;" valida_minlength="1" 
        retorno="focus|Selecione uma unidade">
        Unidade
        <select name="unidade" id="unidade">
        	<option <? if($servico->und==''){echo 'selected=selected';}?>>Selecione</option>
            <option <? if($servico->und=='Fardo'){echo 'selected=selected';}?>>Fardo</option>
            <option <? if($servico->und=='Kg'){echo 'selected=selected';}?>>Kg</option>
            <option <? if($servico->und=='g'){echo 'selected=selected';}?>>g</option>
            <option <? if($servico->und=='Litro'){echo 'selected=selected';}?>>Litro</option>
            <option <? if($servico->und=='ml'){echo 'selected=selected';}?>>ml</option>
            <option <? if($servico->und=='Caixa'){echo 'selected=selected';}?>>Caixa</option>
            <option <? if($servico->und=='Unidade'){echo 'selected=selected';}?>>Unidade</option>
            <option <? if($servico->und=='Saco'){echo 'selected=selected';}?>>Saco</option>
            <option <? if($servico->und=='Pacote'){echo 'selected=selected';}?>>Pacote</option>
            <option <? if($servico->und=='Lata'){echo 'selected=selected';}?>>Lata</option>
            <option <? if($servico->und=='Metro'){echo 'selected=selected';}?>>Metro</option>
            <option <? if($servico->und=='m2'){echo 'selected=selected';$displayund="block";}?> value="m2">m2</option>
        </select>
		</label>
        
            
        <label style="width:80px;">
        Valor
		<input type="text" name="vl_normal" decimal="2" valida_minlength="1" 
        retorno="focus|Digite um valor no campo Valor Normal"
        value="<?=moedaUsaToBr($servico->valor_normal)?>"/>
        </label>
        
        <label style="width:100px;">
        Valor Colaborador
		<input type="text" name="vl_colaborador" decimal="2" valida_minlength="1" 
        retorno="focus|Digite um valor no campo Valor Colaborador"
        value="<?=moedaUsaToBr($servico->valor_colaborador)?>"/>
        </label>
        <div style="clear:both"></div>
        <label style="width:115px;">
        Tempo de Execuçao
		<input type="text" name="tempo_execucao" mascara="__:__" valida_minlength="1" 
        retorno="focus|Digite um valor no campo Tempo de Execuçao"
        value="<?=substr($servico->tempo_execucao,0,5);?>"/>
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:330px;">
        Observaçao
		<textarea name="obs"><?=$servico->observacao?></textarea>
        </label>
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$servico->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($servico->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>