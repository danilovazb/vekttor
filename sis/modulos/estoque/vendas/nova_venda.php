<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.qtd{width:50px;height:12px;text-align:right}
.vlr{width:50px;height:12px;text-align:right}
.marca{height:12px; width:55px;}
.cz{ color:#999999}
.alert-input {background-color: pink;}
</style>
<script>
//moedaBrToUsa
//moedaUsaToBR
$(document).ready(function(){
	$("#busca_produto").focus();
	$("#dados tr:nth-child(2n+1)").addClass('al');
	
})

$(".qtd").live('keyup',function(){
	calculo_compra(this);	
})

function calculo_compra(t){

	qtd = qtdBrToUsa($(t.parentNode.parentNode).find(".qtd").val(),3)*1;
	valor =  moedaBrToUsa($(t.parentNode.parentNode).find(".vlr").text())*1;
	v_total=valor*qtd;
	v_total=moedaUsaToBR(v_total.toFixed(2));
	
	$(t.parentNode.parentNode).find('.v_total').html(v_total);
		
	total=0;
	$(t.parentNode.parentNode.parentNode).find('.v_total').each(function(){
		valor=(moedaBrToUsa($(this).html())*1)		
		//alert(valor);
		total += valor;
		//alert(total);
	})
	total=moedaUsaToBR(total.toFixed(2));
	$('#vlrtotal').html(total);
	
}

$(".qtd").live('keyup',function(){
	calculo_compra(this);	
})

$(".vlr").live('keyup',function(){
	calculo_compra(this);	
})

$(".und").live('change',function(){
	calculo_compra(this);	
})

function direciona(t){
	//qtd=t.value;

	qtd=moedaBrToUsa($(t.parentNode.parentNode).find(".qtd").val())*1;
	
	//unidade = $(t.parentNode.parentNode).find(".und").val();
	//vlr=$(t).parent().parent().find(".vlr").val();
	vlr = moedaBrToUsa($(t.parentNode.parentNode).find(".vlr").html())*1;
	conversao=moedaBrToUsa($(t).parent().parent().find(".conversao").val())*1;
	//conversao = $(t.parentNode.parentNode).find(".conversao").val()*1;
	//conversao2 = $(t.parentNode.parentNode).find(".conversao2").val()*1;
	produto_id=$(t).parent().parent().find(".produto_id").val();
	marca=$(t).parent().parent().find(".marca").html();
	compra_id=$("#compra_id").val();
	pedido_id=$("#pedido_id").val();
	cont = $(t.parentNode.parentNode).find('.item').attr('id');
	//pedido_item=$(t.parentNode.parentNode).find(".pedido_item").val();
	item_id=$(t.parentNode.parentNode).find(".item").text();
	
	url='<?=$caminho?>atualiza_valores.php?pedido_id='+pedido_id+'&produto_id='+produto_id+'&qtd='+qtd+'&conversao='+conversao+'&valor='+vlr+'&marca='+marca+'&cont='+cont+'&item_id='+item_id+'&acao=alterar';
	console.log(url);
	window.open(url,'carregador');
}

function atualiza_pedido(ocorrencia){
	var ocorrencia_pedido = document.getElementById("ocorrencia_pedido").value;
	var ocorrencia_chegada = document.getElementById("ocorrencia_chegada").value;
	var ocorrencia_chegada = document.getElementById("ocorrencia_chegada").value;
	//alert(ocorrencia);
	url='<?=$caminho?>atualiza_venda.php?cliente_id=<?=$_GET['cliente_id']?>&venda_id=<?=$venda_id?>&ocorrencia_pedido='+ocorrencia_pedido+'&ocorrencia_chegada='+ocorrencia_chegada;
	//alert(url);
	window.open(url,'carregador');
}

function funcao_bsc2(resultado,acao,origem){	
	actions_W= acao.split('|');
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
	var cliente_id = $("#cliente_id").val();
	var total=moedaBrToUsa($('#vlrtotal').text());
	//linha = $("<tr><td>"+nome+"</td><td></td> <td></td> <td></td> <td></td> </tr>");ocorrencia	
	//linha.appendTo("#tbody");
	//alert(produto_id);
	$("#produto_id").val('');
	$("#busca_produto_id").val('');
	$("#busca_produto").val('');
	
		var dados = 'produto_id='+produto_id+'&cliente_id=<?=$cliente_id?>&venda_id=<?=$venda_id?>&total='+total;
						//alert(dados);
						$.ajax({
							url: 'modulos/estoque/vendas/adiciona_produto.php', 
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
	total=moedaBrToUsa($('#vlrtotal').text());
	total -=vlr;
	total=total.toFixed(2);
	$(t.parentNode.parentNode).find('td').remove();
	url='modulos/estoque/vendas/atualiza_valores.php?acao=excluir&id='+id;
	window.open(url,'carregador');
	$('#vlrtotal').text(moedaUsaToBR(total));
	//alert(id);
}


/*
 * SCRIPT PARA FORMA DE PAGAMENTO E PARCELAS 
 */
var dias = 0;

$("select#parcelas").live('change',function(){
			
			var qtd = $(this).val();
			var dataHoje = $("#data_hoje").val();
			
			
			
			if(qtd > '0'){	
			
				var id  = $("#id").val();
				$("#pagar").removeAttr('disabled','disabled');
				$("#titulo_parcela").css('display','block');
				$("#info_parcela").css('display','block');
				$("#info_parcela").html('');
				
				var total_orcamento = moedaBrToUsa($("#valor_total_venda").val());
				var result = (total_orcamento/qtd);
							
				var data_1 = $('<label>Primeira Parcela<br/><input type="text" name="parcela_1" id="parcela_1" size="8"  mascara="__/__/____"></label><div style="clear:both;"></div>');
				$("#info_parcela_1").html(data_1);
				
				dias = 0;
				for(i = 0; i < qtd; i++){	
					var j = i+1;		
					var dmy = dataHoje.split("/"); 
					var joindate = new Date(parseInt(dmy[2], 10),parseInt(dmy[1], 10) - 1,parseInt(dmy[0], 10));
					joindate.setDate(joindate.getDate() + dias); 
					
					var campo_parcela = $('<div id="form_parcelas"><div style="clear:both;"></div>\
					<label>Descri&ccedil;&atilde;o Parcela<br><input type="text" name="descricao_parcela[]" id="descricao_parcela" value="Parcela '+j+' O.S N&ordm; '+id+' "></label>\
					<label>Data Vencimento<br/><input size="9" type="text" name="data_vencimento_parcela[]" calendario="1" id="data_vencimento_parcela'+j+'" value="'+("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear()+'"></label>\
					<label>Valor Parcela<br><input type="text" name="valor_parcela[]" decimal="2" sonumero="1" id="valor_parcela" style="text-align:left;" size="8" value='+moedaUsaToBR(result.toFixed(2))+'></label>\
					<label style="width:120px;">Forma de Pagamento\
						 <select name="forma_pagamento_parcela[]" id="forma_pagamento_parcela">\
							<option value="0">Selecione</option>\
							<option value="1" selected="selected">Dinheiro</option>\
							<option value="2">Cheque</option>\
							<option value="3">Cart&atilde;o de Credito</option>\
							<option value="4">Boleto</option>\
							<option value="5">Permuta</option>\
							<option value="6">Transfer&ecirc;ncia</option>\
							<option value="8">Dep�sito</option>\
							<option value="7">Outros</option>\
						</select>\
        			</label>\
					</div>');					
					;
					$("#info_parcela").append(campo_parcela);									
					dias += 30;
				}
			} else{
					$("#pagar").attr('disabled','disabled');
					$("#titulo_parcela").css('display','none');	
					$("#info_parcela_1").html('');
					$("#info_parcela").css('display','none');
			}
});

/*- SCRIPT PARA CALCULAR A DATA -*/
var dias = 0;
var h = 0;
$("#parcela_1").live('blur',function(){
		
		if($("#parcela_1").val() != ''){
		var qtd = $("select#parcelas").val();		
			dias = 0;
			 h = 0;
			for(var i=0;i<qtd; i++){
					h = i+1;
						var dataInsere = $(this).val();
            			var dmy = dataInsere.split("/"); 
						var joindate = new Date(parseInt(dmy[2], 10),parseInt(dmy[1], 10) - 1,parseInt(dmy[0], 10));
						joindate.setDate(joindate.getDate() + dias); 					
						//alert(("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear());
          				$("#data_vencimento_parcela"+h).val(("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear());							
						dias += 30;	
						
			}	
		}
			
});

var total_parcela_pagamento = 0;
var diferenca = 0;
$("#valor_parcela").live("keyup",function(){
	var total_parcela_pagamento = 0;
	var diferenca = 0;
	$("div#form_parcelas #valor_parcela").each(function(index, element) {
        total_parcela_pagamento += moedaBrToUsa(element.value)*1;
    });
	
	diferenca = moedaBrToUsa($("#valor_total_venda").val())*1 - (total_parcela_pagamento)*1;
	
	//alert(moedaBrToUsa($("#total_venda").val()) + " "+moedaBrToUsa(total_parcela_pagamento) )
	
	$("#total_parcela_forma_pagamento").html(moedaUsaToBR(total_parcela_pagamento.toFixed(2)));
	$("#total_parcela_diferenca").html(moedaUsaToBR(diferenca.toFixed(2)));
	
	if(   (moedaBrToUsa(total_parcela_pagamento))*1  !==  (moedaBrToUsa($("#valor_total_venda").val())*1 ) ){
		//alert("dsa");
		$("#envia-financeiro").hide();
		
	} else {
		//alert("g");
	    $("#envia-financeiro").show();
	}
		
});
/*-Finalizar-*/
$("#finalizar_venda").live("click",function(){ 
	var j=0;
	$("div#class_qtd_origem input[name='qtd_origem']").each(function(index, element) {
        var qtd_origem = (element.value)*1;
		var item_pedido = $(this).parent().parent().parent().find("input[class='qtd']");
		var qtd_pedida = moedaBrToUsa(item_pedido.val());
		
			if(qtd_origem < qtd_pedida){
				item_pedido.addClass("alert-input");
				j += 1;	
			} else {
				j - 1;
			}
    });
	
	if(j == 0){
		$("#form_finaliza").submit();
		$(this).hide();
	}
});
</script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">�</div>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s1'>
  	Estoque
</a>
<a href="./" class='s2'>
    Vendas 
</a>

<a href="?tela_id=73" class="navegacao_ativo">
<span></span>    Itens
</a>
</div>
<div id="barra_info">
<?
if(($venda->status!='Em aberto')){
	$readonly='disabled="disabled"';
	}
?>
<form method="post" action="" autocomplete='off' id="form_finaliza">
<input type="button" value="<<" onclick="location.href='?tela_id=191&pagina=<?=$_GET['pagina']?>&limitador=<?=$_GET['limitador']?>'">
<input type="hidden" name="busca_produto_id[]" id="busca_produto_id" value="">
        Adicione um produto<input type="text" id='busca_produto' 
                
                onkeyup="return vkt_ac(this,event,'0','modulos/estoque/vendas/busca_produtos.php','@r0','funcao_bsc2(this,\'@r1-value>busca_produto_id\',\'produto\')')"

                
                 autocomplete='off' name="produto" value=""  valida_minlength="3"  retorno='focus|Coloque no minimo 3 caracter' style="width:170px;height:10px;font-size:11px;"  <?=$readonly?>	/>
                 
<?=
"<strong>Cliente:</strong> ".$cliente->razao_social." <strong>Pedido:</strong> ".$venda_id;
?>
<input type="hidden" name="fornecedor_id"  id="fornecedor_id" value="<?=$venda->fornecedor_id?>" />
<input type="hidden" name="almoxarifado_id"  id="almoxarifado_id" value="<?=$venda->unidade_id?>" />
<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
<input type="hidden" id="venda_id" name="venda_id" value="<?=$venda->id?>"/>

<?
	if($venda->status=='Em aberto'){
?>

<!--<input type="button" style="float:right; margin:3px 5px 0 10px;"  value="Finalizar" id="finalizar_venda"/>-->
<input type="hidden" name="acao" value="Finalizar"/>

<input type="button" style="float:right; margin:3px 5px 0 10px;" name="acao" value="Cancelar Venda" onclick="location.href='?tela_id=191&cliente_id=<?=$cliente_id?>&venda_id=<?=$venda_id?>&status=cancelado&pagina=<?=$_GET['pagina']?>&limitador=<?=$_GET['limitador']?>&venda_id=<?=$venda_id?>'"/>
<?
	}
?>
<input type="button" style="float:right; margin:3px 5px 0 10px;" name="acao" value="Imprimir" onclick="window.open('modulos/estoque/vendas/imprimir_venda.php?venda_id=<?=$venda_id?>',carregador)" />

</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>	
            <td width="150">Produto</td>
            <td width="60">Qtd Est.</td>
            <td width="80">Qtd Cli.</td>
            <td width="60">R$ Valor</td>
            <td width="60">Ult. R$</td>
            <!--
            <td width="60">Un Com.</td>
            <td width="60">R$ Com.</td>
            <td width="60">Un Emb.</td>
            <td width="60">R$ Emb.</td>
            <td width="60">Un Uso.</td>
            <td width="60">R$ Uso</td>
            <td width="60">Total</td>
            -->
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
<form id="produtos">
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados" id="tbody">
	<? 
	//$produtos = mysql_query($t="SELECT p.*  FROM produto as p,produto_has_fornecedor as pf WHERE pf.fornecedor_id='".$cliente->id."' AND pf.produto_id=p.id AND pf.vkt_id='$vkt_id'");
	//echo $t."<br>";
	$venda_itens=@mysql_query($t="SELECT 
									*, evi.id as item_id 
								FROM 
									estoque_vendas_item evi,
									produto p
								WHERE 
									evi.pedido_id='".$venda_id."' AND
									evi.vkt_id='$vkt_id' AND
									evi.produto_id = p.id
									
									");
	$cont=0;
	$soma=0;
	while($venda_item=@mysql_fetch_object($venda_itens)){
		$cont++;
		
		//if(!empty($venda_id)){
			
			
			
		//}
		
		//if($venda_item->qtd_pedida>0){
			$total= $venda_item->qtd_pedida*($venda_item->valor_ini);
			$soma+=$total;
			$em_estoque= mysql_fetch_object(mysql_query($a="SELECT * FROM estoque_mov WHERE vkt_id='$vkt_id' AND produto_id='{$venda_item->produto_id}' ORDER BY id DESC LIMIT 1"));
			//echo $a;
			//echo $em_estoque->saldo;
			$estocado=0;
			if($em_estoque->id>0){
				//echo "tem".$venda_item->fatorconversao;
				$estocado=@($em_estoque->saldo/$venda_item->fatorconversao);
			}
			
	?>
	<tr>
           <td width="150"><?=$venda_item->nome;?><input type="hidden" name="produto_id[]" class="produto_id" value="<?=$venda_item->produto_id?>"/></td>
            <td width="60">
			<div id='class_qtd_origem'><input type='hidden' name='qtd_origem' value='<?=$estocado?>'></div>
			<?=$estocado." ".substr($venda_item->unidade_embalagem,0,2)?>
            </td>
            <td width="80">
            	 
           	  <input type="text"  name="qtd[]" class="qtd" value="<?=qtdUsaToBr($venda_item->qtd_pedida)?>" onblur="direciona(this)" <?=$readonly?> sonumero="1"/>
              <?=substr($venda_item->unidade_embalagem,0,2)?>
              <input type="hidden" class="conversao" value="<?=$venda_item->conversao2?>" />
              <input type="hidden" class="und" value="<?=$venda_item->unidade_embalagem?>" />
           	</td>
            <td width="60"><span class="vlr"><?=moedaUsaToBr($venda_item->preco_venda/$venda_item->conversao)?></span></td>
            <td width="60"align="right" class="v_total"><?=moedaUsaToBr($total)?></td>
            <td >
            <?
            	if(empty($readonly)){
					echo "<img src='../fontes/img/menos.png' width='18' height='18' onclick='removeItem(this)' class='remove'/>";
				}
				?>
            <span style="display:none;" id="item<?=$cont?>" class="item"><?=$venda_item->item_id?></span>
           </td>
            
      </tr>
	<? }//} ?>
    </tbody>
</table>
<label style="margin-left:40px;float:left;">
Observa�ao Pedido<br>
<textarea cols="50" rows="10" name="ocorrencia_pedido" id="ocorrencia_pedido" onblur="atualiza_pedido()" <?=$readonly?>>
<?=$venda->obs_pedido?>
</textarea>
</label>
<label style="margin-left:150px;">
Observa�ao Chegada<br>
<textarea cols="50" rows="10" name="ocorrencia_chegada" id="ocorrencia_chegada" onblur="atualiza_pedido()" <?=$readonly?> style="margin-left:150px;">
<?=$venda->obs_chegada?>
</textarea>
</label>

<input type="hidden" id="pedido_id" value=<?=$venda_id?> venda/> 

<input type="hidden" name="valor_total_venda" id="valor_total_venda" value="<?=moedaUsaToBr($soma);?>">

</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
                <td width="150"></td>
            <td width="60"></td>
            <td width="60"></td>
            <td width="60"></td>
            <td width="60"><?=moedaUsaToBr($soma)?></td>
 <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
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

