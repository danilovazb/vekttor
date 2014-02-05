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
    
    <span>Unidades</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		<label style="width:311px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?=$unidade->nome?>" autocomplete='off' maxlength="44"/>
		</label><br />
       <div style="clear:both;"></div>
        Descrição<br>
		<label style="width:311px;">
			<textarea name="descricao" style="height:80px;"><?=$unidade->descricao?></textarea>
		</label>
	</fieldset>
	<input name="id" type="hidden" value="<?=$unidade->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($unidade->id>0){
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