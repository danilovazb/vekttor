<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<meta charset="utf-8"> 
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:820px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Clientes</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_cliente" enctype="multipart/form-data" target="<?=$_GET['target']?>" action="<?=$_GET['action']?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<input id='tipo_cadastro' name="tipo_cadastro" type="hidden" value="<? if($cliente_fornecedor->id>0)echo $cliente_fornecedor->tipo_cadastro; else echo "Jurídico"; ?>" />
	<input name="cliente_fornecedor_id" type="hidden" value="<?=$cliente_fornecedor_id?>" />
		<fieldset  id='campos_1' <? if($cliente_fornecedor->tipo_cadastro=="Físico")echo 'style="display:none"'; ?> >
			<legend>
				<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong>Jurídico</strong></a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';">Físico</a>
                <? if($cliente_fornecedor->id>0){?><a onclick="aba_form(this,2);">Documentos</a><? } ?>
			</legend>
			<div>
				<input type="hidden" name="j_tipo" value="<?=$cliente_fornecedor->tipo?>">
			</div>
			<label style="width:294px; margin-right:23px;">
				Raz&atilde;o Social
				<input type="text" id='j_razao_social' onkeyup="document.getElementById('j_nome_fantasia').value=this.value" name="j_razao_social" value="<?=$cliente_fornecedor->razao_social?>" />
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
                	<img id="foto" width="100" height="55" src="<?="modulos/administrativo/clientes/fotos_clientes/".$cliente_fornecedor->id.".".$cliente_fornecedor->extensao?>">
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
				Celular
				<input type="text" id='j_telefone1' name="j_telefone1" value="<?=$cliente_fornecedor->telefone1?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:134px; margin-right:22px;">
				Telefone 2
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
			<label style="width:134px; margin-right:22px;">
				Limite Mensal 
				<input type="text" id='j_limite' name="j_limite" value="<?=moedaUsaToBr($cliente_fornecedor->limite)?>" sonumero='1' decimal='2'/>
			</label>
            <div style="clear:both"></div>
            
            <input type="file" name="foto_cliente" id="foto_cliente"/>
                        
		</fieldset>
		
		<fieldset  id='campos_2' <? if($cliente_fornecedor->tipo_cadastro=="Jurídico"||empty($cliente_fornecedor_id)){ echo 'style="display:none"'; }?> >
			<legend>
				<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';">Jurídico</a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';"><strong>Físico</strong></a>
                  <? if($cliente_fornecedor->id>0){?><a onclick="aba_form(this,2);">Documentos</a><? } ?>
			</legend>
			<input type="hidden" name="j_tipo" value="<? if($cliente_fornecedor->tipo_cadastro=="Físico") echo $cliente_fornecedor->tipo?>">
			
			<div style="clear:both"></div>
            <div style="max-height:450px;overflow:auto;">
			<label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='f_nome_contato' name="f_nome_contato" value="<?=$cliente_fornecedor->razao_social?>" />
			</label>
			<label style="width:294px;">
				Ramo de Atividade
				<input type="text" id='f_ramo_atividade' name="f_ramo_atividade" value="<?=$cliente_fornecedor->ramo_atividade?>" />
			</label>
            <? if(!empty($cliente_fornecedor->extensao)&&$cliente_fornecedor->tipo_cadastro=="Físico"){?>
            <div style="position:absolute;width:200px;height:165px;margin-left:630px;" class="div_foto_cliente">
            	<div>Foto</div>
                <div style="width:150px;max-height:100px;">
                	<img id="foto" width="100" height="100" src="<?="modulos/administrativo/clientes/fotos_clientes/".$cliente_fornecedor->id.".".$cliente_fornecedor->extensao?>">
            	</div>	
            	
           	 	<div style="clear:both"></div>
            	<a href="#" class="remover_foto">Remover Foto</a>
				<input type="hidden" name="extensao" id="extensao" value="<?=$cliente_fornecedor->extensao?>"/>
            </div>
            <? }?>
			</div>
            <div style="clear:both"></div>
			<label style="width:136px; margin-right:22px;">
				CPF
				<input type="text" id='f_cnpj_cpf' name="f_cnpj_cpf" value="<?=$cliente_fornecedor->cnpj_cpf?>" mascara="___.___.___-__" sonumero='1' retorno='focus|Coloque o CPF corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				RG
				<input type="text" id='f_rg' name="f_rg" value="<?=$cliente_fornecedor->rg?>"  sonumero='1' retorno='focus|Coloque o RG corretamente!' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Local de Emiss&atilde;o
				<input type="text" id='f_local_emissao' name="f_local_emissao" value="<?=$cliente_fornecedor->local_emissao?>" />
			</label>
             
            <label style="width:110px; margin-right:22px;">
				Data Emissao
				<input type="text" mascara='__/__/____' id='f_data_emissao' name="f_data_emissao" value="<?=dataUsaToBr($cliente_fornecedor->data_emissao)?>" />
			</label>
            <div style="clear:both"></div>
            <label style="width:136px;">
				Data Nascimento
				<input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" value="<?=dataUsaToBr($cliente_fornecedor->nascimento)?>" />
			</label>
            <label style="width:136px;">
				Naturalidade
				<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$cliente_fornecedor->naturalidade?>" />
			</label>
            <!--<div style="width:150px;height:200px;float:right;margin-top:10px;">
            	<div>Foto</div>
                <div id="foto" style="width:150px;height:150px;border:#CCC solid 1px;float:right;background:url(../../../fotos_clientes/7297.jpg)">
            			
            	</div>
           	 	<div style="clear:both"></div>
            	<input type="file" name="foto_cliente" id="foto_cliente" size="2"/>
			</div>-->
            <label style="width:136px;">
				Nacionalidade
				<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$cliente_fornecedor->nacionalidade?>" />
			</label>
            
             <label style="width:130px">
				Estado Civil
				<select name="f_estado_civil" onchange="exibeConjugue()">
				<?
					if($cliente_fornecedor->estado_civil=="Casado"){
						$casado='selected="selected"';
					}else{
						$solteiro='selected="selected"';
					}
				?>
					<option value="Solteiro" <?=$solteiro?>>Solteiro</option>
					<option value="Casado" <?=$casado?>>Casado</option>
				</select>
                
            </label>
            
            <label style="width:294px; margin-right:23px;">
				Email
				<input type="text" id='f_email' name="f_email" value="<?=$cliente_fornecedor->email?>"  retorno='focus|Coloque o email corretamente!' />
			</label>        
            
            
			<label style="width:130px; margin-right:23px;">
				Celular
				<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$cliente_fornecedor->telefone1?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:130px; margin-right:22px;">
				Telefone 2
				<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$cliente_fornecedor->telefone2?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<div style="clear:both"></div>
            <label style="width:136px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="f_fax" value="<?=$cliente_fornecedor->fax?>" mascara="(__)____-____" sonumero='1' />
			</label>
           
			<label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='f_cep' name="f_cep" value="<?=$cliente_fornecedor->cep?>" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/administrativo/clientes/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}"/>
			</label>
			<label style="width:290px; margin-right:23px;">
				Endere&ccedil;o
				<input type="text" id='f_endereco' name="f_endereco" value="<?=$cliente_fornecedor->endereco?>" />
			</label>
            <div style="clear:both"></div>
			<label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='f_bairro' name="f_bairro" value="<?=$cliente_fornecedor->bairro?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='f_cidade' name="f_cidade" value="<?=$cliente_fornecedor->cidade?>" />
			</label>
			<label style="width:130px; margin-right:23px;">
				Estado
				<input type="text" id='f_estado' name="f_estado" value="<?=$cliente_fornecedor->estado?>" />
			</label>
			
              <label style="width:130px; margin-right:22px;">
				Limite Mensal
				<input type="text" id='f_limite' name="f_limite" value="<?=moedaUsaToBr($cliente_fornecedor->limite)?>" decimal='2'/>
			</label>
            
            <label style="width:294px; margin-right:23px;">
				Endereco Comercial
				<input type="text" id='f_endereco_comercial' name="f_endereco_comercial" value="<?=$cliente_fornecedor->endereco_comercial?>" />
			</label>
			<label style="width:130px;">
				Telefone Comercial
				<input type="text" id='f_telefone_comercial' name="f_telefone_comercial" value="<?=$cliente_fornecedor->telefone_comercial?>" mascara="(__)____-____" sonumero='1' />
			</label>
          	<label style="width:130px;">
				Sexo
				<select name="sexo">
                	<option value="m" <? if($cliente_fornecedor->sexo=='m'){echo "selected='selected'";}?>>Masculino</option>
                    <option value="f" <? if($cliente_fornecedor->sexo=='f'){echo "selected='selected'";}?>>Feminino</option>
                </select>
			</label>
			<?
			
			if($cliente_fornecedor->estado_civil=="Casado"){
				$display="block";	
			}else{
				$display="none";
			}
			?>
			
			<div style="clear:both"></div>
			<div id="dados_conjugue" style="display:<?=$display?>;">
			<label style="width:294px; margin-right:23px;">
				Nome - Conjugue
				<input type="text" id='f_conjugue_nome' name="f_conjugue_nome" value="<?=$cliente_fornecedor->conjugue_nome?>" />
			</label>
             <label style="width:175px; margin-right:22px;">
				Data de Nascimento - Conjugue
				<input type="text" id='f_conjugue_data_nascimento' name="f_conjugue_data_nascimento" value="<?=DataUsaToBr($cliente_fornecedor->conjugue_data_nascimento)?>" mascara='__/__/____' sonumero='1'/>
			</label>
			<label style="width:294px;">
				Ramo de Atividade - Conjugue
				<input type="text" id='f_conjugue_ramo_atividade' name="f_conjugue_ramo_atividade" value="<?=$cliente_fornecedor->conjugue_ramo_atividade?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				CPF - Conjugue
				<input type="text" id='f_conjugue_cpf' name="f_conjugue_cpf" value="<?=$cliente_fornecedor->conjugue_cpf?>" mascara="___.___.___-__" sonumero='1' retorno='focus|Coloque o CPF corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				RG - Conjugue
				<input type="text" id='f_conjugue_rg' name="f_conjugue_rg" value="<?=$cliente_fornecedor->conjugue_rg?>" retorno='focus|Coloque o RG corretamente!' />
			</label>
            <div style="clear:both"></div>
			<label style="width:136px; margin-right:22px;" title='Local de emissao RG do Conjugue'>
				Local Emissao RG.
				<input type="text" id='f_conjugue_local_emissao' name="f_conjugue_local_emissao" value="<?=$cliente_fornecedor->conjugue_local_emissao?>" />
			</label>
            <label style="width:155px; margin-right:22px;">
				Data da Emissao - Conjugue
				<input type="text" id='f_conjugue_data_emissao' name="f_conjugue_data_emissao" value="<?=DataUsaToBr($cliente_fornecedor->conjugue_data_emissao)?>" mascara='__/__/____'/>
			</label>
            <label style="width:130px; margin-right:22px;">
				Telefone - Conjugue
				<input type="text" id='f_conjugue_telefone' name="f_conjugue_telefone" value="<?=$cliente_fornecedor->conjugue_telefone?>" mascara="(__)____-____" sonumero='1'/>
			</label>
            <label style="width:136px; margin-right:22px;">
				E-mail - Conjugue
				<input type="text" id='f_conjugue_email' name="f_conjugue_email" value="<?=$cliente_fornecedor->conjugue_email?>"/>
			</label>
            <label style="width:150px;">
				Naturalidade - Conjugue
				<input type="text" id='f_conjugue_naturalidade' name="f_conjugue_naturalidade" value="<?=$cliente_fornecedor->conjugue_naturalidade?>" />
			</label>
            <label style="width:150px;">
				Nacionalidade - Conjugue
				<input type="text" id='f_conjugue_nacionalidade' name="f_conjugue_nacionalidade" value="<?=$cliente_fornecedor->conjugue_nacionalidade?>" />
			</label>
            <label style="width:294px; margin-right:23px;">
				Endereco Comercial - Conjugue
				<input type="text" id='f_endereco_comercial_conjugue' name="f_endereco_comercial_conjugue" value="<?=$cliente_fornecedor->conjugue_endereco_comercial?>" />
			</label>
			<label style="width:170px;">
				Telefone Comercial - Conjugue
				<input type="text" id='f_telefone_comercial_conjugue' name="f_telefone_comercial_conjugue" value="<?=$cliente_fornecedor->conjugue_telefone_comercial?>" mascara="(__)____-____" sonumero='1' />
			</label>
			</div>
            <div style="clear:both"></div>
            	
			</label>
            
             <div style="clear:both"></div>
            
            <input type="file" name="foto_cliente_fisico" id="foto_cliente_fisico"/>
            
			
        </fieldset>
        
        <fieldset  id='campos_3' style="display:none">
			<legend>
				<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';">Jur&iacute;dico</a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';">F&iacute;sico</a>
                 <? if($cliente_fornecedor->id>0){?><a onclick="aba_form(this,2);"><strong>Documentos</a></strong><? } ?>
			</legend>
						
			<div style="clear:both"></div>
			    <label style="width:200px;">                
                Descri&ccedil;&atilde;o
                <input type="text" name="descricao_documento" id="descricao_documento">
                </label>
                <label style="width:250px;">                
                Arquivo
                <input type="file" name="arquivo_documento" id="arquivo_documento">
                </label>
              
                <label style="margin-left:30px;margin-top:20px;">                
                <img src="../fontes/img/mais.png" id="add_documento"/>
                </label>
                
                <div style="clear:both"></div>
                <table id="dados_documentos" cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:250px;">Descri&ccedil;&atilde;o</td>
                        <td style="width:30px;">Download</td>                        
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$documentos = mysql_query($t="SELECT * FROM cliente_fornecedor_arquivo WHERE cliente_fornecedor_id='$cliente_fornecedor->id'");
					//echo $t;
					while($documento = @mysql_fetch_object($documentos)){
				 ?>
                 	<tr id="<?=$documento->id?>">
                        <td style="width:250px;">
                        <img src='../fontes/img/menos.png' class='remove_documento'><?=$documento->descricao?>
                        
                        </td>
                       
                        <td style="width:30px;" align="center"><a class="download_documento"><img src='../fontes/img/baixar.png'></a></td>          
                    </tr>
                  <?php
					}
					
				  ?>
                   <input type="hidden" name="id_documento_exclusao" id="id_documento_exclusao"/>
                 </tbody>
                </table>
			
        </fieldset>
        
        <label>
        	Grupo:
             <select name="cf_grupo_id" id="cf_grupo_id">
    		<option value="" ></option>
        	<?php
				$grupos = mysql_query("SELECT * FROM cliente_fornecedor_grupo WHERE vkt_id='$vkt_id' AND tipo='C'");
				while($grupo = mysql_fetch_object($grupos)){
			?>
        	<option value="<?=$grupo->id?>" <?php if($cliente_fornecedor->grupo_id==$grupo->id){ echo "selected='selected'";}?>><?=$grupo->nome?></option>
        	<?php
				}
			?>
    		</select>
            
        </label>
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
    <input name="action2" id="action2" type="hidden" />
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<?
if($_GET['nao_abre']!=1){
	?>
    <script>top.openForm()</script>
    <?
}
?>
