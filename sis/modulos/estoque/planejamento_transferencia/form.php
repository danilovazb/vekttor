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
    
    <span>Produto</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete='off' class="form_float" method="post">
    <input type="hidden" name="sys_modulos_id" id="sys_modulos_id" value="<?=$modulo->id?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong id='escreve'>Informa&ccedil;&otilde;es</strong>
		</legend>
        
		<label style="width:250px;">
			Produto:
            	<input type="text" name="produto" id="produto">
		</label>      
        
 
        <label style="width:250px;">
          Nome Item
          	<input type="text" name="nome_item" id="nome_item" size="20" value="<?=$modulo->nome?>">
		</label>
        
         <label style="width:250px;">
          Tela:
          	<input type="text" name="tela" id="tela" size="20" value="<?=$modulo->tela?>">
		</label>
        
         <label style="width:250px;">
          Caminho
          	<input type="text" name="caminho" id="caminho" size="20" value="<?=$modulo->caminho?>" />
		</label>
        
         <label style="width:250px;">
          A&ccedil;&atilde;o do Item
          	<select name="acao_menu" id="acao_menu">

            	<option <?=$sel_acao1?> value="expande">Expande</option>
                <option <?=$sel_acao2?> value="abre">Abre</option>
                <option <?=$sel_acao3?> value="form">Form</option>
                <option <?=$sel_acao4?> value="interno">Interno</option>
                <option <?=$sel_acao5?> value="blank">Blank</option>
            </select>
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