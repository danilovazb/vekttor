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
    
    <span>Período de Inscriçao</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
				
		<fieldset  id='campos_2'>
        	<legend><strong>Período de Inscriçao</strong></legend>
            <label style="width:300px; margin-right:23px;">Curso
				<select id="">
                	<option>SELECIONE O CURSO:</option>
                    <option style="font-weight:bold"><b>Desenvolvimento de Sistemas</b></option>
                    <option style="font-weight:bold"><b>Segurança do Trabalho</b></option>
                    <option style="font-weight:bold"><b>Designer</b></option>
                </select>
			</label>
            <div style="clear:both;"></div>
            <label>
            	<select id="">
                	<option>SELECIONE O TIPO:</option>
                    <option>Matricula</option>
                    <option>Rematricula</option>
                </select>
			</label>
            <div style="clear:both;"></div>
            <label>Data Inicio
            	<input type="text" name="data_inicio" size="5">
            </label>
            <label>Data Fim
            	<input type="text" name="data_fim" size="5">
            </label>
            <div style="clear:both;"></div>
            
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