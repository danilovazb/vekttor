// JavaScript Document
$(function(){
	
	var ClassAjax = "modulos/midia/class/Ajax.class.php";
	
	$(document).on("click","#btn-add-cliente",function(){
		//$("#add-cliente-form").load("modulos/midia/orcamento/cadastro/form_cliente.php");
		$("#add-cliente-form").load("modulos/administrativo/clientes/form.php?nao_abre=1&action=modulos/midia/orcamento/cadastro/cadastro_cliente.php&target=carregador");
	});
	
	/* Click #btn-dd-midia : Cadastro de Orçamento */
	$(document).on("click","#btn-dd-midia",function(){
		var $table_dados = $("#table-list-painel");
		var dados = {
		  painel_id : $("select#painel_id option:selected").val(),
		  plano_id : $("select#plano_id option:selected").val(),
		  midia_id : $("select#tipo_midia_id option:selected").val(),
		  insercao : $("#insercao").val(),
		  valor    : $("#valor").val(),
		  periodo_inicio : $("#periodo_inicio").val(),
		  periodo_fim : $("#periodo_fim").val(),
		  frequencia : $("#frequencia").val(),
		  observacao : $("#observacao").val()
		};
		
		//Formata os dados
		var obj = {methodAjax:"CadastraOrcamento",dados:dados}
		
		//Envia para a Class Ajax.class.php
		$.ajax({
			type:"POST",
			dataType:"html",
			url:ClassAjax,
			data:obj,
			success: function(tr){
				//console.log(tr);
				//$table_dados.find("tbody").append(tr);
				//$("#table-list-painel tbody tr:even").addClass('al');
			}	
		});
		
	});
	
	/* Delete */
	$(document).on("click",".delete",function(){
		var id = $(this).closest("tr").attr("id");
		var $tr = $(this).closest("tr");
		$tr.remove();
		console.log(id);
	});
	
	/*Cadastra Rascunho*/
	$(document).on("click",".mais",function(){
		var dados = {methodAjax:"CadastraRascunhoOrcamento"};
		$.ajax({
			type:"POST",
			//dataType:"json",
			url:ClassAjax,
			data:dados,
			success: function(data){
				console.log(data);
			}
		});
	});
	
	/*Cadastro de tipo de mídia*/
	$(document).on("change","#tipo_midia",function(){
		$select = $(this);
		var val_option = $select.find("option:selected").val();
		
		if(val_option == "add"){
			window.open("modulos/midia/orcamento/cadastro/form_tipo_midia.php","carregador");
		} if(val_option == "edit"){
			window.open("modulos/midia/orcamento/cadastro/form_tipo_midia_edit.php","carregador");
		}
		
	});
	
	$(document).on("change","select#tipo_midia_edit",function(){
			var id = $(this).val();
			var textMidia = $(this).find("option:selected").text();
			
			$("#tipo_midia_id").val(id);
			$("#nome_tipo_midia").val($.trim(textMidia));
			//console.log(id+" : "+textMidia);
	});
	
});