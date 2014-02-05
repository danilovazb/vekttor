<?
//Includes
// configuração inicial do sistema
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php"); 
$disabled = "";
if($r->status == 2){
	$disabled = 'disabled="disabled"';
}
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:430px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    <span>Importação</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong> Importação de arquivo </strong>
		</legend>
        
        <input type="hidden" name="turma_id" value="<?=$_GET["turma_id"]?>">
        <input type="hidden" name="bimestre_id" value="<?=$_GET["bimestre_id"]?>">
        <input type="hidden" name="unidade_id" value="<?=$_GET["unidade_id"]?>">
        <input type="hidden" name="professor_has_turma" value="<?=$_GET["professor_has_turma"]?>">
        <input type="hidden" name="ensino_id" value="<?=$_GET["ensino_id"]?>">
        
        <div style="clear:both;"></div>
               
        <label>Selecione arquivo
        	<input type="file" name="arquivo" id="arquivo" retorno='focus|Selecione a arquivo' valida_minlength='1'>
        </label>
        
        <div style="clear:both;"></div>
        <label>
        	Data importação<br/>
            <input type="text" name="data_avaliacao" id="data_avaliacao" style="width:75px;" mascara="__/__/____" value="<? if( !empty($banco) ) echo $bancos_codigos; else echo date("d/m/Y"); ?>" calendario="1">
        </label>
    
	</fieldset>
	
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<input name="action" type="submit" <?=$disabled?> value="Importar" style="float:right"  />

<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>