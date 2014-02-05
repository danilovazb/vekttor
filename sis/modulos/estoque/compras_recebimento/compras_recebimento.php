<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php"); 
//include("atualiza_valores.php"); 
?>
<style>
.qtd{width:50px;height:12px; text-align:right}
.vlr{width:50px;height:12px; text-align:right}
.marca{height:8px; width:55px;}
#info_parcela{ overflow:auto; width:450px; max-height:200px}
</style>
<script>
//moedaBrToUsa
//moedaUsaToBR
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})

function calculatotal(t){
	valor =  moedaBrToUsa($(t.parentNode.parentNode).find(".vlr").val())*1;
	qtd= qtdBrToUsa($(t.parentNode.parentNode).find('.qtd').val(),3)*1;
	unidade2=$(t.parentNode.parentNode).find('.conversao').val()*1;
	unidade3=$(t.parentNode.parentNode).find('.conversao2').val()*1;
	unidade_tipo=$(t.parentNode.parentNode).find('.unidade_tipo').val();
	
	if(unidade_tipo=='compra'){
		v_total = valor;	
	}
	
	if(unidade_tipo=='embalagem'){
		v_total=valor/unidade3;
	}
	if(unidade_tipo=='uso'){
		v_total=valor/(unidade2*unidade3);
	}
	
	//total = moedaBrToUsa($('#valor_total').text());
	//alert(total);

	
	if(valor!=''||qtd!=''){
		$(t.parentNode.parentNode).find('.v_total').html(moedaUsaToBR((v_total*qtd).toFixed(2)));
		total=0;
	}
	
	$(t.parentNode.parentNode.parentNode).find('.v_total').each(function(){
		total += (moedaBrToUsa($(this).html())*1);
	})
	$('#valor_total').html(moedaUsaToBR(total.toFixed(2)));
}

function direciona(t){
	produto_id=$(t).parent().parent().find(".produto_id").val();
	pedido_id=$("#pedido_id").val();
	qtd=qtdBrToUsa($(t.parentNode.parentNode).find(".qtd").val(),3)*1;
	nota_fiscal = $("#nro_nota_fiscal").val();
	
	vlr = moedaBrToUsa($(t.parentNode.parentNode).find(".vlr").val());
	//v_total = vlr*qtd;
	//cont = $(t.parentNode.parentNode).find('.item').attr('id');
	ocorrencia = $(t.parentNode.parentNode).find('.ocorrencia').val();
	unidade_tipo=$(t.parentNode.parentNode).find('.unidade_tipo').val();
	conversao = $(t.parentNode.parentNode).find('.conversao').val();
	
	observacao = $("#obs_chegada").val();
	item_id=$(t.parentNode.parentNode).find(".item").text();
	recebido = $(t.parentNode.parentNode).find(".recebido").val();
	
	url='<?=$caminho?>atualiza_valores.php?produto_id='+produto_id+'&qtd='+qtd+'&valor='+vlr+'&cont='+cont+'&item_id='+item_id+'&ocorrencia='+ocorrencia+'&obs='+observacao+'&recebido='+recebido+'&pedido_id='+pedido_id+'&nota_fiscal='+nota_fiscal;
	
	window.open(url,'carregador');
}
function atualiza_pedido(ocorrencia){
	url='<?=$caminho?>atualiza_pedido.php?fornecedor_id=<?=$_GET['fornecedor_id']?>&compra_id=<?=$_GET['compra_id']?>&ocorrencia='+ocorrencia.value;
	window.open(url,'carregador');
}

$(function(){
	
	$("#finalizar").on('click',function(){
		var Valtotal = 0;
		
		$(".TotalCompra").each(function(){
			Valtotal += moedaBrToUsa($(this).val())*1;	
		})
		if(Valtotal > 0){
			var params = "?totalcompra="+Valtotal+"&fornecedor_id="+$("#fornecedor_id").val()+"&compra_id="+$("#compra_id").val()+"&nro_nota_fiscal="+$("#nro_nota_fiscal").val(); 
			window.open('modulos/estoque/compras_recebimento/form_pagamento.php'+params,'carregador');
		}
	});
	$("#botao_salvar,##botao_salvar2").live('click',function(){
			if($("#conta_id").val() == 0){
				alert('Informe a Conta');
				return false	
			} else{
				$("#form_compras_pagamento").submit();
			}
	})
	/*- script para pagamentos -*/
	$("select#parcelas").live('change',function(){	
		/*-recebe a quantidade de parcelas-*/
		var qtd = $(this).val();
		/*-recebe a data da primeira parcela-*/
		var DataPrimeiraParcela = $("#pri_parcela").val(); 
		/*-recebe o ID do documento-*/
		var id = $("#compra_id").val();
		
		
		if(qtd > 1){
			$("#um_parcela").hide();
			$("#info_parcela").show();	
			$("#info_parcela").html('');
			/*-recebe o TOTAL do pagamento-*/
			var TotalPagamento = moedaBrToUsa($("#valor_total").val())*1;
			var ResultadoDivisao = (TotalPagamento/qtd);
			dias = 0;
			var htmlParcela = "";
			for(i = 0; i < qtd; i++){	
				var j = i+1;							
				var dmy = DataPrimeiraParcela.split("/"); 
				var joindate = new Date(parseInt(dmy[2], 10),parseInt(dmy[1], 10) - 1,parseInt(dmy[0], 10));
				joindate.setDate(joindate.getDate() + dias); 
				var dataVencimento = ("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear();
				 htmlParcela += '<div style="clear:both;"></div><label>Descri&ccedil;&atilde;o Parcela<br><input type="text" name="descricao_parcela[]" id="descricao_parcela" value="Parcela '+j+' Pagamento N&ordm; '+id+' "></label><label>Data Vencimento<br/><input size="9" type="text" name="data_vencimento_parcela[]" calendario="1" id="data_vencimento_parcela'+j+'" value="'+dataVencimento+'"></label><label>Valor Parcela <strong> x '+j+'</strong><br><input type="text" name="valor_parcela[]" id="valor_parcela" size="8" readonly="readonly" value='+moedaUsaToBR(ResultadoDivisao.toFixed(2))+'></label>';					
				dias += 30;
			}
			$("#info_parcela").html(htmlParcela);
		} else{
				
				$("#info_parcela").hide();
				$("#um_parcela").show();
		}
	}) /* fim script pagamentos */
	
});

$("#enviar_boleto_financeiro").live('click',function(){

	if($(this).is(':checked')){
		$("#botao_salvar").hide();
		$("#botao_salvar2").show();
		/*$("#pri_parcela").attr('disabled','disabled');
		$("#parcelas").attr('disabled','disabled');
		$("#info_parcela").html('');*/
	}else{
		$("#botao_salvar2").hide();
		$("#botao_salvar").show();
		/*$("#pri_parcela").attr('disabled','');
		$("#parcelas").attr('disabled','');*/
	}

});

$("#info_pagamento").live("click",function(){
	var id = $("#compra_id").val();
	
	window.open('modulos/estoque/compras_recebimento/form_info_pagamento.php?compra_id='+id,'carregador');

});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s1'>
    Estoque 
</a>
<a href="./" class='s2'>
    Recebimento
</a>

<a href="?tela_id=73" class="navegacao_ativo">
<span></span>  Itens
</a>
</div>
<div id="barra_info">

<form method="post" action="">
<input type="hidden" name="compra_id" id="compra_id" value="<?=$_GET['compra_id']?>">
<input type="button" value="<<" onclick="location.href='?tela_id=197&pagina=<?=$_GET['pagina']?>&limitador=<?=$_GET['limitador']?>'">
<?=
"<strong>Fornecedor: </strong>".$fornecedor->razao_social." || <strong>Pedido:</strong> ".$_GET['compra_id']." || <strong>Almoxarifado:</strong> ".$almoxarifado->nome." || <strong>Data de Chegada Prevista:</strong> ".DataUsatoBr($compra->data_chegada_prevista)." || ";
?>
<label>
	<strong>N&ordm; Nota Fiscal: </strong>
    <input type="text" name="nro_nota_fiscal" id="nro_nota_fiscal" onblur="direciona(this)" value="<?=$compra->nro_nota_fiscal?>" style="width:70px;height:10px;" <?=$readonly?>/>
</label>

<input type="hidden" name="fornecedor_id"  id="fornecedor_id" value="<?=$fornecedor->id?>" />
<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
<input type="button" style="float:right; margin:3px 5px 0 10px;" name="acao" value="Imprimir" onclick="window.open('modulos/estoque/compras/imprimir_compra.php?compra_id=<?=$_GET['compra_id']?>',carregador)" />
<?
	$status_compra=mysql_fetch_object(mysql_query($t="SELECT status FROM estoque_compras WHERE id='".$_GET['compra_id']."'"));
	if(($status_compra->status=='Em aberto')){
?>
<!--<input type='button' style='float:right; margin:3px 5px 0 10px;' name='acao' value='Finalizar' onclick="location='?tela_id=198&pagina=<?=$_GET['pagina']?>&limitador=<?=$_GET['limitador']?>&Finalizar=Finalizado&compra_id=<?=$_GET['compra_id']?>'"/>-->
	<input type="button" style='float:right; margin:3px 5px 0 10px;' value='Finalizar' id="finalizar">
<?
	}else if(($status_compra->status=='Finalizado')){
		$readonly="disabled";
?>
	<input type="button" style='float:right; margin:3px 5px 0 10px;' value='Pagar' id="finalizar">
<?
	}
	if($status_compra->status=="pago"){
		$readonly="disabled";
		echo "<button id='info_pagamento' type='button'> Informações de pagamento </button>";
	}
?>
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	 <td width="35">Item</td>	
            <td width="150">Produto</td>
            <td width="60">Marca</td>
            <td width="80">Qtd Ped.</td>
            <td width="80">Qtd Rec.</td>
            <td width="60">R$ Valor</td>
            <td width="60">Total</td>
            <td width="150">Ocorrencia</td>
            
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<!--<form id="produtos">-->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados" id="tbody">
	<? 
		
	$itens = mysql_query($t="SELECT 
								pf.*,p.nome,p.id as produto_id, ec.id,pf.id as eci_id, ec.status 
							FROM 
								estoque_compras_item as pf, produto as p, estoque_compras as ec
							WHERE 
								pf.vkt_id='$vkt_id' AND 
								pf.pedido_id=ec.id AND
								pf. pedido_id ='$_GET[compra_id]' AND  pf.produto_id = p.id ORDER BY p.nome");
	echo mysql_error();
	//echo $t."<br>";
	$cont=0;
	$soma=0;
	while($item=mysql_fetch_object($itens)){
		if($item->qtd_enviada==NULL){$qtd_usada=$item->qtd_pedida;}else{$qtd_usada=$item->qtd_enviada;}
		if($item->qtd_enviada==NULL){$valor_usado=$item->valor_ini;}else{$valor_usado=$item->valor_fim;}
		//verifica qual a unidade comprada e faz o calculo
		
		if($item->status=='Finalizado'&&$item->unidade_tipo=='compra'){
			
			$qtd_usada = $qtd_usada / $item->fatorconversao2 / $item->fatorconversao;
			//$qtd_usada = moedaUsaToBr($qtd_usada); 
		}else
		if($item->status=='Finalizado'&&$item->unidade_tipo=='embalagem'){
			$qtd_usada = $qtd_usada / $item->fatorconversao2;
			$qtd_usada = moedaUsaToBr($qtd_usada); 
		}
		
		
			if($item->qtd_pedida>0){
				$soma += $qtd_usada*$valor_usado;
	?>
	<tr>
    		 <td width="35"><?=$cont+1?></td>
    	   <td width="150"><?=$item->nome;?><input type="hidden" name="produto_id[]" class="produto_id" value="<?=$item->produto_id?>"/></td>
           <td width="60"><?=$item->marca?> <?=$conversao?> </td>
           <td width="80" align="right">
           	  <?=qtdUsaToBr($item->qtd_pedida)?> <?=substr($item->unidade,0,2)?>
              <input type="hidden" value="<?=$item->fatorconversao?>" class="conversao"/>
              <input type="hidden" value="<?=$item->fatorconversao2?>" class="conversao2"/>
              <input type="hidden" value="<?=$item->unidade_tipo?>" class="unidade_tipo"/>
           	</td>
            <td width="80" align="right"><input type="text"  name="qtd[]" class="qtd" value="<?=qtdUsaToBr($qtd_usada)?>" 
            onblur="direciona(this)" onkeyup="calculatotal(this)" <?=$readonly?> sonumero="1"/> <?=substr($item->unidade,0,2)?></td>
            
          <td width="60"><input type="text" name="vlr[]" class="vlr" value="<? if(empty($item->valor_fim)){echo moedaUsaToBr($item->valor_ini);}else{echo moedaUsaToBr($item->valor_fim);}?>" onblur="direciona(this)" onkeyup="calculatotal(this)" <?=$readonly?>/></td>
            
            <td width="60"align="right" class="v_total">
				<input type="hidden" name="Valtotal[]" id="Valtotal" class="TotalCompra" value="<?=moedaUsaToBr($qtd_usada*$valor_usado)?>"><?=moedaUsaToBr($qtd_usada*$valor_usado)?>
            </td>
            <td width="150"><input type="text" name="ocorrencia" class="ocorrencia" value="<?=$item->ocorrencia?>" onblur="direciona(this)" <?=$readonly?>/></td>
            <td ><span style="display:none;" class="item"><?=$item->eci_id?></span></td>
            
      </tr>
      
	<? }} ?>
    </tbody>
</table>

	

<br>
<br>
<p style="margin-left:40px;">
Obs. Pedido<br>
<?=$compra->obs_pedido?>
</p>
<br>
<label style="margin-left:40px;">
Observaçao<br>
<textarea name="obs_chegada" id="obs_chegada" cols="50" rows="10" style="margin-left:40px;" onblur="atualiza_pedido(this)" <?=$readonly?>>
<?=$compra->obs_chegada;?>
</textarea>
</label>
<input type="hidden" id="pedido_id" value="<?=$compra->id?>" /> 
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="60" ></td>
            <td width="60"  id='valor_total' ><?=moedaUsaToBr($soma);?></td>
            <td width="60">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="60"></td>
 <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	<strong>As alteraçoes serao salvas automaticamente ao digitar no campo</strong>
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

