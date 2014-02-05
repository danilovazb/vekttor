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
	<form id="form_arquivo" class="form_float" method="post" enctype="multipart/form-data" action="" target="carregador">
    <input id="id_chave" type="text" name="UPLOAD_IDENTIFIER" value="<?php echo $id_progresso;?>" />
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es do Arquivo</strong>
		</legend>
		<label style="width:311px;">Arquivo<br/>
		 	<input type="file" name="arquivo" id="arquivo">
		</label>
        <label>
        	<div id='vkt_barra' style="width:300px; display:none; height:20px; position:relative; border-radius:5px; border:1px solid #CCC; margin:5px; padding:1px; text-align:center; ">
                <div id='vkt_barra_progresso' style="height:20px; text-align:center; border-radius:5px; width:0%; background:#093;">
                </div>
                <span style="position:absolute; width:300px; height:20px; line-height:20px;  top:0; left:0; font-weight:bold;"><span id="progresso">Carregando</span>%</span>
        </div>
        </label>
        <label>Oberva&ccedil;&atilde;o<br/>
        	<textarea name="observacao" cols="32"></textarea>
        </label>
        <label>Data Envio<br/>
        	<input type="text" name="data_envio" id="data_envio" calendario='1' mascara='__/__/____' size="9" value="<?
            	if($r->data_envio){
					dataUsaToBr($r->data_envio);
				} else {echo date('d/m/Y');}
				?>">
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
