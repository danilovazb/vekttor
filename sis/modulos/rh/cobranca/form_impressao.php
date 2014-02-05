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
    
    <span>COBRANÇA</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        
            
        
        
       <label style="width:107px">
            Data de Vencimento
            <input type="text" id='data_vencimento' name="data_vencimento" value="<? echo date("d")."/".date("m")."/".date("Y")?>" calendario="1" mascara="__/__/____"/>           	           
        </label>
        
              
        <div style="clear:both"></div>
        
       		
     
     
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$cobranca->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="button"  value="Imprimir Boletos" id="imprimir_todos_boletos" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>