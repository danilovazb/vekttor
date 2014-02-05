$(function(){
	
	function MontaParcela(){
		var json = { 
		  qtdParcela:$("#quantidade_parcelas").val(),
		  data_parcela:$("#data_parcela").val(),
		  ValTotal:$("#valor_total").val()
		}
		
		if( $.trim(json.qtdParcela) != "" && $.trim(json.data_parcela) != "" )
			CriarParcelas(json);
	}
	
	$("#data_parcela").live("blur",function(){ MontaParcela(); });
	
	$("#quantidade_parcelas").live("blur",function(){ MontaParcela(); });
	
	$("#valor_total").live("blur",function(){ MontaParcela(); });
	
});

function CriarParcelas(json){
	var ValorParcela = ( parseFloat(moedaBrToUsa(json.ValTotal)) / parseInt(json.qtdParcela));
	
	$("#valor_parcela-1").val(moedaUsaToBR(ValorParcela.toFixed(2)));
	
	if( $.trim(json.qtdParcela) > 1 ){
		
		var $input = "";
		var dias = 0;
		var contador = 0;
		var DateVencimento = json.data_parcela.split("/");
		
		for(i = 0; i < json.qtdParcela - 1; i++){
		  //dias += 30;
		  contador++;
		  var dados = { funcao:"calculaDataParcela",dataParcela:json.data_parcela, contador:contador};
		   $.ajax({
				type:"POST",
				data:dados,
				url:"modulos/rh/venda_funcionario/ajax.php",
				success: function(data){
					
					 $input += ""+ 
					  "<label style='width:110px;'>"+
						"<input type='text' name='data_parcela[]' mascara='__/__/____' value='"+(data)+"' >"+ 
					  "</label>"+ 
					  "<label style='width:100px;'>"+ 
						"<input type='text' name='valor_parcela[]' value='"+moedaUsaToBR(ValorParcela.toFixed(2))+"'>"+ 
					  "</label>"+
					  "<div style='clear:both'></div>";
						
				}, complete: function(){
					$("#resultParcela").html($input);	
				}
		   });
		}
			
		
			
	} else{}
		
}