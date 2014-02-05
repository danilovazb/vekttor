<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions_fatura.php");
include("_ctrl_fatura.php"); 
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
    
    <span>Fatura</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es da fatura</strong>
		</legend>
		<label style="width:311px;">Descrição
		  <input type="text" id='descricao' disabled="disabled" value="<?=$fatura->descricao?>" autocomplete='off' maxlength="44"/>
		</label>
        <label style="width:100px;">Vencimento
		  <input type="text" id='data_vencimento' name="data_vencimento" calendario='1' value="<?=dataUsaToBr($fatura->data_vencimento)?>" autocomplete='off' maxlength="44"/>
		</label>
        <label style="width:100px;">Valor
		  <input type="text" id='valor' disabled="disabled" value="<?=moedaUsaToBr($fatura->valor)?>" autocomplete='off' />
		</label>
        <label style="width:120px;">Situação: <?=$situacao[$fatura->situacao]?>
		</label>
	</fieldset>
	<input name="id_fatura" type="hidden" value="<?=$id_fatura?>" />
    <? 
	if($_GET['comissao']){
		?>
        <input type="hidden" name="comissao" value="true" />
        <?
	}
	?>
	
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