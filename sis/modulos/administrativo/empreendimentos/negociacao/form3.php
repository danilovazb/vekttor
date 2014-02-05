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
<div style="width:600px">
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
			<strong>Informações</strong>
			</legend>
			<label style="width:170;"> Descri&ccedil;&atilde;o da Negocia&ccedil;&atilde;o
				<input type="text" id='nome' name="nome" value="<?=$r->nome?>" />
			</label>
          <label style="width:170;">
            Simulação com Tipo
            <select id='tipo_id' style="height:22px" onchange="document.getElementById('valor').value=moedaUsaToBR(this.value);calcula_negociacao()">
            <option value="<?=$rt->valor?>">Tipo de Disponibilidade</option>
            <?
            $qt = mysql_query($trace="SELECT * FROM disponibilidade_tipo WHERE empreendimento_id='$empreendimento_id'");
			while($rt = mysql_fetch_object($qt)){
			?>
            	<option value="<?=$rt->valor?>"><?=$rt->nome?></option>
            <?
			}
			?>
            </select>
            </label>
			<label style="width:120;"> Valor
				<input type="text" id='valor' name="valor" value="<?=moedaUsaToBr($disponibilidade_tipo->valor)?>"  decimal='2' style="text-align:right" disabled="disabled" />
			</label>
			<label style="width:90px;"> % Entrada
				<input type="text" id='porcentagem_entrada' name="porcentagem_entrada" value="<?=moedaUsaToBr($r->entrada_porcentagem)?>"  decimal='2' style="text-align:right" onkeyup="porcento_valor(vt(),this.value,'valor_entrada');calcula_banco();"  />
		  </label>
			<label style="width:90px;"> R$ Entrada
				<input type="text" id='valor_entrada' name="valor_entrada" value=""  decimal='2' style="text-align:right"  onkeyup="valor_porcento(vt(),this.value,'porcentagem_entrada');calcula_banco();"/>
			</label>
			<label style="width:90px;"> Parcelas
				<input type="text" id='entrada_parcelas' name="entrada_parcelas" value="<?=$r->entrada_parcelas?>"  sonumero='1' style="text-align:right"  onkeyup="calcula_parcelas('valor_entrada','entrada_parcelas','entrada_juros','entrada_valor_parcelas')"/>
		  </label>
            
			<label style="width:60px;">% Juros
				<input type="text" id='entrada_juros' name="entrada_juros" value="<?=moedaUsaToBr($r->entrada_juros)?>"  decimal='2' style="text-align:right"  onkeyup="calcula_parcelas('valor_entrada','entrada_parcelas','entrada_juros','entrada_valor_parcelas')"/>
		  </label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text" id='entrada_valor_parcelas' name="entrada_valor_parcelas" value=""  decimal='2' style="text-align:right"   disabled="disabled"/>
		  </label>
            
            
            
            
            
            
            <div style="clear:both; width:100%"></div>
		  <label style="width:90px; clear:both"> % Construtora
				<input type="text" id='porcentagem_construtora' name="porcentagem_construtora" value="<?=moedaUsaToBr($r->construtora_porcentagem)?>"  decimal='2' style="text-align:right"  onkeyup="porcento_valor(vt(),this.value,'valor_construtora');calcula_banco();"/>
		  </label>
			<label style="width:90px;"> R$ Construtora
				<input type="text" id='valor_construtora' name="valor_construtora" value=""  decimal='2' style="text-align:right"  onkeyup="valor_porcento(vt(),this.value,'porcentagem_construtora');calcula_banco();" />
		  </label>
			<label style="width:45px;"> Parcelas
				<input type="text"  name="construtora_parcelas" value="<?=$r->construtora_parcelas?>"  sonumero='1' style="text-align:right" id="construtora_parcelas" onkeyup="calcula_parcelas('valor_construtora','construtora_parcelas','construtora_juros','construtora_valor_parcelas')"  />
		  </label>
			<label style="width:70px;"> Periodo<?
            $construtora_periodo[$r->construtora_periodo]='selected="selected"';
			?>
				<select name="construtora_periodo">
                	<option value="1" <?= $construtora_periodo[1]?>>Mensal</option>
                	<option value="3"<?= $construtora_periodo[3]?>>Triemestral</option>
                	<option value="6"<?= $construtora_periodo[6]?>>Semestral</option>
                	<option value="12"<?= $construtora_periodo[12]?>>Anual</option>
                </select>
			</label>
			<label style="width:50px;"> % Juros
				<input type="text"  name="construtora_juros" value="<?=moedaUsaToBr($r->construtora_juros)?>"  decimal='2' style="text-align:right" id="construtora_juros" onkeyup="calcula_parcelas('valor_construtora','construtora_parcelas','construtora_juros','construtora_valor_parcelas')"  />
			</label>
			<label style="width:70px;"> R$ Parcelas
				<input type="text"  name="construtora_valor_parcelas" value=""  decimal='2' style="text-align:right" id="construtora_valor_parcelas"  disabled="disabled" />
			</label>



            <div style="clear:both; width:100%"></div>

		  <label style="width:90px; clear:both"> % Banco
				<input type="text" id='porcentagem_banco' name="porcentagem_banco" value="<?=moedaUsaToBr($r->banco_porcentagem)?>"  decimal='2' style="text-align:right" onkeyup="porcento_valor(vt(),this.value,'valor_banco');calcula_banco();" />
		  </label>
			<label style="width:90px;"> R$ Banco
				<input type="text" id='valor_banco' name="valor_banco" value=""  decimal='2' style="text-align:right" onkeyup="valor_porcento(vt(),this.value,'porcentagem_banco');calcula_banco();" />
		  </label>
			<label style="width:90px;"> Parcelas
				<input type="text"  name="banco_parcelas" value="<?=$r->banco_parcelas?>"  sonumero='1' style="text-align:right" id="banco_parcelas" onkeyup="calcula_parcelas('valor_banco','banco_parcelas','banco_juros','banco_valor_parcelas')"  />
		  </label>
			<label style="width:60px;"> % Juros
				<input type="text"  name="banco_juros" value="<?=moedaUsaToBr($r->banco_juros)?>"  decimal='2' style="text-align:right" id="banco_juros" onkeyup="calcula_parcelas('valor_banco','banco_parcelas','banco_juros','banco_valor_parcelas')"  />
			</label>
			<label style="width:90px;"> R$ Parcelas
				<input type="text"  name="banco_valor_parcelas" value=""  decimal='2' style="text-align:right" id="banco_valor_parcelas"  disabled="disabled" />
			</label>

	
    
    
    
    
    		<label style="width:512px;"> Observação
				<textarea id='obs' name="obs" value="" /><?=$r->obs?></textarea>
			</label>
            
            
            
            
            
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