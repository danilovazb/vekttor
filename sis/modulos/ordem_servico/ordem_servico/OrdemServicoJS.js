/*- SCRIPT PARA OS FILTORS -*/

var urlAjaxOs = "modulos/ordem_servico/ordem_servico/ajax.php";
var urlTabelaItem = "modulos/ordem_servico/ordem_servico/tabela_item.php";

$.fn.serializeObject = function(){
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function VerificaDescontos(input){
	var obj = { valor:input.val(),funcao:'VerificaDescontos'}
	$.ajax({
		type:"POST",
		url:urlAjaxOs,
		data:obj
	}).done(function(data){
		if(data == 'success'){
			return true;
		}
		else{
			alert("Não podemos efeturar desconto nessa quantia");
			input.val("");
		}
	});
}

$("#desconto-produto,#desconto").live("blur",function(){
	if( $.trim($(this).val()) != "" )
		VerificaDescontos($(this));
});

/* Antes de alterar qualquer linha de codigo dessa função fale com o autor */
function TemplateTableEquipamento(dados,ID){
	var idEdit = "";
	var inputOS = "";
	if ( dados.os_id !== 0);
		inputOS = "<input type='hidden' name='os_id' value='"+dados.os_id+"'>";
	
	if( $.trim(dados.os_id) != "" )
		idEdit = "del-equipamento-edit";
	else 
		idEdit = "del-equipamento";
	
	var $table = ''+
	'<table id="table-equipamento" class="table-equipamento-'+ID+'" cellpadding="0" cellspacing="0" width="98%">'+
	  '<thead>'+
		'<tr>'+
			'<th colspan="4" align="left" class="equipamento">'+dados.equipamento+'<a href="#" id="'+idEdit+'"><span style="float:right; color:#777"> &times; </span></a></th>'+
		'</tr>'+
		'<tr>'+
			'<th style="width:35px;">COD</th>'+
			'<th>Solicitação / Defeito</th>'+
			'<th>Diagnóstico / Laudo</th>'+
			'<th>Estado Equipamento</th>'+
		'</tr>'+
	  '</thead>'+
	  '<tbody>'+
		'<tr>'+
			'<td>'+inputOS+
			  '<input type="hidden" name="equipamento" value="'+dados.equipamento+'">'+
			  '<input type="hidden" name="marca" value="'+dados.marca+'">'+
			  '<input type="hidden" name="modelo" value="'+dados.modelo+'">'+
			  '<input type="hidden" name="numero_serie" value="'+dados.numero_serie+'">'+
			  '<input type="hidden" name="equipamento_id[]" value="'+ID+'"> '+ID+'</td>'+
			'<td><input type="hidden" name="solicitacao_defeito[]" value="'+dados.solicitacao_defeito+'"><span>'+dados.solicitacao_defeito+'</span></td>'+
			'<td><input type="hidden" name="diagnostico_laudo[]" value="'+dados.diagnostico_laudo+'"><span>'+dados.diagnostico_laudo+'</span></td>'+
			'<td><input type="hidden" name="estado_equipamento[]" value="'+dados.estado_equipamento+'"><span>'+dados.estado_equipamento+'</span></td>'+
		'</tr>'+
	  '</tbody>'+
     '</table>';
	return $table;
}

/* Antes de alterar qualquer linha de codigo dessa função fale com o autor */
function TemplateTableHistorico(dados){
	var $htmlTable = '';
	var valido = $.isEmptyObject(dados.itens);
	if( valido == false){
	  $htmlTable += ''
	     +'<table id="table-equipamento" class="table-equipamento-'+dados.id+'" cellpadding="0" cellspacing="0" width="100%">'+
			'<thead>'+
			   '<tr>'+
				 '<th colspan="5" align="left" class="equipamento">'+dados.nome+'</th>'+
			   '</tr>'+
			   '<tr>'+
				'<th style="width:130px">Defeito</th>'+
				'<th style="width:130px">Laudo</th>'+
				'<th style="width:120px">Estado Equipamento</th>'+
				'<th style="width:90px">Data Cadastro</th>'+
				'<th style="width:90px">O.S Nº</th>'+
			   '</tr>'+
			'</thead>'+
          '<tbody>';
		$.each(dados.itens,function(i,item){  
			$htmlTable += ''+
			'<tr>'+
			  '<td>'+item.solicitacao_defeito+'</td>'+
			  '<td>'+item.diagnostico_laudo+'</td>'+
			  '<td>'+item.estado_equipamento+'</td>'+
			  '<td>'+item.data_cadastro+'</td>'+
			  '<td>'+item.os_id+'</td>'+
			'</tr>';
		});
	
		$htmlTable += '</tbody>';
		$htmlTable += '</table>';
		$(".table-historico").html($htmlTable);
		$(".historio-ativo").html("<input type='hidden' id='input-historico-ativo' name='input-historico-ativo' value='1'>");
	
	} else {
		$(".table-historico").html($htmlTable);
		$(".historio-ativo").html("");
	}
}

/* Função Histórico*/
var historio = function(NumeroSerie){
	$.post(urlAjaxOs,{numSerie:NumeroSerie,funcao:"ListNumeroSerie"},function(dados){
		TemplateTableHistorico(dados);
	},'json');
}

/* Função adicionar produto */
var AddProduto = function(){
  var produto = $("#produto").val(); 
  var produto_id = $("#produto_id").val(); 
  var qtd_produto = $("#qtd_produto").val(); 
  var preco_venda = $("#preco_venda_produto").val(); //urlTabelaItem
  
  var valor =  (preco_venda * qtd_produto);
  var dados = "produto="+produto+"&produto_id="+produto_id+"&qtd="+qtd_produto;
	$.ajax({
	  url: urlTabelaItem+'?acao=produto',
	  type: 'POST',
	  data: dados,
	  success: function(data, textStatus) {
		if(data != 'error'){
			
		  $('#tbody').append(data);
		  $("#produto").val('');
		  total_produto = moedaBrToUsa($("#total_produto").val())*1;
		  total_produto += (valor);
	  
		  // Total para produto
		  $("#total_produto").val(moedaUsaToBR(total_produto.toFixed(2)));
		  $("#TotalProduto").text(moedaUsaToBR(total_produto.toFixed(2)));
		  $("#total-geral-produto").val(moedaUsaToBR(total_produto.toFixed(2)));
		  
		  // TOTAL NO FINAL DA TABELA
		  $("table thead tr td div#t_produto_table").html(moedaUsaToBR(total_produto.toFixed(2)));
		  
		  // ATUALIZAR O VALOR TOTAL DO ORÇAMENTO
		  SomaTotal(); 
		}
	  }//.success
	}); //.ajax
}

//Deleta Equipamento da Lista
$("#del-equipamento").live("click",function(event){
	event.preventDefault();
	var $table = $(this).closest("table");
	$table.remove();
});

$("#result-table-equipamento table#table-equipamento tbody tr").live("click",function(){
	var $window = $("#window-add-equipamento");
	var $tr = $(this);
	var os_id               = $tr.find("input[name='os_id']").val(); //Somente para edição
	var equipamento_id      = $tr.find("input[name='equipamento_id[]']").val();
	var equipamentoTEXT     = $tr.find("input[name='equipamento']").val();
	var estadoEquipamento   = $tr.find("input[name='estado_equipamento[]']").val();
	var marca               = $tr.find("input[name='marca']").val();
	var modelo              = $tr.find("input[name='modelo']").val();
	var numero_serie        = $tr.find("input[name='numero_serie']").val();
	var solicitacao_defeito = $tr.find("input[name='solicitacao_defeito[]']").val();
	var diagnostico_laudo   = $tr.find("input[name='diagnostico_laudo[]']").val();
	 
	$window.load("modulos/ordem_servico/ordem_servico/form_equipamento.php",function(){
	  historio(numero_serie);
	  $window.find("#os_id").val(os_id);
	  $window.find("#equipamento_id").val(equipamento_id);
	  $window.find("#equipamento").val(equipamentoTEXT);
	  $window.find("#equipamento").attr("disabled","disabled");
	  $window.find("#modelo").val(modelo);
	  $window.find("#modelo").attr("disabled","disabled");
	  $window.find("#marca").val(marca);
	  $window.find("#marca").attr("disabled","disabled");
	  $window.find("#numero_serie").val(numero_serie);
	  $window.find("#numero_serie").attr("disabled","disabled");
	  $window.find("#estado_equipamento").val(estadoEquipamento);
	  $window.find("#solicitacao_defeito").val(solicitacao_defeito);
	  $window.find("#diagnostico_laudo").val(diagnostico_laudo);
	  var $divAction = $window.find("div#action"); 
	  $divAction.find("button:first").hide();
	  $divAction.prepend("<button type='button' id='btn-atualizar-equipamento'>Atualizar</button>");
	});

});

$("#cadEquipamento").live("click",function(){
	var erro = 0;
	var msg = "";
	var dados_form = $("#form_equipamento_cadastro").serializeArray();
	var $table = "";
	var dados = $("#form_equipamento_cadastro").serializeObject();
	var json_dados = $.parseJSON(JSON.stringify(dados));
	
	if ( $.trim(json_dados.solicitacao_defeito) == ""){
		msg += " Informe o defeito do Equipamento \n ";
		erro++;
	}
	if(erro > 0){
		alert(msg);
	} else {
	  $.post(urlAjaxOs,{dados_form:dados,funcao:"CadastraEquipamento"},function(dados){
		
		if( $.trim(dados.equipamentoID) !== ""){
		  $table = TemplateTableEquipamento(json_dados,dados.equipamentoID);
		  
		  var compara = 0;
		  $("form#form_osCadastro input[type='hidden'][name='list_equipamento[]']").each(function(index, element) {
			  if(this.value == dados.equipamentoID)
			   compara++;
		  });
		  
		  if(compara == 0){
			  $("#result-table-equipamento").prepend($table);
			  var $tableAdd = $(".table-equipamento-"+dados.equipamentoID);
			  $tableAdd.find(".equipamento > a").attr("class",dados.ItemID);
		  
			  $("#lista-equipamento").append("<input type='hidden' name='list_equipamento[]' value='"+dados.equipamentoID+"'>");
			  $("#window-add-equipamento .exibe_formulario").remove();
		  } else {
			  alert("Você já selecionou esse equipamento ");
			  return false;	
		  }
		  
		}
	  },'json');
		
	}
});

$("#btn-atualizar-equipamento").live("click",function(event){
	event.preventDefault();
	var dados = $("#form_equipamento_cadastro").serializeObject();
	var $tr = $(".table-equipamento-"+dados.equipamento_id+"");
	
	//$.post(urlAjaxOs,{dados_form:dados,funcao:"AtualizaEquipamento"},function(){}); Aqui ele Atualiza o equipamento
	
	$tr.find('input[name="solicitacao_defeito[]"]').val(dados.solicitacao_defeito);
	$tr.find("tbody tr td:eq(1) > span").text(dados.solicitacao_defeito);
	
	$tr.find('input[name="diagnostico_laudo[]"]').val(dados.diagnostico_laudo);
	$tr.find("tbody tr td:eq(2) > span").text(dados.diagnostico_laudo);
	
	$tr.find('input[name="estado_equipamento[]"]').val(dados.estado_equipamento);
	$tr.find("tbody tr td:eq(3) > span").text(dados.estado_equipamento);
	
	$("#window-add-equipamento .exibe_formulario").remove();
	
});

$("#del-equipamento-edit").live("click",function(){
	var $table = $(this).closest("table");
	var ItemID = $(this).attr("class");
	$.post(urlAjaxOs,{funcao:"DeleteItemEquipamento",id:ItemID},function(){
		$table.remove();
	});
});

$("#close_form_os_equipamento").live("click",function(){
	var $form_equipamento = $(this).closest("div.exibe_formulario");
	$form_equipamento.remove();
});

$("#estado_equipamento,#solicitacao_defeito,#diagnostico_laudo").live("blur",function(){
	
	if( ($.trim($("#os_id").val() ) != "") && ($.trim( $("input#equipamento_id").val() ) != "") ) {
	  var NameColumn = $(this).attr("name");
	  var obj = { 
	  	os_id:$("#os_id").val(), equipamento_id:$("#equipamento_id").val(), TextAtualizar:$(this).val(), NameColumn:NameColumn 
	  }
	  $.post(urlAjaxOs,{funcao:"AtualizaItemEquipamento", dados:obj},function(data){ console.log(data); });
	}
	
});

//Adicionar Equipamento
$("#add-equipamento").live("click",function(){
	$("#window-add-equipamento").show();
	var $window = $("#window-add-equipamento");
	var os_id = $("#id").val();
	
	$("#window-add-equipamento").load("modulos/ordem_servico/ordem_servico/form_equipamento.php",function(){
		$window.find("#os_id").val(os_id);
	});
});

$("#numero_serie").live("blur",function(){
	var NumeroSerie = $(this).val();
	 
	if( $.trim(NumeroSerie) != "" ){
		$("form#form_equipamento_cadastro .ca").val("Aguarde...");
	
		$.post(urlAjaxOs,{numSerie:NumeroSerie,funcao:"ListNumeroSerie"},function(dados){
			$("form#form_equipamento_cadastro .ca").val("");
			
			var valido = $.isEmptyObject(dados);
			
			if(valido == false){
				$("#equipamento_id").val(dados.id);
				$("#equipamento").val(dados.nome);
				$("#modelo").val(dados.modelo);
				$("#marca").val(dados.marca);
				TemplateTableHistorico(dados);
			} else {
				$("#equipamento_id").val("");
				$(".table-historico").html("");	
			}
		},'json');
	} else {
		$("form#form_equipamento_cadastro .ca").val("");
	}
	
});

$("#equipamento").live("blur",function(){
	historio($("#numero_serie").val());
});
 
/* Soma total produtos */
var SomaTotalProdutos = function(){
	var totalGeralProduto = 0;
	var TotalNotas = 0;
	TotalNotas = ( moedaBrToUsa($("#total_produto").val()) - moedaBrToUsa($("#desconto-produto").val()));
	totalGeralProduto = TotalNotas;
	
	if( $.trim($("#acrescimo-produto").val()) != "" )
		totalGeralProduto = TotalNotas + moedaBrToUsa($("#acrescimo-produto").val())*1;
		
	$("#total-geral-produto").val( moedaUsaToBR(totalGeralProduto.toFixed(2)) );
}

/* Soma total serviços */
var SomaTotalServicos = function(){
	var totalGeralServico = 0;
	var TotalNotas = 0;
    TotalNotas = ( moedaBrToUsa($("#total_servico").val()) - moedaBrToUsa($("#desconto").val()));
	totalGeralServico = TotalNotas;
	
	if( $.trim($("#acrescimo").val()) != "" )
		totalGeralServico = TotalNotas + moedaBrToUsa($("#acrescimo").val())*1;
	
	$("#total-servico").val( moedaUsaToBR(totalGeralServico.toFixed(2)) );
}

/*Total Geral*/
var TotalGeral = function(){
  var total_produto = moedaBrToUsa($("#total-geral-produto").val())*1;
  var total_servico = moedaBrToUsa($("#total-servico").val())*1;
  
  var total = (total_produto + total_servico);					
  $("#ostotalView").val(moedaUsaToBR(total.toFixed(2)));
  
  Lucro();
}

$("select#situacao").live('change',function(){
	
	var valor = $(this).val();
	var de = $("#de").val();
	var ate = $("#ate").val();
	
	if( $.trim(valor) != "all" ){
	var situacao = ($(this).find("option:selected").attr("id"));
	if(situacao == 1)
		location.href=("?tela_id=276&status="+valor+"&situacao="+situacao+"&de="+de+"&ate="+ate);
	else if(situacao == 2)
		location.href=("?tela_id=276&status="+valor+"&situacao="+situacao+"&aprovacao=1"+"&de="+de+"&ate="+ate);
	else if(situacao == 3)
		location.href=("?tela_id=276&situacao="+situacao+"&cancelada=1"+"&de="+de+"&ate="+ate);
	} else {
		location.href=("?tela_id=276&de="+de+"&ate="+ate);
	}
		
});

/*Add produto */
var total_produto = 0;

$("#produto").live("keyup",function(event){
	var code = event.keyCode || event.which;
	if( $.trim($("#produto_id").val()) !== "" ){
		if( code == 13)
			AddProduto();
	}
});
$("#click_produto").live('click',function(){
	AddProduto();
});

var total_atualizado = 0;
var total_produto_form = 0;
$("#click_produto_excluir").live('click',function(){
		var d = $(this).parent().parent();
		
		var qtd_produto   = $(this).parent().parent().find("#array_qtd_produto").val();   // QTD do Item selecionado
		var valor_produto = $(this).parent().parent().find("#array_valor_produto").val(); // Valor Unitario
		var valor_total   = $(this).parent().parent().find("#v_total_produto").val();     // Valor Total
		
		/*-- INSERE O VALOR NULO NO INPUT QUE FOI EXCLUIDO -*/
		$(this).parent().parent().find("#array_qtd_produto").val(0);   
		$(this).parent().parent().find("#array_valor_produto").val(0); 
		$(this).parent().parent().find("#v_total_produto").val(0);     
		$(this).parent().parent().find("#array_produto_id").val(0); 
		//Pega o valor total do Produto no Formulario
		total_produto_form = $("#total_produto").val();
		
		total_atualizado  = (moedaBrToUsa(total_produto_form)*1) - (moedaBrToUsa(valor_total)*1);
		total_produto = total_atualizado; // Aqui o Total Geral do produto é atualizado
		//Atualiza o valor total do produto no Formulario
		$("#total_produto").val(moedaUsaToBR(total_atualizado.toFixed(2)));
		$("#TotalProduto").text(moedaUsaToBR(total_atualizado.toFixed(2)));
		d.hide();
		//Atualiza o valor Total da Tabela Abaixo
		$("table thead tr td div#t_produto_table").html(moedaUsaToBR(total_atualizado.toFixed(2)));
		/*---------- FUNCAO PARA ATUALIZAR O VALOR TOTAL DO ORÇAMENTO ---------*/
		SomaTotal();
			
})
/* SCRIPT PARA EDICAO DO PRODUTO EVENTO DO BOTAO EXCLUIR */
$("#edit_produto_excluir").live('click',function(){
		var d     = $(this).parent().parent();
		var os_id = $("#id").val(); // ID da OS
		
		var produto_id    = $(this).parent().parent().find("#array_produto_id").val();    // ID do produto
		var qtd_produto   = $(this).parent().parent().find("#array_qtd_produto").val();   // QTD do Item selecionado
		var valor_produto = $(this).parent().parent().find("#array_valor_produto").val(); // Valor Unitario
		var valor_total   = $(this).parent().parent().find("#v_total_produto").val();     // Valor Total
		
		/*-- INSERE O VALOR NULO NO INPUT QUE FOI EXCLUIDO -*/
		//$(this).parent().parent().find("#array_produto_id").val(0);
		$(this).parent().parent().find("#array_qtd_produto").val(0);   
		$(this).parent().parent().find("#array_valor_produto").val(0); 
		$(this).parent().parent().find("#v_total_produto").val(0); 
		$(this).parent().parent().find("#osIDProduto").val(0);
		//Pega o valor total do Produto no Formulario
		total_produto_form = $("#total_produto").val();
		
		total_atualizado  = (moedaBrToUsa(total_produto_form)*1) - (moedaBrToUsa(valor_total)*1);
		total_produto = total_atualizado; // Aqui o Total Geral do produto é atualizado
		//Atualiza o valor total do produto no Formulario
		$("#total_produto").val(moedaUsaToBR(total_atualizado.toFixed(2)));
		$("#TotalProduto").text(moedaUsaToBR(total_atualizado.toFixed(2)));
		d.hide();
		//Atualiza o valor Total da Tabela Abaixo
		$("table thead tr td div#t_produto_table").html(moedaUsaToBR(total_atualizado.toFixed(2)));
		/*---------- FUNCAO PARA ATUALIZAR O VALOR TOTAL DO ORÇAMENTO ---------*/
		SomaTotal();
})


/* Add Serviço */
var total_servico = 0;
var total_final = 0;
var valor = 0 ;
var total_orcamento= 0;

var AddServico = function(){
	var stringMedida = "";
	var servico = $("#servico").val(); var servico_id = $("#servico_id").val();
	var qtd_servico = $("#qtd_servico").val(); var funcionario_id = $("#funcionario_id").val();
	var obs_item = $("#obs_item_servico").val();
	var obsProducao = $("#obs_producao").val(); var altura = $("#altura").val();
	var largura = $("#largura").val();
	
	var todosCheckboxes = $('#mudar_valor_colaborar').find(':checkbox');
	  
	  if(todosCheckboxes.is(":checked"))
		  valor_mudar = '1';
	  else
		  valor_mudar = '0';
									
	  if(valor_mudar == '1'){ 	
		  var valor_und = $("#valor_colaborador").val();
		  valor    = $("#valor_colaborador").val() * moedaBrToUsa(qtd_servico);	
	  
	  } else if(valor_mudar == '0'){	
		  var valor_und = $("#valor_normal").val();
		  valor = $("#valor_normal").val() * moedaBrToUsa(qtd_servico);
	  }
	  
	  if(  $.trim(altura) != "" && $.trim(largura) != "" )	
	  	stringMedida = "&altura="+altura+"&largura="+largura;
					
		var dados = "servico="+servico+"&servico_id="+servico_id+"&qtd="+qtd_servico+"&funcionario_id="+funcionario_id+"&valor="+valor_und+"&marcador="+valor_mudar+"&obsItem="+obs_item+stringMedida+"&obsProducao="+obsProducao;
					
  $.ajax({
	  url: 'modulos/ordem_servico/ordem_servico/tabela_item.php?acao=servico',
	  type: 'POST',
	  data: dados,
	  success: function(data, textStatus) {
		  if(data != 'error'){
			  $('#tbody_servico').append(data);
			  $("#servico").val('');
			  $("#funcionario").val('');
			  $("#valor_normal").val('');
			  $("#valor_colaborador").val('');
			  $("#obs_item_servico").val('');
			  $("#obs_producao").val('');
			  // pega os valores que ja estao no formulario
			  total_servico = moedaBrToUsa($("#total_servico").val())*1;		
			  total_servico += (valor)*1;
			  
			  // TOTAL PARA SERVIÇO
			  total_servico_format = moedaUsaToBR(total_servico.toFixed(2));
			  
			  $("#total_servico").val(total_servico_format);
			  $("#TotalServico").text(total_servico_format);
			  $("#total-servico").val(total_servico_format); 
			  
			  // TOTAL NO FINAL DA TABELA
			  $("table thead tr td div#t_servico_table").html(total_servico_format);		
			  // ATUALIZAR O VALOR TOTAL DO ORÇAMENTO
			  SomaTotal();
		  } else{
			  alert("Existe Campo Vazio!");	
		  }
	  },
  });//.ajax
	
	
}

$("#click_servico").live('click',function(){
	AddServico();					
});

$("#obs_item_servico,#obs_producao").live("keyup",function(event){
	var code = event.keyCode || event.which;
	var erro = 0;
	var msg = "";
	
	if( code == 13){
	
	  if( $.trim($("select#funcionario_id option:selected").val()) == "" ){
		  erro++;
		  msg += "Informe o técnico\n";	
	  }
	  if(erro > 0){
		  alert(msg);	
	  }
	  else{
	  	if( $.trim($("#servico_id").val()) !== "" )
			AddServico();
	  }
	}
	
});

var total_servico_form = 0;
$("#click_servico_excluir").live('click',function(){
		var d = $(this).parent().parent();
		var qtd_produto   = $(this).parent().parent().find("#array_qtd_servico").val();   // QTD Servico
		var valor_servico = $(this).parent().parent().find("#array_valor_servico").val(); // Valor Unitario
		var valor_total   = $(this).parent().parent().find("#v_total_servico").val();     // Valor Total Selecionado
		var valor_funcionario = $(this).parent().parent().find("#valor_tecnico").val();     // Valor Total Selecionado
		/*-- INSERE O VALOR NULO NO INPUT QUE FOI EXCLUIDO -*/
		$(this).parent().parent().find("#array_qtd_servico").val(0);   
		$(this).parent().parent().find("#array_valor_servico").val(0); 
		$(this).parent().parent().find("#v_total_servico").val(0);
		$(this).parent().parent().find("#valor_tecnico").val(0);
		$(this).parent().parent().find("#array_servico_id").val(0); 
		// Dados Secundarios
		$(this).parent().parent().find("#array_funcionario_id").val(0); 
		//$(this).parent().parent().find("#array_servico_id").val(0);
		// Recebe o valor total do forumlario
		total_servico_form = $("#total_servico").val();
		var total_atualizado  = (moedaBrToUsa(total_servico_form)*1) - (moedaBrToUsa(valor_total)*1);
		total_servico = total_atualizado; //Aqui o total geral do servico é atualizado
		//Atualiza o valor total do produto no formulario
		$("#total_servico").val(moedaUsaToBR(total_atualizado.toFixed(2)));
		$("#TotalServico").text(moedaUsaToBR(total_atualizado.toFixed(2)));
		d.hide();
		//Atualiza o valor da tabela abaixo
		$("table thead tr td div#t_servico_table").html(moedaUsaToBR(total_atualizado.toFixed(2)));
		/* ATUALIZAR O VALOR TOTAL DO ORÇAMENTO */			
		SomaTotal();
})
$("#edit_servicoExcluir").live('click',function(){
		var d = $(this).parent().parent();
		var val_TotalItem   = $(this).parent().parent().find("#v_total_servico").val();
		$(this).parent().parent().find("#edit_osID").val('0'); 
		// Recebe o valor total do forumlario
		total_ServicoForm = $("#total_servico").val();
		var total_atualizado  = (moedaBrToUsa(total_ServicoForm)*1) - (moedaBrToUsa(val_TotalItem)*1);
		total_servico = total_atualizado; //Aqui o total geral do servico é atualizado
		$("table thead tr td div#t_servico_table").html(moedaUsaToBR(total_atualizado.toFixed(2)));
		$("#total_servico").val(moedaUsaToBR(total_atualizado.toFixed(2)));
		$("#TotalServico").text(moedaUsaToBR(total_atualizado.toFixed(2)));
		d.hide();
		/* ATUALIZAR O VALOR TOTAL DO ORÇAMENTO */
		SomaTotal();	     
		
})
$("#servico").live('blur',function(){
		var und = $("#und_servico").val();
		$("#visual_und strong").html(und);
			if(und == 'm2'){
				var label = $('<label style="width:30px">Altura<input type="text" name="altura" id="altura" ></label><label style="width:30px">Largura<input type="text" name="largura" id="largura" ></label>');	
				$("#info_m2").html(label);
				$("#altura").focus();
			} else{
				$("#info_m2").html('');
			}
})
var result = 0;
$("#altura,#largura").live('blur',function(){
		var altura  = $("#altura").val();
		var largura = $("#largura").val();
		var valor_unit = $("#valor_unit").val()*1;	
			var result = (moedaBrToUsa(altura)) * (moedaBrToUsa(largura))*valor_unit; 
			$("#valor_normal").val(result.toFixed(2));
})
$(function(){
	$("#edit_obsItemServico").live('blur',function(){
		var id = $(this).parent().parent().attr('id');
		var obs = $(this).val();
		$.post('modulos/ordem_servico/ordem_servico/tabela_item.php?acao=upObsItem',{obs:obs,id:id})
	})
	
	$("#edit_obs_producao").live('blur',function(){
		var id = $(this).parent().parent().attr('id');
		var obs = $(this).val();
		$.post('modulos/ordem_servico/ordem_servico/tabela_item.php?acao=upObsProducao',{obs:obs,id:id})
	})	
})
/*-- SCRIPT PARA DESPESAS --*/
var valor_total_despesa = 0;
var total = 0;
var total_item = 0;
$("#click_despesas").live('click',function(){
	
				var descricao_despesas = $("#descricao_despesa").val();
				var qtd_despesas       = $("#qtd_despesa").val();
				var valor_despesa      = $("#valor_despesa").val();
				
				total_item = ((moedaBrToUsa(valor_despesa))*1)*qtd_despesas;
				total += total_item;
				
				if((descricao_despesas) != ''){
				var item_tr = $('<tr><td><input type="hidden" name="os_custo_id[]" id="os_custo_id" value=""> <input type="hidden" name="item_controle[]" id="item_controle" value="insert"><input type="text" style="height:13px;" id="desc_despesas" name="descricao_despesas_item[]" value="'+descricao_despesas+'"></td><td><input type="hidden" name="qtd_despesas_item[]" value="'+qtd_despesas+'" size="5">'+qtd_despesas+'</td><td><input type="hidden" name="valor_despesas_item[]" value="'+valor_despesa+'" size="5">'+(valor_despesa)+'</td><td><input type="hidden" name="total_item_despesa[]" id="total_item_despesa" value="'+moedaUsaToBR(total_item.toFixed(2))+'" size="5">'+moedaUsaToBR(total_item.toFixed(2))+'</td><td><img src="../fontes/img/menos.png" id="click_despesas_excluir"></td></tr>');
					//alert(item_tr);
					$("#item_despesas").append(item_tr);
					$("#item_despesas tr:even").css("background-color", "#fff");
					$("#item_despesas tr:odd").addClass('al');
					$("#valor_total_despesas").html(moedaUsaToBR(total.toFixed(2)));
					
					$("#descricao_despesa").val('');
					$("#qtd_despesa").val('1');
					$("#valor_despesa").val('');
				}
				
				Subtotal();
				//alert(descricao_despesas);
})
$("#click_despesas_excluir").live('click',function(){	
					var id = $(this).parent().parent();
					var valor = ($(this).parent().parent().find("#total_item_despesa").val());
					var total_atualizado = ( (total)*1 - (moedaBrToUsa(valor))*1 );
					total = total_atualizado;
					$("#valor_total_despesas").html(moedaUsaToBR(total_atualizado.toFixed(2)));
					id.remove();
					Subtotal();		
})
$("#excluir_edit_despesas").live('click',function(){
					
					var b = $(this).parent().parent();
					var totalFinal = $("#valor_total_despesas").text();
					var totalItem  = $(this).parent().parent().find("#total_itemDespesaEdit").val();
					
					$(this).parent().parent().find("#total_itemDespesaEdit").val(0);
					var TotalAtualizado = (moedaBrToUsa(totalFinal)) - (moedaBrToUsa(totalItem)*1); 
					$("#valor_total_despesas").text(moedaUsaToBR(TotalAtualizado.toFixed(2)));
					//Dernando
					//Adicionado para fazer cálculo de lucro(Total-Despesas)
					Subtotal();
					b.hide();	
})

/* SCRIPT PARA VALOR DO COLABORADOR */
$("#v_colaborar").live('click',function(){
		
			var todosCheckboxes = $('#mudar_valor_colaborar').find(':checkbox');
			if(todosCheckboxes.is(":checked")){
				valor_mudar = '1';	
			} else{
				valor_mudar = '0';
			}
			if(valor_mudar == '1'){
				$("#valor_colaborador").removeAttr('disabled');
			} else if(valor_mudar == '0'){
				$("#valor_colaborador").attr('disabled','disabled');
			}
});

/* Eventos */
 
$("#desconto-produto").live("blur",function(){ // Desconto Produto blur
	if( $.trim($(this).val()) == "" ){
		$("#desconto-produto-porcent").val("");
	}
	SomaTotalProdutos();	
});
$("#desconto-produto").live('keyup',function(event){ // Desconto Produto
	var code = event.keyCode || event.which;
	  
	  if(code != '9'  ){
		  var desconto = moedaBrToUsa($(this).val()) * 1;
		  var totalProduto = moedaBrToUsa($("#total_produto").val())*1;
		  var result = (desconto / totalProduto)*100;
		  $("#desconto-produto-porcent").val(moedaUsaToBR(result.toFixed(1)));					
		  SomaTotalProdutos();
	  } else{ return false;} 
});
$("#desconto-produto-porcent").live('keyup',function(event){ // Desconto porcentagem produto
	  var code = event.keyCode || event.which;
	  	
	  if(code != '9'){
		  var valPorcentagem = moedaBrToUsa($(this).val())*1;
		  var valSubtotal = moedaBrToUsa($("#total_produto").val())*1;
		  var result = (valPorcentagem / 100) * valSubtotal;
		  $("#desconto-produto").val((moedaUsaToBR(result.toFixed(2))));
		  SomaTotalProdutos();	
	  }else{ return false;}
});
$("#acrescimo-produto").live("blur",function(){
	SomaTotalProdutos();
});


$("#desconto").live('keyup',function(event){ //Desconto Serviço
	var code = event.keyCode || event.which;

	  if(code != '9'  ){
		  var desconto = moedaBrToUsa($(this).val()) * 1;
		  var total = moedaBrToUsa($("#total_servico").val())*1;
		  var result = (desconto / total)*100;
		  $("#descontoPorcentagem").val(moedaUsaToBR(result.toFixed(1)));					
		  SomaTotalServicos();
	  } else{ return false;} 
});
$("#descontoPorcentagem").live('keyup',function(event){ //Desconto porcentagem serviço
	  var code = event.keyCode || event.which;
	  	
	  if(code != '9'){
		  var valPorcentagem = moedaBrToUsa($(this).val())*1;
		  var total = moedaBrToUsa($("#total_servico").val())*1;
		  var result = (valPorcentagem / 100) * total;
		  $("#desconto").val((moedaUsaToBR(result.toFixed(2))));
		  SomaTotalServicos();	
	  }else{ return false;}
});
$("#acrescimo").live("blur",function(){
	SomaTotalServicos();
});


$("#desconto-produto,#desconto-produto-porcent,#acrescimo-produto").live('blur',function(){ 
  TotalGeral();
});
$("#desconto,#descontoPorcentagem,#acrescimo").live('blur',function(){
  TotalGeral();
});


function SomaTotal(){  // ATUALIZAR O VALOR TOTAL DO ORÇAMENTO 			
	 
	  var acrescimo     = moedaBrToUsa($("#acrescimo").val())*1;
	  var desconto      = moedaBrToUsa($("#desconto").val())*1;
	  var total_produto = moedaBrToUsa($("#total_produto").val())*1;
	  var total_servico = moedaBrToUsa($("#total_servico").val())*1;
	  var total = ((total_produto + total_servico + acrescimo) - (desconto));					
	  
	  //Subtotal
	  $("#subtotalView").val(moedaUsaToBR(total.toFixed(2)));
	  $("#subtotal").val(moedaUsaToBR(total.toFixed(2)));
	  //Total
	  $("#ostotalView").val(moedaUsaToBR(total.toFixed(2)));
	  $("#ostotal").val(moedaUsaToBR(total.toFixed(2)));
}

function Lucro(){
	var total = moedaBrToUsa($("#ostotal").val())*1;
	var total_despesas = moedaBrToUsa($("#valor_total_despesas").text())*1;
	lucro = total - total_despesas;
	$("#lucro").html(moedaUsaToBR(lucro.toFixed(2)));
}

$("select#garantia").live('change',function(){ //SCRIPT PARA DESATIVAR GARANTIA 
  var garantia = $(this).val();
	  if(garantia == '1'){
		  $("#data_final_garantia").attr('disabled','disabled');
		  $("#data_final_garantia").css('background','#E8E8E8');
	  } else{
		  $("#data_final_garantia").removeAttr('disabled');
		  $("#data_final_garantia").css('background','#FFFFFF');
	  }
				
})
<!-- script para aprovaçao de ordem de serviço -->
$("#aprovar").live('click',function(){
		$("#data_aprovacao").removeAttr('disabled','disabled');
		$("#data_execucao").removeAttr('disabled','disabled');
		//$("#aprovar").attr('disabled','disabled');
		$("#salvar").hide();
		var finaliza = $('<input type="submit" name="action" id="finalAprova" value="Aprovar">');
		$("#info_aprovacao").html(finaliza);		
})
$("#finalAprova").live('click',function(){
			if($("#orcado").is(":not(:checked)")){
				alert('A O.S nao foi orcada');
				return false;	
			} else{
				return true;	
			}
})
$("#orcado").live('change',function(){
			if($(this).is(':checked')){
				$("#AprID").show();
			} else{
				$("#AprID").hide();
			}
			
			
})
$("#salvar").live('click',function(){
		
	if($("#aprSim").is(":checked")){
	  $("#data_aprovacao").removeAttr('disabled','disabled');
	  $("#data_execucao").removeAttr('disabled','disabled');
	  aba_form(this,5);
	  $("#salvar").hide();
	  var finaliza = $('<input type="hidden" name="ApAndSalve" value="1"><input type="submit" name="action" value="Salvar">');
	  $("#info_aprovacao").html(finaliza);
	  return false;		
	}
		
	return true;		
});
<!-- Cancelar O.S -->
$("#cancelamento").live('click',function(){
		aba_form(this,6);
		$("#salvar").css('display','none');
		var cancelar = $('<input type="submit" name="action" value="Cancelar">');
		$("#info_aprovacao").html(cancelar);
})
<!-- Pagamento O.S -->
$("#pagamento").live('click',function(){
		aba_form(this,8);
		$("#salvar").hide();
		$("#entregaID").show();
		$("#executadoID").show();
		$("#executado").removeAttr('disabled','disabled');
		$("#ContaID").attr('valida_minlength','1');
		var pagar = $('<input type="submit" name="action" disabled="disabled" id="pagar" value="Enviar ao Financeiro">');					  
		$("#info_aprovacao").html(pagar);
		$("#fimFieldset").append(entrega);	
});//

$("#ExInfoPg").live('click',function(){
	aba_form(this,8);
})
$("#pagar").live('click',function(){
						
		  if($("#executado").is(":not(:checked)")) {
			  alert('Atençao! O Servico ainda nao foi executado');
			  return false;	
		  }
		  else{
			  if($('#forEntrega').is(':checked')){
					  aba_form(this,9);
					  var finalizar = $('<input type="submit" name="action" id="finalizar" value="Finalizar">');
					  $("#entregaID").show();	
					  $("#info_aprovacao").html(finalizar);				
			  } else{
					  return true;	
			  }
		  }
	return false;
})
$("#entrega").live('click',function(){
	  $("#salvar").hide();
	  aba_form(this,9);
	  var finalizar = $('<input type="hidden" name="entrega" value="1"><input type="submit" name="action" id="finalizar" value="Finalizar">');
	  $("#entregaID").hide();	
	  $("#info_aprovacao").html(finalizar);
})
$("select#status_os").live('change',function(){
		var status = $(this).val();
				if(status == '2'){
					$("#data_entrega").removeAttr('disabled','disabled');
				} else{
					$("#data_entrega").attr('disabled','disabled');
				}
})
$("#marcado_edit_servico").live('click',function(){
	var id = $(this).parent().parent().attr('id');
	var checkbox = $(this).parent().parent().find(':checkbox');
		 
			if(checkbox.is(":checked"))	
				$(this).parent().parent().find('#check_edit_servico').val('1');	
			else
				$(this).parent().parent().find('#check_edit_servico').val('2');
})
$("#marcado_cad_servico").live('click',function(){
						var id_c = $(this).parent().parent().attr('id');
						var checkbox_c = $(this).parent().parent().find(':checkbox#marcado_cad_servico');
								if(checkbox_c.is(":checked"))	
									$(this).parent().parent().find('#check_cad_servico').val('1');	
								else
									$(this).parent().parent().find('#check_cad_servico').val('2');
})
/*
 * SCRIPT PARA FORMA DE PAGAMENTO E PARCELAS 
 */
var dias = 0;



$("select#parcelas").live('change',function(){
			
		var qtd = $(this).val();
		var dataHoje = $("#data_hoje").val();
			
	if($(this).val() > '0'){
					
		$("#pagar").removeAttr('disabled','disabled');
		var id  = $("#numero_sequencia_empresa").val();
		$("#titulo_parcela").css('display','block');
		$("#info_parcela").css('display','block');
		$("#info_parcela").html('');
		
		var total_orcamento = moedaBrToUsa($("#ostotal").val());
		var result = (total_orcamento/qtd);
				
		$("#info_parcela_1").html('<label>Primeira Parcela<br/><input type="text" name="parcela_1" id="parcela_1" size="8"  mascara="__/__/____"></label><div style="clear:both;"></div>');
		
		dias = 0;
		
		var $campo_parcela = "";
			
		  for(i = 0; i < qtd; i++){	
			  
			  $.post(urlAjaxOs,{funcao:"formaPagamento"},function(data){
				  
					 var j = i+1;		
					 var dmy = dataHoje.split("/");
					 var joindate = new Date(parseInt(dmy[2], 10),parseInt(dmy[1], 10) - 1,parseInt(dmy[0], 10));
					 joindate.setDate(joindate.getDate() + dias);
					 var selectOption = "";
					 var dataVencimento = ("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear(); 
					 
					 selectOption += '<label style="width:120px;"> Forma de Pagamento <select name="forma_pagamento_parcela[]" id="forma_pagamento_parcela">';		 
					 $.each(data,function(i,item){
						 selectOption +='<option value="'+item.id+'">'+item.nome+'</option>';
					 }); 
					 selectOption += "</select></label>";	
				  
					  $campo_parcela += ''+
					  '<div id="form_parcelas">'+
						  '<div style="clear:both;"></div>'+
						  '<label>Descri&ccedil;&atilde;o Parcela<br>'+
						  '<input type="text" name="descricao_parcela[]" id="descricao_parcela" value="Parcela '+j+' O.S N&ordm; '+id+' "></label>'+
						  '<label>Data Vencimento<br/>'+
						  '<input size="9" type="text" name="data_vencimento_parcela[]" calendario="1" id="data_vencimento_parcela'+j+'" value="'+dataVencimento+'"></label>'+
						  '<label>Valor Parcela<br>'+
							  '<input type="text" name="valor_parcela[]" decimal="2" sonumero="1" id="valor_parcela" style="text-align:left;" size="8" value='+moedaUsaToBR(result.toFixed(2))+'>'+
						  '</label>'+
						  selectOption+
					   '</div>';	
							  
			  $("#info_parcela").html($campo_parcela);
			  dias += 30;
			  
			  var EfetivarMovientacao = '<br/><button type="button" id="realizar-pagamento">Realizar pagamento</button>';
			  $("#info_parcela #form_parcelas:first").append(EfetivarMovientacao);			
								  
			  },'json');
			  
		   }/* fim for */
				
				
		} else{
			
			$("#pagar").attr('disabled','disabled');
			$("#titulo_parcela").css('display','none');	
			$("#info_parcela_1").html('');
			$("#info_parcela").css('display','none');
		
		}
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
				  //alert(("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear());
				  $("#data_vencimento_parcela"+h).val(("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear());							
				  dias += 30;	
				  
	  }	
  }
			
});

/*- SCRIPT PARA ABA ENVIO DE EMAIL -*/
function validaEmail(email){
	er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
    if(er.exec(email))
        return true;
    else
        return false;
}

$("#enviar_orcamento").live('click',function(){
		if($.trim($("#emailDestino").val()) != ""){
					var osID = $("#id").val();
					var email = $("#emailDestino").val();
					var msg   = $("#msg").val();
					var result = validaEmail(email);
						if(result == true){
								var iconCarregando = $('<p>Carregando...</p>');
								var dados = "id="+osID+"&emailDestino="+email+"&msg="+msg;
								$.ajax({
									type:'POST',
									url:'modulos/ordem_servico/ordem_servico/enviaEmail.php',
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
});

$("#imp_os").live('click',function(){
	var id              = $("#id").val();
	window.open('modulos/ordem_servico/ordem_servico/rel_os.php?id='+id,'_BLANK');
});

$("#imp_ordem_producao").live('click',function(){
	var id              = $("#id").val();
	window.open('modulos/ordem_servico/ordem_servico/impressao_ordem_producao.php?id='+id,'_BLANK');
});

$(".array_servico_valor").live('blur',function(){
	
	var valor       = moedaBrToUsa($(this).val())*1;
	var qtd_servico = $(this).parent().parent().find('.array_servico_qtd').val()*1; 
	
	novo_valor = moedaUsaToBR(valor * qtd_servico);
	novo_valor = novo_valor;
	
	$(this).parent().parent().find('.total_servico_item').text('');
	$(this).parent().parent().find('#v_total_servico').val(novo_valor);
	$(this).parent().parent().find('.total_servico_item').text(novo_valor);	
	
	valor_total =0;
	$(this).parent().parent().parent().find('.total_servico_item').each(function(){
		valor_total += (moedaBrToUsa($(this).html()))*1;
	})
	
	valor_total=moedaUsaToBR(valor_total.toFixed(2));
	$('#TotalServico').html('');
	$('#TotalServico').html(valor_total);
	$('#t_servico_table').html('');
	$('#t_servico_table').html(valor_total);
	$('#total_servico').val('');
	$('#total_servico').val(valor_total);
	Subtotal();
	SomaTotal();
});

var total_parcela_pagamento = 0;
var diferenca = 0;
$("#valor_parcela").live("keyup",function(){
	var total_parcela_pagamento = 0;
	var diferenca = 0;
	
	$("div#form_parcelas #valor_parcela").each(function(index, element) {
        total_parcela_pagamento += moedaBrToUsa(element.value)*1;
    });
	
	diferenca = moedaBrToUsa($("#total_da_os").val())*1 - (total_parcela_pagamento)*1;

	$("#total_parcela_forma_pagamento").html(moedaUsaToBR(total_parcela_pagamento.toFixed(2)));
	$("#total_parcela_diferenca").html(moedaUsaToBR(diferenca.toFixed(2)));
	
	if( (moedaUsaToBR(total_parcela_pagamento.toFixed(2)))  !==  ($("#total_da_os").val()) ){
		$("#pagar").hide();
		$("#realizar-pagamento").hide();	
	} else {
	    $("#pagar").show();
		$("#realizar-pagamento").show();
	}
		
});

/*Pagamento 1 percela*/

$("#realizar-pagamento").live("click",function(){
	
	if($("#executado").is(":checked")){
	  var $parcela = $(this).closest("div#form_parcelas");
	  var $container = $parcela.closest("div.container-pagamento");
	  var btnFinanceiro = "<input type='hidden' name='action' value='enviar-financeiro'><button type='submit' id='enviar-financeiro'> Enviar para Financeiro </button>";
	  
	  var obj = {
		  funcao:"RealizaPagamento",
		  cliente_id:$("#cliente_id").val(),
		  conta_id:$("select#conta_id option:selected").val(),
		  centro_custo_id:$("select#centro_custo_id option:selected").val(),
		  plano_de_conta_id:$("select#plano_de_conta_id option:selected").val(),
		  os_id:$("#id").val(),
		  executado:$("#executado").val(),
		  dataExecucao:$("#data_execucao").val(),
		  descricao:$parcela.find("#descricao_parcela").val(),
		  dataVencimento:$parcela.find("input[name='data_vencimento_parcela[]']").val(),
		  FormaPagamento:$parcela.find("select#forma_pagamento_parcela option:selected").val(),
		  ValorParcela:$parcela.find("input[name='valor_parcela[]']").val()
	  };
	  	
	  $.ajax({
	  	type:"POST",
		url:urlAjaxOs,
		data:obj
	  }).done(function(data){
		  $("#executado").attr('disabled','disabled');
		  $("#data_execucao").attr('disabled','disabled');
		  $parcela.html("<div class='pane-item-pago'><p>1 Parcela foi pago com sucesso!</p></div>");
		  console.log(data);
	  });
		
	} else {
		alert("O serviço ainda não foi executado! ");
		return false;	
	}
	
	
});

