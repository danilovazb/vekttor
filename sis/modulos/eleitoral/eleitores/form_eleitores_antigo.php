<?
//Includes
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 
print_r($_POST);
print_r($_GET);
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
<form onsubmit="return validaForm(this)" class="form_float" method="post">
<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
<fieldset id='campos_1' >
<legend>
 		<a onclick="aba_form(this,0)"><strong>Dados Principais</strong></a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)">Dados Sociais</a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>

</legend>
  <label style="width:311px;">
    Nome
    <input type="text" id='nome' name="nome" value="" autocomplete='off' maxlength="44"/>
  </label>
  <label>
    Apelido
    <input type="text" id='apelido' name="apelido" value="" autocomplete='off' maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:150px"> 
  Data de Nascimento
  <input type="text" id='data_nascimento' name="data_nascimento" value="" autocomplete='off' maxlength="44" mascara='__/__/____' calendario='1'/>
  </label>
  <label style="width:120px">Telefone1 
    <input type="text" id='telefone1' name="telefone1" value="" autocomplete='off' maxlength="44" mascara="(__)____-____"/> 
  </label>
  <label style="width:120px">Telefone 2
  <input type="text" id='telefone2' name="telefone2" value="" maxlength="44" mascara="(__)____-____"/>
  </label>
  <br />
  <label style="width:120px">E-mail
  <input type="text" id='email' name="email" value="" maxlength="44"/>
  </label>
  <label style="width:99px">Estado Civil
  <select name="estado_civil" id="estado_civil">
    <option value="casado">casado(a)</option>
    <option value="divorciado">divorciado(a)</option>
    <option value="separado">separado(a)</option>
    <option value="solteiro">solteiro(a)</option>
    <option value="ue">Uniao Estavel</option>
    <option value="viuvo">Viuvo(a)</option>
  </select>
  </label>
  
  <label style="width:200px">
  Naturalidade
  <input type="text" id='naturalidade' name="naturalidade" autocomplete='off' maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:150px">
    Endere&ccedil;o<input type="text" id='endereco' name="endereco" value="" maxlength="44"/>
    </label>
  <label style="width:150px">
    Bairro<input type="text" id='bairro' name="bairro" value="" maxlength="44"/>
    </label>
	<label style="width:150px">
    Cidade<input type="text" id='cidade' name="cidade" value="" maxlength="44"/>
    </label>
    <div style="clear:both"></div>
    <label style="width:150px">
   	UF<input name="estado" type="text"  />
   </label>
   <label style="width:150px">CEP
  	<input type="text" id='cep' name="cep" value="" maxlength="44"/>
   </label>
    <label style="width:200px">
    Regiao/Setor/Area<input type="text" id='regiao_id' name="regiao_id" value="" autocomplete='off' maxlength="44"/>
    </label>
    <div style="clear:both"></div>
    
    <label style="width:300px">
    Nome
   <input type="text" id='nome_vinculo' name="nome_vinculo[]" value="" autocomplete='off' maxlength="44"/>
	</label>
    
    <label style="width:200px">
    Relacionamento
	<select name="coordenador_id" id="coordenador_id">
  		<?
			$vinculos_q = mysql_query("SELECT * FROM eleitoral_vinculos");
			while($vinculo = mysql_fetch_object($vinculos_q)){
		?>
        	<option value="<? $vinculo->id?>"><? echo $vinculo->vinculo?></option>
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
    CPF<input type="text" id='cpf' name="cpf" value="" autocomplete='off' maxlength="44" mascara="___.___.___-__"/>
  </label> 
  <label style="width:100px;">
  Título de Eleitor <input type="text" id='titulo_eleitor' name="titulo_eleitor" value=""  maxlength="44"/>
  </label>
  <label style="width:50px;">
  Zona<input type="text" name="zona" id='zona' value="" size="10" maxlength="44"/> 
  </label>
  <label style="width:50px;">
  Secao <input type="text" name="secao" id='secao' autocomplete='off' value="" size="10" maxlength="44"/>
  </label>
  <label style="width:120px;">
  Local <input type="text" id='local' autocomplete='off' value="" size="10" maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:85px;">Status do Voto
  <select name="status_voto" id="status_voto">
    <option value="sim">certo</option>
    <option value="nao">nao</option>
    <option value="incerto">incerto</option>
    <option value="aberto">Em aberto</option>
  </select>
  </label>
  <label style="width:120px;">
  Placa/Outdor
  <select name="outdoor" id="outdoor">
 	<option value="naocontactado" selected="selected">Nao Contactado</option>
    <option value="autorizado">Autorizado</option>
    <option value="naoautorizado">Nao Autorizado</option>
    <option value="naoinstalado">Instalado</option>
  </select> 
  </label>
  <label style="width:120px;">
  Adesivo
  <select name="adesivo" id="adesivo">
  	<option value="naocontactado" selected="selected">Nao Contactado</option>
    <option value="autorizado">Autorizado</option>
    <option value="naoautorizado">Nao Autorizado</option>
    <option value="naoinstalado">Instalado</option>
  </select>
  </label>
  <label style="width:120px;">
  Carro Passeata
      <select name="carro_passeata" id="carro_passeata">
        <option value="naocontactado" selected="selected">Nao Contactado</option>
        <option value="autorizado">Autorizado</option>
        <option value="naoautorizado">Nao Autorizado</option>
        <option value="naoinstalado">Instalado</option>
      </select>
  </label>
  <div style="clear:both"></div>
  <label style="width:350px;">
	Profissao <input type="text" id='profissao_id' name="profissao_id" value="" autocomplete='off' maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:350px;">
  	 Empresa<input type="text" id='empresa' name="empresa" value="" autocomplete='off' maxlength="44"/>	
  </label>
  <div style="clear:both"></div>
</fieldset>
<fieldset id='campos_3'  style="display:none">
  <legend>
 		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)"><strong>Dados Sociais</strong></a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>  </legend>
  <label style="width:85px;">Renda Familiar
    <input type="text" id='renda' name="renda_familiar" value="" autocomplete='off' maxlength="44" sonumero='1' decimal="2"/>
  </label>
  <label style="width:120px;"> 
  	Numero de Pessoas<input type="text" id='num_integrantes_familia' name="num_integrantes_familia" value="" maxlength="44" />
  </label>
  <label style="width:120px;">
  	Grau de Instrucao
    <select name="grau_instrucao">
    	<option value="analfabeto">Analfabeto</option>
        <option value="fundamental incompleto">fundamental incompleto</option>
        <option value="fundamental completo">fundamental completo</option>
        <option value="superior incompleto">superior incompleto</option>
        <option value="superior completo">superior completo</option>
    </select>
  </label>
  <div style="clear:both"></div>
  <label style="width:170px;">
  	Religiao <input type="text" name="religiao" id='religiao' autocomplete='off' value="" maxlength="44"/>
  </label>
  <label style="width:170px;">
  Filiacao Partidaria <input type="text" name="filiacao_partidaria_id" id='filiacao_partidaria_id' autocomplete='off' value="" maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:170px;">
	Doenca<input type="text" id='doenca' name="doenca" value="" autocomplete='off' maxlength="44"/>
  </label>
  <label style="width:170px;">
  Medicamentos <input type="text" id='medicamentos' name="medicamentos" value="" autocomplete='off' maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:170px;">
  	Esporte <input type="text" id='esporte' name="esporte" value="" autocomplete='off' maxlength="44"/>
  </label>
  <label style="width:170px;">
   Time <input type="text" id='time' name="time" value="" autocomplete='off' maxlength="44"/>
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
    Nome<input type="text" id='dependente_nome' name="dependente_nome[]" value="" autocomplete='off'/>
  </label>
  <div style="clear:both"></div>
  <label style="width:190px;">
    Data de Nascimento <input type="text" id='dependente_nascimento' name="dependente_nascimento[]" value="" autocomplete='off' maxlength="44" mascara='__/__/____' calendario='1'/>
  </label>
  <label style="width:190px;">
  Relação Dependente <select name="dependente_vinculo[]" id="dependente_vinculo">
  						<option value="pai">Pai</option>
  						<option value="mae">Mae</option>
  						<option value="irmao">irmao</option>
					</select> 
  </label>
  <div style="clear:both"></div>
  <label style="width:190px;">
  	Ocupacao<input type="text"  name="dependente_ocupacao[]" id='dependente_ocupacao' autocomplete='off' value="" maxlength="44"/>
  </label>
  <label style="width:190px;">
  	Instituicao <input type="text" name="depedente_instituicao[]" id='dependente_instituicao' autocomplete='off' value="" maxlength="44"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:190px;">
    Doenca<input type="text" id='dependente_doenca' name="dependente_doenca[]" value="" autocomplete='off' maxlength="44"/>
  </label>
  <label style="width:190px;">
  Medicamentos<input type="text" id='dependente_medicamentos' name="dependente_medicamentos[]" value="" autocomplete='off' maxlength="44"/>
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
    	<tr id="0" class="aplicavel" >
            <td width="330" onclick="editaDependente(this)"></td>
            <td>
            	<input type="hidden" value="" class="elemento_retiravel" name="dependente_nome[]"   />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_nascimento[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_vinculo[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_ocupacao[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="depedente_instituicao[]"  />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_doenca[]" />
                <input type="hidden" value="" class="elemento_retiravel" name="dependente_medicamentos[]"    />
            	<input value="Exc" type="button" onclick="retiraDependente(this);"   />
            </td>
        </tr>
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
  <label style="width:190px;">
  Tipo do Bem<select id="tipo_bem">
      <option value="apartamento">Apartamento</option>
      <option value="casa">Casa</option>
      <option value="caminhão">Caminh&atilde;o</option>
      <option value="carro">carro</option>
      <option value="barco">Barco</option>
    </select>
    </label> 
    <label style="width:190px;">
    Tipo/Modelo/Marca(descricao) <input type="text" id='titulo_bem' autocomplete='off' value="" maxlength="44"/>
  	</label>
    <input type="hidden" id="bem_id" value="" />
    <div style="clear:both;"></div>
    <label>
    	<input type="button" id="acao_bem" value="Adicionar" onclick="manipulaBem(this)" />
    </label>
  <div style="clear:both"></div>
  <label style="width:398px;height:100px;">
	Observacoes <textarea id="descricao_bem" rows="5"></textarea>
  </label>
  <div id="dados_bens">
  <table style="width:405px;  float:left; " cellpadding="0" cellspacing="0">
  	<thead>
    <tr>
    <td width="260">Tipo/Modelo/Marca(descricao)</td><td width="60">Tipo</td><td></td>
    </tr></thead>
    <tbody id="bens_lista" style="background-color:white;">
    	<tr id="0" class="aplicavel" >
            <td width="260"></td>
            <td></td>
            <td>
            	<input type="hidden" value="" class="elemento_retiravel" name="titulo_bem[]"   />
                <input type="hidden" value="" class="elemento_retiravel" name="tipo_bem[]"    />
                <input type="hidden" value="" class="elemento_retiravel" name="descricao_bem[]"    />
            	<input value="Exc" type="button" onclick="retiraBem(this);"   />
            </td>
        </tr>
    </tbody>
  </table>
 
  </div>
</fieldset>
<input name="id" type="hidden" value="<?=$unidade->id?>" />

<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" ></div>
<!---------------------------------------------------Dados cadastrais----------------------->
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<?
if($unidade->id>0){
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