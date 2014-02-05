<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:710px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Odontólogo</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	
	
   
		<fieldset  id='campos_1'>
				<legend>
                	<a onclick="aba_form(this,0)"><strong>Cliente</strong></a>
                    <a onclick="aba_form(this,1)">Usuario</a>
                    <a onclick="aba_form(this,2)">Agenda</a>
                </legend>
				
                <div style="max-height:500px;overflow:auto">
             <label style="width:294px;">
				Nome
				<input type="text" id='f_nome_contato' name="f_nome_contato" value="<?=$odontologo->nome_contato?>" <?php echo $disabled;?> valida_minlength='3' retorno='focus|Digite o nome da Odontólogo'/>
			</label>
			<label style="width:294px;">
				Ramo de Atividade
				<input type="text" id='f_ramo_atividade' name="f_ramo_atividade" value="<?=$odontologo->ramo_atividade?>" <?php echo $disabled;?> />
			</label>
            
            <div style="clear:both"></div>
            <label style="width:136px;">
				CPF
				<input type="text" id='f_cnpj_cpf' name="f_cnpj_cpf" value="<?=$odontologo->cnpj_cpf?>" mascara="___.___.___-__" sonumero='1' <?php echo $disabled;?> />
			</label>
			<label style="width:136px;">
				RG
				<input type="text" id='f_rg' name="f_rg" value="<?=$odontologo->rg?>"  sonumero='1' <?php echo $disabled;?>/>
			</label>
            <label style="width:136px;margin-left:5px;">
				Local de Emissão
				<input type="text" id='f_local_emissao' name="f_local_emissao" value="<?=$odontologo->local_emissao?>" <?php echo $disabled;?>/>
			</label>
			<label style="width:136px;">
				Data Emissao
				<input type="text" mascara='__/__/____' id='f_data_emissao' calendario='1' name="f_data_emissao" value="<?=dataUsaToBr($odontologo->data_emissao)?>" <?php echo $disabled;?>/>
			</label>
            <label style="width:136px;">
				CRO
				<input type="text" id='f_cro' name="f_cro" value="<?=$odontologo->cro?>" <?php echo $disabled;?> />
			</label>
           	
            <label style="width:136px;">
				Data Nascimento
				<input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" value="<?=dataUsaToBr($odontologo->nascimento)?>" <?php echo $disabled;?> />
			</label>
            <label style="width:136px;margin-left:5px;">
				Naturalidade
				<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$odontologo->naturalidade?>" <?php echo $disabled;?>/>
			</label>
            <label style="width:136px;">
				Nacionalidade
				<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$odontologo->nacionalidade?>" <?php echo $disabled;?>/>
			</label>
             
            <label style="width:294px; margin-right:23px;">
				Email
				<input type="text" id='f_email' name="f_email" value="<?=$odontologo->email?>"   <?php echo $disabled;?> valida_minlength='3' retorno="focus|Digite o Email"/>
			</label>
			<label style="width:130px; margin-right:23px;">
				Telefone 1
				<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$odontologo->telefone1?>" mascara="(__)____-____" sonumero='1' <?php echo $disabled;?>/>
			</label>
			<label style="width:130px; margin-right:22px;">
				Telefone 2
				<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$odontologo->telefone2?>" mascara="(__)____-____" sonumero='1' <?php echo $disabled;?> />
			</label>
			<label style="width:136px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="f_fax" value="<?=$odontologo->fax?>" mascara="(__)____-____" sonumero='1' <?php echo $disabled;?>/>
			</label>
			 <label style="width:136px">
                
				Estado Civil
				<select name="f_estado_civil" onchange="exibeConjugue()" <?php echo $disabled;?>>
				<?
					if($odontologo->estado_civil=="Casado"){
						$casado='selected="selected"';
					}else{
						$solteiro='selected="selected"';
					}
				?>
					<option value="Solteiro" <?=$solteiro?>>Solteiro</option>
					<option value="Casado" <?=$casado?>>Casado</option>
				</select>
			</label>
            <label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='f_cep' name="f_cep" value="<?=$odontologo->cep?>" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/administrativo/clientes/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}" <?php echo $disabled;?>/>
			</label>
            <div style="clear:both"></div>
			<label style="width:290px;">
				Endereço
				<input type="text" id='f_endereco' name="f_endereco" value="<?=$odontologo->endereco?>" <?php echo $disabled;?> />
			</label>
			<label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='f_bairro' name="f_bairro" value="<?=$odontologo->bairro?>" <?php echo $disabled;?> />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='f_cidade' name="f_cidade" value="<?=$odontologo->cidade?>" <?php echo $disabled;?> />
			</label>
			<label style="width:136px; ">
				Estado
				<input type="text" id='f_estado' name="f_estado" value="<?=$odontologo->estado?>" <?php echo $disabled;?> />
			</label>
			<label style="width:136px; ">
				Limite
				<input type="text" id='f_limite' name="f_limite" value="<?=moedaUsaToBr($odontologo->limite)?>" decimal='2' <?php echo $disabled;?>/>
			</label>
            <label style="width:294px; margin-right:23px;">
				Endereco Comercial
				<input type="text" id='f_endereco_comercial' name="f_endereco_comercial" value="<?=$odontologo->endereco_comercial?>" <?php echo $disabled;?>/>
			</label>
			<label style="width:136px;">
				Telefone Comercial
				<input type="text" id='f_telefone_comercial' name="f_telefone_comercial" value="<?=$odontologo->telefone_comercial?>" mascara="(__)____-____" sonumero='1'<?php echo $disabled;?>/>
			</label>
            <label style="width:136px;">
				% Recebimento
				<input type="text" id='porcentagem_recebimento' name="porcentagem_recebimento" value="<?=MoedaUsaToBr($odontologo->porcentagem_recebimento)?>" decimal="2" sonumero='1'<?php echo $disabled;?> style="text-align:right"/>
			</label>
            <div style="clear:both"></div>
          
            <?
			if($odontologo->estado_civil=="Casado"){
				$display="block";	
			}else{
				$display="none";
			}
			?>
			
			<div style="clear:both"></div>
			<div id="dados_conjugue" style="display:<?=$display?>">
			<label style="width:294px; margin-right:23px;">
				Nome - Conjugue
				<input type="text" id='f_conjugue_nome' name="f_conjugue_nome" value="<?=$odontologo->conjugue_nome?>" <?php echo $disabled;?>/>
			</label>
             <label style="width:175px; margin-right:22px;">
				Data de Nascimento - Conjugue
				<input type="text" id='f_conjugue_data_nascimento' name="f_conjugue_data_nascimento" value="<?=dataUsaToBr($odontologo->conjugue_data_nascimento)?>" mascara='__/__/____' sonumero='1' <?php echo $disabled;?>/>
			</label>
			<label style="width:294px;">
				Ramo de Atividade - Conjugue
				<input type="text" id='f_conjugue_ramo_atividade' name="f_conjugue_ramo_atividade" value="<?=$odontologo->conjugue_ramo_atividade?>" <?php echo $disabled;?>/>
			</label>
			<label style="width:136px; margin-right:22px;">
				CPF - Conjugue
				<input type="text" id='f_conjugue_cpf' name="f_conjugue_cpf" value="<?=$odontologo->conjugue_cpf?>" mascara="___.___.___-__" sonumero='1' <?php echo $disabled;?>/>
			</label>
			<label style="width:136px; margin-right:23px;">
				RG - Conjugue
				<input type="text" id='f_conjugue_rg' name="f_conjugue_rg" value="<?=$odontologo->conjugue_rg?>" <?php echo $disabled;?>/>
			</label>
			<label style="width:136px; margin-right:22px;" title='Local de emissao RG do Conjugue'>
				Local Emissao RG.
				<input type="text" id='f_conjugue_local_emissao' name="f_conjugue_local_emissao" value="<?=$odontologo->conjugue_local_emissao?>" <?php echo $disabled;?>/>
			</label>
            <label style="width:155px; margin-right:22px;">
				Data da Emissao - Conjugue
				<input type="text" id='f_conjugue_data_emissao' calendario="1" name="f_conjugue_data_emissao" value="<?=DataUsaToBr($odontologo->conjugue_data_emissao)?>" mascara='__/__/____' <?php echo $disabled;?>/>
			</label>
            <label style="width:130px; margin-right:22px;">
				Telefone - Conjugue
				<input type="text" id='f_conjugue_telefone' name="f_conjugue_telefone" value="<?=$odontologo->conjugue_telefone?>" mascara="(__)____-____" sonumero='1' <?php echo $disabled;?>/>
			</label>
            <label style="width:136px; margin-right:22px;">
				E-mail - Conjugue
				<input type="text" id='f_conjugue_email' name="f_conjugue_email" value="<?=$odontologo->conjugue_email?>" <?php echo $disabled;?>/>
			</label>
            <label style="width:150px;">
				Naturalidade - Conjugue
				<input type="text" id='f_conjugue_naturalidade' name="f_conjugue_naturalidade" value="<?=$odontologo->conjugue_naturalidade?>" <?php echo $disabled;?>/>
			</label>
            <label style="width:150px;">
				Nacionalidade - Conjugue
				<input type="text" id='f_conjugue_nacionalidade' name="f_conjugue_nacionalidade" value="<?=$odontologo->conjugue_nacionalidade?>" <?php echo $disabled;?>/>
			</label>
            <label style="width:294px; margin-right:23px;">
				Endereco Comercial - Conjugue
				<input type="text" id='f_endereco_comercial_conjugue' name="f_endereco_comercial_conjugue" value="<?=$odontologo->conjugue_endereco_comercial?>" <?php echo $disabled;?>/>
			</label>
			<label style="width:170px;">
				Telefone Comercial - Conjugue
				<input type="text" id='f_telefone_comercial_conjugue' name="f_telefone_comercial_conjugue" value="<?=$odontologo->conjugue_telefone_comercial?>" mascara="(__)____-____" sonumero='1' <?php echo $disabled;?>/>
                </label>
                </div>
                <input type="file" name="foto_odontologo" id="foto_odontologo" />
                </div>
		</fieldset>
		 <fieldset style="display:none;" >
			<legend>
				<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)"><strong>Usuário</strong></a>
                <a onclick="aba_form(this,2)">Agenda</a>
			</legend>
           	<label style="width:294px; margin-right:23px;">
				Nome
			<input type="text" id='nome_usuario' name="nome_usuario" value="<?=$odontologo->nome?>" valida_minlength='3' retorno="focus|Digite o Nome do Usuário(Aba Usuário)"/>
            </label>
            <div style="clear:both"></div>
            <label style="width:135px; margin-right:23px;">
				Login
			<input type="login" id='login_usuario' name="login_usuario" value="<?=$odontologo->login?>" valida_minlength='3' retorno="focus|Digite o Login do Usuário(Aba Usuário)"/>
            </label>
            <label style="width:135px; margin-right:23px;">
				Senha
			<input type="password" id='senha_usuario' name="senha_usuario" value="<?=$odontologo->senha?>" valida_minlength='3' retorno="focus|Digite s Senha do Usuário(Aba Usuário)"/>
            </label>
      		<div style="clear:both"></div>
            <label>
             Tipo de Usuário
             <select name="usuatio_tipo_id" id="usuatio_tipo_id ">
            	<?php
					$tipos_usuarios = mysql_query("SELECT * FROM usuario_tipo WHERE vkt_id='$vkt_id'");
					
					while($tipo = mysql_fetch_object($tipos_usuarios)){
						if($tipo->id==$odontologo->usuario_tipo_id){$selected="selected='selected'";}
						echo "<option value='$tipo->id' $selected>$tipo->nome</option>";
						$selected='';
					}
				?>
            </select>
           </label>
		</fieldset>
        <fieldset style="display:none;" >
			<legend>
				<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)">Usuário</a>
                <a onclick="aba_form(this,2)"><strong>Agenda</strong></a>
			</legend>
           	<label style="width:294px; margin-right:23px;">
				Agenda
			
            <select name="agenda_id" id="agenda_id">
            	<?php
					$agendas = mysql_query("SELECT * FROM agenda WHERE vkt_id='$vkt_id'");
					
					while($agenda = mysql_fetch_object($agendas)){
						if($agenda->id==$odontologo->agenda_id){$selected="selected='selected'";}
						echo "<option value='$agenda->id' $selected>$agenda->nome</option>";
						$selected='';
					}
				?>
            </select>
            </label>
             <input name="id" type="hidden" value="<?=$odontologo->oc_id?>" />
             <input type="hidden" name="usuario_id" id="usuario_id" value="<?=$odontologo->usuario_id?>" />
             <input type="hidden" name="cliente_fornecedor_id"  id="cliente_fornecedor_id" value="<?=$odontologo->cliente_fornecedor_id?>" />
             
		</fieldset>
		
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($odontologo->id>0){
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