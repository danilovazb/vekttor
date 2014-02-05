<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

$disabled = "";
$disabled_imprimir = 'disabled="disabled";';
if(!empty($matricula->id)){
	$disabled = 'disabled="disabled"';
} if(!empty($matricula->id)){
	$disabled_imprimir = "";
}



?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<style>
label#responsavel:hover{ cursor:crosshair;}
#turma_id option blockquote { padding:3px;}
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
	<form onsubmit="return validaForm(this)" autocomplete="off"  class="form_float" id='frmcontrato'  method="post" enctype="multipart/form-data">
		<fieldset style="height:450px;">
        	<legend>
            <a  id="confirma_turma"><strong>Confirmação Matrícula - Responsável</strong></a>
            <div style="display:none" id="menu_cadastro_aluno">
            <a id="aba_aluno">Dados dos alunos</a>
    		<a>Filiaçao</a>
    		<a>Transporte</a>
    		<a>Emergencia</a>
            <a>Matricula</a>
            <a>Observaçao</a>
            <a>Contrato</a>
            </div>
          </legend>
            <input type="hidden" name="responsavel_id" id="responsavel_id"  value="<?=$responsavel->id?>">
            <input type="hidden" name="matricula_id" id="matricula_id" value="<?=$matricula_aluno->id?>">
            <input type="hidden" name="tipo" id="tipo" value="Cliente">
            
			<?
            if($responsavel->id>0){
                $tipo=utf8_encode($responsavel->tipo_cadastro);
            }else{	
                $tipo='Físico';
            }
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
				CPF *
				<input type="text" id='f_cnpj_cpf' <?=$desabilita['Jurídico']?> onkeyup="checa_cpf(this)" name="f_cnpj_cpf" value="<?=$responsavel->cnpj_cpf?>" mascara="___.___.___-__" sonumero='1' retorno="focus|Digite o CPF corretamente" valida_cpf='1'/>
			</label>
            
         <label id="cnpj" style="width:120px; margin-right:22px;<?=$desaparece['Físico']?>">
			CNPJ <input type="text" id='f_cnpj_cpf' <?=$desabilita['Físico']?> name="f_cnpj_cpf" value="<?=$responsavel->cnpj_cpf?>" mascara="__.___.___/____-__" sonumero='1' retorno="focus|Digite o CNPJ corretamente"/>
		 </label>
            
            
			<label style="width:240px; margin-right:23px;">
				Nome do Respons&aacute;vel *<br />
				<input type="text" id="nome_responsavel" name="nome_responsavel" value="<?=utf8_encode($responsavel->razao_social)?>" retorno="focus|Digite o nome do Responsável" valida_minlength='3'/>
			</label>
            
            <div style="clear:both;"></div>
            <label style="width:75px;">
				Nascimento *
				<input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" value="<?=dataUsaToBr($responsavel->nascimento)?>" retorno="focus|Digite a data de nascimento - Responsável" valida_minlength='1' valida_data='01/01/0001,99/99/9999'/>
			</label>
            <label style="width:120px;">
                Grau de Instrucao
                <select name="f_grau_instrucao" id="f_grau_instrucao" >
                    <option <? if($responsavel->grau_instrucao=='superior incompleto')echo "selected='selected'"; ?> value="superior incompleto">Superior Incompleto</option>
                    <option <? if($responsavel->grau_instrucao=='superior completo')echo "selected='selected'"; ?> value="superior completo">Superior Completo</option>
                    <option <? if($responsavel->grau_instrucao=='outros')echo "selected='selected'"; ?> value="outros">Outros</option>
                </select>
  			</label>
   			<!-- Estado Civil -->
            <label style="width:130px">
				Estado Civil
				<select name="f_estado_civil" id="f_estado_civil" >
				<?
					if($responsavel->estado_civil=="Casado"){
						$casado='selected="selected"';
					}if($responsavel->estado_civil=="Solteiro"){
						$solteiro='selected="selected"';
					}if($responsavel->estado_civil=="Separado"){
						$separado = 'selected="selected"';
					}if($responsavel->estado_civil=="Divorciado"){
						$divorciado = 'selected="selected"';
					}if($responsavel->estado_civil=="Viuvo"){
						$viuvo = 'selected="selected"';
					} 
				?>
					<option value="Solteiro" <?=$solteiro?>>Solteiro(a)</option>
					<option value="Casado" <?=$casado?>>Casado(a)</option>
                    <option value="Separado" <?=$separado?>>Separado(a)</option>
                    <option value="Divorciado" <?=$divorciado?>>Divorciado(a)</option>
                    <option value="Viuvo" <?=$viuvo?>>Viúvo(a)</option>
  			 </select>
			</label>
			
            <div style="clear:both"></div>			
			<label style="width:120px;">
				Atividade 
				<input type="text" id='ramo_atividade_responsavel' name="ramo_atividade_responsavel" value="<?=utf8_encode($responsavel->ramo_atividade)?>" />
			</label>
            
			<label style="width:100px; margin-right:23px;">
				RG *
				<input type="text" id='f_rg' name="f_rg" maxlength="13" value="<?=$responsavel->rg?>"  sonumero='1' retorno="focus|Digite o RG corretamente - Responsável" valida_minlength='3' />
			</label>
            <label style="width:100px; margin-right:22px;">
				Orgão Emissor *
				<input type="text" id='f_local_emissao' name="f_local_emissao" value="<?=$responsavel->local_emissao?>" valida_minlength='1' retorno='focus|Informe Orgão Emissor' />
			</label><label style="width:90px; margin-right:22px;">
				Data Emissao 
				<input type="text" mascara='__/__/____' onfocus="this.select" clendario='1' id='f_data_emissao' name="f_data_emissao" value="<?=dataUsaToBr($responsavel->data_emissao)?>"  />
			</label> <!-- *  valida_data='1' retorno='focus|Data emissao inválida - responsável'  -->
            
            <div style="clear:both;"></div>
           
		           
          <label style="width:100px;">
				Naturalidade
				<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=utf8_encode($responsavel->naturalidade)?>" />
			</label>
            <label style="width:126px;">
				Nacionalidade
				<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$responsavel->nacionalidade?>" />
			</label>
            <!-- EMAIL Responsável -->
            <label style="width:194px; margin-right:23px;">
				Email *
				<input type="text" id='f_email' name="f_email" value="<?=$responsavel->email?>"  retorno="focus|Digite o email corretamente" valida_minlength='3' />
			</label>
            <div style="clear:both"></div>
            
            
			<label style="width:100px; margin-right:23px;">
				Tel.Residencial *
				<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$responsavel->telefone1?>" mascara="(__)____-____" sonumero='1' retorno="focus|Digite o telefone corretamente" valida_minlength='3'/>
			</label>
			<label style="width:100px; margin-right:22px;">
				Tel.Celular
				<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$responsavel->telefone2?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:100px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="f_fax" value="<?=$responsavel->fax?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<div style="clear:both"></div>
            <label style="width:136px; margin-right:22px;">
				Cep *
				<input type="text" id='f_cep' name="f_cep" value="<?=$responsavel->cep?>" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );document.title=cp;if(cp.length==9){return vkt_ac(this,event,'undefined','modulos/escolar/responsavel/busca_endereco.php','@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}" autocomplete="off" retorno="focus|Digite o CEP corretamente" valida_minlength='3'/>
			</label>
			 <label style="width:190px; margin-right:23px;">
				Endereço *
				<input type="text" id='f_endereco' name="f_endereco" value="<?=utf8_encode($responsavel->endereco);?>" retorno="focus|Digite o Endereco corretamente" valida_minlength='3'/>
			</label>
            <div style="clear:both"></div>
            <label style="width:136px; margin-right:23px;">
				Bairro *
				<input type="text" id='f_bairro' name="f_bairro" value="<?=utf8_encode($responsavel->bairro)?>" retorno="focus|Digite o Bairro corretamente" valida_minlength='3'/>
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade *
				<input type="text" id='f_cidade' name="f_cidade" value="<?=$responsavel->cidade?>" retorno="focus|Digite a cidade corretamente" valida_minlength='3'/>
			</label>
			<label style="width:40px; margin-right:23px;">
				UF *
				<input type="text" id='f_estado' name="f_estado" value="<?=$responsavel->estado?>" retorno="focus|Digite o estado corretamente" valida_minlength='2'/>
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
        
      <!-- ABA ALUNOS -->
      <fieldset id="campos_2" style="display:none; height:450px;">
        <legend>
          <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
          <a id="aba_aluno"><strong>Dados dos alunos</strong></a>
          <a>Filiaçao</a>
          <a>Transporte</a>
          <a>Emergencia</a>
          <a>Matricula</a>
          <a>Observaçao</a>
          <a>Contrato</a>
        </legend>
        
        <input type="hidden" id="aluno_id" name="aluno_id" value="<?=$aluno->id?>" />
        <input type="hidden" id="aluno_id_busca" name="aluno_id_busca" value="" />
          
          <div style="float:left; width:650px;">
          <?
          if(empty($aluno->id)){
          ?>
          <label><input type="checkbox" id="responsavel_e_aluno" style="width:inherit" value="0" name="mesmo"><strong>Este Aluno tem os mesmos dados do responsavel</strong></label>
          
          <label><input type="checkbox" name="mesmo_endereco" id="mesmo_endereco" value="0" style="width:inherit" /><strong>Este Aluno reside no mesmo local que o responsavel</strong></label>
          <?
          }
          ?>
          <!--<div style="clear:both;"></div>
          <label>Tipo Matrícula
            <select name="tipo_matricula" id="tipo_matricula">
                <option value="matricula">Matrícula</option>
                <option value="rematricula">Rematricula</option>
            </select>
          </label>-->
          <div style="clear:both;"></div>
          <label style="width:260px;">
              Nome do aluno *
              <input type="text" valida_minlength='10' retorno='focus|Informe o nome do Aluno' name="nome_aluno" id="nome_aluno" busca='modulos/escolar2/busca/busca_aluno.php,@r1,@r0-value>aluno_id_busca|@r1-value>nome_aluno,0' value="<?=utf8_encode($aluno->nome);?>" autocomplete="off" />
          </label>
          <label style="width:80px;">
              Nascimento *
              <input type="text" id="data_nascimento_aluno" name="data_nascimento_aluno" mascara="__/__/____" sonumero="1" value="<?=dataUsaToBr($aluno->data_nascimento); ?>" valida_data='1' retorno='focus|Data de Nascimento Inválida' />
          </label>
          
          <label style="width:115px;">Cor <?=$aluno->cor?>
          <select name="cor" id="cor">
              <option value="branco" <? if($aluno->cor == 'branco') echo 'selected="selected"';?>  >Branco</option>
              <option value="pardo-moreno" <? if($aluno->cor == 'pardo-moreno') echo $checked = 'selected="selected"';?>>Pardo/Moreno</option>
              <option value="negro" <? if($aluno->cor == 'negro') echo $checked = 'selected="selected"';?>>Negro</option>
              <option value="amarelo" <? if($aluno->cor == 'amarelo') echo $checked = 'selected="selected"'; ?>>Amarelo</option>
              <option value="indigena" <? if($aluno->cor == 'indigena') echo $checked = 'selected="selected"';?>>Indígena</option>
              <option value="naodeclarado" <? if($aluno->cor == 'naodeclarado') echo $checked = 'selected="selected"';?>>N&atilde;o Declarado</option>
          </select>
          </label>
          <!-- -->
          <label style="width:90px;">Sexo
            <select name="sexo_aluno" id="sexo_aluno">
                <option value="masculino" <? if($aluno->sexo == 'masculino') echo 'selected="selected"';?> >Masculino</option>
                <option value="feminino"  <? if($aluno->sexo == 'feminino') echo 'selected="selected"';?>>Feminino</option>
            </select>
          </label>
          <div style="display:none">
              Cor<br/>
              <input type="radio" name="cor" value="branco" <? if($aluno->cor == 'branco') echo 'checked="checked"';?>>Branco
              <input type="radio" name="cor" value="pardo-moreno" <? if($aluno->cor == 'pardo-moreno') echo $checked = 'checked="checked"';?>>Pardo/Moreno
              <input type="radio" name="cor" value="negro" <? if($aluno->cor == 'negro') echo $checked = 'checked="checked"';?>>Negro
              <input type="radio" name="cor" value="amarelo" <? if($aluno->cor == 'amarelo') echo $checked = 'checked="checked"'; ?>>Amarelo
              <input type="radio" name="cor" value="indigena" <? if($aluno->cor == 'indigena') echo $checked = 'checked="checked"';?>>Indígena
              <input type="radio" name="cor" value="naodeclarado" <? if($aluno->cor == 'naodeclarado') echo $checked = 'checked="checked"';?>>N&atilde;o Declarado
           </div>
             
           <div style="clear:both"></div>
          
           <label style="width:105px;">
              CPF *
              <input type="text" id="cpf_aluno" name="cpf_aluno"   value="<?=$aluno->cpf; ?>" mascara='___.___.___-__' <?
              $idade = calcula_idade( $aluno->data_nascimento );
              if($idade<=18&&$aluno->id>0){
                  //echo " valida_cpf='1' retorno='focus|Digite o CPF corretamente do aluno'";
              }
              ?>/>
          </label><!-- valida_cpf='1' retorno='focus|Digite o CPF do aluno corretamente' -->
          
          <label style="width:95px;">
              RG *
              <input type="text" id="rg_aluno" name="rg_aluno" maxlength="13" sonumero='1' value="<?=$aluno->rg;?>"   />
          </label> <!-- valida_minlength='5' retorno='focus|Informe RG do Aluno' -->
          
          <label style="width:95px;">
          Data Expedição 
          <input type="text" id="rg_dt_expedicao"  name="rg_dt_expedicao" mascara='__/__/____' value="<?=dataUsaToBr($aluno->rg_dt_expedicao);?>" />
          </label> <!-- * valida_data='1' retorno='focus|Data Expedição Inválida' -->
          <label style="width:165px;">
              Profissão
              <input type="text" id="profissao" name="profissao"  value="<?=$aluno->profissao;?>" />
          </label>
          <div style="clear:both"></div>
          <label style="width:255px;">
          E-Mail 
          <input type="text" id="email" name="email" value="<?=$aluno->email;?>" /> <!-- valida_minlength='8' retorno='focus|Coloque o email corretamente' * -->
          </label>
          <label style="width:105px;">
              Tel. Residencial *
              <input type="text" id="telefone1" name="telefone1" mascara='(__)____-____' value="<?=$aluno->telefone1;?>" valida_minlength='8' retorno='focus|Informe Telefone Aluno' />
          </label>
          <label style="width:105px;">
              Tel. Celular
              <input type="text" id="telefone2" name="telefone2" mascara='(__)____-____' value="<?=$aluno->telefone2;?>" />
          </label>
          <div style="clear:both"></div>
          <label style="width:88px;">
          CEP *
          <input type="text" id="cep" name="cep" mascara='_____-___' sonumero='1' value="<?=$aluno->cep; ?>" valida_minlength='9' retorno='focus|Informe CEP Aluno' />
          </label>
          <label style="width:238px;">
          Endereço *
          <input type="text" id="endereco" name="endereco" value="<?=$aluno->endereco; ?>" valida_minlength='8' retorno='focus|Informe Endereço do Aluno' />
          </label>
          
          <label style="width:137px;">
          Bairro * 
          <input type="text" id="bairro" name="bairro" value="<?=$aluno->bairro; ?>" valida_minlength='4' retorno='focus|Informe Bairro' />
          </label>  
          <div style="clear:both"></div>
          <label style="width:130px;">
              Complemento
              <input type="text" id="complemento" name="complemento" value="<?=utf8_encode($aluno->complemento);?>" />
          </label>
          <label style="width:100px;">
              Cidade
              <input type="text" id="cidade" name="cidade" value="<?=$aluno->cidade; ?>" />
          </label>
          <label style="width:25px;">
              UF
              <input type="text" id="uf" name="uf" value="<?=$aluno->uf;?>" />
          </label>
          <label style="width:190px;">
              Portador Necessidades Especiais
              <input type="text" id="portador_necessidade" name="portador_necessidade" value="<?=utf8_encode($aluno->portador_necessidade);?>" />
          </label>
          
         <div style="clear:both"></div>
          <label style="width:160px;">
              Escolaridade
              <input type="text" id="escolaridade_aluno" name="escolaridade_aluno" value="<?=$aluno->escolaridade; ?>" />
          </label>
          
          <label>Código Interno<br/>
              <input type="text" name="codigo_interno" id="codigo_interno" style="width:90px;" value="<?=$aluno->codigo_interno;?>">
          </label>
          <label style="width:60px;">Cod.Aluno: <?=$aluno->id?>
          </label>
          <label style="width:60px;">Senha
              <input type="text" name="senha" id="senha" value="<?=$aluno->senha?>" />
          </label>
                <label  style="width:100px">
          Tipo de Aluno <br />
          <?
          
          $bolsista = mf(mq("
          SELECT * FROM escolar_alunos_bolsistas WHERE aluno_id = '$aluno->id'
          "));
          if($bolsista->aluno_id>0){
              echo "<strong>Bolsista</strong>";	
          }else{
              echo "<strong>Integral</strong>";	
          }
          ?>
          </label>
          <label><? if($cliente_id==13){ ?> Universidades/Áreas <?   }else{ ?>  Restriçao Alimentar / Alergia <?  } ?>
              <input type="text" name="restricao_alimentar" id="restricao_alimentar" size="25" value="<?=utf8_encode($aluno->restricao_alimentar)?>">
          </label>
          
          <label style="width:90px;">Tipo Matrícula *
            <select name="tipo_matricula" id="tipo_matricula">
                <option value="matricula" <? if($matricula_aluno->matricula_rematricula == "matricula"){ echo 'selected="selected"';} ?>>Matrícula</option>
                <option value="rematricula" <? if($matricula_aluno->matricula_rematricula == "rematricula"){ echo 'selected="selected"';} ?>>Rematricula</option>
            </select>
          </label>     

        <div style="clear:both;"></div>
        <label><br/>
                <input type="file" name="file[]" >
        </label>
          
        <div style="clear:both;"></div>
        <!-- FAZER A MATRICULA -->
        <?php
        if(empty($matricula->id)){
        ?> 
        <!-- SELECT PARA PERIODO LETIVO -->
        <!--<label>Periodo Letivo
            <select name="periodo_letivo" id="periodo_letivo">
            <option value="0">Selecione</option>
            <?
                $sql_periodo_letivo = mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE vkt_id = '$vkt_id' ");
                while($periodo_letivo=mysql_fetch_object($sql_periodo_letivo)){
            ?>
            <option value="<?=$periodo_letivo->id?>"><?=utf8_encode($periodo_letivo->nome)?></option>
            <?
                }
            ?>
            </select>
        </label>-->
        
        <!--<label style="width:100px;">UNIDADE
            <select name="unidade" id="unidade">
            
            </select>
        </label>-->
        
        <!-- SELECT PARA SERIE -->
        <!--<label style="width:100px;">Série
            <select name="serie_id" id="serie_id">
           
           
            </select>
        </label>-->
        
         <!-- SELECT PARA TURMA -->
         <!--<label style="width:100px;">Turma
        <select name="turma_id" id="turma_id">
            
        </select>
        </label>-->
        <!--<input type="hidden" name="fazer_matricula" id="fazer_matricula" retorno="focus|Não existe turma" valida_minlength='1'>-->
        <?
      //$config_conta = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_config WHERE vkt_id = '$vkt_id' AND cobrar = '1' "));
      //if(!empty($config_conta->id)){
        ?>
        <!--<label style="width:92px;">Valor Matr&iacute;cula
            <input type="text" name="valor_matricula" id="valor_matricula">
        </label>
      
        
        <label style="width:95px;">Data Vencimento<br>
            <input type="text" name="data_vencimento" style="width:75px;" calendario='1' value="<?=date('d/m/Y');?>">
        </label>-->
       <?php
        }
       ?>
        <div style="clear:both;"></div>
          
          </div>
          <div style="width:120px;float:left; height:160px;border:1px solid #999; background:#FFF; overflow:hidden">
          
              <div style="clear:both; padding:2px;" id='img_curso' >
              <?
              if(strlen($aluno->extensao)>=3){
              ?>
              <img src='modulos/escolar2/aluno/img/<?=$aluno->id?>.<?=$aluno->extensao?>' height="100" /><br />
              <?
              }
              ?>
              </div>
              <span id="busca_btn_remover"></span>
          </div>
          
          
      <?
      if(strlen($aluno->extensao)>=3){
      ?>
      <a href="#" onclick="this.style.display='none'" class='remove_imagem_aluno' aluno_id='<?=$aluno->id?>'>Remover</a>
         <?
      }
      ?>
    <!--<div style="clear:both;"></div>         
    <div style="border-bottom:1px solid #CCC; width:50%; padding:2px; margin-bottom:8px;"> <sub> Turma  &nbsp; </div>-->
    
    </fieldset>
      
      <!-- ABA FILIAÇÃO -->
      <fieldset id="campos_3" style="display:none; height:450px;"> 
         <legend>
          <a id="aba_aluno">Dados dos alunos</a>
          <a><strong>Filiaçao</strong></a>
          <a>Transporte</a>
          <a>Emergencia</a>
          <a>Matricula</a>
          <a>Observaçao</a>
          <a>Contrato</a> 
        </legend>
      				
            <label style="width:250px;">Mae
                <input type="text" name="mae" id="mae" value="<?=utf8_encode($aluno->mae)?>">                    	
            </label>
            <label style="width:95px;"> CPF
                <input type="text" id="cpf_mae" name="cpf_mae" sonumero='1' value="<?=$aluno->cpf_mae?>" autocomplete="off" mascara="___.___.___-__"
               onkeyup="cp=this.value.replace(/\_/g,'' );
    document.title=cp;if(cp.length==14){return  vkt_ac(this,event,'undefined','modulos/escolar/alunos_inscritos/busca_cpf.php',
    '@r0','funcao_bsc(this,\'@r0-value>mae|@r1-value>cpf_mae|@r2-value>telefone_mae|@r3-value>profissao_mae|@r5-value>email_mae\',\'cpf_mae\')')}"/>   
            </label>   
            <label style="width:95px;"> Telefone
                <input type="text" name="telefone_mae" mascara='(__)____-____' id="telefone_mae" value="<?=$aluno->tel_mae?>">
            </label>
            <label> Profissao
                <input type="text" name="profissao_mae" id="profissao_mae" value="<?=utf8_encode($aluno->profissao_mae);?>">
            </label><br><br><br>
            <label> Local de Trabalho
                <input type="text" name="local_trabalho_mae" id="local_trabalho_mae" value="<?=utf8_encode($aluno->local_trabalho_mae);?>">
            </label>
            <label style="width:92px;">Telefone
                <input type="text" name="tel_trabalho_mae" sonumero='1' mascara='(__)____-____' id="tel_trabalho_mae" value="<?=$aluno->tel_trabalho_mae?>">
            </label>
            <label style="width:203px;">Email
                <input type="text" name="email_mae" id="email_mae" retorno='focus|Coloque o email corretamente' value="<?=$aluno->email_mae?>">
            </label>
            <!-- -->
            <label style="width:250px;">Pai
                <input type="text" name="pai" id="pai" value="<?=utf8_encode($aluno->pai)?>">                    	
            </label>
            <label style="width:95px;"> CPF
                <input type="text" name="cpf_pai" sonumero='1' mascara='___.___.___-__' id="cpf_pai" value="<?=$aluno->cpf_pai?>" 
                onkeyup="cp=this.value.replace(/\_/g,'' );
                document.title=cp;if(cp.length==14){return  vkt_ac(this,event,'undefined','modulos/escolar/alunos_inscritos/busca_cpf.php',
                '@r0','funcao_bsc(this,\'@r0-value>pai|@r1-value>cpf_pai|@r2-value>telefone_pai|@r3-value>profissao_pai|@r5-value>email_pai\',\'cpf_pai\')')}"/>
            </label>      
            <label style="width:95px;"> Telefone
                <input type="text" name="telefone_pai" mascara='(__)____-____' id="telefone_pai" value="<?=$aluno->tel_pai?>">
            </label>
            
            <label> Profissao
                <input type="text" name="profissao_pai" id="profissao_pai" value="<?=utf8_encode($aluno->profissao_pai)?>"> 
            </label>
            <label> Local de Trabalho
                <input type="text" name="local_trabalho_pai" id="local_trabalho_pai" value="<?=$aluno->local_trabalho_pai?>">
            </label>
            <label style="width:92px;">Telefone
                <input type="text" name="tel_trabalho_pai" sonumero='1' id="tel_trabalho_pai" mascara='(__)____-____' value="<?=$aluno->tel_trabalho_pai?>">
            </label>
            <label style="width:203px;">Email
                <input type="text" name="email_pai" id="email_pai" retorno='focus|Coloque o email corretamente' value="<?=$aluno->email_pai?>">
            </label>
      
      </fieldset>
      
      <!-- ABA TRANSPORTE -->
      <fieldset id="campos_4" style="display:none; height:450px;"> 
      <legend>
        <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
        
        <a id="aba_aluno">Dados dos alunos</a>
        <a>Filiaçao</a>
        <a><strong>Transporte</strong></a>
        <a>Emergencia</a>
        <a>Matricula</a>
        <a>Observaçao</a>
        <a>Contrato</a>
      </legend>
        	<div><strong>Pessoa(as) que virá(ao) trazer e buscar a criança?  (Nome e documento)</strong></div> <br/>
            
            <!-- -->
            <label style="width:290px;">1. Nome 
            	<input type="text" name="pessoa_trazer_buscar_1" id="pessoa_trazer_buscar_1" value="<?=utf8_encode($aluno->pessoa_trazer_buscar_1)?>">
            </label>
            <label style="width:200px;"> Documento
            	<input type="text" name="pessoa_trazer_buscar_2" id="pessoa_trazer_buscar_2" value="<?=utf8_encode($aluno->pessoa_trazer_buscar_2)?>">	
            </label><br/><br/><br/>
            
            <!-- -->
            <label style="width:290px;">2. Nome 
            	<input type="text" name="pessoa_trazer_buscar_3" id="pessoa_trazer_buscar_3" value="<?=utf8_encode($aluno->pessoa_trazer_buscar_3)?>">	
            </label>
            <label style="width:200px;"> Documento
            	<input type="text" name="pessoa_trazer_buscar_4" id="pessoa_trazer_buscar_4" value="<?=utf8_encode($aluno->pessoa_trazer_buscar_4)?>">	
            </label>
            
            <!-- -->
            <label style="width:290px;">3. Nome 
            	<input type="text" name="pessoa_trazer_buscar_5" id="pessoa_trazer_buscar_5" value="<?=utf8_encode($aluno->pessoa_trazer_buscar_5)?>">	
            </label>
            <label style="width:200px;"> Documento
            	<input type="text" name="doc_trazer_buscar_5" id="doc_trazer_buscar_5" value="<?=utf8_encode($aluno->doc_trazer_buscar_5)?>">	
            </label>
            
             <!-- -->
            <label style="width:290px;">4. Nome 
            	<input type="text" name="pessoa_trazer_buscar_6" id="pessoa_trazer_buscar_6" value="<?=utf8_encode($aluno->pessoa_trazer_buscar_6)?>">	
            </label>
            <label style="width:200px;"> Documento
            	<input type="text" name="doc_trazer_buscar_6" id="doc_trazer_buscar_6" value="<?=utf8_encode($aluno->doc_trazer_buscar_6)?>">	
            </label>
            
            
            <div style="clear:both;"></div>
            <div style="font-size:10px; color:#C00;"><strong>Obs.: Pessoas não autorizadas nesta lista não irao retirar a criança da escola.</strong></div>
       </fieldset>
      
      <!-- ABA EMERGENCIA -->
       <fieldset id="campos_5" style="display:none; height:450px;"> 
        <legend>
          <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
          <a id="aba_aluno">Dados dos alunos</a>
          <a>Filiaçao</a>
          <a>Transporte</a>
          <a><strong>Emergencia</strong></a>
          <a>Matricula</a>
          <a>Observaçao</a>
          <a>Contrato</a>
        </legend>
      
        	<div>No caso de emergencia ou ocorrencia , chamar por:</div>
            <label style="width:290px;">1.
            	<input type="text" name="pessoa_emergencia_1" id="pessoa_emergencia_1" value="<?=utf8_encode($aluno->pessoa_caso_emergencia_1)?>">
            </label>
            <label style="width:90px;">Fones
            	<input type="text" name="fone_emergencia_1" id="fone_emergencia_1" mascara='(__)____-____' value="<?=$aluno->telefone_caso_emergencia_1?>">	
            </label>
            <div style="clear:both"></div>
            <label style="width:290px;">2.
            	<input type="text" name="pessoa_emergencia_2" id="pessoa_emergencia_2" value="<?=utf8_encode($aluno->pessoa_caso_emergencia_2)?>">	
            </label>
           <label style="width:90px;">Fones
            	<input type="text" name="fone_emergencia_2" id="fone_emergencia_2" mascara='(__)____-____' value="<?=$aluno->telefone_caso_emergencia_2?>">	
            </label>      
       </fieldset>
      
      <!-- ABA MATRÍCULA  -->
      <fieldset id="campos_6" style="display:none; height:450px;"> 
        
        <legend>
          <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
          <a id="aba_aluno">Dados dos alunos</a>
          <a>Filiaçao</a>
          <a>Transporte</a>
          <a >Emergencia</a>
          <a><strong>Matricula</strong></a>
          <a>Observaçao</a>
          <a>Contrato</a>
        </legend>
       
        <!-- FAZER A MATRICULA -->
        <?php
        if(empty($matricula->id)){
		?> 
        <!-- SELECT PARA PERIODO LETIVO -->
        <span class="status_mat"> Aguarde... </span>
        <br/><br/>
        <label>Periodo Letivo
        	<select name="periodo_letivo" id="periodo_letivo">
            <option value="0">Selecione</option>
            <?
            	$sql_periodo_letivo = mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE vkt_id = '$vkt_id' ");
				while($periodo_letivo=mysql_fetch_object($sql_periodo_letivo)){
			?>
            <option value="<?=$periodo_letivo->id?>"><?=utf8_encode($periodo_letivo->nome)?></option>
            <?
				}
			?>
            </select>
        </label>
        
        <label style="width:100px;">UNIDADE
        	<select name="unidade" id="unidade"></select>
        </label>
        
        <!-- SELECT PARA SERIE -->
        <label style="width:100px;">Série
        	<select name="serie_id" id="serie_id">
     
           
            </select>
        </label>
        
         <!-- SELECT PARA TURMA -->
        <label style="width:100px;">Turma
      		<select name="turma_id" id="turma_id"></select>
        </label>
        <input type="hidden" name="fazer_matricula" id="fazer_matricula" retorno="focus|Não existe turma" valida_minlength='1'>
        
        <br/>
        <div style="clear:both"></div>
        
        <div class="matricula_outra_turma">
        <div class="outra_turma"><hr/></div>
        <div class="outra_turma">
         <p>
            <label style="width:185px;visibility:hidden;"></label>
            <label><br/>Esse aluno estudará em outro horario? </label>
            
            <label style="width:100px;">Turma <!-- SELECT PARA TURMA -->
                <select name="turma_id_2" id="turma_id_2"></select>
            </label>
         </p>
         <input type="hidden" name="fazer_matricula_1" id="fazer_matricula_1" >
         <div class="outra_turma"></div>
        </div>
        <div style="clear:both"></div>
       </div><!--/matricula_outra_turma -->
        
        <div style="clear:both"></div>
        <?
        	$config_conta = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE vkt_id = '$vkt_id' AND cobrar = '1' "));
			if(!empty($config_conta->id)){
        ?>
        <div style="left:50%;">
        <label style="width:180px;visibility:hidden;"></label>
        
        <label style="width:95px;">Data Vencimento<br>
        	<input type="text" name="data_vencimento" style="width:75px;" calendario='1' value="<?=date('d/m/Y');?>">
        </label>
        
        <label style="width:92px;">Valor Matr&iacute;cula
        	<input type="text" name="valor_matricula" id="valor_matricula" sonumero="1" decimal="2">
        </label>
        
        <label style="width:100px;">Valor Mensalidade
        	<input type="text" name="valor_mensalidade" id="valor_mensalidade" sonumero="1" decimal="2">
        </label>
      
        </div>
        <?php
			}  
			
		}
	   ?>
      <div style="clear:both;"></div>
       <?php
	   if(!empty($matricula->id)){
	   $sql_matricula = mysql_query(" SELECT * FROM escolar2_matriculas WHERE aluno_id = '$aluno->id' AND status = 'matricula' ");
	   while($matricula_lista = mysql_fetch_object($sql_matricula)){
		  $turma_lista = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_turmas WHERE id = '$matricula_lista->turma_id' "));
		  $horario = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_horarios WHERE id = '$turma_lista->horario_id' "));
		  $sala = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_salas WHERE id = '$turma_lista->sala_id' "));
		  $serie = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$turma_lista->serie_id' "));
		  $unidade = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$turma_lista->unidade_id' "));
		  $periodo = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE id = '$turma_lista->periodo_letivo_id' "));
	   ?>
       
       <label>Periodo Letivo<br/>
        	<select name="periodo_letivo" id="periodo_letivo" style="width:150px;" disabled="disabled">
            <option value="0">Selecione</option>
            <?
            	$sql_periodo_letivo = mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE vkt_id = '$vkt_id' ");
				while($periodo_letivo=mysql_fetch_object($sql_periodo_letivo)){
				  $sel = $periodo_letivo->id == $periodo->id ? 'selected="selected"' : NULL;
				  //if($periodo_letivo->id == $periodo->id) { $sel='selected="selected"';} else {$sel="";}
			?>
            <option <?=$sel?> value="<?=$periodo_letivo->id?>"><?=utf8_encode($periodo_letivo->nome)?></option>
            <? } ?>
            </select>
       </label>
       
       <label>Unidade<br/>
        	<select name="periodo_letivo" id="periodo_letivo" style="width:150px;" disabled="disabled">
            <option value="0">Selecione</option>
            <?
            	$sqlUnidade = mysql_query(" SELECT * FROM escolar2_unidades WHERE vkt_id = '$vkt_id' ");
				while($unidadeSEL=mysql_fetch_object($sqlUnidade)){
				  $sel = $unidadeSEL->id == $unidade->id ? 'selected="selected"' : NULL;
				  
			?>
            <option <?=$sel?> value="<?=$unidadeSEL->id?>"><?=utf8_encode($unidadeSEL->nome)?></option>
            <? } ?>
            </select>
       </label>
       <div style="clear:both;"></div>
      
	  <? } ?> 
       <table cellpadding="0" cellspacing="0" style="width:100%" id="table-info-matricula" >
        <thead>
            <tr>
                <td style="width:10px;"></td>
                
                <td style="width:80px;">Turma</td>
                <td style="width:80px;">Sala</td>
                <td style="width:80px;">Série</td>    
                <td style="width:60px;">Horário</td>
                <td style="width:80px;">Valor Matricula</td>
                <td style="width:80px;">Valor Mensalidade</td>
                
            </tr>
        </thead>
      <!--</table>
	  <table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">-->
        <tbody> 	
		<?php
		  $sql_matricula_tabela = mysql_query(" SELECT * FROM escolar2_matriculas WHERE aluno_id = '$aluno->id' AND status = 'matricula' ");
		
            while($matricula_lista = mysql_fetch_object($sql_matricula_tabela)){ 
			 
			 	$total++;
				if($total%2){$sel='class="al"';}else{$sel='';}
			 
			 	$aluno_matricula = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$matricula_lista->aluno_id' ")); 
				
				$turma_lista = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_turmas WHERE id = '$matricula_lista->turma_id' "));
				$horario = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_horarios WHERE id = '$turma_lista->horario_id' "));
				$sala = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_salas WHERE id = '$turma_lista->sala_id' "));
				$serie = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$turma_lista->serie_id' "));
				$unidade = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$turma_lista->unidade_id' "));
				$periodo = 	mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE id = '$turma_lista->periodo_letivo_id' "));
				
				$nome_unidade = $unidade->nome;
				 if( strlen($unidade->nome) > 15 )
					$nome_unidade = substr($unidade->nome,0,15)."...";
				
				$responsavel_lista = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$matricula_lista->responsavel_id' "));
		?>
        <tr <?=$sel?> id="<?=$matricula_lista->id;?>" style="background:#FFF;">
            	<td style="width:10px; padding-left:1px;"><div style="text-align:center;" id="click_resp" >+</div></td>
                
            	<td><?=utf8_encode($turma_lista->nome);?></td>
            	<td style="width:80px;"><?=($sala->nome);?></td>
                <td style="width:80px;"><?=utf8_encode($serie->nome);?></td>
                <td style="width:60px;"><?=utf8_encode($horario->nome);?></td>
            	
            	<td align="center"><input type="text" name="valor_matricula" style="width:80px;" decimal="2" value="<?=moedausaToBr($matricula_lista->valor_matricula)?>"></td>
            	<td align="center"><input type="text" name="valor_mensalidade" style="width:80px;" decimal="2" value="<?=moedausaToBr($matricula_lista->valor_mensalidade)?>"></td>
        </tr>
        <tr <?=$sel?> style="display:none;" id="res_<?=$matricula_lista->id;?>">
            	<td style="width:10px;"></td>
                <td colspan="7" style="border-top:1px solid #CCC;"><strong> RESPONSÁVEL: </strong> <?=utf8_encode($responsavel_lista->razao_social);?> | <strong> CNPJ/CPF: </strong> <?=$responsavel_lista->cnpj_cpf;?></td>
                
            	
        </tr>          
		<?php
			 }
        ?>
         </tbody>
       </table> 
       <?php
	   }
	   ?>   
       </fieldset>
      
      <!-- ABA OBERVAÇÃO -->
      <fieldset id="campos_7" style="display:none; height:450px;"> 
        <legend>
          <!--<a onclick="aba_form(this,0)" id="confirma_turma">Confirmação de Matricula</a>-->
          <a id="aba_aluno">Dados dos alunos</a>
          <a>Filiaçao</a>
          <a>Transporte</a>
          <a>Emergencia</a>
          <a>Matricula</a>
          <a><strong>Observaçao</strong></a>
          <a>Contrato</a>
        </legend>
        
      	<label> <!-- INICIO OBSERVAÇÃO -->
      	Observaçao
        <textarea name="observacao" id="observacao" cols="40" rows="20"><?php echo utf8_encode($aluno->observacao);?></textarea>
      	</label> <!-- FIM OBSERVAÇÃO -->
       </fieldset>
      
      <!-- ABA CONTRATO -->
      <fieldset id="campos_8" style="display:none; height:480px;">
        	<legend>
            <a id="aba_aluno">Dados dos alunos</a>
    		<a>Filiaçao</a>
    		<a>Transporte</a>
    		<a>Emergencia</a>
            <a>Matricula</a>
            <a>Observaçao</a>
            <a><strong>Contrato</strong></a>
          </legend>
          
           
           <label style="width:300px;"> <!-- INICIO CONTRATO -->
        	Modelo de Contrato:
			<select name="modelo_id" id="modelo_id" retorno="focus|Selecione o Modelo do Contrato" valida_minlength='1'>
            	<option value=''></option>
				<?php
					$modelos = mysql_query($t="SELECT * FROM odontologo_contrato_modelo WHERE vkt_id = '$vkt_id'"); 
					//alert($contrato->contrato_modelo_id);
					while($modelo = mysql_fetch_object($modelos)){
						if($modelo->id == $matricula->modelo_contrato_id){
							$selected="selected='selected'";
						}
						echo "<option value='$modelo->id' $selected>".utf8_encode($modelo->nome)."</option>";
						$selected='';
					}
				?>
            </select>
		</label >
        <div style="clear:both"></div>
        <label style="display:none">
		<textarea name="texto" cols="25" rows="29" id="tx_html">
		<?php
			//$contrato = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_contrato_modelo WHERE id='".$_GET['id']."'"));
   			echo utf8_encode($matricula_aluno->contrato);

		?>
        </textarea>
              </label >
  
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px; w"onchange="ti('fontsize',this.options[this.selectedIndex].value)"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null)" href="#" class='btf bold'></a>
<a onclick="ti('italic',null)" href="#" class='btf italic'></a>
<a onclick="ti('underline',null)" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null)" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null)" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null)" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null)" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null)" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null)" href="#" class='btf insertorderedlist'></a>
<div style="clear:both"></div>

       <iframe id='ed' name='ed' width="75%" style="height:345px; background:#FFF;  overflow:scroll;float:left" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0"class="edtx"></iframe>

 
       <div id="esquerda" style="float:right;overflow:auto">
        	
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cpf</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_nome</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_ctps</strong></a>
            
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_remuneracao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_hr_inicio</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_hr_fim</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cargo</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_duracao</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cpf</strong></a>
            <div style="clear:both"></div>
              <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@valor_mensalidade</strong></a>
            
 			<!-- ADICIONADO -->	 
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@turma</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@serie</strong></a>
             <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@periodo_letivo</strong></a>
            
        </div> <!-- FIM CONTRATO -->
          
       </fieldset>
  	  
      <input name="salva_formulario_contrato_cliente" type="hidden" value="1" /> 
      
      
      
      <div style="width:100%; text-align:center" >   
      <?
      if($_GET['aluno_id'] > 0){
      ?>
      <input name="action" type="submit" value="Excluir" style="float:left" />
      <?
      }
      ?>	
      <!--<input type="button"   value="Responsável" style="float:left; display:none "  class="voltar" id="btn-responsavel"  />-->
      <button type="button"   value="Responsável" style="float:left; display:none "  class="voltar" id="btn-responsavel"  /> <img src="../fontes/img/arrow-1.png" style="opacity:0.5;float:left;"> &nbsp; <i style="float:left; margin-top:1px;">Responsável</i> </button>
      <!--<input type="button" name="avancar"  pagina='1' value="Aluno" style="float:right; "  class="avancar"  />-->
      <button type="button" name="avancar"  pagina='1' value="Aluno" style="float:right; "  class="avancar"  /> <i style="float:left; margin-top:1px;">Avançar</i> &nbsp; <img src="../fontes/img/arrow-2.png" style="opacity:0.5;float:right;"> </button>
      <input type="hidden" name="pagina_atual" id="pagina_atual">
       <div class="carregador"> <span> Aguarde... </span> </div>
      <!-- DIV PARA OS BOTOES -->
      <div id="btn-aba" style="float:right;"></div>
      <div id="btn-aba-left" style="float:left;"></div>     
      
      <!-- DIV PARA OPÇÕES ADICIONIAS -->
      <div style="float:left;">
        <?
        if(empty($matricula->id)){
		?>
      	<input type="checkbox" name="imprimir_boleto" id="imprimir_boleto" value="1">Imprimir Boleto
        <input type="checkbox" name="imprimir_contrato" id="imprimir_contrato" value="1">Imprimir Contrato
        <?
		}
        if(!empty($matricula->id)){
		?>
        	<button type="button" id="boleto_matricula"><strong>Imprimir Boleto</strong></button>
        	<button type="button" id="impressao_contrato" ><strong>Imprimir Contrato</strong></button>
        	<button type="button" onclick="window.open('modulos/escolar2/aluno/impressao_aluno.php?id=<?=$aluno->id?>','_BLANK')"><strong>Imprimir Ficha</strong></button>
        <?
		}
		?>
      </div>     
        
      <!--<input type="submit" name="action" value="Confirmar" style="float:right; display:none;" id="confirmar_matricula">-->
      <!--<input name="action" type="button"  id='confirmar_matricula' value="Confirmar"  style="float:right;display:none;"  />-->
      <button name="action" type="button"  id='confirmar_matricula' value="Confirmar"  style="float:right;display:none;"  /> <img src="../fontes/img/icon-ok.png" style="opacity:0.5;float:left; height:13px; margin-top:1px;"> &nbsp; <i style="float:right; margin-top:1px;">Confirmar</i> </button>
      <div style="clear:both"></div>
        
        </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($aluno->senha)<1){echo "<script>top.newPass('senha')</script>";} ?>