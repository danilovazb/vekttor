<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:340px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Fila de Espera</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	
	
   
		<fieldset  id='campos_1'>
				<legend>
                	<a onclick="aba_form(this,0)"><strong>Cliente</strong></a>
                    
                </legend>
				<label>
                <select name="agenda_id" id="agenda_id" <?=$disabled?> valida_minlength='1' retorno='focus|Selecione uma Agenda'>
    					<option value=''>Agenda</option>
						<?php
							//$agendas = mysql_query("SELECT * FROM agenda WHERE usuario_id = '$usuario_id' AND vkt_id='$vkt_id'");
							while($agenda = mysql_fetch_object($agendas)){
							  if($agenda->id==$fila->agenda_id){
								  $selected="selected='selected'";
							  }
							  echo "<option value='$agenda->id' $selected>$agenda->nome</option>";
							  $selected='';
							}
						?>
    			</select>
                </label>
                <div style="clear:both"></div>
                 <label style="width:250px;">
					 
                        Cliente:
                      <input type='text' name="cliente" id="cliente" value="<?=$cliente_fornecedor->razao_social?>" retorno="focus|Digite o Nome do Contrato" valida_minlength='3' busca='modulos/odonto/contrato/busca_cliente.php,@r1,@r0-value>cliente_id|@r1-value>cliente,0' <?=$disabled?>>
                      <input type='hidden' name="cliente_id" id="cliente_id" value="<?=$cliente_fornecedor->id?>">
                  </label >	
                  <div style="clear:both"></div>
                 <label style="width:250px;">
					  Observação:<textarea rows='10' cols="5" name="observacao" <?=$disabled?>><?=$fila->observacao?></textarea>
                  </label >			
		</fieldset>

		<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($fila->id>0){
		if($fila->status!='Concluido'&&$fila->status!='Cancelado'){
			echo "<input name='action' type='submit' value='Cancelar' style='float:left' />";
		}
		if($fila->status=='Em espera'){
		 	echo "<input name='action' type='submit'  value='Atendimento' style='float:right'  />";
		}
		else if($fila->status=='Em atendimento'){
		 	echo "<input name='action' type='submit'  value='Concluir' style='float:right'  />";
		}
	}else{
	?>
	<input name="action" type="submit"  value="Enviar Para Fila" style="float:right"  />
    <?
	}
	?>
    <input type='hidden' name="id" id="id" value="<?=$fila->id?>">
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>