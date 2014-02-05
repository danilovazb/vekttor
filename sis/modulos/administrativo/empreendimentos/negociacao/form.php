<?
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 

//print_r($r);
//print_r($disponibilidade_tipo);
?><link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
label{ display:block; float:left;}
label input{ width:100%}
</style>
<div id='aSerCarregado'>
<div style="width:620px">
	<div>
		<div class='t3'></div>
		<div class='t1'></div>
		<div  class="dragme" >
			<a class='f_x' onclick="form_x(this)">
			</a>
			<span>Negocia&ccedil;&atilde;o: <?=$disponibilidade_tipo->nome?></span></div>
	</div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
		<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
		<fieldset  id='campos_1' >
			<legend>
			<a onclick="aba_form(this,0)"><strong>Informações</strong></a>
			</legend>
			<label style="width:220px;"> Descri&ccedil;&atilde;o da Negocia&ccedil;&atilde;o
				<input type="text" id="nome" name="nome" value="<?=$r->nome?>" />
			</label>
          <label style="width:220px;">
          <? if($disponibilidade_tipo_id>0 || $r->id >0){
			  
			  $bloq="disabled='disabled'";
		  }else{$bloq='';}?>
            Simulação com Tipo
            <select id='tipo_id' style="height:22px" name="disponibilidade_tipo_id" onchange="document.getElementById('alerta').style.display='none';preencheValor(); calcula_negociacao();">
            <option>Tipo de Disponibilidade</option>
            <?
            $qt = mysql_query($trace="SELECT * FROM disponibilidade_tipo WHERE empreendimento_id='$empreendimento_id'");
			while($rt = mysql_fetch_object($qt)){
				if($disponibilidade_tipo_id==$rt->id || $r->disponibilidade_tipo_id==$rt->id){$sel="selected='selected'";
				$tipo=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade_tipo WHERE empreendimento_id='$empreendimento_id' AND id='{$rt->id}' "));
			}else{$sel='';}
			?>
            	<option <?=$sel?> title="<?=$rt->valor?>" value="<?=$rt->id?>"><?=$rt->nome?></option>
            <?
			}
			?>
            </select>
            </label>
            <label id="alerta" style="width:190px; display:none;"><span style="color:red;">Escolha um tipo de simulação</span>
			</label>
            <div style="clear:both; display:block;"></div>
			<label style="width:90px;"> Valor Total R$
				<input type="text" id='valor' name="valor" value="<?=moedaUsaToBr($tipo->valor)?>"  decimal='2' style="text-align:right" onfocus="this.blur();"/>
			</label>
            <label style="width:60px;">Comissão%
				<input type="text" id='porcentagem_comissao' name="porcentagem_comissao" onkeyup="porcento_valor(vt(),this.value,'valor_comissao');calcula_contrato();" value="<?=moedaUsaToBr($r->comissao_porcentagem)?>"  decimal='2' style="text-align:right"  />
            </label>
            <label style="width:70px;">Comissão R$
				<input type="text" id='valor_comissao' name="valor_comissao" onkeyup=" valor_porcento(vt(),this.value,'porcentagem_comissao');calcula_parcelas_comissao('valor_comissao','ato_parcelas','comissao_valor_parcela');calcula_contrato();" value="<?=moedaUsaToBr($r->comissao_valor)?>"  decimal='2' style="text-align:right"  />
			</label>
            
            <label style="width:80px;">Contrato R$
                <input type="text" id='mostra_contrato'  value="<?=moedaUsaToBr($r->contrato_valor)?>"  decimal='2' style="text-align:right" disabled="disabled" />
                <input type="hidden" id="contrato" name="contrato" value="<?=$r->contrato_valor?>"  />
			</label>
            <? if($r->id>0){ $aparece=''; }else{ $aparece="display:none;";} ?>
            <label  id="label_valor_parcela" <?=$aparece?> style="width:135px; <?=$aparece?>">Parcela comissão <span id="qtd_parcelas_comissao">(<?=$r->ato_parcelas?>x)</span>
				<input type="text"  id="comissao_valor_parcela" name="comissao_valor_parcela" value="<?=moedaUsaToBr($r->comissao_valor_parcela)?>"  decimal='2' style="text-align:right" onkeyup="calcula" />
			</label>
            <div style="clear:both; display:block;"></div>
			<label style="width:90px;"> % Ato
				<input type="text" id='porcentagem_ato' name="porcentagem_ato" value="<?=moedaUsaToBr($r->ato_porcentagem)?>" decimal='2' style="text-align:right" onkeyup="porcento_valor(vt(),this.value,'valor_ato');calcula_restante();"  />
		  </label>
			<label style="width:90px;"> R$ Ato
				<input type="text" id='valor_ato' name="valor_ato" value="<?=moedaUsaToBr($r->ato_valor)?>"  decimal='2' style="text-align:right"  onkeyup="valor_porcento(vt(),this.value,'porcentagem_ato');calcula_restante();"/>
			</label>
            <label style="width:90px;"> Ato Parcelas
				<input type="text" id='ato_parcelas' name="ato_parcelas" value="<?=$r->ato_parcelas?>" sonumero='1'  style="text-align:right"  onkeyup="calcula_parcelas('valor_ato','ato_parcelas','ato_juros','ato_valor_parcela');calcula_parcelas_comissao('valor_comissao','ato_parcelas','comissao_valor_parcela','sim');"/>
			</label>
            <label style="width:60px;"> % Juros
				<input type="text" id='ato_juros' name="ato_juros" value="<?=moedaUsaToBr($r->ato_juros)?>"  style="text-align:right" decimal='2'  onkeyup="calcula_parcelas('valor_ato','ato_parcelas','ato_juros','ato_valor_parcela');"/>
			</label>
            <label style="width:90px;"> R$ Parcelas
				<input type="text" id='ato_valor_parcela' name="ato_valor_parcela" value="<?=moedaUsaToBr($r->ato_valor_parcela)?>" decimal='2' style="text-align:right" readonly="readonly"/>
			</label>
            
            
             <div style="clear:both; width:100%"></div>
		  
          
          <div style="clear:both;"></div>
            
            <label style="width:90px;"> % Mensais
				<input type="text" id='porcentagem_mensais' name="porcentagem_mensais" value="<?=moedaUsaToBr($r->mensais_porcentagem)?>"  decimal='2' style="text-align:right"  
                onkeyup="porcento_valor(vt(),this.value,'mensais_total'); calcula_restante(); "/>
		  </label>
          <label style="width:90px;"> R$ Mensais
				<input type="text" id='mensais_total' name="mensais_total" value="<?=moedaUsaToBr($r->mensais_valor)?>"  decimal='2' style="text-align:right"  
                onkeyup="valor_porcento(vt(),this.value,'porcentagem_mensais'); calcula_restante();"/>
		  </label>
			<label style="width:90px;"> QTD Mensais
				<input type="text" id='mensais_parcelas' name="mensais_parcelas" value="<?=$r->mensais_parcelas?>"  sonumero='1' style="text-align:right"  
                onkeyup="calcula_parcelas('mensais_total','mensais_parcelas','mensais_juros','mensais_valor_parcelas'); "/>
		  </label>
            
			<label style="width:60px;">% Juros
				<input type="text" id='mensais_juros' name="mensais_juros" value="<?=moedaUsaToBr($r->mensais_juros)?>"  decimal='2' style="text-align:right"  onkeyup="calcula_parcelas('mensais_total','mensais_parcelas','mensais_juros','mensais_valor_parcelas'); "/>
		  </label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text" id='mensais_valor_parcelas' name="mensais_valor_parcela" value="<?=moedaUsaToBr($r->mensais_valor_parcela)?>"  decimal='2' style="text-align:right" readonly="readonly"/>
		  </label>
          
          <div style="clear:both;"></div>
             
             
             <label style="width:90px;"> % Semestrais
				<input type="text" id='porcentagem_semestrais' name="porcentagem_semestrais" value="<?=moedaUsaToBr($r->semestrais_porcentagem)?>"  decimal='2'  style="text-align:right"  
                onkeyup="porcento_valor(vt(),this.value,'semestrais_total'); calcula_restante(); "/>
		  </label>
          <label style="width:90px;"> R$ Semestrais
				<input type="text" id='semestrais_total' name="semestrais_total" value="<?=moedaUsaToBr($r->semestrais_valor)?>"  decimal='2' style="text-align:right"  
                onkeyup="valor_porcento(vt(),this.value,'porcentagem_semestrais'); calcula_restante();"/>
		  </label>
              <label style="width:90px;"> QTD Semestrais
				<input type="text" id='semestrais_parcelas' name="semestrais_parcelas" value="<?=$r->semestrais_parcelas?>"  sonumero='1' style="text-align:right"  
                onkeyup="calcula_parcelas('semestrais_total','semestrais_parcelas','semestrais_juros','semestrais_valor_parcelas'); "/>
		  </label>
			<label style="width:60px;">% Juros
				<input type="text" id='semestrais_juros' name="semestrais_juros" value="<?=moedaUsaToBr($r->semestrais_juros)?>"  decimal='2' style="text-align:right"  onkeyup="calcula_parcelas('semestrais_total','semestrais_parcelas','semestrais_juros','semestrais_valor_parcelas');"/>
		  </label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text" id='semestrais_valor_parcelas' name="semestrais_valor_parcela" value="<?=moedaUsaToBr($r->semestrais_valor_parcela)?>" decimal='2' style="text-align:right" readonly="readonly" >
		  </label>
          
          <div style="clear:both;"></div>
              
          <label style="width:90px;"> % Anuais
				<input type="text" id='porcentagem_anuais' name="porcentagem_anuais" value="<?=moedaUsaToBr($r->anuais_porcentagem)?>"  decimal='2' style="text-align:right"  
                onkeyup="porcento_valor(vt(),this.value,'anuais_total'); calcula_restante(); "/>
		  </label>
          <label style="width:90px;"> R$ Anuais
				<input type="text" id='anuais_total' name="anuais_total" value="<?=moedaUsaToBr($r->anuais_valor)?>"  decimal='2' style="text-align:right"  
                onkeyup="valor_porcento(vt(),this.value,'porcentagem_anuais'); calcula_restante();"/>
		  </label>
          <label style="width:90px;"> QTD Anuais
				<input type="text" id='anuais_parcelas' name="anuais_parcelas" value="<?=$r->anuais_parcelas?>"  sonumero='1' style="text-align:right"  
                onkeyup="calcula_parcelas('anuais_total','anuais_parcelas','anuais_juros','anuais_valor_parcelas');calcula_restante();"/>
		  </label>
			<label style="width:60px;">% Juros
				<input type="text" id='anuais_juros' name="anuais_juros" value="<?=moedaUsaToBr($r->anuais_juros)?>"  decimal='2' style="text-align:right"  onkeyup="calcula_parcelas('anuais_total','anuais_parcelas','anuais_juros','anuais_valor_parcelas');"/>
		  </label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text" id='anuais_valor_parcelas' name="anuais_valor_parcela" value="<?=moedaUsaToBr($r->anuais_valor_parcela)?>" decimal='2' style="text-align:right" readonly="readonly"/>
		  </label>
          
           <div style="clear:both; width:100%"></div>
          
          <label style="width:90px; clear:both"> % Chave
				<input type="text" id='porcentagem_chave' name="porcentagem_chave" value="<?=moedaUsaToBr($r->chave_porcentagem)?>"  decimal='2' style="text-align:right"  onkeyup="porcento_valor(vt(),this.value,'valor_chave');calcula_restante();"/>
		  </label>
			<label style="width:90px;"> R$ Chave
				<input type="text" id='valor_chave' name="valor_chave" value="<?=moedaUsaToBr($r->chave_valor)?>" decimal='2' style="text-align:right"  onkeyup="valor_porcento(vt(),this.value,'porcentagem_chave');calcula_restante();" />
		  </label>
			<label style="width:90px;"> Parcelas
				<input type="text"  name="chave_parcelas" value="<?=$r->chave_parcelas?>"  sonumero='1' style="text-align:right" id="chave_parcelas" onkeyup="calcula_parcelas('valor_chave','chave_parcelas','chave_juros','chave_valor_parcelas')"  />
		  </label>
          <label style="width:60px;">% Juros
				<input type="text" id='chave_juros' name="chave_juros" value="<?=moedaUsaToBr($r->chave_juros)?>" decimal='2' style="text-align:right"  onkeyup="calcula_parcelas('valor_chave','chave_parcelas','chave_juros','chave_valor_parcelas');"/>
		  </label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text" id='chave_valor_parcelas' name="chave_valor_parcela" value="<?=moedaUsaToBr($r->chave_valor_parcela)?>" decimal='2' style="text-align:right" readonly="readonly"/>
		  </label>
          
          
             

            <div style="clear:both; width:100%"></div>

		  <label style="width:90px; clear:both"> % Banco
				<input type="text" id='porcentagem_banco' name="porcentagem_banco" value="<?=moedaUsaToBr($r->banco_porcentagem)?>" decimal='2' style="text-align:right" onkeyup="porcento_valor(vt(),this.value,'valor_banco');calcula_restante();" onfocus="this.blur();"  />
		  </label>
			<label style="width:90px;"> R$ Banco
				<input type="text" id='valor_banco' name="valor_banco" value="<?=moedaUsaToBr($r->banco_valor)?>" decimal='2' style="text-align:right" onkeyup="valor_porcento(vt(),this.value,'porcentagem_banco');calcula_restante();" onfocus="this.blur();" />
		  </label>
			<label style="width:90px;"> Parcelas
				<input type="text"  name="banco_parcelas" value="<?=$r->banco_parcelas?>"  sonumero='1' style="text-align:right" id="banco_parcelas" onkeyup="calcula_parcelas('valor_banco','banco_parcelas','banco_juros','banco_valor_parcelas')"  />
		  </label>
			<label style="width:60px;"> % Juros
				<input type="text"  name="banco_juros" value="<?=moedaUsaToBr($r->banco_juros)?>" decimal='2' style="text-align:right" id="banco_juros" onkeyup="calcula_parcelas('valor_banco','banco_parcelas','banco_juros','banco_valor_parcelas')"  />
			</label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text"  name="banco_valor_parcela" value="<?=moedaUsaToBr($r->banco_valor_parcela)?>" decimal='2' style="text-align:right" id="banco_valor_parcelas" readonly="readonly" />
			</label>
<div style="clear:both;"></div>
			<label style="width:90px;"> A ser Pago
				<input type="text" id="restante" value="" decimal='2' style="text-align:right" readonly="readonly"/>
			</label>
Restrito
<br />
<input name="restrito" <? if($r->restrito=='1'){echo "checked='checked'";} ?> value="1" type="checkbox" />
            <input type="hidden" id="zero" value="0" />
			<input name="id" type="hidden" value="<?=$r->id?>" />
		</fieldset>
		<!--Fim dos fiels set-->
		
		<div style="width:100%; text-align:center" >
			<input name="action" type="submit" value="Excluir" style="float:left" />
			<input name="action" type="submit"  value="Salvar" style="float:right"  />
			<div style="clear:both"></div>
		</div>
	</form>
 </label>
</div>
<script>top.openForm()</script>