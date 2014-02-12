// JavaScript Document
$(function(){
	//$(".add-midia").
	$(document).on('click','#add-midia',function(){
		console.log('test')
		//tr 	= 	$(this.parentNode.parentNode);
		//id	=	tr.attr('id');
		id = $("#orcamento_id").val()
		selecionados = Array();
		selecionados_input = $(".planejar:checked");
		selecionados_input.each(function(i, e) {
		selecionados.push($(e).val());
        });
		selecionados = selecionados.join(',');
		$.ajax({
			url:'modulos/midia/orcamento/cadastro/form_planeja_midia_ctrl.php',
			type:'GET',
			data:{id:id, 'action':'Abrir',selecionados:selecionados},
			success: function(dados){
				$("#add-midia-form").html(dados)
			}
		})
		//$("#add-midia-form").load("modulos/midia/orcamento/cadastro/form_planeja_midia_ctrl.php?action=Abrir&id="+id);
		
		
	})
	$(document).on('click','#submit-inserir',function(){
		info=$("#form_planejamento_midia").serialize();
		$.ajax({
			url:'modulos/midia/orcamento/cadastro/form_planeja_midia_ctrl.php?action=Inserir',
			type:'POST',
			dataType:"json",
			data:info,
			success: function(dados){
				//console.log(dados);
				$.ajax({
					url:'modulos/midia/orcamento/cadastro/form_planeja_midia_ctrl.php',
					type:'GET',
					data:{id:id, 'action':'Abrir',selecionados:selecionados},
					success: function(dados){
						$("#add-midia-form").html(dados)
					}
				})
			}
		})
		
	})
	
	
	
	
	$(document).on('keyup','.insercao',function(){
		painel_id = $(this).attr('data-rel');
		data = $(this).attr('data');
		
		total=0
		$(".insercao").each(function(i, e) {
			if($.isNumeric($(e).val())){
				total+=$(e).val()*1;
			}else{
				total+=0;
			}
        });	
		
		total_painel=0
		$("input[data-rel="+painel_id+"]").each(function(i, e) {
			if($.isNumeric($(e).val())){
				total_painel+=$(e).val()*1;
			}else{
				total_painel+=0;
			}
        });	
		
		total_dia=0
		$("input[data="+data+"]").each(function(i, e) {
			if($.isNumeric($(e).val())){
				total_dia+=$(e).val()*1;
			}else{
				total_dia+=0;
			}
        });	
		
		
		planejaveis = $("#total_insercoes").val()
		$("#total_painel_"+painel_id).text(total_painel)
		$("#total_dia_"+data).text(total_dia)
		$("#insercoes_planejadas").text(total)
		$("#diferenca_insercoes").text(planejaveis-total)
	})
	
	
	
})