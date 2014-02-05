<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:710px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Periodicidade</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
			
		<fieldset  id='campos_2'>
			<div style="clear:both"></div>
			<label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" name="nome" id="nome" value="<?=$periodicidade->nome?>" />          
                
            </label>
            <label style="width:30px; margin-right:23px;">
				Peso
				<input type="text" name="peso" id="peso" value="<?=moedaUsatoBr($periodicidade->peso)?>" moeda="1"/>           
                
            </label>
            <label style="width:60px; margin-right:23px;">
				Recuperacao
				<select name="recuperacao">          
               		<option value="0" <? if($periodicidade->recuperacao==0){echo "selected='selected'";}?>>NAO</option>
                    <option value="1" <? if($periodicidade->recuperacao==1){echo "selected='selected'";}?>>SIM</option>
                </select>
            </label>
               
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($periodicidade->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="action" type="submit"  value="Salvar" style="float:right"  />
    <input name ="id" type="hidden" value="<?=$periodicidade->id?>" />
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>