// JavaScript Document
function carrega_matriculas(t){
	var periodo_id = $(t).val();
	var de = $("#de").val();
	var a = $("#a").val();
	var erro=0;
	if(periodo_id==0){
		erro++;
	}
	if(de==''||a==''){
		alert('Escolha a data do primeiro vencimento');
		erro++;
	}
	if(erro>0){
		$("#gerar_boleto").attr('disabled',true);
		return false;
	}else{
		$("#gerar_boleto").removeAttr('disabled');
	}
	
	$("#qtd_matriculas").load('modulos/cobranca/mensalidades_escolar/carrega_matriculas.php?action=contagem&periodo_id='+periodo_id+"&de="+de+"&a="+a);
	//window.open('modulos/cobranca/mensalidades_escolar/carrega_matriculas.php?action=contagem&periodo_id='+periodo_id+"&de="+de+"&a="+a);
}

function formBoleto(t){
	if(validaForm(t)){
		window.location='?tela_id=296';
		return true;
	}else{
		return false;
	}
}

function muda_data(t){
	console.log('foi');
	var dias = Array('Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado');
	div=$(t.parentNode.parentNode);
	divs=div.find('.info_data');
	i=0
	divs.each(function(i,e) {
		i++
        campo_data=$(this).find('.escolhe_data');
		container_data=$(this).find('.dia_extenso');
		data_usa=campo_data.val().split('/');
		data_val=campo_data.val();
		d = new Date(data_usa[2],data_usa[1]-1,data_usa[0]);
		dia_semana=d.getDay();
		if(i<=1){
			console.log(data_usa[0] +'/'+data_usa[1]+'/'+data_usa[2])
			console.log(data_val + '-' +d.toString())
		}
		container_data.text(dias[dia_semana])
    });
	
	
	
	
	
	
}
$('.escolhe_data').live('blur',function(){
	muda_data(this)
})
