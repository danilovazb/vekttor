<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
include("../../../modulos/financeiro/_functions_financeiro.php");
// funções do modulo empreendimento
$opcoes = array('1'=>'block','2'=>'none');
$disabled = '';
$readonly = '';
$disOrcado = 'none';
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block; border:1px solid #E0E0E0}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">

<div id='aSerCarregado'>
<div style="width:500px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Cancelamento</span></div>
    </div>
	<form onSubmit="return validaForm(this)" id="form_confirma_cancelamento" class="form_float"  method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$reg_os->id?>" <?=$readonly?>>
    <input type="hidden" name="data_hoje" id="data_hoje" value="<?=date('d/m/Y')?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
    
		 <legend>
            <a onclick="aba_form(this,0)">  <strong>Cancelamento de OS</strong> </a>
    	  </legend>
          <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$reg_os->cliente_id?>">
               
        <label style="width:311px;">
			Login
			  <input type="text" id='login' autocomplete='off' name="login" valida_minlength="3"  retorno='focus|Digite Seu Login'/>
		</label>
        <label style="width:311px;">
			Senha
			  <input type="password" id='senha' autocomplete='off' name="senha" valida_minlength="3"  retorno='focus|Digite Sua Senha'/>
		</label>
            <!-- modal -->
         
  </fieldset>

<div style="clear:both"></div>
</form>
</div>
</div>
</div>
<script>
dados =document.getElementById('aSerCarregado').innerHTML;
top.document.getElementById('form_confirma_cancelamento').innerHTML=dados;
</script>