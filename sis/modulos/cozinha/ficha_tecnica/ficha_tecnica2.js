// JavaScript Document
function addProduto(t){
	if(t.getAttribute('src')=='../fontes/img/mais.png'){
		//copia o elemento modelo
		div_subplano = t.parentNode.parentNode.cloneNode(1);
		
		
		/* pega o numero da linha */
		inputs_plano_superior = t.parentNode.parentNode.getElementsByTagName('input');
		numero_linha = inputs_plano_superior[0].value*1;
		novo_numero=numero_linha+1;
		
		/***** atribui a coloração *****/
		nova_class = (t.parentNode.parentNode.className=='al')?'':'al';
		div_subplano.className=nova_class+' produto_item';
		/***** pega os elementos para manipulação *****/
		inputs = div_subplano.getElementsByTagName('input');
		spans=div_subplano.getElementsByTagName('span');
		
		/***** incrementa para nao haver repeticao de IDS *****/
		spans[0].setAttribute('id','produto_valor'+novo_numero);
		inputs[1].setAttribute('id','produto_id'+novo_numero);
		inputs[2].setAttribute('id','produto'+novo_numero);
		
		
		/* implementa a função */
		inputs[2].setAttribute('busca','modulos/cozinha/ficha_tecnica/busca_materia_prima.php,@r0,@r1-value>produto_id'+novo_numero+'|@r2-innerHTML>produto_valor'+novo_numero+',0');
		/***** zera os valores *****/
		inputs[2].setAttribute('onkeyup','');
		spans[0].innerHTML='';
		spans[1].innerHTML='';
		inputs[0].value=numero_linha+1;
		inputs[1].value='';
		inputs[2].value='';
		inputs[3].value='';
		
		/***** corre pro abraço *****/
		insertAfter(div_subplano,t.parentNode.parentNode);
		t.src='../fontes/img/menos.png';
		cont++;
	}else{
		//pega as informações
		spans= t.parentNode.parentNode.getElementsByTagName('span');
		inputs= t.parentNode.parentNode.getElementsByTagName('input');
		//pega os valores de quantidades
		total_qtd=parseFloat(moedaBrToUsa(document.getElementById('total_qtd').innerHTML));
		total_qtd_produto=parseFloat(moedaBrToUsa(inputs[3].value));
		//exibe a resultado do total - qtd retirada
		document.getElementById('total_qtd').innerHTML=moedaUsaToBR(total_qtd-total_qtd_produto);
		//pega os valores de preços
		total=parseFloat(moedaBrToUsa(document.getElementById('total').innerHTML.replace('R$','')));
		total_produto=parseFloat(moedaBrToUsa(spans[1].innerHTML.replace('R$','')));
		//exibe o resultado do valor total - preço total do produto
		document.getElementById('total').innerHTML=('R$'+moedaUsaToBR(total-total_produto));
		t.parentNode.parentNode.parentNode.removeChild(t.parentNode.parentNode);
	}
}

function calculaTotal(t){
	tr =t.parentNode.parentNode;
	tbody=t.parentNode.parentNode.parentNode;
	totais=tbody.getElementsByTagName('tr');
	vlr=0;
	vlr_qtd=0;
	
	if(tr.getElementsByTagName('input')[1].value==''){
		alert('Por favor, escolha 1 produto');
		t.value='';
		t.blur();
	}else{
		qtd_peso=moedaBrToUsa(t.value);
		qtd=moedaBrToUsa(tr.getElementsByTagName('input')[3].value);
		valor=(tr.getElementsByTagName('span')[0].innerHTML).replace(',','.');
		total=moedaUsaToBR((qtd*valor).toFixed(2));
		
		tr.getElementsByTagName('span')[1].innerHTML='R$'+total;
		var soma_qtd=0;
		$.each($(".produto_qtd"),function(){
			soma_qtd += parseFloat(moedaBrToUsa($(this).val().replace('R$','')));
		})
		var soma_valor_total=0;
		$.each($(".produto_total_valor"),function(){
			soma_valor_total += parseFloat(moedaBrToUsa($(this).text().replace('R$','')));
		})
		
		$("#total").text("R$"+moedaUsaToBR(soma_valor_total.toFixed(2)));
		$("#total_qtd").text(moedaUsaToBR(soma_qtd));
	}		
}

function calculaPerCapta(total, percapta, destino){
	peso_total = moedaBrToUsa(document.getElementById(total).value);
	peso_percapta = moedaBrToUsa(percapta.value);
	
	if(peso_total!=null&&peso_total>0){
		if(peso_percapta!=null&&peso_percapta>0){
			resultado= (peso_total/peso_percapta);
			document.getElementById(destino).innerHTML=moedaUsaToBR(resultado.toFixed(2));
		}
	}
	
}


function adicionaGrupo(t){
		
		
		if($(t).attr('src')=='../fontes/img/mais.png'){
			
			var interior_grupo = $(t).parent().parent().clone(1);
			var linha_pra_adicionar = $("<tr>"+interior_grupo.html()+"</tr>"); linha_pra_adicionar.addClass('grupo');
			$(t).parent().parent().find('td.nome_grupo').html("<input class='adiciona_grupo' type='text' style='height:9px;' />");
			$(t).parent().parent().find('.adiciona_grupo').focus();
			
			
			input_grupo = ($(t).parent().parent().find('.adiciona_grupo'));
			input_grupo.blur(function(){
				if($(this).val()==''){
					$(t).attr('src','../fontes/img/mais.png');
					$(t).parent().parent().find('td.nome_grupo').html("Adicionar Grupo");
					var interior_grupo=null;
					var linha_pra_adicionar=null;
					return null;
				}
			})
			//muda o sinal para -
			$(t).attr('src','../fontes/img/menos.png');
			
			//adiciona a ação de incluir a linha ao apertar ENTER
			$(document).live('keyup',function(e){
				if(e.which==13){
					
					//copia a ultima linha
					var ultima_linha = $(t).parent().parent().prev(".produto_item");
					var nova_linha = $("<tr>"+ultima_linha.html()+"</tr>");
					
					//pega o numero da ultima linha e adiciona 100 para nao haver conflito entre ids
					numero_ultima_linha = ultima_linha.find('.numero_da_linha').val();
					novo_numero_linha= parseInt(numero_ultima_linha)+100;
					nova_linha.find('.numero_da_linha').val(novo_numero_linha);
					nova_linha.addClass('produto_item');
					
					//zera todos os campos da linha
					nova_linha.find('.produto_id').attr('id','produto_id'+novo_numero_linha);
					nova_linha.find('.produto_nome').attr('id','produto'+novo_numero_linha);
					nova_linha.find('.produto_nome').attr('onblur','');
					nova_linha.find('.produto_nome').attr('onkeyup','');
					nova_linha.find('.produto_valor').attr('id','produto_valor'+novo_numero_linha);
					nova_linha.find('.produto_nome').attr('busca',"modulos/cozinha/ficha_tecnica/busca_materia_prima.php,@r0,@r1-value>produto_id"+novo_numero_linha+"|@r2-innerHTML>produto_valor"+novo_numero_linha+",0");
					input_novo_valor = $(t).parent().parent().find('.adiciona_grupo').val();
					$(t).parent().parent().find('td.nome_grupo').html(input_novo_valor);
					
					//ultima_linha.remove();
					$(document).unbind('keyup');
					//colocar o nome do grupo na linha
					nova_linha.find('.grupo_item').val(input_novo_valor);
					
					$(t).parent().parent().after(nova_linha);
					linha_pra_adicionar.appendTo($(t).parent().parent().parent());
				}
			})
		}else{
			if($('.grupo').length>1){
				var soma_grupo_valor=0;
				var soma_grupo_qtd=0;
				var grupo_retirado= $(t).parent().parent().find('td.nome_grupo').text();
				
				var grupos = $(".grupo_item[value='"+grupo_retirado+"']");
				$.each(grupos,function(){
					soma_grupo_valor += parseFloat(moedaBrToUsa($(this).parent().parent().find('.produto_total_valor').text().replace('R$','')));
					soma_grupo_qtd += parseFloat(moedaBrToUsa($(this).parent().parent().find('.produto_qtd').val()));
				})
				
				total = parseFloat(moedaBrToUsa($("#total").text().replace('R$','')));
				total_qtd = parseFloat(moedaBrToUsa($("#total_qtd").text()));
				$("#total").text('R$'+moedaUsaToBR(total-soma_grupo_valor));
				$("#total_qtd").text(moedaUsaToBR(total_qtd-soma_grupo_qtd));
				$(t).parent().parent().parent().find(".grupo_item[value='"+grupo_retirado+"']").parent().parent().remove();
				$(t).parent().parent().remove()	
			}
		}
}