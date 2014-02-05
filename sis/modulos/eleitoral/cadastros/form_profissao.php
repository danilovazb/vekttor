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
    
    <span>Profissoes</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Profissoes</strong>
		</legend>
        <label style="width:200px">
   		Nome<input type="text" name="nome" id="nome" value="<? echo $profissao->descricao;?>">
    	</label>
        <div style="clear:both"></div>
        <label style="width:120px">
   		Data Comemorativa<input type="text" name="data_comemorativa" id="data_comemorativa" value="<? echo DataUsaToBr($profissao->data_comemorativa);?> " calendario='1' mascara='__/__/____'>
    	</label>
        <div style="clear:both"></div>
    <input name="idprofissao" type="hidden" value="<?= $profissao->id?>" />
	
<!--Fim dos fiels set-->
</fieldset>
<div style="width:100%; text-align:center" >
<?
if($profissao->id>0){
?>
<input name="actionprofissao" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="actionprofissao" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>