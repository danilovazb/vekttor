// JavaScript Document
function adicionaFicha(t){
	$(document).live('keyup',function(e){
		if(e.which=='13'){
			pessoas=$(".qtd_pessoas_ficha").val();
			var conteudo_linha = $(t).parent().parent().clone();
			var linha_nova=$("<tr>"+conteudo_linha.html()+"</tr>");
			linha_nova.find("select[name='ficha_id[]']").val('0');
			linha_nova.find("input[name='pessoas[]']").val(pessoas);
			linha_nova.appendTo("#fichas");
		}
	})
}
function retiraFicha(t){
	var linhas = $(t).parent().parent().find('tr');
	if(linhas.length==1){
		$(t).parent().find("select[name='ficha_id[]']").val('0')
		$(t).parent().find("input[name='pessoas[]']").val('');
	}else if(linhas.length>1){
		$(t).parent().remove();
	}
}
function importarDiaAnterior(contrato_id,data,refeicao){
	//alert(contrato_id+' - '+data+' - '+refeicao);
	$("#fichas").load('modulos/cozinha/cardapio/importar_dia_anterior.php?contrato_id='+contrato_id+'&data='+data+'&refeicao='+refeicao);
	
}