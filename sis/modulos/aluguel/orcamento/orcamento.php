<?php
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
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
</style>
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

$("#envio-email").live('click',function(){
					//$(this).hide();
					//$("#botao_salvar").hide();
					//var btnEnviar = $('<label><input type="button" value="Enviar" id="enviarEmail"></label>');
					//$("#info_botao").html(btnEnviar);
});
function validaEmail(email){
	er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
    if(er.exec(email))
        return true;
    else
        return false;
}
$("#enviarEmail").live('click',function(){
		if($.trim($("#emailDestino").val()) != ""){
					var aluguelID = $("#id").val();
					var email = $("#emailDestino").val();
					var msg   = $("#msg").val();
					var result = validaEmail(email);
						if(result == true){
								var iconCarregando = $('<p>Carregando...</p>');
								var dados = "id="+aluguelID+"&emailDestino="+email+"&msg="+msg;
								$.ajax({
									type:'POST',
									url:'modulos/aluguel/orcamento/enviaEmail.php',
									data:dados,
										beforeSend: function(){
											$('#carregaEmail').html(iconCarregando);
										},
										complete: function() {
											$(iconCarregando).remove();
										},
										success: function(html, textStatus) {
											$('#carregaEmail').html("<strong>Email Enviado</strong>");
										},
										error: function(xhr,er) {
											$('#carregaEmail').html('<p class="destaque">Lamento! Ocorreu um erro. Por favor tente mais tarde.')
										}	
								})	
						}
		}	
})

$("#parcelas").live("change",function(){
				
				var numparcelas    = $("#parcelas").val();
				var valor_total    = $("#total_resumo").text();
				var id             = $("#id").val();
					//alert(numparcelas);		
					var dados = "numparcelas="+numparcelas+"&valor_total="+valor_total+"&id="+id;
														
					$.ajax({
						url: 'modulos/aluguel/orcamento/parcelas.php',
						type: 'POST',
						data: dados,
							success: function(data) {
								/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
																					
								//if(data.length>2){								
									//alert(data);
									$("#divparcelas").text('');
									$("#divparcelas").append(data);
								//}
							},
						});	
					
	});
</script>

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
<span></span>    Orçamento
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
      
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["de"];?>" height="7"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["ate"];?>" height="7"/>
    <input type="hidden" name="tela_id" value="<?=$_GET[tela_id]?>" />
      <input type="submit" value="Filtrar" />
     <a href="modulos/aluguel/orcamento/form.php" target="carregador" class="mais"></a>
    <span style="float:right;margin-right:10px;">
      Período: 
  	<?php 
		if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			echo "01/".date("m/Y")." a ".date("t/m/Y");
		}else{
			echo $_GET['de']." a ".$_GET['ate'];
		}?>
        
  </span>
    </form>
    
</div>

<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		//alert(id);
		window.open('modulos/aluguel/orcamento/form.php?id='+id,'carregador');
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
				var porcentagem_desc = moedaBrToUsa($("#descontoPorcentagem").val())*1;
	  			var acrescimo = moedaBrToUsa($("#acrescimo").val())*1;	
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
										url: 'modulos/aluguel/orcamento/item_equipamento.php?acao=equipamento',
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
											$("#equipamento_id").val('');
											$("#produto").val('');
											$("#total").val('');
											$("#qtd_disponivel").val('');
											$('#qtd_selecionada').val(1);
											$("#tbody").append(data);
											$("#total_equipamento_resumo").text(total);
											desconto = total_locacao*porcentagem_desc/100;
	  										$("#desconto").val(moedaUsaToBR(desconto));
	  										$("#total_equipamento_resumo").text(moedaUsaToBR(total_locacao.toFixed(2)));
	  										$("#sub-total").text(moedaUsaToBR(total_locacao.toFixed(2)));
	  
	  										total_resumo=total_locacao-desconto+acrescimo;
	  
	  										$("#total_resumo").text(moedaUsaToBR(total_resumo.toFixed(2)));
										},
									});
								
					}
})
$("#click_equipamento_excluir").live('click',function(){
	
	  var d = $(this).parent().parent();
	  var id = $(this).parent().parent().find("#id_equipamento").val();
	  var valor_total_item =$(this).parent().parent().find("#valor_total_item").val();
	  var porcentagem_desc = moedaBrToUsa($("#descontoPorcentagem").val())*1;
	  var acrescimo = moedaBrToUsa($("#acrescimo").val())*1;		
		
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
	  d.remove(); 
	  desconto = total_locacao*porcentagem_desc/100;
	  $("#desconto").val(moedaUsaToBR(desconto));
	  $("#total_equipamento_resumo").text(moedaUsaToBR(total_locacao.toFixed(2)));
	  $("#sub-total").text(moedaUsaToBR(total_locacao.toFixed(2)));
	  
	  total_resumo=total_locacao-desconto+acrescimo;
	  
	  $("#total_resumo").text(moedaUsaToBR(total_resumo.toFixed(2)));
		
})
$("#excluir_edit_equip").live('click',function(){
	  
	  var d = $(this).parent().parent();
	  var id            = $(this).parent().parent().find(".id_equip_update").val();
	  var id_item_equip = $(this).parent().parent().find(".id_item_equip").val();
	  var valor_total_item =$(this).parent().parent().find(".total_item").text();
	  //alert(valor_total_item);
	  var porcentagem_desc = moedaBrToUsa($("#descontoPorcentagem").val())*1;
	  var acrescimo = moedaBrToUsa($("#acrescimo").val())*1;	  
	  /* Insere o valor zero no total do item clicado */
	  $(this).parent().parent().find("#locacao_valor_total_item").val(0);
	  $(this).parent().parent().find(".val_total_item").val(0);
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
	  desconto = total_locacao*porcentagem_desc/100;
	  $("#desconto").val(moedaUsaToBR(desconto));
	  $("#total_equipamento_resumo").text(moedaUsaToBR(total_locacao.toFixed(2)));
	  $("#sub-total").text(moedaUsaToBR(total_locacao.toFixed(2)));
	  
	  total_resumo=total_locacao-desconto+acrescimo;
	  
	  $("#total_resumo").text(moedaUsaToBR(total_resumo.toFixed(2)));
	  //$("#desconto").val(moedaUsaToBR(total_locacao));
	  	
})


$("#devolver").live('click',function(){
				var locacao = $("#id").val();
				var id = $(this).parent().parent().find("#id_equip_update").val();
				var itens = $(this).parent().parent();
				//alert(id);
				var dados = "id="+id+"&locacao="+locacao;
					$.ajax({
						url: 'modulos/aluguel/orcamento/item_equipamento.php?acao=devolver',
						type: 'POST',
						data: dados,
						success: function(data) {
									var result = data.split("-");
									//alert(data);
									if(result[1] > '0'){
										$(itens).find("#status_item").text('Devolvido');
										$(itens).find("#acao_item").text('');
										$("select#status_locacao").attr('selected','selected').val('3');
									} 
									else if(result[1] == '0'){
										$(itens).find("#status_item").text('Devolvido');
										$(itens).find("#acao_item").text('');
										$("select#status_locacao").attr('selected','selected').val('2');
									}
									else{
									
										$("select#status_locacao").attr('selected','selected').val('2');	
									}		
						},
					});
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
		$.post("modulos/aluguel/orcamento/item_equipamento.php?acao=calculadias", { 
			data_loc: data_locacao, data_dev:data_devolucao },function(data) {
					$('#dias').val(data);
 			}
		);
}
/*---- SCRIPT PARA CALCULO DE DIAS ----*/
$("#data_devolucao").live('blur',function(){
	calculaDias();

})
$("#dias").live('blur',function(){
	var dias = $(this).val();
	var data_locacao = $("#data_locacao").val();
		//alert(data_locacao + ' - '+data_devolucao )
		$.post("modulos/aluguel/orcamento/item_equipamento.php?acao=calculadata", { 
			data_loc: data_locacao, dias_loc:dias },function(data) {
					$('#data_devolucao').val(data);
 			}
		);
})

$("#click_despesa").live('click',function(){
	
	var despesas=$("#despesas").val();
	var qtd=$("#qtd_despesa").val()*1;
	var valor_despesa=moedaBrToUsa($("#valor_despesa").val())*1;
	var valor_total = qtd*valor_despesa;
	var total_despesa = moedaBrToUsa($("#total_despesa_table").text())*1;
	
	//alert(valor_despesa);
	
	total_despesa+=valor_total;
	$("#tbody_despesa").append("<tr class='col'><td style='border-left:1px solid #CCC;'>"+despesas+"<input type='hidden' name='despesas_tbl[]' class='despesas_tbl' value='"+despesas+"'><input type='hidden' name='id_despesa[]' value='novo'/></td><td style='width:45px;'>"+qtd+"<input type='hidden' name='qtd_despesas[]' class='qtd_despesas' value="+qtd+"></td><td style='width:65px;'>"+moedaUsaToBR(valor_despesa.toFixed(2))+"<input type='hidden' name='valor_despesa[]' class='valor_despesa' value="+valor_despesa+"></td><td style='width:65px;' class='valor_t'>"+moedaUsaToBR(valor_total.toFixed(2))+"</td><td style='width:45px;'><img src='../fontes/img/menos.png' id='excluir_despesa'></td></tr>");
	$("#total_despesa_table").text(moedaUsaToBR(total_despesa.toFixed(2)));
	$("#despesas").val('');
	$("#qtd_despesa").val('1');
	$("#valor_despesa").val('');
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

$("#descontoPorcentagem").live("keyup",function(){
	//alert("oi");
	vlr_total = moedaBrToUsa($("#total_equipamento_resumo").text())*1;
	desc_porc =	moedaBrToUsa($(this).val())*1;
	acrescimo = moedaBrToUsa($("#acrescimo").val())*1;
	desconto = vlr_total*desc_porc/100;
	$("#desconto").val(moedaUsaToBR(desconto));
	$("#total_resumo").text(moedaUsaToBR(vlr_total-desconto+acrescimo));
	
});

$("#desconto").live("keyup",function(){
	//alert("oi");
	vlr_total = moedaBrToUsa($("#total_equipamento_resumo").text())*1;
	desconto = moedaBrToUsa($(this).val())*1;
	acrescimo = moedaBrToUsa($("#acrescimo").val())*1;
	//desc_porc =	moedaBrToUsa($("#descontoPorcentagem").val())*1;
	$("#descontoPorcentagem").val(moedaUsaToBR(desconto*100/vlr_total).toFixed(2));
	$("#total_resumo").text(moedaUsaToBR(vlr_total-desconto+acrescimo).toFixed(2));
	
});

$("#acrescimo").live("keyup",function(){
	//alert("oi");
	vlr_total = moedaBrToUsa($("#total_equipamento_resumo").text())*1;
	desconto = moedaBrToUsa($("#desconto").val())*1;
	acrescimo = moedaBrToUsa($(this).val())*1;
	//desc_porc =	moedaBrToUsa($("#descontoPorcentagem").val())*1;
	//$("#descontoPorcentagem").val(moedaUsaToBR(desconto*100/vlr_total));
	$("#total_resumo").text(moedaUsaToBR(vlr_total-desconto+acrescimo).toFixed(2));
	
});
</script>
<!-- -->
<?php
	$fim='';
	if(!empty($_GET['de'])&&!empty($_GET['ate'])){
		$filtro=" AND data_locacao BETWEEN '".DataBrToUsa($_GET['de'])."' AND '".DataBrToUsa($_GET['ate'])."'";
	}

	if(!empty($_GET['busca'])){
		$fim = ' AND descricao LIKE "%'.$_GET['busca'].'%"';	
	}
?>
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
          <td width="60">N&deg;</td>
          <td width="340">Descri&ccedil;&atilde;o Loca&ccedil;&atilde;o</td>
          <td width="180">Cliente</td>
          <td width="80">Loca&ccedil;&atilde;o</td>
          <td width="80">Devolu&ccedil;&atilde;o</td>
          <td width="90">Situa&ccedil;&atilde;o</td>
          <td width="80">Valor Total</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
		<?php
        		$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM aluguel_locacao WHERE vkt_id = '$vkt_id' and status_locacao='7' $filtro $fim "),0,0);
				$sql = mysql_query(" SELECT * FROM aluguel_locacao WHERE vkt_id = '$vkt_id' and status_locacao='7' $filtro $fim  LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));;	
				while($aluguel=mysql_fetch_object($sql)){
					$total++;
					$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$aluguel->cliente_id' "));
		?>     
    	<tr id="<?=$aluguel->id;?>">
          <td width="60"><?=$aluguel->id;?></td>
          <td width="340"><?=$aluguel->descricao?></td>
          <td width="180"><?=$cliente->razao_social?></td>
          <td width="80"><?=dataUsaToBr($aluguel->data_locacao)?></td>
          <td width="80"><?=dataUsaToBr($aluguel->data_devolucao)?></td>
          <td width="90">
          	Orçamento
          </td>
          <td width="80"><?=moedaUsaToBr($aluguel->valor_total);?></td>
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
          <td width="60"><a>Total: </a></td>
          <td width="340"></td>
          <td width="180"></td>
          <td width="80"></td>
          <td width="80"></td>
          <td width="90"></td>
          <td width="80"></td>
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
