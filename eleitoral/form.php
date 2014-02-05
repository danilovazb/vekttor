<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sem t&iacute;tulo</title>
<link href="../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<link href="../fontes/css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" /><!-- -->
<script src="../fontes/js/sis.js"></script> <!-- -->
<script src="../fontes/js/jquery.min.js"></script>
<script src="../fontes/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="../fontes/js/tooltip.js"></script>
<script>
function retiraDependente(t) {
	var tabela = $("#dependentes_lista tr");
	i=0;
	tabela.each(function(){
		$(this).attr('id',i);
		i++;
	});
	
	if(tabela.length>1){
		$(t).parent().parent().remove();
	}else{
		$("#dependentes_lista tr input.elemento_retiravel").each(function(){
			$(this).val('');
		});
		$("#dependentes_lista tr td:first").text('');
	}
	$("#dependentes_lista tr.aplicavel:nth-child(2n+1)").addClass('al'); }
function retiraPolitico(t) {
	var tabela = $("#lista_politicos tr");
	i=0;
	tabela.each(function(){
		$(this).attr('id',i);
		i++;
	});
	
	if(tabela.length>1){
		$(t).parent().parent().remove();
	}else{
		$("#lista_politicos tr input.elemento_retiravel_politicos").each(function(){
			$(this).val('');
		});
		$("#lista_politicos tr td:first").text('');
		$("#lista_politicos tr td:nth-child(2)").text('');
		$("#lista_politicos tr td:nth-child(3)").text('');
		$("#lista_politicos tr td:nth-child(4)").text('');
	}
	$("#lista_politicos tr.aplicavel:nth-child(2n+1)").addClass('al'); }
function manipulaDependente(t){
var tabela = $("#dependentes_lista tr");
var acao =  $("#acao").val();
var ultima_linha_id = parseInt($("#dependentes_lista tr:last").attr('id'));

erro=0;
($("#dependente_nome").val()=='')? erro++:nome = "<input type='hidden' class='elemento_retiravel' name='dependente_nome[]' value='"+$("#dependente_nome").val()+"' />"; 
($("#dependente_nascimento").val()=='')?erro++:nascimento= "<input type='hidden' class='elemento_retiravel' name='dependente_nascimento[]' value='"+$("#dependente_nascimento").val()+"' />";
($("#dependente_vinculo").val()=='')?erro++:vinculo= "<input type='hidden' class='elemento_retiravel' name='dependente_vinculo[]' value='"+$("#dependente_vinculo").val()+"' />";
($("#dependente_ocupacao").val()=='')?erro++:ocupacao="<input type='hidden' class='elemento_retiravel' name='dependente_ocupacao[]' value='"+$("#dependente_ocupacao").val()+"' />";
($("#dependente_instituicao").val()=='')?erro++:instituicao="<input type='hidden' class='elemento_retiravel' name='dependente_instituicao[]' value='"+$("#dependente_instituicao").val()+"' />";
($("#dependente_doenca").val()=='')?erro++:doenca="<input type='hidden' class='elemento_retiravel' name='dependente_doenca[]' value='"+$("#dependente_doenca").val()+"' />";
($("#dependente_medicamentos").val()=='')?erro++:medicamentos="<input type='hidden' class='elemento_retiravel' name='dependente_medicamentos[]' value='"+$("#dependente_medicamentos").val()+"' />";
	if(erro<1){
		if(tabela.length >=1 && $("#dependentes_lista input:first").val()!='' && acao=='Adicionar'){
			
			id=ultima_linha_id+1;
			var nova_linha = 
			$("<tr class='aplicavel' id='"+id+"'><td width='330' onclick=\"editaDependente(this)\">"+$("#dependente_nome").val()+"</td><td>"+nome+nascimento+vinculo+ocupacao+instituicao+doenca+medicamentos+"<input value=\"X\" type=\"button\" onclick=\"retiraPolitico(this);\" /></td></tr>");
			nova_linha.insertAfter($("#dependentes_lista tr:last"));
			
		}else if((tabela.length==1&&acao=='Adicionar')||acao=='Salvar'){
			if(acao=='Salvar'){id=$("#dependente_id").val();}
			if(acao=='Adicionar'){id=ultima_linha_id; }
			$("#dependentes_lista tr#"+id+" input").each(function(index){
				if(index==0){ $(this).val($("#dependente_nome").val());}
				if(index==1){ $(this).val($("#dependente_nascimento").val());}
				if(index==2){ $(this).val($("#dependente_vinculo").val());}
				if(index==3){ $(this).val($("#dependente_ocupacao").val());}
				if(index==4){ $(this).val($("#dependente_instituicao").val());}
				if(index==5){ $(this).val($("#dependente_doenca").val());}
				if(index==6){ $(this).val($("#dependente_medicamentos").val());}
			})
			$("#dependentes_lista tr#"+id+" td:first").text($("#dependente_nome").val());
		}
	}
	$("#dependentes_lista tr.aplicavel:nth-child(2n+1)").addClass('al');
	apagaValores(); }
function editaDependente(t){
	$("#acao").val('Salvar');
	$("#botao_novo").css('display','');
	$("#dependente_id").val($(t).parent().attr('id'));
	var inputs =$(t).parent().find('input');
	inputs.each(function(index){
		if(index==0){ $("#dependente_nome").val($(this).val());}
		if(index==1){ $("#dependente_nascimento").val($(this).val());}
		if(index==2){ $("#dependente_vinculo").val($(this).val());}
		if(index==3){ $("#dependente_ocupacao").val($(this).val());}
		if(index==4){ $("#dependente_instituicao").val($(this).val());}
		if(index==5){ $("#dependente_doenca").val($(this).val());}
		if(index==6){ $("#dependente_medicamentos").val($(this).val());}
	}) }
function apagaValores(){
	$("#botao_novo").css('display','none');
	$("#acao").val('Adicionar');
	$("#dependente_nome").val('');
	$("#dependente_nascimento").val('');
	$("#dependente_vinculo").val('');
	$("#dependente_ocupacao").val('NENHUMA');
	$("#dependente_instituicao").val('NENHUMA');
	$("#dependente_doenca").val('NENHUMA');
	$("#dependente_medicamentos").val('NENHUMA');
	$("#dependente_id").val(''); }
function manipulaPolitico(t){
var tabela = $("#lista_politicos tr");
//var acao =  $("#acao").val();
var ultima_linha_id = parseInt($("#lista_politicos tr:last").attr('id'));

erro=0;
($("#politico_id_busca").val()=='')?erro++:id_politico= "<input type='hidden' class='elemento_retiravel_politicos' name='politico_id[]' value='"+$("#politico_id_busca").val()+"' /> ";
	if(erro<1){
		if(tabela.length >=1 && $("#lista_politicos input:first").val()!='' /*&& acao=='Adicionar'*/){
			id=ultima_linha_id+1;
			var nova_linha = 
			$("<tr class='aplicavel' id='"+id+"'><td>"+$("#politico_nome_busca").val()+"</td><td>"+$("#politico_cargo_busca").val()+"</td><td>"+$("#politico_partido_busca").val()+"</td><td>"+$("#politico_coligacao_busca").val()+"</td><td>"+id_politico+"<input value=\"X\" type=\"button\" onclick=\"retiraPolitico(this);\" /></td></tr>");
			nova_linha.insertAfter($("#lista_politicos tr:last"));
			
		}else{
			id=ultima_linha_id;
			$("#lista_politicos tr#"+id+" input").each(function(index){
				if(index==0){ $(this).val($("#politico_id_busca").val());}
			})
			$("#lista_politicos tr#"+id+" td:first").text($("#politico_nome_busca").val());
			$("#lista_politicos tr#"+id+" td:nth-child(2)").text($("#politico_cargo_busca").val());
			$("#lista_politicos tr#"+id+" td:nth-child(3)").text($("#politico_partido_busca").val());
			$("#lista_politicos tr#"+id+" td:nth-child(4)").text($("#politico_coligacao_busca").val());
			//$("#lista_politicos tr#"+id+" td:nth-child(5)").text($("#politico_coligacao_busca").val());
		}
	}
	$("#lista_politicos tr.aplicavel:nth-child(2n+1)").addClass('al');
	apagaValoresPoliticos(); }
function apagaValoresPoliticos(){
	$("#politico_nome_busca").val('');
	$("#politico_id_busca").val('');
	$("#politico_cargo_busca").val('');
	$("#politico_partido_busca").val('');
	$("#politico_coligacao_busca").val(''); }
function adicionaBusca(t){
		var zona = $("#zona_nome_busca").val();
		$(t).attr('busca',"modulos/eleitoral/eleitores/busca_secao.php?zona="+zona+",@r0,@r1-value>local_nome_busca|@r2-value>zona_id,0");
}

function ZeraValue(campo){
	if(campo.value=="NENHUMA"){
		campo.value='';
	}
}
function RenovaValues(campo){
	if(campo.value==""){
		campo.value='NENHUMA';
	}
}

$("#grupo_social").live('change',function(){
	var grupo_social_id = $(this).val();
	location.href='?tela_id=<?=$_GET['tela_id']?>&grupo_social='+grupo_social_id;
});
$("#link_busca").live('click',function(){
	$(".form_busca").submit();
});

</script>
</head>

<body>
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
<form onsubmit="return validaForm(this);" class="form_float" method="post" autocomplete='off' action="index.php">
<fieldset id="campos_1">
<legend>
 		<a onclick="aba_form(this,0)"><strong>Dados Principais</strong></a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)">Dados Sociais</a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>

</legend>
  <label style="width:260px;">
    Nome
    <input type="text" valida_minlength="3" retorno="focus|Digite seu nome corretamente" maxlength="44" autocomplete="off" value="" name="nome" id="nome">
  </label>
  <label>
    Apelido
    <input type="text" maxlength="44" size="5" autocomplete="off" value="" name="apelido" id="apelido">
  </label>
  <label>Sexo
	<select name="sexo">
        <option value="masculino">Masculino</option>
        <option value="feminino">Feminino</option>
    </select>
    </label>
  <div style="clear:both"></div>
  <label style="width:150px"> 
  Data de Nascimento
  <input type="text" mascara="__/__/____" maxlength="44" autocomplete="off" value="00/00/0000" name="data_nascimento" id="data_nascimento">
  </label>
  <label style="width:120px">Telefone 
    <input type="text" mascara="(__)____-____" maxlength="44" autocomplete="off" value="" name="telefone1" id="telefone1"> 
  </label>
  <label style="width:120px">Celular
  <input type="text" mascara="(__)____-____" maxlength="44" value="" name="telefone2" id="telefone2">
  </label>
  <br>
  <label style="width:120px">E-mail
  <input type="text" maxlength="44" value="" name="email" id="email">
  </label>
  <label style="width:99px">Estado Civil
  <select id="estado_civil" name="estado_civil">
    <option></option>
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
  <input type="text" maxlength="44" autocomplete="off" value="" name="naturalidade" id="naturalidade">
  </label>
  <div style="clear:both"></div>
  <label style="width:150px">CEP
  	<input type="text" autocomplete="off" busca="modulos/eleitoral/eleitores/busca_endereco.php,@r0,@r0-value&gt;cep|@r1-value&gt;endereco|@r2-value&gt;bairro|@r3-value&gt;cidade|@r4-value&gt;uf,0" value="" name="cep" id="cep">
   </label>
  <label style="width:150px">
    Endereço<input type="text" maxlength="44" value="" name="endereco" id="endereco">
    </label>
	<label style="width:150px">
    Cidade<input type="text" maxlength="44" value="" name="cidade" id="cidade">
    </label>
    <div style="clear:both"></div>
    <label style="width:150px">
   	UF<input type="text" value="" id="uf" name="estado">
   </label>
   <label style="width:150px">
    Bairro
    	<input type="text" value="" name="bairro" id="bairro">
    
    </label>
    <label style="width:200px">
    Regiao/Setor/Area
    <select name="regiao_id">
    <option></option>
	    </select>
    </label>
    <div style="clear:both"></div>
    
    <label style="width:300px">
    Colaborador
        <input type="text" busca="../sis/modulos/eleitoral/eleitores/busca_colaborador.php,@r0 @r1,@r0-value&gt;busca_coordenador|@r2-value&gt;coordenador_id,0" value=" " name="busca_coordenador" id="busca_coordenador">   
    <input type="hidden" value="" name="coordenador_id" id="coordenador_id">
	</label>
    
    <label style="width:200px">
    Relacionamento
	<select id="vinculo_coordenador_id" name="vinculo_coordenador_id">
  		<option></option>
		        	<option value="1">aluno(a)</option>
                	<option value="2">amigo(a)</option>
                	<option value="3">Avô(ó)</option>
                	<option value="4">Conhecido(a)</option>
                	<option value="5">Esposo(a)</option>
                	<option value="6">Filho(a)</option>
                	<option value="7">Funcionário(a)</option>
                	<option value="8">Genro(a)</option>
                	<option value="9">Irmão(a)</option>
                	<option value="10">Namorado(a)</option>
                	<option value="11">Neto(a)</option>
                	<option value="12">Noivo(a)</option>
                	<option value="13">Nora(a)</option>
                	<option value="14">Pai</option>
                	<option value="15">Primo(a)</option>
                	<option value="16">Sobrinho(a)</option>
                	<option value="17">Sogro(a)</option>
                	<option value="18">Tio(a)</option>
                	<option value="19">Vizinho(a)</option>
                	<option value="28">Entiado(a)</option>
                	<option value="29">Mãe</option>
        	</select>
	</label>
</fieldset>
<fieldset id="campos_2" style="display:none">
  <legend>
 		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)"><strong>Dados Cadastrais</strong></a>
		<a onclick="aba_form(this,2)">Dados Sociais</a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>  </legend>
 <label style="width:100px;">
    RG<input type="text" sonumero="1" autocomplete="off" value="" name="rg" id="rg">
  </label>
  <label style="width:100px;">
    CPF<input type="text" sonumero="1" mascara="___.___.___-__" autocomplete="off" value="" name="cpf" id="cpf">
  </label> 
  <label style="width:100px;">
  Título de Eleitor <input type="text" maxlength="44" value="" name="titulo_eleitor" id="titulo_eleitor">
  </label>
  <div style="clear:both"></div>
    <label style="width:50px;">
  Zona<input type="text" busca="modulos/eleitoral/eleitores/busca_zona.php,@r0,@r0-value&gt;zona_nome_busca,0" autocomplete="off" value="" id="zona_nome_busca" name="zona_nome_busca">
    <input type="hidden" value="" name="zona_id" id="zona_id">
  </label> 
  <label style="width:50px;">
  Secao<input autocomplete="off" value="" onfocus="adicionaBusca(this)" name="secao_nome_busca" id="secao_nome_busca"> 
  </label>
  <label style="width:150px;">
  Local<input readonly="readonly" autocomplete="off" value="" name="local_nome_busca" id="local_nome_busca"> 
  </label>
  
  <label style="width:85px;">Status do Voto
  <select id="status_voto" name="status_voto">
    <option></option>
    <option value="sim">certo</option>
    <option value="nao">nao</option>
    <option value="incerto">incerto</option>
    <option value="aberto">Em aberto</option>
  </select>
  </label>
  <div style="clear:both"></div>
  <label style="width:350px;">
  Profissão
	<input autocomplete="off" busca="modulos/eleitoral/eleitores/busca_profissoes.php,@r0 ,@r1-value&gt;profissao_id,0" onkeydown="document.getElementById('profissao_id').value=''" value="" id="profissao_nome_busca" name="profissao_nome_busca"> 
    <input type="hidden" value="" name="profissao_id" id="profissao_id">
  </label>
  <div style="clear:both"></div>
  <label style="width:350px;">
  	 Empresa<input type="text" maxlength="44" autocomplete="off" value="" name="empresa" id="empresa">	
  </label>
  <div style="clear:both"></div>
  <label>Intenção de Voto 
  <input autocomplete="off" busca="../sis/modulos/eleitoral/eleitores/busca_politico.php,@r0 @r1 @r2 @r3,@r4-value&gt;politico_id_busca|@r1-value&gt;politico_cargo_busca|@r2-value&gt;politico_partido_busca|@r3-value&gt;politico_coligacao_busca,0" value="" id="politico_nome_busca"> 
  <input type="hidden" value="" id="politico_id_busca">
  <input type="hidden" value="" id="politico_cargo_busca">
  <input type="hidden" value="" id="politico_partido_busca">
  <input type="hidden" value="" id="politico_coligacao_busca">
  </label><a onclick="manipulaPolitico(this)" style="margin-top:18px; float:left;" target="carregador" class="mais"></a>
  <label>Origem 
  <input type="text" name="origem" value="" id="origem"> 

  </label>
  <div style="clear:both"></div>
  
  <table cellspacing="0" cellpadding="0" style="width:505px;  float:left; ">
  	<thead>
    <tr>
    <td width="150">Político</td><td width="100">Cargo</td><td width="70">Partido</td><td>Coligação</td><td></td>
    </tr></thead>
    
    <tbody style="background-color:white;" id="lista_politicos">
    		
		<tr class="aplicavel" id="0">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
            	<input type="hidden" value="" name="politico_id[]" class="elemento_retiravel_politicos">
            	<input type="button" onclick="retiraPolitico(this);" value="X">
            </td>
        </tr>
		
	    </tbody>
  </table>
</fieldset>
<fieldset style="display:none" id="campos_3">
  <legend>
 		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)"><strong>Dados Sociais</strong></a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>  </legend>
  <label style="width:85px;">Renda Familiar
    <input type="text" decimal="2" sonumero="1" maxlength="44" autocomplete="off" value="0,00" name="renda_familiar" id="renda">
  </label>
  <label style="width:120px;"> 
  	Numero de Pessoas<input type="text" maxlength="44" value="" name="num_integrantes_familia" id="num_integrantes_familia">
  </label>
  <label style="width:120px;">
  	Grau de Instrucao
    <select name="grau_instrucao">
    	<option></option>
        <option value="analfabeto">Analfabeto</option>
        <option value="fundamental incompleto">Fundamental Incompleto</option>
        <option value="fundamental completo">Fundamental Completo</option>
        <option value="emincompleto">Ensino Médio Incompleto</option>
        <option value="emcompleto">Ensino Médio Completo</option>
        <option value="superior incompleto">Superior Incompleto</option>
        <option value="superior completo">Superior Completo</option>
        <option value="outros">Outros</option>
    </select>
  </label>
  <label style="width:120px;">
  	Grupo Social
    <select name="grupo_social_id">
    <option></option>
        	<option value="26">Rede Social</option>
        	<option value="27">Parlamentar</option>
        	<option value="28">Rádio</option>
        	<option value="29">Programa Josue Neto</option>
        	<option value="30">Pessoal</option>
        	<option value="31">Teste</option>
        	<option value="32">Pessoal 2</option>
        	<option value="33">Teste Vekttor</option>
        	<option value="34">Orkut</option>
        	<option value="37">Giro de Notícias</option>
        </select>
  </label>
  <div style="clear:both"></div>
<label style="width:170px;">
  	Religiao
      <select name="religiao_id">
    		<option value="0"></option>
	    </select>
    </label>
  <label style="width:170px;">
  Filiacao Partidaria 
  <select name="filiacao_partidaria_id">
  <option></option>
    </select>
  </label>
  
  
  
  <div style="clear:both"></div>
  <label style="width:170px;">
	Doenca<input type="text" onblur="RenovaValues(this)" onfocus="ZeraValue(this)" maxlength="44" autocomplete="off" value="NENHUMA" name="doenca" id="doenca">
  </label>
  <label style="width:170px;">
  Medicamentos <input type="text" onblur="RenovaValues(this)" onfocus="ZeraValue(this)" maxlength="44" autocomplete="off" value="NENHUMA" name="medicamentos" id="medicamentos">
  </label>
  <div style="clear:both"></div>
  <label style="width:170px;">
  	Esporte <input type="text" onblur="RenovaValues(this)" onfocus="ZeraValue(this)" maxlength="44" autocomplete="off" value="NENHUMA" name="esporte" id="esporte">
  </label>
  <label style="width:170px;">
   Time <input type="text" onblur="RenovaValues(this)" onfocus="ZeraValue(this)" maxlength="44" autocomplete="off" value="NENHUMA" name="time" id="time">
  </label>
  <div style="clear:both"></div>
  <label style="width:300px;">
  Origem 
  <input type="text" value="" id="origem" name="origem">
  
  </label>
  
</fieldset>
<fieldset style="display:none;" id="campos_4">
  <legend>
 		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)">Dados Sociais</a>
		<a onclick="aba_form(this,3)"><strong>Dependentes</strong></a>
        <a onclick="aba_form(this,4)">Bens e Posses</a>  </legend>
  <label style="width:400px;">	
    Nome<input type="text" autocomplete="off" value="" id="dependente_nome">
  </label>
  <div style="clear:both"></div>
  <label style="width:190px;">
    Data de Nascimento <input type="text" mascara="__/__/____" maxlength="44" autocomplete="off" name="dependente_nascimento" id="dependente_nascimento">
  </label>
  <label style="width:190px;">
  Relação Dependente <select id="dependente_vinculo">
  <option></option>
    						<option value="1">aluno(a)</option>
                          						<option value="2">amigo(a)</option>
                          						<option value="3">Avô(ó)</option>
                          						<option value="4">Conhecido(a)</option>
                          						<option value="5">Esposo(a)</option>
                          						<option value="6">Filho(a)</option>
                          						<option value="7">Funcionário(a)</option>
                          						<option value="8">Genro(a)</option>
                          						<option value="9">Irmão(a)</option>
                          						<option value="10">Namorado(a)</option>
                          						<option value="11">Neto(a)</option>
                          						<option value="12">Noivo(a)</option>
                          						<option value="13">Nora(a)</option>
                          						<option value="14">Pai</option>
                          						<option value="15">Primo(a)</option>
                          						<option value="16">Sobrinho(a)</option>
                          						<option value="17">Sogro(a)</option>
                          						<option value="18">Tio(a)</option>
                          						<option value="19">Vizinho(a)</option>
                          						<option value="28">Entiado(a)</option>
                          						<option value="29">Mãe</option>
                        					</select> 
  </label>
  <div style="clear:both"></div>
  <label style="width:190px;">
  	Ocupacao<input type="text" onblur="RenovaValues(this)" maxlength="44" onfocus="ZeraValue(this)" value="NENHUMA" autocomplete="off" id="dependente_ocupacao">
  </label>
  <label style="width:190px;">
  	Instituicao <input type="text" onblur="RenovaValues(this)" maxlength="44" onfocus="ZeraValue(this)" value="NENHUMA" autocomplete="off" id="dependente_instituicao">
  </label>
  <div style="clear:both"></div>
  <label style="width:190px;">
    Doenca<input type="text" onblur="RenovaValues(this)" maxlength="44" onfocus="ZeraValue(this)" value="NENHUMA" autocomplete="off" id="dependente_doenca">
  </label>
  <label style="width:190px;">
  Medicamentos<input type="text" onblur="RenovaValues(this)" maxlength="44" autocomplete="off" onfocus="ZeraValue(this)" value="NENHUMA" id="dependente_medicamentos">
  </label>
  <input type="hidden" value="" id="dependente_id">
  <label style=" float:left; clear:both;">
  	<label id="botao_manipular"><input type="button" onclick="manipulaDependente(this);" value="Adicionar" id="acao"></label>
    <label style="display:none" id="botao_novo"><input type="button" onclick="apagaValores()" value="Novo" id="novo"></label>
    </label>
  <div style="clear:both;"></div>
  <div id="dados">
  <table cellspacing="0" cellpadding="0" style="width:405px;  float:left; " id="lista_dependentes">
  	<thead>
    <tr>
    <td colspan="2">Nome</td>
    </tr></thead>
    <tbody style="background-color:white;" id="dependentes_lista">
        
    <tr class="aplicavel" id="0">
            <td width="330" onclick="editaDependente(this)"></td>
            <td>
            	<input type="hidden" name="dependente_nome[]" class="elemento_retiravel" value="">
                <input type="hidden" name="dependente_nascimento[]" class="elemento_retiravel" value="">
                <input type="hidden" name="dependente_vinculo[]" class="elemento_retiravel" value="">
                <input type="hidden" name="dependente_ocupacao[]" class="elemento_retiravel" value="">
                <input type="hidden" name="dependente_instituicao[]" class="elemento_retiravel" value="">
                <input type="hidden" name="dependente_doenca[]" class="elemento_retiravel" value="">
                <input type="hidden" name="dependente_medicamentos[]" class="elemento_retiravel" value="">
            	<input type="button" onclick="retiraDependente(this);" value="X">
            </td>
        </tr>
    
    
        </tbody>
  </table>
 
  </div>
</fieldset>
<fieldset style="display: none" id="campos_5">
  <legend>
 		<a onclick="aba_form(this,0)">Dados Principais</a>
		<a onclick="aba_form(this,1)">Dados Cadastrais</a>
		<a onclick="aba_form(this,2)">Dados Sociais</a>
		<a onclick="aba_form(this,3)">Dependentes</a>
        <a onclick="aba_form(this,4)"><strong>Bens e Posses</strong></a>  </legend>
  <table cellspacing="0" cellpadding="0">
  	<thead>
    	<tr>
        	<td width="100">Bens de Posse</td><td width="50">Qtd</td><td width="300" align="center" ;="">Serviços</td>
        </tr>
    </thead>
      	<tbody>
    	<tr style="background-color:white;">
        	<td>Imóvel</td>
            <td><input type="text" value="" name="imovel_qtd" style="width:20px; height:10px;"></td>
            <td>
            	Placa/Outdoor<input type="checkbox" name="imovel_servicos[]" value="placa/outdoor">
            </td>
       </tr>
       <script>
       </script>
        <tr style="background-color:white;" class="al">
        	<td>Carro Gasolina</td><td>
            	<input type="text" name="carro_gasolina_qtd" value="" style="width:20px; height:10px;"></td>
            <td>
            Adesivo<input type="checkbox" name="carro_gasolina_servicos[]" id="adesivo1" value="adesivo">
            Passeata<input type="checkbox" name="carro_gasolina_servicos[]" id="passeata1" value="passeata">
            Serviço<input type="checkbox" name="carro_gasolina_servicos[]" id="servicos1" value="servicos">
            </td>
        </tr>
        <tr style="background-color:white;">
        	<td>Carro Diesel</td>
            <td><input type="text" value="" name="carro_diesel_qtd" style="width:20px; height:10px;"></td>
            <td>
            	Adesivo<input type="checkbox" name="carro_diesel_servicos[]" value="adesivo">
            	Passeata<input type="checkbox" name="carro_diesel_servicos[]" value="passeata">
            	Serviço<input type="checkbox" name="carro_diesel_servicos[]" value="servicos">
            </td>
        </tr>
        <tr style="background-color:white;" class="al">
        	<td>Moto</td>
            <td><input type="text" value="" name="moto_qtd" style="width:20px; height:10px;"></td>
            <td>
            	Adesivo<input type="checkbox" name="moto_servicos[]" value="adesivo">
                Passeata<input type="checkbox" name="moto_servicos[]" value="passeata">
                Serviço<input type="checkbox" name="moto_servicos[]" value="servicos">
           </td>
        </tr>
        <tr style="background-color:white;">
        	<td>Lancha</td>
            <td><input type="text" value="" name="lancha_qtd" style="width:20px; height:10px;"></td>
            <td>
            	Adesivo<input type="checkbox" name="lancha_servicos[]" value="adesivo">
                Serviço<input type="checkbox" name="lancha_servicos[]" value="servicos">
           </td>
        </tr>
        <tr style="background-color:white;">
        	<td>Barco</td>
            <td><input type="text" value="" name="barco_qtd" style="width:20px; height:10px;"></td>
            <td>
            	Adesivo<input type="checkbox" name="barco_servicos[]" value="adesivo">
                Serviço<input type="checkbox" name="barco_servicos[]" value="servicos">
           </td>
        </tr>
    </tbody>
  </table>
  <label style="width:398px;height:100px; margin-top:10px;">
	Observacoes <textarea rows="5" name="descricao_bens" id="descricao_bens"></textarea>
  </label>
</fieldset>
<input type="checkbox" name="receber_email" id="receber_email" checked='checked'/>Desejo Receber E-mails
<div style="clear:both"></div>
<input type="checkbox" name="receber_sms" id="receber_sms" checked='checked'/>Desejo Receber SMS
<input name="id" type="hidden" value="" />

<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" ></div>
<!---------------------------------------------------Dados cadastrais----------------------->
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<input name="action" type="submit" value="Salvar" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>
</body>
</html>