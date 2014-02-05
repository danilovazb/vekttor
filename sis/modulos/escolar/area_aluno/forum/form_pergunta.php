<?
//Includes
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 

?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:650px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Informa&ccedil;&otilde;es</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
    <input type="hidden" name="pergunta_id" value="<?=$pergunta->id?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        <label>
         <strong>Aluno<br/></strong>
        <?=$aluno->nome?>
        <input type="hidden" name="aluno_id" value="<?=$aluno->id?>" style="width:50px;">
        </label>
        <div style="clear:both"></div>
         <label>
         <strong>Aula<br/></strong>
         <?=$aula_descricao->descricao?>
         <input type="hidden" name="aula_id" value="<?=$id?>" style="width:50px;">
        </label>
        <div style="clear:both"></div>
		<label style="width:500px;">
         <strong> Professor:</strong><br/> 
		    <?=$professor->razao_social?>
            <input type="hidden" name="professor_id" value="<?=$smp->professor_id?>" style="width:50px;">
		</label>
        <div style="clear:both"></div>
        <label>
        	<strong>Perguntar Para o Professor</strong><br/><textarea name="pergunta" id="pergunta" cols="60" rows="10"><?=$pergunta->pergunta?></textarea>
        </label>
	</fieldset>
	
	
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