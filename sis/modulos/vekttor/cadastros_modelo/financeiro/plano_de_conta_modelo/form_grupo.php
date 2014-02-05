<?
//Includes
// configuração inicial do sistema
include("../../../../../_config.php");
// funções base do sistema
include("../../../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions_modelo_grupo.php");
include("_ctrl_modelo_grupo.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Grupo de Modelo de Plano de conta</span></div>
    </div>
    
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		<label style="width:150px;">
			Nome
			  <br />
		  <input type="text" id='nome' name="nome" value="<?=$modelo_grupo->nome?>" autocomplete='off' maxlength="44" style="width:150px" />
		</label>
        <label style="width:200px;">
			Descrição
			
		      <input type="text" id='descricao' name="descricao" value="<?=$modelo_grupo->descricao?>" autocomplete='off' maxlength="44"/>
		</label>
        
        
		
        <div style="clear:both"></div>
	</fieldset>
	<input name="id_grupo" type="hidden" value="<?=$modelo_grupo->id?>" />
    <input type="hidden" name="eh_grupo" value="1">
	

<div style="width:100%; text-align:center" >
<? /*
if($modelo_grupo->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}*/
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>