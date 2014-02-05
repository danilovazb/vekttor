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
    <div style="width:650px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Matéria</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">

            <input name="curso_id" id="curso_id" type="hidden" value="<?php echo $_GET['curso_id']; ?>" />
            
            <fieldset id="campos_1">
                <legend>
                <?
                function menu_fild($linkado){
					$lk1[$linkado] = '<strong>';
					$lk2[$linkado] = '</strong>';
				?>
                     <a onclick="aba_form(this,0)"><?=$lk1[0]?>Cursos<?=$lk2[0]?></a>
                   
                 <?
				}
				menu_fild(0);
				 ?>
                </legend>
                <input type="hidden"  name="modulo_id" id="modulo_id" value="<?=$modulo->id?>"/>
                <?
                //Exibe labels caso id do curso seja maior que 0
				if($d->id > 0){
				?>
                <label style="width:250px; margin-right:23px;">
                    <strong>Nome:</strong><?php echo $d->nome?>
                </label>
                <label style="width:250px; margin-right:23px;">
                    <strong>Módulo:</strong><?php echo $modulo->nome?>
                </label>
                <?
					$t="SELECT count(*) FROM escolar_materias WHERE modulo_id='$modulo->id' AND  vkt_id='$vkt_id'";
					$selmateria = "SELECT * FROM escolar_materias WHERE modulo_id='$modulo->id' AND vkt_id='$vkt_id'"; 
				}
				else{
				?>
                	<label>
                	Curso
                    <select name="curso" id="curso" onchange="selcurso(this)">
                    	<option>SELECIONE UM CURSO</option>
						<?php
							$cursos=mysql_query("SELECT * FROM escolar_cursos WHERE vkt_id='$vkt_id'");
							while($curso=mysql_fetch_object($cursos)){
						?>
                        <option value="<?=$curso->id?>" <? if($curso->id==$_GET[curso]){echo "selected=selected";}?>><?=$curso->nome?></option>
                        <? }?>
                    </select>
                    </label>
                    
                    <label>
                	Módulo
                    <select name="modulo_id" id="modulo_id" onchange="selmodulos(curso,this)">
                    	<option>SELECIONE UM MÓDULO</option>
                    	<?php
							$modulos=mysql_query("SELECT * FROM escolar_modulos WHERE vkt_id='$vkt_id' AND curso_id=".$_GET[curso]);
							while($modulo=mysql_fetch_object($modulos)){
						?>
                        <option value="<?=$modulo->id?>" <? if($modulo->id==$_GET[modulo]){echo "selected=selected";}?>><?=$modulo->nome?></option>
                        <? }?>
                    </select>
                    </label>
                <?						
					$t="SELECT count(*) FROM escolar_materias WHERE modulo_id='".$_GET[modulo]."' AND  vkt_id='$vkt_id'";
					$selmateria = "SELECT * FROM escolar_materias WHERE modulo_id='".$_GET[modulo]."' AND vkt_id='$vkt_id'"; 
				}
                ?>
                <div style="clear:both"></div>
              <div style="width:300px; margin-right:23px;">
                    Matérias
                    <div id='multiplicador'>
                    
                    <?
					
					if(@mysql_result(mq($t),0,0)==0){
						$q = "SELECT 1=1";	
					}else{
						$q = $selmateria;
					}
					//echo $q."<br>";  
					$q= mq($q);
                    
					while($m=mf($q)){
						$x++;
						if($x>1){
							$img='menos';	
							$class='remove';
						}else{
							$img='mais';	
							$class='adiciona';
						}
					?>
                    <label style="width:300px;">
                    
                    <input style="width:250px;float:left;" type="text"  name="nome[]" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?=$m->nome?>" />				                     
                     <img src="../fontes/img/<?=$img?>.png" width="18" height="18" class="<?=$class?>" materia_id='<?=$m->id?>' />
                     <input type="hidden"  name="materia_id[]" value="<?=$m->id?>" /> 
                     </label>
                     <?
                     }
					 ?>
                </div>
              </div>
                
             
          </fieldset>
                
           <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $d->id > 0 || !empty($_GET[modulo])){ ?>
                <input name="action" type="submit" value="Excluir" style="float:left" />
                <?php } ?>
                <input name="action" type="submit" value="Salvar" style="float:right" />

                
              <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script></div>