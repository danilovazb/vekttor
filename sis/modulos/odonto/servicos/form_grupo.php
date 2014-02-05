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
    
    <span>Grupos de Servicos</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' <? if($cliente_fornecedor->tipo_cadastro=="Físico")echo 'style="display:none"'; ?> >
			<legend>
				<a ><strong>Informacoes</strong></a>
				
			</legend>
			
			
			<label style="width:294px;">
				Nome
				<input type="text" id='nome_grupo' name="nome_grupo" value="<?=$grupo->nome?>" retorno="focus|Digite o Nome do Grupo" valida_minlength='3'/>
			</label>
            <div style="clear:both"></div>
            <label style="width:294px;">
				Observação
				<textarea id='observacao_grupo' name="observacao_grupo"><?=$grupo->observacao?></textarea>
			</label>
	</fieldset>
		
		
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($grupo->id>0){
	?>
	<input name="actionGrupo" type="submit" value="Excluir" style="float:left" />
	<input name="id" type="hidden"  value="<?=$grupo->id?>"/>
	<?
	}
	?>
	<input name="actionGrupo" type="submit"  value="Salvar" style="float:right"/>
    
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>