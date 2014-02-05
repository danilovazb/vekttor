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
    
    <span>Configuração da Agenda</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
    <input type="hidden" name="id"  value="<?=$id?>" />
	<fieldset  id='campos_1' >
		<legend>
			<strong>Configurações</strong>
		</legend>

		<label  style="width:100%">
        	<input type="checkbox" name="nome_agenda" id="nome_agenda" value="1" style="display:compact; float:left">Enviar SMS na hora do Agendamento
        </label>
        <div style="clear:both"></div>
		<label>
        	<input type="checkbox" name="nome_agenda" id="nome_agenda" value="1" style="display:inline; float:left">Enviar E-mail na hora do Agendamento
        </label>
        <div style="clear:both"></div>
		<label>
        	Enviar sms Confirmação <input type="text" name="nome_agenda" id="enviar_sms_confirmacao" value="1" style="display:inline; width:20px"> dias de antecedencia
        </label>
        <div style="clear:both"></div>
		<label>
        	Enviar e-mail Confirmação <input type="text" name="nome_agenda" id="enviar_email_confirmacao" value="1" style="display:inline; width:20px"> dias de antecedencia
        </label>
	</fieldset>
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<input name="action" type="submit"  value="Configurar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
<?
// pr($configuracao_agenda) 
?>

</div>
</div>
</div>
<script>top.openForm()</script>