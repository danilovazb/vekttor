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
<div style="width:350px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Período Letivo</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"  method="post" enctype="multipart/form-data">

		<input type="hidden" id="id" name="id" value="<?=$periodo_letivo->id?>" />

		<fieldset>
          <legend>
            <a onclick="aba_form(this,0)"><strong>Período Letivo</strong></a>
          </legend>
			
            <?php
            
			if($_GET['acao']=="editar_periodo_letivo"){
				
				$disabled = "disabled='disabled'";
			
			      
			?>
            
            	<select name="periodo_letivo" id="periodo_letivo">
          		<option value=""> Selecione um período Letivo</option>
            	<?
				$periodos_letivos = mysql_query("SELECT * FROM escolar2_periodo_letivo WHERE vkt_id='$vkt_id'");
				
				while($periodo_letivo = mysql_fetch_object($periodos_letivos)){
				
					echo "<option value='$periodo_letivo->id'>$periodo_letivo->nome</option>";
				
				}
				
			?>
          </select> 
			
			<?php
			
			}else{
			?>
            <label style="width:250px;">
            	Nome
                <input type="text" name="nome_periodo_letivo" id="nome_periodo_letivo" <?=$disabled?> value="<?=$periodo_letivo->nome?>"/>
            </label>
            
            <div style="clear:both;"></div>
            
            <label style="width:100px;">
            	Data de Início
                <input type="text" name="data_inicio_periodo_letivo" id="data_inicio_periodo_letivo" mascara="__/__/____" calendario="1" sonumero="1" <?=$disabled?> value="<?=DataUsaToBr($periodo_letivo->data_inicio)?>"/>
            </label>
            
            <label style="width:100px;">
            	Data de Término
                <input type="text" name="data_termino_periodo_letivo" id="data_termino_periodo_letivo" mascara="__/__/____" calendario="1" sonumero="1" <?=$disabled?> value="<?=DataUsaToBr($periodo_letivo->data_fim)?>"/>
            </label>
            <?
			
				}//if($_GET['acao']=="editar_periodo_letivo")
				
			?>
             <div style="clear:both;"></div>
            
                        
		</fieldset>
		<!-- --><!-- --><!-- -->
      <!-- --><!-- -->

          <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $periodo_letivo->id > 0 ){ ?>
                <input name="action_periodo_letivo" type="submit" value="Excluir" style="float:left" <?=$disabled?>/>
                <?php } ?>
                <input name="action_periodo_letivo" type="submit"  value="Salvar" style="float:right" <?=$disabled?>/>
                
                <div style="clear:both"></div>
            </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>