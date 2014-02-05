<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

include("_function.php");
include("_ctrl.php");

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
	$("#dados tr.aplicavel:nth-child(2n+1)").addClass('al');
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
				if(index==3){ $(this).val($("#dependente_ocupacao").val(''));}
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

function Valor(valor){
	if(valor.disabled==true){
		valor.disabled=false;
	}else{
		valor.disabled=true;
	}
	//alert(valor);
}
function adicionaBusca(t){
		var zona = $("#zona_nome_busca").val();
		$(t).attr('busca',"modulos/eleitoral/eleitores/busca_secao.php?zona="+zona+",@r0,@r1-value>local_nome_busca,0");
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

function diferencaDias(data_inicio,data_fim,periodo){
	var data1 = data_fim.value;
	var data2 = data_inicio.value;
	data1= data1.split("/");
	data2= data2.split("/");
	data1=new Date(data1[2], data1[1], data1[0]);
	data2=new Date(data2[2], data2[1], data2[0]);
    //alert(data1.value);
	//alert(data2);
	if((data_inicio.value!='') && (data_fim.value!='')){
	if(data2>data1){
		alert("A data final deve ser maior que a data inicial");
		data_fim.value="";
		data_fim.focus;
		periodo.value="";
	}else{
		var dif =
        Date.UTC(data1.getYear(),data1.getMonth(),data1.getDate(),0,0,0)
      - Date.UTC(data2.getYear(),data2.getMonth(),data2.getDate(),0,0,0);
   		diferenca= Math.abs((dif / 1000 / 60 / 60 / 24));
		diferenca=diferenca+1;
   		periodo.value=diferenca;
	}
	}
}

function ValidaForm(form){
	//if(form.turno.value==''){
		alert('Selecione um turno');
	//}
}


</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <!--<input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/eleitoral/colaborador/busca_colaborador.php,@r0,@r1-value>busca_id,0' autocomplete="off"/>-->
     <input type="text" id='busca' name="busca" maxlength="44" value="<?=$_GET[busca]?>" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/eleitoral/colaborador/busca_colaborador.php,@r0,0'/>
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Eleitoral 
</a>
<a href="?tela_id=103" class="navegacao_ativo">
<span></span>  Colaboradores</a></div>
<div id="barra_info">
    <a href="<?=$caminho?>/form_colaborador.php" target="carregador" class="mais"></a>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="200"><?=linkOrdem("Nome","nome",1)?></td>
            <td width="120"><?=linkOrdem("Telefone","Telefone",0)?></td>
            <td width="200"><?=linkOrdem("E-mail","E-mail",0)?></td>
            <td width="200"><?=linkOrdem("Endereco","Endereco",0)?></td>
            <td width="200"><?=linkOrdem("Funçao","Funçao",0)?></td>
            <td><?=linkOrdem("Status do Voto","Status do Voto",0)?></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="dados">
    <? 
	if(empty($_GET['busca'])){
	$query_c=mysql_query("SELECT * FROM eleitoral_colaboradores WHERE vkt_id='$vkt_id' ORDER BY tipo_colaborador ASC");
	}else{
	$query_c=mysql_query($trace="SELECT * FROM eleitoral_colaboradores WHERE nome LIKE '%".$_GET['busca']."%' AND vkt_id='$vkt_id'");
	}
	
	while($colaborador=mysql_fetch_object($query_c)){
	?>
     <tr class="aplicavel" onclick="window.open('<?=$caminho?>/form_colaborador.php?id=<?=$colaborador->id?>','carregador')">
            <td width="200"><?=$colaborador->nome?></td>
           	<td width="120"><?=$colaborador->telefone1?></td>
            <td width="200"><?=$colaborador->email?></td>
          	<td width="200"><?=$colaborador->bairro?></td>
            <?
				$funcao=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_funcoes WHERE id='".$colaborador->funcao_id."' AND vkt_id='$vkt_id'"));
     			//echo $trace;
			?>
            <td width="200"><?=$funcao->nome?></td>
            <td ><?=$colaborador->status_voto?></td>
        </tr>
     <? 
	 } 
	 ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><a>Total: <?=$total?></a></td>
            <td width="400">&nbsp;</td>
            <td></td>
      </tr>
    </thead>
</table>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>