<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

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
    
    <span>Cadastro de Quebra</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		
        <label style="width:180px;">
        Unidades
        <select name="projeto_id" id='projto_id' >
			<option value="0">Unidade</option>
			<option value="kg">KG</option>
            <option value="cx">CX</option>
            <option value="und">UND</option>
		</select>
        </label>
        
        <label style="width:100px;" >Data
          <input name="data_limite" id="data_limite" style="width:100px;" value="" mascara='__/__/____' calendario='1' />
        </label>
       
        <div style="clear:both"></div>
        
        <div style="border:1px solid #CCC;">
        	<table cellpadding="0" cellspacing="0" width="100%" >
				<thead>
    				<tr>
                      <td width="250"><?=linkOrdem("Prato","nome",1)?></td>
                      <td width="90">KG Desperdicio</td>
        			</tr>
    			</thead>
			</table>
            
            <table cellpadding="0" cellspacing="0" width="100%" id="dados_filtro">
            	<tbody>
   					<tr class="odda">
                      <td width="250">Feijao</td>
                      <td width="90"><input type="text" name="desperdicio[]" size="8"></td>
        			</tr>
                 </tbody>
			</table>
        </div>
            
	</fieldset>
	<input name="id" type="hidden" value="<?=$obj->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($obj->id>0){
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