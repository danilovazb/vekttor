<?
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 

print_r($r);
print_r($disponibilidade_tipo);
?>
<style>
label{ display:block; float:left;}
label input{ width:100%}
</style><link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
<div style="width:780px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Venda</span></div>
    </div>
	<form onsubmit="return validaForm(this)" action="?tela_id=70" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
		<a onclick="aba_form(this,0);"><strong>Informações</strong></a>
        <a onclick="aba_form(this,1);">Valores de ato e comissao</a>
		</legend>
		<label style="width:160px;">
			Empreendimento 
			<input type="text" id='empreedimento' name="empreedimento" value="<?=$empreendimento->nome?>"  onfocus="this.blur();"/>
            <input type="hidden" id="empreendimento_id" name="empreendimento_id" value="<?=$empreendimento_id?>" onfocus="this.blur();" />
		</label>
		<label style="width:160px;">
			Tipo
			<input type="text" name="disponibilidade_tipo_nome" id="disponibilidade_tipo_nome" value="<?=$disponibilidade_tipo->nome?>" onfocus="this.blur();"  />
		</label>
		<label style="width:150px;">
			Identificação
			<input type="text" name="identificacao" id="identificacao" value="<?=$r->identificacao?>" onfocus="this.blur();"  />
		</label>
		<label style="width:100px;">
			Valor
			<input type="text" name="valor" id="valor" onfocus="this.blur();" value="<?=moedaUsaToBr($disponibilidade_tipo->valor)?>"  style="text-align:right"  />
		</label>
		<label style="width:240px">
			Cliente 
            <input type="hidden" name='cliente_id' id="cliente_id" value="" valida_minlength='1' />
        <input type="hidden" id="empreendimento_id" value="<?=$r->empreendimento_id?>" />
			<input name="cliente" id='cliente' type="text" value="" maxlength="255"  busca='modulos/administrativo/empreendimentos/disponibilidades/busca_clientes.php,@r0 @r2,@r1-value>cliente_id,0' autocomplete='off' />
		</label>
         <input type="hidden" name='venda_ato_porcentagem' id='venda_ato_porcentagem' value=""  />
         <input type="hidden" name='venda_ato_parcelas' id='venda_ato_parcelas' value=""  />
         <input type="hidden" name='venda_ato_juros' id='venda_ato_juros' value=""  />
         <input type="hidden" name='venda_anuais_porcentagem' id='venda_anuais_porcentagem' value=""  />
         <input type="hidden" name='venda_anuais_parcelas' id='venda_anuais_parcelas' value=""  />
         <input type="hidden" name='venda_anuais_juros' id='venda_anuais_juros' value=""  />
         <input type="hidden" name='venda_semestrais_porcentagem' id='venda_semestrais_porcentagem' value=""  />
         <input type="hidden" name='venda_semestrais_parcelas' id='venda_semestrais_parcelas' value=""  />
         <input type="hidden" name='venda_semestrais_juros' id='venda_semestrais_juros' value=""  />
         <input type="hidden" name='venda_mensais_porcentagem' id='venda_mensais_porcentagem' value=""  />
         <input type="hidden" name='venda_mensais_parcelas' id='venda_mensais_parcelas' value=""  />
         <input type="hidden" name='venda_mensais_juros' id='venda_mensais_juros' value=""  />
         <input type="hidden" name='venda_chave_porcentagem' id='venda_chave_porcentagem' value=""  />
         <input type="hidden" name='venda_chave_parcelas' id='venda_chave_parcelas' value=""  />
         <input type="hidden" name='venda_chave_juros' id='venda_chave_juros' value=""  />
         <input type="hidden" name='venda_banco_porcentagem' id='venda_banco_porcentagem' value=""  />
         <input type="hidden" name='venda_banco_parcelas' id='venda_banco_parcelas' value=""  />
         <input type="hidden" name='venda_banco_juros' id='venda_banco_juros' value=""  />
         
         
		<label style="width:160px">
			Negociação
			<select id="negociacao_id" onchange="selectNegociacao(this)" name="negociacao_id" style=" width:160px;" valida_valor="1,99999">
            <option value="0">Selecione uma Negociação</option>
            
				<?
				
				//negociacoes normais
                $qn = mysql_query("SELECT * FROM negociacao WHERE vkt_id='$vkt_id' AND empreendimento_id='{$r->empreendimento_id}' AND disponibilidade_tipo_id='{$disponibilidade_tipo->id}' AND restrito!='1' ");
				while($rn= mysql_fetch_object($qn)){
					echo "<option value='$rn->id' comissao_porcentagem='{$rn->comissao_porcentagem}' comissao_valor='{$rn->comissao_valor}' comissao_valor_parcela='{$rn->comissao_valor_parcela}' contrato_valor='{$rn->contrato_valor}' ato_valor='{$rn->ato_valor}' ato_porcentagem='{$rn->ato_porcentagem}' ato_parcelas='$rn->ato_parcelas' ato_valor_parcela='{$rn->ato_valor_parcela}' ato_juros='$rn->ato_juros' anuais_valor='{$rn->anuais_valor}' anuais_porcentagem='$rn->anuais_porcentagem' anuais_valor_parcela='{$rn->anuais_valor_parcela}' anuais_parcelas='$rn->anuais_parcelas' anuais_juros='$rn->anuais_juros' semestrais_valor='{$rn->semestrais_valor}' semestrais_porcentagem='$rn->semestrais_porcentagem' semestrais_valor_parcela='{$rn->semestrais_valor_parcela}' semestrais_parcelas='$rn->semestrais_parcelas' semestrais_juros='$rn->semestrais_juros' mensais_valor='{$rn->mensais_valor}' mensais_porcentagem='$rn->mensais_porcentagem' mensais_valor_parcela='{$rn->mensais_valor_parcela}' mensais_parcelas='$rn->mensais_parcelas' mensais_juros='$rn->mensais_juros' chave_valor='{$rn->chave_valor}' chave_porcentagem='$rn->chave_porcentagem' chave_valor_parcela='{$rn->chave_valor_parcela}' chave_parcelas='$rn->chave_parcelas' chave_juros='$rn->chave_juros' banco_valor='{$rn->banco_valor}' banco_porcentagem='$rn->banco_porcentagem' banco_valor_parcela='{$rn->banco_valor_parcela}' banco_parcelas='$rn->banco_parcelas' banco_juros='$rn->banco_juros' >$rn->nome</option>";
				}
				?>

                
			</select>
		</label>
        <label style="width:160px">
			Corretor
			<select id="corretor_id" name="corretor_id" style=" width:160px;" valida_valor="1,99999" retorno="focus|Escolha um corretor">
          <option value="0">Selecione um corretor</option>
				<?
                $cn = mysql_query("SELECT * FROM corretor WHERE vkt_id='$vkt_id	'");
				while($corretor= mysql_fetch_object($cn)){
					echo "<option value='$corretor->id' >$corretor->nome</option>";
				}
				?>

                
			</select>
		</label>
        
            <div style="clear:both; width:100%"></div>


			
            <label style="width:90px;"> Data Pagamento
				<input type="text" id='data_primeiro_pagamento' name="data_primeiro_pagamento" retorno='focus|Escolha uma data de pagamento' calendario="1" value="<?=moedaUsaToBr($r->comissao_porcentagem)?>" style="text-align:right" mascara="__/__/____"  valida_data='01/01/0001,25/08/9999' />
                </label>
			<label style="width:90px;"> % Comissão
				<input type="text" id='porcentagem_comissao'  onfocus="this.blur();" name="porcentagem_comissao" onkeyup="porcento_valor(vt(),this.value,'valor_comissao');calcula_contrato();" value=""  decimal='2' style="text-align:right"  />
                </label>
            <label style="width:90px;">Comissão R$
				<input type="text" id='valor_comissao' name="valor_comissao" onkeyup="valor_porcento(vt(),this.value,'porcentagem_comissao'); calcula_contrato();" sonumero="1" style="text-align:right" onfocus="this.blur();" />
			</label>
            <label style="width:130px;"> Valor de Contrato R$
                <input id="contrato" name="contrato" value="<?=$disponibilidade_tipo->contrato?>" onfocus="this.blur()"  />
			</label>
    <label  id="label_valor_parcela" <?=$aparece?> style="width:135px; <?=$aparece?>">Parcela comissão <span id="qtd_parcelas_comissao"></span>
				<input type="text"  id="comissao_valor_parcela" name="comissao_valor_parcela" value="<?=moedaUsaToBr($r->comissao_valor_parcela)?>"  decimal='2' style="text-align:right" onkeyup="calcula_contrato();"  onfocus="this.blur();" />
            </label>
            <div style="clear:both; display:block;"></div>
			<label style="width:90px;"> % Ato
				<input type="text" id='porcentagem_ato' name="porcentagem_ato" value="<?=moedaUsaToBr($r->ato_porcentagem)?>"  onfocus="this.blur();" decimal='2' style="text-align:right" onkeyup="porcento_valor(vt(),this.value,'valor_ato');calcula_restante();"  />
		  </label>
			<label style="width:90px;"> R$ Ato
				<input type="text" id='valor_ato' name="valor_ato" value=""  onfocus="this.blur();" decimal='2' style="text-align:right"  onkeyup="valor_porcento(vt(),this.value,'porcentagem_ato');calcula_restante();"/>
			</label>
            <label style="width:90px;"> Ato Parcelas
				<input type="text" id='ato_parcelas' name="ato_parcelas" value="<?=moedaUsaToBr($r->ato_parcelas)?>"  onfocus="this.blur();" style="text-align:right"  onkeyup="calcula_parcelas('valor_ato','ato_parcelas','ato_juros','ato_valor_parcela'); calcula_contrato();"/>
			</label>
            <label style="width:60px;"> % Juros
				<input type="text" id='ato_juros' name="ato_juros" value="<?=moedaUsaToBr($r->ato_juros)?>"  onfocus="this.blur();"  style="text-align:right" decimal='2'  onkeyup="calcula_parcelas('valor_ato','ato_parcelas','ato_juros','ato_valor_parcela');"/>
			</label>
            <label style="width:90px;"> R$ Parcelas
				<input type="text" id='ato_valor_parcela' name="ato_valor_parcela" value=""   decimal='2' style="text-align:right" onfocus="this.blur();"   />
			</label>
            
            
		
             
            <div style="clear:both;"></div>
            
            <label style="width:90px;"> % Mensais
				<input type="text" id='porcentagem_mensais' name="porcentagem_mensais" value="<?=moedaUsaToBr($r->mensais_porcentagem)?>"  onfocus="this.blur();"  sonumero='1' decimal='2' style="text-align:right"  
                onkeyup="porcento_valor(vt(),this.value,'mensais_total'); calcula_restante(); "/>
		  </label>
          <label style="width:90px;"> R$ Mensais
				<input type="text" id='mensais_total' name="mensais_total" value="<?=$r->entrada_parcelas?>"  onfocus="this.blur();"  sonumero='1' decimal='2' style="text-align:right"  
                onkeyup="valor_porcento(vt(),this.value,'porcentagem_mensais'); calcula_restante();"/>
		  </label>
			<label style="width:90px;"> QTD Mensais
				<input type="text" id='mensais_parcelas' name="mensais_parcelas" value="<?=$r->mensais_parcelas?>"  onfocus="this.blur();"  sonumero='1' style="text-align:right"  
                onkeyup="calcula_parcelas('mensais_total','mensais_parcelas','mensais_juros','mensais_valor_parcelas'); "/>
		  </label>
            
			<label style="width:60px;">% Juros
				<input type="text" id='mensais_juros' name="mensais_juros" value="<?=moedaUsaToBr($r->mensais_juros)?>" onfocus="this.blur();" decimal='2' style="text-align:right"  onkeyup="calcula_parcelas('mensais_total','mensais_parcelas','mensais_juros','mensais_valor_parcelas'); "/>
		  </label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text" id='mensais_valor_parcelas' name="mensais_valor_parcelas" value=""  decimal='2' style="text-align:right" onfocus="this.blur();"/>
		  </label>
          
          
          <div style="clear:both;"></div>
             
             
             <label style="width:90px;"> % Semestrais
				<input type="text" id='porcentagem_semestrais' onfocus="this.blur();" name="porcentagem_semestrais" value="<?=moedaUsaToBr($r->semestrais_porcentagem)?>"  sonumero='1' decimal='2' style="text-align:right"  
                onkeyup="porcento_valor(vt(),this.value,'semestrais_total'); calcula_restante(); "/>
		  </label>
          <label style="width:90px;"> R$ Semestrais
				<input type="text" id='semestrais_total' name="semestrais_total" value="<?=$r->entrada_parcelas?>"  onfocus="this.blur();" sonumero='1' decimal='2' style="text-align:right"  
                onkeyup="valor_porcento(vt(),this.value,'porcentagem_semestrais'); calcula_restante();"/>
		  </label>
              <label style="width:90px;"> QTD Semestrais
				<input type="text" id='semestrais_parcelas' name="semestrais_parcelas" value="<?=$r->semestrais_parcelas?>" onfocus="this.blur();"  sonumero='1' style="text-align:right"  
                onkeyup="calcula_parcelas('semestrais_total','semestrais_parcelas','semestrais_juros','semestrais_valor_parcelas'); "/>
		  </label>
            
			<label style="width:60px;">% Juros
				<input type="text" id='semestrais_juros' name="semestrais_juros" value="<?=moedaUsaToBr($r->semestrais_juros)?>" onfocus="this.blur();"  decimal='2' style="text-align:right"  onkeyup="calcula_parcelas('semestrais_total','semestrais_parcelas','semestrais_juros','semestrais_valor_parcelas');"/>
		  </label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text" id='semestrais_valor_parcelas' name="semestrais_valor_parcelas" value=""  decimal='2' style="text-align:right"   onfocus="this.blur();" />
		  </label>
          
          
          
          <div style="clear:both;"></div>
            
            
            
          <label style="width:90px;"> % Anuais
				<input type="text" id='porcentagem_anuais' name="porcentagem_anuais" onfocus="this.blur();" value="<?=moedaUsaToBr($r->anuais_porcentagem)?>"  sonumero='1' decimal='2' style="text-align:right"  
                onkeyup="porcento_valor(vt(),this.value,'anuais_total'); calcula_restante(); "/>
		  </label>
          <label style="width:90px;"> R$ Anuais
				<input type="text" id='anuais_total' name="anuais_total" value="<?=$r->entrada_parcelas?>" onfocus="this.blur();"  sonumero='1' decimal='2' style="text-align:right"  
                onkeyup="valor_porcento(vt(),this.value,'porcentagem_anuais'); calcula_restante();"/>
		  </label>
          <label style="width:90px;"> QTD Anuais
				<input type="text" id='anuais_parcelas' name="anuais_parcelas" value="<?=$r->anuais_parcelas?>" onfocus="this.blur();" sonumero='1' style="text-align:right"  
                onkeyup="calcula_parcelas('anuais_total','anuais_parcelas','anuais_juros','anuais_valor_parcelas');calcula_restante();"/>
		  </label>
			<label style="width:60px;">% Juros
				<input type="text" id='anuais_juros' name="anuais_juros" value="<?=moedaUsaToBr($r->anuais_juros)?>" onfocus="this.blur();"  decimal='2' style="text-align:right"  onkeyup="calcula_parcelas('anuais_total','anuais_parcelas','anuais_juros','anuais_valor_parcelas');"/>
		  </label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text" id='anuais_valor_parcelas' name="anuais_valor_parcelas" value=""  decimal='2' style="text-align:right"   onfocus="this.blur();" />
		  </label>
         
            
            
            <div style="clear:both; width:100%"></div>

		  <label style="width:90px; clear:both"> % Banco
				<input type="text" id='porcentagem_banco' name="porcentagem_banco" value="<?=moedaUsaToBr($r->banco_porcentagem)?>"  decimal='2' style="text-align:right" onkeyup="porcento_valor(vt(),this.value,'valor_banco');calcula_restante();"  onfocus="this.blur();" />
		  </label>
			<label style="width:90px;"> R$ Banco
				<input type="text" id='valor_banco' name="valor_banco" value=""  decimal='2' style="text-align:right" onkeyup="valor_porcento(vt(),this.value,'porcentagem_banco');calcula_restante();" onfocus="this.blur();" />
		  </label>
			<label style="width:90px;"> Parcelas
				<input type="text"  name="banco_parcelas" value="<?=$r->banco_parcelas?>" onfocus="this.blur();" sonumero='1' style="text-align:right" id="banco_parcelas" onkeyup="calcula_parcelas('valor_banco','banco_parcelas','banco_juros','banco_valor_parcelas')"  />
		  </label>
			<label style="width:60px;"> % Juros 
				<input type="text"  name="banco_juros" value="<?=moedaUsaToBr($r->banco_juros)?>" onfocus="this.blur();"  decimal='2' style="text-align:right" id="banco_juros" onkeyup="calcula_parcelas('valor_banco','banco_parcelas','banco_juros','banco_valor_parcelas')"  />
			</label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text"  name="banco_valor_parcelas" value=""  decimal='2' style="text-align:right" id="banco_valor_parcelas"   onfocus="this.blur();" />
			</label>
            <input type="hidden" id="restante" />
<div style="clear:both;"></div>

  <label style="width:90px; clear:both"> % Chave
				<input type="text" id='porcentagem_chave' name="porcentagem_chave" value="<?=moedaUsaToBr($r->chave_porcentagem)?>"  decimal='2' style="text-align:right"  onkeyup="porcento_valor(vt(),this.value,'valor_chave');calcula_restante();"/>
		  </label>
			<label style="width:90px;"> R$ Chave
				<input type="text" id='valor_chave' name="valor_chave" value=""  decimal='2' style="text-align:right"  onkeyup="valor_porcento(vt(),this.value,'porcentagem_chave');calcula_restante();" />
		  </label>
			<label style="width:90px;"> Parcelas
				<input type="text"  name="chave_parcelas" value="<?=$r->chave_parcelas?>"  sonumero='1' style="text-align:right" id="chave_parcelas" onkeyup="calcula_parcelas('valor_chave','chave_parcelas','chave_juros','chave_valor_parcelas')"  />
		  </label>
          <label style="width:60px;">% Juros
				<input type="text" id='chave_juros' name="chave_juros" value="<?=moedaUsaToBr($r->chave_juros)?>"  decimal='2' style="text-align:right"  onkeyup="calcula_parcelas('valor_chave','chave_parcelas','chave_juros','chave_valor_parcelas');"/>
		  </label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text" id='chave_valor_parcelas' name="chave_valor_parcelas" value=""  decimal='2' style="text-align:right"   onfocus="this.blur();" />
		  </label>
			
		
		<input name="disponibilidade_id" type="hidden" value="<?=$r->id?>" />
	</fieldset>
    <fieldset id="campos_2" style="display:none;">
        <legend>
            <a onclick="aba_form(this,0);">Informações</a>
            <a onclick="aba_form(this,1);"><strong>Valores de ato e comissao</strong></a>
        </legend>
        <div style="float:left; width:200px;">
         <label style="width:150px;">
        	Imobiliária(Comissão)
            <input type="text" id="comissao_restante" onfocus="this.blur();" />
        </label>
         <div style="float:left; width:150px;" id="campos_comissao"></div>
         <div style=" width:180px;" id="faltando_comissao"></div>
        </div>
        
        <div style="float:left; width:200px;">
        <label style="width:150px; ">
        	Construtora(Ato) 
            <input type="text" id="ato_restante" onfocus="this.blur();"  />
        </label>
        <div style="float:left; width:150px;" id="campos_ato"></div>
        <div style="float:left; width:180px;"id="faltando_ato"></div>
        </div>
        
        <div style="float:left; width:200px;">
        <label style="width:150px; ">
        	Total 
            <input type="text" id="total_restante" onfocus="this.blur();" />
        </label>
		<div style="float:left; width:150px;" id="campos_total"></div>
        <div style="float:left; width:180px;" id="faltando_total"></div>
         </div>
        
        
        
    </fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Finalizar Venda" style="float:right; margin-right:5px;"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
<script>top.openForm()</script>