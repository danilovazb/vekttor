<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
//print_r($_GET);




if($_GET[responsavel_id]>0){
	$qr = mysql_query($t="SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id ='$vkt_id' AND id='{$_GET[responsavel_id]}'");
	$responsavel = mf($qr);
}
if($matricula->responsavel_id){
	$qr = mysql_query($t="SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id ='$vkt_id' AND id='$matricula->responsavel_id' ");
	$responsavel = mf($qr);
}
if($_GET[cnpj_cpf]){
	$qr = mysql_query($t="SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id ='$vkt_id' AND cnpj_cpf='{$_GET[cnpj_cpf]}'");
	$responsavel = mf($qr);
}

if($_GET[cnpj_cpf]&&$responsavel->id<1){
	exit();
}
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:850px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Matrícula</span></div>
</div>
	<form class="form_float" method="post" onsubmit="document.getElementById('tipo_cadastro').value=document.getElementById('seleciona_tipo_cadastro').value;return validaForm(this);" enctype="multipart/form-data" id='form_matricula' autocomplete='off'>
	  <fieldset id="campos_1" >
       	  <legend>
          <strong>Matricula</strong> 
          </legend>
        <div id='paidaspaginas' style="width:772px; overflow:hidden;">
        <div id='pagina_id_1' class='paginamatricula' style="width:770px;">
        
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
				<input type="text" id='f_cnpj_cpf' <?=$desabilita['Jurídico']?> onkeyup="checa_cpf(this)" name="f_cnpj_cpf" value="721.735.722-53" mascara="___.___.___-__" sonumero='1' retorno="focus|Digite o CPF corretamente" valida_cpf='1'/>
			</label>
            
         <label id="cnpj" style="width:120px; margin-right:22px;<?=$desaparece['Físico']?>">
				CNPJ
				<input type="text" id='f_cnpj_cpf' <?=$desabilita['Físico']?> name="f_cnpj_cpf" value="<?=$responsavel->cnpj_cpf?>" mascara="__.___.___/____-__" sonumero='1' retorno="focus|Digite o CNPJ corretamente"/>
			</label>
			<label style="width:240px; margin-right:23px;">
				Nome
				do Respons&aacute;vel<br />
				<input type="text" id='f_nome_contato' name="f_nome_contato" value="Gilvandro de Souza Silva" retorno="focus|Digite o nome corretamente" valida_minlength='3'/>
			</label>
             <label style="width:70px;">
				Nascimento
				<input type="text" mascara='__/__/____' id='f_nascimento' name="f_nascimento" value="14/11/1983" retorno="focus|Digite a data de nascimento" valida_minlength='1' valida_data='01/01/0001,99/99/9999'/>
			</label>
            <label style="width:120px;">
  	Grau de Instrucao
    <select name="f_grau_instrucao" >
        <option <? if($responsavel->grau_instrucao=='superior incompleto')echo "selected='selected'"; ?> value="superior incompleto">Superior Incompleto</option>
        <option <? if($responsavel->grau_instrucao=='superior completo')echo "selected='selected'"; ?> value="superior completo">Superior Completo</option>
        <option <? if($responsavel->grau_instrucao=='outros')echo "selected='selected'"; ?> value="outros">Outros</option>
    </select>
  </label>
<div style="clear:both"></div>			<label style="width:120px;">
				Ramo de Atividade
				<input type="text" id='f_ramo_atividade' name="f_ramo_atividade" value="Carpinteiro" />
			</label>
            
			<label style="width:100px; margin-right:23px;">
				RG
				<input type="text" id='f_rg' name="f_rg" value="145333-53"  sonumero='1' retorno="focus|Digite o RG corretamente" valida_minlength='3' />
			</label>
            <label style="width:100px; margin-right:22px;">
				Local de Emissão
				<input type="text" id='f_local_emissao' name="f_local_emissao" value="SESEG" />
			</label><label style="width:90px; margin-right:22px;">
				Data Emissao
				<input type="text" mascara='__/__/____' onfocus="this.select" clendario='1' id='f_data_emissao' name="f_data_emissao" value="14/11/2006" />
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
				<input type="text" id='f_naturalidade' name="f_naturalidade" value="Manacapuru" />
			</label>
            <label style="width:126px;">
				Nacionalidade
				<input type="text" id='f_nacionalidade' name="f_nacionalidade" value="Brasileiro" />
			</label>
            <div style="clear:both"></div>
            <label style="width:194px; margin-right:23px;">
				Email
				<input type="text" id='f_email' name="f_email" value="gilvandro@vekttor.com"  retorno="focus|Digite o email corretamente" valida_minlength='3' />
			</label>
            
			<label style="width:100px; margin-right:23px;">
				Telefone 1
				<input type="text" id='f_telefone1' name="f_telefone1" value="(92)3533-4203" mascara="(__)____-____" sonumero='1' retorno="focus|Digite o telefone corretamente" valida_minlength='3'/>
			</label>
			<label style="width:100px; margin-right:22px;">
				Telefone 2
				<input type="text" id='f_telefone2' name="f_telefone2" value="(92)9202-2909" mascara="(__)____-____" sonumero='1' />
			</label>
			<label style="width:100px; margin-right:23px;">
				Fax
				<input type="text" id='f_fax' name="f_fax" value="(92)3533-4203" mascara="(__)____-____" sonumero='1' />
			</label>
			<div style="clear:both"></div>
            <label style="width:136px; margin-right:22px;">
				Cep
				<input type="text" id='f_cep' name="f_cep" value="69153-160" mascara="_____-___" sonumero='1' onkeyup="cp=this.value.replace(/\_/g,'' );document.title=cp;if(cp.length==9){return vkt_ac(this,event,'undefined','modulos/escolar/responsavel/busca_endereco.php','@r0','funcao_bsc(this,\'@r0-value>f_cep|@r1-value>f_endereco|@r2-value>f_bairro|@r3-value>f_cidade|@r4-value>f_estado\',\'f_cep\')')}" autocomplete="off" retorno="focus|Digite o CEP corretamente" valida_minlength='3'/>
			</label>
			 <label style="width:190px; margin-right:23px;">
				Endereço
				<input type="text" id='f_endereco' name="f_endereco" value="Rua: 15 de outubro 2037" retorno="focus|Digite o Endereco corretamente" valida_minlength='3'/>
			</label>
            <label style="width:136px; margin-right:23px;">
				Bairro
				<input type="text" id='f_bairro' name="f_bairro" value="Palmares" retorno="focus|Digite o Bairro corretamente" valida_minlength='3'/>
			</label>
			<label style="width:136px; margin-right:22px;">
				Cidade
				<input type="text" id='f_cidade' name="f_cidade" value="Manacapuru" retorno="focus|Digite a cidade corretamente" valida_minlength='3'/>
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
            <!-- fim div campos 1 -->
          </div>
  <div id='pagina_id_2' class='paginamatricula axluml' style="width:770px;  display:none">
  			
            <div style="float:left; width:620px;">
       		<div class='' style="clear:both;">
       		  <label><input type="checkbox" name="mesmo" value="0" style="width:inherit" class="endereco_mesmo"/>
           	Necessita Transporte Escolar</label>
            <div style="clear:both;"></div>
            </div>
			<label style="width:294px;">
				Nome do Aluno
				  <input type="text" id="nome" name="nome[]" value="<?=$d->nome; ?>"  retorno="focus|Digite o nome do aluno " valida_minlength='3'  onkeyup="if(this.value.length>2){return vkt_ac(this,event,'undefined','modulos/escolar/alunos_inscritos/busca_aluno.php','@r0 @r2 @r3 ','funcao_bsc(this,\'@r0-value>nome|@r1-value>aluno_id|@r2-value>data_nascimento|@r4-value>endereco|@r5-value>bairro|@r6-value>escolaridade|@r7-value>profissao|@r8-value>complemento|@r9-value>telefone1|@r10-value>telefone2|@r11-value>cep|@r12-value>uf|@r13-value>rg|@r14-value>rg_dt_expedicao|@r15-value>cpf|@r16-value>email|@r17-value>cidade|\',\'nome\')')}" />
			</label>
                  <!-- 
                  $->nome|	@r0-value>nome|
                  $r->id|	@r1-value>aluno_id|
                  $r->nascimento|	@r2-value>data_nascimento|
                  $r->age|	
                  $r->endereco|	@r4-value>endereco|
                  $r->bairro|	@r5-value>bairro|
                  $r->escolaridade|	@r6-value>escolaridade|
                  $r->profissao|	@r7-value>profissao|
                  $r->complemento|	@r8-value>complemento|
                  $r->telefone1|	@r9-value>telefone1|
                  $r->telefone2|	@r10-value>telefone2|
                  $r->cep|	@r11-value>cpf|
                  $r->uf|	@r12-value>uf|
                  $r->rg|	@r13-value>rg|
                  $r->rg_dt_expedicao|	@r14-value>rg_dt_expedicao|
                  $r->cpf|	@r15-value>cpf|
                  $r->email|	@r16-value>email|
                  -->
            <label style="width:120px;">
				Data de Nascimento
				<input type="text" onkeyup="verifica_idade(this)" valida_idade='0,99' id="data_nascimento" name="data_nascimento[]" mascara="__/__/____" sonumero="1" value="<?=dataUsaToBr($d->data_nascimento); ?>" retorno='focus|Preencha o Aniversário do aluno' valida_data='01/01/0001,99/99/9999' />
			</label>
             
            
            <label style="width:120px;">
				Escolaridade
				<input type="text" id="escolaridade" name="escolaridade[]" value="<?=$d->escolaridade; ?>" />
			</label>
              
              
            <label style="width:120px;">
				Profissão
				<input type="text" id="profissao" name="profissao[]"  value="<?=$d->profissao; ?>" />
			</label>
            <label style="width:120px;">
				CPF
				<input type="text" id="cpf" name="cpf[]" value="<?=$d->cpf; ?>" mascara='___.___.___-__' <?
			$idade = calcula_idade( $d->data_nascimento );
			if($idade>=18&&$d->id>0){
				echo " valida_cpf='1' retorno='focus|Digite o CPF corretamente do aluno'";
			}

				?>/>
			</label>
            <label style="width:120px;">
				RG
				<input type="text" id="rg" name="rg[]" sonumero='1' value="<?=$d->rg; ?>" />
			</label>
            
            <label style="width:120px;">
				Data Expedição
				<input type="text" id="rg_dt_expedicao" name="rg_dt_expedicao[]" mascara='__/__/____' value="<?=dataUsaToBr($d->rg_dt_expedicao); ?>" />
			</label>
            
            <label style="width:202px;">
				E-Mail
				<input type="text" id="email" name="email[]" retorno='focus|Coloque o email corretamente' value="<?=$d->email; ?>" />
			</label>
            <label style="width:120px;">
				Telefone Residencial
				<input type="text" id="telefone1" name="telefone1[]" mascara='(__)____-____' value="<?=$d->telefone1; ?>" />
			</label>
            
            <label style="width:120px;">
				Telefone Celular
				<input type="text" id="telefone2" name="telefone2[]" mascara='(__)____-____' value="<?=$d->telefone2; ?>" />
			</label>
            <label style="width:320px;">
				Endereço
				<input type="text" id="endereco" name="endereco[]" value="<?=$d->endereco; ?>" />
			</label>
            
            <label style="width:120px;">
				Bairro
				<input type="text" id="bairro" name="bairro[]" value="<?=$d->bairro; ?>" />
			</label>
            
            <label style="width:120px; margin-right:0;">
				Complemento
				<input type="text" id="complemento" name="complemento[]" value="<?=$d->complemento; ?>" />
			</label>
            
            <label style="width:100px;">
				CEP
				<input type="text" id="cep" name="cep[]" mascara='__.___-___' sonumero='1' value="<?=$d->cep; ?>"  />
			</label>
			
            <label style="width:150px;">
				Cidade
				<input type="text" id="cidade" name="cidade[]" value="<?=$d->cidade; ?>" />
			</label>
            
            <label style="width:50px;">
				UF
				<input type="text" id="uf" name="uf[]" value="<?=$d->uf; ?>" />
			</label>
            
             <label style="width:200px;">
				Portador de Necessidades Especiais
				<input type="text" id="uf" name="uf[]" value="<?=$d->uf; ?>" />
			</label>
            <div style="clear:both"></div>
              <div style="margin-bottom:10px;>
            	Cor<br/>
                <input type="radio" name="cor" value="branco" <? if($d->cor == 'branco') echo 'checked="checked"';?>>Branco
                <input type="radio" name="cor" value="pardo-moreno" <? if($d->cor == 'pardo-moreno') echo $checked = 'checked="checked"';?>>Pardo/Moreno
                <input type="radio" name="cor" value="negro" <? if($d->cor == 'negro') echo $checked = 'checked="checked"';?>>Negro
                <input type="radio" name="cor" value="amarelo" <? if($d->cor == 'amarelo') echo $checked = 'checked="checked"'; ?>>Amarelo
                <input type="radio" name="cor" value="indigena" <? if($d->cor == 'indigena') echo $checked = 'checked="checked"';?>>Indígena
                <input type="radio" name="cor" value="naodeclarado" <? if($d->cor == 'naodeclarado') echo $checked = 'checked="checked"';?>>N&atilde;o Declarado
             </div>
            
           </label>
           
            <label>Código Interno<br/>
            	<input type="text" name="codigo_interno[]" id="codigo_interno" style="width:90px;">
            </label>
            <label style="width:60px;">Cod.Aluno: <?=$d->id?>
            </label>
            <label style="width:60px;">Senha
            	<input type="text" name="senha[]" id="senha" value="<?=$d->senha?>" />
            </label>
            
            <label>	
            	Foto
            		<input type="file" name="file[]" >
            </label>
            <input type="hidden" name="aluno_id[]" id="aluno_id" value="<?=$d->id?>" />
                <input type="hidden"  name="matricula_id[]" value="<?=$_GET[matricula_id]?>"/>

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
            <div style="clear:both;">Onde irá estudar</div>

            <label class='lb_periodo_id'>
            Periodo
            <select name="periodo_id[]" class="periodo_id" 
valida_valor='1,99999999'  retorno='focus|Selecione um período'>
            	<option value="0">Selecione 1 Opção</option>
            	<?
				
				$q = mq($t="SELECT p.* FROM escolar_horarios as h, escolar_periodos as p WHERE p.vkt_id='$vkt_id' AND h.periodo_id=p.id group by h.periodo_id ORDER BY p.inicio_aulas ");
				
				while($r=mf($q)){
					if($r->id==$matricula->periodo_id){$s='selected="selected"';}else{$s='';}
					echo "<option value='$r->id' $s>$r->nome</option>";
				}
				
				?>
            </select>
            <?
           // echo $t;
			?>
            </label>
            
            <label class='lb_escola_id' style="width:150px">
            
Escola
<select name="escola_id[]" class='escola_id' valida_valor='1,99999999' retorno='focus|Selecione uma escolas'>
<option value="0" >Selecione 1 Unidade Antes</option>
</select>            </label>
            
            <label class='lb_curso_id' style="width:150px">
Ensino
<select name="curso_id[]" class='curso_id' valida_valor='1,99999999' retorno='focus|Selecione um Curso'>
<option value="0">Selecione 1 Escola Antes</option>
</select>
            </label>
            
            <label class='lb_modulo_id'  style="width:150px">
Série
<select name="modulo_id[]" class='modulo_id' valida_valor='1,99999999' retorno='focus|Selecione um Módulo'>
<option value="0">Selecione 1 Curso Antes</option>
</select>
            </label>
            <label class='lb_horario_id' >
Hor&aacute;rios
<select name="horario_id[]" class='horario_id' valida_valor='1,99999999' retorno='focus|Selecione um Horario'>
<option value="0">Selecione 1 M&oacute;dulo Antes</option>
</select> 
            </label>
            
            <label class="lb_sala_id">

Salas
<select name="sala_id[]" class='sala_id' >
<option value="0">Selecione 1 Curso Antes</option>
</select>
            </label>

            <label class="lb_tipo_matricula">

Tipo de Matricula
<select name="tipo_matricula[]" class='tipo_matricula' valida_minlength='2' retorno='submit|Selecione o tipo de Matricula' >
<option value="0">Selecione 1 Tipo</option>
<?
$tpmat[$matricula->tipo_matricula]='selected="selected"';
?>
    <option value="MATRÍCULA" <?=$tpmat['MATRÍCULA']?>>MATRÍCULA</option>
    <option value="REMATRÍCULA" <?=$tpmat['REMATRÍCULA']?>>REMATRÍCULA</option>
</select>
            </label>
			</label>
            <?
            if($matricula->id>0){
			?>
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
             <input type="button" onclick="window.open('modulos/boletos/boleto/boleto_bb.php?matricula_id=<?=$matricula->id?>')" value="Imprimir Boleto"   style="float:left;"/>
           <?
			}
		   ?>
            </div>  
        
</div>
            
            <!-- fim div overflow -->
	  </fieldset>
	         
        
          <div style="clear:both; width:100%"></div>
     	<?
	if($_GET[matricula_id]>0){
	?>
	<input name="action" type="submit" value="Excluir" onmousedown="document.getElementById('form_matricula').setAttribute('onsubmit','')" style="float:left" />
    <?
	}
	?>

        <input type="button" name="avancar"  pagina='1' value="Avançar" style="float:right; "  class="avancar"  />
        <input type="submit" name="salvar"  pagina='1' value="Salvar" style="float:right; display:none "  class="salvar"  />
                <input type="button"   value="Voltar" style="float:left; display:none "  class="voltar"  />

        <div style="clear:both">
        </div>
        <span style="float:left; width:650px;">
        <input type="hidden" name="responsavel_id" id="responsavel_id" value="<?=$responsavel->id?>" />
        </span>
	</form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($d->senha)<1){echo "<script>if(document.getElementById('senha').value==''){top.newPass('senha');}</script>";} ?>