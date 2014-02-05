<?php
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php");
$sqlRevenda = mysql_fetch_object(mysql_query($yb=" SELECT * FROM revenda_franquia WHERE cliente_vekttor_id = '$vkt_id'"));
    
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<style>
	#pagina{
		border:1px solid #000;
		width:840px;
		background:#FFFFFF;
		margin:0px auto;
		box-shadow:2px 1px 2px #333333;
		margin-top:20px;
		padding:20px;
		
	}
	.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}


#scroll-table {  background-color:#F2F2F2;width: 517px;}
#scroll-table table {width: 500px;}
#scroll-table .scrollContainer {width: 517px;height: 150px;overflow: auto;}
#scroll-table thead td span{display: block;}
#scroll-table tbody td span{display: block;}

#scroll-table .coluna0{width: 200px;}
#scroll-table .coluna1{width: 70px;}
#scroll-table .coluna2{width: 70px;}
#scroll-table .coluna3{width: 20px;}
/*-CSS ABA SERVICO -*/
#scroll-table-servico{background-color:#F2F2F2;width: 617px;}
#scroll-table-servico table{width: 600px;}
#scroll-table-servico .scrollContainer {width: 617px;height: 150px;overflow: auto;}
#scroll-table-servico thead td span{display: block;}
#scroll-table-servico tbody td span{display: block;}

#scroll-table-servico .coluna0{width: 200px;}
#scroll-table-servico .coluna1{width: 70px;}
#scroll-table-servico .coluna2{width:120px;}
#scroll-table-servico .coluna3{width: 70px;}
#scroll-table-servico .coluna4{width: 20px;}

</style>

<script>
function rteInsertHTML(html) {
	 rteName = 'ed';
	if (document.all) {
		document.getElementById(rteName).contentWindow.document.body.focus();
		var oRng = document.getElementById(rteName).contentWindow.document.selection.createRange();
		oRng.pasteHTML(html);
		oRng.collapse(false);
		oRng.select();
	} else {
		document.getElementById(rteName).contentWindow.document.execCommand('insertHTML', false, html);
	}
}
function ti(m,v){
    w= document.getElementById('ed').contentWindow.document
	if(m=='InsertHTML' ){
		rteInsertHTML(v);
	}else{
		
	if(m == "backcolor"){
		if(navigator.appName =='Netscape'){
			w.execCommand('hilitecolor',false,v);
		}else{
			w.execCommand('backcolor',false,v);
		}
	}else{
		
		w.execCommand(m, false, v);
	}
	}
}

function html_to_form(){
	
		
		document.getElementById("tx_html").value = document.getElementById("ed").contentWindow.document.body.innerHTML
		
		document.getElementById("ed").contentWindow.document.body.innerHTML.replace("\n","");
}


function insere_txt(txt) {
    var myQuery = document.getElementById("ed").contentWindow.document.body;
    var chaineAj = txt;
	//IE support
	if (document.selection) {
		myQuery.focus();
		sel = document.selection.createRange();
		sel.innerHTML = chaineAj;
	}
	//MOZILLA/NETSCAPE support
	else if (document.getElementById("ed").selectionStart || document.getElementById("ed").selectionStart == "0") {
		var startPos = document.getElementById("ed").selectionStart;
		var endPos = document.getElementById("ed").selectionEnd;
		var chaineSql = document.getElementById("ed").innerHTML;

		myQuery.innerHTML = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
	} else {
		myQuery.innerHTML += chaineAj+'++aaa++';
	}
}

</script>
<script>

 $("#botao_salvar").live('click',function(){
	var arquivo = $("#file").val();
					if($.trim(arquivo) != ""){
							checaprogresso();
							html_to_form();
							$("#form_arquivo").submit();
					}else{
							html_to_form(); 
							$("#form_arquivo").submit();
							//setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500);
					}
});
		
            
            function checaprogresso(){
                id_chave=$("#id_chave").val();
                d = new Date();
                s = d.getTime();
                url = '<?=$tela->caminho?>/informacao_do_progresso.php?id_progresso='+id_chave+'&'+s;	
                carregabarra(url);
            }
            
            
            function carregabarra(url){
                console.log(url);
                if($("#vkt_barra").css('display')=='none'){
                    $("#vkt_barra").slideDown();
                }
                $("#progresso").load(url, function(data) {
                    porcentagem = $("#progresso").html();
                    $("#vkt_barra_progresso").css("width",porcentagem.replace(',','.')+'%');
                
                    if($("#vkt_barra_progresso").css("width")!=100){
                        carregabarra(url);
					}
						if(data > '50,00'){
							location.href='?tela_id=354';	
						}
			
                });
            }
                
            function chegouao100porcento(){
                $('#vkt_barra_progresso').css('width','100%');
            }
</script>
<script>
	$(document).ready(function(){
		$("tr:odd").addClass('al');
		<?
		if($_GET['contato_id']>0){
		?>
			window.open('modulos/revenda_vekttor/venda/form.php?contato_id=<?=$_GET['contato_id']?>','carregador');
		<?
		}
		?>
	});
	$(".exibe_modulos").live('click',function(){
		id = $(this).attr('r');
		$(".exibe_modulos").css('font-weight','normal');
		$(this).css('font-weight','bold');
		$(".submodulos").hide();
		$("#div"+id).show();	
	})
	$("#marcarTodos").live("click",function(){
		//alert(this.checked);
		if(this.checked==true){
			$(this).parent().parent().find(".modulo_id").attr("checked","checked");			
		}else{
			$(this).parent().parent().find(".modulo_id").removeAttr("checked");
		}
	});

/* Script para a ABA Cliente*/
$("#tipo_pessoa").live('click',function(){
				var tipo = $(this).val();
				if(tipo == '1') $("#cliente_cnpj").attr('mascara','__.___.___/____-__'); else $("#cliente_cnpj").attr('mascara','___.___.___-__');
})

/*-remove pacote-*/
$(function(){
		$("#remove-pacote").live('click',function(){
					var id = $(this).parent().parent().parent();
					id.remove();
		})
})

/*-add pacote-*/
var TotalMensal = 0;
var TotalImplantacao = 0;
var TotalVenda = 0;
/*- Valores dos Itens -*/
var valMensal = 0;
var valImplantacao = 0;
$(function(){
	  $(".coluna3 input[type='checkbox']").live('click',function(){
				  if($(this).is(':checked')){
						/* Remove um Item da lista de Remoçao */
						var pcID = $(this).val();
						$("#DelPacote input[value='"+pcID+"']").remove();							
					  /*-Mensalidade-*/
								  /* Verifica se existe algum valor */
									  var ValMensalEdit = moedaBrToUsa($("#subtotal-foot .coluna1 span").html())*1;
							  $(this).parent().parent().parent().find("#valMensalPacote").removeAttr('disabled');									
							  valMensal = moedaBrToUsa($(this).parent().parent().parent().find("#valMensalPacote").val())*1;
									  var valTMensal = (valMensal + ValMensalEdit);									
							  TotalMensal = valTMensal;
							  $("#subtotal-foot .coluna1 span").html(moedaUsaToBR(TotalMensal.toFixed(2)));
								  //Resumo Mensalidade
									  $("#val_mensalidade").val(moedaUsaToBR(TotalMensal.toFixed(2)));
									  $("#view_mensalidade").val(moedaUsaToBR(TotalMensal.toFixed(2)));
					  /*-Implantaçao-*/
								  /* Verifica se axiste algum valor */
									  var ValImplantacaoEdit = moedaBrToUsa($("#subtotal-foot .coluna2 span").html())*1;
							  $(this).parent().parent().parent().find("#valImplatPacote").removeAttr('disabled');
							  valImplantacao = moedaBrToUsa($(this).parent().parent().parent().find("#valImplatPacote").val())*1;
									  var valTImplantacao = (valImplantacao + ValImplantacaoEdit);
							  TotalImplantacao = valTImplantacao;
							  $("#subtotal-foot .coluna2 span").html(moedaUsaToBR(TotalImplantacao.toFixed(2)));
								  //Resumo Implantaçao
									  $("#view_implantacao").val(moedaUsaToBR(TotalImplantacao.toFixed(2)));
									  $("#val_implantacao").val(moedaUsaToBR(TotalImplantacao.toFixed(2)));
					  /*-Total da Venda-*/
							  TotalVenda = (TotalMensal+TotalImplantacao);
							  $("#total-foot .coluna2 span").html(moedaUsaToBR(TotalVenda.toFixed(2)));
								  /* Resumo Total */
									  $("#total_venda").val(moedaUsaToBR(TotalVenda.toFixed(2)));
					  /*- Chama a funcao para somar o (Total Geral) da Venda-*/
									  Total();
				  } else if($(this).is(":not(:checked)")){
					  			/* Array com lista de pacote ID para remover */
								var pcID = $(this).val();
								var ListPC = $('<input type="text" name="InputDelPacote[]" id="InputDelPacote" style="width:80px;" value="'+pcID+'">');
								$("#DelPacote").append(ListPC);
					  
					  /*-Mensalidade-*/
								  /* Verifica se existe algum valor */
									  var ValMensalMEdit = moedaBrToUsa($("#subtotal-foot .coluna1 span").html())*1;
							  var valMensalM = moedaBrToUsa($(this).parent().parent().parent().find("#mensal span").text())*1;
							  var TotalMenosMensal = (ValMensalMEdit - valMensalM);
							  TotalMensal = TotalMenosMensal;
							  
							  $("#subtotal-foot .coluna1 span").html(moedaUsaToBR(TotalMenosMensal.toFixed(2)));
								  //Resumo Mensalidade
									  $("#val_mensalidade").val(moedaUsaToBR(TotalMenosMensal.toFixed(2)));
									  $("#view_mensalidade").val(moedaUsaToBR(TotalMenosMensal.toFixed(2)));
					  /*-Implantaçao-*/
								  /* Verifica se existe algum valor */
									  var ValImplantacaoMEdit = moedaBrToUsa($("#subtotal-foot .coluna2 span").html())*1;
							  var valImplantacaoM = moedaBrToUsa($(this).parent().parent().parent().find("#implantacao span").text())*1;
							  var TotalMenosImplantacao = (ValImplantacaoMEdit - valImplantacaoM);
							  TotalImplantacao = TotalMenosImplantacao;
							  
							  $("#subtotal-foot .coluna2 span").html(moedaUsaToBR(TotalMenosImplantacao.toFixed(2)));
								  //Resumo Implantaçao
									  $("#view_implantacao").val(moedaUsaToBR(TotalMenosImplantacao.toFixed(2)));
									  $("#val_implantacao").val(moedaUsaToBR(TotalMenosImplantacao.toFixed(2)));
					  /*-Total da Venda-*/
							  var TotalVendaMenos = (TotalMensal + TotalImplantacao);
							  TotalVenda = TotalVendaMenos;
							  $("#total-foot .coluna2 span").html(moedaUsaToBR(TotalVendaMenos.toFixed(2)));
								  /* Resumo Total */
									  $("#total_venda").val(moedaUsaToBR(TotalVendaMenos.toFixed(2)));
					  /*- Chama a funcao para somar o (Total Geral) da Venda-*/
									  Total();	
				  }
				  
	  })		
})
/*-add servico-*/
var totalServico = 0;
$(function(){ 
$('#add-servico').live('click',function(){
	var valTableServico = $("#valTableServico").val();
		if(valTableServico == '2'){
			$(".table-add").remove();
		}
		var ServicoID = $("#servico_id").val(); var dados = "id="+ServicoID;
		var obs = $("input[name='obsItemServico']").val();
					$.ajax({
						url:'modulos/revenda_vekttor/venda/servico_item.php?acao=buscaServico',
						type:'POST',
						data: dados,
						dataType:'json',
						success: function(data){
								$("#scroll-table-servico").show();
								var ValTotalEdit = moedaBrToUsa($("#scroll-table-servico #foot-total-servico .coluna3 span").html())*1;	
									
									if($.trim(ValTotalEdit) != ""){
										ValTotalEdit += moedaBrToUsa(data.valor_normal)*1; 		
									}
							totalServico = ValTotalEdit;												
							var tr = $('<tr id="0">\
									<td class="coluna0" id="servico">\
									<input type="hidden" name="servicoItemID[]" value="'+data.id+'">\
									<span>'+data.nome+'</span></td>\
									<td class="coluna1" id="und"><span>'+data.und+'</span></td>\
									<td class="coluna2"><span><input type="text" name="obsItemServico[]" value="'+obs+'" style="width:114px;height:14px;"></span></td>\
									<td class="coluna3" id="valor-normal">\
									<input type="hidden" name="valorItemServico[]" id="valorItemServico" value="'+data.valor_normal+'">\
									<span>'+data.valor_normal+'</span></td>\
									<td class="coluna4"><span><img src="../fontes/img/menos.png" id="menos-servico"></span></td>\
								</tr>');
											// fim de tr
								$("#scroll-table-servico #item-servico tbody").append(tr);
								$("#scroll-table-servico #item-servico tbody tr:even").css("background-color", "#fff");
								$("#scroll-table-servico #item-servico tbody tr:odd").addClass('al');
								$("#servico").val('');
								$("#obsItemServico").val('');
								/*- Escreve o total no final da Tabela -*/
								$("#scroll-table-servico #foot-total-servico .coluna3 span").html(moedaUsaToBR(totalServico.toFixed(2)));
								/* Escreve total de serviço da aba resumo */
									$("#view_servico").val(moedaUsaToBR(totalServico.toFixed(2)));
									$("#val_servico").val(moedaUsaToBR(totalServico.toFixed(2)));
								/*- Chama a funcao para somar o (Total Geral) da Venda-*/
									Total();
						}
					});
	});
$('#menos-servico').live('click',function(){
		  var valTableServico = $("#valTableServico").val();
		  if(valTableServico == '2'){ $(".table-add").remove();}
		  var id = $(this).parent().parent().parent().attr('id');
		  var TRRemove = $(this).parent().parent().parent(); 
		  var ValorNormal = moedaBrToUsa($(this).parent().parent().parent().find(".coluna3 span").text())*1;
		  var ValTotalEdit = moedaBrToUsa($("#scroll-table-servico #foot-total-servico .coluna3 span").html())*1; /* Aqui ele pega o valor total da venda */		  
			  if($.trim(ValTotalEdit) != ""){var TotalFinal = (ValTotalEdit - ValorNormal);	 }		
		totalServico = TotalFinal; 
		$("#scroll-table-servico #foot-total-servico .coluna3 span").html(moedaUsaToBR(totalServico.toFixed(2)));
		
	if(id != 0){
	  /* Aqui um vetor com a lista dos itens para remove */
		var ListDel= $('<input type="text" name="InputDelServico[]" id="InputDelServico" style="width:70px;" value="'+id+'" >');
		$("#DelServico").append(ListDel);
	}
	
		/*Remove TR*/
		TRRemove.remove();
		/* Escreve total de serviço na aba resumo */
			$("#view_servico").val(moedaUsaToBR(TotalFinal.toFixed(2)));
			$("#val_servico").val(moedaUsaToBR(TotalFinal.toFixed(2)));
		/*- Chama a funcao para somar o (Total Geral) da Venda-*/
			Total();
					
});

$("#cliente_nome_fantasia").live('focus',function(){
			var nome = $("#cliente_nome").val();
			var n_fantasia = $(this).val();
				if($.trim($(this).val()) == ""){
					$(this).val(nome);
				}
	})
});
$("#cliente_nome").live('blur',function(){
		var cliente = $(this).val();
		$("#nome_usuario").val(cliente);
})

$("#val_desconto").live('keyup',function(){
		var valImplantacao = moedaBrToUsa($("#val_implantacao").val())*1;
		var valServico     = moedaBrToUsa($("#val_servico").val())*1;		
		var desconto       = moedaBrToUsa($(this).val())*1;
		var subtotal = (valImplantacao + valServico - desconto);
		$("#sub-total").val(moedaUsaToBR(subtotal.toFixed(2)));
		/*--*/
		var totalVenda = moedaBrToUsa($("#total_venda").val())*1;
		var porcentagem = ( desconto / totalVenda ) * 100;
		$("#porcentDesconto").val(moedaUsaToBR(porcentagem.toFixed(1)));
});

$("#porcentDesconto").live('keyup',function(){
	
	var valEstipulado = $("#porcento_negociacao").val();
	  var valPorcentagem = moedaBrToUsa($(this).val())*1;
	  	if(valPorcentagem <= valEstipulado){
			  var totalVenda = moedaBrToUsa($("#total_venda").val())*1;
			  var porcentagem = (valPorcentagem / 100) * totalVenda;
			  var subtotal = (totalVenda - porcentagem);
			  $("#sub-total").val(moedaUsaToBR(subtotal.toFixed(2)));
			  $("#val_desconto").val(moedaUsaToBR(porcentagem.toFixed(2)));
		} else{
			alert(' Valor maximo de desconto: '+valEstipulado);
			var vPval = $("#porcento_negociacao").val();
			$("#porcentDesconto").val('');
			//return false;	
		}
});

function Total(){
	  var valImplantacao = moedaBrToUsa($("#val_implantacao").val())*1;
	  var valServico = moedaBrToUsa($("#val_servico").val())*1;
	  var total = (valImplantacao + valServico);
	  $("#total_venda").val(moedaUsaToBR(total.toFixed(2)));
}
$(function(){
	var todosCheckboxes = $('.scrollContainer').find(':checkbox');
		if(todosCheckboxes.is(":checked")){
				for(i=0; i < todosCheckboxes.length; i++){
						$(todosCheckboxes[i]).css('background-color','#CCC');	
				}
		}	
})
</script>
<div id="some">«</div>
<a href="./" class='s1' >
  	Sistema
</a>
<a href="./" class='s2'>
    Revenda Vekttor 
</a>
<a href="?tela_id=354" class="navegacao_ativo">
<span></span> Venda 
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="75">N&ordm;</td>
            <td width="280">Cliente</td>
            <td width="100">Vendedor</td>
            <td width="83">Mensalidade</td>
            <td width="85">Implanta&ccedil;&atilde;o</td>
            <td width="85">Servi&ccedil;o</td>
            <td width="90">Total</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
<input type="hidden" name="porcento_negociacao" id="porcento_negociacao" value="<?=$sqlRevenda->porcento_negociacao;?>">
    <tbody>
	
	<?
	
	if(is_numeric($_GET['busca'])){
			$busca_add =" AND id = '".$_GET['busca']."'";	
	}
	
	/*if(strlen($_GET['busca'])>0){
		$busca_add = "AND nome_fantasia like '%{$_GET[busca]}%'";
	}*/
	
	
	// colocar a funcao da paginação no limite
	$sql= mysql_query("SELECT * FROM vekttor_venda WHERE revenda_franquia_id = '$vkt_id' $busca_add ");
	
	while($venda=mysql_fetch_object($sql)){
		$cliente_vekttor = mysql_fetch_object(mysql_query(" SELECT * FROM  clientes_vekttor WHERE id = '$venda->cliente_vekttor_id' "));
		$vendedor = mysql_fetch_object(mysql_query(" SELECT * FROM rh_funcionario WHERE id = '$venda->vendedor_id'"));
		//echo $t;
		

	?>
			<tr <?=$sel?>onclick="window.open('<?=$caminho?>/form.php?id=<?=$venda->id?>','carregador')">
            	<td width="75"><?=$venda->id;?></td>
                <td width="280"><?=$cliente_vekttor->nome?></td>
                <td width="100"><?=$vendedor->nome;?></td>
                <td width="83"><?=moedaUsaToBr($venda->valor_mensalidade);?></td>
                <td width="85"><?=moedaUsaToBr($venda->valor_implantacao);?></td>
                <td width="85"><?=moedaUsaToBr($venda->valor_servico);?></td>
                <td width="90"><? if(!empty($venda->subtotal)){ echo moedaUsaToBr($venda->subtotal);} else{echo moedaUsaToBr($venda->total);}?></td>
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
