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
    
    <span>Cargos</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<fieldset  id='campos_1' >
		<label>
        	Cargo <input name="cargo" type="text" value="<?=$cargo->cargo?>">
        </label>
        <label style="width:60px;">
        	Salário <input name="salario" value="<?=moedaUsaToBR($cargo->valor_salario)?>" sonumero="1" id="salario" type="text" decimal="1">
        </label>
		    
	</fieldset>
    
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($cargo->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="id" type="hidden" value="<?=$cargo->id?>"/>
    <input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
    
    
</form>
</div>
</div>
</div>
<script>top.openForm()</script>