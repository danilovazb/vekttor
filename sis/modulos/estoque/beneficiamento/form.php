<?
print_r($_POST);
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
input,select,textarea{display:block; }
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:750px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Beneficiamento de Produtos</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off" >
    <input type="hidden" name="produto_beneficiado_id" id="produto_beneficiado_id" value="0">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		
        <div>
		<label style="width:250px;">
			Produto Beneficiado
			  <input name="produto_beneficiado" id="produto_beneficiado"  onkeyup="return vkt_ac(this,event,'0','modulos/estoque/beneficiamento/busca_produtos.php','@r0','funcao_bsc2(this,\'@r1-value>produto_beneficiado_id|@r2-value>unidade_produto_beneficiado\',\'produto_beneficiado\')')" value=""  valida_minlength="3" autocomplete="off"  retorno='focus|Coloque no minimo 3 caracter'>
        </label>
		
        <label>
        	QTD
              <input type="text" name="qtd_produto_beneficiado" id="qtd_produto_beneficiado"  size="2"  maxlength="8" sonumero="1" value="1">
        </label>
        <label style="width:50px;">
        	Unidade
            <input type="text" name="unidade_produto_beneficiado" id="unidade_produto_beneficiado" readonly="readonly" maxlength="8">
        </label>
        <label>
        <? 
			$date = date('d/m/Y');
		?>
        	Data
              <input type="text" name="data_pedido" id="data_pedido"  size="3"  maxlength="8" value="<?=$date?>">
        </label>
         
                 <div id="result_beneficiado"></div>
         		 <div id="result_pedido_id"></div>
                 <div style="clear:both"></div>
         <label id="teste_r">
         	Desperdicio % <br/>
            	<input type="text" name="desperdicio" id="desperdicio" style="width:80px;" sonumero="1" decimal="2">
         </label>
         <label id="teste_r">
         	Saldo(Kg)  <br/>
            	<input type="text" name="saldo" id="saldo" style="width:80px;" sonumero="1" decimal="2">
         </label>
         
         <div style="clear:both"></div>    
         <label>
         	Obs Pedido
              <textarea name="obs_pedido" id="obs_pedido"></textarea>
         </label><br/>
                
        </div>
        
   <!-- nao mexe mais -->     
   <div style="clear:both"></div>
   <div style="margin-top:25px;"></div>
   <div style="display:block">
   <input type="hidden" name="produto_derivado_id" id="produto_derivado_id">     
        <label style="width:255px;">
			Produto Derivado
			<input type="text" name="produto_derivado" id="produto_derivado"  value="" busca='modulos/estoque/beneficiamento/busca_produtos.php,@r0,@r1-value>produto_derivado_id|@r2-value>unidade_produto_derivado|@r3-value>fatorconversao|@r4-value>conversao2,0' size="25">
        </label>
        <label>
			QTD
			<input type="text" name="qtd_derivado" id="qtd_derivado" sonumero="1"  size="2"/>
        </label>
       	 <label style="width:50px;">
        	Unidade
            <input type="text" name="unidade_produto_derivado" id="unidade_produto_derivado" readonly="readonly" maxlength="8">
            <input type="hidden" name="fatorconversao2" id="fatorconversao">
            <input type="hidden" name="conversao2" id="conversao2" />
        </label>
        <label style="margin-left:8px;">
			Obs
			<input type="text" name="obs_derivado" id="obs_derivado"  size="22"/>
        </label><br><img src="../fontes/img/mais.png"  width="18" height="18"  id="derivado_mais"  />
       
  		
    </div><br/>
    <div id="derivado_produto"></div>
    <!--<div id="result_derivado"></div>-->
    	<div>
             <table cellpadding="0" cellspacing="0" width="640">
                <thead>
                    <tr>
                        <td width="200" style="border-left:1px solid #CACACA">Produto Derivado</td>
                        <td width="100">Quantia</td>
                        <td>Obs</td>
                        <td width="20"></td>
                    </tr>
                </thead>
             </table>
       </div>
       <div>
       	<table cellpadding="0" cellspacing="0" width="640" >
            <tbody id="result_derivado">
            	
    		</tbody>
		</table>
       </div>
       <div>
             <table cellpadding="0" cellspacing="0" width="640">
                <thead>
                    <tr>
                        <td width="200" style="border-left:1px solid #CACACA"></td>
                        <td width="100" id="qtd_total_derivado">0,00</td>
                        <td > Restante <span id="qtd_restante_derivado"></span></td>
                        <td width="20"></td>
                    </tr>
                </thead>
             </table>
       </div>			
	</fieldset>	
<!--Fim dos fiels set-->

<div>
<input name="action" type="submit"  value="Salvar" style="float:right"  />

<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()
</script>