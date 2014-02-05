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
    
    <span>Imagem</span></div>
    </div>
	<form onSubmit="return validaForm(this)" id="form_arquivo" class="form_float" method="post" enctype="multipart/form-data" target="">
	
    <?
    $id_progresso = md5(microtime() . rand());
    ?>
	
    <input id="id_chave" type="hidden" name="UPLOAD_IDENTIFIER" value="<?php echo $id_progresso;?>" />
    <input name="email_id" id="email_id" type="hidden" value="<?=$emailma->id?>" />
    <!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
    <fieldset>
		<label>
        Selecione uma Imagem
        <input type="file" name="imagem"/>
		</label>
        <div style="clear:both"></div>
        <div id='vkt_barra' style="width:300px; display:none; height:20px; position:relative; border-radius:5px; border:1px solid #CCC; margin:5px; padding:1px; text-align:center; ">
                                <div id='vkt_barra_progresso' style="height:20px; text-align:center; border-radius:5px; width:0%; background:#093;">
                                </div>
                                <span style="position:absolute; width:300px; height:20px; line-height:20px;  top:0; left:0; font-weight:bold;"><span id="progresso">Carregando</span>%</span>
                        </div>
    </fieldset>
             
	<input name="id" id="id" type="hidden" value="<?=$email->id?>" />
 
		
<!--Fim dos fiels set-->
<div style="width:100%; text-align:center" >
<input name="actionimg" type="submit" value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>
top.openForm();

</script>