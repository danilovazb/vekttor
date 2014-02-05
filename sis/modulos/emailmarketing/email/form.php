<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:450px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>EmailMarketing</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>EmailMarketing</strong>
		</legend>
        
		<label style="width:300px;">
        	Nome
			<input type='text' name="nome" id="nome" value="<?=$lista->nome?>" retorno="focus|Digite o Nome da Lista" valida_minlength='3'>
		</label >
        <div style="clear:both"></div>
                
        <div style="clear:both"></div>
        <label style="width:300px;">
			Observação
            <textarea name="observacao"><?=$lista->observacao?></textarea>
        </label >
  
       
	</fieldset>
	<input name="id" id="id" type="hidden" value="<?=$lista->id?>" />
	
<!--Fim dos fiels set-->
<?
	if($lista->id>0){
?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
<?
	}
?>

<div style="width:100%; text-align:center" >
<input name="action" type="submit" id='action' value="Salvar"  style="float:right;"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>
top.openForm();

</script>