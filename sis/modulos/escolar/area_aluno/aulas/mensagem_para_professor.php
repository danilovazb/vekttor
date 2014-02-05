<?
//Includes
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
print_r($_GET);
$professor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id=".$_GET['professor_id']." AND cliente_vekttor_id='$vkt_id'"));
$aula= mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_aula WHERE id=".$_GET['aula_id']." AND vkt_id=$vkt_id"));
$materia = mysql_fetch_object(mysql_query($t="SELECT *,em.id as mat_id FROM 
												escolar_materias em,
												escolar_sala_materia_professor smp
												WHERE 
												em.id=smp.materia_id AND 
												smp.id=$aula->sala_materia_professor_id AND
												em.vkt_id=$vkt_id")); 
echo $t;
?>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<style>
label#responsavel:hover{ cursor:crosshair;}
</style>
<div id='aSerCarregado'>
<div style="width:650px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Mensagem para Professor</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"  method="post" enctype="multipart/form-data">

		<input type="hidden" id="aluno_id" name="aluno_id" value="<?=$_SESSION['aluno']->id; ?>" />

		<fieldset>
          <legend>
            <strong>Nova Mensagem</strong>
          </legend>
			
              <label style="width:478px;"> <strong>De: </strong><?php echo $_SESSION['aluno']->nome?> </label>
              <label style="width:478px;"> <strong>Para: </strong> <?php echo $professor->razao_social?> </label>
              <label style="width:478px;"> <strong>Assunto</strong> <?php echo $aula->descricao."(".$materia->nome.")"?></label>
              
              <input type="hidden" name="aula_id" value="<?php echo $aula->id ?>" />
              <input type="hidden" name="materia_id" value="<?php echo $materia->mat_id ?>" />
              <input type="hidden" name="professor_id" value="<?php echo $professor->id ?>" />
              <input type="hidden" name="aula" value="<?php echo $aula->descricao ?>" />
              <input type="hidden" name="sala_id" value="<?php echo $materia->sala_id?>" />
              <br>
			<label>
            Anexo
            		<input type="file" name="arquivo" id="arquivo" value="<?=$obj->foto?>" />
            </label >
              <label style="width:550px;"> <strong>Mensagem</strong>
              <textarea style="height:200px;" name="mensagem"></textarea>
              
              </label>
              <br>
			
		</fieldset>
		<!-- --><!-- --><!-- -->
      <!-- --><!-- -->

       <div style="width:100%; text-align:center" >
         <input name="acao" type="submit"  value="Salvar" style="float:right"  />
        <div style="clear:both"></div>
      </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($d->senha)<1){echo "<script>top.newPass('senha')</script>";} ?>