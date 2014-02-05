// JavaScript Document

//CAMINHO : modulos/administrativo/empreendimentos/negociacao/negociacao.js
function vt(){
	return document.getElementById('valor').value;
}
function ct(){
	return document.getElementById('mostra_contrato').value;
}
function rt(){
	return document.getElementById('restante').value;
}

function valor_porcento(valor_total,valor_parcial,destino){
	valor_total = moedaBrToUsa(valor_total);
	valor_parcial = moedaBrToUsa(valor_parcial);
	porcentagem = (valor_parcial/valor_total)*100;
	
	if(document.getElementById('tipo_id').value==''){
		document.getElementById('alerta').style.display='';
	}else{
		document.getElementById('alerta').style.display='none';
		document.getElementById(destino).value=moedaUsaToBR(porcentagem.toFixed(2));
	}
	
	
	
}

function porcento_valor(valor_total,porcentagem,destino){
	valor_total = moedaBrToUsa(valor_total);
	porcentagem = moedaBrToUsa(porcentagem);
	
	valor_final_percentual = (valor_total*(porcentagem/100));
	
	document.getElementById(destino).value=moedaUsaToBR(valor_final_percentual.toFixed(2));
	
}

function calcula_banco(){
	p_entrada = moedaBrToUsa(document.getElementById('porcentagem_ato').value);
	p_construtora = moedaBrToUsa(document.getElementById('porcentagem_chave').value);
	v_entrada = moedaBrToUsa(document.getElementById('valor_ato').value);
	v_construtora = moedaBrToUsa(document.getElementById('valor_chave').value);
	v_total = moedaBrToUsa(document.getElementById('valor').value);
	
	
	document.getElementById('valor_banco').value = moedaUsaToBR(v_total-v_entrada-v_construtora);
	document.getElementById('porcentagem_banco').value = moedaUsaToBR(100-p_construtora-p_entrada);
	
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
	
	document.getElementById('valor_banco').value = moedaUsaToBR((valor_total-valor_entrada-valor_anuais-valor_semestrais-valor_mensais-valor_chave).toFixed(2));
	document.getElementById('restante').value = moedaUsaToBR(((valor_total-valor_entrada-valor_anuais-valor_semestrais-valor_mensais-valor_chave).toFixed(2)));
	document.getElementById('porcentagem_banco').value = moedaUsaToBR((100-p_chave-p_entrada-p_anuais-p_semestrais-p_mensais).toFixed(2));
}

function calcula_contrato(){
	document.getElementById('contrato').value= moedaBrToUsa(document.getElementById('valor').value)-moedaBrToUsa(document.getElementById('valor_comissao').value);
	document.getElementById('mostra_contrato').value= moedaUsaToBR(moedaBrToUsa(document.getElementById('valor').value)-moedaBrToUsa(document.getElementById('valor_comissao').value));
	calcula_parcelas_comissao('valor_comissao','ato_parcelas','comissao_valor_parcela','sim');
	
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
		//alert(destino);
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
			//document.title =montante+' > '+montate_parcelado;
			resultado = moedaUsaToBR(montate_parcelado.toFixed(2));
			if(montante==0){ resultado=0; }
			//console.log(montate_parcelado);
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
	
	ato_porcentagem = moedaBrToUsa(document.getElementById('porcentagem_ato').value);
	ato_valor = valor_total_emp*(ato_porcentagem/100);
	document.getElementById('valor_ato').value = moedaUsaToBR(ato_valor.toFixed(2));
	
	calcula_parcelas('valor_ato','ato_parcelas','ato_juros','ato_valor_parcela');
	
	anuais_porcentagem = moedaBrToUsa(document.getElementById('porcentagem_anuais').value);
	anuais_valor = valor_total_emp*(anuais_porcentagem/100);
	document.getElementById('anuais_total').value = moedaUsaToBR(anuais_valor.toFixed(2));

	calcula_parcelas('anuais_total','anuais_parcelas','anuais_juros','anuais_valor_parcelas');
	
	semestrais_porcentagem =  moedaBrToUsa(document.getElementById('porcentagem_semestrais').value);
	semestrais_valor = valor_total_emp*(semestrais_porcentagem/100);
	document.getElementById('semestrais_total').value = moedaUsaToBR(semestrais_valor);
	
	calcula_parcelas('semestrais_total','semestrais_parcelas','semestrais_juros','semestrais_valor_parcelas');
	
	mensais_porcentagem = moedaBrToUsa(document.getElementById('porcentagem_mensais').value);
	mensais_valor = valor_total_emp*(mensais_porcentagem/100);
	document.getElementById('mensais_total').value = moedaUsaToBR(mensais_valor.toFixed(2));

	calcula_parcelas('mensais_total','mensais_parcelas','mensais_juros','mensais_valor_parcelas');

	chave_porcentagem =  moedaBrToUsa(document.getElementById('porcentagem_chave').value);
	chave_valor = valor_total_emp*(chave_porcentagem/100);
	document.getElementById('valor_chave').value = moedaUsaToBR(chave_valor.toFixed(2));

	calcula_parcelas('valor_chave','chave_parcelas','chave_juros','chave_valor_parcelas');
	
	banco_porcentagem =  moedaBrToUsa(document.getElementById('porcentagem_banco').value);
	banco_valor = valor_total_emp*(banco_porcentagem/100);
	document.getElementById('valor_banco').value = moedaUsaToBR(banco_valor.toFixed(2));
	
	calcula_parcelas('valor_banco','banco_parcelas','banco_juros','banco_valor_parcelas');
	if(parseFloat(document.getElementById('valor_comissao').value)>0){
		aparecer='sim';
	}else{
		aparecer='nao';
	}
	
	porcento_valor(vt(),document.getElementById('porcentagem_comissao').value,'valor_comissao');
	
	calcula_parcelas_comissao('valor_comissao','ato_parcelas','comissao_valor_parcela',aparecer);
	calcula_contrato();
}

function moedaBrToUsa(v){
	nv = v+'';
	nv = nv.replace(/\./g,'');
	nv = nv.replace(/,/g,'.')*1;
	return nv.toFixed(2);
	
}
function moedaUsaToBR(v){
	nv = v+'';
	nv = nv.replace(/ /g,'');
	nv = nv.replace(/,/g,'');
	nv = nv.replace(/\./g,',');
	
	separa = nv.split(',');
	valor = separa[0];
	if(separa.length<2){
		decimal = '00';
	}else{
		decimal = separa[1];
	}
	tamanho_valor=valor.length;
	if(tamanho_valor<4){
		valor_final = valor+','+decimal;
	}
	if(tamanho_valor>3&&tamanho_valor<7){
		valor_final = valor.substr(0,tamanho_valor-3)+'.'+valor.substr(tamanho_valor-3,3)+','+decimal;
	}else if(tamanho_valor>6&&tamanho_valor<10){
		valor_final = valor.substr(0,tamanho_valor-6)+'.'+valor.substr(tamanho_valor-6,3)+'.'+valor.substr(tamanho_valor-3,3)+','+decimal;
	}else{
		valor_final = nv;
	}
	
	
	return valor_final;
}

