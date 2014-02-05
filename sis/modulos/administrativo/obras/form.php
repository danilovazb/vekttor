<?
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 

?><link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='aSerCarregado'>
<div style="width:600px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Empreendimentos</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
		<strong>Informações</strong>
		</legend>
		<label style="width:515px;">
			Nome 
			<input type="text" id='nome' name="nome" valida_minlength='5'  value="<?=$r->nome?>" maxlength="255"/>
		</label>
		<label style="width:160px;">
			Orçamento
			<input type="text" name="orcamento" id="orcamento" value="<?=moedaUsaToBr($r->orcamento)?>" maxlength="23" decimal="2" sonumero="1" style="text-align:right"  />
		</label>
		<label style="width:160px">
			Início
			<input name="inicio" id='inicio' type="text" value="<?=dataUsaToBr($r->inicio)?>" maxlength="23" calendario='1' sonumero='1' valida_data='1'  mascara='__/__/____' retorno='focus|Data Simples' />
		</label>
		<label style="width:160px">
			Fim
			<input name="fim" id='fim' type="text" value="<?=dataUsaToBr($r->fim)?>" maxlength="23" calendario='1' sonumero='1' valida_data='1'  mascara='__/__/____' retorno='focus|Data Simples' />
		</label>
		<input name="id" type="hidden" value="<?=$r->id?>" />
		<input name="tipo" type="hidden" value="Obra" />
	</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<?
if($r->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<input name="action" type="button"  value="Planejamento" style="float:right; margin-right:5px;" onclick="location.href='?tela_id=62&empreendimento_id=<?=$r->id?>'" />
<?
}
?>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
<script>top.openForm()</script>