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
    
    <span>Turma</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
			
		<fieldset  id='campos_2'>
			<legend><strong>Turma</strong></legend>
            <label style="width:300px; margin-right:23px;">
				Nome da Turma
				<input type="text" id='nome' name="nome" value="<?=$professor->nome?>" retorno="focus|Digite a materia" valida_minlength='3'/>
			</label>
            <div style="clear:both"></div>
            <label style="width:100px; margin-right:23px;">
				Minimo de Alunos
				<input type="text" id='minimo' name="minimo" value="<?=$professor->nome?>" retorno="focus|Digite a idade mínima" valida_minlength='3' sonumero="1">
			</label>
            <label style="width:100px; margin-right:23px;">
				Maximo de alunos
				<input type="text" id='maximo' name="maximo" value="<?=$professor->nome?>" retorno="focus|Digite a idade máxima" valida_minlength='3' sonumero="1" mascara="__/__/____"/>
			</label>
            <div style="clear:both"></div>
             <label style="width:180px; margin-right:23px;">Curso
				<select id="curso_id" name="curso_id">
                	<option>Curso</option>
                    <option value="1">Desencolvimento de Sistema</option>
                    <option value="2"> Segurança do Trabalho </option>
                    <option value="3"> Designer </option>
                </select>
			</label>
            <label style="width:100px; margin-right:23px;">
				Turno/Horário
				<select name="turno">
                	<option value="matutino">Matutino</option>
                    <option value="vespertino">Vespertino</option>
                    <option value="noturno">Noturno</option>
                </select>
			</label>
            <div style="clear:both"></div>
                <label style="width:100px; margin-right:23px;">
				Modulo
				<select name="modulod">
                	<option value="matutino">Modulo 1</option>
                    <option value="vespertino">Modulo 2</option>
                    <option value="noturno">Modulo 3</option>
                </select>
			</label>
           	<div style="clear:both;"></div>
             <label>Materia<br/>
            	<input type="text" name="nome" size="35" />
            </label>
            <label>
            	<a href="#" class="mais" id="modulo_mais" style="margin-top:17px;"></a>
            </label>
            <div style="clear:both;"></div>
            <div id="result_mateira"></div>
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