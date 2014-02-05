<?
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 

print_r($r);
?><link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='aSerCarregado'>
<div style="width:600px">
	<div>
		<div class='t3'></div>
		<div class='t1'></div>
		<div  class="dragme" >
			<a class='f_x' onclick="form_x(this)">
			</a>
			<span>Disponibilidade</span></div>
	</div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
		<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
		<fieldset  id='campos_1' >
			<legend>
			<strong>Informações</strong>
			</legend>
			<label style="width:340;"> Identificação
				<input type="text" id='identificacao' name="identificacao" value="<?=$r->identificacao?>" maxlength="255"/>
			</label>
			<label style="width:163px;"> Tipo
                
                 <select name="disponibilidade_tipo_id" id="disponibilidade_tipo_id" value="" >
 <?
 $qtd = mysql_query($trace="SELECT * FROM disponibilidade_tipo WHERE empreendimento_id='$_GET[empreendimento_id]' ORDER BY nome");
 $tipo_selecionado[$r->disponibilidade_tipo_id] = 'selected="selected"';
 while($rtd=mysql_fetch_object($qtd)){
	
	echo "<option value='$rtd->id' ".$tipo_selecionado[$rtd->id].">$rtd->nome</option>";
}
 
 ?>
 </select>
			</label>
			
			<label style="width:512px;"> Observação
				<textarea id='obs' name="obs" value="" /><?=$r->obs?></textarea>
			</label>
			<input name="id" type="hidden" value="<?=$r->id?>" />
		</fieldset>
		<!--Fim dos fiels set-->
		
		<div style="width:100%; text-align:center" >
			<input name="action" type="submit" value="Excluir" style="float:left" />
			<input name="action" type="submit"  value="Salvar" style="float:right"  />
			<div style="clear:both"></div>
		</div>
	</form>
 </label>
</div>
<script>top.openForm()</script>