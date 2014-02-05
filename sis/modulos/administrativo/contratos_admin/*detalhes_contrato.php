<?
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 

print_r($r);
print_r($disponibilidade_tipo);
?>
<style>
label{ display:block; float:left;}
label input{ width:100%}
</style><link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
<div style="width:780px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Detalhes Contrato</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
		<strong>Informações</strong>
		</legend>
		<label style="width:160px;">
			Empreendimento 
			<input type="text" id='empreedimento' name="empreedimento" value="<?=$empreendimento->nome?>" maxlength="255"/>
		</label>
		<label style="width:160px;">
			Tipo
			<input type="text" name="disponibilidade_tipo_nome" id="disponibilidade_tipo_nome" value="<?=$disponibilidade_tipo->nome?>" maxlength="255" sonumero="1";  />
		</label>
		<label style="width:150px;">
			Identificação
			<input type="text" name="identificacao" id="identificacao" value="<?=$r->identificacao?>" maxlength="255" sonumero="1";  />
		</label>
		<label style="width:160px;">
			Valor
			<input type="text" name="valor" id="valor" value="<?=moedaUsaToBr($disponibilidade_tipo->valor)?>" style="text-align:right"  />
		</label>
		<label style="width:320px">
			Cliente 
            <input type="hidden" name='cliente_id' id="cliente_id" value="" valida_minlength='1' />
			<input name="cliente" id='cliente' type="text" value="" maxlength="255"  busca='modulos/administrativo/empreendimentos/disponibilidades/busca_clientes.php,@r2 @r0,@r1-value>cliente_id,0' autocomplete='off' />
		</label>
         <input type="hidden" name='venda_banco_juros' id='venda_banco_juros' value=""  />
         <input type="hidden" name='venda_banco_parcelas' id='venda_banco_parcelas' value=""  />
         <input type="hidden" name='venda_banco_porcentagem' id='venda_banco_porcentagem' value=""  />
         <input type="hidden" name='venda_construtora_juros' id='venda_construtora_juros' value=""  />
         <input type="hidden" name='venda_construtora_periodo' id='venda_construtora_periodo' value=""  />
         <input type="hidden" name='venda_construtora_parcelas' id='venda_construtora_parcelas' value=""  />
         <input type="hidden" name='venda_construtora_porcentagem' id='venda_construtora_porcentagem' value=""  />
         <input type="hidden" name='venda_entrada_juros' id='venda_entrada_juros' value=""  />
         <input type="hidden" name='venda_entrada_parcelas' id='venda_entrada_parcelas' value=""  />
         <input type="hidden" name='venda_entrada_porcentagem' id='venda_entrada_porcentagem' value=""  />
		<label style="width:250px">
			Negociação
			<select id="negociacao_id" onchange="selectNegociacao(this)" name="negociacao_id" style=" width:257px;">
            <option value="0">Selecione uma Negociação</option>
				<?
                $qn = mysql_query("SELECT * FROM negociacao WHERE empreendimento_id= '$r->empreendimento_id'");
				while($rn= mysql_fetch_object($qn)){
					echo "<option value='$rn->id' entrada_porcentagem='$rn->entrada_porcentagem' entrada_parcelas='$rn->entrada_parcelas'entrada_juros='$rn->entrada_juros' construtora_porcentagem='$rn->construtora_porcentagem'construtora_parcelas='$rn->construtora_parcelas' construtora_periodo='$rn->construtora_periodo' construtora_juros='$rn->construtora_juros' banco_porcentagem='$rn->banco_porcentagem'banco_parcelas='$rn->banco_parcelas' banco_juros='$rn->banco_juros'>$rn->nome</option>";
				}
				?>

                
			</select>
		</label>
            <div style="clear:both; width:100%"></div>



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
				<select name="construtora_periodo" id	="construtora_periodo" disabled="disabled">
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




		
		<input name="disponibilidade_id" type="hidden" value="" />
	</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<div style="clear:both"></div>
</div>
</form>
</div>
</div>
<script>top.openForm()</script>