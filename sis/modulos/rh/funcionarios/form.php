<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_function_funcionario.php");
include("_ctrl_funcionario.php"); 
pr($_POST);
pr($_GET);
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">

<div id='aSerCarregado'>
<div style="width:1000px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this);location.href='?tela_id=420&empresa1id=<?=$cliente_fornecedor->id?>'"></a>
    
    <span>Informacoes do Funcionário</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_cliente" enctype="multipart/form-data" target="carregador" action="modulos/rh/funcionarios/form.php" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset id="dados_funcionario">
		<legend>
			  <a class="link_form"><strong>Dados</strong></a>
              <a class="link_form">PIS</a>
    		  <a class="link_form">Dependentes</a>
              <a class="link_form">Social</a>
             <a class="link_form">Documentos</a> 
             <a class="link_form">Contrato</a>
             <a class="link_form">Avaliação</a>    		
		</legend>
	<div style="max-height:450px;overflow:auto;">	            			
		<label style="width:190px;">Nome do Funcionário
		  <input type="text" name="f_nome" value="<?=$registro->nome?>" />
		</label>
        <label style="width:80px">
			Sexo
			<select name="f_sexo" retorno="focus|Digite o nome corretamente" valida_minlength='3'>
		
				<option value="masculino" <? if($registro->sexo=="masculino"){echo "selected='selected'";}?>>Masculino</option>
				<option value="feminino" <? if($registro->sexo=="feminino"){echo "selected='selected'";}?>>Feminino</option>
			</select>
		</label>
  <label style="width:80px;" title="Data de Nascimento">
           Nascimento
          <input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" value="<?=dataUsaToBr($registro->data_nascimento)?>" 
            retorno="focus|Digite a data de nascimento" valida_minlength='1' style="width:75px" />
		</label>       
           <label style="width:70px" title="Estado Civil">
			Est. Civil
			<select name="f_estado_civil" id="f_estado_civil" retorno="focus|Digite o nome corretamente" valida_minlength='3'>
			<?
				if($registro->estado_civil=="casado"){
					$casado='selected="selected"';
				}
				if($registro->estado_civil=="solteiro"){
					$solteiro='selected="selected"';
				}
				
			?>
				<option value="Solteiro" <?=$solteiro?>>Solteiro</option>
				<option value="Casado" <?=$casado?>>Casado</option>
                
			</select>
		</label>
        <label style="width:90px;">
			Raça/Cor
			<select id='f_cor' name="f_cor"/>
            	<option value="9" <? if($registro->cor=='9'){ echo "selected='selected'";}?>>Não Informado</option>
                <option value="1" <? if($registro->cor=='1'){ echo "selected='selected'";}?>>Indígena</option>
                <option value="2" <? if($registro->cor=='2'){ echo "selected='selected'";}?>>Branca</option>
                <option value="4" <? if($registro->cor=='4'){ echo "selected='selected'";}?>>Negra</option>
                <option value="6" <? if($registro->cor=='6'){ echo "selected='selected'";}?>>Amarela</option>
                <option value="8" <? if($registro->cor=='8'){ echo "selected='selected'";}?>>Parda</option>
            </select>
		</label>
        <label style="width:90px" title="Sabe Ler e escrever?">
			Ler e Escrever
			<select name="f_ler_escrever" retorno="focus|Digite o nome corretamente" valida_minlength='3'>
				<option value="sim" <? if($registro->sabe_ler_escrever=="sim"){echo "selected='selected'";}?>>Sim</option>
				<option value="nao" <? if($registro->sabe_ler_escrever=="nao"){echo "selected='selected'";}?>>Nao</option>
			</select>
		</label>

        <label style="width:160px;">
  			Escolaridade
    		<select name="f_grau_instrucao" >
    			<option></option>
        		<option value="1" <? if($registro->grau_instrucao=='1')echo "selected='selected'"?>>Analfabeto</option>
                <option <? if($registro->grau_instrucao=='2')echo "selected='selected'"; ?> value="2">Até a 4ª série incompleta do ensino fundamental</option>
        		<option <? if($registro->grau_instrucao=='3')echo "selected='selected'"; ?> value="3">
            	Com a 4ª série completa do ensino fundamental</option>
        		<option <? if($registro->grau_instrucao=='4')echo "selected='selected'"; ?> value="4">
                De 5 a 8ª série incompleta do ensino fundamental</option>
        		<option <? if($registro->grau_instrucao=='5')echo "selected='selected'"; ?> value="5">Ensino fundamental completo</option>
        		<option <? if($registro->grau_instrucao=='6')echo "selected='selected'"; ?> value="6">Ensino médio incompleto</option>
        		<option <? if($registro->grau_instrucao=='7')echo "selected='selected'"; ?> value="7">Ensino médio completo</option>
        		<option <? if($registro->grau_instrucao=='8')echo "selected='selected'"; ?> value="8">Superior incompleto</option>
        		<option <? if($registro->grau_instrucao=='9')echo "selected='selected'"; ?> value="9">Superior completo</option>
                <option <? if($registro->grau_instrucao=='10')echo "selected='selected'"; ?> value="10">Mestrado</option>
                <option <? if($registro->grau_instrucao=='11')echo "selected='selected'"; ?> value="11">Doutorado</option>
                <option <? if($registro->grau_instrucao=='12')echo "selected='selected'"; ?> value="12">Pós Doutorado</option>

    		</select>
  		</label>



              <div style="clear:both; font-size:10px;"></div>

         <label style="width:100px;" title="Certificado de Escolaridade" rel="tip">
			Certificado
			<input type="text" id='f_certificado' name="f_certificado" value="<?=$registro->certificado?>" />
		</label>

              
         <label style="width:190px;">Nome do Pai
		  <input type="text" name="f_filiacao_pai" value="<?=$registro->filiacao_pai?>" />
		</label>
        
        <label style="width:190px">Nome da Mae
		  <input type="text" name="f_filiacao_mae" value="<?=$registro->filiacao_mae?>" />
		</label>
        
        <?
			if($registro->estado_civil=="casado"){
				$display_casado = "block";
			}else{
				$display_casado = "none";
			}
		?>
        
        <div id="conjugue" style="display:<?=$display_casado?>">
                
        <label style="width:190px">Nome do Conjugue
		  <input type="text" name="f_nome_conjugue" value="<?=$registro->nome_conjugue?>" />
		</label>
        
        </div>
        
        <label style="width:100px;">
        	Aprendiz
            <select name="aprendiz" id="aprendiz">
            	<option></option>
                <option value="1" <? if($registro->aprendiz==1){echo "selected='selected'";}?>>Sim</option>
                <option value="2" <? if($registro->aprendiz==2){echo "selected='selected'";}?>>Não</option>
            </select>
        </label>
         
        <label style="width:100px;">
        	Possui Deficiência
            <select name="possui_deficiencia" id="possui_deficiencia">
            	<option ></option>
                <option value="1" <? if($registro->possui_deficiencia==1){echo "selected='selected'";}?>>Sim</option>
                <option value="2" <? if($registro->possui_deficiencia==2){echo "selected='selected'";}?>>Não</option>
            </select>
        </label>
        
        <?
			if($registro->possui_deficiencia==1){
				$display = "block";
			}
			if($registro->possui_deficiencia==2){
				$display = "none";
			}
		?>
        
        <div id="div_tipo_deficiencia" style="display:<?=$display?>">
          <label style="width:110px;">
              Tipo de Deficiência
              <select name="tipo_deficiencia" id="tipo_deficiencia">
                  <option ></option>
                  <option value="1" <?php if($registro->tipo_deficiencia=='1'){echo "selected=selected";}?>>Física</option>
                  <option value="2" <?php if($registro->tipo_deficiencia=='2'){echo "selected=selected";}?>>Auditiva</option>
                  <option value="3" <?php if($registro->tipo_deficiencia=='3'){echo "selected=selected";}?>>Visual</option>
                  <option value="4" <?php if($registro->tipo_deficiencia=='4'){echo "selected=selected";}?>>Mental</option>
                  <option value="5" <?php if($registro->tipo_deficiencia=='5'){echo "selected=selected";}?>>Múltipla</option>
                  <option value="6" <?php if($registro->tipo_deficiencia=='6'){echo "selected=selected";}?>>Reabilitado</option>
              </select>
          </label>
        </div>
              <div style="clear:both; font-size:10px;"></div>


        <label style="width:100px; ">
			CPF
			<input type="text" id='f_cpf' name="f_cpf" value="<?=$registro->cpf?>" mascara="___.___.___-__" sonumero='1' 
            retorno="focus|Digite o CPF corretamente" valida_minlength='3' onkeyup="checa_cpf(this)"/>
		</label>        
            
              
       	<label style="width:65px; ">
			RG
			<input type="text" id='f_rg' name="f_rg" value="<?=$registro->rg?>"  sonumero='1' />
		</label>       	 
                  
    	<label style="width:93px; " title="Local de Emissao">
			Local de Emissao
			<input type="text" id='f_local_emissao' name="f_local_emissao" value="<?=$registro->rg_orgao_emissor?>" />
		</label>
    	
        <label style="width:93px;">
			Data de Emissao
			<input type="text" mascara='__/__/____'  id='f_data_emissao' name="f_data_emissao" style="width:75px;" value="<?=dataUsaToBr($registro->rg_data_emissao)?>" />
		</label>	
    	 
                 
                
        <div style=" float:left; font-size:10px; border-right:1px solid #CCC; margin-right:10px; padding-right:5px; height:38px;"><strong>CTPS</strong></div>
         <label style="width:70px;" title="Número da Carteira de Trabalho">
			 Número
			 <input type="text" id='f_carteira_profissional_numero' name="f_carteira_profissional_numero" value="<?=$registro->carteira_profissional_numero?>" maxlength="8"/>
		</label>	
        
        <label style="width:70px;">
			 Série
			<input type="text" id='f_carteira_profissional_serie' name="f_carteira_profissional_serie" value="<?=$registro->carteira_profissional_serie?>" maxlength="5"/>
		</label>
        
        <label style="width:25px;">
			UF
			<input type="text" id='f_carteira_profissional_estado_emissor' name="f_carteira_profissional_estado_emissor" value="<?=$registro->carteira_profissional_estado_emissor?>" />
		</label>
        
        <label style="width:86px; margin-left:0;" title="Data de Expediçao da CTPS">
			Data Expedição
			<input type="text" id='f_carteira_profissional_data_expedicao' name="f_carteira_profissional_data_expedicao" value="<?=DataUsaToBr($registro->carteira_profissional_data_expedicao)?>" style="width:75px" mascara="__/__/____" />
		</label>    
        
       
           
        <label style="width:100px;">
			Naturalidade
			<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$registro->naturalidade?>" />
		</label>
        
        <label style="width:126px;">
			Nacionalidade
			<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$registro->nacionalidade?>" />
		</label>
        
        <label style="width:103px; margin-right:10px" title="Número da Carteira de Reservista">
			Carteira Reservista
			<input type="text" id='f_carteira_reservista' name="f_carteira_reservista" value="<?=$registro->carteira_reservista?>" style="width:80px" />
		</label>
        
        <label style="width:103px; margin-right:10px" title="Número da Carteira de Reservista">
			Categoria
            
			<input type="text" id='f_categoria' name="f_categoria" value="01 - Empregado;" style="width:80px" onfocus="this.blur();" />
		</label>
        
        <label style="width:90px; margin-right:23px;">
			Telefone
			<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$registro->telefone1?>" mascara="(__)____-____" sonumero='1' valida_minlength='3' retorno='focus|Por favor, insira um telefone para contato' />
		</label>
		
        <label style="width:90px; margin-right:22px;">
			Celular
			<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$registro->telefone2?>" mascara="(__)____-____" sonumero='1' />
		</label>
          
         
                
        <label style="width:180px; margin-right:23px;">
			Email
			<input type="text" id='f_email' name="f_email" value="<?=$registro->email?>"   />
		</label>
        
        <!--<label style="width:180px; margin-right:23px;">
			Naturalidade
			<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$registro->naturalidade?>"   />
		</label>-->
            
		<div style="clear:both"></div>	
        
        
		
            
                
        <label style="width:70px; margin-right:22px;">
			Cep
			<input type="text" id='f_cep' name="f_cep" value="<?=$registro->cep?>" mascara="_____-___" sonumero='1' 
            autocomplete="off" onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/escolar/professor/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}"/>
		</label>
		
        <label style="width:200px; margin-right:23px;">
			Endereço
			<input type="text" id='f_endereco' name="f_endereco" value="<?=$registro->endereco?>" />
		</label>
        
        <label style="width:30px; margin-right:23px;">
			N&ordm;
			<input type="text" id='f_numero' name="f_numero" value="<?=$registro->casa_numero?>" />
		</label>
        
        <label style="width:100px; margin-right:23px;">
			Bairro
			<input type="text" id='f_bairro' name="f_bairro" value="<?=$registro->bairro?>"/>
		</label>
		
        <label style="width:100px; margin-right:22px;">
			Cidade
			<input type="text" id='f_cidade' name="f_cidade" value="<?=$registro->cidade?>" retorno="focus|Digite a cidade corretamente" valida_minlength='2'/>
		</label>
		
        <label style="width:30px; margin-right:23px;">
			Estado
			<input type="text" id='f_estado' name="f_estado" value="<?=$registro->estado?>" retorno="focus|Digite o estado corretamente" valida_minlength='2'/>
		</label>
        
        <label style="width:100px; margin-right:22px;">
			Complemento
			<input type="text" id='f_complemento' name="f_complemento" value="<?=$registro->complemento?>"/>
		</label>
        
        <div style="clear:both"></div>
        
        <label style="width:80px;  height:33px">
			É estrangeiro
			<select id='f_quando_estrangeiro' name="f_quando_estrangeiro"/>
            	<option ></option>
                <option value="nao" <? if($registro->quando_estrangeiro=="nao"){echo "selected='selected'";} ?>>Nao</option>
                <option value="sim" <? if($registro->quando_estrangeiro=="sim"){echo "selected='selected'";} ?>>Sim</option>
            </select>
		</label>
		
		<? if($registro->quando_estrangeiro=="sim"){$display="block";}else{$display="none";} ?>
                
        <div id="estrangeiro" style="display:<?=$display?>">
        <label style="width:100px;">
			País de Origem
			<input type="text" id='f_pais_origem' name="f_pais_origem" value="<?=$registro->pais_origem?>" />
		</label>
        
               
        <!--<label style="width:120px;">
			Nome Conjugue
			<input type="text" id='f_nome_conjugue' name="f_nome_conjugue" value="<?=$registro->nome_conjugue?>" />
		</label>-->
        
        <label style="width:80px;" title="data de chegada ao Brasil">
			Dt Cheg Brasil		
            	<input type="text" id='f_data_chegada_brasil' name="f_data_chegada_brasil" value="<?=DataUsaToBr($registro->data_chegada_brasil)?>" calendario="1" mascara="__/__/____" sonumero="1"/>
        </label>
        
        <label style="width:70px; height:33px">
			Naturalizado?
			<select name="f_naturalizado" retorno="focus|Digite o nome corretamente" valida_minlength='3'>
			    <option value="nao" <? if($registro->naturalizado=="nao"){echo "selected='selected'";} ?>>Nao</option>       
				<option value="sim" <? if($registro->naturalizado=="sim"){echo "selected='selected'";} ?>>Sim</option>
				
			</select>
		</label>
        
        <label style="width:50px;" title="Estado onde a cateira foi emitida">
			UF Exp.
			<input type="text" id='f_naturalizado_estado' name="f_naturalizado_estado" value="<?=$registro->estado_naturalizado?>" />
		</label>
        
               
        <label style="width:70px;" title="Modelo da Carteira Esntrageira">
			Cart. Modelo
			<input type="text" id='f_carteira_estrangeira_modelo' name="f_carteira_estrangeira_modelo" value="<?=$registro->carteira_estrangeira_modelo?>" />
		</label>
        
                
        <label style="width:70px;" title="Número da Carteira Esntrageira">
			Cart. Núm.
			<input type="text" id='f_carteira_estrangeira_numero' name="f_carteira_estrangeira_numero" value="<?=$registro->carteira_estrangeira_numero?>" />
		</label>
        
                  
        <label style="width:80px;" title="Data de Expediçao da Carteira Esntrageira">
			Dt Cart. 
			<input type="text" id='f_carteira_estrangeira_data_expedicao' name="f_carteira_estrangeira_data_expedicao" value="<?=DataUsaToBr($registro->carteira_estrangeira_data_expedicao)?>" calendario="1" mascara="__/__/____" sonumero="1"/>
		</label>
        
        
        
        
        </div>
        
             		
        
        <label style="width:80px;" title="UF de Nascimento">
			UF de Nasc.
			<input type="text" id='f_uf_nascimento' name="f_uf_nascimento" value="<?=$registro->uf_nascimento?>" />
		</label>
        <label style="width:90px;" title="Município de Nascimento">
			Município Nasc.
			<input type="text" id='f_municipio_nascimento' name="f_municipio_nascimento" value="<?=$registro->municipio_nascimento?>" />
		</label>
		
        <label style="width:100px;">
			Sindicato
			<input type="text" id='f_sindicato' name="f_sindicato" value="<?=$registro->sindicato?>" />
		</label>
        
        <label style="width:100px;">
			Cód. Sindicato
			<input type="text" id='f_cod_sindicato' name="f_cod_sindicato" value="<?=$registro->cod_sindicato?>" />
		</label>
        
        <label style="width:120px;">
			CNPJ Sindicato
			<input type="text" id='f_cnpj_sindicato' name="f_cnpj_sindicato" value="<?=$registro->cnpj_sindicato?>" mascara="__.___.___/____-__" sonumero="1"/>
		</label>
        
        <!--<label style="width:170px;">
			Pensão Alimentícia (%)(TRCT)
			<input type="text" id='f_pensao_alimenticia_trct' name="f_pensao_alimenticia_trct" value="<?=MoedaUsaToBr($registro->pensao_alimenticia_trct)?>" style="width:80px;" sonumero="1" decimal="2"/>
		</label>
        
        <label style="width:170px;">
			Pensão Alimentícia (%)(Saque FGTS)
			<input type="text" id='f_pensao_alimenticia_fgts' name="f_pensao_alimenticia_fgts" value="<?=MoedaUsaToBr($registro->pensao_alimenticia_fgts)?>" style="width:80px;" sonumero="1" decimal="2"/>
		</label>
        
        <label style="width:140px;">
			Adicional de Insalubridade (%)
			<input type="text" id='f_adicional_insalubridade' name="f_adicional_insalubridade" value="<?=MoedaUsaToBr($registro->adicional_insalubridade)?>" style="width:80px;" sonumero="1" decimal="2"/>
            
		</label>
        
        <label style="width:170px;">
			Adicional de Periculosidade (%)
			<input type="text" id='f_adicional_periculosidade' name="f_adicional_periculosidade" value="<?=MoedaUsaToBr($registro->adicional_periculosidade)?>" style="width:80px;" sonumero="1" decimal="2"/>
		</label>
        
            
        <label style="width:170px;">
			Adicional Noturno (%)
			<input type="text" id='f_adicional_noturno' name="f_adicional_noturno" value="<?=MoedaUsaToBr($registro->adicional_noturno)?>" style="width:80px;" sonumero="1" decimal="2"/>
		</label>
        
        <label style="width:110px;" rel="tip" title="Desconto de Vale Transporte">
			Vale Transporte (%)
			<input type="text" id='f_vale_transporte' name="f_vale_transporte" value="<?=MoedaUsaToBr($registro->vale_transporte)?>" style="width:80px;" sonumero="1" decimal="2"/>
		</label> -->
        
		<div style="clear:both"></div>	
                
               	
		<label style="width:90px;" title="Tipo de Admissao">
			Tipo Admissao
			<select id='f_tipo_admissao' name="f_tipo_admissao"/>
            	<option value="10" <?php if($registro->tipo_admissao=='10'){echo "selected=selected";}?>>Primeiro Emprego</option>
                <option value="20" <?php if($registro->tipo_admissao=='20'){echo "selected=selected";}?>>Reemprego</option>
                <option value="25" <?php if($registro->tipo_admissao=='25'){echo "selected=selected";}?>>Contrato por prazo determinado</option>
                <option value="35" <?php if($registro->tipo_admissao=='35'){echo "selected=selected";}?>>Reintegração</option>
                <option value="70" <?php if($registro->tipo_admissao=='70'){echo "selected=selected";}?>>Transferência de entrada</option>
                <option value="80" <?php if($registro->tipo_admissao=='80'){echo "selected=selected";}?>>Contrato de Experiência</option>
            </select>
		</label>
        
        <label style="width:80px;" title="Data da Admissao">
			Data Admissao
			<input type="text" id='f_data_admissao' name="f_data_admissao" value="<?=DataUsaToBr($registro->data_admissao)?>" calendario="1" mascara="__/__/____" sonumero="1"/>
		</label>
        
        <label style="width:70px;" title="Tempo de Experiência(Em dias)" rel="tip" >
			Dias Experi.
			<!--<input type="text" id='f_dias_experiencia' name="f_dias_experiencia" value="<?=$registro->dias_experiencia?>" sonumero="1"/>-->
            <select id='f_dias_experiencia' name="f_dias_experiencia">
            	<option value="1" <?php if($registro->dias_experiencia==1){echo "selected='selected'";}?>>De 30 a 60 dias</option>
                <option value="2" <?php if($registro->dias_experiencia==2){echo "selected='selected'";}?>>De 45 a 45 dias</option>
                <option value="3" <?php if($registro->dias_experiencia==3){echo "selected='selected'";}?>>De 60 a 30 dias</option>
            </select>
		</label>
        
			
        <!--<input type="hidden" name="f_id" id="f_id" value="<?=$registro->f_id?>" />-->
        
        <label style="width:80px;" title="Fim do período de Experiência 1" rel="tip">
        	Data 1
            <input type="text"  name="prazo_experiencia_1" id="prazo_experiencia_1" value="<?=$prazos_experiencia["prazo1"]?>" disabled="disabled"/>
        </label>
        <label style="width:80px;" title="Fim do período de Experiência 2" rel="tip">
        	Data 2
            <input type="text" name="prazo_experiencia_2" id="prazo_experiencia_2" value="<?=$prazos_experiencia["prazo2"]?>" disabled="disabled"/>
        </label>
        
        
        
        <label style="width:80px;" title="Classificação Brasileira de Ocupações" rel="tip">
        	CBO
            <input type="text" id='f_cbo' name="f_cbo" value="<?=$registro->cbo?>" busca='modulos/rh/funcionarios/busca_cargo.php?acao=cbo&empresa_id=<?=$cliente_fornecedor->id?>,@r1 @r2 @r3,@r1-value>f_cbo|@r2-value>f_cargo|@r3-value>f_salario' />
        </label>
        <label style="width:100px;">
        	Cargo
         <input type="text" name="f_cargo" id="f_cargo" value="<?=$registro->cargo?>" busca='modulos/rh/funcionarios/busca_cargo.php?acao=cargo&empresa_id=<?=$cliente_fornecedor->id?>,@r1 @r2 @r3,@r0-value>f_cargo_id|@r1-value>f_cbo|@r2-value>f_cargo|@r3-value>f_salario' autocomplete="off"/>
         <input type="hidden" name="f_cargo_id" id="f_cargo_id" value="<?=$registro->cargo_id?>" />
        </label>
        <label style="width:80px;">
        	Salário
            <input type="text" id='f_salario' name="f_salario" value="<?=MoedaUsaToBr($registro->salario)?>" decimal="2" sonumero="1"/>
        </label>
        
         <div style="clear:both"></div>
                
        <label style="width:80px;" title="Hora de Início do Expediente" rel="tip">
        	Hr. Início Exp.
            <input type="text" id='f_inicio_expediente' name="f_inicio_expediente" value="<?=substr($registro->hora_inicio_expediente,0,5);?>" mascara="__:__" sonumero="1"/>
        </label>
        <label style="width:100px;" title="Hora do Fim do Expediente" rel="tip">
        	Hr. Fim Expediente
            <input type="text" id='f_fim_expediente' name="f_fim_expediente" value="<?=substr($registro->hora_fim_expediente,0,5)?>" mascara="__:__" sonumero="1"/>
        </label>
        
       
        
         <label style="width:100px;" title="Hora do Fim do Expediente" rel="tip">
        	Duração Intervalo
            <input type="text" id='f_duracao_intervalo' name="f_duracao_intervalo" value="<?=substr($registro->duracao_intervalo,0,5)?>" mascara="__:__" sonumero="1"/>
        </label>
        
        <label style="width:80px;" title="Número sequencial da Ficha do Funcionário" rel="tip">
        	N&ordm; Sequencial
            <input type="text" id='f_numero_sequencial_empresa' name="f_numero_sequencial_empresa" value="<?=$registro->numero_sequencial_empresa?>" sonumero="1"/>
        </label>
        <label style="width:100px;">
        	Livro
            <input type="text" id='f_livro' name="f_livro" value="<?=$registro->livro?>"/>
        </label>
        
        
        
        <label style="width:100px;">
              Conta
              <input type="text" name="conta" id="conta" value="<?=$registro->conta?>" />
          </label>
          
          <label style="width:100px;">
              Agência
              <input type="text" name="agencia" id="agencia" value="<?=$registro->agencia?>" />
          </label>
        
        <label style="width:100px;">
                    Banco
                    <select onchange="trocaBanco(this);" name="banco" id="banco">
 	                   <option></option>
						<option value="1" <?php if($registro->banco=="1"){echo "selected='selected'";}?>>Banco do Brasil</option>
                        <option value="27" <?php if($registro->banco=="27"){echo "selected='selected'";}?>>Banco Santander(Brasil) S.A.</option>
                        <option value="237" <?php if($registro->banco=="237"){echo "selected='selected'";}?>>Bradesco</option>
                        <option value="104" <?php if($registro->banco=="104"){echo "selected='selected'";}?>>Caixa Econômica Federal</option>
                        <option value="409" <?php if($registro->banco=="409"){echo "selected='selected'";}?>>Itaú Unibanco S/A</option>
                        <option value="399" <?php if($registro->banco=="399"){echo "selected='selected'";}?>>HSBC</option> 
                    </select>
          </label>
          
          <label style="width:150px;">
                    Foto
                    <input type="file" name="foto" id="foto" />
          </label>
          
                    
           <label style="width:200px;">
            Empresa de Atuação
            <?php
				$empresas = mysql_query($t="SELECT * FROM rh_empresas e, cliente_fornecedor cf WHERE e.cliente_fornecedor_id=cf.id AND e.vkt_id='$vkt_id'");
			
			?>
            <select id='empresa_atuacao_id' name="empresa_atuacao_id"/>
           		<?
					while($empresa=mysql_fetch_object($empresas)){
						if($empresa->cliente_fornecedor_id==$registro->empresa_atuacao_id){
							$selected="selected='selected'";
						}
						echo "<option value='$empresa->cliente_fornecedor_id' $selected>$empresa->nome_fantasia $empresa->cnpj_cpf</option>";
						$selected='';
					}
				?>
            </select>           
        </label>
        <?php
			$funcionario_indicador = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$registro->funcionario_indicacao_id'"));
		?>
        <label style="width:200px;">
                Indicado Por: 
                <input type="text" name="funcionario_indicacao" id="funcionario_indicacao" busca="modulos/rh/funcionarios/busca_funcionarios.php?funcionario_id=<?=$registro->id?>,@r1 @r2,@r0-value>funcionario_indicacao_id|@r1-value>funcionario_indicacao,0" value="<?=$funcionario_indicador->nome?>"/>
                <input type="hidden" name="funcionario_indicacao_id" id="funcionario_indicacao_id" value="<?=$registro->funcionario_indicacao_id?>" />
         </label>
        
       
        <div style="float:left;margin-top:20px;">       
            
        	      	<input type="checkbox" name="vendedor" <? if($registro->vendedor=="s"){echo "checked=checked";} ?>/>Este funcionário é um vendedor
        </div>
        
        <div style="clear:both">
        
         <?php
			if(!empty($registro->extensao)){
		?>        
        <div style="width:150px;max-height:100px;float:left;margin-left:10px;" class="foto">
           	<img width="100" height="100" src="../upload/rh/funcionarios/fotos/<?=$registro->id.".".$registro->extensao?>" id="foto">
        	<a class="remover_foto" href="#">Remover Foto</a>
        </div>    
        <?php
			}
		?> 
        
	</div>        
	</fieldset>
    
    <fieldset id="dados_pis" style="display:none;">
		<legend>
			  <a class="link_form">Dados</a>
              <a class="link_form"><strong>PIS</strong></a>
    		  <a class="link_form">Dependentes</a>
              <a class="link_form">Social</a>
             <a class="link_form">Documentos</a> 
             <a class="link_form">Contrato</a>
             <a class="link_form">Avaliação</a>    		
		</legend>
        
        <label style="width:80px;">
			PIS
			 
			  <input type="text" id='f_pis' name="f_pis" value="<?=$registro->pis?>"/>
		</label>
        
        <label style="width:80px; margin-right:22px;" title="Número do título de Eleitor">
			Título Eleitor
			<input type="text" id='f_titulo_eleitor_numero' name="f_titulo_eleitor_numero" value="<?=$registro->titulo_eleitor_numero?>" 
            />
		</label>        
            
              
       	<label style="width:40px; margin-right:23px;" title="Zona do título de Eleitor">
			Zona
			<input type="text" id='f_titulo_eleitor_zona' name="f_titulo_eleitor_zona" value="<?=$registro->titulo_eleitor_zona?>" />
		</label>       	 
                  
    	<label style="width:40px; margin-right:22px;" title="Seçao do título de Eleitor">
			Seçao
			<input type="text" id='f_titulo_eleitor_secao' name="f_titulo_eleitor_secao" value="<?=$registro->titulo_eleitor_secao?>" />
		</label>
    	
        <label style="width:120px; margin-right:22px;" title="Portaria Naturalizaçao">
			Portaria Naturalizaçao
			<input type="text" id='f_portaria_naturalizacao_numero' name="f_portaria_naturalizacao_numero" value="<?=$registro->portaria_naturalizacao_numero?>" />
		</label>
        
         <label style="width:140px; margin-right:22px;" title="Data da Portaria Naturalizaçao">
			Dt Portaria Naturalizaçao
			<input type="text" id='f_portaria_naturalizacao_data' name="f_portaria_naturalizacao_data" value="<?=dataUsaToBr($registro->portaria_naturalizacao_data)?>" calendario="1"/>
		</label>
               
          <div style="clear:both"></div>     
        
         <label style="width:140px;">
         Tipo Certificado Civil      
        <select title="Certidao Civil" id='f_certidao_civil_tipo' name="f_certidao_civil_tipo" >
			
			<option value="nascimento" <? if($registro->certidao_civil_tipo=="nascimento"){ echo "selected='select'";}?>>Certidao de Nascimento</option> 
            <option value="casamento" <? if($registro->certidao_civil_tipo=="casamento"){ echo "selected='select'";}?>>Certidao de Casamento</option>
             <option value="indigena" <? if($registro->certidao_civil_tipo=="indigena"){ echo "selected='select'";}?>>Certidao Administrativa de Nascimento do Indígena</option>
             <option value="obito" <? if($registro->certidao_civil_tipo=="obito"){ echo "selected='select'";}?>>Certidao de Óbito</option>
		</select>
        </label>
        
        
        
        <label style="width:120px; margin-right:22px;" title="Certidao Civil">
			Dt Certificado Civil
			<input type="text" id='f_certidao_civil_data_emissao' name="f_certidao_civil_data_emissao" value="<?=DataUsaToBr($registro->certidao_civil_data_emissao)?>" 
            calendario="1" mascara="__/__/____"/>
		</label>
        
         <label style="width:140px; margin-right:22px;" title="Matrícula Certidao Civil">
			Matrícula Certificado Civil
			<input type="text" id='f_certidao_civil_matricula' name="f_certidao_civil_matricula" value="<?=$registro->certidao_civil_matricula?>" />
		</label>
        
        <label style="width:120px; margin-right:22px;" title="Livro Certidao Civil">
			Livro Certificado Civil
			<input type="text" id='f_certidao_civil_livro' name="f_certidao_civil_livro" value="<?=$registro->certidao_civil_livro?>" />
		</label>
        
        <div style="clear:both"></div>
        
        <label style="width:140px; margin-right:22px;" title="Cartório Certidao Civil">
			Cartório Certificado Civil
			<input type="text" id='f_certidao_civil_cartorio' name="f_certidao_civil_cartorio" value="<?=$registro->certidao_civil_cartorio?>" />
		</label>
        
        <label style="width:130px; margin-right:22px;" title="Folha Certidao Civil">
			Folha Certificado Civil
			<input type="text" id='f_certidao_civil_folha' name="f_certidao_civil_folha" value="<?=$registro->certidao_civil_folha?>" />
		</label>
        
        
        
        <label style="width:130px; margin-right:22px;" title="Estado Certidao Civil">
			UF Certificado Civil
			<input type="text" id='f_certidao_civil_folha' name="f_certidao_civil_uf" value="<?=$registro->certidao_civil_uf?>" />
		</label>
        
        <label style="width:130px; margin-right:22px;" rel="tip" title="Município Certidao Civil">
			Município Cert. Civil
			<input type="text" id='f_certidao_civil_folha' name="f_certidao_civil_municipio"  value="<?=$registro->certidao_civil_municipio?>" />
		</label>
          
         <div style="clear:both"></div> 
               
        <label style="width:60px; margin-right:22px;" title="Registro Único de Identificação Civil" rel="tip">
			RIC.
			<input type="text" id='f_ric_numero' name="f_ric_numero" value="<?=$registro->ric_numero?>" 
            />
		</label>        
            
              
       	<label style="width:60px; margin-right:23px;" title="Estado emissor do RIC" rel="tip">
			RIC. UF
			<input type="text" id='f_ric_uf' name="f_ric_uf" value="<?=$registro->ric_uf?>" />
		</label>       	 
           
                          
    	<label style="width:60px; margin-right:22px;" title="RIC Emissor" rel="tip">
			RIC. Em.
			<input type="text" id='f_ric_emissor' name="f_ric_emissor" value="<?=$registro->ric_emissor?>" />
		</label>
    	
        <label style="width:60px; margin-right:22px;" title="RIC Municipio" rel="tip">
			RIC. Mun.
			<input type="text" id='f_ric_municipio' name="f_ric_municipio" value="<?=$registro->ric_municipio?>" />
		</label>
        
         <label style="width:70px; margin-right:22px;" title="RIC Data de Expediçao" rel="tip">
			Ric. Dt. Exp.
			<input type="text" id='f_ric_data_expedicao' name="f_ric_data_expedicao" value="<?=dataUsaToBr($registro->ric_data_expedicao)?>" calendario="1"/>
		</label>
			
          
            
            <label style="width:80px; margin-right:22px;" title="Número do passaporte" rel="tip">
			Num Passap.
			<input type="text" id='f_passaporte_numero' name="f_passaporte_numero" value="<?=$registro->passaporte_numero?>" 
            />
		</label>        
            
              
       	<label style="width:100px; margin-right:23px;" title="Emissor do passaporte" rel="tip">
			Emissao Passap.
			<input type="text" id='f_passaporte_emissor' name="f_passaporte_emissor" value="<?=$registro->passaporte_emissor?>"  sonumero='1' />
		</label>       	 
          
            <div style="clear:both"></div>
                  
    	<label style="width:130px; margin-right:22px;" title="Local de Emissao do Passaporte" rel="tip">
			Local Emissao Passap.
			<input type="text" id='f_passaporte_estado_emissor' name="f_passaporte_estado_emissor" value="<?=$registro->passaporte_estado_emissor?>" />
		</label>
    	
             
        <label style="width:120px; margin-right:22px;" title="Data de Emissao do Passaporte" rel="tip">
			Dt. Emissao Passap.
			<input type="text" mascara='__/__/____' calendario='1' id='f_data_emissao_passaporte' name="f_data_emissao_passaporte" value="<?=dataUsaToBr($registro->data_emissao_passaporte)?>" />
		</label>
        
         <label style="width:120px; margin-right:22px;" title="Data de Validade do Passaporte" rel="tip">
			Dt Validade Passap.
			<input type="text" mascara='__/__/____' calendario='1' id='f_data_validade_passaporte' name="f_data_validade_passaporte" value="<?=dataUsaToBr($registro->data_validade_passaporte)?>" />
		</label>
        
        <label style="width:120px; margin-right:22px;" title="País Emissor do Passaporte" rel="tip">
			País Emissor Passap.
			<input type="text"  id='f_pais_emissao_passaporte' name="f_pais_emissao_passaporte" value="<?=$registro->pais_emissao_passaporte?>" />
		</label>
        
        </fieldset>
        <input name="acao2" id="acao2" type="hidden" value="funcionario" />
        <input name="id" id="id" type="hidden" value="<?=$registro->id?>" />
        <input name="f_empresa_id" id="f_empresa_id" type="hidden" value="<?=$cliente_fornecedor->id?>" />
 <?
if($registro->id>0){
?>

<input name="action" type="submit" value="Excluir" style="float:left" />
<input type="button" value="Ficha Frente" class="imprimir_relatorio"/>
<input type="button" value="Ficha Costa" class="imprimir_relatorio"  />
<input type="button" value="PIS" class="imprimir_relatorio"  />
<input type="button" value="Termo de Opçao" class="imprimir_relatorio"/>
<input type="button" value="Termo de Transporte" class="imprimir_relatorio"/>
<input type="button" value="ASO" class="imprimir_relatorio"/>
<input type="button" value="Entrega de Carteira" class="imprimir_relatorio"/>
<input type="button" value="Devolução de Carteira" class="imprimir_relatorio"/>
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both; width:100%"></div>
</form>


<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_dependentes" enctype="multipart/form-data" target="carregador" action="modulos/rh/funcionario/form.php" style="display:none;">
    <fieldset>
		<legend>
			<a class="link_form">Dados</a>
            <a class="link_form">PIS</a>
    		<a class="link_form"><strong>Dependentes</strong></a>
            <a class="link_form">Social</a> 
            <a class="link_form">Documentos</a>
    		<a class="link_form">Contrato</a> 
            <a class="link_form">Avaliação</a> 		
		</legend>
        
        <label style="width:300px;">
        		Nome
                <input type="text" name="nome_dependente" id="nome_dependente" />
        </label>
        
        <label style="width:120px;">
        		Data de Nascimento
                <input type="text" name="data_nascimento_dependente" id="data_nascimento_dependente" sonumero="1" mascara="__/__/____"/>
        </label>
        
        <label style="width:120px;">
        	
  			Escolaridade
    		<select name="grau_escolaridade_dependente" id="grau_escolaridade_dependente">
    			
        		<option value="1">Analfabeto</option>
                <option value="2">Até a 4ª série incompleta do ensino fundamental</option>
        		<option value="3">Com a 4ª série completa do ensino fundamental</option>
        		<option value="4">De 5 a 8ª série incompleta do ensino fundamental</option>
        		<option value="5">Ensino fundamental completo</option>
        		<option value="6">Ensino médio incompleto</option>
        		<option value="7">Ensino médio completo</option>
        		<option value="8">Superior incompleto</option>
        		<option value="9">Superior completo</option>
                <option value="10">Mestrado</option>
                <option value="11">Doutorado</option>
                <option value="12">Pós Doutorado</option>

    		</select>
  		
        </label>
        
        <label style="width:120px;">
        		Grau de Parentesco
                <select name="grau_parentesco_dependente" id="grau_parentesco_dependente">
                		<option value="mae">Mae</option>
                        <option value="pai">Pai</option>
                        <option value="filho">Filho(a)</option>
                        <option value="marido">Marido</option>
                        <option value="espoasa">Esposa</option>
                        <option value="amigo">Amigo(a)</option>
                </select>
        </label>
        
        <div style="float:left;margin-top:15px;">
        	<input type="checkbox" name="dependente_plano_saude" id="dependente_plano_saude" />Tem Plano de Saúde        
        </div>
        
        <div style="clear:both"></div>
        
        <input type="button"  id="adicionar_dependente" value="Adicionar Dependente" style="margin-top:5px;"/>
        
        <div style="clear:both"></div>
        
        <div id='dados_dependentes'>
        
		<?
             require_once('tabela_dependentes.php'); 
		?>
        </div>
        
        <input type="hidden" name="acao2" id="acao2" value="dependente" />
        
        <input name="id" type="hidden" value="<?=$registro->id?>" />
        
</fieldset>
	
<!--Fim dos fiels set-->


<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>

<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_perfil_social" target="carregador" action="modulos/rh/funcionarios/form.php" style="display:none;">
    <fieldset>
		<legend>
			  <a class="link_form">Dados</a>
              <a class="link_form">PIS</a>
    		<a class="link_form">Dependentes</a>
            <a class="link_form"><strong>Social</strong></a> 
            <a class="link_form">Documentos</a>
    		 <a class="link_form">Contrato</a>
             <a class="link_form">Avaliação</a>  		
		</legend>
        <div style="max-height:450px;overflow:auto;">
        <div style="border-bottom:solid 1px #CCC;width:70%;height:15px;margin-bottom:10px;font-weight:bold;color:#999999;">
        	Escolaridade
        </div> 
        
            <label>
                Estuda
                <select id="estuda" name="estuda">
                    <option value="sim" <?php if($registro->estuda=='sim'){ echo "selected='selected'";$display_escolaridade="block";}?>>Sim</option> 
                    <option value="nao" <?php if($registro->estuda=='nao'){ echo "selected='selected'";$display_escolaridade="none";}?>>Não</option>
                                                           
                </select>
            </label>
            
                      
            <div style="float:left;display:<?=$display_escolaridade?>" class="escolaridade">
            
            <label>
            	 Nível:
            	<select name="nivel_escolaridade" id="nivel_escolaridade">
            		<option value="fundamental" <?php if($registro->nivel_escolaridade=='fundamental'){ echo "selected='selected'";}?>/>Fundamental</option>
            		<option value="medio" <?php if($registro->nivel_escolaridade=='medio'){ echo "selected='selected'";}?>/>Médio</option>
            		<option value="superior" <?php if($registro->nivel_escolaridade=='superior'){ echo "selected='selected'";}?>/>Superior</option>
            	</select>
            </label>
            
             <label>
            	 Situação
            	<select name="situacao_escolaridade" id="situacao_escolaridade">
            		<option value="cur" <?php if($registro->situacao_escolaridade=='cur'){ echo "selected='selected'";$display_serie="block";}?>/>Cursando</option>
                    <option value="c" <?php if($registro->situacao_escolaridade=='c'){ echo "selected='selected'";$display_serie="none";}?>/>Completo</option>
            		<option value="i" <?php if($registro->situacao_escolaridade=='i'){ echo "selected='selected'";$display_serie="block";}?>/>Incompleto</option>
            	</select>
            </label>
            
                                
              	
            
            	<label style="width:80px;display:<?=$display_serie?>;" id="lblserie_escolaridade">
                	Série/Período
                    <input type="text" name="serie_escolaridade" value="<?php echo $registro->serie_escolaridade?>"/>
                </label>
                
                <label style="width:80px;">
                	Ano
                    <input type="text" name="ano_escolaridade" value="<?php echo $registro->ano_escolaridade?>" sonumero="1"/>
                </label>
                
                       	                         
                <label style="width:150px;">
                	Curso
                    <input type="text" name="curso_escolaridade" value="<?php echo $registro->curso_escolaridade?>"/>
                </label>
                
                 
            </div>
             <div style="clear:both"></div> 
             <div style="float:left;display:<?=$display_escolaridade?>" class="escolaridade">   
                <label style="width:150px;">
                	Instituição
                    <input type="text" name="instituicao_escolaridade" value="<?php echo $registro->instituicao_escolaridade?>"/>
                </label>
                
                
                              
                  <div id="horario_escolaridade">
                  	Horário:
                  
                  	<input type="checkbox" name="horario_escolaridade[]" value="m" <?php if(strstr($registro->horario_escolaridade,"m")){echo "checked='checked'";}?>/>Manhã
                  	<input type="checkbox" name="horario_escolaridade[]" value="t" <?php if(strstr($registro->horario_escolaridade,"t")){echo "checked='checked'";}?>/>Tarde
                  	<input type="checkbox" name="horario_escolaridade[]" value="n" <?php if(strstr($registro->horario_escolaridade,"n")){echo "checked='checked'";}?>/>Noite
                </div>
            </div>
        
        <div style="clear:both"></div>
        
        <div style="border-bottom:solid 1px #CCC;width:70%;height:15px;margin-bottom:10px;font-weight:bold;color:#999999;">
        	Perfil Social
        </div> 
        <?php
			$display_divmoraem='none';
		?>
            <label style="width:150px;">
                Renda Familiar
                <select id="renda_familiar" name="renda_familiar">
                    <option value="1" <?php if($registro->renda_familiar=='1'){echo "selected='selected'";}?>>até R$670,00</option>
                    <option value="2" <?php if($registro->renda_familiar=='2'){echo "selected='selected'";}?>>de R$670,00 até R$1.000,00</option>
                    <option value="3" <?php if($registro->renda_familiar=='3'){echo "selected='selected'";}?>>de R$1001,00 até R$2.000,00</option>
                    <option value="4" <?php if($registro->renda_familiar=='4'){echo "selected='selected'";}?>>de R$2001,00 até R$3.000,00</option>
                    <option value="5" <?php if($registro->renda_familiar=='5'){echo "selected='selected'";}?>>Acima de R$3.000,00</option>
                </select>
            </label>
            
            <label>
                Mora Em
                <select id="mora_em" name="mora_em">
                    <option value="casa" <?php if($registro->mora_em=='casa'){echo "selected='selected'";}?>>Casa</option>
                    <option value="apartamento" <?php if($registro->mora_em=='apartamento'){echo "selected='selected'";}?>>Apartamento</option>
                    <option value="quitinete" <?php if($registro->mora_em=='quitinete'){echo "selected='selected'";}?>>Quitinete</option>
                    <option value="outros" <?php if($registro->mora_em=='outros'){echo "selected='selected'";$display_divmoraem='block';}?>>Outros</option>
                </select>
            </label>
            
            <div id="divmoraem" style="display:<?=$display_divmoraem?>;float:left;">
            	<label style="width:130px;" rel="tip" title="Mora em Que tipo de casa?">
                	Especifique
                	<input type="text" name="mora_em_especificacao" id="mora_em_especificacao" value="<?php echo $registro->mora_em_especificacao;?>"/>
            	</label>
            </div>            
            
            <label>
                Tipo
                <select id="mora_tipo" name="mora_tipo">
                    <option value="madeira" <?php if($registro->mora_tipo=='madeira'){echo "selected='selected'";}?>>Madeira</option>
                    <option value="alvenaria" <?php if($registro->mora_tipo=='alvenaria'){echo "selected='selected'";}?>>Alvenaria</option>
                    <option value="misto" <?php if($registro->mora_tipo=='misto'){echo "selected='selected'";}?>>Misto</option>
                    <option value="outros" <?php if($registro->mora_tipo=='outros'){echo "selected='selected'";}?>>Outros</option>
                </select>
            </label>
            
            <label>
                Forma
                <select id="mora_forma" name="mora_forma">
                    <option value="proprio" <?php if($registro->mora_forma=='proprio'){echo "selected='selected'";}?>>Próprio</option>
                    <option value="alugado" <?php if($registro->mora_forma=='alugado'){echo "selected='selected'";}?>>Alugado</option>
                    <option value="cedido" <?php if($registro->mora_forma=='cedido'){echo "selected='selected'";}?>>Cedido</option>
                    <option value="terreno" <?php if($registro->mora_forma=='terreno'){echo "selected='selected'";}?>>Terreno da família dele(a)</option>
                    <option value="outros" <?php if($registro->mora_forma=='outros'){echo "selected='selected'";}?>>Outros</option>
                </select>
            </label>
            
            <?php
				$display_graumoracom = "none";
			?>
            
            <label>
                Mora Com
                <select id="mora_com" name="mora_com">
                    <option value="pais" <?php if($registro->mora_com=='pais'){echo "selected='selected'";}?>>Pais</option>
                    <option value="esposo" <?php if($registro->mora_com=='esposo'){echo "selected='selected'";}?>>Esposo(a)</option>
                    <option value="so" <?php if($registro->mora_com=='so'){echo "selected='selected'";}?>>Só</option>
                    <option value="parentes" <?php if($registro->mora_com=='parentes'){echo "selected='selected'";$display_graumoracom="block";}?>>Com Parentes</option>
                    
                </select>
            </label>
             
            <div id="divmoracom" style="display:<?=$display_graumoracom?>;float:left;">
                <label id="textmoracom" style="width:130px;">
                    Grau de Parentesco
                    <select name="graumoracom">
                    	<option value="tio" <?php if($registro->graumoracom=='tio'){echo "selected='selected'";}?>>Tio(a)</option>
                        <option value="avo" <?php if($registro->graumoracom=='avo'){echo "selected='selected'";}?>>Avô(ó)</option>
                        <option value="primo" <?php if($registro->graumoracom=='primo'){echo "selected='selected'";}?>>Primo(a)</option>
                    </select>
                </label>
            </div>
            
           
            <label style="width:90px;" rel="tip" title="Quantidade de Pessoas Adultas que moram/vivem em casa">
                Qtd Adultos
                <input type="text" name="qtd_adultos_casa" id="adultos_casa" value="<?php echo $registro->qtd_adultos_casa;?>" sonumero="1"/>
            </label>
            
            <label style="width:95px;" rel="tip" title="Quantidade de Crianças que moram/vivem em casa">
                Qtd Crianças
                <input type="text" name="qtd_criancas_casa" id="criancas_casa" value="<?php echo $registro->qtd_criancas_casa;?>" sonumero="1"/>
            </label>
            
            <label style="width:115px;" rel="tip" title="Quantidade de Pessoas que trabalham com carteira assinada">
                Qtd Cart. Assinada
                <input type="text" name="qtd_pessoas_carteira_assinada" id="qtd_pessoas_carteira_assinada" value="<?php echo $registro->qtd_pessoas_carteira_assinada;?>" sonumero="1"/>
            </label>       
              
             <label style="width:90px;" rel="tip" title="Quantidade de Pessoas que trabalham como autônomo">
                Qtd Autônomo
                <input type="text" name="qtd_pessoas_autonomo" id="qtd_pessoas_autonomo" value="<?php echo $registro->qtd_pessoas_autonomo;?>" sonumero="1"/>
            </label>
            
            <label style="width:90px;" rel="tip" title="Quantidade de Pessoas que são aposentadas">
                Qtd Aposentado
                <input type="text" name="qtd_pessoas_aposentadas" id="qtd_pessoas_aposentadas" value="<?php echo $registro->qtd_pessoas_aposentadas;?>" sonumero="1"/>
            </label> 
         
         <div style="clear:both"></div>
         
         <div style="border-bottom:solid 1px #CCC;width:70%;height:15px;margin-bottom:10px;font-weight:bold;color:#999999;">
        	Saúde
        </div>
        
        
         <div style="clear:both"></div>
        
        <label>
                Bebe
                <select id="bebe" name="bebe">
                    <option value="nao" <?php if($registro->bebe=='nao'){echo "selected='selected'";$display_frequencia_bebe='none';}?>>nao</option>
                    <option value="sim" <?php if($registro->bebe=='sim'){echo "selected='selected'";$display_frequencia_bebe='block';}?>>sim</option>                    
                </select>
         </label>
         
        
        <div style="display:<?=$display_frequencia_bebe?>;" id="frequencia_bebe">
        	 <label style="width:120px;">
                Com que frequência?
                <input type="text" name="descricao_bebe" id="descricao_bebe" value="<?=$registro->descricao_bebe?>"/>
            </label>
        </div>
        
        <label>
                Fuma
                <select id="fuma" name="fuma">
                    <option value="nao" <?php if($registro->fuma=='nao'){echo "selected='selected'";$display_frequencia_bebe='none';}?>>nao</option>
                    <option value="sim" <?php if($registro->fuma=='sim'){echo "selected='selected'";$display_frequencia_bebe='block';}?>>sim</option>                   
                </select>
         </label>
         
        
        <div style="display:<?=$display_frequencia_bebe?>;" id="circunstancia_fuma">
        	 <label style="width:120px;">
                Com que frequência?
                <input type="text" name="descricao_fuma" id="textcircunstancia_fuma" value="<?=$registro->descricao_fuma?>"/>
            </label>
        </div>
        
        <label style="width:100px;">
                Toma Medicação?
                <select id="medicacao" name="medicacao">
                    <option value="nao" <?php if($registro->medicacao=='nao'){echo "selected='selected'";$display_medicacao='none';}?>>nao</option>
                    <option value="sim" <?php if($registro->medicacao=='sim'){echo "selected='selected'";$display_medicacao='block';}?>>sim</option>
                    
                </select>
         </label>
         
        
        <div style="display:<?=$display_medicacao?>;" id="descricao_medicacao">
        	 <label style="width:120px;">
                Qual?
                <input type="text" name="descricao_medicacao" id="descricao_medicacao" value="<?=$registro->descricao_medicacao?>"/>
            </label>
        </div>
        <?php
        	$display_tratamento='none';
		?>
        <label style="width:130px;">
                Faz algum tratamento?
                <select id="tratamento" name="tratamento">
                     <option value="nao" <?php if($registro->tratamento=='nao'){echo "selected='selected'";}?>>nao</option>
                    <option value="sim" <?php if($registro->tratamento=='sim'){echo "selected='selected'";$display_tratamento='block';}?>>sim</option>
                   
                </select>
         </label>
         
        
        <div style="display:<?=$display_tratamento?>;" id="descricao_tratamento">
        	 <label style="width:120px;">
                Qual?
                <input type="text" name="descricao_tratamento" id="descricao_tratamento" value="<?=$registro->descricao_tratamento?>"/>
            </label>
        </div>
        
        <div style="clear:both"></div>
        
        <div style="color:#999999;">
            Quais destes tipos de problema você possui?
            
            <div style="clear:both;margin-top:10px;"></div>
            
            <input type="checkbox" name="problema_saude[]" value="1" <?php if(strstr($registro->problema_saude,'1')){echo "checked='checked'";}?>/>Pressão Alta
            
            <input type="checkbox" name="problema_saude[]" value="2" <?php if(strstr($registro->problema_saude,'2')){echo "checked='checked'";}?>/>Alergia
            
            <input type="checkbox" name="problema_saude[]" value="3" <?php if(strstr($registro->problema_saude,'3')){echo "checked='checked'";}?>/>Dor de Cabeça
            
            <input type="checkbox" name="problema_saude[]" value="4" <?php if(strstr($registro->problema_saude,'4')){echo "checked='checked'";}?>/>Dor nas Costas
            
            <input type="checkbox" name="problema_saude[]" value="5" <?php if(strstr($registro->problema_saude,'5')){echo "checked='checked'";}?>/>Reumatismo
            
            <input type="checkbox" name="problema_saude[]" value="6" <?php if(strstr($registro->problema_saude,'6')){echo "checked='checked'";}?>/>Diabetes
            
            <input type="checkbox" name="problema_saude[]" value="7" <?php if(strstr($registro->problema_saude,'7')){echo "checked='checked'";}?>/>Asma
            
            <input type="checkbox" name="problema_saude[]" value="8" <?php if(strstr($registro->problema_saude,'8')){echo "checked='checked'";}?>/>Varizes
            
               
          
            <?php
				$display_descricao_problema_saude='none';
			?>
            <input type="checkbox" name="outro_problema_saude" id="outro_problema_saude" <?php if(!empty($registro->descricao_problema_saude)){echo "checked='checked'";
			$display_descricao_problema_saude='block';}?>/>Outro
        	            
           
            
        	
        	<div style="clear:both"></div>
             
               
            <label style="width:250px;display:<?=$display_descricao_problema_saude?>" id="descricao_doenca">
            Descrição da Doença
             	<input type="text" name="descricao_problema_saude" id="textdescricao_doenca" value="<?=$registro->descricao_problema_saude?>"/>
            </label>
        		
           
            <div style="clear:both"></div>
            <?php
				$plano_saude = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='$registro->plano_saude_id'"));
				
			?>
        <label style="width:200px;">
                Plano de Saúde
                <input type="text" name="plano_saude" id="plano_saude" busca="modulos/agendamento/agenda_diaria/busca_cliente2.php?acao=plano_saude,@r1,@r0-value>plano_saude_id|@r1-value>plano_saude,0" value="<?=$plano_saude->razao_social?>"/>
                <input type="hidden" name="plano_saude_id" id="plano_saude_id" value="<?=$registro->plano_saude_id?>" />
         </label>
         
          <label style="width:100px;">
                Data de Aquisição
                <input type="text" name="data_aquisicao_plano" id="data_aquisicao_plano" value="<?=DataUsaToBr($registro->plano_saude_data_aquisicao)?>" sonumero="1" mascara="__/__/____" calendario="1"/>
         </label>
         
         <label style="width:110px;">
                Valor do Funcionário
                <input type="text" name="valor_funcionario_plano" id="valor_funcionario_plano" value="<?=MoedaUsaToBr($registro->plano_saude_valor_funcionario)?>" sonumero="1" decimal="2"/>
         </label>
         
         <label style="width:100px;">
                Valor Dependente
                <input type="text" name="valor_dependente_plano" id="valor_dependente_plano" value="<?=MoedaUsaToBr($registro->plano_saude_valor_depenente)?>" sonumero="1" decimal="2"/>
         </label>
         
         <label style="width:100px;">
                Valor Descontado
                <input type="text" name="valor_descontado_plano" id="valor_descontado_plano" value="<?=MoedaUsaToBr($registro->plano_saude_valor_descontado)?>" sonumero="1" decimal="2"/>
         </label>
         <div style="clear:both"></div>
         <span style="color:#000">Dependentes cadastrados no plano de saúde, para adicionar novos dependentes, faça o cadastro do mesmo na aba dependentes.</span>
         <table  cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:100px;">Dependente</td>
                        <td style="width:50px;">Dt Nascimento</td>
                        <td style="width:50px;">Escolaridade</td>
                        <td style="width:50px;">Parentesco</td>
                        <td style="width:80px;">Plano de Saude</td>
                                            
                    </tr>
                 </thead>
                  <tbody>
         <?php
		 		$dependentes = mysql_query($t="SELECT * FROM  rh_funcionario_dependentes WHERE vkt_id='$vkt_id' AND funcionario_id='$id' AND plano_saude='sim'");
				
				while($dependente = @mysql_fetch_object($dependentes)){
		 ?>
         			<tr id_dependente="<?=$dependente->id?>">
                        <td style="width:100px;" class="edita_socio"><?=$dependente->nome?></td>
                        <td style="width:30px;"><?=DataUsaToBr($dependente->data_nascimento)?></td>
                        <td style="width:50px;"><?=$escolaridade[$dependente->escolaridade]?></td>
                        <td style="width:30px;"><?=$dependente->grau_parentesco?></td>
                        <td style="width:80px;"><?=ucwords($dependente->plano_saude)?></td>
                                  
                    </tr>
         <?php
				}
		 ?>
          </tbody>
  		</table>
        </div>
        </div>
        <input type="hidden" name="acao2" id="acao2" value="dados_sociais" />
        
        <input name="f_empresa_id" id="f_empresa_id" type="hidden" value="<?=$cliente_fornecedor->id?>" />
        <input name="id" type="hidden" value="<?=$registro->id?>" />
        
</fieldset>
	
<!--Fim dos fiels set-->


<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>

<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_documentos" enctype="multipart/form-data" target="carregador" style="display:none;">
    <fieldset>
		<legend>
			  <a class="link_form">Dados</a>
    		<a class="link_form">PIS</a>
    		<a class="link_form">Dependentes</a>  
            <a class="link_form">Social</a>  		
			<a class="link_form"><strong>Documentos</strong></a>
            <a class="link_form">Contrato</a>
            <a class="link_form">Avaliação</a>
        </legend>
        
        <label style="width:300px;">
        		Descriçao
                <input type="text" name="documento_descricao" id="documento_descricao" />
        </label>
        
        <label style="width:300px;">
        		Arquivo
                <input type="file" name="documento_arquivo" id="documento_arquivo" />
        </label>
        
        <input type="button"  id="adicionar_documento" value="Adicionar Documento" style="margin-top:17px;"/>
        
        <div style="clear:both"></div>
        <div id='dados_documentos'>
         <?
            require_once('tabela_documentos.php'); 
		?>
        </div>
        <input type="hidden" name="acao2" id="acao2" value="documento" />
        
        <input name="id" type="hidden" value="<?=$registro->id?>" />
        
</fieldset>
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>


<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_contrato" enctype="multipart/form-data" target="carregador" style="display:none;">
    <fieldset>
		<legend>
			  <a class="link_form">Dados</a>
    		<a class="link_form">PIS</a>
    		<a class="link_form">Dependentes</a>  
            <a class="link_form">Social</a>  		
			<a class="link_form">Documentos</a>
            <a class="link_form"><strong>Contrato</strong></a>
            <a class="link_form">Avaliação</a>
        </legend>
        <div style="max-height:450px;overflow:auto;">
        <div id="form_contrato">         
            <label style="width:200px;">
        	Modelo de Contrato:
			<select name="modelo_id" id="modelo_id">
            	<option value=''></option>
				<?php
					$modelos = mysql_query($t="SELECT * FROM odontologo_contrato_modelo WHERE vkt_id = '$vkt_id'"); 
					//alert($contrato->contrato_modelo_id);
					while($modelo = mysql_fetch_object($modelos)){
						if($modelo->id == $contrato->contrato_modelo_id){
							$selected="selected='selected'";
						}
						echo "<option value='$modelo->id' $selected>$modelo->nome</option>";
						$selected='';
					}
				?>
            </select>
		</label >
        
        <!--<label style="width:200px;">
        <?php
			$cliente = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id = '$contrato->cliente_id' AND cliente_vekttor_id='$vkt_id'"));
		//alert($t);
		?>
        	Cliente:
			<input type='text' name="cliente" id="cliente" value="<?=$cliente->razao_social?>" retorno="focus|Digite o Cliente" valida_minlength='3' busca='modulos/odonto/contrato/busca_cliente.php,@r1,@r0-value>cliente_id|@r1-value>cliente,0'>
            <input type='hidden' name="cliente_id" id="cliente_id" value="<?=$contrato->cliente_id?>">
		</label >
        
        <label style="width:200px;">
        	Descriçao:
			<input type='text' name="nome" id="nome" value="<?=$contrato->nome?>">
		</label >-->
               
           
                <div style="clear:both"></div>
                 <div style="clear:both"></div>
         
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
<div style="float:right;margin-right:210px;">
<!--<button type="button" style="margin-top:2px; "  title="Imprime este contrato" id="salvar_contrato">
	<img src="modulos/odonto/atendimento/img/save.png" height="17"/>
</button>-->
			
</div>
<div style="clear:both"></div>
<div id="texto">
 <label style="display:none">
		<textarea name="texto" cols="25" rows="29" id="tx_html"  >
		<?php
			echo $registro->contrato;
		?>



        </textarea>
              </label >

       <iframe id='ed' name='ed' width="75%" style="height:400px; background:#FFF;  overflow:scroll;float:left" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0"class="edtx"></iframe>
</div>
        
        
        
        
           <div id="esquerda" style="float:right;overflow:auto">
        	
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cpf_cnpj</strong></a>
            <div style="clear:both"></div>
            <!--<a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_rg</strong></a>-->
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_nome</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_ctps</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_ctps_serie</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_ctps_uf</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cbo</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_remuneracao</strong></a>
                        
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_hr_inicio</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_hr_fim</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cargo</strong></a>
            <div style="clear:both"></div>
            <!--<a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_duracao</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cnpj</strong></a>-->
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_endereco</strong></a>
            <div style="clear:both"></div>
            <!--<a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_nomecontato</strong></a>-->
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cpf</strong></a>
            <div style="clear:both"></div>
              <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_rg</strong></a>
            <div style="clear:both"></div>
            <!--<a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@valor_mensalidade</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@valor_implantacao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@dia_implantacao</strong></a>
            <div style="clear:both"></div>-->
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@data_admissao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@data_atual</strong></a>
            <div style="clear:both"></div>
            <!--<a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@data_termino_contrato</strong></a>-->
        </div>
        
       
        	
         </div>
         
                <!--<table cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:200px;">Cliente</td>
                        <td style="width:400px;">Descricao</td>
                        <td style="width:60px;">Imprimir</td>
                        <td align="center">Editar</td>                        
                    </tr>
                 </thead>
                 </table>-->
                 <div style="max-height:65px;overflow:auto">
                 <!--<table id="dados_contratos" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                 <?php
				 	//$atestados = mysql_query($t="SELECT * FROM odontologo_atestados WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id' AND odontologo_atendimento_id = $atendimento_id");
					//echo $t;
					//while($atestado = @mysql_fetch_object($atestados)){
					$contratos = mysql_query($t="SELECT * FROM rh_ WHERE cliente_id='".$cliente_fornecedor->id."'"); 	
				 	while($contrato = mysql_fetch_object($contratos)){
				 ?>
                 	<tr id_contrato="<?=$contrato->id?>">
                        <td style="width:200px;"><?=$cliente_fornecedor->razao_social?></td>
                        <td style="width:400px;"><?=$contrato->nome?></td>
                        <td style="width:60px;" align="center"><button type="button" class="print_contrato" style="margin-top:2px; "  title="Imprime este contrato">
	<img src="../fontes/img/imprimir.png" />
</button></td>    
                        <td align="center"><button type="button" class="editar_contrato" style="margin-top:2px; "  title="Imprime este contrato">
	<img src="modulos/odonto/atendimento/img/edit.png" height="17"/>
</button></td>      
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
                </table>-->
                </div>
                <input name="salva_formulario_contrato" type="hidden" value="interno" />
                 <input name="id" type="hidden" value="<?=$registro->id?>" />
                 <div style="clear:both"></div>
              
			<input type="button" value="Imprimir Contrato" id="imprimir_contrato"/> 
            </div>                       
		</fieldset>      
        
        
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	
	<!--<input name="action" type="submit"  value="Salvar" style="float:right"  />-->
    <input name="action" type="button" id='botao_salvar' onclick="html_to_form('ed','tx_html'); setTimeout('document.getElementById(\'form_contrato\').submit();',500)"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_avaliacao" enctype="multipart/form-data" target="carregador" style="display:none;">
    <fieldset>
	  <legend>
			<a class="link_form">Dados</a>
    		<a class="link_form">PIS</a>
    		<a class="link_form">Dependentes</a>  
            <a class="link_form">Social</a>  		
			<a class="link_form">Documentos</a>
            <a class="link_form">Contrato</a>
            <a class="link_form"><strong>Avaliação</strong></a>
        </legend>
        <?php
			$avaliacao_experiencia = mysql_fetch_object(mysql_query("SELECT * FROM funcionario_has_avaliacao WHERE funcionario_id='$registro->id' AND tipo_avaliacao='1'"));
		?>
        <label>
        	Tipo:
            <select name="tipo_avaliacao" id="tipo_avaliacao">
            	<option value="1">Experiência</option>
                <option value="2">Treinamento</option>
                <option value="3">Desligamento</option>
            </select>
        </label>
        <div style="clear:both"></div>
        <label style="width:600px;">
        	Avaliação
        	<textarea name="avaliacao" id="avaliacao" style="height:250px;"><?=$avaliacao_experiencia->avaliacao?></textarea>
        </label>
    	</fieldset>    
        <!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
        
        <input name="action" type="submit"  value="Salvar" style="float:right"  />
        <input name="acao2" type="hidden"  value="avaliacao" style="float:right"  />
        <input name="id" type="hidden" id="id"  value="<?=$registro->id?>" style="float:right"  />
		<input name="avaliacao_id" type="hidden" id="avaliacao_id"  value="<?=$avaliacao_experiencia->id?>" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
</div>
<script>top.openForm()</script>