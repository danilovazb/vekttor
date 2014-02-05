<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script src="../../../../fontes/js/jquery.min.js"></script>


<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Compra</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
       
		
        <label style="width:150px; clear:both;">
        Fornecedor
          <select name="unidade">
        	<option value="1">Unidade X</option>
            <option value="2">Unidade Y</option>
        </select>
        </label>
        <label style="width:100px; ">
        Valor Total
        <input type="text" value="" sonumero="1" decimal="2" />
        </label>
         <label style="width:80px;">
			Data
			<input type="text" id='data' name="data" value="" autocomplete='off' maxlength="44" calendario="1"/></label>
        <table style=" float:left; width:600px; clear:both; " cellpadding="0" cellspacing="0">
        
        <thead>
        <tr>
        	<td>Item</td>
            <td>Quantidade</td>
            <td>Valor</td>
             <td>Total</td>
            <td></td>
        </tr>
        </thead>
        <tbody style="background-color:white;" id="corpo_tabela_contrato">
        <tr>
        	<td class="n" ><input name="produto[]" id="produto<?=$p?>" value="<?=$produto->nome?>" 
                busca='modulos/estoque/compras/busca_produto.php,@r0,@r1-value>produto_id<?=$p?>|@r2-innerHTML>produto_valor<?=$p?>,0' 
                valida_minlength='2'
                retorno='focus|Busque o nome do produto' autocomplete="off" style="height:8px;"><input type="hidden" name="produto_id" id="produto_id" /></td>
            <td ><input type="text" value="10,00" name="qtd[]" size="5" sonumero="1" decimal="2" /></td>
            <td><input type="text" value="2"  size="5" name="valor[]" sonumero="1" decimal="2" /></td>
            <td>R$20,00</td>
            <td><img src="../fontes/img/mais.png" onclick="manipulaProduto(this)" class="add_sub" /></td>
        </tr>
       
        </tbody>
        <tfoot>
        	<tr><td>Total</td><td></td><td></td><td>R$60,00</td><td></td></tr>
        </tfoot>
        </table>
	</fieldset>
	<input name="id" type="hidden" value="<?=$obj->id?>" />

<script>
$("#corpo_tabela_contrato tr:nth-child(2n+1)").addClass('al');


</script>

<style type="text/css">
.add_sub{ margin-top:2px; margin-bottom:2px; height:18px; width:18px;}
.n{ font-weight:bold;}
</style>
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