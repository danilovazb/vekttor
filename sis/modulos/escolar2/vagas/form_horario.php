<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<style>
label#responsavel:hover{ cursor:crosshair;}
</style>
<div id='aSerCarregado'>
<div style="width:380px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a> <!-- ;location.href='?tela_id=460&escola_id=<?=$_GET['escola_id']?>&ano=<?=$_GET['ano']?> -->
    
    <span>Período Letivo</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"  method="post" enctype="multipart/form-data">

		<input type="hidden" id="id" name="id" value="<?=$horario->id?>" />

		<fieldset>
          <legend>
            <a onclick="aba_form(this,0)"><strong>Horário</strong></a>
          </legend>
			
            <label style="width:250px;">
            	Nome
      			<input type="text" name="nome_periodo_letivo" id="nome_periodo_letivo" value="<?=$horario->nome?>"/>
            </label>
            <? $checked =  $horario->combinar_horario == "sim" ? 'checked="checked"' : NULL ; ?>
            <div style="clear:both;"></div>
            <input type="hidden" name="combine" id="combine" value="nao">
           	<input type="checkbox" name="combinar_horario" id="combinar_horario" <?=$checked?>  value="combina_horario"> <span style="color:#999">Combinar com outro horário?</span>
            
            <div style="clear:both;"></div>
            <div class="obs"><p> <span style="color:#666" class="text-extra-combina-horario"> <b>Importante!</b><br/> Liberará a opção do aluno ficar em 2 turnos ou integral.</span> </p></div><p></p>
            
            <div style="clear:both;"></div>
            <label style="width:100px;">
            	Hora de Início
                <input type="text" name="hora_inicio" id="hora_inicio" mascara="__:__" sonumero="1" value="<?=$horario->hora_inicio?>"/>
            </label>
            
            <label style="width:100px;">
            	Data de Término
                <input type="text" name="hora_termino" id="hora_termino" mascara="__:__" sonumero="1" value="<?=$horario->hora_fim?>"/>
            </label>
           
             <div style="clear:both;"></div>
            
                        
		</fieldset>
		<!-- --><!-- --><!-- -->
      <!-- --><!-- -->

          <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $horario->id > 0 ){ ?>
                <input name="action_horario" type="submit" value="Excluir" style="float:left"/>
                <?php } ?>
                <input name="action_horario" type="submit"  value="Salvar" style="float:right"/>
                
                <div style="clear:both"></div>
            </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>