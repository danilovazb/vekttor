<?
//Includes
// configuração inicial do sistema
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:800px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Aula</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend>
            <a onclick="aba_form(this,0)">| <strong>Aula</strong> | </a>
    		<a onclick="aba_form(this,1)">Conteúdo | </a>
          </legend>
        <input type="hidden" name="aula_id" id="aula_id" value="<?=$aula_id?>">
        <input type="hidden" name="modulo_id" value="<?=$modulo_id?>">
        <input type="hidden" name="materia_id" value="<?=$materia_id?>">
		<label style="width:311px;">Título
		  <input type="text" id='titulo' name="titulo" value="<?=$aula->titulo?>" autocomplete='off' maxlength="80"/>
		</label>
        <div style="clear:both;"></div>
        	
        <div style="clear:both;"></div>
        <label>
        	Data<br/>
            <input type="text" name="data_referente" id="data_referente" style="width:85px;" mascara="__/__/____" value="<?php if($aula->data_referente){ echo dataUsaToBr($aula->data_referente);} else{ echo date('d/m/Y');}?>" calendario='1'>
        </label>
	</fieldset>
    <fieldset id="campos_2" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> | Aula | </a>
    		<a onclick="aba_form(this,1)"><strong>Texto</strong> | </a>
          </legend>
          <label>Texto da Aula<br/>
          		<textarea name="conteudo" id="conteudo_aula" style="width:700px; height:280px;">
				<?=$aula->conteudo?></textarea>
          </label>
     </fieldset>
	
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($aula->id > 0){
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