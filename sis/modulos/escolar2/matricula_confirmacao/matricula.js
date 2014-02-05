// JavaScript Document
/*========== ADICIONADOS POR JAIME ============*/
var urlSelect = "modulos/escolar2/matricula_confirmacao/select.php";

var caminho_modulo = "modulos/escolar2/matricula_confirmacao/";

	function ShowCarregador(){
		$(".status_mat").show();
	}
	
	function HideCarregador(){
		$(".status_mat").hide(); 
	}

$("#responsavel_e_aluno").live("click",function(){
	if( $(this).is(":checked") ) {
		var dados_responsavel = 
			{ 
				1: $("#nome_responsavel").val(), 
				2: $("#f_cnpj_cpf").val(),
				3: $('#f_nascimento').val(),
				4: $('#f_grau_instrucao').val(),
				5: $('#f_ramo_atividade').val(), // RAMO DE ATIVIDADE
				6: $('#f_rg').val(),             // RG
				7: $('#f_data_emissao').val(),   // DATA EMISSAO
				8: $('#f_email').val(),          // EMAIL
				9: $('#f_telefone2').val(),      // TELEFONE 2
			   10: $('#f_cep').val(),
			   11: $('#f_endereco').val(),
			   12: $('#f_bairro').val(),
			   13: $('#f_cidade').val(),
			   14: $('#f_estado').val(),
			   15: $('#f_telefone1').val()       // TELEFONE 2
			};
		
	 } else {
		var dados_responsavel = Array(); 
	}
	// Insere os mesmo dados do responsvel
	$("#nome_aluno").val(dados_responsavel[1]);
	$("#cpf_aluno").val(dados_responsavel[2]);
	$("#data_nascimento_aluno").val(dados_responsavel[3]);
	$("#escolaridade_aluno").val(dados_responsavel[4]);
	$('#profissao').val(dados_responsavel[5]);
	$("#rg_aluno").val(dados_responsavel[6]); 
	$('#rg_dt_expedicao').val(dados_responsavel[7]);
	$('#email').val(dados_responsavel[8]);
	$('#telefone2').val(dados_responsavel[9]);
	//$('#cep').val(dados_responsavel[10]);
	//$('#endereco').val(dados_responsavel[11]);
	//$('#bairro').val(dados_responsavel[12]);
	//$('#cidade').val(dados_responsavel[13]);
	//$('#uf').val(dados_responsavel[14]);
	$('#telefone1').val(dados_responsavel[15]);
});
//

$("#mesmo_endereco").live("click",function(){
	if( $(this).is(":checked") ){
		var dados_endereco = {
			1:$("#f_cep").val(),
			2:$("#f_endereco").val(),
			3:$("#f_bairro").val(),
			4:$("#f_cidade").val(),
			5:$("#f_estado").val()	
		};
	} else {
		dados_endereco = Array();
	}
	//Insere o mesmo endereço no aluno
	$("#cep").val(dados_endereco[1]);
	$("#endereco").val(dados_endereco[2]);
	$("#bairro").val(dados_endereco[3]);
	$("#cidade").val(dados_endereco[4]);
	$("#uf").val(dados_endereco[5]);
});

/* PERÍODO LETIVO */
$("#periodo_letivo").live("change",function(){
	$(".status_mat").show();
	$.post("modulos/escolar2/matricula_confirmacao/select.php",{acao:"periodo",periodo_id:$(this).val()},function(data){
		$("#unidade").html(data);
		$(".status_mat").hide();
	});
		
});
$("#periodo_letivo_1").live("change",function(){
	ShowCarregador();
		$("#unidade_1").load(urlSelect,{acao:"periodo",periodo_id:$(this).val()},function(data){ HideCarregador(); });	
}); 
 
/* UNIDADE */
$("#unidade").live("change",function(){
	ShowCarregador();
	var periodo = $("select#periodo_letivo").val();
		$("#serie_id").load(urlSelect,{acao:"unidade",unidade_id:$(this).val(),periodo_id:periodo},function(data){ HideCarregador(); });
	
});

$("#unidade_1").live("change",function(){
	ShowCarregador();
		$("#serie_id_1").load(urlSelect,{acao:"unidade",unidade_id:$(this).val(),periodo_id:$("select#periodo_letivo_1").val()},function(data){ HideCarregador(); });
});

//
$("#serie_id").live("change",function(){
	ShowCarregador();
	var periodo = $("select#periodo_letivo").val();
	var unidade = $("select#unidade").val();
	var serie   = $(this).val();
	
	$.post("modulos/escolar2/matricula_confirmacao/select.php",{acao:"serie",periodo_id:periodo,unidade_id:unidade,serie_id:serie},function(data){
		$("#turma_id").html(data);
		$("#turma_id_2").html(data);
		HideCarregador();
	});

});

/*$("#serie_id_1").live("change",function(){
	ShowCarregador();
	var periodo = $("select#periodo_letivo_1").val();
	var unidade = $("select#unidade_1").val();
	
	$("#turma_id_1").load(urlSelect,{acao:"serie",periodo_id:periodo,unidade_id:unidade,serie_id:$(this).val()},function(data){
		HideCarregador();
	});
});*/

/* TURMA */
$("#turma_id").live("change",function(){
	var combina_item = 0;
	var erros = 0;
	ShowCarregador();
	var turma = $(this).val();
	
	if($.trim(turma) != ""){ $("#fazer_matricula").val("1"); }
	
	$.post("modulos/escolar2/matricula_confirmacao/select.php",{acao:"turma",turma_id:turma},function(data){
		
		HideCarregador();
		$.each(data,function(i, item){
			 
			 if (item.combinar_horario == "sim")
				 combina_item++;
			 
			$("#valor_matricula").val(item.valor_matricula);
			$("#valor_mensalidade").val(item.valor_matricula);
		});
		
		if( combina_item > 0 ){
			$(".matricula_outra_turma").show();
			$("#fazer_matricula_1").attr("retorno","focus|Nao existe segunda turma");
			$("#fazer_matricula_1").attr("valida_minlength","1");
			
		}
		 else{ 
		 	$("#fazer_matricula_1").removeAttr("retorno");
			$("#fazer_matricula_1").removeAttr("valida_minlength");
			$(".matricula_outra_turma").hide();
		 }
		
	},'json');
	
});

$("#turma_id_2").live("change",function(){
	
	ShowCarregador();
	
	var turma = $(this).val();
	
	console.log(turma);
	
	if( $.trim($(this).val()) != 0 ){ 
		
		$("#fazer_matricula_1").val("1");	
	
	} else{
		$("#fazer_matricula_1").val("");	
	}
	
	$.post(urlSelect,{acao:"turma",turma_id:turma},function(data){
		
		HideCarregador();
		
	},'json');
	
});

//
$("#nome_aluno").live("blur",function(){
	
	if( $.trim($("#aluno_id_busca").val()) != "" ){
		$(".carregador").show();
		var aluno_id = $("#aluno_id_busca").val();
		
		$.post(caminho_modulo+"requisicao.php",{acao:'consultar_aluno',aluno_id:aluno_id},function(data){
			$(".carregador").hide();
		 $.each(data,function(i,item){
				
			var id_aluno = item.id; 
			var extensao = item.extensao; 
			
			//$("#nome_aluno").val(item.nome);
			$("#data_nascimento_aluno").val(item.data_nascimento);
			$("#cpf_aluno").val(item.cpf);
			
			$("select#cor option").each(function() {
				if($(this).val() == item.cor){
				   $(this).attr('selected', true);
				}
            });//
			$("select#sexo_aluno option").each(function() {
                if($(this).val() == item.sexo){
				   $(this).attr('selected', true);
				}
            });
			
			$("#rg_aluno").val(item.rg);
			$("#rg_dt_expedicao").val(item.rg_dt_expedicao);
			$("#profissao").val(item.profissao);
			$("#email").val(item.email);
			$("#telefone1").val(item.telefone1);
			$("#telefone2").val(item.telefone2);
			$("#cep").val(item.cep);
			$("#endereco").val(item.endereco);
			$("#bairro").val(item.bairro);
			$("#complemento").val(item.complemento);
			$("#cidade").val(item.cidade);
			$("#uf").val(item.uf);
			$("#portador_necessidade").val(item.portador_necessidade);
			$("#escolaridade_aluno").val(item.escolaridade);
			$("#codigo_interno").val(item.codigo_interno);
			$("#senha").val(item.senha);
			$("#restricao_alimentar").val(item.restricao_alimentar);
			$("#img_curso").html(item.img);
			
			/*= FILIAÇÃO =*/
					
			  /*=mae=*/
			  $("#mae").val(item.mae);
			  $("#cpf_mae").val(item.cpf_mae);
			  $("#telefone_mae").val(item.tel_mae);
			  $("#profissao_mae").val(item.profissao_mae);
			  $("#local_trabalho_mae").val(item.local_trabalho_mae);
			  $("#tel_trabalho_mae").val(item.tel_trabalho_mae);
			  $("#email_mae").val(item.email_mae);
			  
			  /*=pai=*/
			  $("#pai").val(item.pai);
			  $("#cpf_pai").val(item.cpf_pai);
			  $("#telefone_pai").val(item.tel_pai);
			  $("#profissao_pai").val(item.profissao_pai);
			  $("#local_trabalho_pai").val(item.local_trabalho_pai);
			  $("#tel_trabalho_pai").val(item.tel_trabalho_pai);
			  $("#email_pai").val(item.email_pai);
			  
			  /*=transporte=*/
			  $("#pessoa_trazer_buscar_1").val(item.pessoa_trazer_buscar_1);
			  $("#pessoa_trazer_buscar_2").val(item.pessoa_trazer_buscar_2);
			  $("#pessoa_trazer_buscar_3").val(item.pessoa_trazer_buscar_3);
			  $("#pessoa_trazer_buscar_4").val(item.pessoa_trazer_buscar_4);
			  
			  
			  /*=emergencia=*/
			  $("#pessoa_emergencia_1").val(item.pessoa_caso_emergencia_1);
			  $("#fone_emergencia_1").val(item.telefone_caso_emergencia_1);
			  $("#pessoa_emergencia_2").val(item.pessoa_caso_emergencia_2);
			  $("#fone_emergencia_2").val(item.telefone_caso_emergencia_2);
			  
			  /*=observação=*/
			  $("#observacao").val(item.observacao);
			  document.getElementById("ed").contentWindow.document.body.innerHTML = item.contrato;				
				
		   });
			
		},'json'); // fim de $.post
			
	} // fim de if
	
});
//
$("#f_cnpj_cpf").live("blur",function(){
	var cpf_responsavel = $(this).val();
	
	$("#nome_responsavel").val("Aguarde...");
	
	$.post(caminho_modulo+"requisicao.php",{acao:"consultar_responsavel",cpf_responsavel:cpf_responsavel},function(data){
	  
	   $("#nome_responsavel").val("");
	   $.each(data,function(i,item){
			
			$("#responsavel_id").val(item.id);
			$("#nome_responsavel").val(item.razao_social);
			$("#f_nascimento").val(item.nascimento);
			$("#ramo_atividade_responsavel").val(item.ramo_atividade);
			//GRAU INSTRUCAO
				$("select#f_grau_instrucao option").each(function(){
                  if($(this).val() == item.grau_instrucao){
				   	$(this).attr('selected', true);
				   }  
                });
			$("#f_rg").val(item.rg);
			$("#f_local_emissao").val(item.local_emissao);
			$("#f_data_emissao").val(item.data_emissao);
			$("#f_naturalidade").val(item.naturalidade);
			$("#f_nacionalidade").val(item.nacionalidade);
			$("#f_email").val(item.email);
			$("#f_telefone1").val(item.telefone1);
			$("#f_telefone2").val(item.telefone2);
			$("#f_fax").val(item.fax);
			$("#f_cep").val(item.cep);
			$("#f_endereco").val(item.endereco);
			$("#f_bairro").val(item.bairro);
			$("#f_cidade").val(item.cidade);
			$("#f_estado").val(item.estado);	 
	   });
	},'json'); // fim de $.post
});

$("#click_resp").live("click",function(){
		var  matricula_id  = $(this).parent().parent().attr("id");
		var sinal = $(this).text();
			if(sinal == "+")
			  $(this).text("-");
			else 
			   $(this).text("+")
		
		$("#res_"+matricula_id).toggle();
})

/*=========
	CONTROLE DE ABAS
==========*/
$("#avanca_pagina").live("click",function(){
	
	$("#btn-responsavel").hide();
	
	$("#btn-aba-left").html('<button type="button" id="voltar_pagina"> <img src="../fontes/img/arrow-1.png" style="opacity:0.5;float:left;"> &nbsp; <i style="float:left; margin-top:1px;">Voltar</i> </button>');
	
	var pagina_atual = ($("#pagina_atual").val())*1;
	
		if(pagina_atual == 6){
			$("#avanca_pagina").hide();
			$("#confirmar_matricula").show();
		}
	
	var pagina =  (pagina_atual + 1)*1;
	
	aba_form(this,pagina);
	var pagina_atual = ($("#pagina_atual").val(pagina));
	
});
//
$("#voltar_pagina").live("click",function(){
	
	var pagina_atual = ($("#pagina_atual").val())*1;
	
	if(pagina_atual == 2){
		$("#voltar_pagina").hide();
		$("#btn-responsavel").show();
	} else if(pagina_atual == 7){
		$("#confirmar_matricula").hide();
		$("#avanca_pagina").show();
	}
	var pagina =  (pagina_atual - 1)*1;
	
	aba_form(this,pagina);
	var pagina_atual = ($("#pagina_atual").val(pagina));
	
});

/*=====
	IMPRESSÕES 
=====*/
// Boleto Matricula
$("#boleto_matricula").live("click",function(){
	var id = $("#matricula_id").val();
	window.open('modulos/escolar2/matricula_confirmacao/imprimir_boleto.php?matricula_id='+id,'_BLANK');
});
// Contrato
$("#impressao_contrato").live("click",function(){
	var id = $("#matricula_id").val();
	window.open('modulos/escolar2/matricula_confirmacao/impressao_contrato.php?matricula_id='+id,'_BLANK');
});