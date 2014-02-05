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
                <span>Curso</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data" autocomplete='off'>

            <input name="curso_id" type="hidden" value="<?php echo $_GET['curso_id']; ?>" />
            <input type="hidden" name="ensino_id" id="ensino_id" value="<?=$ensino_id?>" valida_minlength="1" retorno="focus|Não existe ensino Cadastrado">
            
            <fieldset id="campos_1">
                <legend>
                     <a onclick="aba_form(this,0)"><strong style="">Ciclos</strong></a>
                     <!--<a onclick="aba_form(this,1)">Mat&eacute;rias</a>-->
                </legend>
                
                <label style="width:250px; margin-right:23px;">
                    Ensino
                    <input type="text" id="nome" name="nome" busca='modulos/escolar2/busca/busca_ensino.php,@r1,@r0-value>ensino_id|@r1-value>nome,0' valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?php echo $ensino->nome?>" />
                </label>
                <label style="width:60px;">Ordem 
                	<input type="text" name="ord_ensino" id="ord_ensino" value="<?=$ensino->ordem_ensino?>"  />
                </label>
                <label style="width:70px;">
                	% de Faltas
                    <input type="text" id="percentagem_faltas" name="percentagem_faltas" sonumero='1' valida_minlength="0" retorno="focus|Preencha o campo % de Faltas" value="<?php echo $ensino->porcentagem_falta?>" />
                </label>
                    <div style="clear:both;"></div>
                    
               
               <div>
                   <label >Séries<br/>
                     <input type="hidden"  name="serie_id[]" value="<?=$serie->id?>"/>
                     <input style="width:180px;" type="text"  name="serie" id="serie" valida_minlength="0" retorno="focus|Coloque no minimo 5 caracteres" value="<?=$serie->nome?>" />  
                   </label>
                    <!-- -->
                   <label style="width:65px;">Ordem série<br/>
                     <input type="text" name="ordem_ensino" style="width:40px;" id="ordem_ensino" value="1" sonumero="1">
                   </label>
                   <!-- -->
                   <label>Idade Min.<br>
                   	<input type="text" style="width:45px;" name="idade_min" id="idade_min" value="0" sonumero="1" maxlength="3">
                   </label>
                   
                   <!-- -->
                   <label>Idade Max.<br>
                   	<input type="text" style="width:45px;" name="idade_max" id="idade_max" value="0" sonumero="1" maxlength="3">
                   </label>
                   
                   <!-- -->
                   <label>Matéria/dia<br>
                   	<input type="text" style="width:45px;" name="aulas_por_dia" id="aulas_por_dia" value="1" sonumero="1" maxlength="3">
                   </label>
                   
                   <!-- -->
                   <label><br/>
                   		<div style="width:20px; margin-top:2px;"><img src="../fontes/img/mais.png" id="adiciona_serie" width="18" height="18"  /></div>
                   </label>
               
               </div>
                
                <table cellpadding="0" cellspacing="0" style="width:430px;border-left:1px solid #CCC;">
              		<thead> 
                        <tr style="border-left:1px solid #999;">
                            <td width="130">Série</td>
                            <td width="10">ordem</td>
                            <td width="30">min.</td>
                            <td width="30">max.</td>
                            <td width="30">matéria/dia</td>
                            <td width="25">&nbsp;</td>
                        </tr>
              		</thead>
                    <tbody id="lista_serie"></tbody>
                    
                    <tbody>
                    <?php
			   		if(isset($sql_serie)){
                  		while($serie=mysql_fetch_object($sql_serie)){
							$total++;
							if($total%2){$sel='class="al"';}else{$sel='';}
			   			?>
                        <tr <?=$sel?> style="background:#FFF;" id="<?=$serie->id?>">
                        	<td><?=$serie->nome?></td>
                            <td><?=$serie->ordem_ensino?></td>
                            <td><?=$serie->idade_minima?></td>
                            <td><?=$serie->idade_maxima?></td>
                            <td><?=$serie->materias_por_dia?></td>
                            <td style="padding-left:5px;"><div style=" width:15px;"><a href='#' id='remove_serie'>excluir</a></div></td>
                        </tr>
                   <?php
						 }
					}
					?>
                    </tbody>
                </table>
               
          </fieldset>
          
           <fieldset id="campos_2" style="display:none">
		 	<legend>
            	<a onclick="aba_form(this,0)">Ciclos</a>
    			<!--<a onclick="aba_form(this,1)"><strong>Mat&eacute;rias</strong></a>-->
           	</legend>
             <label id="label_materia">Matéria<br/>
             	<input type="text" name="materia" id="materia" value="Matéria">
             </label>
				
              <label  style="width:60px;">Qtd Aula
             	<input type="text" name="qtd_aula" id="qtd_aula" value="1" >
             </label>
               
             
             <label>Série <?=$serie_id?> <br/>
             	<select name="serie_id" id="serie_id">
                	<?php 
						$sql_serie = mysql_query(" SELECT * FROM escolar2_series WHERE ensino_id = '$ensino->id' ");
						while($serie=mysql_fetch_object($sql_serie)){
					?>
                	<option value="<?=$serie->id?>"><?=$serie->nome?></option>
                    <?php 
						}
					?>
                </select>
             </label>
           <label style="margin-top:3px;"><br/>  
             <button type="button" id="add_materia">Adicionar</button>
            </label>
            <table cellpadding="0" cellspacing="0" style="width:430px;border-left:1px solid #CCC;">
              <thead> 
                <tr style="border-left:1px solid #999;">
                    <td width="80">Série</td>
                    <td width="50">Matéria</td>
                </tr>
              </thead>
            <!--</table>
                <!-- -->
                <!--<table cellpadding="0" cellspacing="0" style="width:430px;border-left:1px solid #CCC;">-->
                  <tbody id="serie_materia">
                  
                  </tbody>
                  <tbody id="serie_edit">
                  
				  <?php
				  
				  $sql_serie = mysql_query(" SELECT * FROM escolar2_series WHERE ensino_id = '$ensino->id' ");
                  	
					while($serie=mysql_fetch_object($sql_serie)){
						
					$sql_serie_materia =  (mysql_query($t=" SELECT * FROM escolar2_serie_has_materias WHERE serie_id = '$serie->id'"));
					
					while($serie_materia=mysql_fetch_object($sql_serie_materia)){
						
						$total++;
						if($total%2){$sel='class="al"';}else{$sel='';}
						$serie_name = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$serie_materia->serie_id' "));
						
						
						
						
			   	  ?>
                  	<tr style="background:#999; color:#FFF">
                    	<td width='80'><?=utf8_encode($serie_name->nome)?></td>
                        <td width='50'></td>
                   </tr>	
                   
                   <?php
                   
				   $sql_serie_materia =  (mysql_query($t=" SELECT * FROM escolar2_serie_has_materias WHERE serie_id = '$serie->id'"));
				   
				   while($serie_materia=mysql_fetch_object($sql_serie_materia)){
						$total++;
						if($total%2){$sel='class="al"';}else{$sel='';}   
					   
				   $materia = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_materias WHERE id = '$serie_materia->materia_id' "));
				   
				   ?>
                   
                   <tr <?=$sel?>>
                    	<td width='80'></td>
                        <td width='50'><?=$materia->nome?></td>
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
                <?php if( $ensino->id > 0 ){ ?>
                <input name="action" type="submit" value="Excluir Ensino" style="float:left" />
                <?php } ?>
                <input type="hidden" name="acao" value="atualizar_ensino">
                <input name="action" type="submit" value="Salvar" style="float:right" />

                
              <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script></div>