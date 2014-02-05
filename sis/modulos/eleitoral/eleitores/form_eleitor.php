<?
//Includes
// funções base do sistema
include("../../../_config.php");
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_function.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>


<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    <span>Eleitores</span></div>
    </div>
<form onsubmit="return validaForm(this);" class="form_float" method="post" autocomplete='off' >
<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
<fieldset id='campos_1' >
<legend>
 		<a onclick="aba_form(this,0)"><strong>Dados Principais</strong></a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)">Dados Sociais</a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>

</legend>
  <label style="width:260px;">
    Nome
    <input type="text" id='nome' name="nome" value="<?=$eleitor->nome?>" autocomplete='off' maxlength="44" retorno="focus|Digite seu nome corretamente" valida_minlength='3'/>
  </label>
  <label>
    Apelido
    <input type="text" id='apelido' name="apelido" value="<?=$eleitor->apelido?>" autocomplete='off' size="5" maxlength="44"/>
  </label>
  <label>Sexo
	<select name="sexo">
        <option <? if($eleitor->sexo=='masculino'){ echo "selected='selected'";} ?> value="masculino">Masculino</option>
        <option <? if($eleitor->sexo=='feminino'){ echo "selected='selected'";} ?> value="feminino">Feminino</option>
    </select>
    </label>
  <div style="clear:both"></div>
  <label style="width:150px"> 
  Data de Nascimento
  <input type="text" id='data_nascimento' name="data_nascimento" value="<?=dataUsaToBr($eleitor->data_nascimento)?>" autocomplete='off' maxlength="44" mascara='__/__/____'/>
  </label>
  <label style="width:120px">Telefone 
    <input type="text" id='telefone1' name="telefone1" value="<?=$eleitor->telefone1?>" autocomplete='off' maxlength="44" mascara="(__)____-____"/> 
  </label>
  <label style="width:120px">Celular
  <input type="text" id='telefone2' name="telefone2" value="<?=$eleitor->telefone2?>" maxlength="44" mascara="(__)____-____"/>
  </label>
  <br />
  <label style="width:120px">E-mail
  <input type="text" id='email' name="email" value="<?=$eleitor->email?>" maxlength="44"/>
  </label>
  <label style="width:99px">Estado Civil
  <select name="estado_civil" id="estado_civil">
    <option></option>
    <option <? if($eleitor->estado_civil=='casado'){ echo "selected='selected'"; }?> value="casado">casado(a)</option>
    <option <? if($eleitor->estado_civil=='divorciado')echo 'selected="selected"'; ?> value="divorciado">divorciado(a)</option>
    <option <? if($eleitor->estado_civil=='separado')echo 'selected="selected"'; ?> value="separado">separado(a)</option>
    <option <? if($eleitor->estado_civil=='solteiro')echo 'selected="selected"'; ?> value="solteiro">solteiro(a)</option>
    <option <? if($eleitor->estado_civil=='ue')echo 'selected="selected"'; ?> value="ue">Uniao Estavel</option>
    <option <? if($eleitor->estado_civil=='viuvo')echo 'selected="selected"'; ?> value="viuvo">Viuvo(a)</option>
  </select>
  </label>
  
  <label style="width:200px">
  Naturalidade
  <input type="text" id='naturalidade' name="naturalidade" value="<?=$eleitor->naturalidade?>" autocomplete='off' maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:150px">CEP
  	<input type="text" id='cep' name="cep" value="<?=$eleitor->cep?>" busca='modulos/eleitoral/eleitores/busca_endereco.php,@r0,@r0-value>cep|@r1-value>endereco|@r2-value>bairro|@r3-value>cidade|@r4-value>uf,0' autocomplete="off"/>
   </label>
  <label style="width:150px">
    Endere&ccedil;o<input type="text" id='endereco' name="endereco" value="<?=$eleitor->endereco?>" maxlength="44"/>
    </label>
	<label style="width:150px">
    Cidade<input type="text" id='cidade' name="cidade" value="<?=$eleitor->cidade?>" maxlength="44"/>
    </label>
    <div style="clear:both"></div>
    <label style="width:150px">
   	UF<input name="estado" id="uf" type="text" value="<?=$eleitor->estado?>"  />
   </label>
   <label style="width:150px">
    Bairro
    	<input type="text" id="bairro" name="bairro" value="<?=$eleitor->bairro?>"   />
    </select>
    </label>
    <label style="width:200px">
    Regiao/Setor/Area
    <select name="regiao_id">
    <option></option>
	<?
	$regioes_q=mysql_query("SELECT * FROM eleitoral_regioes WHERE vkt_id=$vkt_id");
	while($regiao=mysql_fetch_object($regioes_q)){
	 ?>
    	<option <? if($eleitor->regiao_id==$regiao->id){echo "selected='selected'";} ?> value="<?=$regiao->id?>"><?=$regiao->sigla." ".$regiao->descricao?></option>
    <? } ?>
    </select>
    </label>
    <div style="clear:both"></div>
    
    <label style="width:300px">
    Colaborador
    <?
    if($eleitor->id>0){
		$coordenador=mysql_fetch_object(mysql_query($trace="SELECT c.id as id,c.nome as nome,f.nome as funcao FROM eleitoral_colaboradores as c, eleitoral_funcoes as f WHERE c.funcao_id=f.id AND c.id='".$eleitor->coordenador_id."'"));
		//echo $trace;	
	}
	?>
    <input type="text" id='busca_coordenador' name="busca_coordenador" value="<?=$coordenador->nome." ".$coordenador->funcao?>" busca='modulos/eleitoral/eleitores/busca_colaborador.php,@r0 @r1,@r0-value>busca_coordenador|@r2-value>coordenador_id,0'/>   
    <input type="hidden" id="coordenador_id" name="coordenador_id" value="<?= $coordenador->id ?>" />
	</label>
    
    <label style="width:200px">
    Relacionamento
	<select name="vinculo_coordenador_id" id="vinculo_coordenador_id">
  		<option></option>
		<?
			$vinculos_q = mysql_query("SELECT * FROM eleitoral_vinculos");
			while($vinculo = mysql_fetch_object($vinculos_q)){
		?>
        	<option <? if($eleitor->vinculo_coordenador_id==$vinculo->id){echo "selected='selected'";} ?> value="<?= $vinculo->id?>"><? echo $vinculo->nome?></option>
        <?		
			}			
		?>
	</select>
	</label>
</fieldset>
<fieldset id='campos_2' style="display:none" >
  <legend>
 		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)"><strong>Dados Cadastrais</strong></a>
		<a onclick="aba_form(this,2)">Dados Sociais</a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>  </legend>
 <label style="width:100px;">
    RG<input type="text" id='rg' name="rg" value="<?=$eleitor->rg?>" autocomplete='off' sonumero='1' />
  </label>
  <label style="width:100px;">
    CPF<input type="text" id='cpf' name="cpf" value="<?=$eleitor->cpf?>" autocomplete='off' mascara='___.___.___-__' sonumero='1' />
  </label> 
  <label style="width:100px;">
  Título de Eleitor <input type="text" id='titulo_eleitor' name="titulo_eleitor" value="<?=$eleitor->titulo_eleitor?>"  maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <?
  	//$nomezona = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_zonas WHERE id='".$eleitor->zona."'"));
  ?>
  <label style="width:50px;">
  Zona<input type="text" name="zona_nome_busca" id="zona_nome_busca" value="<?=$eleitor->zona?>" autocomplete="off" 
  busca='modulos/eleitoral/eleitores/busca_zona.php,@r0,@r0-value>zona_nome_busca,0'>
    <input type="hidden" id="zona_id" name="zona_id" value="<?=$nomezona->id?>" />
  </label> 
  <label style="width:50px;">
  Secao<input id="secao_nome_busca" name="secao_nome_busca" onfocus="adicionaBusca(this)" value="<?=$eleitor->secao?>" autocomplete="off"> 
  </label>
  <label style="width:150px;">
  Local<input id="local_nome_busca" name="local_nome_busca" value="<?=$eleitor->local?>"  autocomplete="off" readonly="readonly"> 
  </label>
  
  <label style="width:85px;">Status do Voto
  <select name="status_voto" id="status_voto">
    <option></option>
    <option <? if($eleitor->status_voto=='sim')echo "selected='selected'";?> value="sim">certo</option>
    <option <? if($eleitor->status_voto=='nao')echo "selected='selected'";?> value="nao">nao</option>
    <option <? if($eleitor->status_voto=='incerto')echo "selected='selected'";?> value="incerto">incerto</option>
    <option <? if($eleitor->status_voto=='aberto')echo "selected='selected'";?> value="aberto">Em aberto</option>
  </select>
  </label>
  <div style="clear:both"></div>
  <label style="width:350px;">
  Profissão
	<input name="profissao_id" id="profissao_id" value="<?=$eleitor->profissao_id?>" busca='modulos/eleitoral/eleitores/busca_profissoes.php,@r0 ,@r0-value>profissao_id,0' autocomplete="off"> 
    <!--<input type="hidden" id="profissao_id" name="profissao_id" value="<?=$profissao->id?>" />-->
  </label>
  <div style="clear:both"></div>
  <label style="width:350px;">
  	 Empresa<input type="text" id='empresa' name="empresa" value="<?=$eleitor->empresa?>" autocomplete='off' maxlength="44"/>	
  </label>
  <div style="clear:both"></div>
  <label>Intenção de Voto 
  <input id="politico_nome_busca" value="" busca='modulos/eleitoral/eleitores/busca_politico.php,@r0 @r1 @r2 @r3,@r4-value>politico_id_busca|@r1-value>politico_cargo_busca|@r2-value>politico_partido_busca|@r3-value>politico_coligacao_busca,0' autocomplete="off"> 
  <input type="hidden" id="politico_id_busca" value="" />
  <input type="hidden" id="politico_cargo_busca" value="" />
  <input type="hidden" id="politico_partido_busca" value="" />
  <input type="hidden" id="politico_coligacao_busca" value="" />
  </label><a class="mais" target="carregador" style="margin-top:18px; float:left;" onclick="manipulaPolitico(this)"></a>
  <label>Origem 
  <input id="origem" value="<?=$eleitor->origem?>" name="origem" type="text"> 

  </label>
  <div style="clear:both"></div>
  
  <table style="width:505px;  float:left; " cellpadding="0" cellspacing="0">
  	<thead>
    <tr>
    <td width="150">Político</td><td width="100">Cargo</td><td width="70">Partido</td><td>Coligação</td><td></td>
    </tr></thead>
    
    <tbody id="lista_politicos" style="background-color:white;">
    <? 
	$i=0;
	if($id>0){
	if(mysql_num_rows($politicos_q)>0){
	while($politico=mysql_fetch_object($politicos_q)){ 
	if($i%2==0){$sel="al";}else{$sel='';}
	?>
    	<tr id="<?=$i?>" class="aplicavel <?=$sel?>" >
            <td><?=$politico->nome?></td>
            <td><?=$politico->cargo?></td>
            <td><?=$politico->coligacao?></td>
            <td><?=$politico->partido?></td>
            <td>
            	<input type="hidden" class="elemento_retiravel_politicos" name="politico_id[]" value="<?=$politico->id?>"   />
            	<input value="X" type="button" onclick="retiraPolitico(this);"   />
            </td>
        </tr>
    <? 
	$i++; }
	}
	else{ ?>
		
		<tr id="0" class="aplicavel" >
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
            	<input type="hidden" class="elemento_retiravel_politicos" name="politico_id[]" value=""   />
            	<input value="X" type="button" onclick="retiraPolitico(this);"   />
            </td>
        </tr>
		
	<? }
	}else{ ?>
		
		<tr id="0" class="aplicavel" >
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
            	<input type="hidden" class="elemento_retiravel_politicos" name="politico_id[]" value=""   />
            	<input value="X" type="button" onclick="retiraPolitico(this);"   />
            </td>
        </tr>
		
	<? }?>
    </tbody>
  </table>
</fieldset>
<fieldset id='campos_3'  style="display:none">
  <legend>
 		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)"><strong>Dados Sociais</strong></a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>  </legend>
  <label style="width:85px;">Renda Familiar
    <input type="text" id='renda' name="renda_familiar" value="<?=moedaUsaToBr($eleitor->renda_familiar)?>" autocomplete='off' maxlength="44" sonumero='1' decimal="2"/>
  </label>
  <label style="width:120px;"> 
  	Numero de Pessoas<input type="text" id='num_integrantes_familia' name="num_integrantes_familia" value="<?=$eleitor->num_integrantes_familia?>" maxlength="44" />
  </label>
  <label style="width:120px;">
  	Grau de Instrucao
    <select name="grau_instrucao">
    	<option></option>
        <option <? if($eleitor->grau_instrucao=='analfabeto')echo "selected='selected'"; ?> value="analfabeto">Analfabeto</option>
        <option <? if($eleitor->grau_instrucao=='fundamental incompleto')echo "selected='selected'"; ?> value="fundamental incompleto">Fundamental Incompleto</option>
        <option <? if($eleitor->grau_instrucao=='fundamental completo')echo "selected='selected'"; ?> value="fundamental completo">Fundamental Completo</option>
        <option <? if($eleitor->grau_instrucao=='emincompleto')echo "selected='selected'"; ?> value="emincompleto">Ensino Médio Incompleto</option>
        <option <? if($eleitor->grau_instrucao=='emcompleto')echo "selected='selected'"; ?> value="emcompleto">Ensino Médio Completo</option>
        <option <? if($eleitor->grau_instrucao=='superior incompleto')echo "selected='selected'"; ?> value="superior incompleto">Superior Incompleto</option>
        <option <? if($eleitor->grau_instrucao=='superior completo')echo "selected='selected'"; ?> value="superior completo">Superior Completo</option>
        <option <? if($eleitor->grau_instrucao=='outros')echo "selected='selected'"; ?> value="outros">Outros</option>
    </select>
  </label>
  <label style="width:120px;">
  	Grupo Social
    <select name="grupo_social_id">
    <option></option>
    <? 
	$grupo_social_q=mysql_query("SELECT * FROM eleitoral_grupos_sociais WHERE vkt_id=$vkt_id");
	while($grupo_social=mysql_fetch_object($grupo_social_q)){
	?>
    	<option <? if($eleitor->grupo_social_id==$grupo_social->id){echo "selected='selected'";} ?> value="<?=$grupo_social->id?>"><?=$grupo_social->nome?></option>
    <? } ?>
    </select>
  </label>
  <div style="clear:both"></div>
<label style="width:170px;">
  	Religiao
      <select name="religiao_id">
    <?
	if($eleitor->id>0){
		$nomereligiao = mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_religioes WHERE vkt_id=$vkt_id AND id=".$eleitor->religiao_id));
		//echo $trace;
	?>
		<option value="<?= $nomereligiao->id?>"><?= $nomereligiao->nome?></option> 
    <?
    }else{
	?>
		<option value="0"/></option>
	<?
    }
	$religioes_q=mysql_query("SELECT * FROM eleitoral_religioes WHERE vkt_id=$vkt_id");
	while($religiao=mysql_fetch_object($religioes_q)){
	 	if($nomereligiao->id!=$religiao->id){
	 ?>
    	<option value="<?=$religiao->id?>"><?=$religiao->nome?></option>
    <? 
		}
	} 
	?>
    </select>
    </label>
  <label style="width:170px;">
  Filiacao Partidaria 
  <select name="filiacao_partidaria_id">
  <option></option>
  <? $filiacao_q=mysql_query("SELECT * FROM eleitoral_partidos WHERE vkt_id=$vkt_id"); 
  while($filiacao=mysql_fetch_object($filiacao_q)){
  ?>
  	<option <? if($eleitor->filiacao_partidaria_id==$filiacao->id) echo "selected='selected'";?> value="<?=$filiacao->id?>"><?=$filiacao->sigla.' - '.$filiacao->nome?></option>
  <? } ?>
  </select>
  </label>
  
  
  
  <div style="clear:both"></div>
  <label style="width:170px;">
	Doenca<input type="text" id='doenca' name="doenca" value="<? if($eleitor->id>0){echo $eleitor->doenca;}else{echo "NENHUMA";}?>" autocomplete='off' maxlength="44" onfocus="ZeraValue(this)" onblur="RenovaValues(this)"/>
  </label>
  <label style="width:170px;">
  Medicamentos <input type="text" id='medicamentos' name="medicamentos" value="<? if($eleitor->id>0){echo $eleitor->medicamentos;}else{echo "NENHUMA";}?>" autocomplete='off' maxlength="44" onfocus="ZeraValue(this)" onblur="RenovaValues(this)"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:170px;">
  	Esporte <input type="text" id='esporte' name="esporte" value="<? if($eleitor->id>0){echo $eleitor->esporte;}else{echo "NENHUMA";}?>" autocomplete='off' maxlength="44" onfocus="ZeraValue(this)" onblur="RenovaValues(this)"/>
  </label>
  <label style="width:170px;">
   Time <input type="text" id='time' name="time" value="<? if($eleitor->id>0){echo $eleitor->time;}else{echo "NENHUMA";}?>" autocomplete='off' maxlength="44" onfocus="ZeraValue(this)" onblur="RenovaValues(this)"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:300px;">
  Origem 
  <input type="text" name="origem" id="origem" value="<?=$eleitor->origem?>" />
  </select>
  </label>
  
</fieldset>
<fieldset id='campos_4' style="display:none;"  >
  <legend>
 		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)">Dados Sociais</a>
		<a onclick="aba_form(this,3)"><strong>Dependentes</strong></a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>  </legend>
  <label style="width:400px;">	
    Nome<input type="text" id='dependente_nome' value="" autocomplete='off'/>
  </label>
  <div style="clear:both"></div>
  <label style="width:190px;">
    Data de Nascimento <input type="text" id='dependente_nascimento' name='dependente_nascimento' autocomplete='off' maxlength="44" mascara='__/__/____'/>
  </label>
  <label style="width:190px;">
  Relação Dependente <select id="dependente_vinculo">
  <option></option>
  <? 
  $vinculo_q=mysql_query("SELECT * FROM eleitoral_vinculos"); 
  while($vinculo=mysql_fetch_object($vinculo_q)){
  ?>
  						<option value="<?=$vinculo->id?>"><?=$vinculo->nome?></option>
                        <? } ?>
					</select> 
  </label>
  <div style="clear:both"></div>
  <label style="width:190px;">
  	Ocupacao<input type="text" id='dependente_ocupacao' autocomplete='off'  value="NENHUMA" onfocus="ZeraValue(this)" maxlength="44" onblur="RenovaValues(this)"/>
  </label>
  <label style="width:190px;">
  	Instituicao <input type="text" id='dependente_instituicao' autocomplete='off'  value="NENHUMA" onfocus="ZeraValue(this)" maxlength="44" onblur="RenovaValues(this)"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:190px;">
    Doenca<input type="text" id='dependente_doenca' autocomplete='off'  value="NENHUMA" onfocus="ZeraValue(this)" maxlength="44" onblur="RenovaValues(this)"/>
  </label>
  <label style="width:190px;">
  Medicamentos<input type="text" id='dependente_medicamentos'  value="NENHUMA" onfocus="ZeraValue(this)" autocomplete='off' maxlength="44" onblur="RenovaValues(this)"/>
  </label>
  <input type="hidden" id="dependente_id" value="" />
  <label style=" float:left; clear:both;">
  	<label id="botao_manipular" ><input type="button" id='acao'  value="Adicionar" onclick="manipulaDependente(this);" /></label>
    <label id="botao_novo" style="display:none"><input type="button" id='novo'  value="Novo"  onclick="apagaValores()" /></label>
    </label>
  <div style="clear:both;"></div>
  <div id="dados">
  <table id="lista_dependentes" style="width:405px;  float:left; " cellpadding="0" cellspacing="0">
  	<thead>
    <tr>
    <td colspan="2">Nome</td>
    </tr></thead>
    <tbody id="dependentes_lista" style="background-color:white;">
    <? 
	if($id>0){
	if(mysql_num_rows($dependentes_q)>0){ 
	$i=0;
		while($dependente=mysql_fetch_object($dependentes_q)){
			if($i%2==0){$sel=" al";}else{$sel="";}
	?>
    	<tr id="<?=$i?>" class="aplicavel <?=$sel?>" >
            <td width="330" onclick="editaDependente(this)"><?=$dependente->nome?></td>
            <td>
            	<input type="hidden" value="<?=$dependente->nome?>" class="elemento_retiravel" name="dependente_nome[]"   />
                <input type="hidden" value="<?=dataUsaToBr($dependente->dt_nascimento)?>" class="elemento_retiravel" name="dependente_nascimento[]"    />
                <input type="hidden" value="<?=$dependente->vinculo_id?>" class="elemento_retiravel" name="dependente_vinculo[]"    />
                <input type="hidden" value="<?=$dependente->ocupacao?>" class="elemento_retiravel" name="dependente_ocupacao[]"    />
                <input type="hidden" value="<?=$dependente->instituicao?>" class="elemento_retiravel" name="dependente_instituicao[]"  />
                <input type="hidden" value="<?=$dependente->doenca?>" class="elemento_retiravel" name="dependente_doenca[]" />
                <input type="hidden" value="<?=$dependente->medicamentos?>" class="elemento_retiravel" name="dependente_medicamentos[]"    />
            	<input value="X" type="button" onclick="retiraDependente(this);"   />
            </td>
        </tr>
    <? $i++;
		}
	}
	else{ ?>
    
    <tr id="0" class="aplicavel" >
            <td width="330" onclick="editaDependente(this)"></td>
            <td>
            	<input type="hidden" value="" class="elemento_retiravel" name="dependente_nome[]"   />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_nascimento[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_vinculo[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_ocupacao[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_instituicao[]"  />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_doenca[]" />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_medicamentos[]"    />
            	<input value="X" type="button" onclick="retiraDependente(this);"   />
            </td>
        </tr>
    
    
    <?
	}
	}else{ ?>
    
    <tr id="0" class="aplicavel" >
            <td width="330" onclick="editaDependente(this)"></td>
            <td>
            	<input type="hidden" value="" class="elemento_retiravel" name="dependente_nome[]"   />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_nascimento[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_vinculo[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_ocupacao[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_instituicao[]"  />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_doenca[]" />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_medicamentos[]"    />
            	<input value="X" type="button" onclick="retiraDependente(this);"   />
            </td>
        </tr>
    
    
    <?
	}?>
    </tbody>
  </table>
 
  </div>
</fieldset>
<fieldset id='campos_5' style="display: none" >
  <legend>
 		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)">Dados Sociais</a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)"><strong>Bens e Posses</strong></a>  </legend>
  <table cellpadding="0"  cellspacing="0">
  	<thead>
    	<tr>
        	<td width="100">Bens de Posse</td><td width="50">Qtd</td><td width="300" align="center";>Serviços</td>
        </tr>
    </thead>
    <? 
	function verificaServico($servico, $lista){
		if(in_array($servico,explode(',',$lista))){ echo "checked='checked'";}
	}
	?>
  	<tbody>
    	<tr style="background-color:white;">
        	<td>Imóvel</td>
            <td><input style="width:20px; height:10px;" type="text" name="imovel_qtd" value="<?=$eleitor->imovel_qtd?>" /></td>
            <td>
            	Placa/Outdoor<input type="checkbox" <? verificaServico('placa/outdoor',$eleitor->imovel_servicos) ?> value="placa/outdoor" name="imovel_servicos[]" />
            </td>
       </tr>
       <script>
       </script>
        <tr class="al" style="background-color:white;">
        	<td>Carro Gasolina</td><td>
            	<input style="width:20px; height:10px;" type="text" value="<?=$eleitor->carro_gasolina_qtd?>" name="carro_gasolina_qtd" /></td>
            <td>
            Adesivo<input type="checkbox" value="adesivo" id="adesivo1" <?=verificaServico('adesivo',$eleitor->carro_gasolina_servicos)?> name="carro_gasolina_servicos[]" />
            Passeata<input type="checkbox" value="passeata" id="passeata1" <?=verificaServico('passeata',$eleitor->carro_gasolina_servicos)?> name="carro_gasolina_servicos[]" />
            Serviço<input type="checkbox" value="servicos" id="servicos1" <?=verificaServico('servicos',$eleitor->carro_gasolina_servicos)?> name="carro_gasolina_servicos[]" />
            </td>
        </tr>
        <tr style="background-color:white;">
        	<td>Carro Diesel</td>
            <td><input style="width:20px; height:10px;" type="text" name="carro_diesel_qtd" value="<?=$eleitor->carro_diesel_qtd?>" /></td>
            <td>
            	Adesivo<input type="checkbox" value="adesivo" <?=verificaServico('adesivo',$eleitor->carro_diesel_servicos)?> name="carro_diesel_servicos[]" />
            	Passeata<input type="checkbox" value="passeata" <?=verificaServico('passeata',$eleitor->carro_diesel_servicos)?> name="carro_diesel_servicos[]" />
            	Serviço<input type="checkbox" value="servicos" <?=verificaServico('servicos',$eleitor->carro_diesel_servicos)?> name="carro_diesel_servicos[]" />
            </td>
        </tr>
        <tr class="al" style="background-color:white;">
        	<td>Moto</td>
            <td><input style="width:20px; height:10px;" type="text" name="moto_qtd" value="<?=$eleitor->moto_qtd?>" /></td>
            <td>
            	Adesivo<input type="checkbox"value="adesivo" <?=verificaServico('adesivo',$eleitor->moto_servicos)?> name="moto_servicos[]" />
                Passeata<input type="checkbox" value="passeata" <?=verificaServico('passeata',$eleitor->moto_servicos)?> name="moto_servicos[]" />
                Serviço<input type="checkbox" value="servicos" <?=verificaServico('servicos',$eleitor->moto_servicos)?> name="moto_servicos[]" />
           </td>
        </tr>
        <tr style="background-color:white;">
        	<td>Lancha</td>
            <td><input style="width:20px; height:10px;" type="text" name="lancha_qtd" value="<?=$eleitor->lancha_qtd?>" /></td>
            <td>
            	Adesivo<input type="checkbox" value="adesivo" <?=verificaServico('adesivo',$eleitor->lancha_servicos)?> name="lancha_servicos[]" />
                Serviço<input type="checkbox" value="servicos" <?=verificaServico('servicos',$eleitor->lancha_servicos)?> name="lancha_servicos[]" />
           </td>
        </tr>
        <tr style="background-color:white;">
        	<td>Barco</td>
            <td><input style="width:20px; height:10px;" type="text" name="barco_qtd" value="<?=$eleitor->barco_qtd?>" /></td>
            <td>
            	Adesivo<input type="checkbox" value="adesivo" <?=verificaServico('adesivo',$eleitor->barco_servicos)?> name="barco_servicos[]" />
                Serviço<input type="checkbox" value="servicos" <?=verificaServico('servicos',$eleitor->barco_servicos)?> name="barco_servicos[]" />
           </td>
        </tr>
    </tbody>
  </table>
  <label style="width:398px;height:100px; margin-top:10px;">
	Observacoes <textarea id="descricao_bens" name="descricao_bens" rows="5"><?=$eleitor->descricao_bens?></textarea>
  </label>
</fieldset>
<input type="checkbox" name="receber_email" id="receber_email" <? if($eleitor->recebe_email=="sim"||empty($eleitor->recebe_email)){echo "checked='checked'";} ?>/>Desejo Receber E-mails
<div style="clear:both"></div>
<input type="checkbox" name="receber_sms" id="receber_sms" <? if($eleitor->recebe_sms=="sim"||empty($eleitor->recebe_sms)){echo "checked='checked'";} ?>/>Desejo Receber SMS
<input name="id" type="hidden" value="<?=$id?>" />

<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" ></div>
<!---------------------------------------------------Dados cadastrais----------------------->
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<?
if($id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit" value="Salvar" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>