<?php

//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div style="top:30px; left:50px;" class="exibe_formulario" id="exibe_formulario">
<div id='aSerCarregado'>
    <div style="width:400px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Periodo</span>
            </div>
        </div>
		<form onsubmit="return validaForm(this)" class="form_float" method="post">

            <input name="id" type="hidden" value="<?php echo $_GET['id']; ?>" />
            
            <fieldset id="campos_1">
                <legend>
                     <strong>Periodo</strong>
               </legend>
                
                <label style="width:95%; margin-right:23px;">
                    Nome
                    <input type="text" id="nome" name="nome" valida_minlength="3" retorno="focus|Coloque no minimo 3 caracteres" value="<?php echo $d->nome?>" />
                </label>
                
                <label style="width:130px;">
                    Inicio das Aulas
                      <input type="text" style="width:80px;" id="inicio_aulas" name="inicio_aulas" value="<?=dataUsaToBr($d->inicio_aulas)?>" calendario='1' mascara="__/__/____"/>
                </label>
                <label style="width:130px;">
                    Fim das Aulas
                      <input type="text" style="width:80px;" calendario='1' id="fim_aulas" name="fim_aulas" value="<?=dataUsaToBr($d->fim_aulas)?>" mascara="__/__/____"/>
                </label>
                <div style="clear:both"></div>
              <label style="width:130px;">
                    Inicio das Rematriculas
                      <input type="text" style="width:80px;" id="inicio_rematricula" name="inicio_rematricula" value="<?=dataUsaToBr($d->inicio_rematricula)?>" calendario='1' mascara="__/__/____"/>
                </label>
                <label style="width:130px;">
                    Fim das Rematriculas
                      <input type="text" style="width:80px;" calendario='1' id="fim_rematricula" name="fim_rematricula" value="<?=dataUsaToBr($d->fim_rematricula)?>" mascara="__/__/____"/>
                </label>
              <div style="clear:both"></div>
                <label style="width:130px;">
                    Inicio das Matriculas
                      <input type="text" style="width:80px;" id="inicio_matricula" name="inicio_matricula" value="<?=dataUsaToBr($d->inicio_matricula)?>" calendario='1' mascara="__/__/____"/>
                </label>
                <label style="width:130px;">
                    Fim das Matriculas
                      <input type="text" style="width:80px;" calendario='1' id="fim_matricula" name="fim_matricula" value="<?=dataUsaToBr($d->fim_matricula)?>" mascara="__/__/____"/>
              </label>

              <div style="clear:both"></div>
                       <label style="width:95%;">
                        obs
                        <textarea type="text" style="height:100px" id="obs" name="obs"><?php echo $d->obs; ?></textarea>
                    </label>
         
  </fieldset>

            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $d->id > 0 ){ ?>
                <input name="action" type="submit" value="Excluir" style="float:left" />
                <?php } ?>
                <input name="action" type="submit"  value="Salvar" style="float:right" />
                
                <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script></div>