<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script src="../../../../fontes/js/jquery.min.js"></script>
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:820px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this);location.href='?tela_id=417'"></a>
    
    <span>Empresas</span></div>
    </div>
    
   
	<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_cliente" enctype="multipart/form-data" target="carregador" action="modulos/rh/empresa/form.php">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<input id='tipo_cadastro' name="tipo_cadastro" type="hidden" value="<? if($cliente_fornecedor->id>0)echo $cliente_fornecedor->tipo_cadastro; else echo "Jurídico"; ?>" />
	<input name="cliente_fornecedor_id" id="cliente_fornecedor_id" type="hidden" value="<?=$cliente_fornecedor->cliente_fornecedor_id?>" />
		<fieldset  id='campos_1' <? if($cliente_fornecedor->tipo_cadastro=="Físico")echo 'style="display:none"'; ?> >
			<legend>
				<a class="form2"><strong>Jurídico</strong></a>
                <a class="form2">Sócios</a>
                <a class="form2">Contrato Social</a>
                <a class="form2">Contrato Interno</a>
                <a class="form2">Documentos</a>
                <a class="form2">Requerimento de Empresários</a>
			</legend>
			<div>
				<input type="hidden" name="j_tipo" value="<?=$cliente_fornecedor->tipo?>">
			</div>
			<label style="width:294px; margin-right:23px;">
				Raz&atilde;o Social
				<input type="text" id='j_razao_social' onkeyup="document.getElementById('j_nome_fantasia').value=this.value" name="j_razao_social" value="<?=$cliente_fornecedor->razao_social?>"  retorno="focus|Digite a Razao Social" valida_minlength='2'/>
			</label>
			<label style="width:294px;">
				Nome Fantasia
				<input type="text" id='j_nome_fantasia' name="j_nome_fantasia" value="<?=$cliente_fornecedor->nome_fantasia?>" />
			</label>
            <? 
			
			if(!empty($cliente_fornecedor->extensao)&&$cliente_fornecedor->tipo_cadastro=="Jurídico"){?>
            <div style="position:absolute;width:200px;height:165px;margin-left:630px;" class="div_foto_cliente">
            	<div>Foto</div>
                <div style="width:150px;max-height:100px;">
                	<img id="foto" height="55" src="<?="modulos/administrativo/clientes/fotos_clientes/".$cliente_fornecedor->id.".".$cliente_fornecedor->extensao?>">
            	</div>	
            	
           	 	<div style="clear:both"></div>
            	<a href="#" class="remover_foto">Remover Foto</a>
				<input type="hidden" name="extensao" id="extensao" value="<?=$cliente_fornecedor->extensao?>"/>
            </div>
            <? }?>
			<label style="width:294px; margin-right:23px;">
				Nome do Contato
				<input type="text" id='j_nome_contato' name="j_nome_contato" value="<?=$cliente_fornecedor->nome_contato?>" />
			</label>
			<label style="width:294px;">
				Ramo de Atividade
				<input type="text" id='j_ramo_atividade' name="j_ramo_atividade" value="<?=$cliente_fornecedor->ramo_atividade?>" />
			</label>
            <div style="clear:both"></div>
			<label style="width:136px; margin-right:22px;">
				CNPJ
				<input type="text" id='j_cnpj_cpf' name="j_cnpj_cpf" value="<?=$cliente_fornecedor->cnpj_cpf?>" mascara="__.___.___/____-__" sonumero='1' retorno='focus|Coloque o CNPJ corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Suframa
				<input type="text" id='j_suframa' name="j_suframa" value="<?=$cliente_fornecedor->suframa?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Inscri&ccedil;&atilde;o Municipal
				<input type="text" id='j_inscricao_municipal' name="j_inscricao_municipal" value="<?=$cliente_fornecedor->inscricao_municipal?>" />
			</label>
           
            <label style="width:134px; margin-right:23px;">
				Inscri&ccedil;&atilde;o Estadual
				<input type="text" id='j_inscricao_estadual' name="j_inscricao_estadual" value="<?=$cliente_fornecedor->inscricao_estadual?>" />
			</label>
			<label style="width:294px; margin-right:23px;">
				Email
				<input type="text" id='j_email' name="j_email" value="<?=$cliente_fornecedor->email?>" retorno='focus|Coloque o email corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Telefone
				<input type="text" id='j_telefone1' name="j_telefone1" value="<?=$cliente_fornecedor->telefone1?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:134px; margin-right:22px;">
				Celular
				<input type="text" id='j_telefone2' name="j_telefone2" value="<?=$cliente_fornecedor->telefone2?>" mascara="(__)____-____" sonumero='1' />
			</label>
            <div style="clear:both"></div>
			<label style="width:136px; margin-right:23px;">
				Fax
				<input type="text" id='j_fax' name="j_fax" value="<?=$cliente_fornecedor->fax?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='j_cep' name="j_cep" value="<?=$cliente_fornecedor->cep?>" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/administrativo/clientes/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>j_cep|@r1-value>j_endereco|@r2-value>j_bairro|@r3-value>j_cidade|@r4-value>j_estado\',\'j_cep\')')}"/>
			</label>
			<label style="width:290px; margin-right:23px;">
				Endere&ccedil;o
				<input type="text" id='j_endereco' name="j_endereco" value="<?=$cliente_fornecedor->endereco?>" />
			</label>
            <div style="clear:both"></div>
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
			<!--<label style="width:134px; margin-right:22px;">
				Limite
				<input type="text" id='j_limite' name="j_limite" value="<?=moedaUsaToBr($cliente_fornecedor->limite)?>" sonumero='1' decimal='2'/>
			</label>-->
            <div style="clear:both"></div>
            <label style="width:100px; margin-right:22px;">
				Valor Mensalidade
				<input type="text" id='vlr_mensalidade' name="vlr_mensalidade" value="<?=moedaUsaToBr($cliente_fornecedor->valor_mensalidade)?>" sonumero='1' decimal='2'/>
			</label>
             <label style="width:90px; margin-right:22px;">
				Código Interno
				<input type="text" id='j_codigo_interno' name="j_codigo_interno" value="<?=$cliente_fornecedor->codigo_interno?>"/>
			</label>
            <!--<label style="width:100px; margin-right:22px;" title="Classificação Nacional de Atividade Econômica" rel='tip'>
				CNAE
				<input type="text" id='j_cnae' name="j_cnae" value="<?=$cliente_fornecedor->cnae?>"/>
			</label>
            <label style="width:100px; margin-right:22px;" title="Classificação Nacional de Atividade Econômica Preponderante" rel='tip'>
				CNAE Prep.
				<input type="text" id='j_cnae_preponderante' name="j_cnae_preponderante" value="<?=$cliente_fornecedor->cnae_preponderante?>"/>
			</label>-->
            <label style="width:100px; margin-right:22px;" title=" Fundo da Previdência e Assistência Social" rel="tip">
				FPAS
				<input type="text" id='j_fpas' name="j_fpas" value="<?=$cliente_fornecedor->fpas?>"/>
			</label>
            
            <label style="width:100px; margin-right:22px;" title=" Número de identificação do registro de empresa" rel="tip">
				Nire
				<input type="text" id='f_nire' name="f_nire" value="<?=$cliente_fornecedor->nire?>"/>
			</label>
            
            <label style="width:100px; margin-right:22px;" title=" Número de identificação do registro de empresa filial" rel="tip">
				Nire Filial
				<input type="text" id='f_nire_filial' name="f_nire_filial" value="<?=$cliente_fornecedor->nire_filial?>"/>
			</label>
            
            <label style="width:100px; margin-right:22px;" rel="tip">
				Valor Capital
				<input type="text" id='f_valor_capital' name="f_valor_capital" value="<?=MoedaUsaToBr($cliente_fornecedor->valor_capital)?>" decimal="2"/>
			</label>
            <label style="width:100px; margin-right:22px;" title="Início das Atividades" rel="tip">
				Início atividades
				<input type="text" id='f_inicio_atividades' name="f_inicio_atividades" value="<?=DataUsaToBr($cliente_fornecedor->dt_inicio_atividades)?>" mascara="__/__/____"/>
			</label>
            
            <label style="width:150px; margin-right:22px;" rel="tip">
				Pequena/Micro Empresa?
				<select name="porte_empresa" id='porte_empresa'/>
                	<option value="1" <? if($cliente_fornecedor->porte_empresa=='1'){echo "selected='selected'";}?>>Micro Empresa</option>
                    <option value="2" <? if($cliente_fornecedor->porte_empresa=='2'){echo "selected='selected'";}?>>Empresa de Pequeno Porte</option>
                    <option value="3" <? if($cliente_fornecedor->porte_empresa=='3'){echo "selected='selected'";}?>>Empresa/Órgão não classificada nos itens anteriores</option>
                    <option value="4" <? if($cliente_fornecedor->porte_empresa=='4'){echo "selected='selected'";}?>>Micro Empreendedor Individual</option>
                </select>
			</label>
            
            <label style="width:100px; margin-right:22px;" title="Código de Recolhimento" rel="tip">
				Cód. Recolhimento 
				<input type="text" name="codigo_recolhimento" id='codigo_recolhimento' value="<?=$cliente_fornecedor->codigo_recolhimento?>" sonumero="1"/>                
			</label>
            
            <label style="width:100px; margin-right:22px;" rel="tip" title="Indicador de Recolhimento FGTS" rel="tip">
				Indicador FGTS 
				<select name="indicador_recolhimento_fgts" id='indicador_recolhimento_fgts'/> 
                 <option value="1" <?php if($cliente_fornecedor->indicador_recolhimento_fgts=="1"){ echo "selected='selected'";}?>/>1</option>
                 <option value="2" <?php if($cliente_fornecedor->indicador_recolhimento_fgts=="2"){ echo "selected='selected'";}?>/>2</option>                
				 <option value="3" <?php if($cliente_fornecedor->indicador_recolhimento_fgts=="3"){ echo "selected='selected'";}?>/>3</option>
                 </select>
            </label>
            
             <label style="width:100px; margin-right:22px;" rel="tip" title="Data de Recolhimento FGTS" rel="tip">
				Data Recolhimento 
				<input type="text" name="data_recolhimento_fgts" id='data_recolhimento_fgts' value="<?=DataUsaToBr($cliente_fornecedor->data_recolhimento_fgts)?>" sonumero="1" mascara="__/__/____" calendario="1"/>               
			</label>
            
            <div style="clear:both"></div>
            
            <label style="width:120px; margin-right:22px;" rel="tip" title="Data de recollhimento da previdencia social" rel="tip">
				Dt Previdência Social 
				<input type="text" name="data_recolhimento_previdencia_social" id='data_recolhimento_previdencia_social' value="<?=DataUsaToBr($cliente_fornecedor->data_recolhimento_previdencia_social)?>" sonumero="1" mascara="__/__/____" calendario="1"/>          
			</label>
            
            <label style="width:40px; margin-right:22px;">
				% RAT 
				<input type="text" name="porcentagem_rat" id='porcentagem_rat' value="<?=MoedaUsaToBr($cliente_fornecedor->porcentagem_rat)?>" sonumero="1" decimal="2"/>          
			</label>
            
            <label style="width:100px; margin-right:22px;" title="Código de Outras Entidades" rel="tip">
			Código Entidades 
				<input type="text" name="codigo_outras_entidades" id='codigo_outras_entidades' value="<?=$cliente_fornecedor->codigo_outras_entidades?>" maxlength="4"/>          
			</label>
            
            <label style="width:100px; margin-right:22px;">
			Código Pgto. GPS 
				<input type="text" name="codigo_pagamento_gps" id='codigo_pagamento_gps' value="<?=$cliente_fornecedor->codigo_pagamento_gps?>" maxlength="4"/>          
			</label>
            
            <label style="width:127px; margin-right:22px;">
			Código de Centralização 
				<select name="codigo_centralizacao" id='codigo_centralizacao'>
                 <option value="0" <? if($cliente_fornecedor->codigo_centralizacao=="0"){echo "selected='selected'";}?>/>0 - Não Centraliza</option>
                 <option value="1" <? if($cliente_fornecedor->codigo_centralizacao=="1"){echo "selected='selected'";}?>/>1 - Centralizadora</option>
                 <option value="2" <? if($cliente_fornecedor->codigo_centralizacao=="2"){echo "selected='selected'";}?>/>2 - Centralizada</option>          
				</select>
            </label>
            
                        
            <label style="width:127px; margin-right:22px;">
			Simples 
				<input type="text" name="simples" id='simples' value="<?=$cliente_fornecedor->simples?>" maxlength="4"/>          
			</label>
                        
            <!--Logomarca<br>
            <input type="file" name="foto_cliente" id="foto_cliente"/>-->
              <input type="hidden" name="acao2" id="form_empresa" value="empresa" />          
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
<?php
	include('form_socios.php');
	include('form_contrato_social.php');
	include('form_contrato_interno.php');
	include('form_documentos.php');	
	include('form_requerimento.php');	
?>

</div>
</div>
</div>
<script>
top.openForm();
</script>