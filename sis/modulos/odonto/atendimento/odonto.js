$(function(){
	$("#tabela_dados tr:odd").css("background-color", "#F1F5FA");
	$(".doenca:even").css("background-color", "#F1F5FA");
	
	
	
	$("legend a, legend strong").live('click',function(){
		if($(this).text()=='Consulta'){
			$("#concluir_consulta").show();
			atualizaProcedimentosAprovados()
		}else{
			$("#concluir_consulta").hide();
		}
	})
});


// JavaScript Document
$(".chamaExames").live("click",function(){
	var id  = $("#atendimento_id").val();
	var aba = $(this).text();
	//alert(aba);
	//$("#formulario_atendimento").css("display","none");
	$("#formulario_atendimento").hide();
	$("#divformexame").load('modulos/odonto/atendimento/form_exame.php?id='+id+'&aba='+aba);	
});

$(".chamaAuxiliares").live("click",function(){
	var id  = $("#id").val();
	var aba = $(this).attr('title');
	window.open('modulos/odonto/atendimento/form.php?atendimento_id='+id+'&aba='+aba,'carregador')	
});


$("#add_receituario").live("click",function(){
	html_to_form('ed_receituario','tx_receituario');
	var texto_receituario = $('#tx_receituario').val();
	var data_receituario  = $('#data_receituario').val();
	var atendimento_id    = $('#atendimento_id').val();
	var cliente_id        = $('#cliente_id').val();
	var cliente           = $('#cliente_razao_social').val();
	
	var dados = "texto_receituario="+texto_receituario+"&data_receituario="+data_receituario+"&atendimento_id="+atendimento_id+"&cliente_id="+cliente_id+"&cliente="+cliente+"&acao=add";
														
	$.ajax({
				url: 'modulos/odonto/atendimento/funcoes_receituario.php',
					type: 'POST',
					data: dados,
					success: function(data) {
								/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
																			
				var id_receituario = data;
								
				//$("#dados_receituario").append("<tr id_receituario="+id_receituario+"><td style='width:90px;'><img src='../fontes/img/menos.png' id='remove_receituario'>"+data_receituario+"</td><td style='width:210px;'>"+cliente+"</td><td style='width:30px;' align='center'><img src='modulos/odonto/atendimento/img/Printer-icon.png' class='print_receituario'/></td></tr>");
					$("#dados_receituario").append("<tr id_receituario="+id_receituario+"><td style='width:90px;'><img src='../fontes/img/menos.png' id='remove_receituario'>"+$("#informdata").attr('data')+"</td><td style='width:550px;'>"+cliente+"</td><td align='center'><button type='button' class='print_receituario' style='margin-top:2px;'  title='Imprime este receituario'><img src='../fontes/img/imprimir.png'/></button></td></tr>");
				$('#nome_receituario').val('');
				$('#texto_receituario').val('');
				$('#ed_receituario').val('');
				$('#data_receituario').val($("#informdata").attr('data'));
				},
			});		
});

$(".print_receituario").live("click",function(){
	var id = $(this).parent().parent().attr('id_receituario');
	window.open('modulos/odonto/atendimento/impressao_receituario.php?receituario_id='+id);
});

$("#remove_receituario").live("click",function(){
	
	var id = $(this).parent().parent().attr('id_receituario');
	var dados = "id="+id+"&acao=remove";
	//alert(id);													
	$.ajax({
				url: 'modulos/odonto/atendimento/funcoes_receituario.php',
					type: 'POST',
					data: dados,
					success: function(data) {
								/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
																					
					
				},
			});
	$(this).parent().parent().remove();		
});
/*------------------Fim Script para Receituário------------------------*/
/*------------------Script para Atestado------------------------*/
$("#add_atestado").live("click",function(){
		
	var cid                  = $('#cid').val();
	var data_atestado        = $('#data_atestado').val();
	
	var hora_inicio_atestado = $('#hora_inicio_atestado').val();
	var hora_fim_atestado    = $('#hora_fim_atestado').val();
	var dias_afastamento     = $('#dias_afastamento').val();
	var atendimento_id    = $('#atendimento_id').val();
	var cliente_id           = $('#cliente_id').val();
	var cliente              = $('#cliente_razao_social').val();
	var registros			 = $("#lista_atestados tr").length;
	var dados = "cid="+cid+"&data_atestado="+data_atestado+"&hora_inicio="+hora_inicio_atestado+"&hora_fim="+hora_fim_atestado+"&dias_afastamento="+dias_afastamento+"&acao=add&atendimento_id="+atendimento_id+"&cliente_id="+cliente_id;
													
	$.ajax({
				url: 'modulos/odonto/atendimento/funcoes_atestado.php',
					type: 'POST',
					data: dados,
					success: function(data) {
								/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
				//alert(data);															
				var id_atestado = data;
				//alert(data);
				
				if(registros%2==0){c='al'}else{c=''}
				$("#dados_atestado").append("<tr class='"+c+"' id_atestado="+id_atestado+"><td style='width:90px;'>"+$("#informdata").attr('data')+"</td><td style='width:450px;'>"+cliente+"</td><td style='width:30px;'>"+dias_afastamento+"</td><td align='center'><button type='button' class='print_atestado' style='margin-top:2px;'  title='Imprime este atestado'><img height='12' src='../fontes/img/imprimir.png'/></button></td><td align='center'><img src='../fontes/img/menos.png' id='remove_atestado'></td></tr>");
				$('#cid').val('');
				$('#data_atestado').val($("#informdata").attr('data'));
				$('#hora_inicio_atestado').val('');
				$('#hora_fim_atestado').val('');
				$('#dias_afastamento').val('');
				},
		});		
});

$(".print_atestado").live("click",function(){
	var id = $(this).parent().parent().attr('id_atestado');
	window.open('modulos/odonto/atendimento/impressao_atestado.php?id='+id);
});

$("#remove_atestado").live("click",function(){
	
	var id = $(this).parent().parent().attr('id_atestado');
	var dados = "id="+id+"&acao=remove";
	//alert(id);													
	$.ajax({
		url: 'modulos/odonto/atendimento/funcoes_atestado.php',
			type: 'POST',
			data: dados,
			success: function(data) {
						/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
																			
			
		},
	});
	$(this).parent().parent().remove();		
});
/*------------------Script para Exame------------------------*/
$("#add_exame").live("click",function(){
	var data_exame        = $("#data_exame").val();
	//var id_exame          = $("#proximo_exame").val()*1;
	var atendimento_id    = $('#id').val();
	var cliente_id        = $('#cliente_id').val();
	var cliente           = $('#cliente_razao_social').val();
	var linhas			  = $("#lista_exames tr").length;
	//codigo para adicionar imagem sem dar refresh
	$("#action_aba").val('Incluir Exame');
	$('#formulario_atendimento').submit();
	$("#action_aba").val('');
	$('#obs_exame').val('');
	$("#data_exame").val($("#informdata").attr('data'));
	$('#imagem').val('');
	if(linhas%2==0){c = 'al' }else{c=''}
	$("#dados_exames").append("<tr class='"+c+"'><td style='width:45px;'>"+data_exame+"</td><td style='width:310px;'>"+cliente+"</td><td style='width:15px;' align='center'> <button type='button' class='download_exame' style='margin-top:2px;'  title='Faz download deste exame'>Baixar</button></td><td style='width:15px;'><img src='../fontes/img/menos.png' id='remove_exame'></td></tr>");														
	var proximo_exame = id_exame + 1;
	$('#proximo_exame').val(proximo_exame);
});

$("#remove_exame").live("click",function(){
	
	var id = $(this).parent().parent().attr('id_exame');
	
	var dados = "id="+id+"&action=Remove Exame";
	//alert(id);													
	$.ajax({
		url: 'modulos/odonto/atendimento/atendimento.php',
			type: 'POST',
			data: dados,
			success: function(data) {
						/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
				//alert(data);															
			
		},
	});
	$(this).parent().parent().remove();		
});
$('.download_exame').live('click',function(){
	var id =  $(this).parent().parent().attr('id_exame');
	//alert(id);
	window.open("modulos/odonto/atendimento/exame_download.php?exame_id="+id,"carregador");
});	

$(".chama_atendimento").live("click",function(){
	var id  = $("#id").val();
	var aba = $(this).text();
	//alert(aba);
	$("#divformexame").html('');
	$("#formulario_atendimento").css("display","block");	
});

$('.remover_foto').live('click',function(){
			
		$('.div_foto_cliente').css('display','none');
		$('#action_aba').val("RemoverFoto");
		$("#formulario_atendimento").submit();

		
	});
	
$("#modelo_id").live("change",function(){
	//alert(numparcelas);	
	var modelo_id = $(this).val();
		
	var dados = "modelo_id="+modelo_id+"&acao=busca_modelo";
														
	$.ajax({
		url: 'modulos/odonto/contrato/busca_modelo.php',
		type: 'POST',
		data: dados,
		success: function(data) {
		
			document.getElementById("ed_contrato").contentWindow.document.body.innerHTML = data;
		
		},
	});	
					
	
});

$(".editar_contrato").live('click',function(){
	var id =  $(this).parent().parent().attr('id_contrato');
		
	var dados = "modelo_id="+id+"&acao=busca_contrato";
														
	$.ajax({
		url: 'modulos/odonto/contrato/busca_modelo.php',
		type: 'POST',
		data: dados,
		success: function(data) {
		
			$("#form_contrato").html('');
			$("#form_contrato").html(data);
			//alert(data);
		},
	});	
	//document.getElementById("ed").contentWindow.document.designMode='on';
	//$("#form_contrato").html('');
});

function rteInsertHTML(html,ed) {
	 rteName = ed;
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
function ti(m,v,ed){
	w= document.getElementById(ed).contentWindow.document
	if(m=='InsertHTML' ){
		rteInsertHTML(v,ed);
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

function html_to_form(ed_frame,tx_html){
	
		
		document.getElementById(tx_html).value = document.getElementById(ed_frame).contentWindow.document.body.innerHTML
		
		document.getElementById(ed_frame).contentWindow.document.body.innerHTML.replace("\n","");
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




function insertValueQuery() {
    var myQuery = document.sqlform.sql_query;
    var myListBox = document.sqlform.dummy;

    if(myListBox.options.length > 0) {
        sql_box_locked = true;
        var chaineAj = "";
        var NbSelect = 0;
        for(var i=0; i<myListBox.options.length; i++) {
            if (myListBox.options[i].selected){
                NbSelect++;
                if (NbSelect > 1)
                    chaineAj += ", ";
                chaineAj += myListBox.options[i].value;
            }
        }

        //IE support
        if (document.selection) {
            myQuery.focus();
            sel = document.selection.createRange();
            sel.text = chaineAj;
            document.sqlform.insert.focus();
        }
        //MOZILLA/NETSCAPE support
        else if (document.sqlform.sql_query.selectionStart || document.sqlform.sql_query.selectionStart == "0") {
            var startPos = document.sqlform.sql_query.selectionStart;
            var endPos = document.sqlform.sql_query.selectionEnd;
            var chaineSql = document.sqlform.sql_query.value;

            myQuery.value = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
        } else {
            myQuery.value += chaineAj;
        }
        sql_box_locked = false;
    }
}


$(".print_contrato").live("click",function(){
	
	var id = $(this).parent().parent().attr("id_contrato");
	window.open("modulos/odonto/contrato/impressao_contrato.php?id="+id);
});

$("#salvar_contrato").live('click',function(){
	var cliente      = $("#cliente_razao_social").val();
	var descricao = $("#nome").val();
	var modelo_contrato_id = $("#modelo_id").val();
	var contrato_id = $("#contrato_id").val();
	
	if(descricao==''||(!modelo_contrato_id>0)){
		alert('Selecione um contrato e preencha o campo descriçao!');
	}else{
		html_to_form('ed_contrato','tx_contrato'); 
		setTimeout("document.getElementById('formulario_atendimento').submit()",500);
		
		alert("Contrato Salvo Com Sucesso!");
		if(!contrato_id>0){
			$("#dados_contratos tbody").append("<tr id_contrato=''><td style='width:200px;'>"+cliente+"</td><td style='width:400px;'>"+descricao+"</td><td style='width:60px;' align='center'><button type='button' class='print_contrato' style='margin-top:2px; '  title='Imprime este contrato'><img src='../fontes/img/imprimir.png' /></button></td>  <td align='center'><button type='button' class='editar_contrato' style='margin-top:2px; '  title='Edita este contrato'><img src='modulos/odonto/atendimento/img/edit.png' height='17'/></button></td></tr>");
			$("#modelo_id").val('');
			$("#contrato_id").val('');
			$("#nome").val('');
			document.getElementById("ed_contrato").contentWindow.document.body.innerHTML = '';
		}
	}
	
});

$("#novo_contrato").live('click',function(){
	$("#modelo_id").val('');
	$("#nome").val('');
	 document.getElementById("ed_contrato").contentWindow.document.body.innerHTML = ''
	 $("#contrato_id").val('');
	 $(this).css('display','none');
	 $("#cancelar_edicao_contrato").css('display','none');
	 $("#salvar_contrato").css('float','right');
});

$("#cancelar_edicao_contrato").live('click',function(){
	var id =  $("#contrato_id").val();
	
	var dados = "modelo_id="+id+"&acao=inativa_contrato";
														
	$.ajax({
		url: 'modulos/odonto/contrato/busca_modelo.php',
		type: 'POST',
		data: dados,
		success: function(data) {
		
			$("#modelo_id").val('');
			$("#nome").val('');
	 		document.getElementById("ed_contrato").contentWindow.document.body.innerHTML = ''
	 		$("#contrato_id").val('');
	 		$("#novo_contrato").css('display','none');
	 		$("#cancelar_edicao_contrato").css('display','none');
	 		$("#salvar_contrato").css('float','right');
		},
	});	
	$("#dados_contratos tbody tr").each(function() {
        if($(this).attr('id_contrato')==id){
			$(this).remove();
		}
    });
});

$(".impressao").live('click',function(){
	var texto = $(this).val();
	var id     = $("#id").val();
	
	if(texto=='Imprimir Ficha Cadastral'){
		window.open('modulos/odonto/atendimento/impressao_ficha_cadastral.php?atendimento_id='+id);
	}
	if(texto=='Imprimir Anamnese'){
		window.open('modulos/odonto/atendimento/impressao_anamnese.php?atendimento_id='+id);
	}
	if(texto=='Imprimir Análise'){
		window.open('modulos/odonto/atendimento/impressao_orcamento.php?atendimento_id='+id);
	}
	if(texto=='Imprimir Procedimentos'){
		window.open('modulos/odonto/atendimento/impressao_procedimentos.php?atendimento_id='+id);
	}
});

function habilitaBotaoImpressao(impressao){
	$(".impressao").css("display","none");
	
	if(impressao=='anamnese'){
		
		$("#imprimir_anamnese").css("display","block");
	}
	if(impressao=='fichacadastral'){
		$("#imprimir_ficha_cadastral").css("display","block");
	}
	if(impressao=='analise'){
		$("#imprimir_analise").css("display","block");
		$("#imprimir_procedimento").css("display","block");
	}
}
