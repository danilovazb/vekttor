<?
//Includes
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:850px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Funcionários</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<fieldset  id='campos_1' >
			
        <input type="hidden" name="j_tipo" value="<? if($cliente_fornecedor->tipo_cadastro=="Físico") echo $cliente_fornecedor->tipo?>">
            
        <legend>
			<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong>Funcionarios</strong></a>
			<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';">Usuário</a>
		</legend>
            <div style="float:left; width:650px;">
		<label style="width:100px; margin-right:22px;">
			CPF
			<input type="text" id='f_cnpj_cpf' name="f_cnpj_cpf" value="<?=$professor->cpf?>" mascara="___.___.___-__" sonumero='1' 
            retorno="focus|Digite o CPF corretamente" valida_minlength='3' onkeyup="checa_cpf(this)"/>
		</label>
            			
		<label style="width:294px; margin-right:23px;">
			Nome
			<input type="text" id='f_nome_contato' name="f_nome_contato" value="<?=$professor->nome_contato?>" retorno="focus|Digite o nome corretamente"validamin_length='3'/>
		</label>
            
        <label style="width:100px;">
			Data Nascimento
			<input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" value="<?=dataUsaToBr($professor->nascimento)?>" 
            retorno="focus|Digite a data de nascimento" valida_minlength='1' />
		</label>
            
    	<label style="width:100px; margin-right:23px;">
			RG
			<input type="text" id='f_rg' name="f_rg" value="<?=$professor->rg?>"  sonumero='1' />
		</label>
          
    	<label style="width:100px; margin-right:22px;">
			Orgão Emissor
			<input type="text" id='f_local_emissao' name="f_local_emissao" value="<?=$professor->rg_orgao_emissor?>" />
		</label>
    	
        <label style="width:100px; margin-right:22px;">
			Data Emissao
			<input type="text" mascara='__/__/____' calendario='1' id='f_data_emissao' name="f_data_emissao" value="<?=dataUsaToBr($professor->rg_data_emissao)?>" />
		</label>	
    	
        <label style="width:200px;">
  			Grau de Instrucao
    		<select name="f_grau_instrucao" >
    			<option></option>
        		<option <? if($professor->grau_instrucao=='analfabeto')echo "selected='selected'"; ?> value="analfabeto">Analfabeto</option>
        		<option <? if($professor->grau_instrucao=='fundamental incompleto')echo "selected='selected'"; ?> value="fundamental incompleto">Fundamental Incompleto</option>
        		<option <? if($professor->grau_instrucao=='fundamental completo')echo "selected='selected'"; ?> value="fundamental completo">Fundamental Completo</option>
        		<option <? if($professor->grau_instrucao=='emincompleto')echo "selected='selected'"; ?> value="emincompleto">Ensino Médio Incompleto</option>
        		<option <? if($professor->grau_instrucao=='emcompleto')echo "selected='selected'"; ?> value="emcompleto">Ensino Médio Completo</option>
        		<option <? if($professor->grau_instrucao=='superior incompleto')echo "selected='selected'"; ?> value="superior incompleto">Superior Incompleto</option>
        		<option <? if($professor->grau_instrucao=='superior completo')echo "selected='selected'"; ?> value="superior completo">Superior Completo</option>
        		<option <? if($professor->grau_instrucao=='outros')echo "selected='selected'"; ?> value="outros">Outros</option>
    		</select>
  		</label>
		<div style="clear:both"></div>
        <label style="width:120px;">
			Ramo de Atividade
			<input type="text" id='f_ramo_atividade' name="f_ramo_atividade" value="<?=$professor->ramo_atividade?>" />
		</label>
        
        <label style="width:80px">
			Estado Civil
			<select name="f_estado_civil" retorno="focus|Digite o nome corretamente" valida_minlength='3'>
			<?
				if($professor->estado_civil=="Casado"){
					$casado='selected="selected"';
				}else{
					$solteiro='selected="selected"';
				}
			?>
				<option value="Solteiro" <?=$solteiro?> >Solteiro</option>
				<option value="Casado" <?=$casado?> >Casado</option>
			</select>
		</label>
		
        <label style="width:100px;">
			Naturalidade
			<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$professor->naturalidade?>" />
		</label>
        
        <label style="width:126px;">
			Nacionalidade
			<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$professor->nacionalidade?>" />
		</label>
         <label>
  			Cargo
    		<select name="cargo_id" >
            <? $cargos_q=mysql_query("SELECT * FROM cargo_salario WHERE vkt_id='$vkt_id' ORDER BY cargo ASC"); ?>
    		<option value="0"></option>
            <? while($cargo=mysql_fetch_object($cargos_q)){ ?>
            	<option value="<?=$cargo->id?>"> <?=$cargo->cargo?> </option>
            <? } ?>
    		</select>
  		</label>
		<div style="clear:both"></div>
        <label style="width:80px;" >
        Salário
        	<input name="salario" type="text" sonumero="1" value="" />
        </label>
        <label style="width:194px; margin-right:23px;">
			Email
			<input type="text" id='f_email' name="f_email" value="<?=$professor->email?>"  retorno="focus|Digite o email corretamente" valida_minlength='3' />
		</label>
            
		<label style="width:90px; margin-right:23px;">
			Telefone 1
			<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$professor->telefone1?>" mascara="(__)____-____" sonumero='1' valida_minlength='3' retorno='focus|Por favor, insira um telefone para contato' />
		</label>
		
        <label style="width:90px; margin-right:22px;">
			Celular
			<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$professor->telefone2?>" mascara="(__)____-____" sonumero='1' />
		</label>
		
        <label style="width:90px; margin-right:23px;">
			Fax
			<input type="text" id='f_fax' name="f_fax" value="<?=$professor->fax?>" mascara="(__)____-____" sonumero='1' />
		</label>
		
        
        <label style="width:75px; margin-right:22px;">
			Cep
			<input type="text" id='f_cep' name="f_cep" value="<?=$professor->cep?>" mascara="_____-___" sonumero='1' 
            autocomplete="off" onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/escolar/professor/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}"/>
		</label>
		
        <label style="width:190px; margin-right:23px;">
			Endereço
			<input type="text" id='f_endereco' name="f_endereco" value="<?=$professor->endereco?>" />
		</label>
        
        <label style="width:136px; margin-right:23px;">
			Bairro
			<input type="text" id='f_bairro' name="f_bairro" value="<?=$professor->bairro?>"/>
		</label>
		
        <label style="width:136px; margin-right:22px;">
			Cidade
			<input type="text" id='f_cidade' name="f_cidade" value="<?=$professor->cidade?>" retorno="focus|Digite a cidade corretamente" valida_minlength='2'/>
		</label>
		
        <label style="width:30px; margin-right:23px;">
			Estado
			<input type="text" id='f_estado' name="f_estado" value="<?=$professor->estado?>" retorno="focus|Digite o estado corretamente" valida_minlength='2'/>
		</label>
        
        <label style="width:160px;">
  			Status
    		<select name="f_estatus_professor" >
    			<option></option>
        		<option <? if($professor->estatus_professor=='contratado')echo "selected='selected'"; ?> value="contratado">Contratado</option>
        		<option <? if($professor->estatus_professor=='efetivo/concursado')echo "selected='selected'"; ?> value="efetivo/concursado">Efetivo/Concursado</option>
        		<option <? if($professor->estatus_professor=='estagio probatorio')echo "selected='selected'"; ?> value="estagio probatorio">Estágio Probatório</option>
        		<option <? if($professor->estatus_professor=='outros')echo "selected='selected'"; ?> value="outros">Outros</option>
    		</select>
  		</label>
        <label style="width:100px; margin-right:22px;">
			Data Adimissão
			<input type="text" mascara='__/__/____' calendario='1' id='f_data_emissao' name="f_data_emissao" value="<?=dataUsaToBr($professor->data_emissao)?>" />
		</label>
        
        <label style="width:100px; margin-right:22px;">
			Fim do Contrato
			<input type="text" mascara='__/__/____' calendario='1' id='f_data_emissao' name="f_data_emissao" value="<?=dataUsaToBr($professor->data_emissao)?>" />
		</label>
        
      
         <div style="clear:both"></div>
        <label>Cadeira
        	<input type="text" name="cadeira">
        </label>
		<label>Escola
        	<input type="text" name="cadeira">
        </label>
        <div style="clear:both"></div>
        <label>Cadeira
        	<input type="text" name="cadeira">
        </label>
		<label>Escola
        	<input type="text" name="cadeira">
        </label>
        <div style="clear:both"></div>
        <label>Cadeira
        	<input type="text" name="cadeira">
        </label>
		<label>Escola
        	<input type="text" name="cadeira">
        </label>
        <div style="clear:both"></div>
         
        </div>
        
            <div style="width:120px;float:left; height:160px;border:1px solid #999; background:#FFF; overflow:hidden">
            
            		<div style="clear:both; padding:2px;" id='img_curso' >
                <?
                if(strlen($d->extensao)>=3){
				?>
                <img src='modulos/escolare/funcionarios/img/<?=$d->id?>.<?=$d->extensao?>' height="100" /><br />
                <?
				}
				?>
                </div>
            
            </div>
    <?
                if(strlen($d->extensao)>=3){
				?>
                <a href="#" onclick="this.style.display='none'" class='remove_imagem' aluno_id='<?=$d->id?>'>Remover</a>
                   <?
				}
				?>
		<div style="clear:both"></div>
            <label>
            		<input type="file" name="file[]" >
            </label>
			
        <input type="hidden" name="f_id" id="f_id" value="<?=$professor->f_id?>" />
        
		    
	</fieldset>
    
    <fieldset  id='campos_2' style="display:none" >
		<legend>
			<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';">Professor</a>
			<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';"><strong>Usuário</strong></a>
		</legend>
        
        <?php
			$usuario=mysql_fetch_object(mysql_query($t="select * from usuario WHERE id='".$professor->usuid."'"));
		?>
            
		<label style="width:151px">
			Tipo de Usuário
            <select name="usuario_tipo">
				<?php
					$q=mysql_query("SELECT * FROM usuario_tipo WHERE vkt_id='$vkt_id'");
					while($r=mysql_fetch_object($q)){
				?>
            	
                <option <? if($r->id==$usuario->usuario_tipo_id)echo 'selected="selected"'; ?>  value="<?=$r->id?>"><?=$r->nome?></option>
				
				<?
					}//$r
				?>
            </select>
        </label>
		
        <div style="clear:both"></div>
        
        <label style="width:144px; margin-right:23px;">
			Login
			<input type="text" name="login" id="login" value="<?=$usuario->login?>" maxlength="23"  retorno="focus|Digite Um Login na aba Usuário" 	            valida_minlength='1'/>
		</label>
        
		<label style="width:144px">
			Senha
			<input name="senha" id='senha' type="password" value="<?=$usuario->senha?>" maxlength="23" retorno="focus|Digite Uma Senha na aba Usuário" valida_minlength='1'/>
		</label>
        
		<input name="usuario" type="hidden" value="<?=$usuario->id?>" />
        
	</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($professor->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="id" type="hidden" value="<?=$professor->id?>"/>
    <input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
    
    
</form>
</div>
</div>
</div>
<script>top.openForm()</script>