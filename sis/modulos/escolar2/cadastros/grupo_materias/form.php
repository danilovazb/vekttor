<?
//Includes
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    <span> Informações Grupo</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<fieldset  id='campos_1' >
    	<legend><strong>Grupo Matéria</strong></legend>
		<label>
        	Nome grupo <input name="grupo_materia" type="text" value="<?=$info_grupo->nome?>">
        </label>
		    
	</fieldset>
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<? if($info_grupo->id>0){ ?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<? } ?>
	<input name="id" type="hidden" value="<?=$info_grupo->id?>"/>
    <input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
    
    
</form>
</div>
</div>
</div>
<script>top.openForm()</script>