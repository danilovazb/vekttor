<?
//Includes
// configuração inicial do sistema
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Aula</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Aula</strong>
		</legend>
        <input type="hidden" name="id" id="id" value="<?=$r->id?>">
        <input type="hidden" name="periodo_materia_id" value="<?=$_GET['periodo_materia']?>">
		<label style="width:311px;">Descriçao
		  <input type="text" id='descricao' name="descricao" value="<?=$r->descricao?>" autocomplete='off' maxlength="80"/>
		</label>
        <div style="clear:both;"></div>
        <label>
        	Data<br/>
            <input type="text" name="data_aula" id="data_aula" style="width:85px;" mascara="__/__/____" value="<?php if($data){ echo dataUsaToBr($data[0]);} else{ echo date('d/m/Y');}?>">
        </label>
	</fieldset>
	
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($r->id > 0){
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