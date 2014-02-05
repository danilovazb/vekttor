<?php
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div style="top:30px; left:50px;" class="exibe_formulario" id="exibe_formulario">
<style>
#label_materia input{ color:#999; }
#serie_materia tr { background:#FFF;}
</style>
<div id='aSerCarregado'>
    <div style="width:500px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Informações Mat&eacute;ria</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">

            <input name="curso_id" type="hidden" value="<?php echo $_GET['curso_id']; ?>" />
            
            <input type="hidden" name="ensino_id" id="ensino_id" value="<?=$serie->ensino_id?>">
            <input type="hidden" name="serie_id" id="serie_id" value="<?=$serie->id?>">
            <input type="hidden" name="materia_id" id="materia_id">
            
            <fieldset id="campos_1">
                <legend>
                     <a onclick="aba_form(this,0)"><strong>Mat&eacute;ria</strong></a>
                </legend>
                
             <label id="label_materia">Matéria<br/>
             	<input type="text" name="materia" id="materia" value="" busca='modulos/escolar2/busca/busca_materia.php,@r1,@r0-value>materia_id|@r1-value>materia,0'>
             </label>
				
        
         
            
                              
          </fieldset>
          
            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $d->id > 0 ){ ?>
                <input name="action" type="submit" value="Excluir" style="float:left" />
                <?php } ?>
                <input type="hidden" name="acao" value="atualiza_materia">
                <input name="action" type="submit" value="Salvar" style="float:right" />     
              <div style="clear:both"></div>
           </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script></div>