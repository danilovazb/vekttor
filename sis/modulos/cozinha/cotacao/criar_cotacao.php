<?php  
	include '_functions.php';
	include '_ctrl.php';
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a><a href="./" class='s1'>
    Cozinha 
</a><a href="?tela_id=45" class='s2'>
  	Cotação
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span> Cotação Produto
</a>
</div>
<style type="text/css" media="all">
thead tr th {text-align:center;border-bottom: 2px solid #999;}
tr th {padding: 1px 6px;font-size: 0.9em;} 
tfoot tr td {text-align:center;border-top: 2px solid #999;}
tr.sub {background:#999;color:#FFF;}
.valor{text-align:right;}
#row{font-weight:500;}
#prod{text-align:left;}
#tabela_dados{ overflow:auto;}
</style>
<script>
$(document).ready(function(){
	$('table#tabela_dados tbody tr:odd').addClass('al');
	//------------------------------------------------
	 
  	$("table .tn").mouseover(function() {
    	$('table .tn').css('color','#000');
  	}).mouseout(function(){
    	$('table .tn').css('color','');
  	});
	
})

$(".valor").live('keyup',function(){
	calculo_item(this);	
})
$(".qtd").live('keyup',function(){
	calculo_item(this);	
})
$(".und").live('change',function(){
	calculo_item(this);	
})

function calculo_item(t){

// compra > embala > usa
//  1 > 30 > 1000

	//valores para base do cálculo
	qtd = moedaBrToUsa($(t.parentNode.parentNode).find(".qtd").val())*1;
	//unidade = $(t.parentNode.parentNode).find(".und").val()*1;
	valor =  moedaBrToUsa($(t.parentNode.parentNode).find(".valor").val())*1;
	unidade2 = $(t.parentNode.parentNode).find(".conversao").val()*1;
	unidade3 = $(t.parentNode.parentNode).find(".conversao2").val()*1;
	unidade_tipo = $(t.parentNode.parentNode).find(".und option:selected").attr("ut");


	//alert(unidade2);
	//alert(unidade_tipo);
	if(unidade_tipo=='compra'){
		
		qtd_unidade 	= (qtd);
		qtd_embalagem 	= (qtd_unidade*unidade2);
		qtd_uso			= (qtd_unidade*unidade3*unidade2);
		
		//alert(qtd_unidade);
		vlr_unidade 	= valor;
		v_embalagem		= (vlr_unidade/unidade2);
		v_embalagem 	= v_embalagem/qtd;
		v_uso			= v_embalagem/unidade3;
	}
	
	if(unidade_tipo=='embalagem'){
		qtd_embalagem 	= (qtd);
		qtd_unidade 	= (qtd/unidade2);
		qtd_uso			= (qtd*unidade3);
		
		v_embalagem		= valor;
		vlr_unidade 	= v_embalagem*unidade2;
		v_uso			= v_embalagem/unidade3;
	}
	//
	if(unidade_tipo=='uso'){
		
		qtd_uso			= (qtd);
		qtd_embalagem 	= (qtd/unidade3);
		qtd_unidade 	= (qtd_embalagem/unidade2);
		
		v_uso			= valor;
		v_embalagem		= v_uso*unidade3;
		//vlr_unidade 	= v_embalagem*unidade3;
		vlr_unidade 	= valor*unidade2*unidade3;
	}
	
	
	v_total =valor*qtd;
	
	qtd_unidade2 	= qtd_unidade.toFixed(2);
	qtd_embalagem2 	= qtd_embalagem.toFixed(2);
	qtd_uso2 		= qtd_uso.toFixed(2);

	vlr_unidade2	= vlr_unidade.toFixed(2);
	v_embalagem2 	= v_embalagem.toFixed(2);
	v_uso2 			= v_uso.toFixed(2);
	

	$(t.parentNode.parentNode).find('.qtd_unidade').html(moedaUsaToBR(qtd_unidade2));
	$(t.parentNode.parentNode).find('.qtd_embalagem').html(moedaUsaToBR(qtd_embalagem2));
	$(t.parentNode.parentNode).find('.qtd_uso').html(moedaUsaToBR(qtd_uso2));
	
	$(t.parentNode.parentNode).find('.v_compra').html(moedaUsaToBR(vlr_unidade2)) ;
	$(t.parentNode.parentNode).find('.v_embalagem').html(moedaUsaToBR(v_embalagem2)) ;
	$(t.parentNode.parentNode).find('.v_uso').html(moedaUsaToBR(v_uso2)) ;
	
	
	$(t.parentNode.parentNode).find('.v_total').html(moedaUsaToBR(v_total.toFixed(2)));
	valor_total =0;
	$(t.parentNode.parentNode.parentNode).find('.v_total').each(function(){
		valor_total += (moedaBrToUsa($(this).html()))*1;
	})
	
	$('#valor_total').html(moedaUsaToBR(valor_total.toFixed(2)));
	
	
}
function direciona(t){
	qtd=moedaBrToUsa($(t.parentNode.parentNode).find(".qtd").val())*1;
	unidade = $(t.parentNode.parentNode).find(".und").val();
	vlr = moedaBrToUsa($(t.parentNode.parentNode).find(".valor").val());
	conversao = $(t.parentNode.parentNode).find(".conversao").val()*1;
	conversao2 = $(t.parentNode.parentNode).find(".conversao2").val()*1;
	produto_id=$(t).parent().parent().find(".produto_id").val();
	marca=$(t).parent().parent().find(".marca").val();
	compra_id=$("#compra_id").val();
	pedido_id=$("#pedido_id").val();
	cont = $(t.parentNode.parentNode).find('.item').attr('id');
	item_id=$(t.parentNode.parentNode).find(".item").text();
	produto_id=$(t.parentNode.parentNode).find(".produto_id").val();
	item_necess_id=$(t.parentNode.parentNode).find(".item_necessidade_id").val();
	cotacao_id=<? if(!empty($cotacao)){echo $cotacao->id;}else{echo $novacotacao;}?>
	
	unidade_tipo = $(t.parentNode.parentNode).find(".und option:selected").attr("ut");
	
	url='modulos/cozinha/cotacao/atualiza_valores.php?cotacao_id=<?=$cotacao_id?>&qtd='+qtd+'&unidade='+unidade+'&valor='+vlr+'&conversao='+conversao+'&conversao2='+conversao2+'&marca='+marca+'&cont='+cont+'&item_id='+item_id+'&necessidade_id=<?=$necessidade_id?>&necessidade_item_id='+item_necess_id+'&produto_id='+produto_id+'&acao=alterar&unidade_tipo='+unidade_tipo;
	//alert(url);
	window.open(url,'carregador');
}

function funcao_bsc2(resultado,acao,origem){	
	actions_W= acao.split('|');
	//alert(actions_W);
//	document.title=resultado.innerHTML+','+resultado.getAttribute('r0')+','+resultado.getAttribute('r1')+','+resultado.getAttribute('r2')+','+acao+','+origem+','+actions_W.length;
	
	//document.getElementById(origem).value=resultado.getAttribute('r0');
	
	for(w=0;w<actions_W.length;w++){
		vlores_e_locais = actions_W[w].split("-");
		local_e_acao = vlores_e_locais[1].split('>');
		
		valor = vlores_e_locais[0].replace(/@/g,'');
		local = local_e_acao[0];
		acao_W  = local_e_acao[1];
		
		if(local=='innerHTML'){
			document.getElementById(acao_W).innerHTML=resultado.getAttribute(valor);
		}else if(local=='value'){
			document.getElementById(acao_W).setAttribute('value',resultado.getAttribute(valor));
			document.getElementById(acao_W).value=resultado.getAttribute(valor);
		}else{
			document.getElementById(acao_W).setAttribute(local,resultado.getAttribute(valor));
		}
	}
	/*--------- funcoes para pegar valor e enviar a requisicao para o servidor via ajax ----------------------*/
	var produto_id    = $("#busca_produto_id").val();
	
	var fornecedor_id = $("#fornecedor_id").val();
	//linha = $("<tr><td>"+nome+"</td><td></td> <td></td> <td></td> <td></td> </tr>");ocorrencia	
	//linha.appendTo("#tbody");
	//alert(produto_id);
	$("#produto_id").val('');
	$("#busca_produto_id").val('');
	$("#busca_produto").val('');
	

		var dados = 'produto_id='+produto_id+'&necessidade_id=<?=$necessidade_id?>&acao=criar_cotacao'
						//alert(dados);
						$.ajax({
							url: 'modulos/cozinha/cotacao/adiciona_produto.php', 
							dataType: 'html',
							type: 'POST',
							data: dados,
							success: function(data, textStatus) {
								
								$('#tbody').append(data);
								$("tr:odd").addClass('al');
							},
						}); /* Fim Ajax*/
					
}
function removeItem(t){
	//alert(t);
	id=$(t.parentNode.parentNode).find('.item').text();
	vlr=moedaBrToUsa($(t.parentNode.parentNode).find('.v_total').text())*1;
	total=moedaBrToUsa($('#valor_total').text());
	total -=vlr;
	total=total.toFixed(2);
	$(t.parentNode.parentNode).find('.v_total').text('0,00');
	$(t.parentNode.parentNode).find('.valor').val('');
	$(t.parentNode.parentNode).find('.qtd').val('');
	//$(t.parentNode.parentNode).find('td').remove();
	url='modulos/cozinha/cotacao/atualiza_valores.php?acao=excluir&id='+id;
	window.open(url,'carregador');
	$('#valor_total').text(moedaUsaToBR(total));
	//alert(id);
}

$(".qtd, .obs").live('keyup',function(){

	var id  = $(this).parent().parent().find("#produto_necessidade_id").val();
	var produto_id = $(this).parent().parent().find("#produto_id").val();
	var qtd = $(this).parent().parent().find(".qtd").val();
	var obs = $(this).parent().parent().find(".obs").val();
	
	
	
	var dados = 'produto_necessidade_id='+id+'&qtd='+qtd+'&obs='+obs+'&acao=edita_produto_cotacao&produto_id='+produto_id;
	
	$.ajax({
		url: 'modulos/cozinha/cotacao/adiciona_produto.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
		success: function(data, textStatus) {
						
			$('#tbody').append(data);
			$("tr:odd").addClass('al');
		},
	});

});
</script>
<div id="barra_info">

<form method="post">
<input type="button" value="<<" onclick="location.href='?tela_id=118&necessidade_id=<?=$necessidade_id?>&cotacao_id=<?=$cotacao_id?>'" style="margin-top:3px;">

<input type="hidden" name="busca_produto_id[]" id="busca_produto_id" value="">
<input type="text" id='busca_produto' onkeyup="return vkt_ac(this,event,'0','modulos/cozinha/cotacao/busca_produto.php','@r0','funcao_bsc2(this,\'@r1-value>busca_produto_id\',\'produto\')')"
   autocomplete='off' name="produto" value=""  valida_minlength="3"  style='width:170px;height:10px;font-size:11px;' retorno='focus|Coloque no minimo 3 caracter' <? if(($pedido->status=='Finalizado')||($pedido->status=='cancelado')){echo "disabled='disabled'";}?> />
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%" style="overflow:auto;" >
<thead>
    	<tr>
          <td width="200"><?=linkOrdem("Produto","nome",1)?></td>
          <td width="60">Qtd</td>
          <td width="190">Obs</td>
          <td></td>
      </tr>
    </thead>
</table>
<div id='dados' style="overflow:auto;">
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" style="overflow:auto;">
	<tbody id="tbody">
    	
        <tr>
        </tr>
       
     </tbody>
</table>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->

</div>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="90"></td>
          <td width="70"></td>
          <td width="45"></td>
          <td width="45"></td>
          <td width="80"></td>
          <td width="60"></td>
          <td width="50"></td>
          <td width="60"></td>
          <td width="50"></td>
          <td width="50"></td>
          <td width="50"></td>
          <td width="50"></td>
          <td width="50" align="right">Total: </td>
          <td width="50" id='valor_total' ><?=moedaUsaToBr($soma);?></td>
          <td></td>
        </tr>
    </thead>
</table>
</div>

<div id='rodape'>
As altera&ccedil;oes serao salvas automaticamente ao digitar no  campo
</div>
<script>
// Fecha aba de menu

		$("#menu").animate({
			'marginLeft': -210,
			
		  }, 0);
		$("#conteudo").animate({
			'marginLeft': 10
		  }, 0);
		$("#rodape").animate({
			'marginLeft': 10
		  }, 0);
				   $("#some").html("&raquo;")

////

</script>