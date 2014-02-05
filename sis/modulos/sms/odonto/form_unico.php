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
<div style="width:400px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>SMS</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" id="form_odonto_sms" method="post" enctype="multipart/form-data">
    <input name="id" id="id" type="hidden" value="<?=$email->id?>" />
    <input type="hidden" name="cliente_id" id="cliente_id">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend><strong>Enviar SMS</strong></legend>
        <label style="width:285px;">Cliente
        	<input type="text" name="cliente" id="cliente" busca="modulos/odonto/buscas/busca_clientes.php,@r0,@r0-value>cliente|@r1-value>cliente_id|@r11-value>celular_unico,0">
        </label>
    	<div style="clear:both"></div>
        <label style="width:120px;">Celular
        	<input type="text" name="celular_unico" id="celular_unico" style="background:#F2F2F2; color:#999;" readonly >
        </label>
        <div style="clear:both"></div>
        <label>Mensagem 
  		<textarea name="msg_unica" id="msg_unica" cols="25" rows="5"><?=$sms_edit->msg?></textarea>
        </label>
	</fieldset>
<div style="display:none;" id="result_loading"><span><strong>Carregando...</strong></span></div>
<div id="result" style=" float:left;"></div>     	
<!--Fim dos fiels set-->
<div style="width:100%; text-align:center; height:20px;" id="btn_info" >
<input name="action" type="button" id='enviar_und_sms' value="Enviar" style="float:right"  />
</div>
<div style="clear:both"></div>
</form>
</div>
</div>
</div>
<script>
top.openForm();

</script>