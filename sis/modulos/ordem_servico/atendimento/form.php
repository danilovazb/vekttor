<?php
//Includes
// configura��o inicial do sistema
include("../../../_config.php");
// fun��es base do sistema
include("../../../_functions_base.php");
// fun��es do modulo empreendimento
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
    
    <span>Atendimento</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        
		<label style="width:330px;">
        Descri�ao
		<input type="text" name="descricao" valida_minlength="3" 
        retorno="focus|Digite no m�nimo 3 caracteres no campo descri�ao"
        value="<?=$atendimento->descricao?>"/>
        </label>
        
          
        <div style="clear:both"></div>
        
        <label style="width:330px;height:100px;">
        Observa�ao
		<textarea name="observacao" rows="5"><?=$atendimento->observacao?></textarea>
        </label>
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$atendimento->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($atendimento->id > 0){
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