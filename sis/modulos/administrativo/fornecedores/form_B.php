<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
<div style="width:710px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Clientes</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<input id='tipo_cadastro' name="tipo_cadastro" type="hidden" value="<? if($cliente_fornecedor->id>0)echo $cliente_fornecedor->tipo_cadastro; else echo "Jurídico"; ?>" />
	<input name="cliente_fornecedor_id" type="hidden" value="<?=$cliente_fornecedor_id?>" />
		<fieldset  id='campos_1' <? if($cliente_fornecedor->tipo_cadastro=="Físico")echo 'style="display:none"'; ?> >
			<legend>
				<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong>Jurídico</strong></a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';">Físico</a>
			</legend>
			<div>
				<input type="hidden" name="j_tipo" value="<?=$cliente_fornecedor->tipo?>">
			</div>
			<label style="width:294px; margin-right:23px;">
				Razão Social
				<input type="text" id='j_razao_social' name="j_razao_social" value="<?=$cliente_fornecedor->razao_social?>" />
			</label>
			<label style="width:294px;">
				Nome Fantasia
				<input type="text" id='j_nome_fantasia' name="j_nome_fantasia" value="<?=$cliente_fornecedor->nome_fantasia?>" />
			</label>
			<label style="width:294px; margin-right:23px;">
				Nome do Contato
				<input type="text" id='j_nome_contato' name="j_nome_contato" value="<?=$cliente_fornecedor->nome_contato?>" />
			</label>
			<label style="width:294px;">
				Ramo de Atividade
				<input type="text" id='j_ramo_atividade' name="j_ramo_atividade" value="<?=$cliente_fornecedor->ramo_atividade?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				CNPJ
				<input type="text" id='j_cnpj_cpf' name="j_cnpj_cpf" value="<?=$cliente_fornecedor->cnpj_cpf?>" mascara="__.___.___/____-__" sonumero='1' retorno='focus|Coloque o CNPJ corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Suframa
				<input type="text" id='j_suframa' name="j_suframa" value="<?=$cliente_fornecedor->suframa?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Inscrição Municipal
				<input type="text" id='j_inscricao_municipal' name="j_inscricao_municipal" value="<?=$cliente_fornecedor->inscricao_municipal?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Inscrição Estadual
				<input type="text" id='j_inscricao_estadual' name="j_inscricao_estadual" value="<?=$cliente_fornecedor->inscricao_estadual?>" />
			</label>
			<label style="width:294px; margin-right:23px;">
				Email
				<input type="text" id='j_email' name="j_email" value="<?=$cliente_fornecedor->email?>" retorno='focus|Coloque o email corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Telefone 1
				<input type="text" id='j_telefone1' name="j_telefone1" value="<?=$cliente_fornecedor->telefone2?>" mascara="__/____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Telefone 2
				<input type="text" id='j_telefone2' name="j_telefone2" value="<?=$cliente_fornecedor->telefone2?>" mascara="__/____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Fax
				<input type="text" id='j_fax' name="j_fax" value="<?=$cliente_fornecedor->fax?>" mascara="__/____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='j_cep' name="j_cep" value="<?=$cliente_fornecedor->cep?>" mascara="_____-__" sonumero='1' />
			</label>
			<label style="width:294px; margin-right:23px;">
				Endereço
				<input type="text" id='j_endereco' name="j_endereco" value="<?=$cliente_fornecedor->endereco?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='j_bairro' name="j_bairro" value="<?=$cliente_fornecedor->bairro?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='j_cidade' name="j_cidade" value="<?=$cliente_fornecedor->cidade?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Estado
				<input type="text" id='j_estado' name="j_estado" value="<?=$cliente_fornecedor->estado?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Limite
				<input type="text" id='j_limite' name="j_limite" value="<?=$cliente_fornecedor->limite?>" />
			</label>
		</fieldset>
		
		<fieldset  id='campos_2' <? if($cliente_fornecedor->tipo_cadastro=="Jurídico"||empty($cliente_fornecedor_id))echo 'style="display:none"'; ?> >
			<legend>
				<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';">Jurídico</a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';"><strong>Físico</strong></a>
			</legend>
			<input type="hidden" name="j_tipo" value="<? if($cliente_fornecedor->tipo_cadastro=="Físico") echo $cliente_fornecedor->tipo?>">
			<label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='f_nome_contato' name="f_nome_contato" value="<?=$cliente_fornecedor->nome_contato?>" />
			</label>
			<label style="width:294px;">
				Ramo de Atividade
				<input type="text" id='f_ramo_atividade' name="f_ramo_atividade" value="<?=$cliente_fornecedor->ramo_atividade?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				CPF
				<input type="text" id='f_cnpj_cpf' name="f_cnpj_cpf" value="<?=$cliente_fornecedor->cnpj_cpf?>" mascara="__.___.___/____-__" sonumero='1' retorno='focus|Coloque o CNPJ corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				RG
				<input type="text" id='f_rg' name="f_rg" value="<?=$cliente_fornecedor->rg?>" mascara="__.___.___-_" sonumero='1' retorno='focus|Coloque o RG corretamente!' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Inscrição Municipal
				<input type="text" id='f_inscricao_municipal' name="f_inscricao_municipal" value="<?=$cliente_fornecedor->inscricao_municipal?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Inscrição Estadual
				<input type="text" id='f_inscricao_estadual' name="f_inscricao_estadual" value="<?=$cliente_fornecedor->inscricao_estadual?>" />
			</label>
			<label style="width:294px; margin-right:23px;">
				Email
				<input type="text" id='f_email' name="f_email" value="<?=$cliente_fornecedor->email?>"  retorno='focus|Coloque o email corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Telefone 1
				<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$cliente_fornecedor->telefone2?>" mascara="__/____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Telefone 2
				<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$cliente_fornecedor->telefone2?>" mascara="__/____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="f_fax" value="<?=$cliente_fornecedor->fax?>" mascara="__/____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='f_cep' name="f_cep" value="<?=$cliente_fornecedor->cep?>" mascara="_____-__" sonumero='1' />
			</label>
			<label style="width:294px; margin-right:23px;">
				Endereço
				<input type="text" id='f_endereco' name="f_endereco" value="<?=$cliente_fornecedor->endereco?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='f_bairro' name="f_bairro" value="<?=$cliente_fornecedor->bairro?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='f_cidade' name="f_cidade" value="<?=$cliente_fornecedor->cidade?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Estado
				<input type="text" id='f_estado' name="f_estado" value="<?=$cliente_fornecedor->estado?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Limite
				<input type="text" id='f_limite' name="f_limite" value="<?=$cliente_fornecedor->limite?>" />
			</label>
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($cliente_fornecedor_id>0){
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
<script>top.openForm()</script>