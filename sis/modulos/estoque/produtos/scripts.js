// JavaScript Document
caminho="modulos/estoque/produtos/";

$(document).ready(function(){
	$("#tabela_dados tr:nth-child(2n+1)").addClass('al');
	$("#cotar_todos").click(function(){
		if($(this).is(':checked')){
			$(".cotar").attr('checked',true)
			$(".cotar").parent().parent().find("input[type=text]").removeAttr( "disabled")
		}else{
			$(".cotar").attr('checked',false)
			$(".cotar").parent().parent().find("input[type=text]").attr( "disabled",'disabled')
			
		}
	})
})

$(".cotar").live('click',function(){
	if($(this).is(":checked")){
			$(this.parentNode.parentNode).find("input").removeAttr( "disabled");
			//console.log($(this))
	}else{
			$(this.parentNode.parentNode).find("input").attr( "disabled",'disabled');	
			$(this).removeAttr( "disabled");
			//console.log($(this));
	}
});

function enviarParaCotacao(){
	n=$(".cotar:checked").length;
	if(n>0){
		$("#produtos_para_cotacao").submit();
	}else{
		alert('No mínimo 1 produto deve ser selecionado para cotação');
	}
}

function FormataMoeda(valor){
	var valor_formatado = valor;
	var tam = var_formatado.length;
}

function calculaPreco(tipo){
	var campos_preenchidos = 0;
	
	var custo_compra = parseFloat(moedaBrToUsa($("#custo").val()));
	var custo_embalagem = parseFloat(moedaBrToUsa($("#custo_embalagem").val()));
	
	var custo_uso = $("#custo_uso").val();
	custo_uso = custo_uso.replace(/\./g,'');
	custo_uso = custo_uso.replace(/,/g,'.')*1;
	
	var conversao_compra_embalagem = parseFloat(moedaBrToUsa($("#conversao1").val()));
	var conversao_embalagem_uso = parseFloat(moedaBrToUsa($("#conversao2").val()));
	
	if((conversao_compra_embalagem!=''&&conversao_compra_embalagem>0) && (conversao_embalagem_uso!=''&&conversao_embalagem_uso>0)){
		
		if(custo_compra!=''&&custo_compra>0){
			campos_preenchidos++;
			if(tipo=='compra'){
				$("#custo_embalagem").val(moedaUsaToBR((custo_compra/conversao_compra_embalagem).toFixed(2)));
				var custo_por_embalagem = custo_compra/conversao_compra_embalagem;
				novo_valor = (custo_por_embalagem/conversao_embalagem_uso).toFixed(5);
				novo_valor = novo_valor.replace(/\./g,',');
				$("#custo_uso").val(novo_valor);
			}
		}
		if(custo_embalagem!=''&&custo_embalagem>0){
			campos_preenchidos++;
			if(tipo=='embalagem'){
				$("#custo").val(moedaUsaToBR((custo_embalagem*conversao_compra_embalagem).toFixed(2)));
				novo_valor = (custo_embalagem/conversao_embalagem_uso).toFixed(5);
				novo_valor = novo_valor.replace(/\./g,',');
				$("#custo_uso").val(novo_valor);
			}
		}	
		
		if(custo_uso!=''&&custo_uso>0){
			campos_preenchidos++;
			if(tipo=='uso'){
				custo_novo_embalagem=(custo_uso*conversao_embalagem_uso).toFixed(2);
				$("#custo_embalagem").val(moedaUsaToBR(custo_novo_embalagem));
				custo_novo = moedaUsaToBR((custo_novo_embalagem*conversao_compra_embalagem).toFixed(2))
				$("#custo").val(custo_novo);
				
			}
		}
		
		if(tipo=='conversao'){
			if(campos_preenchidos==3){
				$("#custo_embalagem").val(moedaUsaToBR((custo_compra/conversao_compra_embalagem).toFixed(2)));
				var custo_por_embalagem = custo_compra/conversao_compra_embalagem;
				novo_valor = (custo_por_embalagem/conversao_embalagem_uso).toFixed(5);
				novo_valor = novo_valor.replace(/\./g,',');
				$("#custo_uso").val(novo_valor);
			}
			
		}
	}
}

//onclick="

$(".abre_form").live('click',function(){
	id=$(this).parent().attr('id')
	
	window.open(caminho+'form.php?id='+id,'carregador');
})

$('.unidade_embalagem').live('change',function(){
	unidade = $(this).val();
	$('.unidade_info').html(unidade)
})
$('.unidade').live('change',function(){
	unidade = $(this).val();
	$('.unidade_info_compra').html(unidade)
})
$('.unidade_uso').live('change',function(){
	unidade = $(this).val();
	$('.unidade_info_uso').html(unidade)
})

$('.produto_has_fornecedor').live('click',function(){
	
	if($(this).attr('checked')=='checked'){
		$('#action2').val('marcado');
	}else{
		$('#action2').val('desmarcado');
	}
	$("#form_cliente").attr('target','carregador');
	$("#form_cliente").submit();
});

$("#add_fornecedor").live("click",function(){
			
			var fornecedor_id    = $("#fornecedor_id").val();
			var razao_social      = $("#busca_fornecedor").val();
			produto_id              = $("#id").val();
			
			var cont = 0;
			
			var dados               = "fornecedor_id="+fornecedor_id+"&razao_social="+razao_social+"&id="+id+"&acao=adicionar";
			
			$(".produto_has_fornecedor").each(function() {
 
      			if(fornecedor_id==$(this).val()){
					cont++;
				}
  
			});
			
							
		if(cont==0){		
			$.ajax({
					url: 'modulos/estoque/produtos/produto_has_fornecedor.php',
					type: 'POST',
					data: dados,
						success: function(data) {
							/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
																				
							//if(data.length>2){								
								//alert(data);
								
								
								
									$("#dados_fornecedores tbody").append(data);
								
						},
					});	
			}
			$("#busca_fornecedor").val('');
});

$(".remove_fornecedor").live('click',function(){
	produto_id = $("#id").val();
	alert(produto_id);
	fornecedor_id = $(this).parent().parent().find('.produto_has_fornecedor').val();
	window.open('modulos/estoque/produtos/_ctrl.php?acao=excluir_produto_fornecedor&produto_id='+produto_id+'&fornecedor_id='+fornecedor_id,'carregador');
	$(this).parent().parent().remove();
});

$('#add_foto').live('click',function(){
		
		var nome_foto = $("#foto_nome").val();
		$("#action2").val("Salvar");
		
					
		$("#dados_fotos").append("<tr><td style='width:500px;'><img src='../fontes/img/menos.png' class='remove_foto'/>"+nome_foto+"</td><td style='width:70px;' align='center'><a class='download_foto'><img src='modulos/odonto/consulta/baixar.png'></a></td></tr>");
		//var
		
		$("#form_cadastro_produtos").attr("target","carregador");
		$("#form_cadastro_produtos").submit();
		$("#form_cadastro_produtos").attr("target","");
		
		$('#foto_nome').val("");
		$('#foto_produto_arquivo').val("");
		$("#action2").val("");
		
});

$('.remove_foto').live('click',function(){
		
		var id_foto =  $(this).parent().parent().attr('id');
			
		$("#action2").val("ExcluirFoto");
		$("#id_foto_exclusao").val(id_foto);
					
		//var
		
		$("#form_cadastro_produtos").attr("target","carregador");
		$("#form_cadastro_produtos").submit();
		$("#form_cadastro_produtos").attr("target","");
		
		$(this).parent().parent().remove();
		
});

$('.download_foto').live('click',function(){
	var id =  $(this).parent().parent().attr('id');
		
	window.open("modulos/estoque/produtos/downloadFotosProdutos.php?foto_id="+id,"carregador");
});	