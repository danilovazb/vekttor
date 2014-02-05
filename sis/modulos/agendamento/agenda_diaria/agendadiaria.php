<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
$agenda_id = 0;

if(!empty($_GET['sel_agenda'])){
	$agenda_id = $_GET['sel_agenda'];
}
?>
<style>

body,html{ padding:0; margin:0; height:auto; }
body,td,th {font-family: Tahoma, Geneva, sans-serif;font-size: 13px;}
tbody tr:hover td{ background:none; color:#333;}
table#tabela_dados tbody tr:hover td{background:url(../fontes/img/bt2.jpg); color:#FFF;}
.fc{ height:100px;}
#calendar { margin: 0 auto; margin-top:0; }
table thead tr th { background:none; color:#333; font-size:12px; font-weight:100; text-shadow: 1px 1px 1px #CCC;}
table#tabela_dados tbody tr:nth-child(odd){ background:#F1F5FA; }
table#tabela_dados tbody tr:nth-child(even){ background:#FFF; }
a{ text-decoration:none;}
thead { background:none;}
thead > tr th{ padding:4px; font-size:11px;}

tbody td{font-size:11px; padding-left:10px; border-right:1px solid #CCC; height:auto; cursor:pointer;}

@media (min-width: 1024px) { #calendar{ width:90%;} }
@media (max-width: 1024px) { #calendar{ width:77%;}}

@media (min-width: 768px) and (max-width: 979px) { #calendar{ width:83%;}}
@media (max-width: 767px) { #calendar{ width:83%;}}
@media (max-width: 480px) { #calendar{ width:100%;} }
</style>
<link rel='stylesheet' type='text/css' href='modulos/agendamento/agenda_diaria/css/fullcalendar.css' />
<script type='text/javascript' src='modulos/agendamento/agenda_diaria/js/fullcalendar.js'></script>
<script type='text/javascript' src="modulos/agendamento/agenda_diaria/js/agendadiaria.js"></script>
<script type="text/javascript">
jQuery(function(){
  
	$('#external-events div.external-event').each(function() {
			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			var eventObject = {
				id : $(this).attr("id"), title : $.trim($(this).text())  //use the element's text as the event title
			};

			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag

			});

	});


  
  $("#excluir_evento").live("click",function(event){
		$("#aSerCarregado").hide();
  });
  /*--*/
  var htmlCliente = "";
  $("#busca").live('keydown',function(event){
	  if((event.keyCode == 13) && ($.trim($("#cliente_id").val()) != "")){
		  var cliente_id = $("#cliente_id").val();
		  $.ajax({
			  url:"modulos/agendamento/agenda_diaria/dataBanco.php",
			  type:"POST",
			  dataType:"json",
			  data:"acao=busca_cliente&cliente_id="+cliente_id,
			  success: function(data){
				  $("#calendar").hide();
				  $("#form_agenda").hide();
				  $("#table_cliente").show();
				  $("#rodape").show();
				  $("#table_footer").show();
				  $("#dados").show();
				  $("#voltar_agenda").show();
				  $("#dados_body").html('');
				  $.each(data,function(i,item){
					  htmlCliente += '<tr id='+item.agenda_id+' class="item_agenda">\
						<td width="40">'+item.id+'</td><td width="180">'+item.cliente+'</td>\
						<td width="180">'+item.titulo+'</td>\
						<td width="118">'+item.hora_inicio+'</td>\
						<td width="118">'+item.hora_fim+'</td>\
						<td width="120">'+item.agenda+'</td>\
						<td></td>\
					  </tr>';				
				  });
				  $("#dados_body").html(htmlCliente);
				  
			  }	
		  });/*fim ajax*/	
		  htmlCliente = "";
		  $("#cliente_id").val('');	
	  }	
  })/*fim busca*/;
	$("#voltar_agenda").live('click',function(){
			location.href="?tela_id=372";	
	})
});


function funcao_bsc_agenda(resultado){
	ano = resultado.getAttribute('r5');
	mes =resultado.getAttribute('r6');
	dia =resultado.getAttribute('r7');
	agenda_id =resultado.getAttribute('r3');
	$("#busca").val(resultado.getAttribute('r1'));
	location= '?tela_id=372&sel_agenda='+agenda_id+'&dia_set='+dia+'&mes_set='+mes+'&ano_set='+ano;
	
//	$('#calendar').fullCalendar('gotoDate',ano,mes,dia);		
}

/*-script para modal cliente-*/
$(".atl_natureza input:radio").live('click',function(){
	$("#atl_nome").val("");
	$("#atl_cnpf_cpf").val("");
	$("#atl_nome").attr("disabled","disabled");
	$("#atl_cnpf_cpf").attr("disabled","disabled");
	$("#atl_cadastrar").attr("disabled","disabled");
	
	for( i=0; i < $(this).length; i++ ){
			if($(this).is(":checked")){
				var liberado = true;
			}
	}
	if(liberado == true){
		$("#atl_nome").removeAttr("disabled");
		$("#atl_cnpf_cpf").removeAttr("disabled");
		$("#atl_cadastrar").removeAttr("disabled");
	}
	if($(this).val() == '1'){
		$("#atl_cnpf_cpf").val('');
		$("#atl_cnpf_cpf").attr('mascara','___.___.___-__');
	}else{
		$("#atl_cnpf_cpf").val('');
		$("#atl_cnpf_cpf").attr('mascara','__.___.___/____-__'); // 05.535.221/0001-88
	}
});

$("div").on("click","#cad_cliente",function(){
	$(".modal").toggle();
});

$("div").on('click','#atl_cadastrar',function(){
  
  //Físico - Jurídico
  var natureza = $(".atl_natureza").find(":radio");
	  for(i=0; i < natureza.length; i++){
		  if($(natureza[i]).is(":checked")){
			  var tipo = $(natureza[i]).val();
		  }
	  }
	var nome = $("#atl_nome").val();
	var cnpj_cpf = $("#atl_cnpf_cpf").val();
	
  $.post('modulos/agendamento/agenda_diaria/Requisicoes.php?acao=atl_cliente',{tipo_cadastro:tipo,nome:nome,cnpjCpf:cnpj_cpf},function(data){
	$("input#cliente_id").val(data);$("input#cliente_razao").val(nome);
	$("#atl_nome").attr("disabled","disabled");
	$("#atl_cnpf_cpf").attr("disabled","disabled");
	$("#atl_cadastrar").attr("disabled","disabled");
	$(".modal").hide("slow");	
  });
  		
});
/*-fim script para modal cliente-*/
</script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">&laquo;</div>
<a href="" class='s1'>
  	Sistema
</a>
<a href="" class='s2'>
  	Agendamento
</a>
<a href="" class='navegacao_ativo'><span></span> Agenda Di&aacute;ria</a>
<form class='form_busca' action="" method="get" autocomplete='off'>
   	 <a></a>
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca" data-placement="bottom" autocomplete="off" onkeyup="return vkt_ac(this,event,'0','modulos/agendamento/agenda_diaria/busca_cliente.php','<sub>@r2 - @r4</sub> <br/> @r1  <div style=\'border-bottom:1px solid #CCC\'></div>','funcao_bsc_agenda(this,\'@r1-value>busca|@r0-value>cliente_id\',\'busca\')'); " /><!-- busca="modulos/agendamento/agenda_diaria/busca_cliente.php,@r1,@r1-value>busca|@r0-value>cliente_id,0"   -->
</form>
<div style="float:right;box-shadow:rgba(255, 255, 255, 0.2) 0px 1px 0px 0px inset, rgba(0, 0, 0, 0.0470588) 0px 1px 2px 0px;background-color: rgb(245, 245, 245);background-image: linear-gradient(rgb(255, 255, 255), rgb(230, 230, 230));border-bottom-color: rgb(179, 179, 179);
border-bottom-left-radius: 4px;
border-bottom-right-radius: 4px;
border-bottom-style: solid;
border-bottom-width: 1px;
border-left-color: rgba(0, 0, 0, 0.0980392);
border-left-style: solid;
border-left-width: 1px;
border-right-color: rgba(0, 0, 0, 0.0980392);
border-right-style: solid;
border-right-width: 1px;
border-top-color: rgba(0, 0, 0, 0.0980392);
border-top-left-radius: 4px;
border-top-right-radius: 4px;
border-top-style: solid;
border-top-width: 1px;
box-shadow: rgba(255, 255, 255, 0.2) 0px 1px 0px 0px inset, rgba(0, 0, 0, 0.0470588) 0px 1px 2px 0px;
color: rgb(51, 51, 51);
cursor: pointer;
display: block;
float: right;
font-family: Tahoma, Geneva, sans-serif;
font-size: 11px;
height: 10px;
line-height: 12px;
margin-bottom: 0px;
margin-right: 5px;
margin-top: 3px;
padding-bottom: 2px;
padding-left: 12px;
padding-right: 12px;
padding-top: 1px;
text-align: center;
text-decoration: none;
text-shadow: rgba(255, 255, 255, 0.74902) 0px 1px 1px;
vertical-align: middle;
width: 14px; height:15px; cursor:pointer" onClick="window.open('<?=$tela->caminho?>/form_config.php','carregador')"><img src="../../../../fontes/img/config.png" width="14" height="15"  alt=""/></div>
</div>

<div style="position:absolute; margin-left:20px; margin-top:10px;"><form method="get" id="form_agenda">
<input type="hidden" name="tela_id" value="372" />
<?php 
$sql= mysql_query($y=" SELECT * FROM agenda WHERE vkt_id = '$vkt_id'  ");
?>
    <select name="sel_agenda" id="sel_agenda">
        <option value="0" >Agenda</option>
        <option value="novo">Adicionar</option>
    	<?php
        	while($Agenda=mysql_fetch_object($sql)){
					if($_GET['sel_agenda'] == $Agenda->id){ $sel = 'selected="selected"';} else{$sel = "";};
		?>    
        <option value="<?php echo $Agenda->id?>" <?=$sel;?>><?php echo $Agenda->nome;?></option>
    	<?php
			}
		?>
    </select>
<button type="button" id="editagenda" >Editar</button>
</form></div>

<div style="position:relative; text-align:center;"><span id='loading' style='display:none; position:absolute; background:#FFC; font-weight:800;'>Carregando...</span></div>
<input type="hidden" name="agenda_id" id="agenda_id" value="<?=$agenda_id?>">
<button type="button" id="voltar_agenda" style="display:none; margin-top:2px;">Voltar para agenda</button>
<input type="hidden" name="cliente_id" id="cliente_id">



<div id='calendar'></div>

<table cellpadding="0" cellspacing="0" width="100%" id="table_cliente" style="display:none;">
	<thead>
    	<tr>
          <td width="40">N&deg;</td>
          <td width="180">Cliente</td>
          <td width="180">Nota</td>
          <td width="118">Inicio</td>
          <td width="118">Fim</td>
          <td width="120">Agenda</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' style="display:none">
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" class="tabela_dados">
	<tbody id="dados_body"></tbody>
</table>
</div>
<!-- Isso é Necessário para a criaçao o resize -->
<script>
<? if($_GET[dia_set]){ ?>
$(document).ready(function(e) {
	$('#calendar').fullCalendar('gotoDate',<?=$_GET[ano_set]?>,<?=$_GET[mes_set]?>,<?=$_GET[dia_set]?>);
});
<? } ?>
resize();
</script>
<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black; display:none;" id="table_footer">
    <thead>
    	<tr>
          <td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="85">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>
<div id='rodape' style="display:none;"></div>
