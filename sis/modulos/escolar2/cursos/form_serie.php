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
    <div style="width:650px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Informações Série</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data" autocomplete='off'>

            <input name="curso_id" type="hidden" value="<?php echo $_GET['curso_id']; ?>" />
            
            <input type="hidden" name="ensino_id" id="ensino_id" value="<?=$serie->ensino_id?>">
            <input type="hidden" name="serie_id" id="serie_id" value="<?=$serie->id?>">
            <input type="hidden" name="materia_id" id="materia_id">
            
            <fieldset id="campos_1">
                <legend>
                     <a onclick="aba_form(this,0)"><strong>S&eacute;rie/Mat&eacute;ria</strong></a>
                </legend>
                
                <label style="width:180px; margin-right:23px;">
                    S&eacute;rie<br/>
                    <input type="text" id="nome_serie" name="nome_serie"  valida_minlength="0" retorno="focus|Coloque no minimo 5 caracteres" value="<?php echo utf8_encode($serie->nome);?>" />
                </label>
                <label style="width:75px;">
                	Ordem ensino<br/>
                    <input type="text" style="width:50px" name="ordem_ensino" id="ordem_ensino" value="<?=$serie->ordem_ensino?>">
                </label>
                <label style="width:65px;">
                	Idade Min.<br/>
                    <input type="text" style="width:50px" name="idade_minima" id="idade_minima" value="<?=$serie->idade_minima?>">
                </label>
                <label style="width:65px;">
                	Idade Máx.<br/>
                    <input type="text" style="width:50px" name="idade_maxima" id="idade_maxima" value="<?=$serie->idade_maxima?>">
                </label>
                
               
                <label style="width:90px;">Matérias por dia<br/>
                	<input type="text" name="materia_por_dia" id="materia_por_dia" style="width:50px;" value="<?=$serie->materias_por_dia?>">
                </label>
               <div style="clear:both;"></div>  
               
               
          
             <label id="label_materia">Matéria<br/>
             	<input type="text" name="materia" id="materia" value="Matéria"  busca='modulos/escolar2/busca/busca_materia.php,@r1,@r0-value>materia_id|@r1-value>materia,0' autocomplete='off'>
             </label>
				
              <label  style="width:60px;">Qtd Aula
             	<input type="text" name="qtd_aula" id="qtd_aula" value="1" sonumero="1"  maxlength="5" >
             </label>
             
             <label style="width:120px;">Grupo
             	<select name="grupo_materia_id" id="grupo_materia_id">       
                	<option value="0"></option>
                	<?php
                    $sql = mysql_query(" SELECT * FROM escolar2_grupo_materia WHERE vkt_id = '$vkt_id' ");
					while($grupo = mysql_fetch_object($sql)){
					?>
                    <option value="<?=$grupo->id?>"><?=utf8_encode($grupo->nome)?></option>
                    <?php
					 }
					?>
                </select>
             </label>
               
             
           
           <label><br/>  
             <button type="button" id="add_materia">adicionar</button>
           </label>
           <p style="float:left" class="status_add_mat"> Aguarde... </p>
           
           <!-- modal -->
          <div class="janela" style="display:none;">
          <div class="modal-header">
            <a href="#" style="color:#CCC; font-weight:bold; float:right;" class="modal_close">x</a>
            <span><b>Atualizar Matéria</b></span>
          </div>
                <div class="modal-body">
                    <p>
                      <input type="hidden" name="serie_materia_modal" id="serie_materia_modal">
                      <input type="hidden" name="materia_id_modal" id="materia_id_modal">
                      <label> Matéria
                          <input type="text" name="nome_materia" id="nome_materia">
                      </label>
                    </p>
                </div>
          <div class="modal-footer">
            <span class="carregador" style="display:none">Aguarde...</span>
            <button type="button" id="btn-at-materia" style="float:right;" >Atualizar</button>
          </div>
        </div>
		 <!-- fim modal -->
           
            <table cellpadding="0" cellspacing="0" style="width:430px;border-left:1px solid #CCC;">
              <thead> 
                <tr style="border-left:1px solid #999;">
                    <td width="80">Série</td>
                    <td width="50">Matéria</td>
                    <td width="10">&nbsp;</td>
                </tr>
              </thead>
            <!--</table>
                <!-- -->
                <!--<table cellpadding="0" cellspacing="0" style="width:430px;border-left:1px solid #CCC;">-->
                  <tbody id="serie_materia">
                  
                  </tbody>
                  <tbody id="serie_edit">
                  
				  <?php
				  
				  $sql_serie = (mysql_query(" SELECT * FROM escolar2_series WHERE id = '" . mysql_real_escape_string($_GET['serie_id']) . "' "));
                  	
					while($serie=mysql_fetch_object($sql_serie)){
						
					$sql_serie_materia =  (mysql_query($t=" SELECT * FROM escolar2_serie_has_materias WHERE serie_id = '$serie->id'"));
					
					while($serie_materia=mysql_fetch_object($sql_serie_materia)){
						
						$total++;
						if($total%2){$sel='class="al"';}else{$sel='';}
						$serie_name = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$serie_materia->serie_id' "));
						
						
			   	  ?>
                  	<input type="hidden" name="n_serire_id" id="n_serire_id" value="<?=$serie_name->id?>">
                    <tr style="background:#999; color:#FFF" id="<?=$serie_materia->id?>">
                    	<td width='80'><?=utf8_encode($serie_name->nome);?></td>
                        <td width='50'></td>
                        <td>&nbsp;</td>
                   </tr>	
                   
                   <?php
                   
				   $sql_serie_materia =  (mysql_query($t=" SELECT * FROM escolar2_serie_has_materias WHERE serie_id = '$serie->id'"));
				   
				   while($serie_materia=mysql_fetch_object($sql_serie_materia)){
						$total++;
						if($total%2){$sel='class="al"';}else{$sel='';}   
					   
				   $materia = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_materias WHERE id = '$serie_materia->materia_id' "));
				   
				   ?>
                   
                   <tr <?=$sel?> id="<?=$serie_materia->id?>" materia_id="<?=$materia->id?>">
                    	<td width='80'><span  class="result_materia_<?=$serie_materia->id?>"></span></td>
                        <td width='50' class="n_materia_<?=$materia->id?>" id="n_materia"><?=utf8_encode($materia->nome);?></td>
                        <td><div style='width:10px; text-align:center'><a href='#' id='remove_materia'>excluir</a></div></td>
                   </tr>	
                     
                    
                     
                  <?php
				  
				   }
				  
					  }
					}
				  ?>
                  </tbody>
                 
                </table>
                              
          </fieldset>
            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $d->id > 0 ){ ?>
                <input name="action" type="submit" value="Excluir" style="float:left" />
                <?php } ?>
                <input type="hidden" name="acao" value="atualiza_serie">
                <input name="action" type="submit" value="Salvar" style="float:right" />

                
              <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script></div>