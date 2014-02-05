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
    
    <span>Matricula</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
			
		<fieldset  id='campos_2'>
			<legend><strong>Matricula</strong></legend>
            <label style="width:300px; margin-right:23px;">
				Aluno
				<input type="text" name="aluno">
			</label>
            <label style="width:300px; margin-right:23px;">Curso
				<select id="curso_id" name="curso_id">
                	<option>Curso</option>
                    <option value="1">Desencolvimento de Sistema</option>
                    <option value="2"> Segurança do Trabalho </option>
                    <option value="3"> Designer </option>
                </select>
			</label>
            <label style="width:300px; margin-right:23px;">Turma
				<select id="result_curso">
                	<option>Turma</option>
                    <!--<option> DSVKTS101</option>
                    <option> DSVKTS202</option>
                    <option> STVKTS302 </option>
                    <option> STVKTS404 </option>
                    <option> DGVKTS505 </option>
                    <option> DGVKTS606 </option>-->
                </select>
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