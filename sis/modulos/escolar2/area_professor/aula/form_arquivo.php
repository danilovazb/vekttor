<?
//Includes
// configuração inicial do sistema
include("../../../../../_config.php");
// funções base do sistema
include("../../../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Upload</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data" target="carregador">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
    <input type="hidden" value="myForm" name="<?php echo ini_get("session.upload_progress.name"); ?>">

	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es do Arquivo</strong>
		</legend>
		<label style="width:311px;">Arquivo<br/>
		 	<input type="file" name="file">
		</label>
        <label>
        	<div id="barra">
            	<div id="barra_progresso"></div>
            </div>
        </label>
        <label>Oberva&ccedil;&atilde;o<br/>
        	<textarea name="observacao" cols="32"></textarea>
        </label>
        <label>Data Envio<br/>
        	<input type="text" name="data_envio" id="data_envio" calendario='1' mascara='__/__/____' size="9">
        </label>
	</fieldset>
	<input name="insere" type="hidden" value="<?=$_GET['aula']?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($registro->id > 0){
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