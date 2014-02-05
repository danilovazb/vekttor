// JavaScript Document
function calc_parcela(){
	d =top.document;
	valor_contrato 			= moedaBrToUsa(d.getElementById('valor_total').value);
	valor_entrada 			= moedaBrToUsa(d.getElementById('valor_entrada').value);
	quantidade_parcelas 	= moedaBrToUsa(d.getElementById('parcelas').value);
	valor_parcela			= moedaBrToUsa(d.getElementById('valor_parcela').value);
	
	
	//alert(valor_contrato+' | '+valor_entrada+' | '+quantidade_parcelas);
	if(valor_contrato>0&&quantidade_parcelas>0){
		valor_negociado = valor_contrato-valor_entrada;
		valor_parcela =valor_negociado/quantidade_parcelas;
		novo_valor_parcela = moedaUsaToBR(valor_parcela.toFixed(2));
		
		
		if(valor_parcela==valor_parcela||valor_parcela==0){
			d.getElementById('valor_parcela').value=novo_valor_parcela;
		}
		
	}
	calc_parcelas_penentes();
}

function calc_parcelas_penentes(){
	d =top.document;
	parcelas 			= d.getElementById('parcelas').value*1;
	parcelas_pagas 		= d.getElementById('parcelas_pagas').value*1;
	valor_total_pago	= moedaBrToUsa(d.getElementById('valor_total_pago').value);

	parcelas_pendentes 	= parcelas-parcelas_pagas;
	
	d.getElementById('parcelas_pendentes').value=parcelas_pendentes;
	
	if(valor_total_pago>0){
			valor_parcela_paga = valor_total_pago/parcelas_pagas;
		
		d.getElementById('valor_parcela_paga').value=moedaUsaToBR(valor_parcela_paga.toFixed(2));
		
	}
	
	
}

function calc_total_parcelado(){
	d =top.document;
	valor_parcela_paga	= moedaBrToUsa(d.getElementById('valor_parcela_paga').value);
	parcelas_pagas 		= d.getElementById('parcelas_pagas').value*1;
	
	if(parcelas_pagas>0&&valor_parcela_paga){
		valor_total_pago	=valor_parcela_paga*parcelas_pagas;
		d.getElementById('valor_total_pago').value= moedaUsaToBR(valor_total_pago.toFixed(2));
	}
	
}
