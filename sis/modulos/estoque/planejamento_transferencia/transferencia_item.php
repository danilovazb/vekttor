<?
// funçoes do modulo empreendimento 
include("_functions.php");
include("_ctrl.php");

//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.g td{background:url(../fontes/img/bb.jpg)}
.alert-input {
     background-color: pink;
	    
}

.dg{width:120px; text-align:right; padding:0;}
.dg .und{ width:80px;}
</style>
<script type="text/javascript">
/* Variaveis Globais */
var caminho = 'modulos/estoque/planejamento_transferencia/itens_transferencia.php';
var cont = 0;

$(document).ready(function(){
	$("#dados tr:odd").addClass('al');
})


function funcao_bsc2(resultado,acao,origem){
	var transferencia_id = $("#transferencia_id").val();
	var produto_id       = $("#produto_id").val();
		
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

}



/*quando ele clica para atualizar quantidade*/
$("#qtd_bd, .und").live('blur',function(e){	
  
  var produto_id = $(this).parent().parent().attr('id');
  var transferencia_id = $("#transferencia_id").val();
  var item_id = $(this).parent().parent().attr('item-id');
  var und     = $(this).parent().parent().find('.und').val();
  var qtd     = $(this).parent().parent().find('#qtd_bd').val();
  var conversao = $(this).parent().parent().find('.conversao').val();
  var gramatura = $(this).parent().parent().find('.gramatura').val();
   
  $.post(caminho+'?acao=upqtd',
	{
	  qtd:qtd,
	  id_p:produto_id,
	  item_id:item_id,
	  trans_id:transferencia_id,
	  und:und,
	  conversao:conversao
	},function(dados){
		
		$("#t"+item_id).text(dados);	
	}
	
  );	  							
});/* Fim Script */

$(".delete").live('click',function(){
  var transferencia_id = $("#transferencia_id").val();
  var item_id = $(this).parent().parent().attr('item-id');
  
  var produto_id = $(this).parent().parent().attr('id');
  var b=$(this).parent().parent();
	if(confirm("Deseja realmente excluir?")){
		$.post(caminho+'?acao=exclui',{produto:produto_id,item_id:item_id},
			function(e){
				b.remove();
			}
		);
		return false;
	} /* fim de if(confirm)*/
	
	
});/* Fim Script */	
	
$("#cancelar").live("click",function(){
	var transferencia_id = $("#transferencia_id").val();
	$.post(caminho+'?acao=cancelar',{trans_id:transferencia_id},function(){ location.href=('?tela_id=192');});		
});

/*-enviar-*/
$("#envia_transferencia").live("click",function(){ 
	var j=0;
	$(".qtd_pedida").each(function(i,item) {
        var qtdPedida = moedaBrToUsa($(this).val())*1;
		var saldo = moedaBrToUsa($("input[class='saldoOrigem"+i+"']").val())*1;
			if(qtdPedida > saldo){
				$("input[lang='qtd_pedida"+i+"']").addClass('alert-input');
				j += 1;	
			} else{
				j - 1;
				$("input[lang='qtd_pedida"+i+"']").removeClass('alert-input');
			}
    });
	
	if(j == 0){
		$("#form_enviar").submit();
		$(this).hide();
	}
});

/*-ocorrencia-*/
$("#oc_pedido").live('blur',function(e){ 
	var transferencia_id = $("#transferencia_id").val();
	$.post(caminho+'?acao=oc_pedido',{ trans_id:transferencia_id,oc_pedido:$("#oc_pedido").val()} );
});/* Fim Script */

/* OCORRENCIA ITEM DO PEDIDO */
$("#oc_pedido_item").live("blur",function(){			
  
   var produto_id = $(this).parent().parent().attr('id');
   var item_id = $(this).parent().parent().attr('item-id');
  
   var transferencia_id = $("#transferencia_id").val();
   
   $.post(caminho+'?acao=oc_pedido_item',
	   {
		  oc_item:$(this).val(),
		  p:produto_id,
		  item_id:item_id,
		  trans_id:transferencia_id
	   }
  );
  
   		
}); /* Fim Script*/

$("#duplica_transferencia").live('click',function(){

	var transferencia_id = $("#transferencia_id").val();
	
	var dados = 'transferencia_id='+transferencia_id+'&acao=duplica_transferencia';
		
	$.ajax({
		url: 'modulos/estoque/transferencia/acao.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
		success: function(data, textStatus) {
			
			var dados = data.split("|");
			
			id         = dados[0];
			id_origem  = dados[1];
			id_destino = dados[2];
			
			location.href='?tela_id=193&acao=edit&id='+id+'&id_origem='+dados[1]+'&id_destino='+dados[2]+"&status=0";			
			
		},
	});

});

$("#produto").live('blur',function(){
	
	var produto_id = $("#produto_id").val();
	
	var dados = 'produto_id='+produto_id+'&acao=consulta_produto';
		
	$.ajax({
		url: 'modulos/estoque/transferencia/acao.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
		success: function(data, textStatus) {
			
			$("#unidade_produto").html('');
			$("#unidade_produto").html(data);			
			
		},
	});
	
});
$("#adicionar").live('click',function(){
	
	var transferencia_id = $("#transferencia_id").val();
	var ultimo_numero_item = $('#tbody tr').length;
	var unidade_selecionada = $("#und_novo_produto").val();
	var unidade_embalagem   = $("#conversao_embalagem_novo_produto").val();
	var unidade_uso         = $("#unidade_uso_novo_produto").val();
	var conversao           = $("#conversao_novo_produto").val();
	var selecionado         ="";
	ultimo_numero_item += 1;
	
	var dados = "transferencia="+transferencia_id+"&produto_id="+$("#produto_id").val()+"&origem="+$("#id_origem").val()+"&destino="+$("#id_destino").val()+"&qtd="+$("#qtd1").val();
	 if(cont > 0){
		cont = cont; 
	  }
	 $.ajax({
		url:caminho+"?acao=cadastra",
		type:"POST",
		data:dados,
		dataType:"json",
		success: function(data){
			var htmlLista = "";
			$.each(data,function(i,item){
				htmlLista='<tr id="'+item.produto_id+'" item-id="'+item.id+'">\
					  <td width="30">'+ultimo_numero_item+'</td>\
					  <td width="190">'+item.produto_nome+'</td>\
					  <td class="dg">\
					  <input type="hidden" name="produtoID[]" id="produtoID" value="'+item.produto_id+'">\
            		  <input type="hidden" name="conversao2[]" id="conversao2" value="'+item.conversao2+'">\
					  <input type="text" name="qtd_bd[]" id="qtd_bd" size="5" style="font-size:11px;" class="qtd_pedida" lang="qtd_pedida'+cont+'" value="'+item.qtd+'">\
					  <select class="und" name="und[]">\
					  	<option value="unidade_embalagem">'+unidade_embalagem+'</option>\
						<option value="unidade_uso">'+unidade_uso+'</option>\
					  </select>\
					  <input type="hidden" name="conversao" class="conversao" value='+conversao+' >\
					  </td>\
					  <td width="90" id="t'+item.id+'">\
					  </td>\
					  <td width="100" title="Unidade de Embalagem">\
					  <input type="hidden" name="saldo_origem[]" id="saldo_origem" value="'+item.saldo_origem+'" class="saldoOrigem'+cont+'">\
					  '+item.saldo_origem+' '+item.embalagem+'</td>\
					  <td width="100" title="Unidade de Embalagem">'+item.saldo_destino+' '+item.embalagem+'</td>\
					  <td width="166"><input type="text" lang="'+item.produto_id+'" name="oc_pedido_item" id="oc_pedido_item" value="" style="height:10px;font-size:11px;"></td>\
					  <td><a href="#" class="delete" lang="'+item.produto_id+'"><img src="modulos/estoque/transferencia/menos.png"></a></td>\
				</tr>';
			})
			$("#produto_id").val('');
			$("#produto").val('');	
			$("#qtd1").val('');	
			$('#tbody').append(htmlLista);
			$("#dados tr:odd").addClass('al');
			$("#unidade_produto").html('');	
			cont++;
		}
	  });
});
$(".marcado").live('click',function(){
	var id=$(this).parent().parent().attr('item-id');
	var produto_id = $(this).parent().parent().find("#produto_id").val();
	
	//alert(id);
	if($(this).attr('checked')){
		marcado='sim';		
	}else{
		marcado='nao';
	}
	
	var dados = 'item_id='+id+'&acao=marcar&marcado='+marcado;
	
	window.open('modulos/estoque/planejamento_transferencia/itens_transferencia.php?'+dados,'carregador');	
	/*$.ajax({
		url: 'modulos/estoque/transferencia_planejamento/itens_tranferencia.php', 
		dataType: 'html',
		type: 'POST',
		data: dados,
		success: function(data, textStatus) {
			
			$("#unidade_produto").html('');
			$("#unidade_produto").html(data);			
			
		},
	});*/
	
	//$("").load('modulos/estoque/transferencia/itens_tranferencia.php?acao=marcar&item_id='+id+'&marcado='+marcado);
});
$(".mais").live('click',function(){
	var id=$(this).parent().parent().attr('item-id');
	var comensais=$("#comensais").val();
	var tbody=$(this).parent().parent().attr('cont_tbody');
	var al=$(this).parent().parent().attr('class');
	
	
		
	var dados = "item_id="+id+'&comensais='+comensais+'&al='+al+'&cont_tbody='+tbody;
	 if(cont > 0){
		cont = cont; 
	  }
	 $.ajax({
		url:caminho+"?acao=duplica_item",
		type:"POST",
		data:dados,
		dataType:"html",
		success: function(data){
			
			$("#tbody"+tbody).append(data);
			
			//$("#tbody"+tbody).addClass('al');
		}
	 });
	 //$("#tbody"+tbody).addClass('al');
});
$(".qtd_calc").live('click',function(){
	qtd_calc = $(this).text();
	
	$(this).parent().parent().find('.qtd_pedida').val(qtd_calc);
	$(this).parent().parent().find('.und').find('option:eq(1)').attr('selected','selected');
});
$("#comensal").live('blur',function(){
	var comensal = $(this).val();
	var transferencia_id = $("#transferencia_id").val();
	var id_origem = $("#id_origem").val();
	var id_destino = $("#id_destino").val();
	dados = 'comensal='+comensal+'&transferencia_id='+transferencia_id+'&id_origem='+id_origem+'&id_destino='+id_destino;
	$.ajax({
		url:caminho+"?acao=altera_comensal",
		type:"POST",
		data:dados,
		dataType:"html",
		success: function(data){
			location.href='?tela_id=518&acao=edit&id='+transferencia_id+'&id_origem='+id_origem+'&id_destino='+id_destino+'&status=0';	
				
		}
	 });
	//window.open(caminho+'?,"carregador");
	//setInterval(3);
	
});
$(".gramatura").live('blur',function(){
	var gramatura = $(this).val();
	var comensal = $("#comensal").val();
	var produto_id=$(this).parent().parent().attr('id');
	var transferencia_id = $("#transferencia_id").val();
	var item_id = $(this).parent().parent().attr('item-id'); 
	dados = 'gramatura='+gramatura+'&produto_id='+produto_id+'&transferencia_id='+transferencia_id+'&item_id='+item_id;
	$.ajax({
		url:caminho+"?acao=altera_gramatura",
		type:"POST",
		data:dados,
		dataType:"html",
		success: function(data){
			
			//alert(data);
			//location.href='?tela_id=518&acao=edit&id='+transferencia_id+'&id_origem='+id_origem+'&id_destino='+id_destino+'&status=0';	
				
		}
	 });
	 qtd_calc = qtdBrToUsa(gramatura,2) * qtdBrToUsa(comensal,2);
	 $(this).parent().parent().find('.qtd_calc').html('');
	 $(this).parent().parent().find('.qtd_calc').text(qtdUsaToBr(qtd_calc,2));
	
});
</script>
<style>
.qtd_pedida{ text-align:right}
</style>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">&laquo;</div>
<a href="../transferencia - Cópia/?" class='s1'>
  	Sistema NV
</a>
<a href="../transferencia - Cópia/?" class='s2'>
  	Estoque
</a>
<a href="../transferencia - Cópia/?tela_id=96" class='navegacao_ativo'>
<span></span>    Transfer&ecirc;ncia de Mercadoria
</a>
</div>
<div id="barra_info">
  
  <div style="float:left;"><?php
  //$display='none';
  ?><strong>Origem:</strong> <?=$origem_nome->nome;?></div>
  <div style="float:left;margin-left:15px;"><strong>Destino:</strong> <?=$destino_nome->nome;?></div>
  <div style="float:left;margin-left:15px;"><strong>N&ordm; Transfer&ecirc;ncia: </strong><?=$transferencia_id?></div>
  <div style="float:left;margin-left:15px;"><strong>Comensais: </strong>
  	<input type="text" name="comensais" value="<?=$transferencia->comensal?>" id="comensal" style="width:20px;height:8px;"/>
  </div>
  <div style="float:left;margin-left:15px;"><strong>Data: </strong>
  	<? if($_GET['acao'] == 'cadastra'){
	  echo $data;
	 } else{
 	 	echo dataUsaToBr($transferencia->data_inicio);
	 	}
	?>
    
    <input type="button" name="duplica_transferencia" id="duplica_transferencia" value="Duplicar Transfer&ecirc;ncia" />
    
  </div>
  	
 	<div style="float:right; margin-right:15px;">
    		<? 
			if($transferencia->status == '3' or $transferencia->status == '1' or $transferencia->status == '2')
				$disable = 'disabled="disabled"';
			?>
        	<input name="action"  type="button"  value="&laquo;" onclick="location.href='?tela_id=517'" />    	
            <input <?=$disable?> type="button" id="envia_transferencia" value="Enviar">
        <? ?>
        <input type="button" value="Imprimir" onclick="window.open('modulos/estoque/transferencia/impressao_transferencia.php?id=<?=$transferencia_id?>','_BLANK')" /> 
   </div>
</div>
<form name="form_enviar" id="form_enviar" method="post">

<!--<div id="barra_info">-->
<input type="hidden" name="comensais" id="comensais" value="<?=$comensais->comensais?>">
<input type="hidden" name="opcao" value="enviar">
<input type="hidden" name="id_origem" id="id_origem" value="<?=$_GET['id_origem']?>">
<input type="hidden" name="id_destino" id="id_destino" value="<?=$_GET['id_destino']?>">
<input type="hidden" id="flag" value="0" />
<input type="hidden" name="produto_id" id="produto_id">
<input type="hidden"  name="transferencia_id" id="transferencia_id" value="<?=$transferencia_id;?>">
                <!-- input para selecionar o produto
          		<label>
                Produto: <input type="text" id='produto'
                onkeyup="return vkt_ac(this,event,'0','modulos/estoque/transferencia/busca_produtos.php?id_origem=<?=$_GET['id_origem']?>','@r0','funcao_bsc2(this,\'@r1-value>produto_id\',\'produto\')')"
                 autocomplete='off' name="produto" value=""  valida_minlength="3"  retorno='focus|Coloque no minimo 3 caracter' style="width:170px;height:10px;font-size:11px;"  	/>
                 </label>
                 <label>	
				Qtd: <input type="text" name="qtd" id="qtd1" size="5" style="font-size:11px;" value="">
                </label>
                <label id="unidade_produto">	
					
                </label>
                <label >	
				 <input type="button" id="adicionar" value="Adicionar">
                </label>
</div>-->


<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    <!--<tr <?=$sel?>>
          <td width="190">
          		<input type="hidden"  name="transferencia_id" id="transferencia_id" value="<?=$transferencia_id;?>">
                <!-- input para selecionar o produto
          		<input type="text" id='produto'
                onkeyup="return vkt_ac(this,event,'0','modulos/estoque/transferencia/busca_produtos.php?id_origem=<?=$_GET['id_origem']?>','@r0','funcao_bsc2(this,\'@r1-value>produto_id\',\'produto\')')"
                 autocomplete='off' name="produto" value=""  valida_minlength="3"  retorno='focus|Coloque no minimo 3 caracter' style="width:170px;height:10px;font-size:11px;"  	/>
          </td>
           <td width="70"><input type="text" name="qtd" id="qtd1" size="5" style="font-size:11px;" value="1"></td>
						<? if($_GET['status'] == 2){ ?>
                        <td width="90" colspan="4"></td>
                        <td width="70" colspan="3"><strong>Recebimento</strong></td>
                        <? } ?>
        </tr>-->
        <tr class='g'>
          <td width="30">Item</td>
          <td width="30"></td>
          <td width="160">Produto</td>
          <td width="60">Gramatura</td>
          <!--<td width="60">Comensais</td>-->
          <td width="60" title="Quantidade Calculada" rel="tip">Qtd. Calc.</td>
          <td class="dg" title="Quantidade Enviada" rel="tip">Qtd. Enviada</td>
          <!--<td width="130">QTD</td>
          <td width="90">QTD</td>-->
          <td width="75" title="Unidade de Embalagem">Esto. Origem </td>
          <td width="75" title="Unidade de Embalagem">Esto. Destino </td>
          <td width="150">Ocorrencia</td>
		  <? if($_GET['status'] == 2){ ?>
          <td width="190">Ocorrencia</td>
          <td width="50">recebeu</td> 
          <? } ?>
          <td></td>
        </tr>
</thead>  
</table>  
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
        <div id="aqui"></div>
        
        <?
		$grupo_produtos = mysql_query("SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id'");
        	
		//if($_GET['acao'] == 'edit'){
			$cont = 0;
			
			$cont_tbody = 0;
			while($grupo_produto = mysql_fetch_object($grupo_produtos)){
				
				
				
				
			
				$item = mysql_query($t="SELECT *,i.ocorrencia_recebimento as oc_recebimento, i.id AS item_id, i.gramatura as item_gramatura FROM estoque_transferencia_item AS i 
						 JOIN 
						 	estoque_transferencia AS t  on t.id = i.transferencia_id
						 JOIN 
						 	produto AS p on i.produto_id=p.id WHERE t.id = '$transferencia_id' AND p.produto_grupo_id='$grupo_produto->id' ORDER BY p.nome ASC" );
						//echo $t;
				if(mysql_num_rows($item)>0){
					echo "
				<table style='width:100%'>
				<thead>
				<tr>
    				<td>$grupo_produto->nome</td>
    			</tr>
				</thead>
				</table>";
				}
				echo "<table cellpadding='0' cellspacing='0' width='100%' id='tabela_dados'>
				<tbody id='tbody$cont_tbody'>";
				while($r=mysql_fetch_object($item)){
					
					
					
					//saldo destino
					$estoque_mov_destino = @mysql_fetch_object(mysql_query(" SELECT * FROM estoque_mov WHERE produto_id = '".$r->produto_id."' AND almoxarifado_id = '".$_GET['id_destino']."' AND vkt_id = '$vkt_id' ORDER BY id DESC LIMIT 1"));
					$saldo_destino = @($estoque_mov_destino->saldo / $r->conversao2);
				   //saldo origem
				   $estoque_mov_origem = @mysql_fetch_object(mysql_query(" SELECT * FROM estoque_mov WHERE produto_id = '".$r->produto_id."' AND almoxarifado_id = '".$_GET['id_origem']."' AND vkt_id = '$vkt_id' ORDER BY id DESC LIMIT 1"));
				   $saldo_origem = @($estoque_mov_origem->saldo / $r->conversao2);
				   $qtd = $r->qtd_enviada;
				   if($r->unidade_tipo=="unidade_uso"){
				   		$qtd = $qtd*$r->conversao2;
				   }
				    if($estoque_mov_origem->saldo<$r->estoque_min){
				   		$color="#B94A48";
				   }else{
					   $color="";
				   }
				   
				?>
        <tr id="<?=$r->produto_id;?>" item-id="<?=$r->item_id?>" cont_tbody="<?=$cont_tbody?>">
          <td width="30"><?=($cont+1)?></td>
          <td width="30"><input type="checkbox" name="marcado[]" class="marcado"  <?php if($r->marcado=='sim'){echo "checked='checked'";}?> <?=$disable?>/></td>
          <td width="160"><?=$r->nome;?></td>
          <td width="60">
		  <input type="text" name="gramatura[]" class="gramatura" value="<?=limitador_decimal_br($r->gramatura,4)?>" style="width:50px;text-align:right"/>
          </td>
          <!--<td width="60"><?=qtdUsatoBr($comensais->comensais,2)?></td>-->
          <td width="60" ><span class="qtd_calc"><?=limitador_decimal_br(($r->gramatura*$transferencia->comensal),4)?></span><?=" ".substr($r->unidade_uso,0,2)?></td>
          <td class="dg">
            <input type="hidden" name="produtoID[]" id="produtoID" value="<?=$r->produto_id;?>">
            <input type="hidden" name="conversao2[]" id="conversao2" value="<?=$r->conversao2;?>">
            <input type="text" <?=$disable?> name="qtd_bd[]" id="qtd_bd" class="qtd_pedida"  size="5" lang="qtd_pedida<?=$cont?>" style="font-size:11px;" 
            value="<?=qtdUsatoBr($qtd,2);?>" /> 
            <select class='und' name="und[]" style="width:50px;"><option value='unidade_embalagem' <?=$disable?> <?=$sel[unidade_embalagem]?>><?=substr($r->unidade_embalagem,0,2)." ".limitador_decimal_br($r->conversao2).' '.substr($r->unidade_uso,0,2)?></option><option value='unidade_uso'  <?=$sel[unidade_uso]?> <? if($r->unidade_tipo=="unidade_uso"){echo "selected='selected'";}?>><?=substr($r->unidade_uso,0,2)?></option></select>
          	<input type="hidden" name="conversao[]" class="conversao" value="<?=$r->conversao2?>"/>
          </td>
          <!--<td width="90" id="t<?=$r->item_id?>"><?=qtdUsatoBr($qtd,2)?></td>-->
          <td width="75" align="right" style="color:<?=$color?>">
		  <input type="hidden" name="saldo_origem[]" id="saldo_origem" value="<?=$saldo_origem?>" class="saldoOrigem<?=$cont?>">
		  <?=substr($saldo_origem,0,4)." ".substr($r->unidade_embalagem,0,3)?>
          </td>
          <td width="75" align="right"><?=substr($saldo_destino,0,4)." ".substr($r->unidade_embalagem,0,3)?></td>
          <td width="150" align="right"><input type="text" name="oc_pedido_item" id="oc_pedido_item" value="<?=$r->ocorrencia?>" <?=$disable?> style="font-size:11px;"></td>
          
          	<? if($_GET['status'] == 2){ ?>
           <td width="190" align="right"><?=substr($r->oc_recebimento,0,36);?></td>
           <td width="50" align="right"><?=$r->qtd_recebida;?></td> 
		   	<? } ?>
          <!--<td> <? if(empty($disable)){?> <a href="#" class="delete" lang="<?=$r->produto_id;?>"> <img src="../transferencia - Cópia/modulos/estoque/transferencia/menos.png"></a> <? }?> </td>
          -->
          <td><a target="carregador" class="mais" style="float:left"></a></td>
        </tr>
         
    	<? 		
					$cont++;
				}
			echo "</tbody>
		</table>";
			$cont_tbody++;
			}
		//}
		?>
   

<div>
	<div style="margin:5px;"> <span style="#">Ocorr&ecirc;ncia Pedido:</span>
    	<div>
        <label>
    		<input type="text" style="height:14px;"  name="oc_pedido" id="oc_pedido" size="40" value="<?=$transferencia->ocorrencia_pedido?>" <?=$disable?>>
        </label>
        </div>
    </div>
</div>

<div>
	<div style="margin:5px;"> <span style="#">Ocorr&ecirc;ncia Recebimento:</span>
    	<div>
        	<?=$transferencia->ocorrencia_recebimento?>
        </div>
    </div>
</div>
</div>
</form>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
          <td width="300"><input <?=$disable?> name="action" id="cancelar" type="button"  value="Cancelar"  /></td>
          <td width="70">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>

<div>As comensais representam a soma dos valores de almoço dos contratos da unidade de origem selecionada para esta transfer&ecirc;ncia</div>

</div>
<script>
some_menu();
</script>
