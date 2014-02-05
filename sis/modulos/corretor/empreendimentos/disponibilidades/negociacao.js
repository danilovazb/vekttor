// JavaScript Document

//CAMINHO : modulos/administrativo/empreendimentos/disponibilidades/negociacao.js
function vt(){
	return document.getElementById('valor').value;
}
function valor_porcento(valor_total,valor_parcial,destino){
	valor_total = moedaBrToUsa(valor_total);
	valor_parcial = moedaBrToUsa(valor_parcial);
	porcentagem = (valor_parcial/valor_total)*100;
	
	document.getElementById(destino).value=moedaUsaToBR(porcentagem.toFixed(2));
	
}
function porcento_valor(valor_total,porcentagem,destino){
	valor_total = moedaBrToUsa(valor_total);
	porcentagem = moedaBrToUsa(porcentagem);
	
	valor_final_percentual = (valor_total*(porcentagem/100));
	
	document.getElementById(destino).value=moedaUsaToBR(valor_final_percentual.toFixed(2));
	
}

function calcula_restante(){
	p_entrada = moedaBrToUsa(document.getElementById('porcentagem_ato').value);
	p_chave = moedaBrToUsa(document.getElementById('porcentagem_chave').value);
	p_anuais = moedaBrToUsa(document.getElementById('porcentagem_anuais').value);
	p_semestrais = moedaBrToUsa(document.getElementById('porcentagem_semestrais').value);
	p_mensais= moedaBrToUsa(document.getElementById('porcentagem_mensais').value);
	
	valor_total = moedaBrToUsa(document.getElementById('valor').value);
	valor_entrada = moedaBrToUsa(document.getElementById('valor_ato').value);
	valor_anuais = moedaBrToUsa(document.getElementById('anuais_total').value);
	valor_semestrais = moedaBrToUsa(document.getElementById('semestrais_total').value);
	valor_mensais = moedaBrToUsa(document.getElementById('mensais_total').value);
	valor_chave = moedaBrToUsa(document.getElementById('valor_chave').value);
	
	
	document.getElementById('valor_banco').value = moedaUsaToBR(valor_total-valor_entrada-valor_anuais-valor_semestrais-valor_mensais-valor_chave);
	document.getElementById('restante').value = moedaUsaToBR(valor_total-valor_entrada-valor_anuais-valor_semestrais-valor_mensais-valor_chave);
	document.getElementById('porcentagem_banco').value = moedaUsaToBR((100-p_chave-p_entrada-p_anuais-p_semestrais-p_mensais).toFixed(2));
}


function calcula_banco(){
	p_entrada = moedaBrToUsa(document.getElementById('porcentagem_entrada').value);
	p_construtora = moedaBrToUsa(document.getElementById('porcentagem_construtora').value);
	v_entrada = moedaBrToUsa(document.getElementById('valor_entrada').value);
	v_construtora = moedaBrToUsa(document.getElementById('valor_construtora').value);
	v_total = moedaBrToUsa(document.getElementById('valor').value);
	
	
	document.getElementById('valor_banco').value = moedaUsaToBR(v_total-v_entrada-v_construtora);
	document.getElementById('porcentagem_banco').value = moedaUsaToBR(100-p_construtora-p_entrada);
	
}

function calcula_parcelas(valor,parcelas,juros,destino){
	j_valor		= moedaBrToUsa(document.getElementById(valor).value);
	j_parcelas	= moedaBrToUsa(document.getElementById(parcelas).value);
	l_juros		= moedaBrToUsa(document.getElementById(juros).value);
	
	montante =  j_valor;
	
	if(l_juros>0&& j_parcelas>0){
		montante =montante * Math.pow((1+(l_juros/100)),j_parcelas);
	}
	if(j_parcelas>0){
		montate_parcelado = montante/j_parcelas;
		document.title =montante+' > '+montate_parcelado;
		document.getElementById(destino).value = moedaUsaToBR(montate_parcelado.toFixed(2));
	}

}

function calcula_parcelas_comissao(valor,parcelas,destino,aparece){
	j_valor		= moedaBrToUsa(document.getElementById(valor).value);
	j_parcelas	= moedaBrToUsa(document.getElementById(parcelas).value);
	//l_juros		= moedaBrToUsa(document.getElementById(juros).value);
	
	montante =  j_valor;
	/*if(l_juros>0&& j_parcelas>0){
		montante =montante * Math.pow((1+(l_juros/100)),j_parcelas);
	}*/
	if(j_parcelas>0){
		if(aparece=='sim'){
			document.getElementById('label_valor_parcela').style.display='';
			document.getElementById('qtd_parcelas_comissao').innerHTML="("+(document.getElementById(parcelas).value)+"x)";
		}
			//alert(destino);
			montate_parcelado = montante/j_parcelas;
			document.title =montante+' > '+montate_parcelado;
			resultado = moedaUsaToBR(montate_parcelado.toFixed(2));
			if(montante==0){ resultado=0; }
			document.getElementById(destino).value = resultado;
	}
}

function calcula_negociacao(){
	/*
	1calcula entrada
	2 calculavalor da parcela
	
	3 calcula valor construtora
	4 calcula  parcela construtora
	
	5 calcula valor banco
	6 calcula valor parcela banco
	
	
	*/
	
	valor_total_emp =  moedaBrToUsa(document.getElementById('valor').value);
	
	ato_porcentagem =  	moedaBrToUsa(document.getElementById('porcentagem_ato').value);
	ato_valor = valor_total_emp*(ato_porcentagem/100);
	document.getElementById('valor_ato').value = moedaUsaToBR(ato_valor.toFixed(2));
	
	calcula_parcelas('valor_ato','ato_parcelas','ato_juros','ato_valor_parcela');
	
	
	anuais_porcentagem =  	moedaBrToUsa(document.getElementById('porcentagem_anuais').value);
	anuais_valor = valor_total_emp*(anuais_porcentagem/100);
	document.getElementById('anuais_total').value = moedaUsaToBR(anuais_valor.toFixed(2));

	calcula_parcelas('anuais_total','anuais_parcelas','anuais_juros','anuais_valor_parcelas');
	
	
	semestrais_porcentagem =  	moedaBrToUsa(document.getElementById('porcentagem_semestrais').value);
	semestrais_valor = valor_total_emp*(semestrais_porcentagem/100);
	document.getElementById('semestrais_total').value = moedaUsaToBR(semestrais_valor.toFixed(2));
	
	calcula_parcelas('semestrais_total','semestrais_parcelas','semestrais_juros','semestrais_valor_parcelas');
	
	
	mensais_porcentagem =  	moedaBrToUsa(document.getElementById('porcentagem_mensais').value);
	mensais_valor = valor_total_emp*(mensais_porcentagem/100);
	document.getElementById('mensais_total').value = moedaUsaToBR(mensais_valor.toFixed(2));

	calcula_parcelas('mensais_total','mensais_parcelas','mensais_juros','mensais_valor_parcelas');


	chave_porcentagem =  	moedaBrToUsa(document.getElementById('porcentagem_chave').value);
	chave_valor = valor_total_emp*(chave_porcentagem/100);
	document.getElementById('valor_chave').value = moedaUsaToBR(chave_valor.toFixed(2));

	calcula_parcelas('valor_chave','chave_parcelas','chave_juros','chave_valor_parcelas');


	banco_porcentagem =  	moedaBrToUsa(document.getElementById('porcentagem_banco').value);
	banco_valor = valor_total_emp*(banco_porcentagem/100);
	document.getElementById('valor_banco').value = moedaUsaToBR(banco_valor.toFixed(2));
	
	calcula_parcelas('valor_banco','banco_parcelas','banco_juros','banco_valor_parcelas');
	
	if(parseFloat(document.getElementById('valor_comissao').value)>0){
		aparecer='sim';
	}else{
		aparecer='nao';
	}
	
	comissao_porcentagem = document.getElementById('porcentagem_comissao').value;
	
	
	porcento_valor(document.getElementById('valor').value,comissao_porcentagem,'valor_comissao');
	calcula_parcelas_comissao('valor_comissao','ato_parcelas','comissao_valor_parcela',aparecer);
	calcula_contrato();
	


}

function calcula_contrato(){
	document.getElementById('contrato').value= moedaBrToUsa(document.getElementById('valor').value)-moedaBrToUsa(document.getElementById('valor_comissao').value);
	document.getElementById('mostra_contrato').value= moedaUsaToBR(moedaBrToUsa(document.getElementById('valor').value)-moedaBrToUsa(document.getElementById('valor_comissao').value));
	calcula_parcelas_comissao('valor_comissao','ato_parcelas','comissao_valor_parcela','sim');
}

function campos_ato_comissao(qtd,ato_valor_parcela,comissao_valor_parcela){
	$('#campos_ato').html('');
	$('#campos_comissao').html('');
	total_ato=moedaBrToUsa(ato_valor_parcela)*qtd;
	total_comissao=moedaBrToUsa(comissao_valor_parcela)*qtd;
	$("#total_restante").val(moedaUsaToBR(total_ato.toFixed(2)));
	$("#comissao_restante").val(moedaUsaToBR(total_comissao.toFixed(2)));
	$("#ato_restante").val(moedaUsaToBR(total_ato-total_comissao));
	for(i=0;i<qtd;i++){
		elemento_comissao=$("<label>Parcela Comissão Nº"+(i+1)+"<input onkeyup=\"recalcula_parcelas('comissao_restante','parcela_comissao',"+i+",'faltando_comissao');\" name='parcela_comissao[]' value="+comissao_valor_parcela+" sonumero='1' class='parcela_comissao' type='text' /></label>");
		elemento_ato=$("<label>Parcela Ato Nº "+(i+1)+"<input onkeyup=\"recalcula_parcelas('ato_restante','parcela_ato',"+i+",'faltando_ato');\" name='parcela_ato[]' value="+moedaUsaToBR((moedaBrToUsa(ato_valor_parcela)-moedaBrToUsa(comissao_valor_parcela)))+" sonumero='1' type='text' class='parcela_ato' /></label>");
		elemento_total=$("<label>Parcela Total Nº "+(i+1)+"<input name='parcela_total[]' value="+ato_valor_parcela+" id="+i+" sonumero='1' type='text' class='parcela_total' /></label>");
		$('#campos_ato').append(elemento_ato);
		$('#campos_comissao').append(elemento_comissao);
		$("#campos_total").append(elemento_total);
	}
}
function recalcula_parcelas(id_total,classe_elementos_parcela,num_elemento,destino){
	total = parseFloat(moedaBrToUsa(document.getElementById(id_total).value));
	elementos = document.getElementsByClassName(classe_elementos_parcela);
	acumulado=0;
	for(i=0;i<elementos.length;i++){
		acumulado+=parseFloat(moedaBrToUsa(elementos[i].value));
	}
	if(acumulado>total){
		document.getElementById(destino).innerHTML= 'soma das parcelas ultrapassa total';	
	}
	document.getElementById(destino).innerHTML='restam '+moedaUsaToBR((total-acumulado).toFixed(2));
	comissao=moedaBrToUsa(document.getElementsByClassName('parcela_comissao')[num_elemento].value);
	ato=moedaBrToUsa(document.getElementsByClassName('parcela_ato')[num_elemento].value);
	document.getElementsByClassName('parcela_total')[num_elemento].value=moedaUsaToBR(comissao*1+ato*1);
	
}
function selectNegociacao(t){
	if(t.value>0){
		objs = t.options[t.selectedIndex];
		contrato_valor 				=objs.getAttribute('contrato_valor');
		comissao_valor				=objs.getAttribute('comissao_valor');
		comissao_valor_parcela		=objs.getAttribute('comissao_valor_parcela');
		comissao_porcentagem		=objs.getAttribute('comissao_porcentagem');
		
		ato_valor				=objs.getAttribute('ato_valor');
		ato_porcentagem			=objs.getAttribute('ato_porcentagem');
		ato_parcelas			=objs.getAttribute('ato_parcelas');
		ato_valor_parcela		=objs.getAttribute('ato_valor_parcela');
		ato_juros				=objs.getAttribute('ato_juros');
		
		anuais_valor			=objs.getAttribute('anuais_valor');
		anuais_porcentagem		=objs.getAttribute('anuais_porcentagem');
		anuais_parcelas			=objs.getAttribute('anuais_parcelas');
		anuais_valor_parcela	=objs.getAttribute('anuais_valor_parcela');
		anuais_juros			=objs.getAttribute('anuais_juros');
		
		semestrais_valor			=objs.getAttribute('semestrais_valor');
		semestrais_porcentagem		=objs.getAttribute('semestrais_porcentagem');
		semestrais_parcelas			=objs.getAttribute('semestrais_parcelas');
		semestrais_valor_parcela	=objs.getAttribute('semestrais_valor_parcela');
		semestrais_juros			=objs.getAttribute('semestrais_juros');
		
		mensais_valor			=objs.getAttribute('mensais_valor');
		mensais_porcentagem		=objs.getAttribute('mensais_porcentagem');
		mensais_parcelas		=objs.getAttribute('mensais_parcelas');
		mensais_valor_parcela	=objs.getAttribute('mensais_valor_parcela');
		mensais_juros			=objs.getAttribute('mensais_juros');
		
		chave_valor				=objs.getAttribute('chave_valor');
		chave_porcentagem		=objs.getAttribute('chave_porcentagem');
		chave_parcelas			=objs.getAttribute('chave_parcelas');
		chave_valor_parcela		=objs.getAttribute('chave_valor_parcela');
		chave_juros				=objs.getAttribute('chave_juros');
		
		banco_valor				=objs.getAttribute('banco_valor');
		banco_porcentagem		=objs.getAttribute('banco_porcentagem');
		banco_parcelas			=objs.getAttribute('banco_parcelas');
		banco_valor_parcela		=objs.getAttribute('banco_valor_parcela');
		banco_juros				=objs.getAttribute('banco_juros');
		
		document.getElementById('contrato').value=moedaUsaToBR(contrato_valor);
		document.getElementById('valor_comissao').value=moedaUsaToBR(comissao_valor);
		document.getElementById('qtd_parcelas_comissao').innerHTML='('+moedaUsaToBR(ato_parcelas)+'x)';
		document.getElementById('comissao_valor_parcela').value=moedaUsaToBR(comissao_valor_parcela);
		document.getElementById('porcentagem_comissao').value=moedaUsaToBR(comissao_porcentagem);
		
		document.getElementById('valor_ato').value=moedaUsaToBR(ato_valor);
		document.getElementById('porcentagem_ato').value=moedaUsaToBR(ato_porcentagem);
		document.getElementById('ato_parcelas').value=ato_parcelas;
		document.getElementById('ato_valor_parcela').value=moedaUsaToBR(ato_valor_parcela);
		document.getElementById('ato_juros').value=moedaUsaToBR(ato_juros);
		
		document.getElementById('anuais_total').value=moedaUsaToBR(anuais_valor);
		document.getElementById('porcentagem_anuais').value=moedaUsaToBR(anuais_porcentagem);
		document.getElementById('anuais_parcelas').value=anuais_parcelas;
		document.getElementById('anuais_valor_parcelas').value=moedaUsaToBR(anuais_valor_parcela);
		document.getElementById('anuais_juros').value=moedaUsaToBR(anuais_juros);
		
		document.getElementById('semestrais_total').value=moedaUsaToBR(semestrais_valor);
		document.getElementById('porcentagem_semestrais').value=moedaUsaToBR(semestrais_porcentagem);
		document.getElementById('semestrais_parcelas').value=semestrais_parcelas;
		document.getElementById('semestrais_valor_parcelas').value=moedaUsaToBR(semestrais_valor_parcela);
		document.getElementById('semestrais_juros').value=moedaUsaToBR(semestrais_juros);
		
		document.getElementById('mensais_total').value=moedaUsaToBR(mensais_valor);
		document.getElementById('porcentagem_mensais').value=moedaUsaToBR(mensais_porcentagem);
		document.getElementById('mensais_parcelas').value=mensais_parcelas;
		document.getElementById('mensais_valor_parcelas').value=moedaUsaToBR(mensais_valor_parcela);
		document.getElementById('mensais_juros').value=moedaUsaToBR(mensais_juros);
		
		document.getElementById('valor_chave').value=moedaUsaToBR(chave_valor);
		document.getElementById('porcentagem_chave').value=moedaUsaToBR(chave_porcentagem);
		document.getElementById('chave_parcelas').value=chave_parcelas;
		document.getElementById('chave_valor_parcelas').value=moedaUsaToBR(chave_valor_parcela);
		document.getElementById('chave_juros').value=moedaUsaToBR(chave_juros);
		
		document.getElementById('valor_banco').value=moedaUsaToBR(banco_valor);
		document.getElementById('porcentagem_banco').value=moedaUsaToBR(banco_porcentagem);
		document.getElementById('banco_parcelas').value=banco_parcelas;
		document.getElementById('banco_valor_parcelas').value=banco_valor_parcela;
		document.getElementById('banco_juros').value=moedaUsaToBR(banco_juros);
		
		campos_ato_comissao(ato_parcelas,moedaUsaToBR(ato_valor_parcela),moedaUsaToBR(comissao_valor_parcela));
		
	}
}