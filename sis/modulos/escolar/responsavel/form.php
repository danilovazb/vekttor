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
    
    <span>Responsável</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
			
		<fieldset >
         <legend>
      			<a onclick="aba_form(this,0)"><strong>Responsável</strong></a>
      			<a onclick="aba_form(this,1)">Matriculas</a>
      	 </legend>
			<div style="clear:both"></div>
			<label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='f_nome_contato' name="f_nome_contato" value="<?=$responsavel->nome_contato?>" retorno="focus|Digite o nome corretamente" valida_minlength='3'/>
			</label>
             <label style="width:126px;">
				Data Nascimento
				<input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" value="<?=dataUsaToBr($responsavel->nascimento)?>" retorno="focus|Digite a data de nascimento" valida_minlength='1'/>
			</label>
            <label style="width:120px;">
  	Grau de Instrucao
    <select name="f_grau_instrucao" >
    	<option></option>
        <option <? if($responsavel->grau_instrucao=='analfabeto')echo "selected='selected'"; ?> value="analfabeto">Analfabeto</option>
        <option <? if($responsavel->grau_instrucao=='fundamental incompleto')echo "selected='selected'"; ?> value="fundamental incompleto">Fundamental Incompleto</option>
        <option <? if($responsavel->grau_instrucao=='fundamental completo')echo "selected='selected'"; ?> value="fundamental completo">Fundamental Completo</option>
        <option <? if($responsavel->grau_instrucao=='emincompleto')echo "selected='selected'"; ?> value="emincompleto">Ensino Médio Incompleto</option>
        <option <? if($responsavel->grau_instrucao=='emcompleto')echo "selected='selected'"; ?> value="emcompleto">Ensino Médio Completo</option>
        <option <? if($responsavel->grau_instrucao=='superior incompleto')echo "selected='selected'"; ?> value="superior incompleto">Superior Incompleto</option>
        <option <? if($responsavel->grau_instrucao=='superior completo')echo "selected='selected'"; ?> value="superior completo">Superior Completo</option>
        <option <? if($responsavel->grau_instrucao=='outros')echo "selected='selected'"; ?> value="outros">Outros</option>
    </select>
  </label>
            <div style="clear:both"></div>
			<label style="width:194px;">
				Ramo de Atividade
				<input type="text" id='f_ramo_atividade' name="f_ramo_atividade" value="<?=$responsavel->ramo_atividade?>" />
			</label>
			<label style="width:100px; margin-right:22px;">
				CPF
				<input type="text" id='f_cnpj_cpf' name="f_cnpj_cpf" value="<?=$responsavel->cnpj_cpf?>" mascara="___.___.___-__" sonumero='1' retorno="focus|Digite o CPF corretamente" valida_minlength='3'/>
			</label>
			<label style="width:100px; margin-right:23px;">
				RG
				<input type="text" id='f_rg' name="f_rg" value="<?=$responsavel->rg?>"  sonumero='1' retorno="focus|Digite o RG corretamente" valida_minlength='3' />
			</label>
            <label style="width:100px; margin-right:22px;">
				Local de Emissão
				<input type="text" id='f_local_emissao' name="f_local_emissao" value="<?=$responsavel->local_emissao?>" />
			</label>
            <label style="width:130px">
				Estado Civil
				<select name="f_estado_civil" retorno="focus|Digite o nome corretamente" valida_minlength='3'>
				<?
					if($responsavel->estado_civil=="Casado"){
						$casado='selected="selected"';
					}else{
						$solteiro='selected="selected"';
					}
				?>
					<option value="Solteiro" <?=$solteiro?>>Solteiro</option>
					<option value="Casado" <?=$casado?>>Casado</option>
				</select>
			</label>
			<label style="width:126px; margin-right:22px;">
				Data Emissao
				<input type="text" mascara='__/__/____' clendario='1' id='f_data_emissao' name="f_data_emissao" value="<?=dataUsaToBr($responsavel->data_emissao)?>" />
			</label>	           
            <label style="width:100px;">
				Naturalidade
				<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$responsavel->naturalidade?>" />
			</label>
            <label style="width:126px;">
				Nacionalidade
				<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$responsavel->nacionalidade?>" />
			</label>
            <div style="clear:both"></div>
            <label style="width:194px; margin-right:23px;">
				Email
				<input type="text" id='f_email' name="f_email" value="<?=$responsavel->email?>"  retorno="focus|Digite o email corretamente" valida_minlength='3' />
			</label>
            
			<label style="width:100px; margin-right:23px;">
				Telefone 1
				<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$responsavel->telefone1?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:100px; margin-right:22px;">
				Telefone 2
				<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$responsavel->telefone2?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:100px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="f_fax" value="<?=$responsavel->fax?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<div style="clear:both"></div>
            <label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='f_cep' name="f_cep" value="<?=$responsavel->cep?>" mascara="_____-___" sonumero='1' busca='modulos/escolar/responsavel/busca_endereco.php,@r0,@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado' autocomplete="off" retorno="focus|Digite o CEP corretamente" valida_minlength='3'/>
			</label>
			 <label style="width:190px; margin-right:23px;">
				Endereço
				<input type="text" id='f_endereco' name="f_endereco" value="<?=$responsavel->endereco?>" retorno="focus|Digite o Endereco corretamente" valida_minlength='3'/>
			</label>
            <label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='f_bairro' name="f_bairro" value="<?=$responsavel->bairro?>" retorno="focus|Digite o Bairro corretamente" valida_minlength='3'/>
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='f_cidade' name="f_cidade" value="<?=$responsavel->cidade?>" retorno="focus|Digite a cidade corretamente" valida_minlength='3'/>
			</label>
			<label style="width:30px; margin-right:23px;">
				Estado
				<input type="text" id='f_estado' name="f_estado" value="<?=$responsavel->estado?>" retorno="focus|Digite o estado corretamente" valida_minlength='2'/>
			</label>
	
			<div style="clear:both"></div>
			
            
		</fieldset>
        
        
        <!-- -->
      <fieldset id="campos_2" style="display:none"> 
      <legend>
      <a onclick="aba_form(this,0)">Responsável</a>
      <a onclick="aba_form(this,1)"><strong>Matriculas</strong></a>
      </legend>
      	<table>
        	
        		  <tr >
            <td><strong>Matricula</strong></td>
            <td><strong>Alunos</strong></td>
            <td><strong>Escolca</strong></td>
            <td><strong>Curso</strong></td>
            <td><strong>Pago</strong></td>
            </tr>
            	<?php
					while($responsavel_mat =@mysql_fetch_object($matricula)){
						$aluno=mysql_fetch_object(mysql_query(" SELECT * FROM escolar_alunos WHERE id = '$responsavel_mat->aluno_id'"));
						$escola = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_escolas WHERE id = '$responsavel_mat->escola_id' "));
						$escola = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_escolas WHERE id = '$responsavel_mat->escola_id' "));
								$modulo		= mysql_fetch_object(mysql_query("SELECT * FROM escolar_modulos WHERE id='$responsavel_mat->modulo_id'"));
		$horario	= mysql_fetch_object(mysql_query("SELECT * FROM escolar_horarios WHERE id='$responsavel_mat->horario_id'"));
		$curso 		= mysql_fetch_object(mysql_query("SELECT * FROM escolar_cursos WHERE id='$responsavel_mat->curso_id'"));

				?>
                <tr onclick="location.href='?limitador=&tela_id=215&pagina=&busca=<?=$aluno->nome?>'">
            <td><?=$responsavel_mat->id?></td>
            <td><?=$aluno->nome?></td>
            <td><?=$escola->nome?></td>
            <td><?=$curso->nome.$modulo->nome	?></td>
            <td><?=$responsavel_mat->pago	?></td>
            </tr>
            	<?php
					}			
				?>
                
            </table><div style="clear:both"></div>
       </fieldset>
       <!-- -->
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($responsavel->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="action" type="submit"  value="Salvar" style="float:right"  />
    <input name ="id" type="hidden" value="<?=$responsavel->id?>" />
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>