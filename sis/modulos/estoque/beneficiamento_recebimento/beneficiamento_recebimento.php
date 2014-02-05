<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php"); 
?>


<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<script>
$("#qtd_realizado").live('blur',function(){	
			var qtd = $(this).val();
			var id_item = $(this).parent().parent().find('#item_id').val();
			
			var dataString = 'id_item='+id_item+'&qtd='+qtd;
			
		$.ajax({
			type: "POST",
			url: "modulos/estoque/beneficiamento_recebimento/recebimento.php?acao=update_qtd_item",
			data: dataString,
			cache: false,
 		 }); /* Fim Ajax*/
		//return false;
});/* Fim Script */	

$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
			//alert(id);
		window.open('modulos/estoque/beneficiamento_recebimento/form.php?id='+id,'carregador');
});

$("#derivado_mais").live('click',function(e){
		
	var beneficiamento_id = $("#pedido_id").val();
	var produto_id        = $("#produto_derivado_id").val();
	var produto           = $("#produto_derivado").val();
	
	var qtd_derivado        = $("#qtd_derivado").val();
	var obs_derivado        = $("#obs_derivado").val();
	 
			var dados = 'beneficiamento_id='+beneficiamento_id+'&produdo_id='+produto_id+'&produto='+produto+'&qtd='+qtd_derivado+'&obs_item='+obs_derivado;
			//alert(dados)
						$.ajax({
							url: 'modulos/estoque/beneficiamento_recebimento/recebimento.php?acao=add_derivado',
							type: 'POST',
							data: dados,
							success: function(data, textStatus) {
								$('#result_derivado').append(data);
								$('#produto_derivado').val("");
								$('#qtd_derivado').val("");
								$('#obs_derivado').val("");							
							},
						}); /* Fim Ajax*/	
		
})

$("#qtd_realizada,#aparas,#descarte,#perda").live('blur',function(){
				
				var aparas    = moedaBrToUsa($("#aparas").val())*1;
				var descarte  = moedaBrToUsa($("#descarte").val())*1;
				var perda     = moedaBrToUsa($("#perda").val())*1;
				var beneficiamento = $("#pedido_id").val();
				
				var totalDesperdicio = (aparas+descarte+perda);
				
				var realizado = moedaBrToUsa($("#qtd_realizada").val());
				
				if(realizado>0){
					var desgelo = (realizado - totalDesperdicio);
				}
					var dados = 'aparas='+aparas+'&descarte='+descarte+'&perda='+perda+'&desgelo='+desgelo+'&qtd_realizada='+realizado+'&beneficiamento='+beneficiamento;
			
							$.ajax({
								url: 'modulos/estoque/beneficiamento_recebimento/recebimento.php?acao=desgelo',	
								type: 'POST',
								data: dados,					
							})
				
				$("#desgelo").val(moedaUsaToBR(desgelo))
				
})

$("#obs_item").live('blur',function(){
			var obs_item = $(this).val();
			var beneficiamento = $(this).parent().parent().find("#item_id").val();
			var produto_id = $(this).attr('lang');
			var dados = 'obs_item='+obs_item+'&beneficiamento='+beneficiamento+'&produto_id='+produto_id;
			
			//alert(dados);
				 $.ajax({
						url: 'modulos/estoque/beneficiamento_recebimento/recebimento.php?acao=obs_item',	
						type: 'POST',
						data: dados					
				 });
})
</script>

<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
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
<a href="?tela_id=200" class="navegacao_ativo">
<span></span>    <?=$tela->nome?>
</a>
</div>
<div id="barra_info">
	<div style="float:left; margin-top:1px;">
        <div style="margin-top:-4px; padding:2px;">
        <form method="get">
        <input name='tela_id' value="200" type="hidden" />
        <select name="status" id="status">
            <option>Status</option>
            <option <? if($_GET['status'] == '1'){echo 'selected="selected"';} ?>value="1">Aguardando</option>
            <option <? if($_GET['status'] == '2'){echo 'selected="selected"';} ?>value="2">Recebido</option>
            
        </select>
        <input type="submit" value="Filtrar">
        </form>
        </div>
    </div>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="50">N&ordm;</td>
        	<td width="200">Produto</td>
            <td width="60">Quantia</td>
            <td width="55">Unidade</td>
            <td width="200">Observaçao</td>
            <td width="70">Realizado</td>
            <td width="70">Status</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody id="tabela_dados">
    <?php
			if(!empty($_GET['busca'])){
				$busca = "AND e.pedido_id = ".$_GET['busca'];	
			}
			if(isset($_GET['status'])){
				$and_status = "AND e.status = ".$_GET['status'];	
			}
	
    		$pedido=mysql_query(" SELECT *,
															e.id as pedido_beneficiamento_id 
														FROM estoque_beneficiamento_pedido e
															JOIN produto p ON e.produto_beneficiado_id=p.id  
																WHERE e.vkt_id = '$vkt_id' 
																AND e.status <> '3'
																$and_status	$busca
																ORDER BY e.id DESC								
																");
				while($pedido_item=mysql_fetch_object($pedido)){
							if($pedido_item->status == '2'){
									$status = "Recebido";
							} else if($pedido_item->status == '1') {
									$status = "Aguardando";
							} else{ $status = "Cancelado";}
	?>
    <tr style="background-color:#999; color:white;" id="<?=$pedido_item->pedido_beneficiamento_id;?>">
    	<td width="50"><?=$pedido_item->pedido_beneficiamento_id;?></td>
    	<td><?=$pedido_item->nome;?></td>
        <td width="60"><?=moedaUsaToBr($pedido_item->qtd_pedido)?></td>
        <td width="55"><?=$pedido_item->unidade?></td>
        <td width="200"><?=$pedido_item->obs;?></td>
        <td width="70"><?=moedaUsaToBr($pedido_item->qtd_realizada)?></td>
        <td width="70"><?=$status?></td>
        <td></td> 
    </tr>
    <?
				
    	$sql_item = mysql_query("SELECT * FROM estoque_beneficiamento_item i
									JOIN produto p	on i.produto_id=p.id
										WHERE beneficiamento_id =".$pedido_item->pedido_beneficiamento_id);
		
					while($item=mysql_fetch_object($sql_item)){
	?>
    <tr class="produtos_tabela" id="<?=$item->beneficiamento_id?>">
        <td width="50"></td>
        <td width="200"><?=$item->nome?></td>
        <td width="60"><?=moedaUsaToBr($item->qtd_pedida*$item->conversao2)?></td>
        <td width="55"><?=$item->unidade_uso?></td>
        <td width="100"><?=$item->obs_item_pedido?></td>
        <td width="70"><?=moedaUsaToBr($item->qtd_realizada*$item->conversao2)?></td>
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
