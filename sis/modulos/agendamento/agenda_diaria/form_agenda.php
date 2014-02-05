<?
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
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Agenda</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
    <input type="hidden" name="id"  value="<?=$id?>" />
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
		<label>Nome agenda
        	<input type="text" name="nome_agenda" id="nome_agenda" value="<?=$AgendaNome->nome?>">
        </label>
	</fieldset>
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($AgendaNome->id > 0){
?>
<input name="action" type="submit" value="Excluir Agenda" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Salvar Agenda" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>