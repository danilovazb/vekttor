<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php"); 
?>


<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<style>
textarea{
	resize:none;
}
</style>
<script>
//calcula o restande máximo de derivados
function calcula_quantidade_restante(){
	
	var saldo              = moedaBrToUsa($("#saldo").val())*1;
	var qtd_total_derivado = moedaBrToUsa($("#qtd_total_derivado").text())*1;
	qtd_restante_derivado = saldo - qtd_total_derivado;
	$("#qtd_restante_derivado").text(moedaUsaToBR(qtd_restante_derivado.toFixed(2)));
}


$("select#pedido_id").live("change",function(){
				var pedido_id = $(this).val();
				var dados = 'pedido_id='+pedido_id;
				//alert(dados);
				//$('#result_pedido_id').load('modulos/estoque/beneficiamento/beneficiamento_item.php',data);
				$.ajax({
							url: 'modulos/estoque/beneficiamento/beneficiamento_item.php?acao=pedido_info',
							dataType: 'html',
							type: 'POST',
							data: dados,
							success: function(data, textStatus) {
								//$('#result_pedido_id').css('display','block');
								//$('#result_pedido_id').html(data);
								$("#cd_fornecedor").css('display','none');
								$("#cd_marca").css('display','none');
								$("#cd_data").css('display','none');
								$("#info_pedido").html(data);
																//$("#produto_beneficiado").attr('disabled','disabled');
							},
						}); /* Fim Ajax*/
});
/*----------------- AQUI ELE INSERE O PRODUTO DERIVADO ----------------*/
var total_qtd_derivado=0;
var saldo=0;
$("#derivado_mais").live('click',function(e){
		
		var produto_beneficiado = $("#produto_beneficiado_id").val();
		if(produto_beneficiado == '0'){
			alert("Informe Produto Beneficiado");
			return false;	
		} else {
	
	var saldo = moedaBrToUsa($("#saldo").val())*1;
	var qtd_total_beneficiado = $("#qtd_produto_beneficiado").val();
	
	var produto_derivado_id = $("#produto_derivado_id").val();
	var produto_derivado    = $("#produto_derivado").val();
	var id_pedido           = $("#id_pedido").val();
	var qtd_derivado        = moedaBrToUsa($("#qtd_derivado").val())*1;
	var obs_derivado        = $("#obs_derivado").val();
	var und                 = $("#unidade_produto_derivado").val();
	var qtd_total_derivado  = moedaBrToUsa($("#qtd_total_derivado").text())*1;
	var fatorconversao      = $("#fatorconversao").val()*1;
	var conversao2			= $("#conversao2").val();
	
	qtd_unidade_uso         = qtd_derivado * fatorconversao;
	 	
		if(produto_derivado_id == 0){
			return false;
			alert(produto_derivado);	
		}
		else if(produto_derivado == ''){
			alert("Informe o Produto");
				return false;	
		}
		else{
			
			var dados = 'produto_derivado='+produto_derivado+'&id_pedido='+id_pedido+'&qtd_derivado='+qtd_derivado+'&produto_id='+produto_derivado_id+'&obs_derivado='+obs_derivado+'&und='+und+'&total_beneficiado='+qtd_total_beneficiado+'&fatorconversao='+fatorconversao+'&conversao2='+conversao2;
			//alert(dados)
						$.ajax({
							url: 'modulos/estoque/beneficiamento/beneficiamento_item.php?acao=cad_derivado',
							dataType: 'html',
							type: 'POST',
							data: dados,
							success: function(data, textStatus) {
								$('#result_derivado').append(data);
								$('#produto_derivado').val("");
								$('#qtd_derivado').val("");
								$('#obs_derivado').val("");	
								//$("#saldo").val(saldo);							
							},
						}); /* Fim Ajax*/
			
			//soma as quantidades de produtos derivados			
			qtd_total_derivado += moedaBrToUsa(qtd_unidade_uso)*1;
			
			qtd_total_derivado  = moedaUsaToBR(qtd_total_derivado.toFixed(2));
			$("#qtd_total_derivado").html("");
			$("#qtd_total_derivado").text(qtd_total_derivado);
			
			calcula_quantidade_restante();
		}
	}
		
})

function funcao_bsc2(resultado,acao,origem){	
	actions_W= acao.split('|');
//	document.title=resultado.innerHTML+','+resultado.getAttribute('r0')+','+resultado.getAttribute('r1')+','+resultado.getAttribute('r2')+','+acao+','+origem+','+actions_W.length;
	
	document.getElementById(origem).value=resultado.getAttribute('r0');
	
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
	
	var produto_beneficiado_id   = $("#produto_beneficiado_id").val();
	var qtd_produto_beneficiado  = $("#qtd_produto_beneficiado").val();
	var produto_beneficiado      = $("#produto_beneficiado").val();
	var data_pedido              = $("#data_pedido").val();
	

						//alert()						
		var dados = 'produto_beneficiado_id='+produto_beneficiado_id+'&produto='+produto_beneficiado+'&qtd_beneficiado='+qtd_produto_beneficiado+'&data_pedido='+data_pedido;
						//alert(dados);
						$.ajax({
							url: 'modulos/estoque/beneficiamento/beneficiamento_item.php?acao=cad_beneficiado', 
							dataType: 'html',
							type: 'POST',
							data: dados,
							success: function(data, textStatus) {
								$('#result_beneficiado').html(data);
								$("#qtd_derivado").val("");
								$("#result_pedido_id").css('display','none');
								
							},
						}); /* Fim Ajax*/
						
		//alert(produto_beneficiado_id+' - qtd '+qtd_produto_beneficiado);	
					
}

$(".delete_pedido").live('click',function(){
			var id_pedido = $(this).parent().parent().find('#id_pedido').val();
			var b=$(this).parent().parent();
			var dataString = 'id_pedido='+id_pedido;
			
	
		$.ajax({
			type: "POST",
			url: "modulos/estoque/beneficiamento/beneficiamento_item.php?acao=exclui_pedido",
			data: dataString,
			cache: false,
			success: function(e){
				$("#produto_beneficiado").removeAttr('disabled','disabled');
			b.hide();
			e.stopImmediatePropagation();
			}
 		 }); /* Fim Ajax*/
		//return false;
	 /* fim de if(confirm)*/
});/* Fim Script */	
$(".delete_derivado").live('click',function(){
		var pedido_id = $(this).parent().parent().find('#pedido_id').val();
		var b=$(this).parent().parent();
		var dataString = 'id='+pedido_id;
		var qtd_pedida = moedaBrToUsa($(this).parent().parent().find('.qtd_pedida_uso').text())*1;
		var qtd_total_derivado = moedaBrToUsa($("#qtd_total_derivado").text())*1;
		
			
			//alert(dataString);
		
		
		$.ajax({
			type: "POST",
			url: "modulos/estoque/beneficiamento/beneficiamento_item.php?acao=exclui_derivado_item&id="+pedido_id,
			data: dataString,
			cache: false,
			success: function(e){
			b.hide();
			e.stopImmediatePropagation();
			}
 		 }); /* Fim Ajax*/
		$(this).parent().parent().remove();
		
		qtd_total_derivado -= qtd_pedida;
		
		
		$("#qtd_total_derivado").html("");
		$("#qtd_total_derivado").text(moedaUsaToBR(qtd_total_derivado.toFixed(2)));
			
		calcula_quantidade_restante();
		//return false;
	 /* fim de if(confirm)*/
});/* Fim Script */
$(".delete_item").live('click',function(){
		var pedido_id = $(this).parent().parent().find('#item_id').val();
		var b=$(this).parent().parent();
		var dataString = 'id='+pedido_id;
		var qtd_pedida = moedaBrToUsa($(this).parent().parent().find('.qtd_pedida_uso').text())*1;
		var qtd_total_derivado = moedaBrToUsa($("#qtd_total_derivado").text())*1;	
			
		$.ajax({
			type: "POST",
			url: "modulos/estoque/beneficiamento/beneficiamento_item.php?acao=delete_item&id="+pedido_id,
			data: dataString,
			cache: false,
			success: function(e){
			b.hide();
			e.stopImmediatePropagation();
			}
 		 });
		 //$("#saldo").val(saldo);
		 
		$(this).parent().parent().remove();
		 
		 qtd_total_derivado -= qtd_pedida
		
		$("#qtd_total_derivado").html("");
		$("#qtd_total_derivado").text(moedaUsaToBR(qtd_total_derivado.toFixed(2)));
			
		calcula_quantidade_restante();		 
		 /* Fim Ajax*/
		//return false;
	 /* fim de if(confirm)*/
});/* Fim Script */
$("#qtd_beneficiado").live('blur',function(){	
			var qtd = $(this).val();
			var id_pedido = $(this).parent().parent().find('#id_pedido').val();
			
			var dataString = 'id_pedido='+id_pedido+'&qtd='+qtd;
			//alert(dataString);
	
		$.ajax({
			type: "POST",
			url: "modulos/estoque/beneficiamento/beneficiamento_item.php?acao=update_qtd_beneficiado",
			data: dataString,
			cache: false,
			success: function(data, textStatus) {					
				$("#produto_beneficiado").attr('disabled','disabled');
			},
 		 }); /* Fim Ajax*/
		//return false;
	 /* fim de if(confirm)*/
});/* Fim Script */	
$("#tabela_dados tr").live("click",function(){
		var produto_id = $(this).attr('id');
		var pedido_id  = $(this).attr('lang');
		var beneficiamento_id = $(this).attr('dir')
		
		window.open('modulos/estoque/beneficiamento/form_edit.php?produto_id='+produto_id+'&pedido_id='+pedido_id+'&beneficiamento_id='+beneficiamento_id,'carregador');
});

$("#cancelar").live('click',function(){
			var id_beneficiamento = $("#id_pedido").val();
			var dados = "status=3&beneficiamento="+id_beneficiamento;
				//alert(dados+id_beneficiamento);
			$.ajax({
				type: "POST",
				url: "modulos/estoque/beneficiamento/beneficiamento_item.php?acao=cancelar",
				data: dados,
				cache: false,
				success: function(data, textStatus) {					
					location.href=('?tela_id=109');
				},
 		 	}); /* Fim Ajax*/
})

$("#desperdicio, #qtd_produto_beneficiado").live('blur',function(){
	var qtd = moedaBrToUsa($("#qtd_produto_beneficiado").val())*1;
	var desperdicio = moedaBrToUsa($("#desperdicio").val())*1;
	
	perda = (qtd*desperdicio)/100;
	saldo = qtd - perda;
	
	$("#saldo").val(moedaUsaToBR(saldo.toFixed(2)));
	
	calcula_quantidade_restante();

});
$("#saldo").live('blur',function(){
	var saldo = moedaBrToUsa($(this).val())*1;
	var qtd = moedaBrToUsa($("#qtd_produto_beneficiado").val())*1;
	
	desperdicio = qtd - saldo;
	
	desperdicio = (desperdicio*100)/qtd;
	
	$("#desperdicio").val('');
	$("#desperdicio").val(moedaUsaToBR(desperdicio.toFixed(2)));
	calcula_quantidade_restante();
});
</script>

<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="109" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="?tela_id=109" class="navegacao_ativo">
<span></span>    Beneficiamento
</a>
</div>
<div id="barra_info">
	<div style="float:left; margin-top:1px;">
        <div style="margin-top:-4px; padding:2px;">
        <form method="get">
        <input name='tela_id' value="109" type="hidden" />
        <select name="status" id="status">
            <option>Status</option>
            <option <? if($_GET['status'] == '1'){echo 'selected="selected"';} ?>value="1">Aguardando</option>
            <option <? if($_GET['status'] == '2'){echo 'selected="selected"';} ?>value="2">Recebido</option>
            <option <? if($_GET['status'] == '3'){echo 'selected="selected"';} ?>value="3">Cancelado</option>
        </select>
        <input type="submit" value="Filtrar">
        </form>
        </div>
    </div>
    <a target="carregador" href="<?=$caminho?>form.php" class="mais"></a>
    <form>
    <label>
      <input name='tela_id' value="109" type="hidden" />
    </label>
    </form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="50">N&ordm;</td>
        	<td width="200">Produto</td>
            <td width="100">Quantia</td>
            <td width="60">Unidade</td>
            <td width="100">Perda</td>
            <td width="70">Status</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="tabela_dados">
    <?php
    		if(isset($_GET['busca'])){
				$busca = "AND e.pedido_id = ".$_GET['busca'];	
			}
			if(isset($_GET['status'])){
				$and_status = "AND e.status = ".$_GET['status'];	
			}
			$pedido=mysql_query($r=" SELECT *,
										e.id as pedido_beneficiamento_id 
									FROM estoque_beneficiamento_pedido e
											JOIN produto p ON e.produto_beneficiado_id=p.id  
																WHERE e.vkt_id = '$vkt_id' 
																$busca $and_status
									ORDER BY e.id DESC
								");
																//echo $r;
				while($pedido_item=mysql_fetch_object($pedido)){
						if($pedido_item->status == '2'){
									$status = "Recebido";
							} else if($pedido_item->status == '1') {
										$status = "Aguardando";
							} else {$status = "Cancelado";}
	?>
    <tr style="background-color:#999; color:white;" id="<?=$pedido_item->produto_beneficiado_id;?>" lang="<?=$pedido_item->pedido_beneficiamento_id?>" dir="<?=$pedido_item->pedido_beneficiamento_id?>">
    	<td width="20"><?=$pedido_item->pedido_beneficiamento_id;?></td>
    	<td><?=$pedido_item->nome;?></td>
        <td width="100"><?=moedaUsaToBr($pedido_item->qtd_pedido)?></td>
        <td width="60"><?=$pedido_item->unidade?></td>
        <td width="100"><?=moedaUsaToBr($pedido_item->desperdicio)?></td>
        <td width="70"><?=$status?></td>
        <td></td> 
    </tr>
    <?
				
    	$sql_item = mysql_query("SELECT * FROM estoque_beneficiamento_item i
									JOIN produto p	on i.produto_id=p.id
										WHERE beneficiamento_id =".$pedido_item->pedido_beneficiamento_id);
		
					while($item=mysql_fetch_object($sql_item)){
	?>
    <tr class="produtos_tabela" id="<?=$pedido_item->produto_beneficiado_id;?>" lang="<?=$pedido_item->pedido_beneficiamento_id?>" dir="<?=$pedido_item->pedido_beneficiamento_id?>">
        <td width="50"></td>
        <td width="200"><?=$item->nome?></td>
        <td width="100"><?=moedaUsaToBr($item->qtd_pedida*$item->conversao2)?></td>
        <td width="60"><?=$item->unidade_uso?></td>
        <td width="100"></td>
        <td width="70"></td>
        <td></td>
    </tr>
    <?
					}
			}
	?>
    </tbody>
</table>

</div>
</div>
<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  <script>

$(document).ready(function(){
	$("#tabela_dados tr.produtos_tabela:nth-child(2n+1)").addClass('al');
})
</script>
  
    <div style="float:right; margin:0px 20px 0 0">
    </div>
</div>
