<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:420px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>MUDANÇA DE CARGO</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			
			<a onclick="aba_form(this,0)"><strong>Informa&ccedil;&otilde;es</strong></a>
            
		</legend>
		
        
       <label style="width:300px">
            Nome
            <input type="text" id='nome' name="nome" value="<?=$licenca->nome?>"/>
              
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:80px">
            Código
            <input type="text" id='codigo' name="codigo" value="<?=$licenca->codigo?>"/>
           	           
        </label>
        
        <div style="clear:both"></div>
        
        <label>
            Remunerado
           <select name="remunerado" id="remunerado">
           	<option value="nao" <?php if($licenca->remunerado=="nao"){ echo "selected='selected'";}?>>Não</option>
            <option value="sim" <?php if($licenca->remunerado=="sim"){ echo "selected='selected'";}?>>Sim</option>
           </select>           
        </label>
        
        <label>
            Tipo
           <select name="tipo_licenca" id="tipo_licenca">
           	<option value="maternidade" <?php if($licenca->tipo=="maternidade"){ echo "selected='selected'";}?>>Maternidade</option>
            <option value="militar" <?php if($licenca->tipo=="militar"){ echo "selected='selected'";}?>>Militar</option>
            <option value="acidente_trabalho" <?php if($licenca->tipo=="acidente_trabalho"){ echo "selected='selected'";}?>>Acidente de Trabalho</option>
           </select>           
        </label>
        
             
                                
	</fieldset>
    
	<input name="id" type="hidden" value="<?=$licenca->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($licenca->id > 0){
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