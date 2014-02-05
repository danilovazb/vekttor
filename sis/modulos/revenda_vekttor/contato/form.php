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
    
    <span>Contato Revenda</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
    <input type="hidden" name="id" value="<?=$contato->id?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<input id='tipo_cadastro' name="tipo_cadastro" type="hidden" value="<? if($contato->id>0){echo $contato->tipo_cadastro;} else {echo "Jurídico"; }?>" />
	<input name="cliente_fornecedor_id" type="hidden" value="<?=$id?>" />
		<fieldset  id='campos_1' <? if($contato->tipo_cadastro=="Físico")echo 'style="display:none"'; ?> >
			<legend>
				<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong>Jurídico</strong></a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';">Físico</a>
                <a onclick="aba_form(this,2);">Intera&ccedil;&atilde;o</a>
                <?
					if($id>0){
				?>
                <a onclick="aba_form(this,3);">Histórico</a>
                <?
					}
				?>
			</legend>
			<div>
				<input type="hidden" name="j_tipo" value="<?=$contato->tipo?>">
			</div>
			<label style="width:294px; margin-right:23px;">
				Razão Social
				<input type="text" id='j_razao_social' onkeyup="document.getElementById('j_nome_fantasia').value=this.value" name="j_razao_social" value="<?=$contato->razao_social?>" />
			</label>
			<label style="width:294px;">
				Nome Fantasia
				<input type="text" id='j_nome_fantasia' name="j_nome_fantasia" value="<?=$contato->nome_fantasia?>" />
			</label>
			<label style="width:294px; margin-right:23px;">
				Nome do Contato
				<input type="text" id='j_nome_contato' name="j_nome_contato" value="<?=$contato->nome_contato?>" />
			</label>
			<label style="width:294px;">
				Ramo de Atividade
				<input type="text" id='j_ramo_atividade' name="j_ramo_atividade" value="<?=$contato->ramo_atividade?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				CNPJ
				<input type="text" id='j_cnpj_cpf' name="j_cnpj_cpf" value="<?=$contato->cnpj_cpf?>" mascara="__.___.___/____-__" sonumero='1' retorno='focus|Coloque o CNPJ corretamente!' />
			</label>
			<!--<label style="width:136px; margin-right:23px;">
				Suframa
				<input type="text" id='j_suframa' name="j_suframa" value="<?$contato->suframa?>" />
			</label>-->
			<label style="width:136px; margin-right:22px;">
				Inscrição Municipal
				<input type="text" id='j_inscricao_municipal' name="j_inscricao_municipal" value="<?=$contato->inscricao_municipal?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Inscrição Estadual
				<input type="text" id='j_inscricao_estadual' name="j_inscricao_estadual" value="<?=$contato->inscricao_estadual?>" />
			</label>
            <label style="width:80px;">
            	Data Cadastro
            	<input type="text" name="data_cadastro" id="data_cadastro" calendario='1' mascara="__/__/____" value="<?=dataUsaToBr($contato->data_cadastro)?>">
            </label>
			<label style="width:294px; margin-right:23px;">
				Email
				<input type="text" id='j_email' name="j_email" value="<?=$contato->email?>" retorno='focus|Coloque o email corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Telefone 1
				<input type="text" id='j_telefone1' name="j_telefone1" value="<?=$contato->telefone1?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Telefone 2
				<input type="text" id='j_telefone2' name="j_telefone2" value="<?=$contato->telefone2?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Fax
				<input type="text" id='j_fax' name="j_fax" value="<?=$contato->fax?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='j_cep' name="j_cep" value="<?=$contato->cep?>" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/administrativo/clientes/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>j_cep|@r1-value>j_endereco|@r2-value>j_bairro|@r3-value>j_cidade|@r4-value>j_estado\',\'j_cep\')')}"/>
			</label>
			<label style="width:294px; margin-right:23px;">
				Endereço
				<input type="text" id='j_endereco' name="j_endereco" value="<?=$contato->endereco?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='j_bairro' name="j_bairro" value="<?=$contato->bairro?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='j_cidade' name="j_cidade" value="<?=$contato->cidade?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Estado
				<input type="text" id='j_estado' name="j_estado" value="<?=$contato->estado?>" />
			</label>
           
            <div style="clear:both"></div>
            <label>
            	Observa&ccedil;&atilde;o
            	<textarea name="obsContato" id="obsContato" cols="30"><?=$contato->observacao?></textarea>
            </label>
		</fieldset>
		
		<fieldset  id='campos_2' <? if($contato->tipo_cadastro=="Jurídico"||empty($id))echo 'style="display:none"'; ?> >
			<legend>
				<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';">Jurídico</a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';"><strong>Físico</strong></a>
                <a onclick="aba_form(this,2);">Intera&ccedil;&atilde;o</a>
                <?
					if($id>0){
				?>
                <a onclick="aba_form(this,3);">Histórico</a>
                <?
					}
				?>
			</legend>
			<input type="hidden" name="j_tipo" value="<? if($contato->tipo_cadastro=="Físico") echo $contato->tipo?>">
			
			<label style="width:151px">
				Estado Civil
				<select name="f_estado_civil" onchange="exibeConjugue()">
				<?
					if($contato->estado_civil=="Casado"){
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
			<label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='f_nome_contato' name="f_nome_contato" value="<?=$contato->nome_contato?>" />
			</label>
			<label style="width:294px;">
				Ramo de Atividade
				<input type="text" id='f_ramo_atividade' name="f_ramo_atividade" value="<?=$contato->ramo_atividade?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				CPF
				<input type="text" id='f_cnpj_cpf' name="f_cnpj_cpf" value="<?=$contato->cnpj_cpf?>" mascara="___.___.___-__" sonumero='1' retorno='focus|Coloque o CPF corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				RG
				<input type="text" id='f_rg' name="f_rg" value="<?=$contato->rg?>"  sonumero='1' retorno='focus|Coloque o RG corretamente!' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Local de Emissão
				<input type="text" id='f_local_emissao' name="f_local_emissao" value="<?=$contato->local_emissao?>" />
			</label>
			<label style="width:126px; margin-right:22px;">
				Data Emissao
				<input type="text" mascara='__/__/____' id='f_data_emissao' calendario='1' name="f_data_emissao" value="<?=dataUsaToBr($contato->data_emissao)?>" />
			</label>
            <label style="width:126px;">
				Data Nascimento
				<input type="text" mascara='__/__/____' id='f_nascimento' calendario='1' name="f_nascimento" value="<?=dataUsaToBr($contato->nascimento)?>" />
			</label>
            <label style="width:126px;">
				Naturalidade
				<input type="text" id='f_naturalidade' name="f_naturalidade" value="<?=$contato->naturalidade?>" />
			</label>
            <label style="width:126px;">
				Nacionalidade
				<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="<?=$contato->nacionalidade?>" />
			</label>
            <label style="width:294px; margin-right:23px;">
				Email
				<input type="text" id='f_email' name="f_email" value="<?=$contato->email?>"  retorno='focus|Coloque o email corretamente!' />
			</label>
			<label style="width:130px; margin-right:23px;">
				Telefone 1
				<input type="text" id='f_telefone1' name="f_telefone1" value="<?=$contato->telefone1?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:130px; margin-right:22px;">
				Telefone 2
				<input type="text" id='f_telefone2' name="f_telefone2" value="<?=$contato->telefone2?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="f_fax" value="<?=$contato->fax?>" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='f_cep' name="f_cep" value="<?=$contato->cep?>" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );
            document.title=cp;if(cp.length==9){return  vkt_ac(this,event,'undefined','modulos/administrativo/clientes/busca_endereco.php',
            '@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}"/>
			</label>
			<label style="width:290px; margin-right:23px;">
				Endereço
				<input type="text" id='f_endereco' name="f_endereco" value="<?=$contato->endereco?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='f_bairro' name="f_bairro" value="<?=$contato->bairro?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='f_cidade' name="f_cidade" value="<?=$contato->cidade?>" />
			</label>
			<label style="width:130px; margin-right:23px;">
				Estado
				<input type="text" id='f_estado' name="f_estado" value="<?=$contato->estado?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				Limite
				<input type="text" id='f_limite' name="f_limite" value="<?=moedaUsaToBr($contato->limite)?>" decimal='2'/>
			</label>
            <label style="width:294px; margin-right:23px;">
				Endereco Comercial
				<input type="text" id='f_endereco_comercial' name="f_endereco_comercial" value="<?=$contato->endereco_comercial?>" />
			</label>
			<label style="width:294px;">
				Telefone Comercial
				<input type="text" id='f_telefone_comercial' name="f_telefone_comercial" value="<?=$contato->telefone_comercial?>" mascara="(__)____-____" sonumero='1' />
			</label>
            <div style="clear:both"></div>
            <label>
            	Observa&ccedil;&atilde;o
            	<textarea name="obsContato" id="obsContato" cols="30"><?=$contato->observacao?></textarea>
            </label>
            <?
			if($contato->estado_civil=="Casado"){
				$display="block";	
			}else{
				$display="none";
			}
			?>
			
			<div style="clear:both"></div>
			<div id="dados_conjugue" style="display:<?=$display?>">
			<label style="width:294px; margin-right:23px;">
				Nome - Conjugue
				<input type="text" id='f_conjugue_nome' name="f_conjugue_nome" value="<?=$contato->conjugue_nome?>" />
			</label>
             <label style="width:175px; margin-right:22px;">
				Data de Nascimento - Conjugue
				<input type="text" id='f_conjugue_data_nascimento' name="f_conjugue_data_nascimento" value="<?=dataUsaToBr($contato->conjugue_data_nascimento)?>" mascara='__/__/____' sonumero='1'/>
			</label>
			<label style="width:294px;">
				Ramo de Atividade - Conjugue
				<input type="text" id='f_conjugue_ramo_atividade' name="f_conjugue_ramo_atividade" value="<?=$contato->conjugue_ramo_atividade?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				CPF - Conjugue
				<input type="text" id='f_conjugue_cpf' name="f_conjugue_cpf" value="<?=$contato->conjugue_cpf?>" mascara="___.___.___-__" sonumero='1' retorno='focus|Coloque o CPF corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				RG - Conjugue
				<input type="text" id='f_conjugue_rg' name="f_conjugue_rg" value="<?=$contato->conjugue_rg?>" retorno='focus|Coloque o RG corretamente!' />
			</label>
			<label style="width:136px; margin-right:22px;" title='Local de emissao RG do Conjugue'>
				Local Emissao RG.
				<input type="text" id='f_conjugue_local_emissao' name="f_conjugue_local_emissao" value="<?=$contato->conjugue_local_emissao?>" />
			</label>
            <label style="width:155px; margin-right:22px;">
				Data da Emissao - Conjugue
				<input type="text" id='f_conjugue_data_emissao' calendario="1" name="f_conjugue_data_emissao" value="<?=DataUsaToBr($contato->conjugue_data_emissao)?>" mascara='__/__/____'/>
			</label>
            <label style="width:130px; margin-right:22px;">
				Telefone - Conjugue
				<input type="text" id='f_conjugue_telefone' name="f_conjugue_telefone" value="<?=$contato->conjugue_telefone?>" mascara="(__)____-____" sonumero='1'/>
			</label>
            <label style="width:136px; margin-right:22px;">
				E-mail - Conjugue
				<input type="text" id='f_conjugue_email' name="f_conjugue_email" value="<?=$contato->conjugue_email?>"/>
			</label>
            <label style="width:150px;">
				Naturalidade - Conjugue
				<input type="text" id='f_conjugue_naturalidade' name="f_conjugue_naturalidade" value="<?=$contato->conjugue_naturalidade?>" />
			</label>
            <label style="width:150px;">
				Nacionalidade - Conjugue
				<input type="text" id='f_conjugue_nacionalidade' name="f_conjugue_nacionalidade" value="<?=$contato->conjugue_nacionalidade?>" />
			</label>
            <label style="width:294px; margin-right:23px;">
				Endereco Comercial - Conjugue
				<input type="text" id='f_endereco_comercial_conjugue' name="f_endereco_comercial_conjugue" value="<?=$contato->conjugue_endereco_comercial?>" />
			</label>
			<label style="width:170px;">
				Telefone Comercial - Conjugue
				<input type="text" id='f_telefone_comercial_conjugue' name="f_telefone_comercial_conjugue" value="<?=$contato->conjugue_telefone_comercial?>" mascara="(__)____-____" sonumero='1' />
			</label>
			</div>
            <div style="clear:both"></div>
            
		</fieldset>
        <fieldset  id='campos_3' style="display:none">
			<legend>
				<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';">Jurídico</a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';">Físico</a>
                <a onclick="aba_form(this,2);"><strong>Intera&ccedil;&atilde;o</strong></a>
                <?
					if($id>0){
				?>
                <a onclick="aba_form(this,3);">Histórico</a>
                <?
					}
				?>
			</legend>
            <div style="clear:both"></div>
		<?php
			$interacao = mysql_fetch_object(mysql_query("SELECT * FROM revenda_contato_interacao WHERE revenda_contato_id='".$contato->id."' ORDER BY id LIMIT 1"));
			$vendedor  = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE usuario_id='".$usuario_id."'"));
			//alert($vendedor->id);
		?>
        
        <label style="width:200px;">
        	Tipo de interaçao
            <select name="tipo_interacao" id="interacao">
            	<option value="0">Selecione o tipo de interacao</option>
            	<option value="1" <?php if($interacao->tipo_interacao==1){echo "selected='selected'";}?>>Telefone</option>
                <option value="2" <?php if($interacao->tipo_interacao==2){echo "selected='selected'";}?>>Visita</option>
                <option value="3" <?php if($interacao->tipo_interacao==3){echo "selected='selected'";}?>>Reuniao</option>                
            </select>
        </label>
        
        <label style="width:80px;">
        	Dt. Interaçao
            <input type="text" mascara="__/__/____" calendario='1' name="data_interacao" id="data_interacao" value="<?php if(!empty($interacao)){echo DataUsaToBr(substr($interacao->data_hora_interacao,0,10));}else{echo date("d/m/Y");}?>"/>
        </label>
        
        <label style="width:80px;">
        	Hr Interaçao
            <input type="text" mascara="__:__" name="hora_interacao" value="<?php if(!empty($interacao)){echo substr($interacao->data_hora_interacao,11,5);}else{echo date("H:i");}?>"/>
        </label>
        
        <div style="clear:both"></div>
        
               
        <label style="width:170px;">
        	O que gerou
            <select name="o_que_gerou" id="o_que_gerou">
            	<option value="0">Selecione uma opçao</option>
                <option value="1"  <?php if($interacao->o_que_gerou==1){echo "selected='selected'";}?>>Telefonema</option>
                <option value="2" <?php if($interacao->o_que_gerou==2){echo "selected='selected'";}?>>Visita</option>
                <option value="3" <?php if($interacao->o_que_gerou==3){echo "selected='selected'";}?>>Reuniao</option>
                <option value="4" <?php if($interacao->o_que_gerou==4){echo "selected='selected'";}?>>Venda</option>
                <option value="5" <?php if($interacao->o_que_gerou==5){echo "selected='selected'";}?>>Cancelamento</option>
            </select>
        </label>
        <?php
			if($interacao->o_que_gerou>=1 && $interacao->o_que_gerou<=3){
				$display='block';
			}else{
				$display='none';
			}
		?>
        <div id="prox_interacao" style="display:<?=$display?>">
       		 <?php
			//alert($interacao->id);	
			$proxima_interacao = mysql_fetch_object(mysql_query($t="SELECT * FROM revenda_contato_interacao WHERE interacao_id='$interacao->id' AND interacao_id>0"));
			//echo $t;
			
			?>
        	<div style='clear:both'></div>
            <label style='width:100px;'>
            	Data
                <input type='text' name='dt_proxima_interacao' calendario="1" id='dt_proxima_interacao' mascara='__/__/____' value="<?php if(!empty($proxima_interacao)){  echo  DataUsaToBr(substr($proxima_interacao->data_hora_interacao,0,10));}?>"/>
            </label>
            <label style='width:100px;'>
            	Hora<input type='text' name='hr_proxima_interacao' id='dt_proxima_interacao' mascara='__:__' value="<?php if(!empty($proxima_interacao)){echo substr($proxima_interacao->data_hora_interacao,11,5);}?>"/>
            </label>
        </div>
         <div style="clear:both"></div>
         <label style="width:400px;">
        	Observaçao
            <textarea name="observacao" id="observacao" rows="5"><?=$interacao->comentario?></textarea>
        </label>
        <input type="hidden" name="interacao_id" id="interacao_id" value="<?=$interacao->id?>" />
       </fieldset>
       <?php
            if(!empty($interacoes)){
       ?>
		<fieldset style="display:none;">
		<legend>
        	<a onclick="aba_form(this,0); document.getElementById('tipo_cadastro').value='Jurídico';"><strong>Jurídico</strong></a>
				<a onclick="aba_form(this,1); document.getElementById('tipo_cadastro').value='Físico';">Físico</a>
                <a onclick="aba_form(this,2);">Intera&ccedil;&atilde;o</a>
                <?
					if($id>0){
				?>
                <a onclick="aba_form(this,3);">Histórico</a>
                <?
					}
				?>
       	</legend>	
        
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<thead>
                	<tr>
                    	<td width="70">INTERAÇAO</td>
                        <td width="70">DATA/HORA</td>
                        <td width="70">O QUE GEROU</td>
                    </tr>
                </thead>
            </table>
            <div style="height:500px;overflow:auto;">
            <table cellpadding="0" cellspacing="0" width="100%" class="semformatacao">
            <tbody>
            <?php
				while($i = mysql_fetch_object($interacoes)){
					
					//tipo de interacao
					if($i->tipo_interacao==1){$tp_interacao="Telefonema";}
					if($i->tipo_interacao==2){$tp_interacao="Visita";}
					if($i->tipo_interacao==3){$tp_interacao="Reuniao";}
					//o que gerou
					if($i->o_que_gerou==1){$o_que_gerou="Telefonema";}
					if($i->o_que_gerou==2){$o_que_gerou="Visita";}
					if($i->o_que_gerou==3){$o_que_gerou="Reuniao";}
					if($i->o_que_gerou==4){$o_que_gerou="Venda";}
					if($i->o_que_gerou==5){$o_que_gerou="Cancelamento";}						
			?>
            	<tr>
            	<td width="70"><?=$tp_interacao?></td>
                <td width="70"><?=DataUsaToBr(substr($i->data_hora_interacao,0,10))." as ".substr($i->data_hora_interacao,11,5);?></td>
                <td width="70"><?=$o_que_gerou?></td>
                </tr>
                <tr>
                	<td colspan="3" style="height:60px;overflow:auto" valign="top"><strong>Observaçao: </strong><?=$i->comentario?></td>
                </tr>
			<?php
				}
			?>
            </tbody>
            </table>
            </div>        
        </fieldset>	
       <?php
			}
		?>
        
	<!--Fim dos fiels set-->
    <div style="margin-bottom:10px;">
    	<label>
            	Vendedor<br/>
                <select name="vendedor_id" id="vendedor_id" style="width:150px;">  
                	<option></option>
                		<?php
                        	$sqlVendedor =  mysql_query($u=" SELECT * FROM rh_funcionario WHERE vendedor = 's' AND vkt_id = '$vkt_id'");
								while($vendedor = mysql_fetch_object($sqlVendedor)){
										if ($vendedor->id == $contato->vendedor_id){$sel='selected="selected"';}else{$sel="";}
						?>
                		<option value="<?=$vendedor->id?>" <?=$sel?> ><?=$vendedor->nome?></option>
                		<?php
								}
						?>
                </select>
                
            </label>
    </div>
	<div style="width:100%; text-align:center" >
     
	<?
	if($contato->id > 0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>