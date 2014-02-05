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
	

	$(t.parentNode.parentNode).find('.qtd_unidade').html(qtdUsaToBr(qtd_unidade2));
	$(t.parentNode.parentNode).find('.qtd_embalagem').html(qtdUsaToBr(qtd_embalagem2));
	$(t.parentNode.parentNode).find('.qtd_uso').html(qtdUsaToBr(qtd_uso2));
	
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
	
		var dados = 'produto_id='+produto_id+'&fornecedor_id=<?=$fornecedor_id?>&necessidade_id=<?=$_GET['necessidade_id']?>'
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
</script>
<div id="barra_info">

<form method="post">
<input type="button" value="<<" onclick="location.href='?tela_id=118&necessidade_id=<?=$necessidade_id?>&cotacao_id=<?=$cotacao_id?>'">
	<!-- Adicione um produto<input type="text" id='busca_produto' onkeyup="return vkt_ac(this,event,'0','modulos/cozinha/cotacao/busca_produto.php?necessidade_id=<?=$necessidade_id?>','@r0','funcao_bsc2(this,\'@r1-value>busca_produto_id\',\'produto\')')"
   autocomplete='off' name="produto" value=""  valida_minlength="3"  retorno='focus|Coloque no minimo 3 caracter' style="width:170px;height:10px;font-size:11px;"  <?=$readonly?>	/>
   <input type="hidden" name="busca_produto_id[]" id="busca_produto_id" value="">-->
   Cota&ccedil;&atilde;o N&ordm;:<strong><?=$cotacao_id?></strong>  - 
   <?=$fornecedor->razao_social?> 
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%" style="overflow:auto;" >
<thead>
    	<tr>
           <td width="35">Item</td>
          <td width="90"><?=linkOrdem("Produto","nome",1)?></td>
          <td width="70">Marca</td>
          <td width="45" title="Quantidade Necessidade">QTD N</td>
          <td width="45" title="Quantidade Fornecedor">QTD F</td>
          <td width="80">Unidade</td>
          <td width="60">Valor</td>
          <td width="50" title="Preco Ultima Compra">Ult. R$</td>
          <td width="60" title="Unidade Ultima Compra">Un Com.</td>
          <td width="50" title="Preço Compra">R$ Com.</td>
          <td width="50" title="Unidade Embalagem">Un Emb.</td>
          <td width="50" title="Preço Embalagem">R$ Emb.</td>
          <td width="50" title="Unidade Uso">Un Uso.</td>
          <td width="50" title="Preço Uso">R$ Uso</td>
          <td width="50">Total</td>
          <td></td>
      </tr>
    </thead>
</table>
<div id='dados' style="overflow:auto;">
<?php
	$grupo_produtos = mysql_query("SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id' ORDER BY nome");	
	
?>
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" style="overflow:auto;">
	<tbody id="tbody">
    	<?
        	//$itens_necessidade_fornecedor=mysql_query($t="SELECT cni.* FROM cozinha_necessidade_item cni WHERE cni.necessidade_id = '".$_GET['necessidade_id']."'");
			//$itens_necessidade_fornecedor=mysql_query($t="SELECT * FROM cozinha_necessidade_item WHERE necessidade_id='".$_GET['necessidade_id']."' AND vkt_id='$vkt_id'");
			//echo $t;
			
			while($grupo_produto = mysql_fetch_object($grupo_produtos)){
				$produtos_necessidade_item=mysql_query($t="SELECT * 
					  	FROM 
					  	cozinha_necessidade_item cni,
						produto p						
 						WHERE 
						cni.vkt_id         ='$vkt_id' AND
						cni.produto_id     =p.id AND
						p.produto_grupo_id ='$grupo_produto->id' AND 
						cni.necessidade_id ='$necessidade_id' AND
						cni.cotar='sim'
						");
				if(mysql_num_rows($produtos_necessidade_item)>0){
					echo "<tr><td style='background:#999; color:white' colspan='16'>$grupo_produto->nome</td></tr>";
				}
			
			$soma=0;
			while($produto_necessidade=mysql_fetch_object($produtos_necessidade_item)){
				$cont++;
				$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id=".$produto_necessidade->produto_id));
				$item_cotacao=mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_cotacao_item WHERE cotacao_id='".$cotacao->id."' AND produto_id='".$produto->id."'"));
				//echo $fornecedor->id."<br>";
				associaProdutoForencedor($produto->id,$fornecedor->id);
				//if($item_cotacao->qtd_pedida>0){
		?>
        <tr>
           <td width="35"><?=$cont?></td>
          <td width="90"><?=$produto->nome?><input type="hidden" class="produto_id" name="produto_id[]" value="<?=$produto->id?>"/></td>
          <td width="1" style="display:none"><input type="hidden" class="item_necessidade_id" name="item_necessidade_id[]" value="<?=$item_necessidade->id?>" /></td>
          <td width="70"><input type="text" name="marca[]" class="marca" size="7" onblur="direciona(this)" value="<?=$item_cotacao->marca?>"/></td>
          <td width="45" title="Quantidade Necessidade"><span class="qtd_necessidade"><?=$produto_necessidade->qtd_digitada?></span><?=" ".substr($produto->unidade_embalagem,0,2)?></td>
          <td width="45" title="Quantidade Fornecedor"><input type="text" name="qtd[]" class="qtd" size="3" value="<? if(empty($item_cotacao->qtd_pedida)){echo limitador_decimal($item_necessidade->qtd_digitada);}else{echo limitador_decimal($item_cotacao->qtd_pedida);}?>" onblur="direciona(this)" sonumero='1'/></td>
          <td width="80">
            <select name="unidade[]" class='und' onchange="direciona(this)" style="width:80px;">
              <option  ut = 'compra' value="<?=$produto->unidade?>" <? if($produto->unidade==$item_cotacao->unidade){echo "selected=selected";$ut='compra';}?>><?=substr($produto->unidade,0,2)." ".$produto->conversao." ".substr($produto->unidade_embalagem,0,2)?></option>
              <option ut = 'embalagem' value="<?=$produto->unidade_embalagem ?>" <? if($produto->unidade_embalagem==$item_cotacao->unidade){echo "selected=selected";$ut='embalagem';}?>><?=substr($produto->unidade_embalagem,0,2)." ".$produto->conversao2." ".substr($produto->unidade_uso,0,2) ?></option>
              <option ut = 'uso' value="<?=$produto->unidade_uso?>" <? if($produto->unidade_uso==$item_cotacao->unidade){echo "selected=selected";$ut='uso';}?>><?=substr($produto->unidade_uso,0,2)?></option>
            </select>
            <input type="hidden" name="conversao" class="conversao" value="<?=$produto->conversao?>"/>
            <input type="hidden" name="conversao1" class="conversao2" value="<?=$produto->conversao2?>"/>
          </td>
          <td width="60" ><input type="text" name="valor[]" class="valor" value="<?=moedaUsatoBr($item_cotacao->valor_ini)?>" size="5" onblur="direciona(this)" decimal='2'/></td>
          <td width="50" class="cz" title="Preco Ultima Compra"><?=moedaUsaToBr($produto->preco_compra)?></td>
          <td width="60" align="right" class="cz" title="Unidade Ultima Compra"><span class="qtd_unidade">
			  <?
            	if($item_cotacao->qtd_pedida>0){
			
				if($ut=='compra'){
					//echo $ut;
					$qtd_unidade   = $item_cotacao->qtd_pedida;
					$qtd_embalagem = $qtd_unidade*$item_cotacao->fatorconversao;
					$qtd_uso	   = $qtd_unidade*$item_cotacao->fatorconversao2*$item_cotacao->fatorconversao;
		
					$vlr_unidade   = $item_cotacao->valor_ini;
					$v_embalagem   = $vlr_unidade/$item_cotacao->fatorconversao;
					$v_uso		   = $v_embalagem/$item_cotacao->fatorconversao2;
					//echo $vlr_unidade."<br>";
				}
				if($ut=='embalagem'){
					//echo $ut;
					$qtd_embalagem 	= $item_cotacao->qtd_pedida;
					$qtd_unidade 	= $item_cotacao->qtd_pedida/$item_cotacao->fatorconversao;
					$qtd_uso		= $item_cotacao->qtd_pedida*$item_cotacao->fatorconversao2;
		
					$v_embalagem	= $item_cotacao->valor_ini;
					$vlr_unidade 	= $v_embalagem*$item_cotacao->fatorconversao;
					$v_uso			= $v_embalagem/$item_cotacao->fatorconversao2;
					//echo $vlr_unidade."<br>";
				}
				if($ut=='uso'){
					//echo $ut;
					$qtd_uso		= $item_cotacao->qtd_pedida;
					//qtd_embalagem 	= (qtd/unidade3);
					$qtd_embalagem 	= $item_cotacao->qtd_pedida/$item_cotacao->fatorconversao2;
					$qtd_unidade 	= $item_cotacao->qtd_pedida/$item_cotacao->fatorconversao;
		
					$v_uso			= $item_cotacao->valor_ini;
					$v_embalagem	= $v_uso*$item_cotacao->fatorconversao2;
					$vlr_unidade 	= $v_embalagem*$item_cotacao->fatorconversao;
					//echo $vlr_unidade."<br>";
				}
				}
				
				$total = $item_cotacao->qtd_pedida * $item_cotacao->valor_ini;
			?>
			<?=number_format($qtd_unidade,2,",",".")?></span> <?=substr($produto->unidade,0,2)?>
            </td>
            <td width="50" align="right" class="v_compra cz" title="Preço <?=$produto->unidade ?>"><?=number_format($vlr_unidade,2,",",".")?></td>
            <td width="50" align="right" class="cz" title="Unidade Embalagem"><span class="qtd_embalagem"><?=limitador_decimal($qtd_embalagem)?></span> <?=substr($produto->unidade_embalagem,0,2)?></td>
            <td width="50" align="right" class="v_embalagem cz" title="Preco <?=$produto->unidade_embalagem?>"><?=number_format($v_embalagem,2,",",".")?></td>
           <td width="50" align="right" class="cz" title="Unidade Uso"><span class="qtd_uso"> <?=number_format($qtd_uso,2,",",".")?></span><?=substr($produto->unidade_uso,0,2)?></td>
           <td width="50" align="right" class="v_uso cz" title="Preço <?=$produto->unidade_uso?>"><?=number_format($v_uso,2,",",".")?></td>
            <td width="50"align="right" class="v_total"><?=number_format($total,2,",",".");$soma+=$total;?></td>
            <td>
            	<span style="display:none;" id="item<?=$cont?>" class="item"><?=$item_cotacao->id?></span>
            	<?
            	if(empty($readonly)){
					echo "<img src='../fontes/img/menos.png' width='18' height='18' onclick='removeItem(this)' class='remove'/>";
				}
				?>
          </td>
        </tr>
        <?
				}
			}
		?>
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