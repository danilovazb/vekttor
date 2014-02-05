$("#formstar").live("click",function(){
	val =$(this).find("input").val();
	
	if(val=='0'){
		$(this).find("input").val('1');
		$(this).css('background','url(../fontes/img/st.png)')	
	}else{
		$(this).find("input").val('0');
		$(this).css('background','url(../fontes/img/st2.png)')	
	}
});

function resize2(){
	h =document.body.clientHeight;
	document.getElementById('sis_coluna2').style.height=(h-75)+'px';
}
function resize3(){
	h =document.body.clientHeight;
	document.getElementById('dados').style.height=(h-250)+'px';
}
function resize4(){
	h =document.body.clientHeight;
	document.getElementById('dados').style.height=(h)+'px';
}


window.onresize=function() {
	resize3();
	resize2();
}
$(document).ready(function(){	
		$("#situ3").live("click",function(){
			
		$('#tempo_gasto').attr('disabled','disabled');
		$('#data_fim').attr('disabled','disabled');
		$('#hora_fim').attr('disabled','disabled');
		$('#v2').attr('disabled','disabled');
		$('#data_inicio').attr('disabled','disabled');
		$('#hora_inicio').attr('disabled','disabled');
		$('#v1').attr('disabled','disabled');
		
		$('#situ2').attr('checked',false);
	});
	
	$("#situ2").live("click",function(){
		$('#data_inicio').attr('disabled','disabled');
		$('#hora_inicio').attr('disabled','disabled');
		$('#v1').attr('disabled','disabled');
		//$('#situ3').attr('disabled','disabled');
		$('#situ3').attr('checked',false);
		//desabilitar
		$('#tempo_gasto').removeAttr('disabled');
		$('#data_fim').removeAttr('disabled');
		$('#hora_fim').removeAttr('disabled');
		$('#v2').removeAttr('disabled');
	});	
	
});

$(".exa").live("click",function(){
	var atividade_id = $(this).attr('id');
	var edono = $(this).attr('p');

	if(edono=='1'){
		window.open('modulos/projetos/atividades/form.php?id='+atividade_id+'&tela_id='+$('#infotela').attr('tela_id'),'carregador');
	}else{
		window.open($('#infotela').attr('caminho')+'/form.php?id='+atividade_id,'carregador');
	}
});
// checa
$("#tabela_dados input").live("click",function(){
	id = $(this.parentNode.parentNode).attr('ri');
	atividade = $(this.parentNode.getElementsByTagName('span')[0]).text();
	t1 = $('#f'+id).text();
	t2 =$('#g'+id).text();
	t3 =$('#h'+id).text();
	if($(this).is(':checked')){
		$(this.parentNode.parentNode.parentNode).find('tr').removeClass('azul');
		$(this.parentNode.parentNode.parentNode).find('input').css("visibility","visible");
		$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp2');
		$(this.parentNode.parentNode).find('img').removeClass('brp');
		$(this.parentNode.parentNode).find('img').addClass('brp0');
		document.getElementById("g"+id).setAttribute('pause','1');
		
		window.open($('#infotela').attr('caminho')+'/_actions.php?action=conclui_atividade&atividade_id='+id,'carregador');


	}else{
		$(this.parentNode.parentNode.parentNode).find('tr').removeClass('azul');
		$(this.parentNode.parentNode.parentNode).find('input').css("visibility","visible");
		$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp2');
		
		$(this.parentNode.parentNode.parentNode).find('img').addClass('brp');
		$(this.parentNode.parentNode.parentNode).find('input:checked').each(function(index) {
    		$(this.parentNode.parentNode).find('img').removeClass('brp');
    		$(this.parentNode.parentNode).find('img').removeClass('brp2');
    		$(this.parentNode.parentNode).find('img').addClass('brp0');
		});


		
		document.getElementById("g"+id).setAttribute('pause','1');
		window.open($('#infotela').attr('caminho')+'/_actions.php?action=ativa_atividade&atividade_id='+id,'carregador');
	}
});

///inicia a atividade
$(".brp").live("click",function(){
	id = $(this.parentNode.parentNode).attr('ri');
	$(this).removeClass('brp');
	$(this.parentNode.parentNode.parentNode).find('tr').removeClass('azul');
	$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp2');
	$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp');
	$(this.parentNode.parentNode.parentNode).find('img').addClass('brp0');
	$(this.parentNode.parentNode.parentNode).find('input').css("visibility","hidden");
	$(this.parentNode.parentNode).addClass('azul');
	$(this.parentNode).find('input').css("visibility","visible");
;
	document.title=$(this.parentNode).find(".exa").html();
	
	
	$(this).addClass('brp2');
	document.getElementById("g"+id).setAttribute('pause','0');
	cronometro("g"+id);
	window.open($('#infotela').attr('caminho')+'/_actions.php?action=starta&atividade_id='+id,'carregador');

});

// Para a a tividade
$(".brp2").live("click",function(){
	id = $(this.parentNode.parentNode).attr('ri');
	$(this).removeClass('brp2');
	 $(this).addClass('brp');
	 
	 
	 
	 	document.title=$('.navegacao_ativo').attr('tt');

	$(this.parentNode.parentNode.parentNode).find('tr').removeClass('azul');
	$(this.parentNode.parentNode.parentNode).find('input').css("visibility","visible");
	$(this.parentNode.parentNode.parentNode).find('img').removeClass('brp2');
	$(this.parentNode.parentNode.parentNode).find('img').addClass('brp');
	document.getElementById("g"+id).setAttribute('pause','1');
	window.open($('#infotela').attr('caminho')+'/_actions.php?action=pausa&atividade_id='+id,'carregador');


});
function cronometro(origem){
	horasMinutos = document.getElementById(origem).innerHTML;
	
	splitTime = horasMinutos.split(":");
	
	horas = splitTime[0]*1;
	minutos = splitTime[1]*1;
	segundos = splitTime[2]*1;
//	alert(segundos)
	if(horas>0){}else{horas=0;}
	if(minutos>0){}else{minutos=0;}
	if(segundos>0){}else{segundos=0;}
	
	segundos++;
	if(segundos>59){
		minutos++;
		segundos=0;	
	}
	if(minutos>59){
		horas++;
		minutos=0;	
	}
	
	
	
	if(document.getElementById(origem).getAttribute('pause')!=1){
	
		document.getElementById(origem).innerHTML=ct(horas)+":"+ct(minutos)+":"+ct(segundos);
		setTimeout("cronometro(\""+origem+"\")",1000);
	}else{
		idlinhe = document.getElementById(origem).parentNode.getAttribute('ri');
		planejado = document.getElementById('f'+idlinhe).innerHTML;
		realizado = document.getElementById(origem).innerHTML
		
		saldo =calc_saldo(planejado,realizado);
		document.getElementById('h'+idlinhe).innerHTML=saldo;
		
	}
	calc_porcentagem_time(origem);
}
function calc_porcentagem_time(origem){
	pid = document.getElementById(origem).parentNode.getAttribute('ri');
	pestimado = time_to_sec(document.getElementById('f'+pid).innerHTML);
	pdecorrido = time_to_sec(document.getElementById(origem).innerHTML);
	
	ppercentual = (pdecorrido/pestimado)*100;
	ppercentual = ppercentual.toFixed(2);
	
	document.getElementById('pp'+pid).innerHTML=ppercentual;
	if(ppercentual>100){
		ppercentual =100
		document.getElementById('p'+pid).style.background='#990000';
	}
	document.getElementById('p'+pid).style.width=ppercentual+'%';
	
	
}

function time_to_sec(t){
	splitTime =t.split(":");
	horas = splitTime[0]*1;
	minutos = splitTime[1]*1;
	segundos = splitTime[2]*1;

	if(horas>0){}else{horas=0;}
	if(minutos>0){}else{minutos=0;}
	if(segundos>0){}else{segundos=0;}
	
	h_seg = horas*60*60;
	m_seg = minutos*60;
	s_seg = segundos;
	
	return h_seg+m_seg+s_seg;
	
}
function sec_to_time(secs){
    var hours = Math.floor(secs / (60 * 60));
   
    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);
 
    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);
   
    return ct(hours)+":"+ct(minutes);
}


function calc_saldo(previsto,realizado){
	pr =time_to_sec(previsto);
	re =time_to_sec(realizado);
	
	if(pr>re){
		tempo_saldo = pr-re;
		sinal = '&nbsp;';
	}else{
		tempo_saldo = re-pr;
		sinal ='-';
	}
	
	return sinal+sec_to_time(tempo_saldo);

}
function ct(i){
	if(i<10){
		return '0'+i;
	}else{
		return i;	
	}
}

