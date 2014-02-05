

function setCookie(c_name,value,exdays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function fechar_modal(centro,plano){
	if(centro){
	var array_centro = centro.split(":");
	var array_plano  = plano.split(":"); 
	
	var p = $.trim(array_plano[1]);
	var c = $.trim(array_centro[1]);
	
	if(p == "block;" )
		$(" label #plano_conta").focus();
	 if (c == "block;" )
		$(" label #centro_custo").focus();
	
	}
	$("#janela_centro_custo").hide("slow");
	$("#janela_plano_contas").hide("slow");
}

/* Teclas de atalho para teclado */
	
var pressedCtrl = false;
var pressedCommand = false; 

$(document).keyup(function (e) {
	if(e.which == 17)
		pressedCtrl=false;
	if(e.which == 224)
		pressedCommand=false;
});

$(document).keydown(function (event) {
	var conta_id = $("#conta_id").val(); 
	
	if(event.which == 17) 
	  pressedCtrl = true;
	 if(event.which == 224)
		pressedCommand=true;
		 
	  if(event.which == 27){
		var centro = $("#janela_centro_custo").attr("style");
		var plano  = $("#janela_plano_contas").attr("style");
		fechar_modal(centro,plano);	
	  }
	
	if( (event.which == 78 && pressedCtrl == true) || (event.which == 78 && pressedCommand == true) ){
		event.preventDefault();
		window.open('modulos/financeiro/form_movimentacao.php?conta_id='+conta_id,'carregador');
	} 	
	
});


$("#pagar").live("click",function(){
	if($(this).is(":checked")){
		$("#valor_cadastro").css("background","pink");	
	}
});
$("#receber").live("click",function(){
	if($(this).is(":checked")){
		$("#valor_cadastro").css("background","#BAE7BE");	
	}
});

/* Funções inseridas Jaime */
  /*function insere_campo_planos( plano_id, descricao, modal, insercao){
	  
	  var array_plano = Array();
	  
	  $("label #plano_de_conta_id").each(function(index, element) {
		array_plano[index] = element.value;
      });
	  
	  var indice = $.inArray(plano_id, array_plano);
	  
	  if(indice == -1){
		$("#"+insercao+" #plano_conta").val(descricao);
		setCookie('plano_de_contas',descricao,30);
		setCookie('plano_de_contas_id',plano_id,30);

	  	$("#"+insercao+" label#array_plano_id").html( '<input type="text" name="plano_de_conta_id[]" id="plano_de_conta_id" style="width:80px;" value="'+plano_id+'">');
	  	$("#"+modal+"").hide("slow");
	  } else { 
		$("#janela_plano_contas #result-modal").html(" <div class='badge-default badge-important'>Você já selecionou esse Plano </div>");
	  }
	  	
  } /* fim da função */

  /*function insere_centro_custo( centro_id, descricao, modal, insercao){
	  
	  var array_centro = Array();
	  
	  $("label #centro_custo_id").each(function(index, element) {
		array_centro[index] = element.value;
      });
	  
	  var indice = $.inArray(centro_id, array_centro);
	  
	  if(indice == -1){
		$("#"+insercao+" #centro_custo").val(descricao);
		setCookie('centro_custo',descricao,30);
		setCookie('centro_custo_id',centro_id,30);
		
	    $("#"+insercao+" label#array_centro_id").html( '<input type="text" name="centro_custo_id[]" id="centro_custo_id"  style="width:80px;" value="'+centro_id+'">');
	    $("#"+modal+"").hide("slow");		
	  } else {
		$("#janela_centro_custo #result-modal").html(" <div class='badge-default badge-important'>Você já selecionou esse Centro </div>");
	  }  
  }*/
  
/* Funções */
function addPlc(t){
	
	if(t.innerHTML == '+'){
		
		div_subplano = document.createElement("div");// cria uma div
		div_subplano.setAttribute('style',t.parentNode.getAttribute('style'));
		div_subplano.setAttribute('class',t.parentNode.getAttribute('class'));
		div_subplano.setAttribute('id',t.parentNode.getAttribute('id'));
		
		var div_current = t.parentNode;
		
		/*-------*/
		id = t.parentNode.getAttribute('id');
		
		var array_id = id.split("_");
		
		var novoid = parseInt(array_id[1]) + 1;
		var gera_id = array_id[0]+"_"+novoid;
		
		div_subplano.setAttribute('id',gera_id);
		div_subplano.setAttribute('novoid',novoid);
		
		div_subplano.innerHTML= t.parentNode.innerHTML;

		insertAfter(div_subplano,t.parentNode);
		$(div_subplano).find("button").html("-");
		
		novo_select = $(div_subplano).find("select:first");
		
		// mudar id
		nome_novo_id = novo_select.attr('id')+novoid;
		novo_select.attr('id',nome_novo_id);
		$(div_subplano).find(".select2-container").remove();
		 
		$("#"+nome_novo_id).select2({
			placeholder: "Selecione plano de contas",
			formatResult: top.format,
			allowClear: true
		});
		
		var textEdit = $("#"+nome_novo_id).select2('data').text; //pega o texto selecionado
		var idEdit = $("#"+nome_novo_id).select2('data').id; //pega o ID selecionado
		var valEdit = top.format_text(textEdit);
		
		
		$("#"+nome_novo_id).select2("data",{id:nome_novo_id,text:valEdit});
		
		$("#"+nome_novo_id).on("select2-selecting",function(e){
			e.preventDefault();
			var string = "";
			string = format_text(e.object.text);
			var data = { id:e.object.id, text:string };
		   
		   	  $(this).select2("data",data);
			   	  $(this).select2("close");
		});
		
		/*$("#"+nome_novo_id).on("change",function(e){
		   var string = "";
		   //console.log("executa aqui");
		   
		   if(e.added.text)
		   		string = top.format_text(e.added.text);
		   
		   var data = { id:e.added.id, text:string,disabled: true };
		   
		   $(this).select2("data",data);
			 
		});*/		
		
		
	}else{
		t.parentNode.parentNode.removeChild(t.parentNode);
	}
}


	

$(document).on("keyup","#plano_porcentagem",function(event){
	if (event.which != 8) calc_plano_centro_porcentagem($(this));
});
$(document).on("keyup","#centro_porcentagem",function(event){
	if (event.which != 8) calc_plano_centro_porcentagem($(this));		
});

$(document).on("keyup blur","#plano_valor",function(event){
	if (event.which != 8) calc_plano_centro_valor($(this));		
});

$(document).on("keyup blur","#centro_valor",function(event){
	if (event.which != 8) calc_plano_centro_valor($(this));		
});
  
function calc_plano_centro_porcentagem(t){
	var jsValorCadastro= moedaBrToUsa(document.getElementById('valor_cadastro').value);
	var porcentagem = moedaBrToUsa(t.val());
	var calculo = jsValorCadastro*(porcentagem/100);
	t.parent().parent().find('input').eq(2).val(moedaUsaToBR(calculo.toFixed(2)));
	
}
function calc_plano_centro_valor(t){
    var calculo = 0;
	var jsValorCadastro= moedaBrToUsa(document.getElementById('valor_cadastro').value);
	var valore=moedaBrToUsa(t.val());
	calculo =(valore/jsValorCadastro)*100;
	
	console.log(moedaUsaToBR(calculo.toFixed(2)));
	t.parent().parent().find('input').eq(3).val(moedaUsaToBR(calculo.toFixed(2)));
}



function confirma_calculor(){
	
	centros = document.getElementById('centro_de_custos').getElementsByTagName('div');
	planos = document.getElementById('plano_de_contas').getElementsByTagName('div');
	nome_internauta =document.getElementById('internauta_id').getAttribute('title');
	nome_cliente	=document.getElementById('cliente').value;
	limite_mensal = (document.getElementById("limite_mensal").value)*1;
	id_movimentacao = document.getElementsByName("id")[0].value;
	valor_cadastro_form = document.getElementById("valor_cadastro").value;
	
	
	jsvalor_cadastrado = moedaBrToUsa(document.getElementById('valor_cadastro').value)*1;
	
	valor_centros = 0;
	
	for(i=0;i<centros.length;i++){
		valor_campos = moedaBrToUsa(centros[i].getElementsByTagName('input').value)*1;
		valor_centros=valor_centros+valor_campos;
	}
	diferenca1 =jsvalor_cadastrado-valor_centros;
	
	valor_planos = 0;
	
	for(i=0;i<planos.length;i++){
		valor_campos = moedaBrToUsa(planos[i].getElementsByTagName('input').value)*1;
		valor_planos=valor_planos+valor_campos;
	}
	diferenca2 =jsvalor_cadastrado-valor_planos;

	erro=0;
	mensagem='';
	
	/**/
			
	var valor_cadastro = moedaBrToUsa($("#valor_cadastro").val());
	var val_soma_centro = 0;
	var val_soma_plano = 0;
	
	$("label #centro_valor").each(function(index, element) {
		val_soma_centro += moedaBrToUsa(element.value)*1;
	});
	
	$("label #plano_valor").each(function(index, element) {
		val_soma_plano += moedaBrToUsa(element.value)*1;
	});
	
	
	if( val_soma_centro > valor_cadastro || val_soma_centro < valor_cadastro ){
	  erro++;
	  mensagem=mensagem+" o Valor dos centros está diferente do valor de cadastro\n";
	}
	
	if( val_soma_plano > valor_cadastro || val_soma_plano < valor_cadastro ){
	  erro++;
	  mensagem=mensagem+" o Valor dos planos está diferente do valor de cadastro\n";
	}
	
	/*if( $.trim(id_movimentacao) == "" && limite_mensal != 0  ){
		
		if( limite_mensal < valor_cadastro){
			erro++;
			mensagem=mensagem+" Esse valor excede o limite mensal do cliente\n";
		}
	}*/
			
	/**/
	
	if(diferenca1>0.02){
		erro++;
		mensagem=mensagem+"O Total dos Centros de Custos não coincidem com o valor cadastrado\n";
	}
	if(diferenca2>0.02){
		erro++;
		mensagem=mensagem+"O Total dos Planos de Contas não coincidem com o valor cadastrado\n";
	}
	if(document.getElementById('efetivar_movimento').checked==true){
		if(document.getElementById('conta_id').value==0){
			erro++;
			mensagem=mensagem+"Selecione uma conta para efetivar a movimentação\n";
		}
	}
	
	if(nome_internauta!=nome_cliente){
		erro++;
		mensagem=mensagem+"O nome Selecionado é diferente informado "+nome_internauta+" ! "+nome_cliente+"\n";
		
	}
	
	if(erro==0){
		if(validaForm(document.getElementById('form_movimento_caixa'))){
			document.getElementById('form_movimento_caixa').submit();
		}
		
	}else{
		
		alert(mensagem);
	}
}

function populaSelect(id){
	var lista= document.getElementById(id);
	
}

$(".deldoc").live("click",function(){
	identificador	= $(this).attr("identificador");
	tipo			= $(this).attr("tipo");
	extencao		= $(this).attr("extencao");
	url = 'modulos/financeiro/deleta_arquivos.php?movimento_id='+identificador+'&tipo='+tipo+'&extencao='+extencao
	if(confirm('Você irá deletar o arquivo')){
		$(this).parent().hide();
		$('#'+tipo).show();
		window.open(url,'carregador');
	}
})


function confirma_transferencia(){
  if(confirm('Confirma Transferencia')){
	  conta_id_destino=document.getElementById('conta_id_destino').value; 
	  conta_id_origem=document.getElementById('conta_id_origem').value;
	  valor_transferido=document.getElementById('valor_transferido').value; 
	  
	  if(conta_id_destino*1>0&&conta_id_origem*1>0&&valor_transferido.length>=3&&conta_id_destino!=conta_id_origem){
	  	document.getElementById('form_transferencia_entre_contas').submit();
	  }else{
		  alert('Preencha as informações corretamente');
	  }
  }
}
function co(t,i){
	
	if(t.checked){
		consilia_desconsilia = 1;	
	}else{
		consilia_desconsilia = 0;	
	}
	d= Date();
	url ="modulos/financeiro/consilia_desconsilia.php?movimento_id="+i+"&consilia_desconsilia="+consilia_desconsilia+"&"+d;
	window.open(url,'carregador');
}

$("#plano_valor").live("focus",function(){
	$("#janela_plano_contas").hide()
})

  $("#centro_valor").live("focus",function(){ $("#janela_centro_custo").hide(); })
  //$("#busca_plano").live("blur",function(){ /*$("#nota").focus()*/ });
 
  $.fn.serializeObject = function(){ /* Transforma os dados do formulario em JSON */
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
  
  /*$("#duplicar").live("click",function(){
	var dadosForm = $("#form_movimento_caixa").serializeObject(); 
	$.ajax({
		type:"POST",
		url:"modulos/financeiro/FileAjax.class.php",
		data:dadosForm,
		success: function(data){
			console.log(data);
		}	
	});
  });*/
		
  function format_text(string){
	var nome_filho = string;
	var pais = nome_filho.split('#@');
	var diviao = pais.length; 		
	  
	return pais[diviao-1];
  }
  
  function format(state, container) {
	var option = $(state.element);
		
		if (option[0].tagName === 'OPTION') {
			
			if (option.attr('disabled') === 'disabled'){
				container.hide();	 
			} else {
				var string = format_text(option.text());
				return string;
			}
		
		} else {
			
			var nivel = option.attr("nivel"); 
			return "<div style='margin-left:"+nivel*5+"px' >"+option.prop('label')+"<div>";
		}
  }
  
  /* Forma de pagamento */
  function mudaFormaPagamento(){
	  id=$("#forma_pagamento").val();
	  prazo=$("#forma_pagamento option:selected").attr('prazo');
	  taxa_pct=$("#forma_pagamento option:selected").attr('taxa_pct');
	  taxa_fix=$("#forma_pagamento option:selected").attr('taxa_fix');
	  vencimento=$("#data_vencimento").val();
	  valor=$("#valor_cadastro").val();
	  
	  data_obj = {id:id, prazo:prazo, taxa_pct:taxa_pct, taxa_fix:taxa_fix, vencimento:vencimento,valor:valor};
	  console.log(data_obj);
	  
	  $.ajax({
		  type:"POST",
		  url:"modulos/financeiro/ajax_data_forma_pagamento.php",
		  dataType:"json",
		  data:data_obj
	  }).done(function(data){
		  $.each(data,function(i,item){
			  $("#"+i).text(item);
		  })
	  }) 
  }
  
  /* Repetir conta */
  var InserirHtmlRepetir = false;
  $("select[name='repetir']").live("change",function(){
	  var val_repetir = $(this).find("option:selected").val();
	  var HtmlSelect = "&nbsp;"+
		  "<select name='tipo_repetir'>"+
		  "<option value='semana'>Semanas</option>"+
		  "<option value='quinzenas'>Quinzenas</option>"+
		  "<option value='mes'>Meêses</option>"+
		 "</select>";
		 
	  if(val_repetir > 0 && InserirHtmlRepetir == false){
		 
		 $("#result-repetir").html(HtmlSelect);
		 InserirHtmlRepetir = true;
		 
	  } else if(InserirHtmlRepetir == true && val_repetir > 0 ) {
		 return true
	  } else if(val_repetir == 0 && InserirHtmlRepetir == true ){
		  
		  $("#result-repetir").html("");
		  InserirHtmlRepetir = false;
	  }
	  
  });