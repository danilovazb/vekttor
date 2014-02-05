<?

//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("../_functions_financeiro.php");
include("_functions_contrato.php");
include("_ctrl_contrato.php");

?>
<style>
input,select,textarea{display:block; }
label{ float:left}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario" style="top:30px; left:50px; position:fixed">
<div id='aSerCarregado'>
<div  style="width:620px">

<script src="contrato.js" language="javascript" type="application/javascript"></script>
<script src="../../../../fontes/js/sis.js" language="javascript" type="application/javascript"></script>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Contrato</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" id='form_transferencia_entre_contas' method="post" enctype="multipart/form-data" autocomplete='off'>
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Dados do Contrato</strong>
		</legend>
        <input type="hidden" name="cliente_fornecedor_id" id="cliente_fornecedor_id" value="<?=$cliente_fornecedor->id?>"   />
		<label style="width:250px;">
			Fornecedor
            <input name="cliente" id="cliente" value="<?=$cliente_fornecedor->razao_social?>" 
            busca='modulos/financeiro/busca_clientes.php,@r0 @r2,@r1-value>cliente_fornecedor_id|@r0-title>cliente,0' 
            valida_minlength='3'
            retorno='focus|Busque o nome do Cliente' autocomplete="off">        
		</label>
		<label style="width:250px;">
			Descri&ccedil;&atilde;o
			  <input type="text"  name="nome" id="nome" value="<?=$contrato->nome?>" />
        </label>
		<label style="width:90px;">
			Nº Contrato
			  <input type="text"    sonumero='1'  name="numero" id="numero" value="<?=$contrato->numero?>"/>
        </label>
		<label style="width:90px;">
			R$ Contrato
			  <input type="text"   decimal="2" sonumero='1' moeda='1'  style="text-align:right;" name="valor_total" id="valor_total" onkeyup="carregador.calc_parcela()" value="<?=moedaUsaToBr($contrato->valor_contrato)?>"/>
        </label>
		<label style="width:90px;">
			R$ Entrada
			  <input type="text"   decimal="2" sonumero='1' moeda='1'  style="text-align:right;" name="valor_entrada" id="valor_entrada" onkeyup="carregador.calc_parcela()" value="<?=moedaUsaToBr($contrato->valor_entrada)?>"/>
        </label>
		<label style="width:90px;">
			N&ordm; de Parcelas
			   <input type="text" sonumero='1' style="text-align:center;" onkeyup="carregador.calc_parcela()" name="parcelas" id="parcelas" value="<?=$contrato->parcelas?>"/>
        </label>
<label style="width:80px;">
			R$ Parcela
			  <input type="text"   decimal="2" sonumero='1' moeda='1'  style="text-align:right;" name="valor_parcela" id="valor_parcela" value="<?=moedaUsaToBr($contrato->valor_parcela)?>"/>
        </label>        <div style="clear:both"></div>
<label style="width:100px;">
			R$ Total j&aacute; pago
			  <input type="text"   decimal="2" sonumero='1' moeda='1'  style="text-align:right;" name="valor_total_pago" id="valor_total_pago" value="<?=moedaUsaToBr($contrato->valor_pago_em_parcelas+$movimento_contrato['total'])?>" />
        </label>
        
        <label style="width:90px;">
			Parcelas Pagas
			  <input type="text" onchange="carregador.calc_parcelas_penentes()"   sonumero='1' style="text-align:center;" name="parcelas_pagas" id="parcelas_pagas" value="<?=$contrato->parcelas_pagas+$movimento_contrato['parcelas']?>"/>
        </label>
		
		<label style="width:100px;">
			R$ Parcelas Pagas
			  <input type="text"   decimal="2" sonumero='1' moeda='1'  style="text-align:right;" name="valor_parcela_paga" id="valor_parcela_paga" onkeyup="carregador.calc_total_parcelado()"  value="<?=moedaUsaToBr(@(($contrato->valor_pago_em_parcelas+$movimento_contrato['total'])/$contrato->parcelas_pagas))?>"/>
        </label>
        <div style="clear:both;"></div>
		<label style="width:90px;">
			Parcelas Penden
			  <input type="text"   sonumero='1' style="text-align:center;" name="parcelas_pendentes" id="parcelas_pendentes"  onfocus="return this.blur(); document.getElementById('data_proxima_parcela').focus()" value="<?=$contrato->parcelas-$contrato->parcelas_pagas?>"/>
        </label>
		<label style="width:120px;">
			Data Pr&oacute;xima Parcela
			  <input type="text"   name="data_proxima_parcela" id="data_proxima_parcela" calendario='1' mascara='__/__/____' value="<?=dataUsaToBr($contrato->data_pagamento)?>"/>
        </label>
        <div style="float:left">
<span  >Tipo de Parcela</span><br />
        		<input type="radio" name="parcela_tipo" value="fixa" />  Fixa
        		<input type="radio" name="parcela_tipo" value="variada"/>  Variada
</div>

        <div style="clear:both;"></div>

        <label style="width:120px;">
            
			Centro de Custos
			<select name="centro_custo_id" id=''>
              	<?
    
				exibe_option_sub_plano_ou_centro('centro',0,$contrato->centro_id,0);

				?>
              </select>
        </label>
        
                <label style="width:120px;">
			Plano de Conta
			<select name="plano_de_conta_id">
              	<?

			exibe_option_sub_plano_ou_centro('plano',0,$contrato->plano_id,0);

				?>
              </select>
        </label>



	</fieldset>
	
	<input name="action_contrato" type="hidden" value="1" />
	<input name="contrato_id" type="hidden" value="<?=$contrato->id?>" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($contrato->id>0 ){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
  <input  type="button"  value="Salvar"  style="float:right" onclick="if(confirm('Será criado também os proximos movimentos em contas a pagar.')){this.parentNode.parentNode.submit()}" /><div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()
</script>