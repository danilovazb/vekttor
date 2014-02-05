<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
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
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>CARGOS E SALÁRIOS</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        
		<label style="width:311px;">
        Cargo
		<input type="text" name="cargo" valida_minlength="3" 
        retorno="focus|Digite no mínimo 3 caracteres no campo cargo"
        value="<?=$cargo_salario->cargo?>"/>
        </label>
        
        <label style="width:90px;">
        Valor do Salário
		<input type="text" name="vlr_salario" valida_minlength="3" 
        retorno="focus|Digite o valor do salário"
        value="<?=moedaUsaToBr($cargo_salario->valor_salario)?>" decimal="2"/>
        </label>
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$cargo_salario->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($cargo_salario->id > 0){
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