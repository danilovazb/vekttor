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
    
    <span>Bolsistas</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
			
		<fieldset  id='campos_2'>
			<div style="clear:both"></div>
			<label style="width:100px; margin-right:23px;">
				Código Totvs
				<input type="text" id='cod_totvs' name="cod_totvs" value="<?=$bolsista->codigo_totvs?>"autocomplete="off" retorno="focus|Digite o código TOTVS" valida_minlength='3'/>
			</label>
            <label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='busca_nome_aluno' name="busca_nome_aluno" value="<?=$bolsista->nome?>" busca='modulos/escolar/bolsistas/busca_aluno.php,@r0-@r1,@r0-value>busca_id_aluno|@r1-value>busca_nome_aluno' autocomplete="off" retorno="focus|Digite o nome corretamente" valida_minlength='3'/>
				<input type="hidden" name="busca_id_aluno" id="busca_id_aluno" value="<?=$bolsista->aluno_id?>" />
            </label>
               
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($bolsista->aluno_id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="action" type="submit"  value="Salvar" style="float:right"  />
    <input name ="id" type="hidden" value="<?=$bolsista->aluno_id?>" />
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>