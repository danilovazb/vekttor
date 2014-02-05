<link href="../../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='aSerCarregado'>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Reserva</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
		<strong>Informações</strong>
		</legend>
		<label style="width:340;">
			Empreendimento 
			<input type="text" id='empreedimento' name="empreedimento" value="" maxlength="255"/>
		</label>
		<label style="width:160px;">
			Disponibilidade
			<input type="text" name="disponibilidade" id="disponibilidade" value="" maxlength="23" sonumero="1";  />
		</label>
		<label style="width:250px">
			Entrada
			<input name="entrada" id='entrada' type="text" value="" maxlength="255" sonumero='1' decimal="2" style="text-align:right" />
		</label>
		<label style="width:250px">
			Cliente
			<input name="inicio" id='inicio' type="text" value="" maxlength="255" style="text-align:right" />
		</label>
		<label style="width:250px">
			Data Limite
			<input name="data_limite" id='data_limite' type="text" value="" maxlength="23" sonumero='1' mascara='__/__/____' style="text-align:right" />
		</label>
		<label style="width:250px">
			Negociação
			<select id="negociacao" name="negociacao" style=" width:257px;">
				<option> 30% de entrada + 36x</option>
			</select>
		</label>
		<label style="width:517px;">
			Observação 
			<textarea id='obs' name="obs" value="" /></textarea>
		</label>
		<input name="disponibilidade_id" type="hidden" value="" />
		<div class="divisao_options">
			<span class="titulo_options">Também estão na reserva</span>
			<table cellpadding="2" width="525">
				<tr bgcolor="#999999">
					<td>Nome</td>
					<td>Corretor</td>
					<td>Data</td>
				</tr>
				<tr>
					<td>Nome de Teste</td>
					<td>Corretor de Teste</td>
					<td>Data de Teste</td>
				</tr>
				<tr>
					<td>Nome de Teste</td>
					<td>Corretor de Teste</td>
					<td>Data de Teste</td>
				</tr>
				<tr>
					<td>Nome de Teste</td>
					<td>Corretor de Teste</td>
					<td>Data de Teste</td>
				</tr>
				<tr>
					<td>Nome de Teste</td>
					<td>Corretor de Teste</td>
					<td>Data de Teste</td>
				</tr>
			</table>	
			<div style="clear:both"></div>
		</div>
	</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit" value="Excluir" style="float:left" />
<input name="action" type="submit"  value="Reservar" style="float:right"  />
<input name="action" type="submit"  value="Finalizar Venda" style="float:right; margin-right:5px;"  />
<div style="clear:both"></div>
</div>
</form>
</div>
<script>top.openForm()</script>