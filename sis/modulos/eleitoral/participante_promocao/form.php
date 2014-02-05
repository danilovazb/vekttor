<?
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Zona/Secao</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		
     <select name="promocao_id" id="promocao_id" style="margin-top:3px;">
   		<option value="">SELECIONE UMA PROMOÇAO</option>
		<?php
			$promocoes = mysql_query($t="SELECT * FROM eleitoral_promocao WHERE vkt_id='$vkt_id'");
			echo $t;
			while($promocao = mysql_fetch_object($promocoes)){
		?>
        	<option value="<?=$promocao->id?>" <? if($_GET['promocao_id']==$promocao->id){ echo "selected='selected'";}?>><?=$promocao->descricao?></option>
        <?php
			}
		?>
        
    </select>
     <div style="clear:both"></div>
     <label style="width:200px;">
    		Selecione um Participante: <input type="text" name="participante" id="participante" busca='modulos/eleitoral/eleitores/busca_eleitor.php,@r0,@r1-value>participante_id,0'/>
    	<input type="hidden" name="participante_id" id="participante_id" />
    </label>
	
<!--Fim dos fiels set-->
</fieldset>
<div style="width:100%; text-align:center" >
<?
if($promocao->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>