<?
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
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
			<strong>Grupos Sociais</strong>
		</legend>
        <label style="width:300px">
   		Nome<input type="text" name="nome" id="nome" value="<?=$promocao->descricao?>">
    	</label>
        <div style="clear:both"></div>
     	<label style="width:300px">
   		Observacao<textarea name="obs" id="obs"><?=$promocao->obs?></textarea>
    	</label>
     <input name="id" type="hidden" value="<?=$promocao->id?>" />
	
<!--Fim dos fiels set-->
</fieldset>
<div style="width:100%; text-align:center" >
<?
if($promocao->id>0){
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