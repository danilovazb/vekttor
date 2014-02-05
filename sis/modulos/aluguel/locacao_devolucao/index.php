<?
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function rteInsertHTML(html) {
	 rteName = 'ed';
	if (document.all) {
		document.getElementById(rteName).contentWindow.document.body.focus();
		var oRng = document.getElementById(rteName).contentWindow.document.selection.createRange();
		oRng.pasteHTML(html);
		oRng.collapse(false);
		oRng.select();
	} else {
		document.getElementById(rteName).contentWindow.document.execCommand('insertHTML', false, html);
	}
}
function ti(m,v){
    w= document.getElementById('ed').contentWindow.document
	if(m=='InsertHTML' ){
		rteInsertHTML(v);
	}else{
		
	if(m == "backcolor"){
		if(navigator.appName =='Netscape'){
			w.execCommand('hilitecolor',false,v);
		}else{
			w.execCommand('backcolor',false,v);
		}
	}else{
		
		w.execCommand(m, false, v);
	}
	}
}

function html_to_form(){
	
	
		document.getElementById("tx_html").value = document.getElementById("ed").contentWindow.document.body.innerHTML
		
		document.getElementById("ed").contentWindow.document.body.innerHTML.replace("\n","");
}


function insere_txt(txt) {
    var myQuery = document.getElementById("ed").contentWindow.document.body;
    var chaineAj = txt;
	//IE support
	if (document.selection) {
		myQuery.focus();
		sel = document.selection.createRange();
		sel.innerHTML = chaineAj;
	}
	//MOZILLA/NETSCAPE support
	else if (document.getElementById("ed").selectionStart || document.getElementById("ed").selectionStart == "0") {
		var startPos = document.getElementById("ed").selectionStart;
		var endPos = document.getElementById("ed").selectionEnd;
		var chaineSql = document.getElementById("ed").innerHTML;

		myQuery.innerHTML = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
	} else {
		myQuery.innerHTML += chaineAj+'++aaa++';
	}
}


function SomarItens(){
		var TotalEquipamento = moedaBrToUsa($("#TotalEquipamento").val())*1;
		var desconto         = moedaBrToUsa($("#desconto").val())*1;
		var acrescimo        = moedaBrToUsa($("#acrescimo").val())*1;
		
		var ValTotal = ((TotalEquipamento + acrescimo) - desconto);
		
		$("#ValTotalAluguel").text(moedaUsaToBR(ValTotal.toFixed(2)));
		$("#TotalAluguel  ").val(moedaUsaToBR(ValTotal.toFixed(2)));
		/* Nao Modifica Total */
		$("#ValTotalHidden").val(moedaUsaToBR(ValTotal.toFixed(2)));
		$("#ValTotalAluguel").text(moedaUsaToBR(ValTotal.toFixed(2)));
		$("#TotalGeralView").text(moedaUsaToBR(ValTotal.toFixed(2)));
		
}
function SomarItensPorceto(){
		var TotalEquipamento = moedaBrToUsa($("#TotalGeral").val())*1;
		var desconto         = moedaBrToUsa($("#desconto").val())*1;
		var acrescimo        = moedaBrToUsa($("#acrescimo").val())*1;
		
		var ValTotal = ((TotalEquipamento + acrescimo) - desconto);
		
		$("#ValTotalAluguel").text(moedaUsaToBR(ValTotal.toFixed(2)));
		$("#TotalAluguel  ").val(moedaUsaToBR(ValTotal.toFixed(2)));
		/* Nao Modifica Total */
		//$("#ValTotalHidden").val(moedaUsaToBR(ValTotal.toFixed(2)));
		
}
function SomarAcrescimo(){
		var acrescimo  = moedaBrToUsa($("#acrescimo").val())*1;
		var desconto   = moedaBrToUsa($("#desconto").val())*1;
		var TotalGeral = moedaBrToUsa($("#TotalGeral").val())*1;
		var ValTotal   = ((TotalGeral + acrescimo) - desconto);
		/*- Apresenta o valor na tela e preenche campo hidden-*/
		$("#TotalAluguel").val(moedaUsaToBR(ValTotal.toFixed(2)));
		$("#ValTotalAluguel").text(moedaUsaToBR(ValTotal.toFixed(2)));
		
}
$("#acrescimo").live("keyup",function(){
						var acrescimo = moedaBrToUsa($(this).val())*1;
						//alert(acrescimo);
							if(acrescimo != null){
								SomarAcrescimo();
									
							} if(acrescimo == '0'){
									var TotalEquipamento = moedaBrToUsa($("#TotalEquipamento").val())*1;
									var desconto         = moedaBrToUsa($("#desconto").val())*1;
									var TotalGeral = (TotalEquipamento - desconto );
									
									$("#TotalAluguel").val(moedaUsaToBR(TotalGeral.toFixed(2)));
									$("#ValTotalAluguel").text(moedaUsaToBR(TotalGeral.toFixed(2)));	
							}
						
})
$("#desconto").live('keyup',function(e){				
	  if(e.keyCode != '9'){
		  var desconto = moedaBrToUsa($(this).val())*1;
		  var valTotalOrcamento = moedaBrToUsa($("#TotalGeral").val());
		  var ResFinal = (desconto / valTotalOrcamento) * 100;
		  //alert(moedaUsaToBR(ResFinal.toFixed(2)));
		  $("#descontoPorcentagem").val(moedaUsaToBR(ResFinal.toFixed(2)));
		  /*---------- FUNCAO PARA ATUALIZAR O VALOR TOTAL DO ORÇAMENTO ---------*/					
		  SomarItensPorceto();
	  }
})

$("#descontoPorcentagem").live('keyup',function(){
				
	var valTotalOrcamento = moedaBrToUsa($("#TotalGeral").val());	
	var valPorcentagem = moedaBrToUsa($(this).val());
			
	var ResFinal = (valPorcentagem / 100) * valTotalOrcamento ;
	$("#desconto").val('');
	$("#desconto").val((moedaUsaToBR(ResFinal.toFixed(2))));
		var desc = $("#desconto").val();
		SomarItensPorceto();
					 					
})
function Pagamento(qtd){
		var qtd = qtd;
		var dataHoje = $("#data_hoje").val();
			//alert(qtd);
			if(qtd > '0'){	
				$("#pagar").removeAttr('disabled','disabled');
				var id  = $("#id").val();
				$("#titulo_parcela").css('display','block');
				$("#info_parcela").css('display','block');
				$("#info_parcela").html('');
			
				var total_orcamento = moedaBrToUsa($("#TotalAluguel").val());
				var result = (total_orcamento/qtd);
							
				var data_1 = $('<label>Primeira Parcela<br/><input type="text" name="parcela_1" id="parcela_1" size="8"  mascara="__/__/____"></label><div style="clear:both;"></div>');
				$("#info_parcela_1").html(data_1);
				
				dias = 0;
				for(i = 0; i < qtd; i++){	
					var j = i+1;
									
					var dmy = dataHoje.split("/"); 
					var joindate = new Date(parseInt(dmy[2], 10),parseInt(dmy[1], 10) - 1,parseInt(dmy[0], 10));
					joindate.setDate(joindate.getDate() + dias); 
					
					var campo_parcela = $('<div style="clear:both;"></div>\
					<label>Descri&ccedil;&atilde;o Parcela<br><input type="text" name="descricao_parcela[]" id="descricao_parcela" value="Parcela '+j+' Loca&ccedil;&atilde;o N&ordm; '+id+' "></label>\
					<label>Data Vencimento<br/><input size="9" type="text" name="data_vencimento_parcela[]" calendario="1" id="data_vencimento_parcela'+j+'" value="'+("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear()+'"></label>\
					<label>Valor Parcela<br><input type="text" name="valor_parcela[]" id="valor_parcela" size="8" readonly="readonly" value='+moedaUsaToBR(result.toFixed(2))+'></label>');					
					$("#info_parcela").append(campo_parcela);
					dias += 30;
				}
			} else{
					$("#pagar").attr('disabled','disabled');
					$("#titulo_parcela").css('display','none');	
					$("#info_parcela_1").html('');
					$("#info_parcela").css('display','none');
			}
}
/*- SCRIPT PARA PAGAMENTO ALUGUEL -*/
$("#pagamento").live('click',function(){
		aba_form(this,6);
		$("#botao_salvar").hide();
		var qtd = $("#QtdParcelaPg").val();
		//$("#entregaID").show();
		//$("#executadoID").show();
		//$("#executado").removeAttr('disabled','disabled');
		$("#ContaID").attr('valida_minlength','1');
		var pagar = $('<input type="submit" name="action" disabled="disabled" id="pagar" value="Enviar ao Financeiro">');					  
		$("#info_add").html(pagar);
		//$("#fimFieldset").append(entrega);
		Pagamento(qtd);	
});
/*
 * SCRIPT PARA FORMA DE PAGAMENTO E PARCELAS 
 */
var dias = 0;
$("select#parcelas").live('change',function(){
			
			var qtd = $(this).val();	
			Pagamento(qtd);
});
/*- SCRIPT PARA CALCULAR A DATA -*/
var dias = 0;
var h = 0;
$("#parcela_1").live('blur',function(){
		
		if($("#parcela_1").val() != ''){
		var qtd = $("select#parcelas").val();		
			dias = 0;
			 h = 0;
			for(var i=0;i<qtd; i++){
					h = i+1;
						var dataInsere = $(this).val();
            			var dmy = dataInsere.split("/"); 
						var joindate = new Date(parseInt(dmy[2], 10),parseInt(dmy[1], 10) - 1,parseInt(dmy[0], 10));
						joindate.setDate(joindate.getDate() + dias);
          				$("#data_vencimento_parcela"+h).val(("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear());							
						dias += 30;	
						
			}	
		}
			//return false;	
})
$("#ExInfoPg").live('click',function(){
	aba_form(this,6);
	$("#botao_salvar").hide();
		//$("#entregaID").show();
		//$("#executadoID").show();
		//$("#executado").removeAttr('disabled','disabled');
		var pagar = $('<input type="submit" name="action" disabled="disabled" id="pagar" value="Pagar">');					  
		$("#info_add").html(pagar);
		//$("#fimFieldset").append(entrega);
})


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
})

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
		//alert(tipo_cliente);
		$.post('modulos/ordem_servico/ordem_servico/tabela_item.php?acao=atl_cliente',{tipo_cadastro:tipo,nome:nome,cnpjCpf:cnpj_cpf},function(data){
				$("#cliente_id").val(data);
				$("#cliente").val(nome);
				$("#atl_nome").attr("disabled","disabled");
				$("#atl_cnpf_cpf").attr("disabled","disabled");
				$("#atl_cadastrar").attr("disabled","disabled");
				$(".modal").hide("slow");	
		})
		
})
/*-fim script para modal cliente-*/

</script>
<style>
	.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px;}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}
a{ text-decoration:none;}
</style>
<div id='conteudo'>
<div id='navegacao'>
<div id='some'>«</div>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="#" class='s2'>
  	Aluguel
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Loca&ccedil;&atilde;o / Devolu&ccedil;&atilde;o
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
 <form method="get" autocomplete="off">
    <select name="status_locacao" id="status_locacao">
    	<option value="">Status</option>
    	<option value="1" <?php if($_GET['status_locacao']==1){echo "selected=selected";}?>>Locaç&atilde;o</option>
        <option value="2" <?php if($_GET['status_locacao']==2){echo "selected=selected";}?>>Devolvido</option>
        <option value="3" <?php if($_GET['status_locacao']==3){echo "selected=selected";}?>>Parcialmente Devolvido</option>
        <option value="4" <?php if($_GET['status_locacao']==4){echo "selected=selected";}?>>Cancelado</option>
        <!--<option value="5" <?if($_GET['status_locacao']==5){echo "selected=selected";}?>>Em Andamento</option>-->
        <!--<option value="5" <?if($_GET['status_locacao']==6){echo "selected=selected";}?>>Reserva</option>-->
    </select>
    <select name="pago" id="pago">
        <option value="0">Selecione</option>
    	<option value="sim" <?php if($_GET['pago']=='sim'){echo "selected=selected";}?>>Pago</option>
        <option value="nao" <?php if($_GET['pago']=='nao'){echo "selected=selected";}?>>N&atilde;o Pago</option>
    </select>
    <input type="submit" value="Filtrar" />
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
     <a href="modulos/aluguel/locacao_devolucao/form.php" target="carregador" class="mais"></a>
    </form>
    
</div>

<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		//alert(id);
		window.open('modulos/aluguel/locacao_devolucao/form.php?id='+id,'carregador');
	});
});
</script>
<script>
$(document).ready(function(){
		$("table tr:odd").addClass('al');
});
</script>
<!-- JS PARA ALUGUEL -->
<script>	
$("#status_locacao").live('change',function(){
			var valor = $("select#status_locacao").val();
			if(valor == '6'){
					$("#aqui_reserva").css('display','block');
			} else{
					$("#aqui_reserva").css('display','none');
			}		
})
<!-- Adicionar Equipamento -->
var total_locacao = 0;
var total_item = 0;
$("#click_equipamento").live('click',function(){
				var total_locacao = 0;
				var total_item = 0;
				var qtd_disponivel    = $("#qtd_disponivel").val()*1;
				var valor_equipamento = $("#valor_equipamento").val();
				var qtd_selecionada   = $("#qtd_selecionada").val()*1;
				var dias              = $("#dias").val();
				var periodo           = $("#periodo").val();
				var equipamento_id    = $("#equipamento_id").val();	
				
					if(qtd_selecionada > qtd_disponivel){
							alert("Quantidade disponivel menor que a quantidae selecionada");
							return false;	
					} 
					if((dias == null) || (dias == '')){
						alert('Selecione a quantidade de dias');
						return false;	
					}
					if(qtd_disponivel == 0){
						alert("Nao existe equipamento disponivel");
						return false;
					}
					else{
							
							var dados = "equipamento_id="+equipamento_id+'&qtd='+qtd_selecionada+'&dias='+dias;
									/*-- faz o calculo para valor de dias --*/
									var total_item = ((dias / periodo) * valor_equipamento) * qtd_selecionada; 
									
									$.ajax({
										url: 'modulos/aluguel/locacao_devolucao/item_equipamento.php?acao=equipamento',
										type: 'POST',
										data: dados,
										success: function(data) {
											
											total_locacao = moedaBrToUsa($("#valor_total").val())*1;
											total_locacao += (total_item); /*- SOMA O TOTAL DE CADA ITEM  -*/
											/*----------- TOTAL PARA A LOCAÇAO --------------*/
											$("#valor_total").val(moedaUsaToBR(total_locacao.toFixed(2)));
											
											/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
											var total = moedaUsaToBR(total_locacao.toFixed(2));
											//var total = moedaUsaToBR(total_locacao.toFidex(2));
											$("table thead tr td div#total_locacao_table").html(total);
											$("#TotalEquipamentoView").text(total);
											$('#TotalEquipamento').val(total);
											$('#TotalGeral').val(total);								
											$("#equipamento_id").val('');
											$("#produto").val('');
											$("#total").val('');
											$("#qtd_disponivel").val('');
											$('#qtd_selecionada').val(1);
											$("#tbody").append(data);
											SomarItens();
										},
									});	
					}
})
$("#click_equipamento_excluir").live('click',function(){
	
	  var d = $(this).parent().parent();
	  var id = $(this).parent().parent().find("#id_equipamento").val();
	  var valor_total_item =$(this).parent().parent().find("#valor_total_item").val();
	
	
	  $(this).parent().parent().find("#id_equipamento").val(0);
	  $(this).parent().parent().find("#valor_total_item").val(0);
	  //Pega o valor total do Produto no Formulario
	  total_form = $("#valor_total").val();
	  total_atualizado  = (moedaBrToUsa(total_form)) - (moedaBrToUsa(valor_total_item));
	  //alert(total_form+' '+total_atualizado);
	  total_locacao = total_atualizado; // Aqui o Total Geral do produto é atualizado
	  //var total = total_locacao.toFixed(2);
	  //Atualiza o valor total do produto no Formulario
	  $("#valor_total").val(moedaUsaToBR(total_locacao.toFixed(2)));
	  /*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
	  $("table thead tr td div#total_locacao_table").html(moedaUsaToBR(total_locacao.toFixed(2)));
	  d.hide(); 
	
		
})
$("#excluir_edit_equip").live('click',function(){
	  var d = $(this).parent().parent();
	  var id            = $(this).parent().parent().find("#id_equip_update").val();
	  var id_item_equip = $(this).parent().parent().find("#id_item_equip").val();
	  var valor_total_item =$(this).parent().parent().find("#val_total_item").val();
	  /* Insere o valor zero no total do item clicado */
	  $(this).parent().parent().find("#val_total_item").val(0);
	  //Pega o valor total do Produto no Formulario
	  total_form = $("#valor_total").val();
	  total_atualizado  = (moedaBrToUsa(total_form)) - (moedaBrToUsa(valor_total_item));
	  //alert(total_form+' '+total_atualizado);
	  total_locacao = total_atualizado; // Aqui o Total Geral do produto é atualizado
	  //Atualiza o valor total do produto no Formulario
	  $("#valor_total").val(moedaUsaToBR(total_locacao.toFixed(2)));
	  /*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
	  $("table thead tr td div#total_locacao_table").html(moedaUsaToBR(total_locacao.toFixed(2)));
	  d.hide(); 	
})


$("#devolver").live('click',function(){
				var locacao = $("#id").val();
				var id = $(this).parent().parent().find("#id_equip_update").val();
				var itens = $(this).parent().parent();
				//alert(id);
				var dados = "id="+id+"&locacao="+locacao;
					$.ajax({
						url: 'modulos/aluguel/locacao_devolucao/item_equipamento.php?acao=devolver',
						type: 'POST',
						data: dados,
						success: function(data) {
									var result = data.split("-");
									//alert(data);
									if(result[1] > '0'){
										$(itens).find("#status_item").text('Devolvido');
										$(itens).find("#acao_item").text('');
										$("select#status_locacao").attr('selected','selected').val('3');
										$("#StatusLocacaoUpdate").val('3');
									} 
									else if(result[1] == '0'){
										$(itens).find("#status_item").text('Devolvido');
										$(itens).find("#acao_item").text('');
										$("select#status_locacao").attr('selected','selected').val('2');
										$("#StatusLocacaoUpdate").val('2');
									}
									else{
									
										$("select#status_locacao").attr('selected','selected').val('2');
										$("#StatusLocacaoUpdate").val('2');	
									}		
						},
					});
})	
/*
* Script para Cancelar o aluguel
*/
$("#CancelaAlg").live('click',function(){
			aba_form(this,7);
			$("#botao_salvar").hide();
			var btnCancelar = $('<input type="submit" name="action" id="cancelar" value="Cancelar" style="float:right;">');
			$("#info_add").html(btnCancelar);
})

$("#todos").live('click',function(){
			var id = $(this).val();
			ckeckbox = $("#todos");
			if($(ckeckbox).is(":checked")){			
				$("select#status_locacao").attr('selected','selected').val('2');	
			} else{
				$("select#status_locacao").attr('selected','selected').val('1');
					
			}
})

function calculaDias(){
		var data_devolucao = $("#data_devolucao").val();
		var data_locacao   = $("#data_locacao").val();
		//alert(data_locacao + ' - '+data_devolucao )
		$.post("modulos/aluguel/locacao_devolucao/item_equipamento.php?acao=calculadias", { 
			data_loc: data_locacao, data_dev:data_devolucao },function(data) {
					$('#dias').val(data);
 			}
		);
}
/*---- SCRIPT PARA CALCULO DE DIAS SELECIONANDO A DATA ----*/
$("#data_devolucao").live('blur',function(){
	calculaDias();
})
/*---- SCRIPT PARA CALCULO DE DIAS SELECIONANDO O DIA ----*/
$("#dias").live('blur',function(){
		
		var QtdDias = parseInt($(this).val());
		if(QtdDias > '0'){
				var DateLocacao = $("#data_locacao").val();
				var dmy = DateLocacao.split("/"); 
				var joindate = new Date(parseInt(dmy[2], 10),parseInt(dmy[1], 10) - 1,parseInt(dmy[0], 10));
				joindate.setDate(joindate.getDate() + QtdDias);
				 $("#data_devolucao").val(("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear());
		}
})
$("#click_despesa").live('click',function(){
	
	var despesas=$("#despesas").val();
	var qtd=$("#qtd_despesa").val()*1;
	var valor_despesa=moedaBrToUsa($("#valor_despesa").val())*1;
	var valor_total = qtd*valor_despesa;
	var total_despesa = moedaBrToUsa($("#total_despesa_table").text())*1;
	
	//alert(valor_despesa);
	
	if(despesas.length>0){
	total_despesa+=valor_total;
	$("#tbody_despesa").append("<tr class='col'><td style='border-left:1px solid #CCC;'>"+despesas+"<input type='hidden' name='despesas_tbl[]' class='despesas_tbl' value='"+despesas+"'><input type='hidden' name='id_despesa[]' value='novo'/></td><td style='width:45px;'>"+qtd+"<input type='hidden' name='qtd_despesas[]' class='qtd_despesas' value="+qtd+"></td><td style='width:65px;'>"+moedaUsaToBR(valor_despesa.toFixed(2))+"<input type='hidden' name='valor_despesa[]' class='valor_despesa' value="+valor_despesa+"></td><td style='width:65px;' class='valor_t'>"+moedaUsaToBR(valor_total.toFixed(2))+"</td><td style='width:45px;'><img src='../fontes/img/menos.png' id='excluir_despesa'></td></tr>");
	$("#total_despesa_table").text(moedaUsaToBR(total_despesa.toFixed(2)));
	$("#despesas").val('');
	$("#qtd_despesa").val('1');
	$("#valor_despesa").val('0,00');
	
	
	//$("#TotalEquipamentoView").text(total);
	$("#TotalDespesasView").text(moedaUsaToBR(total_despesa.toFixed(2)));
	$('#TotalDespesas').val(moedaUsaToBR(total_despesa.toFixed(2)));
	SomarItens();
	}else{
		alert("Digite uma Despesa");
	}
});

$("#excluir_despesa").live("click",function(){
	//alert("oi");
	var valor_total=moedaBrToUsa($("#total_despesa_table").text())*1;
	var valor_despesa=moedaBrToUsa($(this).parent().parent().find('.valor_t').text())*1;
	//alert($(this).parent().parent().find('.despesas_tbl').val());
	$(this).parent().parent().find('.despesas_tbl').val('-1');
	$(this).parent().parent().hide();
	valor_total-=valor_despesa;
	
	$("#total_despesa_table").text(moedaUsaToBR(valor_total.toFixed(2)));	
});


</script>
<!-- -->
<?php
	$statusLocacao = " AND status_locacao != '4' ";
	$fim='';
	if(!empty($_GET['status_locacao'])){
		$statusLocacao=" AND status_locacao ='".$_GET['status_locacao']."'";
	}
	if(!empty($_GET['pago'])){
		$fim.=" AND pago = '".$_GET['pago']."'";	
	}
	if(!empty($_GET['busca'])){
		if(is_numeric($_GET['busca'])){
			$fim = 'AND id = "'.$_GET['busca'].'"';	
		} else{
					$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE razao_social LIKE '%".$_GET['busca']."%' LIMIT 1 "));
					$fim = "AND cliente_id = '".$cliente->id."'";	
		}
	}
?>
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
          <td width="60">N&deg;</td>
          <td width="280">Descri&ccedil;&atilde;o Loca&ccedil;&atilde;o</td>
          <td width="240">Cliente</td>
          <td width="65">Loca&ccedil;&atilde;o</td>
          <td width="65">Devolu&ccedil;&atilde;o</td>
          <td width="90">Situa&ccedil;&atilde;o</td>
          <td width="80">Valor Total</td>
          <td width="35">Pago</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
		<?php
        		$registros = mysql_result(mysql_query(" SELECT COUNT(*) FROM aluguel_locacao WHERE vkt_id = '$vkt_id' $statusLocacao $fim "),0,0);
				$sql = mysql_query(" SELECT * FROM aluguel_locacao WHERE vkt_id = '$vkt_id' $statusLocacao $fim LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
				while($aluguel=mysql_fetch_object($sql)){
					$total++;
					$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$aluguel->cliente_id' "));
		?>     
    	<tr id="<?=$aluguel->id;?>">
          <td width="60"><?=$aluguel->id;?></td>
          <td width="280"><?=$aluguel->descricao?></td>
          <td width="240"><?=$cliente->razao_social?></td>
          <td width="65"><?=dataUsaToBr($aluguel->data_locacao)?></td>
          <td width="65"><?=dataUsaToBr($aluguel->data_devolucao)?></td>
          <td width="90">
          <?
          	if($aluguel->status_locacao == '1'){
					echo "Locado";
			} else if($aluguel->status_locacao == '2'){
					echo "Devolvido";
			} else if($aluguel->status_locacao == '3'){
					echo "Parcialmente Devolvido";
			} else if($aluguel->status_locacao == '4'){
					echo "Cancelado";
			} else if($aluguel->status_locacao == '5'){
					echo "Em Andamento";
			} else if($aluguel->status_locacao == '6'){
					echo "Reserva";
			}
		  ?>
          </td>
          <td width="80">
		  <?
		  $TotalAluguel = ($aluguel->valor_total + $aluguel->acrescimo - $aluguel->desconto);
			echo moedaUsaToBr($TotalAluguel);			
		  ?>
           </td>
          <td width="35" style="text-transform:capitalize;"><?=$aluguel->pago;?></td>
          <td></td>
        </tr>
        <?php
				}
		?>
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
          <td width="60"><a>Total: <?=$total?></a></td>
          <td width="280"></td>
          <td width="240"></td>
          <td width="65"></td>
          <td width="65"></td>
          <td width="90"></td>
          <td width="80"></td>
          <td width="35"></td>
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