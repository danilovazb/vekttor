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
    
    <span>Necessidade</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Necessidade</strong>
		</legend>
		<label style="width:100px;">
           	Data de Início 
           <input type="text" name="data_inicio" id="data_inicio" mascara="__/__/____" sonumero="1" value="<?=$horario->hora_inicio?>" calendario="1"/>
        </label>
        
        <label style="width:100px;">
           	Data Final
           <input type="text" name="data_final" id="data_final" mascara="__/__/____" sonumero="1" value="<?=$horario->hora_inicio?>" calendario="1"/>
        </label>
       
       <div style="clear:both"></div>
       
       
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$unidade->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="button" id="criar_cotacao" value="Criar Cotação" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>