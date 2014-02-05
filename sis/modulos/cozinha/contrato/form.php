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
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<? 


?>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Contrato</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		<label style="width:200px;">
			Cliente
			<input name="cliente" id="cliente" value="<?=$cliente->razao_social?>" 
            busca='modulos/financeiro/busca_clientes.php?tipo=Cliente,@r0 @r2,@r1-value>cliente_id|@r0-title>cliente,0' 
            valida_minlength='3'
            retorno='focus|Busque o nome do Cliente' autocomplete="off">  
            <input type="hidden" id="cliente_id" name="cliente_id"  value="<?=$contrato->cliente_id?>" />
		</label>
        <label>Almoxarifado
        	<select name="unidade_id">
            	<? $unidades_q=mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
				while($unidade=mysql_fetch_object($unidades_q)){
					if($contrato->unidade_id==$unidade->id){ $sel='selected="selected"';}else{$sel='';}
				?>
                <option <?=$sel?> value="<?=$unidade->id?>"><?=$unidade->nome?></option>
                <? } ?>
            </select>
        
        </label>
        <label style="width:108px;">Data Inicio Contrato
        	<input name="data" id="data" type="text" calendario='1' value="<?=dataUsaToBr($contrato->data)?>"/>
        </label>
        <div style="clear:both;"></div>
        <label style="width:132px; ">
        Valor do Contrato
        <input type="text" sonumero='1' decimal="2" name="valor" value="<?=moedaUsatoBr($contrato->valor)?>" />
        </label>
        <label style="width:120px;">
        Dia de Vencimento 1<input type="text" name="data_vencimento1" maxlength="2" value="<?=$contrato->data_vencimento1?>"/>
        </label>
        <label style="width:120px;">
        Dia de Vencimento 2<input type="text" name="data_vencimento2" maxlength="2" value="<?=$contrato->data_vencimento2?>"/>
        </label>
        <label style="width:100px;">
        Pesagem: <select name="pesagem">
        <option <? if($contrato->pesagem=='leve'){echo 'selected="selected"';} ?> value="leve">Leve</option>
        <option <? if($contrato->pesagem=='medio'){echo 'selected="selected"';} ?> value="medio">Médio</option>
        <option <? if($contrato->pesagem=='pesado'){echo 'selected="selected"';} ?> value="pesado">Pesado</option>
        <option <? if($contrato->pesagem=='muito pesado'){echo 'selected="selected"';} ?> value="muito pesado">Muito Pesado</option>
        </select>
        </label>
        <table style=" float:left; width:600px; clear:both; " cellpadding="0" cellspacing="0">
        
        <thead>
        <tr>
        	<td>Refeição</td>
            <td>Pessoas/Dia</td>
            <td>Pessoas/Mês</td>
            <td>Valor do Prato</td>
        </tr>
        </thead>
        <tbody style="background-color:white;" id="corpo_tabela_contrato">
        <tr class="al">
        	<td style=" font-weight:bold;">Café</td>
            <td style="overflow:hidden; width:90px;">
            <input type="text" value="<?=$contrato->cafe_dia?>" size="5"  name="cafe_dia" /></td>
            <td><input type="text" value="<?=$contrato->cafe_mes?>" size="5"  name="cafe_mes" /></td>
            <td><input type="text" value="<?=moedaUsaToBr($contrato->cafe_valor)?>"  sonumero="1" decimal="2" size="5" name="cafe_valor" /></td>
        </tr>
        <tr>
        	<td style=" font-weight:bold;">Almoço</td>
            <td><input type="text" value="<?=$contrato->almoco_dia?>"  size="5" name="almoco_dia" /></td>
            <td><input type="text" value="<?=$contrato->almoco_mes?>" size="5" name="almoco_mes" /></td>
            <td><input type="text" value="<?=moedaUsaToBr($contrato->almoco_valor)?>" sonumero="1" decimal="2" size="5" name="almoco_valor" /></td>
        </tr>
        <tr class="al">
        	<td style=" font-weight:bold;">Lanche</td>
            <td><input type="text" value="<?=$contrato->lanche_dia?>" size="5" name="lanche_dia"/></td>
            <td><input type="text" value="<?=$contrato->lanche_mes?>"  size="5" name="lanche_mes" /></td>
            <td><input type="text" value="<?=moedaUsaToBr($contrato->lanche_valor)?>" sonumero="1" decimal="2" size="5" name="lanche_valor" /></td>
        </tr>
        <tr>
        	<td style=" font-weight:bold;"	>Janta</td>
            <td><input type="text" value="<?=$contrato->janta_dia?>"  size="5" name="janta_dia" /></td>
            <td><input type="text" value="<?=$contrato->janta_mes?>"  size="5" name="janta_mes" /></td>
            <td><input type="text" value="<?=moedaUsaToBr($contrato->janta_valor)?>" sonumero="1" decimal="2" size="5" name="janta_valor" /></td>
        </tr>
         <tr>
        	<td style=" font-weight:bold;"	>Ceia</td>
            <td><input type="text" value="<?=$contrato->ceia_dia?>"  size="5" name="ceia_dia" /></td>
            <td><input type="text" value="<?=$contrato->ceia_mes?>"  size="5" name="ceia_mes" /></td>
            <td><input type="text" value="<?=moedaUsaToBr($contrato->ceia_valor)?>" sonumero="1" decimal="2" size="5" name="ceia_valor" /></td>
        </tr>
        </tbody></table>
        <div style="clear:both;"></div>
        Status:
        <div style="clear:both;"></div>
        Ativo<input name="status" id="status" value="1" type="radio" <? if($contrato->status==1){ echo 'checked=cheked';}?>/>
        Inativo<input name="status" id="status" value="0" type="radio" <? if($contrato->status==0){ echo 'checked=cheked';}?>/>
	</fieldset>
	<input name="id" type="hidden" value="<?=$contrato->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($contrato->id>0){
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