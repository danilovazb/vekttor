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
                <span>Informa&ccedil;&otilde;es S&eacute;rie</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">

            <input name="id" type="hidden" value="<?php echo $registro->id?>" />
            
            <fieldset id="campos_1">
                <legend>
                <a onclick="aba_form(this,0)"><strong>S&eacute;rie</strong></a>
    			<a onclick="aba_form(this,1)">Mat&eacute;rias</a>
                </legend>
                
                <label style="width:250px; ">
                    Nome
                    <input type="text" id="nome" name="nome" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?php echo $registro->nome?>" />
                </label> 
                <div style="clear:both"></div>
                <label>Ensino
                	<select name="ensino_id" id="ensino_id">
                    <?php
                    	$sql_ensino = mysql_query(" SELECT * FROM escolar2_ensino  WHERE vkt_id = '$vkt_id' ");
						while($ensino=mysql_fetch_object($sql_ensino)){
							if($registro->ensino_id == $ensino->id){ $selected = 'selected="selected"'; } else {$selected = '';}
					?>
                    <option <?=$selected?>  value="<?=$ensino->id;?>"><?=$ensino->nome?></option>
                    <?php
						}
					
					?>
                    </select>
                </label>
                
                <div style="clear:both"></div>
                <label style="width:100px;">Materia por dia
                <input type="text" name="materia_por_dia">
                </label>
                
                <div style="clear:both"></div>
          		 <label style="width:100px; ">
                    Ordem
                    <input type="text" id="ordem_ensino" sonumero="1" name="ordem_ensino" valida_minlength="1" retorno="focus|Coloque no minimo 1 caracteres" value="<?php echo $registro->ordem_ensino?>" />
                </label>
                
              
          </fieldset>
          
          
          <fieldset id="campos_2" style="display:none">
		 	<legend>
            	<a onclick="aba_form(this,0)">S&eacute;rie</a>
    			<a onclick="aba_form(this,1)"><strong>Mat&eacute;rias</strong></a>
           	</legend>
            
            	<!--<label>
                	<input type="text" name="materia" id="materia">
                </label>
                <label>
                	<img src="../fontes/img/mais.png">
                </label>-->
            
           </fieldset>
          
          
          <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $registro->id > 0 ){ ?>
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