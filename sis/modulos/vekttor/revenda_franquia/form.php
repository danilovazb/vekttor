<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
//pr($_POST);
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Projeto</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete='off' class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong id='escreve'>Informa&ccedil;&otilde;es</strong>
		</legend>
        
        <input type="hidden" name='cliente_fornecedor_id' id='cliente_fornecedor_id' value="<?=$c->id;?>" />
        
        <input type="hidden" name='franquia_id' id='franquia_id' value="<?=$franquia->id;?>" />
        
		<label style="width:311px;">
			Cliente
			  <input type="text" id='nome' busca='modulos/vekttor/revenda_franquia/busca_clientes.php,@r0 @r2,@r1-value>cliente_fornecedor_id|@r2-value>cnpj,0' autocomplete='off' name="nome" value="<?=$c->razao_social;?>" maxlength="44"  valida_minlength="3"  retorno='focus|Coloque no minimo 3 caracter' />
		</label>      
        
 
        <label style="width:311px;">
          CNPJ
          	<input type="text" name="cnpj" id="cnpj" size="15" value="<?php echo $c->cnpj_cpf;?>">
		</label>
		
	</fieldset>
	<input name="id" type="hidden" value="" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >


		<input name="action" type="submit" value="Excluir" style="float:left" />	

<input name="action" type="submit"  value="Salvar" style="float:right"  />
<?php  // $user = isset($db->user) ? $db->user : NULL;?>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>