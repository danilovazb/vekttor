<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<style>
label#responsavel:hover{ cursor:crosshair;}
</style>
<div id='aSerCarregado'>
<div style="width:850px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Matrícula</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"  method="post" enctype="multipart/form-data">

		<input type="hidden" id="aluno_id" name="aluno_id" value="<?=$_GET['aluno_id']; ?>" />

		<fieldset>
        	<legend>
            <a onclick="aba_form(this,0)" id="confirma_turma"><strong>Confirmação de Matricula</strong></a>
            <div style="display:none" id="menu_cadastro_aluno">
            <a onclick="aba_form(this,1)">Dados dos alunos</a>
    		<a onclick="aba_form(this,2)">Filiaçao</a>
    		<a onclick="aba_form(this,3)">Transporte</a>
    		<a onclick="aba_form(this,4)">Emergencia</a>
            <a onclick="aba_form(this,5)">Matricula</a>
            <a onclick="aba_form(this,6)">Observaçao</a>
            </div>
          </legend>
            <input type="hidden" name="responsavel_id" id="responsavel_id" value="<?=$responsavel->id?>">
        		<!-- -->
                	<?
		
		if($responsavel->id>0){$tipo=$responsavel->tipo_cadastro;}else{$tipo='Físico';}
		$selecionado[$tipo]="selected='selected'";
		$desaparece[$tipo]="display:none";
		$desabilita[$tipo]="disabled='disabled'";
		$dado=($tipo=='Jurídico')?'CNPJ':'CPF';
		$retorno[$tipo]="retorno='focus|Digite o $dado corretamente'";
		?>			
          <label>Tipo
          	<select id="tipo_cadastro" name="tipo_cadastro" onchange="mudaTipo(this);" >
            	<option <?=$selecionado['Físico']?> value="Físico">Física</option>
                <option <?=$selecionado['Jurídico']?> value="Jurídico">Jurídico</option>
            </select>
          </label>

          <label id="cpf" style="width:120px; margin-right:22px;<?=$desaparece['Jurídico']?>">
				CPF
				<input type="text" id='f_cnpj_cpf' <?=$desabilita['Jurídico']?> onkeyup="checa_cpf(this)" name="f_cnpj_cpf" value="" mascara="___.___.___-__" sonumero='1' retorno="focus|Digite o CPF corretamente" valida_cpf='1'/>
			</label>
            
         <label id="cnpj" style="width:120px; margin-right:22px;<?=$desaparece['Físico']?>">
				CNPJ
				<input type="text" id='f_cnpj_cpf' <?=$desabilita['Físico']?> name="f_cnpj_cpf" value="<?=$responsavel->cnpj_cpf?>" mascara="__.___.___/____-__" sonumero='1' retorno="focus|Digite o CNPJ corretamente"/>
			</label>
			<label style="width:240px; margin-right:23px;">
				Nome
				do Respons&aacute;vel<br />
				<input type="text" id="nome_responsavel" name="nome_responsavel" value="" retorno="focus|Digite o nome do Responsável" valida_minlength='3'/>
			</label>
             <label style="width:70px;">
				Nascimento
				<input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" value="" retorno="focus|Digite a data de nascimento - Responsável" valida_minlength='1' valida_data='01/01/0001,99/99/9999'/>
			</label>
            <label style="width:120px;">
  	Grau de Instrucao
    <select name="f_grau_instrucao" id="f_grau_instrucao" >
        <option <? if($responsavel->grau_instrucao=='superior incompleto')echo "selected='selected'"; ?> value="superior incompleto">Superior Incompleto</option>
        <option <? if($responsavel->grau_instrucao=='superior completo')echo "selected='selected'"; ?> value="superior completo">Superior Completo</option>
        <option <? if($responsavel->grau_instrucao=='outros')echo "selected='selected'"; ?> value="outros">Outros</option>
    </select>
  </label>
<div style="clear:both"></div>			<label style="width:120px;">
				Ramo de Atividade
				<input type="text" id='ramo_atividade_responsavel' name="ramo_atividade_responsavel" value="" />
			</label>
            
			<label style="width:100px; margin-right:23px;">
				RG
				<input type="text" id='f_rg' name="f_rg" value=""  sonumero='1' retorno="focus|Digite o RG corretamente - Responsável" valida_minlength='3' />
			</label>
            <label style="width:100px; margin-right:22px;">
				Local de Emissão
				<input type="text" id='f_local_emissao' name="f_local_emissao" value="" />
			</label><label style="width:90px; margin-right:22px;">
				Data Emissao
				<input type="text" mascara='__/__/____' onfocus="this.select" clendario='1' id='f_data_emissao' name="f_data_emissao" value="" />
			</label>
            <label style="width:130px">
				Estado Civil
				<select name="f_estado_civil" >
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
		            <div style="clear:both"></div>
		           
          <label style="width:100px;">
				Naturalidade
				<input type="text" id='f_naturalidade' name="f_naturalidade" value="" />
			</label>
            <label style="width:126px;">
				Nacionalidade
				<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="" />
			</label>
            <div style="clear:both"></div>
            <label style="width:194px; margin-right:23px;">
				Email
				<input type="text" id='f_email' name="f_email" value=""  retorno="focus|Digite o email corretamente" valida_minlength='3' />
			</label>
            
			<label style="width:100px; margin-right:23px;">
				Telefone 1
				<input type="text" id='f_telefone1' name="f_telefone1" value="" mascara="(__)____-____" sonumero='1' retorno="focus|Digite o telefone corretamente" valida_minlength='3'/>
			</label>
			<label style="width:100px; margin-right:22px;">
				Telefone 2
				<input type="text" id='f_telefone2' name="f_telefone2" value="" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:100px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="f_fax" value="" mascara="(__)____-____" sonumero='1' />
			</label>
			<div style="clear:both"></div>
            <label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='f_cep' name="f_cep" value="" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );document.title=cp;if(cp.length==9){return vkt_ac(this,event,'undefined','modulos/escolar/responsavel/busca_endereco.php','@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}" autocomplete="off" retorno="focus|Digite o CEP corretamente" valida_minlength='3'/>
			</label>
			 <label style="width:190px; margin-right:23px;">
				Endereço
				<input type="text" id='f_endereco' name="f_endereco" value="" retorno="focus|Digite o Endereco corretamente" valida_minlength='3'/>
			</label>
            <label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='f_bairro' name="f_bairro" value="" retorno="focus|Digite o Bairro corretamente" valida_minlength='3'/>
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='f_cidade' name="f_cidade" value="" retorno="focus|Digite a cidade corretamente" valida_minlength='3'/>
			</label>
			<label style="width:30px; margin-right:23px;">
				Estado
				<input type="text" id='f_estado' name="f_estado" value="Am" retorno="focus|Digite o estado corretamente" valida_minlength='2'/>
			</label>
            
            <?
            if($_GET[matricula_id]<1){
			?>
	<label style="width:180px;display:none">
				Alunos que vai Matricular<br />
				<select   style="width:60px;" class="alunos_a_ser_matriculados" name="alunos_a_ser_matriculados"  >
				<?
				?>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
			</label>
            <?
            }else{
			?>
			<input type="hidden" name="alunos_a_ser_matriculados" value="1" />
			<?	
			}
			?>
			<div style="clear:both"></div>  
            
                <!-- fim de dados confirmação matriucla --> 
                
        </fieldset>
        <!-- fim de fieldset -->
        
        <fieldset id="campos_2" style="display:none">
          <legend>
            <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
            <a onclick="aba_form(this,1)"><strong>Dados dos alunos</strong></a>
    		<a onclick="aba_form(this,2)">Filiaçao</a>
    		<a onclick="aba_form(this,3)">Transporte</a>
    		<a onclick="aba_form(this,4)">Emergencia</a>
            <a onclick="aba_form(this,5)">Matricula</a>
            <a onclick="aba_form(this,6)">Observaçao</a>
          
          </legend>
            <div style="float:left; width:650px;">
           	
          
            
            <label><input type="checkbox" id="responsavel_e_aluno" style="width:inherit" value="0" name="mesmo">Este Aluno tem os mesmos dados do responsavel</label>
            <div style="clear:both;"></div>
			<label style="width:260px;">
				Nome do aluno
				<input type="text" name="nome_aluno" id="nome_aluno" value="<?=$d->nome; ?>" />
			</label>
            <label style="width:80px;">
				Nascimento
				<input type="text" id="data_nascimento_aluno" name="data_nascimento_aluno" mascara="__/__/____" sonumero="1" value="<?=dataUsaToBr($d->data_nascimento); ?>" />
			</label>
            
            
           
            <label style="width:115px;">Cor
            <select name="cor" id="cor">
            	<option value="branco">Branco</option>
                <option value="pardo-moreno">Pardo/Moreno</option>
                <option value="negro">Negro</option>
                <option value="amarelo">Amarelo</option>
                <option value="indigena">Indígena</option>
                <option value="naodeclarado">N&atilde;o Declarado</option>
            </select>
            </label>
           	<!-- -->
            <label style="width:90px;">Sexo
              <select name="sexo_aluno" id="sexo_aluno">
                  <option value="masculino">Masculino</option>
                  <option value="feminino">Feminino</option>
              </select>
            </label>
             <div style="display:none">
            	Cor<br/>
                <input type="radio" name="cor" value="branco" <? if($d->cor == 'branco') echo 'checked="checked"';?>>Branco
                <input type="radio" name="cor" value="pardo-moreno" <? if($d->cor == 'pardo-moreno') echo $checked = 'checked="checked"';?>>Pardo/Moreno
                <input type="radio" name="cor" value="negro" <? if($d->cor == 'negro') echo $checked = 'checked="checked"';?>>Negro
                <input type="radio" name="cor" value="amarelo" <? if($d->cor == 'amarelo') echo $checked = 'checked="checked"'; ?>>Amarelo
                <input type="radio" name="cor" value="indigena" <? if($d->cor == 'indigena') echo $checked = 'checked="checked"';?>>Indígena
                <input type="radio" name="cor" value="naodeclarado" <? if($d->cor == 'naodeclarado') echo $checked = 'checked="checked"';?>>N&atilde;o Declarado
             </div>
               
             <div style="clear:both"></div>
            
             <label style="width:105px;">
				CPF
				<input type="text" id="cpf_aluno" name="cpf_aluno" value="<?=$d->cpf; ?>" mascara='___.___.___-__' <?
				$idade = calcula_idade( $d->data_nascimento );
				if($idade>=18&&$d->id>0){
					echo " valida_cpf='1' retorno='focus|Digite o CPF corretamente do aluno'";
				}
				?>/>
			</label>
            <label style="width:95px;">
				RG
				<input type="text" id="rg_aluno" name="rg_aluno" sonumero='1' value="" />
			</label>
            
            <label style="width:85px;">
				Data Expedição
				<input type="text" id="rg_dt_expedicao" name="rg_dt_expedicao" mascara='__/__/____' value="" />
			</label>
            <label style="width:165px;">
				Profissão
				<input type="text" id="profissao" name="profissao"  value="<?=$d->profissao; ?>" />
			</label>
           
            
           
             <div style="clear:both"></div>
            
            <label style="width:255px;">
				E-Mail
				<input type="text" id="email" name="email" retorno='focus|Coloque o email corretamente' value="" />
			</label>
            <label style="width:105px;">
				Tel. Residencial
				<input type="text" id="telefone1" name="telefone1" mascara='(__)____-____' value="" />
			</label>
            
            <label style="width:105px;">
				Tel. Celular
				<input type="text" id="telefone2" name="telefone2" mascara='(__)____-____' value="" />
			</label>
            <div style="clear:both"></div>
            
             <label style="width:88px;">
				CEP
				<input type="text" id="cep" name="cep" mascara='_____-___' sonumero='1' value="<?=$d->cep; ?>" />
			</label>
            <label style="width:238px;">
				Endereço
				<input type="text" id="endereco" name="endereco" value="<?=$d->endereco; ?>" />
			</label>
            
            <label style="width:137px;">
				Bairro
				<input type="text" id="bairro" name="bairro" value="<?=$d->bairro; ?>" />
			</label>
            
          
            
            <div style="clear:both"></div>
            
            <label style="width:130px;">
				Complemento
				<input type="text" id="complemento" name="complemento" value="<?=$d->complemento; ?>" />
			</label>
        
           
			
            <label style="width:100px;">
				Cidade
				<input type="text" id="cidade" name="cidade" value="<?=$d->cidade; ?>" />
			</label>
            
            <label style="width:25px;">
				UF
				<input type="text" id="uf" name="uf" value="<?=$d->uf; ?>" />
			</label>
           
             <label style="width:190px;">
				Portador Necessidades Especiais
				<input type="text" id="portador_necessidade" name="portador_necessidade[]" value="" />
			</label>
            
           <div style="clear:both"></div>
            <label style="width:160px;">
				Escolaridade
				<input type="text" id="escolaridade_aluno" name="escolaridade_aluno" value="<?=$d->escolaridade; ?>" />
			</label>
            
            <label>Código Interno<br/>
            	<input type="text" name="codigo_interno" id="codigo_interno" style="width:90px;" value="<?=$d->codigo_interno;?>">
            </label>
            <label style="width:60px;">Cod.Aluno: <?=$d->id?>
            </label>
            <label style="width:60px;">Senha
            	<input type="text" name="senha" id="senha" value="<?=$d->senha?>" />
            </label>
                  <label  style="width:100px">
            Tipo de Aluno <br />
            <?
			
			$bolsista = mf(mq("
			SELECT * FROM escolar_alunos_bolsistas WHERE aluno_id = '$d->id'
			"));
            if($bolsista->aluno_id>0){
				echo "<strong>Bolsista</strong>";	
			}else{
				echo "<strong>Integral</strong>";	
			}
			?>
			</label>
            <label><? if($cliente_id==13){ ?> Universidades/Áreas <?   }else{ ?>  Restriçao Alimentar / Alergia <?  } ?>
            	<input type="text" name="restricao_alimentar" id="restricao_alimentar" size="55" value="<?=$d->restricao_alimentar?>">
            </label>
                  

            <div style="clear:both;"></div>
            <label><br/>
            		<input type="file" name="file[]" >
            </label>
            
        <label>Turma
      	<select>
        	<option>Turma</option>
            <?php
            	$sql_periodo_letivo = mysql_query(" SELECT * FROM escolar2_turmas WHERE vkt_id = '$vkt_id' ");
				while($turma = mysql_fetch_object($sql_periodo_letivo)){
			?>
            <option value="<?=$turma->id?>"><?=utf8_encode($turma->nome);?></option>
            <?php
				}
			?>
        </select>
      </label>
      
            
            </div>
            <div style="width:120px;float:left; height:160px;border:1px solid #999; background:#FFF; overflow:hidden">
            
            		<div style="clear:both; padding:2px;" id='img_curso' >
                <?
                if(strlen($d->extensao)>=3){
				?>
                <img src='modulos/escolar/alunos_inscritos/img/<?=$d->id?>.<?=$d->extensao?>' height="100" /><br />
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
       <!--<div style="clear:both;"></div>         
      <div style="border-bottom:1px solid #CCC; width:50%; padding:2px; margin-bottom:8px;"> <sub> Turma  &nbsp; </div>-->
     
      </fieldset>
      
      <fieldset id="campos_3" style="display:none"> 
       <legend>
        <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
        
        <a onclick="aba_form(this,1)">Dados dos alunos</a>
        <a onclick="aba_form(this,2)"><strong>Filiaçao</strong></a>
        <a onclick="aba_form(this,3)">Transporte</a>
        <a onclick="aba_form(this,4)">Emergencia</a>
        <a onclick="aba_form(this,5)">Matricula</a>
        <a onclick="aba_form(this,6)">Observaçao</a> 
      </legend>
      				
                    <label style="width:250px;">Mae
                    	<input type="text" name="mae" id="mae" value="<?=$d->mae?>">                    	
                    </label>
                    
                    <label style="width:95px;"> CPF
                    	<input type="text" id="cpf_mae" name="cpf_mae" sonumero='1' value="<?=$d->cpf_mae?>" autocomplete="off" mascara="___.___.___-__"
                       onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==14){return  vkt_ac(this,event,'undefined','modulos/escolar/alunos_inscritos/busca_cpf.php',
            '@r0','funcao_bsc(this,\'@r0-value>mae|@r1-value>cpf_mae|@r2-value>telefone_mae|@r3-value>profissao_mae|@r5-value>email_mae\',\'cpf_mae\')')}"/>   
                    </label>
                    
                    <label style="width:95px;"> Telefone
                    	<input type="text" name="telefone_mae" mascara='(__) ____-____' id="telefone_mae" value="<?=$d->tel_mae?>">
                    </label>
                    
                    <label> Profissao
                    	<input type="text" name="profissao_mae" id="profissao_mae" value="<?=$d->profissao_mae?>">
                    </label><br><br><br>
                    <label> Local de Trabalho
                    	<input type="text" name="local_trabalho_mae" value="<?=$d->local_trabalho_mae?>">
                    </label>
                    <label style="width:92px;">Telefone
                    	<input type="text" name="tel_trabalho_mae" sonumero='1' mascara='(__)____-____' id="tel_trabalho_mae" value="<?=$d->tel_trabalho_mae?>">
                    </label>
                    <label style="width:203px;">Email
                    	<input type="text" name="email_mae" id="email_mae" retorno='focus|Coloque o email corretamente' value="<?=$d->email_mae?>">
                    </label>
                    <!-- -->
                    <label style="width:250px;">Pai
                    	<input type="text" name="pai" id="pai" value="<?=$d->pai?>">                    	
                    </label>
                    <label style="width:95px;"> CPF
                    	<input type="text" name="cpf_pai" sonumero='1' mascara='___.___.___-__' id="cpf_pai" value="<?=$d->cpf_pai?>" 
                        onkeyup="cp=this.value.replace(/\_/g,'' );
            			document.title=cp;if(cp.length==14){return  vkt_ac(this,event,'undefined','modulos/escolar/alunos_inscritos/busca_cpf.php',
            			'@r0','funcao_bsc(this,\'@r0-value>pai|@r1-value>cpf_pai|@r2-value>telefone_pai|@r3-value>profissao_pai|@r5-value>email_pai\',\'cpf_pai\')')}"/>
                    </label>
                    
                    <label style="width:95px;"> Telefone
                    	<input type="text" name="telefone_pai" mascara='(__)____-____' id="telefone_pai" value="<?=$d->tel_pai?>">
                    </label>
                    
                    <label> Profissao
                    	<input type="text" name="profissao_pai" id="profissao_pai" value="<?=$d->profissao_pai?>"> 
                    </label>
                    <label> Local de Trabalho
                    	<input type="text" name="local_trabalho_pai" value="<?=$d->local_trabalho_pai?>">
                    </label>
                    <label style="width:92px;">Telefone
                    	<input type="text" name="tel_trabalho_pai" sonumero='1' id="tel_trabalho_pai" mascara='(__)____-____' value="<?=$d->tel_trabalho_pai?>">
                    </label>
                    <label style="width:203px;">Email
                    	<input type="text" name="email_pai" id="email_pai" retorno='focus|Coloque o email corretamente' value="<?=$d->email_pai?>">
                    </label>
      
      </fieldset>
      <!-- -->
      <fieldset id="campos_4" style="display:none"> 
      <legend>
        <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
        
        <a onclick="aba_form(this,1)">Dados dos alunos</a>
        <a onclick="aba_form(this,2)">Filiaçao</a>
        <a onclick="aba_form(this,3)"><strong>Transporte</strong></a>
        <a onclick="aba_form(this,4)">Emergencia</a>
        <a onclick="aba_form(this,5)">Matricula</a>
        <a onclick="aba_form(this,6)">Observaçao</a>
      </legend>
        	<div>Pessoa(as) que virá(ao) trazer e buscar a criança?  (Nome e documento)</div>
            <label style="width:290px;">1.
            	<input type="text" name="pessoa_trazer_buscar_1" id="pessoa_trazer_buscar_1" value="<?=$d->pessoa_trazer_buscar_1?>">
            </label>
            <label style="width:290px;">2.
            	<input type="text" name="pessoa_trazer_buscar_2" id="pessoa_trazer_buscar_2" value="<?=$d->pessoa_trazer_buscar_2?>">	
            </label><br/><br/><br/>
            <label style="width:290px;">3.
            	<input type="text" name="pessoa_trazer_buscar_3" id="pessoa_trazer_buscar_3" value="<?=$d->pessoa_trazer_buscar_3?>">	
            </label>
           <label style="width:290px;">4.
            	<input type="text" name="pessoa_trazer_buscar_4" id="pessoa_trazer_buscar_4" value="<?=$d->pessoa_trazer_buscar_4?>">	
            </label>
            <div style="clear:both;"></div>
            <div style="font-size:10px;">Obs: Pessoas nao autorizadas nesta lista nao irao retirar a criança da escola</div>
      
       </fieldset>
      <!-- -->
      <fieldset id="campos_5" style="display:none"> 
      <legend>
    
        <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
        
        <a onclick="aba_form(this,1)">Dados dos alunos</a>
        <a onclick="aba_form(this,2)">Filiaçao</a>
        <a onclick="aba_form(this,3)">Transporte</a>
        <a onclick="aba_form(this,4)"><strong>Emergencia</strong></a>
        <a onclick="aba_form(this,5)">Matricula</a>
        <a onclick="aba_form(this,6)">Observaçao</a>
    
      </legend>
        	<div>No caso de emergencia ou ocorrencia , chamar por:</div>
            <label style="width:290px;">1.
            	<input type="text" name="pessoa_emergencia_1" id="pessoa_emergencia_1" value="<?=$d->pessoa_caso_emergencia_1?>">
            </label>
            <label style="width:290px;">Fones
            	<input type="text" name="fone_emergencia_1" id="fone_emergencia_1" value="<?=$d->telefone_caso_emergencia_1?>">	
            </label><br/><br/><br/>
            <label style="width:290px;">2.
            	<input type="text" name="pessoa_emergencia_2" id="pessoa_emergencia_2" value="<?=$d->pessoa_caso_emergencia_2?>">	
            </label>
           <label style="width:290px;">Fones
            	<input type="text" name="fone_emergencia_2" id="fone_emergencia_2" value="<?=$d->telefone_caso_emergencia_2?>">	
            </label>      
       </fieldset>
       <!-- -->
      <!-- -->
      <fieldset id="campos_6" style="display:none"> 
      <legend>
      
        <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
        
        <a onclick="aba_form(this,1)">Dados dos alunos</a>
        <a onclick="aba_form(this,2)">Filiaçao</a>
        <a onclick="aba_form(this,3)">Transporte</a>
        <a onclick="aba_form(this,4)">Emergencia</a>
        <a onclick="aba_form(this,5)"><strong>Matricula</strong></a>
        <a onclick="aba_form(this,6)">Observaçao</a>
      
      </legend>
        		<?php
				while($aluno_matricula = mysql_fetch_object($s_matricula)){
                	
				$responsavel = mysql_fetch_object(mysql_query($g="SELECT * FROM cliente_fornecedor WHERE id = '$aluno_matricula->responsavel_id'"));
				$escola = mysql_fetch_object(mysql_query("SELECT * FROM escolar_escolas WHERE id = $aluno_matricula->escola_id"));
				$curso = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_cursos WHERE id = '$aluno_matricula->curso_id'"));	
				$modulo = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_modulos WHERE id = '$aluno_matricula->modulo_id' "));
				$sala = mysql_fetch_object(mysql_query("SELECT * FROM escolar_salas WHERE id = '$aluno_matricula->sala_id'"));
				?>
            <label id="responsavel" onclick="location.href='?limitador=&tela_id=222&pagina=1&busca=<?=$responsavel->cnpj_cpf?>'">Respons&aacute;vel<br>
            	<strong><?=$responsavel->nome_fantasia?></strong>
            </label>
            <label>Escola<br>
            	<strong><?=$escola->nome?></strong><br>
            </label>
            <label>
            	Sala<br/>
                <strong><?=$sala->nome?></strong>
            </label>
            <label>
            	Data Vencimento<br>
                <strong><?=dataUsaToBr($aluno_matricula->data_vencimento);?></strong>                
            </label>
            <label>
            	Data Pagamento<br>
                <strong><?=dataUsaToBr($aluno_matricula->data_pagamento);?></strong>                
            </label>
            <div style="clear:both;"></div>
            <label>
            	Cursos<br>
                <strong><?=$curso->nome?></strong><br/>
            </label>
            <label>
            	Modulo<br/>
                <strong><?=$modulo->nome?></strong>
            </label>
            <label>
            	Situaçao do Curso<br/>
                <strong><?=$aluno_matricula->situacao_curso?></strong>
            </label>
             <label>
            	Pagamento<br/>
                		<? 
							if($aluno_matricula->pago == 'S') 
									$pagamento = 'Efetuado';
							else 
									$pagamento = 'Nao Efetuado';
						?>
                <strong><?=$pagamento?></strong>
            </label>
            
            	<?php
				 }
				?>
            <!--<label>Cursos
            	<input type="text" name="escola" id="escola" disabled="disabled">
            </label>
            <label>Modulos
            	<input type="text" name="modulo" id="modulo">
            </label>
            <label>Horarios
            	<input type="text" name="horarios" id="horarios">
            </label>
            <label>Salas
            	<input type="text" name="horarios" id="horarios">
            </label>
            <label>Data Vencimento
            	<input type="text" name="horarios" id="horarios">
            </label>
            <label>Data Pagamento
            	<input type="text" name="horarios" id="horarios">
            </label>
             <label>Situa&ccedil;ao Curso
            	<input type="text" name="horarios" id="horarios">
            </label>
            <label>
            	Situa&ccedil;&atilde;o Pagemento
                	<input type="text" name="pago">
            </label>
            <label>
            	Situa&ccedil;&atilde;o Matricula
                	<input type="text" name="pago">
            </label>
            <label>
            	Situa&ccedil;&atilde;o Matricula
                	<input type="text" name="pago">
            </label>-->
       </fieldset>
       <!-- -->
      <fieldset id="campos_7" style="display:none"> 
      <legend>
    
        <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
        <a onclick="aba_form(this,1)">Dados dos alunos</a>
        <a onclick="aba_form(this,2)">Filiaçao</a>
        <a onclick="aba_form(this,3)">Transporte</a>
        <a onclick="aba_form(this,4)">Emergencia</a>
        <a onclick="aba_form(this,5)">Matricula</a>
        <a onclick="aba_form(this,6)"><strong>Observaçao</strong></a>
    
      </legend>
      	<label>
      	Observaçao
        <textarea name="observacao" cols="40" rows="20"><?php echo $d->observacao?></textarea>
      	</label>
      </fieldset>
      
   
      
        
        <div style="width:100%; text-align:center" >
        <input type="button" value="Imprimir" onclick="window.open('modulos/escolar/alunos_inscritos/impressao_aluno.php?id=<?=$_GET['aluno_id']?>','_BLANK')">
        <?
        if($_GET['aluno_id'] > 0){
        ?>
        <input name="action" type="submit" value="Excluir" style="float:left" />
        <?
        }
        ?>
        <input type="button"   value="Voltar" style="float:left; display:none "  class="voltar"  />
        <!--<input name="action" type="submit"  value="Avançar" style="float:right"  />-->
        <input type="button" name="avancar"  pagina='1' value="Avançar" style="float:right; "  class="avancar"  />
        <input type="submit" name="action" value="Confirmar" style="float:right; display:none;" id="confirmar_matricula">
        <div style="clear:both"></div>
        </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($d->senha)<1){echo "<script>top.newPass('senha')</script>";} ?>