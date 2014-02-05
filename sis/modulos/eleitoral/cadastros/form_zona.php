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
    
    <span>Zona/Secao</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Zona/Secao</strong>
		</legend>
        <label style="width:40px">
   		Zona<input type="text" name="zona" id="zona" value="<?=$zona_q->zona?>">
    	</label>
        <label style="width:40px">
   		Secao<input type="text" name="secao" id="secao" value="<?=$zona_q->secao?>">
    	</label>
        <div style="clear:both"></div>
         <label style="width:300px">
   		Local<input type="text" name="local" id="local" value="<?=$zona_q->local?>">
    	</label>
    <input name="idzona" type="hidden" value="<?=$zona_q->id?>" />
	
<!--Fim dos fiels set-->
</fieldset>
<div style="width:100%; text-align:center" >
<?
if($zona_q->id>0){
?>
<input name="actionzona" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="actionzona" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>