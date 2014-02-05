<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div style="width:800px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Socio</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" id="form_socio_funcional" method="post" autocomplete="off" target="carregador" action="modulos/rh/empresa/form_socio_funcional.php">
	<fieldset  id='campos_1' >
		<input name="cliente_fornecedor_id" id="cliente_fornecedor_id" type="hidden" value="<?=$_GET['empresa_id']?>" />	
        <input type="hidden" name="socio_id" id="socio_id" value="<?=$socio->id?>" />
        <input type="hidden" name="j_tipo" value="<? if($socio->tipo_cadastro=="Físico") echo $socio->tipo?>">
            
        <legend>
			<a class="link_socio"><strong>Dados</strong></a>
            <a class="link_socio">Documentos</a>
			
		</legend>
            
		<label style="width:100px; margin-right:22px;">
			CPF
			<input type="text" id='f_cnpj_cpf' name="f_cnpj_cpf" value="<?=$socio->cnpj_cpf?>" mascara="___.___.___-__" sonumero='1' 
            retorno="focus|Digite o CPF corretamente" valida_minlength='3' onkeyup="checa_cpf(this)"/>
		</label>
            			
		<label style="width:294px; margin-right:23px;">
			Nome
			<input type="text" id='f_nome_contato' name="f_nome_contato" value="<?=$socio->razao_social?>" retorno="focus|Digite o nome corretamente"validamin_length='3'/>
		</label>
            
        <label style="width:100px;">
			Data Nascimento
			<input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" value="<?=dataUsaToBr($socio->nascimento)?>" 
            retorno="focus|Digite a data de nascimento" valida_minlength='1' />
		</label>
            
    	<label style="width:100px; margin-right:23px;">
			RG
			<input type="text" id='f_rg' name="f_rg" value="<?=$socio->rg?>"  sonumero='1' />
		</label>
          
    	<label style="width:100px; margin-right:22px;">
			Local de Emissão
			<input type="text" id='f_local_emissao' name="f_local_emissao" value="<?=$socio->local_emissao?>" />
		</label>
    	
        <label style="width:100px; margin-right:22px;">
			Data Emissao
			<input type="text" mascara='__/__/____' calendario='1' id='f_data_emissao' name="f_data_emissao" value="<?=dataUsaToBr($socio->data_emissao)?>" />
		</label>	
    	
        <label style="width:120px;">
  			Grau de Instrucao
    		<select name="f_grau_instrucao" >
    			<option></option>
        		<option <? if($socio->grau_instrucao=='analfabeto')echo "selected='selected'"; ?> value="analfabeto">Analfabeto</option>
        		<option <? if($socio->grau_instrucao=='fundamental incompleto')echo "selected='selected'"; ?> value="fundamental incompleto">
            	Fundamental Incompleto</option>
        		<option <? if($socio->grau_instrucao=='fundamental completo')echo "selected='selected'"; ?> value="fundamental completo">
                Fundamental Completo</option>
        		<option <? if($socio->grau_instrucao=='emincompleto')echo "selected='selected'"; ?> value="emincompleto">Ensino Médio Incompleto</option>
        		<option <? if($socio->grau_instrucao=='emcompleto')echo "selected='selected'"; ?> value="emcompleto">Ensino Médio Completo</option>
        		<option <? if($socio->grau_instrucao=='superior incompleto')echo "selected='selected'"; ?> value="superior incompleto">Superior Incompleto</option>
        		<option <? if($socio->grau_instrucao=='superior completo')echo "selected='selected'"; ?> value="superior completo">Superior Completo</option>
        		<option <? if($socio->grau_instrucao=='outros')echo "selected='selected'"; ?> value="outros">Outros</option>
    		</select>
  		</label>
        
        <label style="width:120px;">
			Ramo de Atividade
			<input type="text" id='f_ramo_atividade' name="f_ramo_atividade" value="<?=$socio->ramo_atividade?>" />
		</label>
        
        <label style="width:80px">
			Estado Civil
			<select name="f_estado_civil" id="f_estado_civil" retorno="focus|Digite o nome corretamente" valida_minlength='3'>
			<?
				if($socio->estado_civil=="Casado"){
					$casado='selected="selected"';
				}else if($socio->estado_civil=="Solteiro"){
					$solteiro='selected="selected"';
				}else{
					$viuvo='selected="selected"';
				}
			?>
				<option value="Solteiro" <?=$solteiro?>>Solteiro</option>
				<option value="Casado" <?=$casado?>>Casado</option>
                <option value="Viuvo" <?=$viuvo?>>Viuvo</option>
			</select>
		</label>
		
        <div id="informacoes_casados" style="display:none;width:150px;">
        	<label title="Regime de Bens" rel="tip">
            	Reg. Bens
            	<input type="text" name="regime_bens" id="regime_bens" value="<?=$socio->regime_bes?>"
            </label>
            <div style="clear:both"></div>
        </div>
        
        <label style="width:100px;">
			Naturalidade
			<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$socio->naturalidade?>" />
		</label>
        
        <label style="width:126px;">
			Nacionalidade
			<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$socio->nacionalidade?>" />
		</label>
        
             
        <label style="width:194px; margin-right:23px;">
			Email
			<input type="text" id='f_email' name="f_email" value="<?=$socio->email?>"  />
		</label>
            
		<label style="width:90px; margin-right:23px;">
			Telefone 1
			<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$socio->telefone1?>" mascara="(__)____-____" sonumero='1' valida_minlength='3' retorno='focus|Por favor, insira um telefone para contato' />
		</label>
		
        <label style="width:90px; margin-right:22px;">
			Telefone 2
			<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$socio->telefone2?>" mascara="(__)____-____" sonumero='1' />
		</label>
		
        <label style="width:90px; margin-right:23px;">
			Fax
			<input type="text" id='f_fax' name="f_fax" value="<?=$socio->fax?>" mascara="(__)____-____" sonumero='1' />
		</label>
		
               
        <label style="width:75px; margin-right:22px;">
			Cep
			<input type="text" id='f_cep' name="f_cep" value="<?=$socio->cep?>" mascara="_____-___" sonumero='1' 
            autocomplete="off" onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/escolar/professor/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}"/>
		</label>
		
        <label style="width:190px; margin-right:23px;">
			Endereço
			<input type="text" id='f_endereco' name="f_endereco" value="<?=$socio->endereco?>" />
		</label>
        
        <label style="width:20px; margin-right:23px;">
			N&ordm;
			<input type="text" id='f_numero' name="f_numero" value="<?=$socio->casa_numero?>" />
		</label>
        
        <label style="width:136px; margin-right:23px;">
			Bairro
			<input type="text" id='f_bairro' name="f_bairro" value="<?=$socio->bairro?>"/>
		</label>
		
        <label style="width:120px; margin-right:22px;">
			Cidade
			<input type="text" id='f_cidade' name="f_cidade" value="<?=$socio->cidade?>" retorno="focus|Digite a cidade corretamente" valida_minlength='2'/>
		</label>
		
        <label style="width:30px; margin-right:23px;">
			Estado
			<input type="text" id='f_estado' name="f_estado" value="<?=$socio->estado?>" retorno="focus|Digite o estado corretamente" valida_minlength='2'/>
		</label>
        
      	<label style="width:80px; margin-right:23px;">
			Complemento
			<input type="text" id='f_complemento' name="f_complemento" value="<?=$socio->complemento	?>" />
		</label>
        
        <label style="width:90px; margin-right:23px;" title="Base de cálculo para GPS individual" rel='tip'>
			Vlr Contribuiçao
			<input type="text" id='f_valor_contribuicao' name="f_valor_contribuicao" value="<?=MoedaUsaToBr($dados_socio->valor_contribuicao)?>" sonumero="1" decimal="2"/>
		</label>
        
        <div style="clear:both"></div>
        
        <label style="width:180px; margin-right:23px;">
			Nome da Mãe
			<input type="text" id='f_nome_mae' name="f_nome_mae" value="<?=$socio->filiacao_mae?>"/>
		</label>
        
        <label style="width:180px; margin-right:23px;">
			Nome do Pai
			<input type="text" id='f_nome_pai' name="f_nome_pai" value="<?=$socio->filiacao_pai?>"/>
		</label>
        
        <label style="width:100px; margin-right:23px;" title="Data da Assiatura" rel="tip">
			Dt. Assinatura
			<input type="text" id='f_data_assinatura' name="f_data_assinatura" value="<?=DataUsaToBr($dados_socio->data_assinatura)?>" mascara="__/__/____" sonumero="1"/>
		</label>
			
		<div style="clear:both"></div>
			
        <input type="hidden" name="f_id" id="f_id" value="<?=$socio->f_id?>" />
		    
	</fieldset>
    <input type="hidden" name="acao2" id="acao2" value="socio"> 
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($socio->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="id" type="hidden" value="<?=$socio->id?>"/>
    <input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
</form>

<form onsubmit="return validaForm(this)" class="form_float" id="form_documento_socio" method="post" autocomplete="off" target="carregador" action="modulos/rh/empresa/form_socio_funcional.php" style="display:none" enctype="multipart/form-data">
	<fieldset  id='campos_1' >
		<input name="cliente_fornecedor_id" id="cliente_fornecedor_id" type="hidden" value="<?=$_GET['empresa_id']?>" />	
        <input type="hidden" name="socio_id" id="socio_id" value="<?=$socio->id?>" />
        <input type="hidden" name="j_tipo" value="<? if($socio->tipo_cadastro=="Físico") echo $socio->tipo?>">
            
        <legend>
			<a class="link_socio">Dados</a>
            <a class="link_socio"><strong>Documentos</strong></a>
			
		</legend>
            
		 <label style="width:250px;">
        		Descriçao
                <input type="text" name="documento_descricao" id="documento_descricao" />
        </label>
        
        <label style="width:300px;">
        		Arquivo
                <input type="file" name="documento_arquivo_socio" id="documento_arquivo_socio" />
        </label>
        
        <input type="button"  id="adicionar_documento_socio" value="Adicionar Documento" style="margin-top:17px;"/>
        
        <div style="clear:both"></div>
        <div id='dados_documentos_socios'>
       <div id='documentos_socios'>
<table  cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:250px;">Descriçao</td>
                         <td style="width:15px;">Download</td>
                         <td style="width:15px;">Remover</td>                     
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$documentos = mysql_query($t="SELECT * FROM   cliente_fornecedor_arquivo WHERE cliente_fornecedor_id='$socio->id'");
					
					//echo $t;
					while($documento = @mysql_fetch_object($documentos)){
				 ?>
                 	<tr id_documento="<?=$documento->id?>">
                        <td style="width:250px;"><? if(empty($_GET['remove_documento'])||empty($_POST['acao2'])){ echo $documento->descricao;}else{echo utf8_encode($documento->descricao);}?></td>	
        				<td style="width:15px;"><img src="../fontes/img/baixar.png" class="imprimir_documento_empresa"/></td>               
                        <td style="width:15px;"><img src='../fontes/img/menos.png' id='remove_documento_socio'></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
  </table>

  </div>
        </div>
        <input type="hidden" name="acao2" id="acao2" value="documento_socio" />
			
		<div style="clear:both"></div>
			
        <input type="hidden" name="f_id" id="f_id" value="<?=$socio->f_id?>" />
		    
	</fieldset>
    
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	/*if($socio->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}*/
	?>
	<input name="id" type="hidden" value="<?=$socio->id?>"/>
    <input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>
dados =document.getElementById('aSerCarregado').innerHTML;
top.document.getElementById('form_socio').innerHTML=dados;
</script>