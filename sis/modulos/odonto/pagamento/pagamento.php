<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
$mes = date("m"); $ano = date("Y");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#info_parcela{ overflow:auto; max-height:150px; border-top:1px solid #CCC; padding-top:8px;}
#descCredito:hover{ color:#FFF;}
.marcado{background: #F7EADA;}
.parcela{ background:#FFFCE1;}
</style>
<script>
//var totalTable = 0 ;
$(" table.lista_pagamento tbody tr ").live('click',function(){
	var id = $(this).attr("id");
	var cliente = $(this).attr("cliente");
	window.open('modulos/odonto/pagamento/form.php?id='+id+'&cliente_id='+cliente,'carregador');
});
var total = 0;

$(function(){
	/*- scrip para busca -*/
	$(".form_busca input[type='text'] ").live('keydown',function(event){
		if( (event.keyCode == 13) && ($.trim($("#cliente_id").val()) != "")) {
		   window.open('modulos/odonto/pagamento/form.php?id='+$("#cliente_id").val(),'carregador'); 
		}
		 $("#cliente_id").val('');
	});
	$(".form_busca a").live('click',function(event){
		if($.trim($("#cliente_id").val()) != "" ){
			window.open('modulos/odonto/pagamento/form.php?id='+$("#cliente_id").val(),'carregador');
			$("#cliente_id").val('');
			$(".form_busca #busca").val('');
			return false;
		}
	});
	/*--*/
	$("tr:odd").addClass('al');
	$("#botao_salvar").live('click',function(){
			var erro=0;
			var mensagem='';
			
			if($("#conta_id").val() == 0){
				erro++;
				mensagem += ' Informe a conta \n';
					
			}if( $.trim($("#valor_total").val()) == "" ){
				erro++;
				mensagem += ' Informe o valor \n';
			} if(erro > 0){
				alert(mensagem);
				return false;
			}
			else{
				$("#form_odonto_pagamento").submit();
			}
	});
	
	/*- script para os itens -*/
	var cont = 0;
	$("table tbody tr td").find(":checkbox").live('click',function(){
	  
	  var valor = moedaBrToUsa($(this).parent().parent().find("#valor_item").text())*1;
	  var totalTable = moedaBrToUsa($("#total-table").html())*1;	
		
		if($(this).is(":not(:checked)")){	
			cont--;
			var tr = $(this).parents("tr");
			tr.removeClass("marcado");
			
			var id = tr.attr("id");
			total = (totalTable - valor);
			var totalS = String(total);
			var sinal = totalS.indexOf("-");
			
			if( sinal === -1  )
				var valor_total = total;
			else 
				var valor_total = total.split('-');
			
			$("#total-table").html(moedaUsaToBR(valor_total.toFixed(2)));		
			$("#valor_total").val(moedaUsaToBR(valor_total.toFixed(2)));
			
			$.post("modulos/odonto/pagamento/requisicoes.php",{acao:"pendente",id:id},function(data){ console.log(data); });
			  	
		} else{
			cont++;
			var tr = $(this).parents("tr");
			tr.addClass("marcado");
			var id = tr.attr("id");
			
			total = (totalTable + valor);
			
			var totalS = String(total);
			var sinal = totalS.indexOf("-");
			
			if( sinal === -1  )
				var valor_total = total;
			else 
				var valor_total = total.split('-');
			
			$("#total-table").html(moedaUsaToBR(valor_total.toFixed(2)));		
			$("#valor_total").val(moedaUsaToBR(valor_total.toFixed(2)));
			
			$.post("modulos/odonto/pagamento/requisicoes.php",{acao:"aprovar",id:id},function(data){ console.log(data); });
		}
		
		if(cont > 0)
			$("#valor_total").addClass("marcado");
		else 
			$("#valor_total").removeClass("marcado");
	});
	
/*- script para pagamentos -*/
$("select#parcelas").live('change',function(){	
		/*-recebe o valor total-*/
		var valor = $("#valor_total").val();
		if($.trim(valor) == ""){
			alert("Não existe valor! ");
			return false;	
		}
		/*-recebe a quantidade de parcelas-*/
		var qtd = $(this).val();
		/*-recebe a data da primeira parcela-*/
		var DataPrimeiraParcela = $("#pri_parcela").val(); 
		/*-recebe o ID do documento-*/
		var id = $("#id").val();
			
		if( (qtd > 1) && ($.trim(valor) != "")){	
			$("#info_parcela").show();	
			$("#info_parcela").html('');
			var total;
			var valor_total;
			
			total = valor.split('-');
			if(total[1] > 0)
				valor_total = total[1];
			else  
				valor_total = valor;
			
			var TotalPagamento = moedaBrToUsa(valor_total)*1;
			var ResultadoDivisao = (TotalPagamento/qtd);
			dias = 0;
			for(i = 0; i < qtd; i++){	
				var j = i+1;							
				var dmy = DataPrimeiraParcela.split("/"); 
				var joindate = new Date(parseInt(dmy[2], 10),parseInt(dmy[1], 10) - 1,parseInt(dmy[0], 10));
				joindate.setDate(joindate.getDate() + dias); 
				
				var campo_parcela = $('<div style="clear:both;"></div>\
				<label>Descri&ccedil;&atilde;o Parcela<br><input type="text" name="descricao_parcela[]" id="descricao_parcela" value="Odonto pagamento parcela '+j+' N&ordm; '+id+' "></label>\
				<label>Data Vencimento<br/><input size="9" type="text" name="data_vencimento_parcela[]" calendario="1" id="data_vencimento_parcela'+j+'" value="'+("0" + joindate.getDate()).slice(-2) + "/" + ("0" + (joindate.getMonth() + 1)).slice(-2) + "/" + joindate.getFullYear()+'"></label>\
				<label>Valor Parcela <strong> x '+j+'</strong><br><input type="text" name="valor_parcela[]" id="valor_parcela" size="8" readonly="readonly" value='+moedaUsaToBR(ResultadoDivisao.toFixed(2))+'></label>');					
				$("#info_parcela").append(campo_parcela);
				dias += 30;
			}
		} else{
				$("#info_parcela").hide();
		}
	}) /* fim script pagamentos */
}); 
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get" autocomplete="off">
   	 <a></a>
    <input type="hidden" name="cliente_id" id="cliente_id">
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" autocomplete="off" busca="modulos/odonto/buscas/busca_clientes.php,@r0,@r0-value>busca|@r1-value>cliente_id,0" name="busca" id="busca" />
   
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Ondontologo 
</a>
<a href="#" class="navegacao_ativo">
<span></span>  Pagamento
</a>
</div>
<div id="barra_info">
 
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="40">COD</td>
            <td width="230">Nome</td>
            <td width="70">Cadastro</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" class="lista_pagamento">
   		<tbody>
		<?php 
		
		$sql = mysql_query($t=" 
		
		SELECT *, atendimento.id AS numero_doc FROM odontologo_atendimentos AS atendimento
		
		JOIN odontologo_atendimento_item AS atendimento_item ON atendimento_item.odontologo_atendimento_id = atendimento.id
		
		WHERE atendimento.vkt_id = '$vkt_id' GROUP BY atendimento_item.cliente_fornecedor_id "); 
	
			while($odonto_item=mysql_fetch_object($sql)){
				$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$odonto_item->cliente_fornecedor_id' "));
		?>
        <tr id="<?=$odonto_item->numero_doc?>" cliente="<?=$cliente->id?>">
            <td width="40"><?=$odonto_item->numero_doc;?></td>
        	<td width="230"><?=$cliente->razao_social;?></td>
            <td width="70"><?=dataUsaToBr($odonto_item->data_cadastro)?></td>
            <td></td>
        </tr>
        <?
				}
		?>
        </tbody>
</table>

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

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
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
