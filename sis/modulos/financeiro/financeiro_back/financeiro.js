function addPlc(t){
	if(t.getAttribute('src')=='../fontes/img/mais.png'){
		div_subplano = document.createElement("div");// cria uma div
		div_subplano.setAttribute('style',t.parentNode.getAttribute('style'));
		div_subplano.innerHTML= t.parentNode.innerHTML;
		insertAfter(div_subplano,t.parentNode);
		t.src='../fontes/img/menos.png';
	}else{
		t.parentNode.parentNode.removeChild(t.parentNode)
	}
}
  
function calc_plano_centro_porcentagem(t){
	jsValorCadastro= moedaBrToUsa(document.getElementById('valor_cadastro').value);
	porcentagem=moedaBrToUsa(t.value);
	calculo =jsValorCadastro*(porcentagem/100);
	t.parentNode.parentNode.getElementsByTagName('input')[0].value=moedaUsaToBR(calculo.toFixed(2));
	
	
	
}

function calc_plano_centro_valor(t){
	jsValorCadastro= moedaBrToUsa(document.getElementById('valor_cadastro').value);
	valore=moedaBrToUsa(t.value);

	calculo =(valore/jsValorCadastro)*100;
	t.parentNode.parentNode.getElementsByTagName('input')[1].value=moedaUsaToBR(calculo.toFixed(2));
	
	
	
}

function confirma_calculor(){
	centros = document.getElementById('centro_de_custos').getElementsByTagName('div');
	planos = document.getElementById('plano_de_contas').getElementsByTagName('div');
	nome_internauta =document.getElementById('internauta_id').getAttribute('title');
	nome_cliente	=document.getElementById('cliente').value;

	jsvalor_cadastrado = moedaBrToUsa(document.getElementById('valor_cadastro').value)*1;
	
	valor_centros = 0;
	
	for(i=0;i<centros.length;i++){
		valor_campos = moedaBrToUsa(centros[i].getElementsByTagName('input')[0].value)*1;
		valor_centros=valor_centros+valor_campos;
	}
	diferenca1 =jsvalor_cadastrado-valor_centros;
	
	valor_planos = 0;
	
	for(i=0;i<planos.length;i++){
		valor_campos = moedaBrToUsa(planos[i].getElementsByTagName('input')[0].value)*1;
		valor_planos=valor_planos+valor_campos;
	}
	diferenca2 =jsvalor_cadastrado-valor_planos;

	erro=0;
		mensagem='';
	if(diferenca1>0.02){
		erro++;
		mensagem=mensagem+"O Total dos Centros de Custos não coincidem com o valor cadastrado\n";
	}
	if(diferenca2>0.02){
		erro++;
		mensagem=mensagem+"O Total dos Planos de Contas não coincidem com o valor cadastrado\n";
	}
	if(document.getElementById('efetivar_movimento').checked==true){
		if(document.getElementById('conta_id').value==0){
			erro++;
			mensagem=mensagem+"Selecione uma conta para efetivar a movimentação\n";
		}
	}
	
	if(nome_internauta!=nome_cliente){
		erro++;
		mensagem=mensagem+"O nome Selecionado é diferente informado "+nome_internauta+" ! "+nome_cliente+"\n";
		
	}
	
	if(erro==0){
		if(validaForm(document.getElementById('form_movimento_caixa'))){
			document.getElementById('form_movimento_caixa').submit();
		}
		
	}else{
		alert(mensagem);
	}
}

function populaSelect(id){
	var lista= document.getElementById(id);
	
}

$(".deldoc").live("click",function(){
	
	identificador	= $(this).attr("identificador");
	tipo			= $(this).attr("tipo");
	extencao		= $(this).attr("extencao");
	url = 'modulos/financeiro/deleta_arquivos.php?movimento_id='+identificador+'&tipo='+tipo+'&extencao='+extencao
	if(confirm('Você irá deletar o arquivo')){
		$(this).parent().hide();
		$('#'+tipo).show();
		window.open(url,'carregador');
	}
})


function confirma_transferencia(){
  if(confirm('Confirma Transferencia')){
	  conta_id_destino=document.getElementById('conta_id_destino').value; 
	  conta_id_origem=document.getElementById('conta_id_origem').value;
	  valor_transferido=document.getElementById('valor_transferido').value; 
	  
	  if(conta_id_destino*1>0&&conta_id_origem*1>0&&valor_transferido.length>=3&&conta_id_destino!=conta_id_origem){
	  	document.getElementById('form_transferencia_entre_contas').submit();
	  }else{
		  alert('Preencha as informações corretamente');
	  }
  }
}
function co(t,i){
	
	if(t.checked){
		consilia_desconsilia = 1;	
	}else{
		consilia_desconsilia = 0;	
	}
	d= Date();
	url ="modulos/financeiro/consilia_desconsilia.php?movimento_id="+i+"&consilia_desconsilia="+consilia_desconsilia+"&"+d;
	window.open(url,'carregador');
}
