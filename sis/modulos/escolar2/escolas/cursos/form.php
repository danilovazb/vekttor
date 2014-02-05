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
                <span>Curso</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">

            <input name="curso_id" type="hidden" value="<?php echo $_GET['curso_id']; ?>" />
            
            <fieldset id="campos_1">
                <legend>
                <?
                function menu_fild($linkado){
					$lk1[$linkado] = '<strong>';
					$lk2[$linkado] = '</strong>';
				?>
                     <a onclick="aba_form(this,0)"><?=$lk1[0]?>Cilcos<?=$lk2[0]?></a>
                 <?
				}
				menu_fild(0);
				 ?>
                </legend>
                
                <label style="width:250px; margin-right:23px;">
                    Nome
                    <input type="text" id="nome" name="nome" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?php echo $d->nome?>" />
                </label>
                <label style="width:70px;">
                	% de Faltas
                    <input type="text" id="perc_faltas" name="perc_faltas" sonumero='1' valida_minlength="1" retorno="focus|Preencha o campo % de Faltas" value="<?php echo $d->perc_faltas?>" />
                </label>
              <div style="width:500px; margin-right:23px; clear:both;">
                    
                    <div style="width:250px; float:left">Séries</div>
                    <div style="width:250px;float:left">Idade Minima e Máxima</div>
                    
                    
                    <div id='multiplicador'>
                    
                    <?
					
					if(@mysql_result(mq("SELECT count(*) FROM escolar_modulos WHERE curso_id='$d->id' AND vkt_id='$vkt_id'"),0,0)==0){
						$q = "SELECT 1=1";	
					}else{
						$q="SELECT * FROM escolar_modulos WHERE curso_id='$d->id' AND vkt_id='$vkt_id'"	;
					}
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
                    <label >
                    <input type="hidden"  name="modulo_id[]" value="<?=$m->id?>"/>
                    <input style="width:250px;" type="text"  name="modulo_nome[]" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?=$m->nome?>" /> 
                     
                     </label>
                     <label style="width:25px;">
                    <input type="hidden"  name="" value="<?=$m->id?>"/>
                    <input type="text"/> 
                       </label>
                       <label style="width:25px;">
                  <input  type="text"/> 
                     
                     </label>
                     <img src="../fontes/img/<?=$img?>.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' />
					 <?
                     }
					 ?>
                </div>
              </div>
                
              
          </fieldset>
            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $d->id > 0 ){ ?>
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