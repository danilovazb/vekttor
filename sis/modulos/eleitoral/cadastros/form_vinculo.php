<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
print_r($_POST);
print_r($_GET);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Vinculos</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Vinculos</strong>
		</legend>
	<label style="80px">
   		PARENTESCO <input type="text" name="nome" value="<?=$vinculo_q->nome?>" />
	</label> 
    <div style="clear:both"></div>
    
    <input name="idvinculo" type="hidden" value="<?=$vinculo_q->id?>" />
	
<!--Fim dos fiels set-->
</fieldset>
<div style="width:100%; text-align:center" >
<?
if($vinculo_q->id>0){
?>
<input name="actionvinculo" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="actionvinculo" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>