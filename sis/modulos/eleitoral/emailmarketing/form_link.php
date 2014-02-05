<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div style="width:350px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Links</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data" target="" id="form_email">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend>
			<a onclick="aba_form(this,0)"><strong>Link</strong></a>
            
		</legend>
           <label style="width:250px;">
        	Link:
			  <input type='text' name="link" id="link" value="http://">
		</label >
        
        <div style="clear:both"></div>
		
         
	</fieldset>
          
	<input type="button" id="inserir_link" value="Inserir" style="float:right" /> 
    <div style="clear:both"></div>
</form>
</div>
</div>
</div>

<script>
dados =document.getElementById('aSerCarregado').innerHTML;
top.document.getElementById('form_links').innerHTML=dados;

</script>