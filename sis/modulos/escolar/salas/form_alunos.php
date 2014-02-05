<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl_sala.php");
include("_ctrl.php");
$sala_id=$_GET['sala_id'];
$mat_id=$_GET['mat_id'];
$aluno=mysql_fetch_object(mysql_query($t="SELECT em.id as matricula,ea.id,ea.nome,ea.cpf,ea.data_nascimento,ea.telefone1,
						ep.nome as periodo,	ee.nome as escola, ec.nome as curso,ec.id as curso_id,em.modulo_id,escola_id,
						em.horario_id
						FROM 
						escolar_matriculas em,
						escolar_alunos ea,
						escolar_periodos ep,
						escolar_escolas ee,
						escolar_cursos ec
						WHERE em.aluno_id = ea.id
						AND em.periodo_id = ep.id
						AND em.escola_id  = ee.id
						AND em.curso_id  = ec.id
						AND em.sala_id='".$sala_id."'
						AND em.id='".$mat_id."'"));
						echo $t;
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
    
    <span>Salas</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
			
		<fieldset>
			<label>
            	<strong>Nome:</strong> <?=strtoupper($aluno->nome)?>
          </label>
            <div style="clear:both"></div>
            <label style="width:300px;">
				<strong>Curso: </strong> <?=strtoupper($aluno->curso)?>			
            </label>
            <div style="clear:both"></div>
          <label style="width:300px;">
				<strong>Escola</strong>	<?=strtoupper($aluno->escola)?>		
          </label>
            <div style="clear:both"></div>
            <label style="width:126px;">
				<strong>Sala</strong>
                <select id='sala' name="sala">
                <?
				$salas=mysql_query($t="SELECT * FROM escolar_salas WHERE vkt_id='$vkt_id' AND horario_id='$aluno->horario_id'");
                echo $t;
				while($sala=mysql_fetch_object($salas)){
					if($sala->id==$sala_id){$selected="selected=selected";}else{$selected='';}
					echo "<option value='".$sala->id."' $selected>".strtoupper($sala->nome);
				}
				?>
                </select>			
            </label>
          
  </label>
		<div style="clear:both"></div>
			
            
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<input name="actionalu" type="submit"  value="Salvar" style="float:right;"  />
    <input name ="mat_id" type="hidden" value="<?=$mat_id?>" />
    <div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>