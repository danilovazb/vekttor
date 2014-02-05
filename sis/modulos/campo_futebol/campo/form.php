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
<div style="width:420px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Campo</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
		<label style="width:311px;">Nome
		  <input type="text" id='nome' name="nome" value="<?=$select->nome?>" autocomplete='off' maxlength="44"/>
		</label>
        <label style="width:85px;">Valor 1
		  <input type="text" id='valor_1' name="valor_1" value="<?=moedaUsaToBr($select->valor1)?>" autocomplete='off' decimal="2" maxlength="44"/>
		</label>
        <label style="width:85px;">Valor 2
		  <input type="text" id='valor_2' name="valor_2" value="<?=moedaUsaToBr($select->valor2)?>" autocomplete='off' decimal="2" maxlength="44"/>
		</label>
        <label style="width:85px;">Valor 3
		  <input type="text" id='valor_3' name="valor_3" value="<?=moedaUsaToBr($select->valor3)?>" autocomplete='off' decimal="2" maxlength="44"/>
		</label>
	</fieldset>
	<input name="id" type="hidden" value="<?=$select->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<? if($select->id > 0){ ?>
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