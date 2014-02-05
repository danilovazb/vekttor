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
    
    <span>Alunos Inadimplentes</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
			
		<fieldset  id='campos_2'>
			<div style="clear:both"></div>
			
            <label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='busca_nome_aluno' name="busca_nome_aluno" value="<?=$inadimplente->razao_social?>" busca='modulos/escolar/Inadimplentes/busca_aluno.php,@r0-@r1,@r0-value>busca_id_aluno|@r1-value>busca_nome_aluno' autocomplete="off" retorno="focus|Digite o nome corretamente" valida_minlength='3'/>
				<input type="hidden" name="busca_id_aluno" id="busca_id_aluno" value="<?=$inadimplente->aluno_id?>" />
            </label>
              <input type="hidden" name="inadimplente_id" id="inadimplente_id" value="<?=$inadimplente->inadimplente_id?>" /> 
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($inadimplente->inadimplente_id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="action" type="submit"  value="Salvar" style="float:right"  />
    <input name ="id" type="hidden" value="<?=$inadimplente->aluno_id?>"/>
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>