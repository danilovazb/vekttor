<?
//Includes
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_ctrl.php");
include("_functions.php");
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

		<fieldset>
          <legend>
            <strong>Nova Mensagem</strong>
          </legend>
			
              <label style="width:478px;"> <strong>De: </strong>  <?php echo $aluno->nome?></label>
              <label style="width:478px;"> <strong>Para: </strong> <?php echo $professor->razao_social?> </label>
              <label style="width:478px;"> <strong>Assunto</strong> <?php echo $aula->descricao."(".$materia->nome.")"?></label>
              
              <input type="hidden" name="aula_id" value="<?php echo $aula->id ?>" />
              <input type="hidden" name="materia_id" value="<?php echo $materia->id ?>" />
              <input type="hidden" name="professor_id" value="<?php echo $professor->id ?>" />
              <input type="hidden" name="aula" value="<?php echo $aula->descricao ?>" />
              <input type="hidden" name="sala_id" value="<?php echo $mensagem->sala_id?>" />
              <input type="hidden" name="mensagem_id" value="<?php echo $mensagem->id?>" />
              <input type="hidden" name="aluno_id" value="<?php echo $aluno->id?>" />
              <br>
			<label>
            <!--Anexo
            		<input type="file" name="arquivo" id="arquivo" value="<?=$mensagem->extensao?>" />
            </label >-->
              <label style="width:550px;"> <strong>Pergunta:</strong><?php echo $mensagem->mensagem?>
                           
              </label>
              <label style="width:550px;"> <strong>Responder</strong>
              <textarea style="height:200px;" name="mensagem"></textarea>
              
              </label>
              <div style="clear:both"></div>
              <a href="modulos/escolar/area_aluno/aulas/arquivos/<?=$mensagem->id.$mensagem->extensao?>" target="_blank">Baixar Arquivo</a>
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