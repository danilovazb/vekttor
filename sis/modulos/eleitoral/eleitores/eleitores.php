<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

include("_function.php");
include("_ctrl.php");

?>

<script>
$(document).ready(function(){
		$("#dependentes_lista tr.aplicavel:nth-child(2n+1)").addClass('al');
		
});


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
	$("#dependentes_lista tr.aplicavel:nth-child(2n+1)").addClass('al'); 
}
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
mensagem_erro = "";
if($("#dependente_nome").val()==''){ erro++;mensagem_erro+="Digite o Nome\n"}else{nome = "<input type='hidden' class='elemento_retiravel' name='dependente_nome[]' value='"+$("#dependente_nome").val()+"' />"}; 
if($("#dependente_nascimento").val()==''){ erro++;mensagem_erro+="Digite a Data de Nascimento\n"}else{nascimento= "<input type='hidden' class='elemento_retiravel' name='dependente_nascimento[]' value='"+$("#dependente_nascimento").val()+"' />"};
if($("#dependente_vinculo").val()==''){erro++;mensagem_erro+="Selecione um Vínculo\n"}else{vinculo= "<input type='hidden' class='elemento_retiravel' name='dependente_vinculo[]' value='"+$("#dependente_vinculo").val()+"' />"};
if($("#dependente_ocupacao").val()==''){ocupacao="<input type='hidden' class='elemento_retiravel' name='dependente_ocupacao[]' value='NENHUMA' />"}else{ocupacao="<input type='hidden' class='elemento_retiravel' name='dependente_ocupacao[]' value='"+$("#dependente_ocupacao").val()+"' />"};
if($("#dependente_instituicao").val()==''){instituicao="<input type='hidden' class='elemento_retiravel' name='dependente_instituicao[]' value='NENHUMA' />"}else{instituicao="<input type='hidden' class='elemento_retiravel' name='dependente_instituicao[]' value='"+$("#dependente_instituicao").val()+"' />"};
if($("#dependente_doenca").val()==''){doenca="<input type='hidden' class='elemento_retiravel' name='dependente_doenca[]' value='NENHUMA' />"}else{doenca="<input type='hidden' class='elemento_retiravel' name='dependente_doenca[]' value='"+$("#dependente_doenca").val()+"' />"};
if($("#dependente_medicamentos").val()==''){medicamentos="<input type='hidden' class='elemento_retiravel' name='dependente_medicamentos[]' value='NENNUMA' />"}else{medicamentos="<input type='hidden' class='elemento_retiravel' name='dependente_medicamentos[]' value='"+$("#dependente_medicamentos").val()+"' />"};
	
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
	
	$("#dependentes_lista tr.aplicavel:nth-child(2n+1)").addClass('al');
	apagaValores();
	}else{
		alert(mensagem_erro);
	}
}
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

$(".form_float input").live('blur',function(){
	conta_eleitores();
});

$(".form_float select").live('change',function(){
	conta_eleitores();
});

$(".opcao").live('click',function(){
	conta_eleitores();
});
function conta_eleitores(){
	var mes_aniversariante = $("#aniversariante").val();
	var cep_inicio         = $("#cep_inicio").val();
	var cep_fim            = $("#cep_fim").val();
	var grupo_social_id    = $("#grupo_social_id").val();
	var regiao_id          = $("#regiao_id").val();
	var estado             = $("#estado").val();
	var cidade             = $("#cidade").val();
	var bairro             = $("#bairro").val();
	var profissao_id       = $("#profissao_id").val();
	var sexo               = $("#sexo").val();
	var acao               = 'conta_eleitores';
	
	$.ajax({
	url:'modulos/eleitoral/eleitores/_ctrl.php?mes_aniversariante='+mes_aniversariante+'&cep_inicio='+cep_inicio+'&cep_fim='+cep_fim+'&grupo_social_id='+grupo_social_id+'&regiao_id='+regiao_id+'&estado='+estado+'&cidade='+cidade+'&bairro='+bairro+'&profissao_id='+profissao_id+'&sexo='+sexo+'&acao='+acao,	
	cache:false,
			success: function(data){
				
				$("#qtd_registros").val(data);
				
				/*total_paginas = data/30;
				total_paginas = total_paginas.toFixed(0);
				
				if(total_paginas<1){
					total_paginas=1;				
				}
				
				//$("#total_paginas").html(total_paginas);
				$("#ate").val(total_paginas);*/
			}
		});		
}
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' autocomplete='off' action="?<?=$_GET['tela_id']?>" method="get">
   	 <a id="link_busca"></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" id='busca' name="busca" maxlength="44" value="<?=$_GET[busca]?>" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Eleitoral 
</a>
<a href="?tela_id=103" class="navegacao_ativo">
<span></span>  Eleitores</a></div>
<div id="barra_info">
	<label style="width:200px;">
    <select id='grupo_social' name="grupo_social"/>
    	<option value="">Selecione um grupo Social</option>
		<?php
			$grupos_sociais = mysql_query("SELECT * FROM eleitoral_grupos_sociais WHERE vkt_id='$vkt_id'");
			while($grupo_social = mysql_fetch_object($grupos_sociais)){
        ?>
        	<option value="<?=$grupo_social->id?>" <? if($_GET['grupo_social']==$grupo_social->id){ echo "selected='selected'";}?>><?=$grupo_social->nome?></option>
        <?php
			}
		?>
    </select>
  </label>
	<a href="<?=$caminho?>/form_eleitor.php" target="carregador" class="mais"></a>
	<input type="button" name="exportar_eleitor" id="exportar_eleitor" value="Exportar" style="float:right;margin-top:3px;" onClick="window.open('modulos/eleitoral/eleitores/form_exportar_eleitores.php','carregador')">
    <a onclick="window.open('modulos/eleitoral/eleitores/download_ficha_cadastral.php','carregador');"><img src="../fontes/img/pdf.png" height="22" style="float:right;margin-top:1px;margin-right:5px;"/></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="200">Nome</td>
            <td width="100">Telefone</td>
            <td width="140">E-mail</td>
            <td width="140">Endere&ccedil;o</td>
            <td width="100">Regi&atilde;o</td>
            <td>Status do Voto</td>
        </tr>
    </thead>
</table>
<div id="dados">
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<?
if(isset($_GET['busca'])){ $filtro_eleitor = " AND nome LIKE '%".$_GET['busca']."%' OR telefone1 LIKE '%".$_GET['busca']."%' OR telefone2 LIKE '%".$_GET['busca']."%'";} else{$filtro_eleitor='';}
if($_GET['grupo_social']>0){ $filtro_eleitor = " AND grupo_social_id ='".$_GET['grupo_social']."'";}

$registros= @mysql_result(mysql_query("SELECT COUNT(*) FROM eleitoral_eleitores WHERE vkt_id='$vkt_id' $filtro_eleitor"),0,0);
$eleitor_q=mysql_query($oi="SELECT * FROM eleitoral_eleitores WHERE vkt_id=$vkt_id $filtro_eleitor LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <? $i=0; while($eleitor=mysql_fetch_object($eleitor_q)){ 
	if($i%2==0){$s="class='al'";}else{$s='';}
	$regiao=mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_regioes WHERE id='$eleitor->regiao_id'"));
	?>
    <tr <?=$s?> onclick="window.open('<?=$caminho?>/form_eleitor.php?id=<?=$eleitor->id?>','carregador')">
    	<td width="200"><?=$eleitor->nome?></td>
        <td width="100"><?=$eleitor->telefone1?></td>
        <td width="140"><?=$eleitor->email?></td>
        <td width="140"><?=$eleitor->bairro?></td>
        <td width="100"><?=$regiao->sigla?></td>
        <td><?=$eleitor->status_voto?></td>
    </tr>
	<? $i++; } ?>
    </tbody>
</table>
</div>
</div>

<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value+'&grupo_social=<?=$_GET['grupo_social']?>'">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('grupo_social' =>$_GET['grupo_social']))?>
    </div>
</div>