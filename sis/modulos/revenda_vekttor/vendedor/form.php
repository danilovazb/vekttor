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
    
    <span>Vendedor</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post"  autocomplete='off' enctype="multipart/form-data">
     <input type="hidden" name="id" id="id" value="<?=$vendedor->id?>" />
     <input type="hidden" name="cliente_vendedor_id" id="cliente_vendedor_id" value="<?=$vendedor->cliente_fornecedor_id?>" />
     <input type="hidden" name="usuario_id" value="<?=$usuario->id;?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1'/>
			<legend>
				<a onclick="aba_form(this,0)"><strong>Vendedor</strong></a>
                <a onclick="aba_form(this,1)">Usuário</a>
			</legend>

			<label style="width:294px; margin-right:23px;">
				Nome <?php echo $rf?>
				<input type="text" id='f_nome_contato' name="f_nome_contato" value="<?=$vendedor->nome?>" />
			</label>
			<label style="width:125px; margin-right:22px;">
				CPF
				<input type="text" id='f_cnpj_cpf' name="f_cnpj_cpf" value="<?=$cliente_vendedor->cnpj_cpf?>" mascara="___.___.___-__" sonumero='1' retorno='focus|Coloque o CPF corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				RG
				<input type="text" id='f_rg' name="f_rg" value="<?=$cliente_vendedor->rg?>"  sonumero='1' retorno='focus|Coloque o RG corretamente!' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Local de Emissão
				<input type="text" id='f_local_emissao' name="f_local_emissao" value="<?=$cliente_vendedor->local_emissao?>" />
			</label>
			<label style="width:100px; margin-right:22px;">
				Data Emissao
				<input type="text" mascara='__/__/____' id='f_data_emissao' calendario="1" name="f_data_emissao" value="<?=dataUsaToBr($cliente_vendedor->data_emissao)?>" />
			</label>
            <label style="width:100px;">
				Data Nascimento
				<input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" calendario="1" value="<?=dataUsaToBr($cliente_vendedor->nascimento)?>" />
			</label>
            <label style="width:126px;">
				Naturalidade
				<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$cliente_vendedor->naturalidade?>" />
			</label>
            <label style="width:126px;">
				Nacionalidade
				<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$cliente_vendedor->nacionalidade?>" />
			</label>
            <label style="width:294px; margin-right:23px;">
				Email
				<input type="text" id='f_email' name="f_email" value="<?=$cliente_vendedor->email?>"  retorno='focus|Coloque o email corretamente!' />
			</label>
			<label style="width:130px; margin-right:23px;">
				Telefone 1
				<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$cliente_vendedor->telefone1?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:130px; margin-right:22px;">
				Telefone 2
				<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$cliente_vendedor->telefone2?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="f_fax" value="<?=$cliente_vendedor->fax?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='f_cep' name="f_cep" value="<?=$cliente_vendedor->cep?>" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/administrativo/clientes/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}"/>
			</label>
			<label style="width:290px; margin-right:23px;">
				Endereço
				<input type="text" id='f_endereco' name="f_endereco" value="<?=$cliente_vendedor->endereco?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='f_bairro' name="f_bairro" value="<?=$cliente_vendedor->bairro?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='f_cidade' name="f_cidade" value="<?=$cliente_vendedor->cidade?>" />
			</label>
			<label style="width:130px; margin-right:23px;">
				Estado
				<input type="text" id='f_estado' name="f_estado" value="<?=$cliente_vendedor->estado?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Limite
				<input type="text" id='f_limite' name="f_limite" value="<?=moedaUsaToBr($cliente_vendedor->limite)?>" decimal='2'/>
			</label>
            <label style="width:294px; margin-right:23px;">
				Endereco Comercial
				<input type="text" id='f_endereco_comercial' name="f_endereco_comercial" value="<?=$cliente_vendedor->endereco_comercial?>" />
			</label>
			<label style="width:230px;">
				Telefone Comercial
				<input type="text" id='f_telefone_comercial' name="f_telefone_comercial" value="<?=$cliente_vendedor->telefone_comercial?>" mascara="(__)____-____" sonumero='1' />
			</label>            
            <div style="clear:both"></div>
            <label style="width:80px; margin-right:23px;">
            	Servi&ccedil;o
                	<input type="text" name="porcento_servico" decimal="1" id="porcento_servico" value="<?=$vendedor->servico?>" style="width:50px; float:left; text-align:right;"><div style="padding:4px 5px 0 0">&nbsp;%</div>
            </label>            
            <label style="width:85px; margin-right:23px;">
            	Implata&ccedil;&atilde;o
                	<input type="text" name="porcento_implantacao" decimal="1" id="porcento_implantacao" value="<?=$vendedor->implantacao?>" style="width:50px; float:left; text-align:right;"><div style="padding:4px 5px 0 0">&nbsp;%</div>
            </label> 
		</fieldset>
		<div style="display:block"></div>        
        <fieldset  id='campos_2' style="display:none;" >
			<legend>
				<a onclick="aba_form(this,0)">Vendedor</a>
                <a onclick="aba_form(this,1)"><strong>Usuário</strong></a>
			</legend>
           	<label style="width:294px; margin-right:23px;">
				Nome
			<input type="text" id='nome_usuario' name="nome_usuario" retorno="focus|Digite um Usuario" valida_minlength='3' value="<?=$usuario->nome?>"/>
            </label>
            <label>
            	Tipo Usuario
                <!--<inp>-->
                <select name="tipo_usuario">
				<?
				$q=mysql_query("SELECT * FROM usuario_tipo WHERE vkt_id='$vkt_id'");
				while($r=mysql_fetch_object($q)){
				?>
            	<option <? if($r->id==$usuario->usuario_tipo_id)echo 'selected="selected"'; ?>  value="<?=$r->id?>"><?=$r->nome?></option>
				<?
				}
				?>
            </select>
            </label>
            <div style="clear:both"></div>
            <label style="width:135px; margin-right:23px;">
				Login
			<input type="login" id='login_usuario' name="login_usuario" value="<?=$usuario->login?>"/>
            </label>
            <label style="width:135px; margin-right:23px;">
				Senha
			<input type="password" id='senha_usuario' name="senha_usuario" value="<?=$usuario->senha?>"/>
            </label>
             <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$usuario->id?>" />
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
<?
	if($vendedor->id>0){
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

