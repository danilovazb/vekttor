<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
if($_GET['aba']!=''){
	$aba=$_GET['aba'];
	if($aba!='cliente'){
		$aparece[$aba]="style='display:block;'";
		$desaparece_cliente="style='display:none'";
	}
}
$verifica_odonto=mysql_result(mysql_query($a="SELECT COUNT(id) FROM odontologo_odontologo WHERE vkt_id='$vkt_id' AND usuario_id='$usuario_id'"),0,0);

?>
<style>
#procedimentos_novos{}
#procedimentos_passados{}
</style>
<link href="../fontes/css/sis.css" rel="stylesheet" type="text/css" /><!-- -->

<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:850px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Atendimento</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" action="modulos/odonto/atendimento/recebe_acao.php" method="post" id='formulario_atendimento' enctype="multipart/form-data" target="carregador" autocomplete="off">
    <input type="hidden" name="id" id="id" value="<?=$id?>" />
    <input type="hidden" name="atendimento_id" id="atendimento_id" value="<?=$atendimento->id?>" />
    <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$cliente_fornecedor->id?>" />
    <input type="hidden" name="consulta_id" id="consulta_id" value="<?=$consulta->id?>" />
    <input type="hidden" name="cliente_razao_social" id="cliente_razao_social" value="<?=$cliente_fornecedor->razao_social?>" />
    <input type="hidden" name="action_aba" id="action_aba" value="" />
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
		<fieldset  id='campos_1' style="display:;" <?=$desaparece_cliente?> >
				<legend style="float:left;">
                	<a onclick="aba_form(this,0);habilitaBotaoImpressao('fichacadastral')"><strong>Cliente</strong></a>
                    <a onclick="aba_form(this,1);atualizaAtendimento();habilitaBotaoImpressao('anamnese');">Anamnese</a>
                    <? if($verifica_odonto>0){ ?>
                    <a onclick="aba_form(this,2);atualizaAtendimento();habilitaBotaoImpressao('analise');atualizaProcedimentos()">Análise</a>
                    <a onclick="aba_form(this,3);atualizaAtendimento();atualizaProcedimentosAprovados();habilitaBotaoImpressao('')">Consulta</a>
                    <? } ?>
                </legend>
                <legend style="float:right;">
                	<a onclick="aba_form(this,4);habilitaBotaoImpressao('')" >Histórico</a>
                    <a onclick="aba_form(this,5);habilitaBotaoImpressao('')">Exames</a>
                    <a onclick="aba_form(this,6);habilitaBotaoImpressao('')">Receituário</a>
                    <a onclick="aba_form(this,7);habilitaBotaoImpressao('')">Atestado</a>
                    <a onclick="aba_form(this,8);habilitaBotaoImpressao('')">Contrato</a>
                </legend>
				<div style="clear:both"></div>
               
           <div style="height:450px;overflow:auto">
           
                <label style="width:300px;">
                Nome
              <input name="internauta_id"  type="hidden" id="internauta_id" title='<?=$cliente_fornecedor->razao_social?>' value="<?=$cliente_fornecedor->internauta_id?>" />
			  <input name="razao_social" id="razao_social" value="<?=$cliente_fornecedor->razao_social?>" valida_minlength='3'retorno='focus|Digite o nome do Cliente' busca='modulos/odonto/buscas/busca_clientes.php,@r0 @r2,@r1-value>internauta_id|@r0-title>internauta_id|@r3-value>ramo_atividade|@r2-value>cnpj_cpf|@r4-value>rg|@r5-value>local_emissao|@r6-value>data_emissao|@r7-value>nascimento|@r8-value>naturalidade|@r9-value>nacionalidade|@r10-value>email|@r11-value>telefone1|@r12-value>telefone2|@r21-value>cliente_id,0' autocomplete="off">
              
              </label>
            <label style="width:300px;">
				Ramo de Atividade
				<input type="text" id='ramo_atividade' name="ramo_atividade" value="<?=$cliente_fornecedor->ramo_atividade?>" />
			</label>
                <? 			
			if(!empty($cliente_fornecedor->extensao)){?>
            <div style="position:absolute;width:200px;height:165px;margin-left:630px;" class="div_foto_cliente">
            	<div>Foto</div>
                <div style="width:200px;height:130px;overflow:hidden;">
                	<img id="foto" width="120" src="<?="modulos/administrativo/clientes/fotos_clientes/".$cliente_fornecedor->id.".".$cliente_fornecedor->extensao?>">
            	</div>	
            	
           	 	<div style="clear:both"></div>
            	<a href="#" class="remover_foto">Remover Foto</a>
				<input type="hidden" name="extensao" id="extensao" value="<?=$cliente_fornecedor->extensao?>"/>
            </div>
            <? }?>  
			<label style="width:140px;">
				CPF
				<input type="text" id='cnpj_cpf' name="cnpj_cpf" value="<?=$cliente_fornecedor->cnpj_cpf?>" mascara="___.___.___-__" sonumero='1' retorno='focus|Coloque o CPF corretamente!' />
			</label>
			<label style="width:140px;">
				RG
				<input type="text" id='rg' name="rg" value="<?=$cliente_fornecedor->rg?>"  sonumero='1' retorno='focus|Coloque o RG corretamente!' />
			</label>
			<label style="width:140px;margin-left:5px;">
				Local de Emissão
				<input type="text" id='local_emissao' name="local_emissao" value="<?=$cliente_fornecedor->local_emissao?>" />
			</label>
			<label style="width:140px; ">
				Data Emissao
				<input type="text" mascara='__/__/____' id='data_emissao' name="data_emissao" value="<?=dataUsaToBr($cliente_fornecedor->data_emissao)?>" />
			</label>
            <div style="clear:both"></div>
            <label style="width:140px;">
				Data Nascimento
				<input type="text" mascara='__/__/____' id='nascimento' name="nascimento" value="<?=dataUsaToBr($cliente_fornecedor->nascimento)?>" />
			</label>
            <label style="width:140px;">
				Naturalidade
				<input type="text" id='naturalidade' name="naturalidade" value="<?=$cliente_fornecedor->naturalidade?>" />
			</label>
            <label style="width:140px;margin-left:5px;">
				Nacionalidade
				<input type="text" id='nacionalidade' name="nacionalidade" value="<?=$cliente_fornecedor->nacionalidade?>" />
			</label>
             <label style="width:140px;margin-left:5px;">
				Estado Civil
				<select name="estado_civil" onchange="exibeConjugue()">
				<?
					if($cliente->estado_civil=="Casado"){
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
            <label style="width:300px;">
				Email
				<input type="text" id='email' name="email" value="<?=$cliente_fornecedor->email?>"  retorno='focus|Coloque o email corretamente!' />
			</label>
			<label style="width:140px; margin-left:5px;">
				Telefone 1
				<input type="text" id='telefone1' name="telefone1" value="<?=$cliente_fornecedor->telefone1?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:135px;">
				Telefone 2
				<input type="text" id='telefone2' name="telefone2" value="<?=$cliente_fornecedor->telefone2?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="fax" value="<?=$cliente_fornecedor->fax?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cep
				<input autocomplete="off" type="text" id='f_cep' name="cep" value="<?=$cliente_fornecedor->cep?>" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/administrativo/clientes/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}"/>
			</label>
			<label style="width:295px;">
				Endereço
				<input type="text" id='f_endereco' name="endereco" value="<?=$cliente_fornecedor->endereco?>" />
			</label>
			<label style="width:140px;">
				Bairro
				<input type="text" id='f_bairro' name="bairro" value="<?=$cliente_fornecedor->bairro?>" />
			</label>
			<label style="width:140px;">
				Cidade
				<input type="text" id='f_cidade' name="cidade" value="<?=$cliente_fornecedor->cidade?>" />
			</label>
			<label style="width:140px;">
				Estado
				<input type="text" id='f_estado' name="estado" value="<?=$cliente_fornecedor->estado?>" />
			</label>
			<label style="width:140px;">
				Limite
				<input type="text" id='f_limite' name="limite" value="<?=moedaUsaToBr($cliente_fornecedor->limite)?>" decimal='2'/>
			</label>
            <label style="width:290px; margin-right:23px;">
				Endereco Comercial
				<input type="text" id='f_endereco_comercial' name="endereco_comercial" value="<?=$cliente_fornecedor->endereco_comercial?>" />
			</label>
			<label style="width:140px;">
				Telefone Comercial
				<input type="text" id='f_telefone_comercial' name="telefone_comercial" value="<?=$cliente_fornecedor->telefone_comercial?>" mascara="(__)____-____" sonumero='1' />
			</label>
            <label style="width:140px;">
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
			<div id="dados_conjugue" style="display:<?=$display?>">
            
			<label style="width:294px; margin-right:23px;">
				Nome - Conjugue
				<input type="text" id='f_conjugue_nome' name="conjugue_nome" value="<?=$cliente_fornecedor->conjugue_nome?>" />
			</label>
             <label style="width:175px; margin-right:22px;">
				Data de Nascimento - Conjugue
				<input type="text" id='f_conjugue_data_nascimento' name="conjugue_data_nascimento" value="<?=DataUsaToBr($cliente_fornecedor->conjugue_data_nascimento)?>" mascara='__/__/____' sonumero='1'/>
			</label>
			<label style="width:294px;">
				Ramo de Atividade - Conjugue
				<input type="text" id='f_conjugue_ramo_atividade' name="conjugue_ramo_atividade" value="<?=$cliente_fornecedor->conjugue_ramo_atividade?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				CPF - Conjugue
				<input type="text" id='f_conjugue_cpf' name="conjugue_cpf" value="<?=$cliente_fornecedor->conjugue_cpf?>" mascara="___.___.___-__" sonumero='1' retorno='focus|Coloque o CPF corretamente!' />
			</label>
			<label style="width:136px; margin-right:22px;">
				RG - Conjugue
				<input type="text" id='f_conjugue_rg' name="conjugue_rg" value="<?=$cliente_fornecedor->conjugue_rg?>" retorno='focus|Coloque o RG corretamente!' />
			</label>
			<label style="width:136px; margin-right:22px;" title='Local de emissao RG do Conjugue'>
				Local Emissao RG.
				<input type="text" id='f_conjugue_local_emissao' name="conjugue_local_emissao" value="<?=$cliente_fornecedor->conjugue_local_emissao?>" />
			</label>
            <label style="width:155px; margin-right:22px;">
				Data da Emissao - Conjugue
				<input type="text" id='f_conjugue_data_emissao' name="conjugue_data_emissao" value="<?=DataUsaToBr($cliente_fornecedor->conjugue_data_emissao)?>" mascara='__/__/____'/>
			</label>
            <label style="width:130px; margin-right:22px;">
				Telefone - Conjugue
				<input type="text" id='f_conjugue_telefone' name="conjugue_telefone" value="<?=$cliente_fornecedor->conjugue_telefone?>" mascara="(__)____-____" sonumero='1'/>
			</label>
            <label style="width:136px; margin-right:22px;">
				E-mail - Conjugue
				<input type="text" id='f_conjugue_email' name="conjugue_email" value="<?=$cliente_fornecedor->conjugue_email?>"/>
			</label>
            <label style="width:150px;">
				Naturalidade - Conjugue
				<input type="text" id='f_conjugue_naturalidade' name="conjugue_naturalidade" value="<?=$cliente_fornecedor->conjugue_naturalidade?>" />
			</label>
            <label style="width:150px;">
				Nacionalidade - Conjugue
				<input type="text" id='f_conjugue_nacionalidade' name="conjugue_nacionalidade" value="<?=$cliente_fornecedor->conjugue_nacionalidade?>" />
			</label>
            <label style="width:294px; margin-right:23px;">
				Endereco Comercial - Conjugue
				<input type="text" id='f_endereco_comercial_conjugue' name="endereco_comercial_conjugue" value="<?=$cliente_fornecedor->conjugue_endereco_comercial?>" />
			</label>
			<label style="width:170px;">
				Telefone Comercial - Conjugue
				<input type="text" id='f_telefone_comercial_conjugue' name="telefone_comercial_conjugue" value="<?=$cliente_fornecedor->conjugue_telefone_comercial?>" mascara="(__)____-____" sonumero='1' />
			</label>
            </div>
              
                <div style="clear:both"></div>
                
                <label style="width:300px;">
                Convenio
            	<input name="convenio_id"  type="hidden" id="convenio_id" value="<?=$convenio->id?>" />

			  <input name="convenio" id="convenio" value="<?=$convenio->razao_social?>" busca='modulos/odonto/buscas/busca_convenio.php,@r0,@r1-value>convenio_id|@r0-title>convenio,0' autocomplete="off">
              </label>
              	 <label style="width:100px;">
                N&deg; Segurado
            	<input name="numero_segurado"  type="text" id="numero_segurado" value="<?=$atendimento->numero_segurado?>" />
			   </label>
                <label style="width:300px;">
                Indicaçao
            	<input type="text" name="indicacao" id="indicacao" value="<?=$atendimento->indicacao?>"/>
		     </label>
             
               <div style="clear:both"></div>
           
               <div style="clear:both"></div>
             <label style="width:250px;">
                Foto
            	<input name="foto_cliente"  type="file" id="foto_cliente" value="<?=$atendimento->extensao?>" />
			</label>
            <? if(!$verifica_fila){ ?>
            <div class="divisao_options" style="float: left; width: 180px; display: block; clear: none; margin-top: 15px; margin-left: 25px;">
             <div style="float:left; width:180px;">
             
             <label style="margin-bottom:5px;">
             	Enviar para fila de espera
                <input type="radio" name="fila_espera" value="Em espera" />
             </label>
             
             
             <label style="margin-bottom:0px;">
             	Enviar para atendimento
                <input type="radio" name="fila_espera" value="Em atendimento" />
             </label>
             
             
             
             
             </div>
             </div>   
          <label style="margin-top:10px;"> 
                <select name="agenda_id" id="agenda_id" <?=$disabled?> valida_minlength='1' retorno='focus|Selecione uma Agenda'>
    					<option value='0'>Agenda</option>
						<?php
							$agendas = mysql_query("SELECT * FROM agenda WHERE usuario_id = '$usuario_id' AND vkt_id='$vkt_id'");
							while($agenda = mysql_fetch_object($agendas)){
							  if($agenda->id==$fila->agenda_id){
								  $selected="selected='selected'";
							  }
							  echo "<option value='$agenda->id' $selected>$agenda->nome</option>";
							  $selected='';
							}
						?>
    			</select>
                </label>
            
              <? }?>
            
              </div>    
		</fieldset>
        <fieldset  id='campos_2' style="display:none;" <?=$aparece['anamnese']?> >
				<legend style="float:left;">
                	<a onclick="aba_form(this,0);atualizaAtendimento();habilitaBotaoImpressao('fichacadastral')">Cliente</a>
                    <a onclick="aba_form(this,1);habilitaBotaoImpressao('anamnese')"><strong>Anamnese</strong></a>
                    <? if($verifica_odonto>0){ ?>
                    <a onclick="aba_form(this,2);habilitaBotaoImpressao('analise');atualizaProcedimentos()">Análise</a>
                    <a onclick="aba_form(this,3);atualizaAtendimento();atualizaProcedimentosAprovados();habilitaBotaoImpressao('')">Consulta</a>
                    <? } ?>
                </legend>
                <legend style="float:right;">
                	<a onclick="aba_form(this,4);habilitaBotaoImpressao('')" >Histórico</a>
                    <a onclick="aba_form(this,5);habilitaBotaoImpressao('')">Exames</a>
                    <a onclick="aba_form(this,6);habilitaBotaoImpressao('')">Receituário</a>
                    <a onclick="aba_form(this,7);habilitaBotaoImpressao('')">Atestado</a>
                    <a onclick="aba_form(this,8);habilitaBotaoImpressao('')">Contrato</a>
                </legend>
				<div style="clear:both; height:5px;"></div>
                <label style="width:300px;">                
                	<b>Cliente:</b> <?=$cliente_fornecedor->nome_fantasia?>
                </label>
                <div style="clear:both"></div>
                <div style="height:400px; overflow:auto;">
                <!--<label style="width:550px;">Pergunta
                	<input type="text" name="pergunta1" id="pergunta1" value="<?=$atendimento->pergunta1?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta1" cols="60"><?=$atendimento->resposta1?></textarea>
                </label>
                <div style="clear:both"></div>
                <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta2" id="pergunta2" value="<?=$atendimento->pergunta2?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta2" cols="60"><?=$atendimento->resposta2?></textarea>
                </label>
                <div style="clear:both"></div>
                <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta3" id="pergunta3" value="<?=$atendimento->pergunta3?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta3" cols="60"><?=$atendimento->resposta3?></textarea>
                </label>
                <div style="clear:both"></div>
               <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta4" id="pergunta4" value="<?=$atendimento->pergunta4?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta4" cols="60"><?=$atendimento->resposta4?></textarea>
                </label>
                <div style="clear:both"></div>
                <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta5" id="pergunta5" value="<?=$atendimento->pergunta5?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta5" cols="60"><?=$atendimento->resposta5?></textarea>
                </label>
                <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta6" id="pergunta6" value="<?=$atendimento->pergunta6?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta6" cols="60"><?=$atendimento->resposta6?></textarea>
                </label>
                <div style="clear:both"></div>
               <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta7" id="pergunta7" <?=$atendimento->pergunta7?>>
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta7" cols="60"><?=$atendimento->resposta7?></textarea>
                </label>
                <div style="clear:both"></div>
              <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta8" id="pergunta8" value="<?=$atendimento->pergunta8?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta8" cols="60"><?=$atendimento->resposta8?></textarea>
                </label>
                <div style="clear:both"></div>
            <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta9" id="pergunta9" value="<?=$atendimento->pergunta9?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta9" cols="60"><?=$atendimento->resposta9?></textarea>
                </label>
                <div style="clear:both"></div>
               <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta10" id="pergunta10" value="<?=$atendimento->pergunta10?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta10" cols="60"><?=$atendimento->resposta10?></textarea>
                </label>
              <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta11" id="pergunta11" value="<?=$atendimento->pergunta11?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta11" cols="60"><?=$atendimento->resposta11?></textarea>
                </label>
                <div style="clear:both"></div>
                <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta12" id="pergunta12" value="<?=$atendimento->pergunta12?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta12" cols="60"><?=$atendimento->resposta12?></textarea>
                </label>
                <div style="clear:both"></div>
                <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta13" id="pergunta13" value="<?=$atendimento->pergunta13?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta13" cols="60"><?=$atendimento->resposta13?></textarea>
                </label>
                <div style="clear:both"></div>
            <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta14" id="pergunta14" value="<?=$atendimento->pergunta14?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta14" cols="60"><?=$atendimento->resposta14?></textarea>
                </label>
                <div style="clear:both"></div>
                <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta15" id="pergunta15" value="<?=$atendimento->pergunta15?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta15" cols="60"><?=$atendimento->resposta15?></textarea>
                </label>
                <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta16" id="pergunta16" value="<?=$atendimento->pergunta16?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta16" cols="60"><?=$atendimento->resposta16?></textarea>
                </label>
                <div style="clear:both"></div>
                <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta17" id="pergunta17" value="<?=$atendimento->pergunta17?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta17" cols="60"><?=$atendimento->resposta17?></textarea>
                </label>
                <div style="clear:both"></div>
               <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta18" id="pergunta18" value="<?=$atendimento->pergunta18?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta18" cols="60"><?=$atendimento->resposta18?></textarea>
                </label>
                <div style="clear:both"></div>
               <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta19" id="pergunta19" vavalue="<?=$atendimento->pergunta19?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta19" cols="60"><?=$atendimento->resposta19?></textarea>
                </label>
                <div style="clear:both"></div>
               <label style="width:550px;">Pergunta
                	<input type="text" name="pergunta20" id="pergunta20" value="<?=$atendimento->pergunta20?>">
                </label>
                <div style="clear:both"></div>
                <label>Resposta
                	<textarea name="resposta20" cols="60"><?=$atendimento->resposta20?></textarea>
                </label>-->
                
                <div style="background-color:#FFF;width:100%;height:20px;text-align:center;margin-bottom:3%;">INQUÉRITO DE SAÚDE</div>
                <div style="float:left">
                <div class="nome_doenca">Est&aacute; em tratamento médico ? </div>	<input type="radio" name="anamnese_tratamento_medico" value="n" <? if(empty($atendimento->anamnese_tratamento_medico)||$atendimento->anamnese_tratamento_medico=='n'){ echo "checked='checked'";} echo $checked?>>N&atilde;o
                <input type="radio" name="anamnese_tratamento_medico" value="s" <? if($atendimento->anamnese_tratamento_medico=='s'){ echo "checked='checked'";}?>>Sim
                </div>    
                <label style="width:300px;margin-left:10px;">
                	<input type="text" name="anamnese_obs_tratamento_medico" id="anamnese_obs_tratamento_medico" value="<?php echo $atendimento->anamnese_obs_tratamento_medico?>">
                </label>
                <div style="clear:both"></div>
                <div style="float:left">
                	<div class="nome_doenca">Está usando medica&ccedil;&atilde;o ? 	</div><input type="radio" name="anamnese_medicacao" value="n" <? if(empty($atendimento->anamnese_medicacao)||$atendimento->anamnese_medicacao=='n'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_medicacao" value="s" <? if($atendimento->anamnese_medicacao=='s'){ echo "checked='checked'";}?>>Sim
                </div>    
                <label style="width:300px;margin-left:10px;">
                	<input type="text" name="anamnese_obs_medicacao" id="anamnese_obs_medicacao" value="<? echo $atendimento->anamnese_obs_medicacao?>">
                </label>
                <div style="clear:both"></div>
                <div style="float:left">
                	<div class="nome_doenca">Alergia ?</div><input type="radio" name="anamnese_alergia" value="n" <? if(empty($atendimento->anamnese_alergia)||$atendimento->anamnese_alergia=='n'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_alergia" value="s" <? if($atendimento->anamnese_alergia=='s'){ echo "checked='checked'";}?>>Sim
                </div>    
                <label style="width:300px;margin-left:10px;">
                	<input type="text" name="anamnese_obs_alergia" id="anamnese_obs_alergia" value="<? echo $atendimento->anamnese_obs_alergia?>">
                </label>
                
               <div style="clear:both"></div>
               <div style="background-color:#FFF;width:100%;height:20px;text-align:center;margin-top:3%;margin-bottom:3%;">DOENÇAS</div>
               
               <div class="doenca">
                <div class="nome_doenca">Anemia ?</div><input type="radio" name="anamnese_anemia" value="n" <? if(empty($atendimento->anamnese_anemia)||$atendimento->anamnese_anemia=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_anemia" value="s" <? if($atendimento->anamnese_anemia=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_anemia" value="ns" <? if($atendimento->anamnese_anemia=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div> 
                                                   
                
                
                <div class="doenca ">
                <div class="nome_doenca">Hepatite ?</div><input type="radio" name="anamnese_hepatite" value="n" <? if(empty($atendimento->anamnese_hepatite)||$atendimento->anamnese_hepatite=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_hepatite" value="s" <? if($atendimento->anamnese_hepatite=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_hepatite" value="ns" <? if($atendimento->anamnese_hepatite=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca">
                <div class="nome_doenca">Sífilis ? </div><input type="radio" name="anamnese_sifilis" value="n" <? if(empty($atendimento->anamnese_sifilis)||$atendimento->anamnese_sifilis=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_sifilis" value="s" <? if($atendimento->anamnese_sifilis=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_sifilis" value="ns" <? if($atendimento->anamnese_sifilis=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca">
                <div class="nome_doenca">HIV ?</div><input type="radio" name="anamnese_hiv" value="n" <? if(empty($atendimento->anamnese_hiv)||$atendimento->anamnese_hiv=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_hiv" value="s" <? if($atendimento->anamnese_hiv=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_hiv" value="ns" <? if($atendimento->anamnese_hiv=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>
                
                <div class="doenca">
                <div class="nome_doenca">Tuberculose ? </div><input type="radio" name="anamnese_tuberculose" value="n" <? if(empty($atendimento->anamnese_tuberculose)||$atendimento->anamnese_tuberculose=='n'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_tuberculose" value="s" <? if($atendimento->anamnese_tuberculose=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_tuberculose" value="ns" <? if($atendimento->anamnese_tuberculose=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                    
                <div class="doenca">
               <div class="nome_doenca"> Asma ? </div><input type="radio" name="anamnese_asma" value="n" <? if(empty($atendimento->anamnese_asma)||$atendimento->anamnese_asma=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_asma" value="s" <? if($atendimento->anamnese_asma=='s'){ echo "checked='checked'";} ?>>Sim
                <input type="radio" name="anamnese_asma" value="ns" <? if($atendimento->anamnese_asma=='ns'){ echo "checked='checked'";} ?>>Não Sei
                </div>    
                
                <div class="doenca">
                <div class="nome_doenca">Fumante ?</div><input type="radio" name="anamnese_fumante" value="n" <? if(empty($atendimento->anamnese_fumante)||$atendimento->anamnese_fumante=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_fumante" value="s" <? if($atendimento->anamnese_fumante=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_fumante" value="ns" <? if($atendimento->anamnese_fumante=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
               
                <div class="doenca">
                <div class="nome_doenca">Hormônio ? 	</div><input type="radio" name="anamnese_hormonio" value="n" <? if($atendimento->anamnese_hormonio==''||$atendimento->anamnese_hormonio=='n'){ echo "checked='checked'";} ?> />N&atilde;o
                <input type="radio" name="anamnese_hormonio" value="s" <? if($atendimento->anamnese_hormonio=='s'){ echo "checked='checked'";}?> />Sim
                <input type="radio" name="anamnese_hormonio" value="ns" <? if($atendimento->anamnese_hormonio=='ns'){ echo "checked='checked'";}?> />Não Sei
                </div>    
               
                <div class="doenca" >
                <div class="nome_doenca">Alcolista ? </div><input type="radio" name="anamnese_alcolista" value="n" <? if(empty($atendimento->anamnese_alcolista)||$atendimento->anamnese_alcolista=='n'){ echo "checked='checked'";} ?> >N&atilde;o
                <input type="radio" name="anamnese_alcolista" value="s" <? if($atendimento->anamnese_alcolista=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_alcolista" value="ns" <? if($atendimento->anamnese_alcolista=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
              
                <div class="doenca">
                <div class="nome_doenca">Tatuagem ? </div><input type="radio" name="anamnese_tatuagem" value="n" <? if(empty($atendimento->anamnese_tatuagem)||$atendimento->anamnese_tatuagem=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_tatuagem" value="s" <? if($atendimento->anamnese_tatuagem=='s'){ echo "checked='checked'";} ?>>Sim
                <input type="radio" name="anamnese_tatuagem" value="ns" <? if($atendimento->anamnese_tatuagem=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca" >
                <div class="nome_doenca">Herpes/Aftas ? </div>	<input type="radio" name="anamnese_herpes" value="n"  <? if(empty($atendimento->anamnese_herpes)||$atendimento->anamnese_herpes=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_herpes" value="s"  <? if($atendimento->anamnese_herpes=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_herpes" value="ns"  <? if($atendimento->anamnese_herpes=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca">
                <div class="nome_doenca">Gravidez ? 	</div><input type="radio" name="anamnese_gravidez" value="n" <? if(empty($atendimento->anamnese_gravidez)||$atendimento->anamnese_gravidez=='n'){ echo "checked='checked'";}?>>N&atilde;o
                <input type="radio" name="anamnese_gravidez" value="s" <? if($atendimento->anamnese_gravidez=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_gravidez" value="ns" <? if($atendimento->anamnese_gravidez=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca" >
                <div class="nome_doenca">Desmaio ? </div><input type="radio" name="anamnese_desmaio" value="n" <? if(empty($atendimento->anamnese_desmaio)||$atendimento->anamnese_desmaio=='n'){ echo "checked='checked'";}?>>N&atilde;o
                <input type="radio" name="anamnese_desmaio" value="s" <? if($atendimento->anamnese_desmaio=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_desmaio" value="ns" <? if($atendimento->anamnese_desmaio=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca">
                	<div class="nome_doenca">Febre Reumática ? </div>	<input type="radio" name="anamnese_febre_reumatica" value="n" <? if(empty($atendimento->anamnese_febre_reumatica)||$atendimento->anamnese_febre_reumatica=='n'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_febre_reumatica" value="s" <? if($atendimento->anamnese_febre_reumatica=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_febre_reumatica" value="ns" <? if($atendimento->anamnese_febre_reumatica=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca" >
                 	<div class="nome_doenca">Diabetes ? 	</div><input type="radio" name="anamnese_diabetes" value="n" <? if(empty($atendimento->anamnese_diabetes)||$atendimento->anamnese_diabetes=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_diabetes" value="s" <? if($atendimento->anamnese_diabetes=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_diabetes" value="ns" <? if($atendimento->anamnese_diabetes=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>
                
                <div class="doenca">
                <div class="nome_doenca">Epilepsia ? </div><input type="radio" name="anamnese_epilepsia" value="n" <? if(empty($atendimento->anamnese_epilepsia)||$atendimento->anamnese_epilepsia=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_epilepsia" value="s" <? if($atendimento->anamnese_epilepsia=='s'){ echo "checked='checked'";} ?>>Sim
                <input type="radio" name="anamnese_epilepsia" value="ns" <? if($atendimento->anamnese_epilepsia=='ns'){ echo "checked='checked'";} ?>>Não Sei
                </div>    
                
                <div class="doenca">
                	<div class="nome_doenca">Cicatrização Ruim ?</div><input type="radio" name="anamnese_cicatrizacao_ruim" value="n" <? if(empty($atendimento->anamnese_cicatrizacao_ruim)||$atendimento->anamnese_cicatrizacao_ruim=='n'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_cicatrizacao_ruim" value="s" <? if($atendimento->anamnese_febre_reumatica=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_cicatrizacao_ruim" value="ns" <? if($atendimento->anamnese_febre_reumatica=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
               
                <div class="doenca">
                	<div class="nome_doenca">Disturbios Psico ?</div><input type="radio" name="anamnese_disturbios_psico" value="n" <? if(empty($atendimento->anamnese_disturbios_psico)||$atendimento->anamnese_disturbios_psico=='n'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_disturbios_psico" value="s" <? if($atendimento->anamnese_disturbios_psico=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_disturbios_psico" value="ns" <? if($atendimento->anamnese_disturbios_psico=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca" >
                	<div class="nome_doenca">Endocardite Bact. ?</div><input type="radio" name="anamnese_endocardite_bact" value="n" <? if(empty($atendimento->anamnese_endocardite_bact)||$atendimento->anamnese_endocardite_bact=='n'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_endocardite_bact" value="s" <? if($atendimento->anamnese_endocardite_bact=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_endocardite_bact" value="ns" <? if($atendimento->anamnese_endocardite_bact=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca">
                	<div class="nome_doenca">Problema Hepático ? </div><input type="radio" name="anamnese_problema_hepatico" value="n" <? if($atendimento->anamnese_problema_hepatico==''||$atendimento->anamnese_problema_hepatico=='s'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_problema_hepatico" value="s" <? if($atendimento->anamnese_problema_hepatico=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_problema_hepatico" value="ns" <? if($atendimento->anamnese_problema_hepatico=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                  
                <div class="doenca">
                	<div class="nome_doenca">Problema Renal ?</div>	<input type="radio" name="anamnese_problema_renal" value="n" <? if(empty($atendimento->anamnese_problema_renal)||$atendimento->anamnese_problema_renal=='n'){ echo "checked='checked'";}?> />N&atilde;o
                <input type="radio" name="anamnese_problema_renal" value="s" <? if($atendimento->anamnese_problema_renal=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_problema_renal" value="ns" <? if($atendimento->anamnese_problema_renal=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca">
                	<div class="nome_doenca">Problema Cardíaco ?</div> 	<input type="radio" name="anamnese_problema_cardiaco" value="n" <? if(empty($atendimento->anamnese_problema_cardiaco)||$atendimento->anamnese_problema_cardiaco=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_problema_cardiaco" value="s" <? if($atendimento->anamnese_problema_cardiaco=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_problema_cardiaco" value="ns" <? if($atendimento->anamnese_problema_cardiaco=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca">
                	<div class="nome_doenca">Tensão Arterial ? 	</div><input type="radio" name="anamnese_tensao_arterial" value="n" <? if( empty($atendimento->anamnese_tensao_arterial)||$atendimento->anamnese_tensao_arterial=='n'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_tensao_arterial" value="s" <? if($atendimento->anamnese_tensao_arterial=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_tensao_arterial" value="ns" <? if($atendimento->anamnese_tensao_arterial=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca">
                	<div class="nome_doenca">Cirurgia ? </div>	<input type="radio" name="anamnese_cirurgia" value="n" <? if( empty($atendimento->anamnese_cirurgia)||$atendimento->anamnese_cirurgia=='n'){ echo "checked='checked'";} $checked?> />N&atilde;o
                <input type="radio" name="anamnese_cirurgia" value="s" <? if($atendimento->anamnese_cirurgia=='s'){ echo "checked='checked'";}?> />Sim
                <input type="radio" name="anamnese_cirurgia" value="ns" <? if($atendimento->anamnese_cirurgia=='ns'){ echo "checked='checked'";}?> />Não Sei
                </div>    
                
                <div class="doenca">
                 <div class="nome_doenca">Tumor ?</div><input type="radio" name="anamnese_tumor" value="n" <? if( empty($atendimento->tumor)||$atendimento->anamnese_tumor=='s'){ echo "checked='checked'";} $checked?>>N&atilde;o
                <input type="radio" name="anamnese_tumor" value="s" <? if($atendimento->anamnese_tumor=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_tumor" value="ns" <? if($atendimento->anamnese_tumor=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>
                
                <div class="doenca">
                	<div class="nome_doenca">Internação Hospital ? </div><input type="radio" name="anamnese_internacao_hospital" value="n" <? if(empty($atendimento->anamnese_internacao_hospital)||$atendimento->anamnese_internacacao_hospital=='n'){ echo "checked='checked'";}?> />N&atilde;o
                <input type="radio" name="anamnese_internacao_hospital" value="s" <? if($atendimento->anamnese_internacao_hospital=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_internacao_hospital" value="ns" <? if($atendimento->anamnese_internacao_hospital=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                
                <div class="doenca">
                	<div class="nome_doenca">Febre Reumática ? </div>	<input type="radio" name="anamnese_febre_reumatica2" value="n" <? if(empty($atendimento->anamnese_febre_reumatica2)||$atendimento->anamnese_febre_reumatica2=='n'){ echo "checked='checked'";} ?>>N&atilde;o
                <input type="radio" name="anamnese_febre_reumatica2" value="s" <? if($atendimento->anamnese_febre_reumatica2=='s'){ echo "checked='checked'";}?>>Sim
                <input type="radio" name="anamnese_febre_reumatica2" value="ns" <? if($atendimento->anamnese_febre_reumatica2=='ns'){ echo "checked='checked'";}?>>Não Sei
                </div>    
                <div style="clear:both"></div>
                <label style="width:90%;">
                	Possui alguma doença / problema siginificativo não mencionado ? 	
                	<input type="text"  name="anamnese_outra_doenca" id="anamnese_outra_doenca" value="<?=$atendimento->anamnese_outra_doenca?>"/>
                </label>
                <label style="width:90%;">
                	Observaçao	
                	<textarea  name="anamnese_observacao_geral" id="anamnese_observacao_geral"/><?=$atendimento->anamnese_observacao_geral?></textarea>
                </label>
          </div>
                
		</fieldset>
        <fieldset  id='campos_3' style="display:none; position:relative;" <?=$aparece['analise']?> >
        <!--------------- FORMULÁRIO EXTRA ------------------------------>
		        <div id="procedimento_novo_form" class="arrasta" style="position:absolute; display:none; width:200px;  margin-left:250px; background:#EDEDED; margin-top:48px;border:1px solid #BBBEC1; z-index:10">
                <div class='t3'></div>
                <div class='t1'></div>
                <div  class="dragme">
					<a class='f_x' onclick="this.parentNode.parentNode.style.display='none';fechaDente()"></a>
                    <span>Procedimentos</span>
                </div>
                <div id="conteudo_form">
                <span style="margin-left:5px;">Dente:</span> <span id="nome_dente"></span>
                <div style="clear:both;"></div>
                
                <span class="faces_dente"><input type="radio" name="face_id" class="face_dente" value="1" /> lingual/palatina</span><br />
                <span class="faces_dente"><input type="radio" name="face_id" class="face_dente" value="2" /> vestibular</span><br />
                <span class="faces_dente"><input type="radio" name="face_id" class="face_dente" value="3" /> mesial</span><br />
                <span class="faces_dente"><input type="radio" name="face_id" class="face_dente" value="4" /> distal</span><br />
                <span class="faces_dente"><input type="radio" name="face_id" class="face_dente" value="5" /> oclusal/incisal</span><br />
                <label style="margin-left:5px; margin-top:5px;">
                Procedimento
                <input autocomplete="off" name="procedimento" id="procedimento" onkeypress="if(this.value=='')document.getElementById('procedimento_id').value=''" busca='modulos/odonto/buscas/busca_procedimento.php,@r0,@r1-value>procedimento_id|@r0-title>procedimento|@r2-value>procedimento_valor,0' >
                <input id="procedimento_id" name="procedimento_id" type="hidden" />
                <input id="procedimento_valor" name="procedimento_valor" type="hidden" />
                </label>
                <label style="margin-left:5px; ">
                obs
                <input type="text" name="obs_procedimento" id="obs_procedimento" />
                </label>
                <div style="height:1px; width:200px; float:left; margin:0 auto; background:black;"></div>
                <label style="margin-left:5px; margin-top:5px;">
                Procedimentos passados
                <input autocomplete="off" name="procedimento_passado" id="procedimento_passado" onkeypress="if(this.value=='')document.getElementById('procedimento_passado_id').value=''" value="" busca='modulos/odonto/buscas/busca_procedimento.php,@r0,@r1-value>procedimento_passado_id|@r0-title>procedimento_passado,0' >
                <input name="procedimento_passado_id" id="procedimento_passado_id" type="hidden" />
                </label>
                <label style="margin-left:5px; ">
                obs
                <input type="text" name="obs_procedimento_passado" id="obs_procedimento_passado" />
                </label>
                <input type="hidden" name="dente_id" id="dente_id" value="" />
                <input type="hidden" name="analise_id" id="analise_id" value="" />
                <input type="button" name="action" value="Incluir Análise" onclick="incluirAnalise();" style="float:right; margin:5px;" />
                </div>
                </div>
                <div id="edita_procedimento_form" style="position:absolute; display:none; width:200px;  margin-left:250px; background:#EDEDED; z-index:10; margin-top:48px;border:1px solid #BBBEC1">
                <div class='t3'></div>
                <div class='t1'></div>
                <div  class="dragme">
					<a class='f_x' onclick="this.parentNode.parentNode.style.display='none';fechaDente()"></a>
                    <span>Editar Procedimento</span>
                </div>
                <span style="margin-left:5px;">Dente:</span>
                <span id="nome_dente_editado"></span>
                <div style="clear:both;"></div>
                <label style="margin-left:5px; margin-top:5px;">
                Procedimento
                <input autocomplete="off" name="procedimento_editavel" id="procedimento_editavel" onkeypress="if(this.value=='')document.getElementById('procedimento_editavel_id').value=''" 
                busca='modulos/odonto/buscas/busca_procedimento.php,@r0,@r1-value>procedimento_editavel_id|@r0-title>procedimento_editavel|@r2-value>procedimento_valor,0' >
                <input id="procedimento_editavel_id" name="procedimento_editavel_id" type="hidden" />
                </label>
                <label style="margin-left:5px; ">
                obs
                <input type="text" name="obs_procedimento_editavel" id="obs_procedimento_editavel" />
                </label>
                <input type="hidden" name="procedimento_editavel_item_id" id="procedimento_editavel_item_id" value="" />
                <input type="hidden" id="tipo_procedimento" name="tipo_procedimento" />
                <input type="hidden" id="dente_id_editavel" name="dente_id_editavel" />
                <input type="button" name="action" value="Editar Análise" onclick="editarAnalise()" style="float:right; margin:5px;" />
                <input type="button" value="Retirar" onclick="excluirAnalise();" style="float:left; margin:5px;" />
                </div>
        <!-- fim formularios extras -->
				<legend style="float:left;">
                	<a onclick="aba_form(this,0);habilitaBotaoImpressao('fichacadastral')">Cliente</a>
                    <a onclick="aba_form(this,1);habilitaBotaoImpressao('anamnese')">Anamnese</a>
                    <? if($verifica_odonto>0){ ?>
                    <a onclick="aba_form(this,2);habilitaBotaoImpressao('analise')"><strong>Análise</strong></a>
                    <a onclick="aba_form(this,3);atualizaProcedimentosAprovados();habilitaBotaoImpressao('')">Consulta</a>
                    <? }?>
                </legend>
                <legend style="float:right;">
                	<a onclick="aba_form(this,4);habilitaBotaoImpressao('')" >Histórico</a>
                    <a onclick="aba_form(this,5);habilitaBotaoImpressao('')">Exames</a>
                    <a onclick="aba_form(this,6);habilitaBotaoImpressao('')">Receituário</a>
                    <a onclick="aba_form(this,7);habilitaBotaoImpressao('')">Atestado</a>
                    <a onclick="aba_form(this,8);habilitaBotaoImpressao('')">Contrato</a>
                </legend>
				<div style="clear:both; height:5px;"></div>
                <label style="width:300px;">                
                <b>Cliente:</b> <?=$cliente_fornecedor->nome_fantasia?>
                </label>
                <div style="clear:both;"></div>
                <div id="arcada" style="width:450px; height:427px; float:left; background: url(../fontes/img/odontoboca.jpg) white no-repeat center  ; margin-bottom:5px; border:1px solid #999 ">
				<div dente_id="55" class="dente dente55" onclick="abreDente(55,'1/4 boca inferior direita')"></div>
                <div dente_id="54" class="dente dente54" onclick="abreDente(54,'1/4 boca inferior esquerda')"></div>
                <div dente_id="53" class="dente dente53" onclick="abreDente(53,'1/4 boca superior esquerda')"></div>
                <div dente_id="52" class="dente dente52" onclick="abreDente(52,'1/4 boca superior direita')"></div>
                <div dente_id="51" class="dente dente51" onclick="abreDente(51,'Mandíbula')"></div>
                <div dente_id="50" class="dente dente50" onclick="abreDente(50,'Maxila')"></div>
                <div dente_id="49" class="dente dente49" onclick="abreDente(49,'boca inteira')"></div>
                <div dente_id="48" class="dente dente48" onclick="abreDente(48,'3º Molar')"></div>
                <div dente_id="47" class="dente dente47" onclick="abreDente(47,'2º Molar')"></div>
                <div dente_id="46" class="dente dente46" onclick="abreDente(46,'1º Molar')"></div>
                <div dente_id="45" class="dente dente45" onclick="abreDente(45,'2º Pré-molar')"></div>
                <div dente_id="44" class="dente dente44" onclick="abreDente(44,'1º Pré-molar')"></div>
                <div dente_id="43" class="dente dente43" onclick="abreDente(43,'Canino')"></div>
                <div dente_id="42" class="dente dente42" onclick="abreDente(42,'Incisivo lateral')"></div>
                <div dente_id="41" class="dente dente41" onclick="abreDente(41,'Incisivo central')"></div>
                <div dente_id="38" class="dente dente38" onclick="abreDente(38,'3º Molar')"></div>
                <div dente_id="37" class="dente dente37" onclick="abreDente(37,'2º Molar')"></div>
                <div dente_id="36" class="dente dente36" onclick="abreDente(36,'1º Molar')"></div>
                <div dente_id="35" class="dente dente35" onclick="abreDente(35,'2º Pré-molar')"></div>
				<div dente_id="34" class="dente dente34" onclick="abreDente(34,'1º Pré-molar')"></div>
                <div dente_id="33" class="dente dente33" onclick="abreDente(33,'Canino')"></div>
                <div dente_id="32" class="dente dente32" onclick="abreDente(32,'Incisivo lateral')"></div>
                <div dente_id="31" class="dente dente31" onclick="abreDente(31,'Incisivo central')"></div> 
                <div dente_id="28" class="dente dente28" onclick="abreDente(28,'3º Molar')"></div>
				<div dente_id="27" class="dente dente27" onclick="abreDente(27,'2º Molar')"></div>
				<div dente_id="26" class="dente dente26" onclick="abreDente(26,'1º Molar')"></div>
               	<div dente_id="25" class="dente dente25" onclick="abreDente(25,'2º Pré-molar')"></div>
                <div dente_id="24" class="dente dente24" onclick="abreDente(24,'1º Pré-molar')"></div>
                <div dente_id="23" class="dente dente23" onclick="abreDente(23,'Canino')"></div>
               	<div dente_id="22" class="dente dente22" onclick="abreDente(22,'Incisivo lateral')"></div>
                <div dente_id="21" class="dente dente21" onclick="abreDente(21,'Incisivo central')"></div>
                <div dente_id="18" class="dente dente18" onclick="abreDente(18,'3º Molar')" ></div>
                <div dente_id="17" class="dente dente17" onclick="abreDente(17,'2º Molar')"></div>
               	<div dente_id="16" class="dente dente16" onclick="abreDente(16,'1º Molar')"></div>
                <div dente_id="15" class="dente dente15" onclick="abreDente(15,'2º Pré-molar')"></div>
                <div dente_id="14" class="dente dente14" onclick="abreDente(14,'1º Pré-molar')"></div>
                <div dente_id="13" class="dente dente13" onclick="abreDente(13,'Canino')"></div>
                <div dente_id="12" class="dente dente12" onclick="abreDente(12,'Incisivo lateral')"></div>
                <div dente_id="11" class="dente dente11" onclick="abreDente(11,'Incisivo central')"></div>
                </div>
                <div id="procedimentos_container">
                <div id="procedimentos_novos" style="width:310px; margin-left:10px; margin-bottom:10px; float:left; height:150px; overflow:auto; position:relative;">
                <table cellspacing="0" cellpadding="0" style="background:white;">
                <thead>
                	<tr><td></td><td>Dente</td><td width="200">Procedimentos</td><td width="50">Valor</td></tr>
                </thead>
                <!-- os itens ser?o colocados via AJAX no formulário extra q tem nesse fieldset no começo -->
                <tbody>
                <?  $aprovado[1]="checked='checked'";
					$procedimentos_novos_q=mysql_query("SELECT * FROM odontologo_atendimento_item WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento_id' AND status!='2' "); 
					while($proc=mysql_fetch_object($procedimentos_novos_q)){
					$i++; if($i%2){$f="class='al'";}else{$f='';}
					$servico=mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id = '$proc->servico_id' "));
					$total[]=$proc->valor;
				?>
                	<tr <?=$f?> >
                    	<td style="padding:0;">
                        	<input title="Aprovar procedimento" rel='tip' data-placement='right' <?=$aprovado[$proc->aprovado]?> onclick="manipulaAprovacao(this)" value="<?=$proc->id?>" type="checkbox" />
                        <td>
							<?=$proc->dente_id?>(<?=$face[$proc->face_id]?>)
                        </td>
                        <td width="300" onclick="abreAnalise(<?=$proc->id?>,'novo','<?=$proc->dente_id?>')">
                             <?=$servico->nome?>
                        </td>
                        <td width="50" align="center">
                        	<input type="text" id="<?=$proc->id?>" class="preco_procedimento" onblur="manipulaPreco(this)" value="<?=moedaUsaToBR($proc->valor)?>" style="height:12px;width:40px;" sonumero="1" />
                        </td>
                    </tr>
				<?
					}
				?>                    
                    </tbody>
                    <tfoot>
                    	<tr>
                        	<td colspan="3"></td>
                            <td id="total_preco_procedimentos" ><?=moedaUsaToBR(@array_sum($total))?></td>
                        </tr>
                    </tfoot>
                </table>
                </div>
                
                <div id="procedimentos_passados" style="width:310px; margin-left:10px; float:left; height:140px;overflow:auto;">
                <table cellspacing="0" cellpadding="0" style="background:white;">
                <thead>
                	<tr><td>Procedimentos passados</td></tr>
                </thead>
                <tbody>
                <? 
					$procedimentos_novos_q=mysql_query("SELECT * FROM odontologo_atendimento_analise WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento_id'"); 
					while($proc=mysql_fetch_object($procedimentos_novos_q)){
						$i++; if($i%2){$f="class='al'";}else{$f='';}
					$servico=mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id = '$proc->servico_id' "));
				?>
                	<tr <?=$f?> >
                    	 <td width="200" onclick="abreAnalise(<?=$proc->id?>,'passado')"><?=$proc->dente_id?>:<?=$proc->face_id?>:<?=$servico->nome?></td>
                    </tr>
                <?
					}
				?>
                    </tbody>
                    <tfoot>
                    	<tr><td>&nbsp;</td></tr>
                    </tfoot>
                </table>
                </div>
                </div>
		</fieldset>
        <fieldset  id='campos_4' style="display:none;" <?=$aparece['consulta']?> >
				<legend style="float:left;">
                	<a onclick="aba_form(this,0);habilitaBotaoImpressao('fichacadastral')">Cliente</a>
                    <a onclick="aba_form(this,1);habilitaBotaoImpressao('anamnese')">Anamnese</a>
                    <? if($verifica_odonto>0){ ?>
                    <a onclick="aba_form(this,2);habilitaBotaoImpressao('analise');atualizaProcedimentos()">Análise</a>
                    <a onclick="aba_form(this,3);habilitaBotaoImpressao('')"><strong>Consulta</strong></a>
                    <? } ?>
                </legend>
                <legend style="float:right;">
                	<a onclick="aba_form(this,4);habilitaBotaoImpressao('')" >Histórico</a>
                    <a onclick="aba_form(this,5);habilitaBotaoImpressao('')">Exames</a>
                    <a onclick="aba_form(this,6);habilitaBotaoImpressao('')">Receituário</a>
                    <a onclick="aba_form(this,7);habilitaBotaoImpressao('')">Atestado</a>
                    <a onclick="aba_form(this,8);habilitaBotaoImpressao('')">Contrato</a>
                </legend>
				<div style="clear:both; height:5px;"></div>
                <label style="width:300px;">                
                <b>Cliente:</b> <?=$cliente_fornecedor->razao_social?>
                <b>Data:</b> <?=date("d/m/Y")?>
                <br>
                Obs
                <textarea name="obs_consulta" id="obs_consulta"><?=$consulta->obs?></textarea>
                </label>
                <div id="procedimentos_aprovados" style="float:left; position:relative;">
                <div id="procedimentos_aprovados_container" style="width:450px;">
                    </div>
                    <!---------------- POPUP DO HISTORICO --------------------->
                    <div id="historico_obs" style="position:absolute; width:350px; top:0; background:#EDEDED; border:1px solid #BBBEC1; display:none;">
                    <div class='t3'></div>
                    <div class='t1'></div>
                    <div  class="dragme">
                        <a class='f_x' onclick="this.parentNode.parentNode.style.display='none';$('#obs_procedimento_consulta').val('');"></a>
                        <span>Procedimentos</span>
                    </div>
                    <span style="margin-left:10px; font-weight:bold;">Histórico de OBS</span>
                    <div id="lista_obs" style="height:100px; overflow:auto; background-color:white; text-align:center;">
                    </div>
                    <div style="clear:both; height:10px;"></div>
                  
                    <div style="clear:both;height:5px;"></div>
                      <input type="checkbox" name="status_item_consulta" id='status_item_consulta'  value="2" />Concluido
                    <label style="margin-left:10px;">OBS
                    	<input type="text" name="obs_procedimento_consulta" id="obs_procedimento_consulta" />
                    </label>
                    <div style="clear:both;"></div>
                    <input type="hidden" name="procedimento_aprovado_id" id="procedimento_aprovado_id" value="" />
                    <input type="button" style="float:right; margin:5px;" onclick="incluirConsultaProcedimento()" value="Salvar" />
                    </div>
                    <!---------------- FIM POPUP DO HISTORICO --------------------->
                </div>
		</fieldset>
        <fieldset style="display:<?php if($aba=="Historico"){echo "block";}else{echo "none";}?>">
        		<legend style="float:left;">
                	<a onclick="aba_form(this,0);habilitaBotaoImpressao('fichacadastral')" title="cliente">Cliente</a>
                    <a onclick="aba_form(this,1);habilitaBotaoImpressao('anamnese')" title="anamnese">Anamnese</a>
                    <? if($verifica_odonto>0){ ?>
                    <a onclick="aba_form(this,2);habilitaBotaoImpressao('analise')" title="analise">An&aacute;lise</a>
                    <a onclick="aba_form(this,3);habilitaBotaoImpressao('');atualizaProcedimentosAprovados()" title="consulta">Consulta</a>
                    <? } ?>
                </legend>
                <legend style="float:right;">
                	<a onclick="aba_form(this,4);habilitaBotaoImpressao('')" ><strong> Histórico </strong></a>
                    <a onclick="aba_form(this,5);habilitaBotaoImpressao('')">Exames</a>
                    <a onclick="aba_form(this,6);habilitaBotaoImpressao('')">Receituário</a>
                    <a onclick="aba_form(this,7);habilitaBotaoImpressao('')">Atestado</a>
                    <a onclick="aba_form(this,8);habilitaBotaoImpressao('')">Contrato</a>
                </legend>
				<div style="clear:both"></div>
              	Histórico de Consultas
                <div id="historico_consultas" style="height:300px; overflow:auto;">
                <table cellpadding="0" cellspacing="0" width="100%" style="background:white;">
                 <thead>
                 	<tr>
                    	<td style="width:45px;">Data</td>
        <td style="width:150px;">Servi&ccedil;o</td> 
        <td style="width:100px;">Dente | face</td> 
        <td style="width:210px;">Obs</td> 
        <td style="width:5px;"></td>
                    </tr>
                 </thead>
                 <tbody>
                 <?php
				 	$consultas_q = mysql_query($t="SELECT * FROM odontologo_consultas WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento_id' ORDER BY data DESC");
					while($consulta = mysql_fetch_object($consultas_q)){
				 ?>
                 	<tr style="background:#999; color:white;">
                        <td><?=dataUsaToBr($consulta->data)?></td><td></td><td></td><td><?=$consulta->obs?></td><td></td>
                    </tr>
                    <? 
					$itens_q=mysql_query($b="
						SELECT 
							 oci.obs as obs, s.nome as servico, oi.dente_id, oi.face_id, oi.id as atendimento_item_id
						FROM
							odontologo_consulta_has_odontologo_atendimento_item as oci,
							odontologo_atendimento_item as oi,
							servico as s
						WHERE 
							oci.odontologo_consulta_id='$consulta->id'
						AND
							oci.odontologo_atendimento_item_id=oi.id
						AND
							oi.servico_id=s.id ");
							if(mysql_num_rows($itens_q)>0){
							
							while($item=mysql_fetch_object($itens_q)){
								$i++; if($i%2){$f="class='al'";}else{$f='';}
					?>
                    <tr <?=$f?>>
                        <td style="width:45px;"></td>
                        <td style="width:150px;"><?=$item->servico?></td>
                        <td style="width:100px;"><?=$item->dente_id?> | <?=$face[$item->face_id]?></td> 
                        <td style="width:210px;" align="left"><?=$item->obs?></td> 
                        <td style="width:5px;"><button type="button" onclick="window.open('modulos/odonto/atendimento/impressao_comparecimento.php?id=<?=$item->atendimento_item_id?>')" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;">
	<img src="../fontes/img/imprimir.png">
</button></td>         
                    </tr>
                  <?php
							}
							}else{
								?>
                                <tr>
                                    <td colspan="4">(Nao há procedimentos para esta data)</td>
                                </tr>
                                <?
							}
					}
				  ?>
                 </tbody>
                 <tfoot>
                 <tr><td colspan="5">&nbsp;</td></tr>
                 </tfoot>
                </table>
                </div>            
		</fieldset>
        <fieldset style="display:<?php if($aba=="Exames"){echo "block";}else{echo "none";}?>">
        		<legend style="float:left;">
                	<a onclick="aba_form(this,0);habilitaBotaoImpressao('fichacadastral')" title="cliente">Cliente</a>
                    <a onclick="aba_form(this,1);habilitaBotaoImpressao('anamnese')" title="anamnese">Anamnese</a>
                    <? if($verifica_odonto>0){ ?>
                    <a onclick="aba_form(this,2);habilitaBotaoImpressao('analise')" title="analise">An&aacute;lise</a>
                    <a onclick="aba_form(this,3);habilitaBotaoImpressao('')" title="consulta">Consulta</a>
                    <? } ?>
                </legend>
                <legend style="float:right;">
                	<a onclick="aba_form(this,4);habilitaBotaoImpressao('')" >Histórico</a>
                    <a onclick="aba_form(this,5);habilitaBotaoImpressao('')"><strong>Exames</strong></a>
                    <a onclick="aba_form(this,6);habilitaBotaoImpressao('')">Receituário</a>
                    <a onclick="aba_form(this,7);habilitaBotaoImpressao('')">Atestado</a>
                    <a onclick="aba_form(this,8);habilitaBotaoImpressao('')">Contrato</a>
                </legend>
				<div style="clear:both"></div>
                
                <label style="width:150px;">                
                Data
                <input type="text" name="data_exame" id="data_exame" value="<?=date('d/m/Y');?>" calendario='1' sonumero='1' mascara='__/__/____'>
                <?php
				//	$proximo_exame = mysql_fetch_array(mysql_query($t="SHOW TABLE STATUS LIKE 'odontologo_exames'"));	
				?>
                 <!--<input type="hidden" name="proximo_exame" id="proximo_exame" value="<?=$proximo_exame['Auto_increment'];?>">-->
                </label>
                <label style="width:150px;">                
                OBS
                <input type="text" name="obs_exame" id="obs_exame">
                </label>                
                <label style="width:140px;">                
                	Arquivo
                    <input type="file" name="imagem" id="imagem" size="9">
                </label>                    
                <label style="margin-left:110px;margin-top:20px;">                
                <img src="../fontes/img/mais.png" id="add_exame"/>
                </label>
                <div id='imagem_exame' style="width:0px;height:0px;"></div>
                <div style="clear:both"></div>
                <table cellpadding="0" cellspacing="0" width="100%" id="dados_exames">
                 <thead>
                 	<tr>
                    	<td style="width:45px;">Data</td>
                        <td style="width:310px;">Nome</td>
                        <td style="width:30px;" align="center" colspan="2">Ação</td>               
                    </tr>
                 </thead>
                 <tbody id="lista_exames" style=" background:white;">
                 <?php
				 	$exames = mysql_query($t="SELECT * FROM odontologo_exames WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id'AND odontologo_atendimento_id=$atendimento_id");
					//alert($t);
					$i=0;
					while($exame = @mysql_fetch_object($exames)){
						if($i%2==0){$cl="al";}else{$cl="";}
				 ?>
                 	<tr class="<?=$cl?>" id_exame="<?=$exame->id?>">
                    	<td style="width:45px;"><?=DataUsaToBr($exame->data)?></td>
                        <td style="width:310px;"><?=$cliente_fornecedor->razao_social?></td>
                        <td style="width:15px;" align="center">
                        	<button type="button" class="download_exame" style="margin-top:2px; "  title="Imprime este receituario">
								<!--<img src="modulos/odonto/atendimento/img/baixar.png" height="10"/>-->Baixar
                            </button>
                       </td>
                       <td style="width:15px;">
                            <img src='../fontes/img/menos.png' id='remove_exame'>
                       </td>          
                    </tr>
                  <?php
				  $i++;
					}
				  ?>
                 </tbody>
                </table>                
		</fieldset>
        <fieldset style="display:none">
					<legend style="float:left;">
                	<a onclick="aba_form(this,0);habilitaBotaoImpressao('fichacadastral')" >Cliente</a>
                    <a onclick="aba_form(this,1);habilitaBotaoImpressao('anamnese')" >Anamnese</a>
                    <? if($verifica_odonto>0){ ?>
                    <a onclick="aba_form(this,2);habilitaBotaoImpressao('analise')" >An&aacute;lise</a>
                    <a onclick="aba_form(this,3);habilitaBotaoImpressao('')" >Consulta</a>
                    <? } ?>
                </legend>
                <legend style="float:right;">
                	<a onclick="aba_form(this,4);habilitaBotaoImpressao('')" >Histórico</a>
                    <a onclick="aba_form(this,5);habilitaBotaoImpressao('')">Exames</a>
                    <a onclick="aba_form(this,6);habilitaBotaoImpressao('')"><strong>Receituário</strong></a>
                    <a onclick="aba_form(this,7);habilitaBotaoImpressao('')">Atestado</a>
                    <a onclick="aba_form(this,8);habilitaBotaoImpressao('')">Contrato</a>
                </legend>
				<div style="clear:both"></div>
                
                <label style="width:150px;">                
                Data
                <input type="text" name="data_receituario" id="data_receituario" value="<?=date('d/m/Y');?>" calendario='1' sonumero='1' mascara='__/__/____'>
                </label>
                
                
                <div style="clear:both"></div>
                <label style="width:40px">
<select name="select"class="in"style="margin-right:5px; w"onchange="ti('fontsize',this.options[this.selectedIndex].value,'ed_receituario')"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null,'ed_receituario')" href="#" class='btf bold'></a>
<a onclick="ti('italic',null,'ed_receituario')" href="#" class='btf italic'></a>
<a onclick="ti('underline',null,'ed_receituario')" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null,'ed_receituario')" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null,'ed_receituario')" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null,'ed_receituario')" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null,'ed_receituario')" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null,'ed_receituario')" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null,'ed_receituario')" href="#" class='btf insertorderedlist'></a>
<div style="float:right;">
<button type="button" title="Salva este receituário" id="add_receituario">
	<img src="modulos/odonto/atendimento/img/save.png" height="17"/>
</button>
 
			
</div>
<div style="clear:both"></div>
<div id="texto">
 <label style="display:none">
		<textarea name="tx_receituario" cols="25" rows="29" id="tx_receituario"  >
		<?php
			echo $contrato->html_contrato;
		?>
      </textarea>
</label >

       <iframe id='ed_receituario' name='ed_receituario' width="100%" style="height:300px; background:#FFF;  overflow:scroll;float:left" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0"class="edtx"></iframe>
</div>
<input name="salva_formulario_contrato_cliente" type="hidden" value="2" />                
                
                <div style="clear:both"></div>
                <table cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:90px;">Data</td>
                        <td style="width:550px;">Nome</td>
                        <td >Imprimir</td>                        
                    </tr>
                 </thead>
                 </table>
                 <div style="max-height:70px;overflow:auto">
                 <table id="dados_receituario" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                 <?php
				 	$receituarios = mysql_query($t="SELECT * FROM odontologo_receituario WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id' AND odontologo_atendimento_id = $atendimento_id");
					
					while($receituario = @mysql_fetch_object($receituarios)){
				 ?>
                 	<tr id_receituario="<?=$receituario->id?>">
                    	<td style="width:90px;"><img src='../fontes/img/menos.png' id='remove_receituario'><?=DataUsaToBr($receituario->data)?></td>
                        <td style="width:550px;"><?=$cliente_fornecedor->razao_social?></td>
                        <td align="center" ><button type="button" class="print_receituario" style="margin-top:2px; "  title="Imprime este receituario">
	<img src="../fontes/img/imprimir.png"/>
</button></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
                </table>     
           
		</fieldset>
        <fieldset style="display:none">
				<legend style="float:left;">
                	<a onclick="aba_form(this,0);habilitaBotaoImpressao('fichacadastral')" title="cliente">Cliente</a>
                    <a onclick="aba_form(this,1);habilitaBotaoImpressao('anamnese')" title="anamnese">Anamnese</a>
                    <? if($verifica_odonto>0){ ?>
                    <a onclick="aba_form(this,2);habilitaBotaoImpressao('analise')" title="analise">An&aacute;lise</a>
                    <a onclick="aba_form(this,3);habilitaBotaoImpressao('')" title="consulta">Consulta</a>
                    <? } ?>
                </legend>
                <legend style="float:right;">
                	<a onclick="aba_form(this,4);habilitaBotaoImpressao('')" >Histórico</a>
                    <a onclick="aba_form(this,5);habilitaBotaoImpressao('')">Exames</a>
                    <a onclick="aba_form(this,6);habilitaBotaoImpressao('')">Receituário</a>
                    <a onclick="aba_form(this,7);habilitaBotaoImpressao('')"><strong>Atestado</strong></a>
                    <a onclick="aba_form(this,8);habilitaBotaoImpressao('')">Contrato</a>
                </legend>
				<div style="clear:both"></div>
                
                <label style="width:80px;">                
                CID
                <input type="text" name="cid" id="cid" sonumero='1'>
                </label>
                <label style="width:150px;">                
                Data
                <input type="text" name="data_atestado" id="data_atestado" value="<?=date('d/m/Y');?>" calendario='1' sonumero='1' mascara='__/__/____'>
                </label>
                <label style="width:80px;">                
                Hora In&iacute;cio
                <input type="text" name="hora_inicio_atestado" id="hora_inicio_atestado" mascara='__:__'>
                </label>
               <label style="width:80px;">                
                Hora Fim
                <input type="text" name="hora_fim_atestado" id="hora_fim_atestado" mascara='__:__'>
                </label>
                <label style="width:120px;">                
                Dias Afastamento
                <input type="text" name="dias_afastamento" id="dias_afastamento" sonumero='1'>
                </label>
                <label style="margin-left:30px;margin-top:20px;">                
                <img src="../fontes/img/mais.png" id="add_atestado"/>
                </label>
                
                <div style="clear:both"></div>
                <table cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:90px;">Data</td>
                        <td style="width:450px;">Nome</td>
                        <td style="width:30px;">Dias</td>
                        <td colspan="2" align="center">Ação</td>                        
                    </tr>
                 </thead>
                 </table>

                 <table id="dados_atestado" cellpadding="0" cellspacing="0" width="100%">
                  <tbody id="lista_atestados" style="background:white">
                 <?php
				 	$atestados = mysql_query($t="SELECT * FROM odontologo_atestados WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id' AND odontologo_atendimento_id = $atendimento_id");
					$i=0;
					while($atestado = @mysql_fetch_object($atestados)){
						if($i%2==0){$c="al";}else{$c="";}
				 ?>
                 	<tr class="<?=$c?>" id_atestado="<?=$atestado->id?>">
                        <td style="width:90px;"><?=DataUsaToBr($atestado->data)?></td>
                        <td style="width:450px;"><?=$cliente_fornecedor->razao_social?></td>
                        <td style="width:30px;"><?=$atestado->dias_afastado?></td>
                        <td align="center">
                        	<button type="button" class="print_atestado" style="margin-top:2px; "  title="Imprime este atestado">
								<img src="../fontes/img/imprimir.png" height="12" />
							</button>
                        </td>
                        <td align="center">
                        	<img src='../fontes/img/menos.png' id='remove_atestado'>
                        </td>
                    </tr>
                  <?php
				  $i++;
					}
				  ?>
                 </tbody>
                </table>                
		</fieldset>
        <fieldset style="display:none">
				<legend style="float:left;">
                	<a onclick="aba_form(this,0);habilitaBotaoImpressao('fichacadastral')" title="cliente">Cliente</a>
                    <a onclick="aba_form(this,1);habilitaBotaoImpressao('anamnese')" title="anamnese">Anamnese</a>
                    <? if($verifica_odonto>0){ ?>
                    <a onclick="aba_form(this,2);habilitaBotaoImpressao('analise')" title="analise">An&aacute;lise</a>
                    <a onclick="aba_form(this,3);habilitaBotaoImpressao('')" title="consulta">Consulta</a>
                    <? } ?>
                </legend>
                <legend style="float:right;">
                	<a onclick="aba_form(this,4);habilitaBotaoImpressao('')" >Histórico</a>
                    <a onclick="aba_form(this,5);habilitaBotaoImpressao('')">Exames</a>
                    <a onclick="aba_form(this,6);habilitaBotaoImpressao('')">Receituário</a>
                    <a onclick="aba_form(this,7);habilitaBotaoImpressao('')">Atestado</strong></a>
                    <a onclick="aba_form(this,8);habilitaBotaoImpressao('')"><strong>Contrato</strong></a>
                </legend>
				<div style="clear:both"></div>
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
		</label >-->
        
        <label style="width:200px;">
        	Descriçao:
			<input type='text' name="nome" id="nome" value="<?=$contrato->nome?>">
		</label >
               
           
                <div style="clear:both"></div>
                 <div style="clear:both"></div>
         
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px; w"onchange="ti('fontsize',this.options[this.selectedIndex].value,'ed_contrato')"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null,'ed_contrato')" href="#" class='btf bold'></a>
<a onclick="ti('italic',null,'ed_contrato')" href="#" class='btf italic'></a>
<a onclick="ti('underline',null,'ed_contrato')" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null,'ed_contrato')" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null,'ed_contrato')" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null,'ed_contrato')" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null,'ed_contrato')" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null,'ed_contrato')" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null,'ed_contrato')" href="#" class='btf insertorderedlist'></a>
<div style="float:right;margin-right:210px;">
<button type="button" style="margin-top:2px; "  title="Salva este contrato" id="salvar_contrato">
	<img src="modulos/odonto/atendimento/img/save.png" height="17"/>
</button>
			
</div>
<div style="clear:both"></div>
<div id="texto">
 <label style="display:none">
		<textarea name="tx_contrato" cols="25" rows="29" id="tx_contrato"  >
		<?php
			echo $contrato->html_contrato;
		?>



        </textarea>
              </label >

       <iframe id='ed_contrato' name='ed_contrato' width="75%" style="height:300px; background:#FFF;  overflow:scroll;float:left" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0"class="edtx"></iframe>
</div>
        
        
        
        
          <div id="esquerda" style="float:right;overflow:auto">
        	
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratante_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratante_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratante_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratante_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratante_cpf</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratante_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratado_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratado_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratado_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratado_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratado_cpf</strong></a>
            <div style="clear:both"></div>
              <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@contratado_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@valor_mensalidade</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@valor_implantacao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contrato') "><strong>@dia_implantacao</strong></a>
        </div>
        
       
        	
         </div>
         
                <table cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:200px;">Cliente</td>
                        <td style="width:400px;">Descricao</td>
                        <td style="width:60px;">Imprimir</td>
                        <td align="center">Editar</td>                        
                    </tr>
                 </thead>
                 </table>
                 <div style="max-height:65px;overflow:auto">
                 <table id="dados_contratos" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                 <?php
				 	//$atestados = mysql_query($t="SELECT * FROM odontologo_atestados WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id' AND odontologo_atendimento_id = $atendimento_id");
					//echo $t;
					//while($atestado = @mysql_fetch_object($atestados)){
					$contratos = mysql_query($t="SELECT * FROM odontologo_contrato_cliente WHERE cliente_id='".$cliente_fornecedor->id."' AND status='1'"); 	
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
                </table>
                </div>
                <input name="salva_formulario_contrato_cliente" type="hidden" value="1" />                
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<input name="imprimir_ficha_cadastral" id="imprimir_ficha_cadastral" type="button"  class="impressao" value="Imprimir Ficha Cadastral" style="float:left;display:none;"	/>
    <input name="imprimir_anamnese" id="imprimir_anamnese" type="button"  class="impressao" value="Imprimir Ficha Cadastral" style="float:left;display:none;"  />
    <input name="imprimir_analise" id="imprimir_analise" type="button"  class="impressao" value="Imprimir Análise" style="float:left;display:none;"  />
    <input name="imprimir_procedimento" id="imprimir_procedimento" type="button"  class="impressao" value="Imprimir Procedimentos" style="float:left;display:none;"  />
    <input name="action" type="submit"  value="Salvar" style="float:right"  />
    <input type="submit" name="action" value="Concluir Consulta" style="float:right; display:none;" id="concluir_consulta" />
	<div style="clear:both"></div>
	
</form>
<div id='divformexame'></div>
</div>
</div>
</div>
<script>top.openForm()</script>