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
             <a class="link_form">Documentos</a> 
             <a class="link_form">Contrato</a>    		
		</legend>
	<!--<div style="max-height:500px;overflow:auto;">-->	            			
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
				}else{
					$solteiro='selected="selected"';
				}
			?>
				<option value="Solteiro" <?=$solteiro?>>Solteiro</option>
				<option value="Casado" <?=$casado?>>Casado</option>
			</select>
		</label>
        <label style="width:90px;">
			Cor
			<input type="text" id='f_cor' name="f_cor" value="<?=$registro->cor?>" />
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

         <label style="width:100px;">
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
        
              <div style="clear:both; font-size:10px;"></div>


        <label style="width:90px; ">
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
			 <input type="text" id='f_carteira_profissional_numero' name="f_carteira_profissional_numero" value="<?=$registro->carteira_profissional_numero?>" maxlength="7"/>
		</label>	
        
        <label style="width:70px;">
			 Série
			<input type="text" id='f_carteira_profissional_serie' name="f_carteira_profissional_serie" value="<?=$registro->carteira_profissional_serie?>" maxlength="3"/>
		</label>
        
        <label style="width:25px;">
			UF
			<input type="text" id='f_carteira_profissional_estado_emissor' name="f_carteira_profissional_estado_emissor" value="<?=$registro->carteira_profissional_estado_emissor?>" />
		</label>
        
        <label style="width:86px; margin-left:0;" title="Data de Expediçao da CTPS">
			Data Expedição
			<input type="text" id='f_carteira_profissional_data_expedicao' name="f_carteira_profissional_data_expedicao" value="<?=DataUsaToBr($registro->carteira_profissional_data_expedicao)?>" style="width:75px" mascara="__/__/____" />
		</label>         
        <div style="clear:both"></div>

    
        
        
               
		
           
        <!--<label style="width:100px;">
			Naturalidade
			<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$registro->naturalidade?>" />
		</label>
        
        <label style="width:126px;">
			Nacionalidade
			<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$registro->nacionalidade?>" />
		</label>-->
        
        <label style="width:103px; margin-right:10px" title="Número da Carteira de Reservista">
			Carteira Reservista
			<input type="text" id='f_carteira_reservista' name="f_carteira_reservista" value="<?=$registro->carteira_reservista?>" style="width:80px" />
		</label>
        
        <label style="width:103px; margin-right:10px" title="Número da Carteira de Reservista">
			Categoria
			<input type="text" id='f_categoria' name="f_categoria" value="<?=$registro->categoria?>" style="width:80px" />
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
			<input type="text" id='f_email' name="f_email" value="<?=$registro->email?>"  retorno="focus|Digite o email corretamente" valida_minlength='3' />
		</label>
            
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
        
        <label style="width:100px;">
			CNPJ Sindicato
			<input type="text" id='f_cnpj_sindicato' name="f_cnpj_sindicato" value="<?=$registro->cnpj_sindicato?>" mascara="___.___.___-__" sonumero="1"/>
		</label>
        
        <label style="width:170px;">
			Pensão Alimentícia (%)(TRCT)
			<input type="text" id='f_pensao_alimenticia_trct' name="f_pensao_alimenticia_trct" value="<?=MoedaUsaToBr($registro->pensao_alimenticia_trct)?>" style="width:80px;" sonumero="1" decimal="2"/>
		</label>
        
        <label style="width:200px;">
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
        
        <label style="width:110px;">
			Vale Transporte (%)
			<input type="text" id='f_vale_transporte' name="f_vale_transporte" value="<?=MoedaUsaToBr($registro->vale_transporte)?>" style="width:80px;" sonumero="1" decimal="2"/>
		</label> 
        
		<div style="clear:both"></div>	
                
               	
		<label style="width:90px;" title="Tipo de Admissao">
			Tipo Admissao
			<input type="text" id='f_tipo_admissao' name="f_tipo_admissao" value="<?=$registro->tipo_admissao?>" />
		</label>
        
        <label style="width:80px;" title="Data da Admissao">
			Data Admissao
			<input type="text" id='f_data_admissao' name="f_data_admissao" value="<?=DataUsaToBr($registro->data_admissao)?>" calendario="1" mascara="__/__/____" sonumero="1"/>
		</label>
        
			
        <!--<input type="hidden" name="f_id" id="f_id" value="<?=$registro->f_id?>" />-->
        
        
        <label style="width:80px;" title="Classificação Brasileira de Ocupações" rel="tip">
        	CBO
            <input type="text" id='f_cbo' name="f_cbo" value="<?=$registro->cbo?>" busca='modulos/rh/funcionarios/busca_cargo.php?acao=cbo,@r1 @r3,@r1-value>f_cargo|@r2-value>f_salario|@r3-value>f_cbo,0' autocomplete="off"/>
        </label>
        <label style="width:100px;">
        	Cargo
         <input type="text" name="f_cargo" id="f_cargo" value="<?=$registro->cargo?>" busca='modulos/rh/funcionarios/busca_cargo.php?acao=cargo,@r1 @r3,@r1-value>f_cargo|@r2-value>f_salario|@r3-value>f_cbo,0' autocomplete="off"/>
         <input type="hidden" name="f_cargo_id" id="f_cargo_id" value="<?=$registro->cargo_id?>" />
        </label>
        <label style="width:80px;">
        	Salário
            <input type="text" id='f_salario' name="f_salario" value="<?=MoedaUsaToBr($registro->salario)?>" decimal="2" sonumero="1"/>
        </label>
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
        <div style="clear:both"></div>
        <label style="width:80px;" title="Número sequencial da empresa, caso não seja preenchida será cadastrada automaticamente" rel="tip">
        	N&ordm; Sequencial
            <input type="text" id='f_numero_sequencial_empresa' name="f_numero_sequencial_empresa" value="<?=$registro->numero_sequencial_empresa?>" sonumero="1"/>
        </label>
        <label style="width:100px;">
        	Livro
            <input type="text" id='f_livro' name="f_livro" value="<?=$registro->livro?>"/>
        </label>
               
               <div style="clear:both"></div>
        	
        	<input type="checkbox" name="vendedor" <? if($registro->vendedor=="s"){echo "checked=checked";} ?> />Este funcionário é um vendedor
<!--</div>-->        
	</fieldset>
    
    <fieldset id="dados_pis" style="display:none;">
		<legend>
			  <a class="link_form">Dados</a>
              <a class="link_form"><strong>PIS</strong></a>
    		  <a class="link_form">Dependentes</a>
             <a class="link_form">Documentos</a> 
             <a class="link_form">Contrato</a>    		
		</legend>
        
        <label style="width:80px;">
			PIS
			 
			  <input type="text" id='f_pis' name="f_pis" value="<?=$registro->pis?>" maxlength="11"/>
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
<input type="button" value="Ficha de Empregado 1" class="imprimir_relatorio"/>
<input type="button" value="Ficha de Empregado 2" class="imprimir_relatorio"  />
<input type="button" value="Imprimir PIS" class="imprimir_relatorio"  />
<input type="button" value="Termo de Opçao" class="imprimir_relatorio"/>
<input type="button" value="Termo de Transporte" class="imprimir_relatorio"/>
<input type="button" value="Atestado de Saúde" class="imprimir_relatorio"/>
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
            <a class="link_form">Documentos</a>
    		 <a class="link_form">Contrato</a>  		
		</legend>
        
        <label style="width:300px;">
        		Nome
                <input type="text" name="nome_dependente" id="nome_dependente" />
        </label>
        
        <label style="width:120px;">
        		Data de Nascimento
                <input type="text" name="data_nascimento_dependente" id="data_nascimento_dependente" calendario="1" sonumero="1" mascara="__/__/____"/>
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
        
        <input type="button"  id="adicionar_dependente" value="Adicionar Dependente" style="margin-top:17px;"/>
        
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

<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_documentos" enctype="multipart/form-data" target="carregador" style="display:none;">
    <fieldset>
		<legend>
			  <a class="link_form">Dados</a>
    		<a class="link_form">PIS</a>
    		<a class="link_form">Dependentes</a>    		
			<a class="link_form"><strong>Documentos</strong></a>
            <a class="link_form">Contrato</a>
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
			<a class="link_form">Documentos</a>
            <a class="link_form"><strong>Contrato</strong></a>
        </legend>
        
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
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cpf</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_rg</strong></a>
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
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@valor_implantacao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@dia_implantacao</strong></a>
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
		</fieldset>      
        
        
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	
	<!--<input name="action" type="submit"  value="Salvar" style="float:right"  />-->
    <input name="action" type="button" id='botao_salvar' onclick="html_to_form('ed','tx_html'); setTimeout('document.getElementById(\'form_contrato\').submit();',500)"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
</div>
<script>top.openForm()</script>