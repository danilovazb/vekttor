<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_function_funcionario.php");
include("_ctrl_funcionario.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div style="width:710px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Documentos</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off" target="carregador" action="modulos/rh/empresa/form_socio_funcional.php">
	<fieldset  id='campos_1' >
		<input name="cliente_fornecedor_id" id="cliente_fornecedor_id" type="hidden" value="<?=$_GET['empresa_id']?>" />	
        <input type="hidden" name="j_tipo" value="<? if($socio->tipo_cadastro=="Físico") echo $socio->tipo?>">
            
        <legend>
			<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong>Dados</strong></a>
			
		</legend>
<label style="width:300px;">
        		Descriçao
                <input type="text" name="documento_descricao" id="documento_descricao" />
        </label>
        
        <label style="width:300px;">
        		Arquivo
                <input type="file" name="documento_arquivo" id="documento_arquivo" />
        </label>
</fieldset>
    <input type="hidden" name="acao2" id="acao2" value="socio"> 
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	
	<input name="id" type="hidden" value="<?=$socio->id?>"/>
    <input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>
dados =document.getElementById('aSerCarregado').innerHTML;
top.document.getElementById('form_socio').innerHTML=dados;
</script>