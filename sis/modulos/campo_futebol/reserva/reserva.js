// JavaScript Document
var ClassAjax = "modulos/campo_futebol/reserva/AjaxClass.php";

$(function(){});

var ChecaCheckboxCampo = function(){
	var checkboxCampos = $(".container_campos").find(":checkbox");
	var Checado = false;
	var Campos = [];
	Campos["checado"] = false;
	
	for(i=0; i < checkboxCampos.length; i++){
		if($(checkboxCampos[i]).is(":checked")){
			Campos.push( $(checkboxCampos[i]).val() );
			Campos["checado"] = true;
		}
	}
	return Campos;
}

/*function testCampo(horas,data_reserva){
	var template = "";
	$.post(ClassAjax,{method:"ConsultaCampoHorario",hora:horas,data_reserva:data_reserva},function(campo){
		template = '<td style="color:#CCC;">'+campo+'</td>';
	});
	return template;
}*/

$(document).on("change","#tipo_campo",function(){
	if($(this).val()!="society"){
		$(".container_campos > input[type='checkbox']").attr("checked","checked");
	}else{
		$(".container_campos > input[type='checkbox']").removeAttr("checked");
		$(".container_campos > input[type='checkbox'][0]").attr("checked","checked");
	}
});

$(document).on("click, change",".container_campos > input[type='checkbox'], #tipo_campo",function(){
	var checkboxAll = $(".container_campos").find(":checkbox");
	var tipo_campo  = $("#tipo_campo").val();
	
	var campo = [];
	
	if($(this).is(":checked")){
	  checkboxAll.attr("disabled","disabled");
	  $(this).removeAttr("disabled");	
	 }else{
	  checkboxAll.removeAttr("disabled");
	 }
	 
	 if(tipo_campo=="padrao"){
		checkboxAll.removeAttr("disabled");	 	
		checkboxAll.attr("checked","checked");
	 }
	
	
	for(i=0; i < checkboxAll.length; i++){
		if($(checkboxAll[i]).is(":checked")){
			campo.push($(checkboxAll[i]).val());
		}
	}
	
	var qtdCampo = campo.length;
	if(qtdCampo > 0){
		var dados = { method:"ConsultaDisponibilidade", campo_id:campo, data_reserva:$("#data_reserva").val(), tipo_campo:tipo_campo };
		$.ajax({
			type:"POST",
			url:ClassAjax,
			data:dados,
			success: function(data){
				console.log(data);
			   $("#tbody_horarios").html(data);
			   $("tr:odd").addClass('al');
				 
			}/*success*/	
		});
	} else{
		var template = '';
		for(h=0; h < 24; h++){
		   
		   var j = h <= 9 ? "0"+h : h;
		   var horas = j+':00';
		   
			 template += '<tr style="background:#FFF;">';	
				template += '<td> <input type="checkbox" id="horario_reserva" name="horario_reserva[]" value="'+horas+'"> </td>';
				template += '<td>'+j+':00</td>';
				template += '<td></td>';
				template += '<td></td>';
			 template += '</tr>'; 
		 }
		 
		 $("#tbody_horarios").html(template);
		 $("tr:odd").addClass('al');
		
	}
});

$(document).on("click","table input[type='checkbox']",function(){
	
	
		var Campos = [];
		var Horarios = [];
		var ChecaCampo = ChecaCheckboxCampo();
		var checkBoxHorarios = $("table").find(":checkbox");
		var tipo_campo = $("#tipo_campo").val();
		
			if(ChecaCampo["checado"] == false){
				alert(" Selecione um campo, para continuar!");
				$(this).prop("checkbox",false);
				
				return false;
					
			} else {
				
				//Horarios
				for(j=0; j < checkBoxHorarios.length; j++ ){
					if( $(checkBoxHorarios[j]).is(":checked") ){
						Horarios.push( $(checkBoxHorarios[j]).val() );
					}	
				}
				
				//Campos
				for(i=0; i < ChecaCampo.length; i++){
					Campos.push(ChecaCampo[i]);
				}
			   
			   var dados = {method:"ConsultaValor",campo_id:Campos, horario:Horarios, data_reserva:$("#data_reserva").val(), tipo_campo:tipo_campo};
			   $.ajax({
					type:"POST",
					url:ClassAjax,
					dataType:"json",
					data:dados,
					success: function(data){
						console.log(data);
						$("#valor_reserva").val(moedaUsaToBR(data.soma.toFixed(2)));
						$("#valor_entrada").val(moedaUsaToBR(data.valor_reserva.toFixed(2)));
						$("#valor_pendente").val(moedaUsaToBR(data.saldo_devedor.toFixed(2)));
					},	
			   });
			   
			   return true;	
		    }
		
	

});