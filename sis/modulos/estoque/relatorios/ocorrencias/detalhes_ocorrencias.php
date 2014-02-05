<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

//filtros
if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
	//filtro para compras e transtrefencias
	$filtro_compras_transferencias = "AND data_inicio BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para compras itens
	$filtro_compras_itens = "AND ec.data_inicio BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para transferencias itens
	$filtro_trans_itens = "AND et.data_inicio BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para inventário
	$filtro_inventario            = "AND ei.data_criado BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para beneficiamento
	$filtro_beneficiamento        = "AND data_pedido BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	//filtro para beneficiamento item
	$filtro_beneficiamento_item   = "AND ebp.data_pedido BETWEEN '".DataBrToUsa($_GET['data_ini'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
}else{
	$filtro_compras_transferencias = "AND MONTH(data_inicio)=MONTH(NOW())";
	//filtro para compras itens
	$filtro_compras_itens = "AND MONTH(ec.data_inicio)=MONTH(NOW())";
	//filtro para transferencias itens
	$filtro_trans_itens = "AND MONTH(et.data_inicio)=MONTH(NOW())";
	//filtro para inventário
	$filtro_inventario  = "AND MONTH(ei.data_criado)=MONTH(NOW())";
	//filtro para beneficiamento
	$filtro_beneficiamento = "AND MONTH(data_pedido)=MONTH(NOW())";
	//filtro para beneficiamento item
	$filtro_beneficiamento_item   = "AND MONTH(ebp.data_pedido)=MONTH(NOW())";
}

$tipo_movimentacao = $_GET['tipo'];

if($tipo_movimentacao == 'pedido_compra_obs'){
	$movimentos             = mysql_query($t="SELECT * FROM estoque_compras WHERE vkt_id='$vkt_id' AND obs_pedido IS NOT NULL AND obs_pedido !='' $filtro_compras_transferencias");
	$descricao_movimentacao = "Ocorrências de Pedidos de Compras";
	$exibe_cliente          = '1';
}
if($tipo_movimentacao == 'chegada_compra_obs'){
	$movimentos             = mysql_query($t="SELECT * FROM estoque_compras WHERE vkt_id='$vkt_id' AND obs_chegada IS NOT NULL AND obs_chegada !='' $filtro_compras_transferencias");
	$descricao_movimentacao = "Ocorrências de Chegadas de Compras";
	$exibe_cliente          = '1';
}
if($tipo_movimentacao == 'compra_ocorrencia_item'){
	$movimentos             = mysql_query($t="SELECT * FROM 
												estoque_compras_item eci,
												estoque_compras ec
											WHERE 
												eci.pedido_id = ec.id AND
												eci.vkt_id='$vkt_id' AND 
												eci.ocorrencia IS NOT NULL AND 
												eci.ocorrencia !=''
												$filtro_compras_itens ");
	$descricao_movimentacao = "Ocorrências de Itens de Compras";
	$exibe_cliente          = '1';
	$exibe_quantidades_pedidas = '1';
	$exibe_produto          = '1'; 
}
if($tipo_movimentacao == 'transferencia_ocorrencia_pedido'){
	$movimentos             = mysql_query($t="SELECT * FROM estoque_transferencia WHERE vkt_id='$vkt_id' AND ocorrencia_pedido IS NOT NULL AND ocorrencia_pedido !='' $filtro_compras_transferencias");
	$descricao_movimentacao = "Ocorrências Pedido Transferência";
	$exibe_coluna_origem    = '1';
}
if($tipo_movimentacao == 'transferencia_ocorrencia_recebimento'){
	
	$movimentos = mysql_query($t="SELECT * FROM estoque_transferencia WHERE vkt_id='$vkt_id' AND ocorrencia_recebimento IS NOT NULL AND ocorrencia_recebimento !='' $filtro_compras_transferencias");
	$descricao_movimentacao = "Ocorrências Recebimento Transferência";
	$exibe_coluna_origem    = '1';
}
if($tipo_movimentacao == 'item_transferencia_ocorrencia_recebimento'){
	$movimentos             = mysql_query($t="SELECT 
												  *, eti.ocorrencia as item_ocorrencia, eti.ocorrencia_recebimento as ocorrencia_r 
											  FROM 
												  estoque_transferencia_item eti,
												  estoque_transferencia et
											  WHERE 
												  eti.vkt_id='$vkt_id' AND
												  eti.transferencia_id = et.id AND
												  ((eti.ocorrencia IS NOT NULL AND 
												  eti.ocorrencia !='') OR
												  (eti.ocorrencia_recebimento IS NOT NULL AND 
												  eti.ocorrencia_recebimento !=''))																		 
												  $filtro_trans_itens"); echo mysql_error();
												  //echo $t;
	$descricao_movimentacao = "Ocorrências Pedido Transferência Item";
	$exibe_coluna_origem    = '1';
	$exibe_produto          = '1';
	$exibe_obs_chegada      = '1';
	
}

if($tipo_movimentacao == 'itens_inventario'){
	$movimentos = mysql_query($t="SELECT 
									  * 
								  FROM 
									  estoque_inventario ei,
									  estoque_inventario_item eii 
								  WHERE
								  	eii.inventario_id = ei.id AND 
									  eii.vkt_id='$vkt_id' AND 
									  eii.ocorrencia IS NOT NULL AND 
									  eii.ocorrencia !='' 
									  $filtro_inventario");
									  
	$descricao_movimentacao = "Ocorrências Itens Inventário";
	$exibe_produto          = '1';
}
if($tipo_movimentacao == 'consumo_ocorrencia_pedido'){
	$movimentos  = mysql_query($t="
		SELECT 
			* 
		FROM 
			estoque_consumos 
		WHERE 
			vkt_id='$vkt_id' AND 
			obs_pedido IS NOT NULL AND 
			obs_pedido !='' 
			$filtro_compras_transferencias");
	//echo $t;
									  
	$descricao_movimentacao = "Ocorrências Pedido Consumo";
	$exibe_cliente          = '1';
}
if($tipo_movimentacao == 'consumo_ocorrencia_recebimento'){
	$movimentos  = mysql_query($t="
		SELECT 
			* 
		FROM 
			estoque_consumos 
		WHERE 
			vkt_id='$vkt_id' AND 
			obs_chegada IS NOT NULL AND 
			obs_chegada !='' 
			$filtro_compras_transferencias");
	//echo $t;
									  
	$descricao_movimentacao = "Ocorrências Chegada Consumo";
	$exibe_cliente          = '1';
}
if($tipo_movimentacao == 'item_consumo_ocorrencia'){
	$movimentos  = mysql_query($t="
		SELECT 
			* 
		FROM 
			estoque_consumos_item eci,
			estoque_consumos ec
		WHERE 
			eci.pedido_id = ec.id AND
			eci.vkt_id='$vkt_id' AND 
			eci.ocorrencia IS NOT NULL AND 
			eci.ocorrencia !=''
			$filtro_compras_itens");
	//echo $t;
									  
	$descricao_movimentacao = "Ocorrências Itens Consumo";
	$exibe_produto          = '1';
}
if($tipo_movimentacao == 'beneficiamento_ocorrencia_pedido'){
	$movimentos  = mysql_query($t="
		SELECT 
		  *, produto_beneficiado_id as produto_id 
		 FROM 
		  estoque_beneficiamento_pedido 
		 WHERE 
		  vkt_id='$vkt_id' AND 
		  obs IS NOT NULL AND 
		  obs !='' 
		  $filtro_beneficiamento");
	//echo $t;
									  
	$descricao_movimentacao = "Ocorrências Pedido Beneficiamento";
	$exibe_produto          = '1';
}
if($tipo_movimentacao == 'beneficiamento_ocorrencia_recebimento'){
	$movimentos  = mysql_query($t="
		SELECT 
			*, produto_beneficiado_id as produto_id 
		FROM 
			estoque_beneficiamento_pedido 
		WHERE 
			vkt_id='$vkt_id' AND 
			obs_recebimento IS NOT NULL AND 
			obs_recebimento !='' 
			$filtro_beneficiamento");
	//echo $t;
									  
	$descricao_movimentacao = "Ocorrências Recebimento Beneficiamento";
	$exibe_produto          = '1';
}
if($tipo_movimentacao == 'beneficiamento_ocorrencia_itens'){
	
$movimentos = mysql_query("
		SELECT 
			  *,ebi.obs_recebimento as obs_item_recebimento 
		  FROM 
			  estoque_beneficiamento_item ebi,
			  estoque_beneficiamento_pedido ebp
			  
		  WHERE 
			  ebi.beneficiamento_id = ebp.id AND
			  ebi.vkt_id='$vkt_id' AND
			  ((ebi.obs_item_pedido IS NOT NULL AND 
			  ebi.obs_item_pedido !='') OR
			  (ebi.obs_recebimento IS NOT NULL AND 
			  ebi.obs_recebimento !=''))
			  $filtro_beneficiamento_item");
	
									  
	$descricao_movimentacao = "Ocorrências Itens Beneficiamento";
	$exibe_produto          = '1';
	$exibe_obs_chegada      = '1';
}
?>

<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})

$("#filtrar").live("click",function(){
	var unidade_id = $("#unidade_id").val();
	var produto_id    = $("#produto_id").val();
	var de            = $("#de").val();
	var ate          = $("#ate").val();
	if(unidade_id > 0 && produto_id>0){
		location.href='?tela_id=<?=$_GET['tela_id']?>&produto_id='+produto_id+'&unidade_id='+unidade_id+'&de='+de+'&ate='+ate;
	}else{
		alert('Selecione uma unidade e um produto');
	}
});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<!--<form class='form_busca' action="" method="post" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" id='busca' name="busca" maxlength="44" value="" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/estoque/compras/busca_pedido.php,@r0,0' sonumero='1' autocomplete="off"/>
</form>-->
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s1'>
    Estoque 
</a>
<a href="./" class='s1'>
    Relatórios
</a>
<a href="./" class='s2'>
    Ocorrências
</a>
<a href="../consumo_estoque/?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span>Detalhes de Ocorrências
</a>
</div>
<div id="barra_info">
	<input type="button" style="margin-top:3px" value="<<" onclick="location.href='?tela_id=482&data_ini=<?=$_GET['data_ini']?>&data_fim=<?=$_GET['data_fim']?>'">
	<? echo $descricao_movimentacao;
		if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
		echo " De: ".$_GET['data_ini']." à ".$_GET['data_fim'];
		}
	?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	
    	<tr>
            <td width="60">Data</td>
             <td width="40">Pedido</td>
            <?php
            if($exibe_coluna_origem){
				echo "
				<td width='100'>Origem</td>
				<td width='100'>Destino</td>
				";
			}
			if($exibe_cliente){
            	echo "<td width='180'>Cliente</td>";
			}
			if($exibe_produto){
            	echo "<td width='125'>Produto</td>";
			}
            if($exibe_quantidades_pedidas){
				echo "
            	<td width='75'>Qtd Pedida</td>
            	<td width='75'>Qtd Chegada</td>";
			}				
			?>
            <td width="200">OBS</td>
            <?php
            if($exibe_obs_chegada){
				echo "<td width='200'>OBS Recebimento</td>";            
			}
			?>
			<td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
	
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
		<?php
			
			while($mov = mysql_fetch_object($movimentos)){
				
				if($tipo_movimentacao=='pedido_compra_obs'||$tipo_movimentacao=='consumo_ocorrencia_pedido'){
					$obs = $mov->obs_pedido;
					$data = $mov->data_inicio;
				}
				if($tipo_movimentacao=='chegada_compra_obs'||$tipo_movimentacao=='consumo_ocorrencia_recebimento'){
					$obs = $mov->obs_chegada;
					$data = $mov->data_inicio;
				}
				if($tipo_movimentacao=='compra_ocorrencia_item'||$tipo_movimentacao=='item_consumo_ocorrencia'){
					$obs = $mov->ocorrencia;
					$data = $mov->data_inicio;
				}
				if($tipo_movimentacao=='transferencia_ocorrencia_pedido'){
					$obs = $mov->ocorrencia_pedido;					
					$data = $mov->data_inicio;
				}
				
				if($tipo_movimentacao=='transferencia_ocorrencia_recebimento'){
					$obs = $mov->ocorrencia_recebimento;					
					$data = $mov->data_inicio;
				}
				if($tipo_movimentacao=='item_transferencia_ocorrencia_recebimento'){
					$obs = $mov->item_ocorrencia;					
					$obs_r = $mov->ocorrencia_r;
					$data = $mov->data_inicio;
				}
				if($tipo_movimentacao=='itens_inventario'){
					$obs = $mov->ocorrencia;
					$data = $mov->data_criado;
				}
				if($tipo_movimentacao=='beneficiamento_ocorrencia_pedido'){
					$obs = $mov->obs;
					$data = $mov->data_pedido;
				}
				if($tipo_movimentacao=='beneficiamento_ocorrencia_recebimento'){
					$obs = $mov->obs_recebimento;
					$data = $mov->data_pedido;
				}
				if($tipo_movimentacao=='beneficiamento_ocorrencia_itens'){
					$obs   = $mov->obs_item_pedido;
					$obs_r = $mov->obs_item_recebimento;
					$data = $mov->data_pedido;
				}
		?>
        <tr>
        <td width="60"><?=DataUsaToBr($data)?></td>
   		<td width="40"><?=$mov->id?></td>
        <?php
        if($exibe_coluna_origem){
				$unidade_origem  = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id = '$mov->unidade_id_origem'"));
				$unidade_destino = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id = '$mov->unidade_id_destino'"));
				echo "
				<td width='100'>$unidade_origem->nome</td>
				<td width='100'>$unidade_destino->nome</td>
				";
		}
		
		if($exibe_cliente){
			$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$mov->fornecedor_id'"));
        	echo "<td width='180'>$cliente->razao_social</td>";
		}
		if($exibe_produto){
           	$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id='$mov->produto_id'"));
			echo "<td width='125'>$produto->nome</td>";
		}
		if($exibe_quantidades_pedidas){
			$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = '$mov->fornecedor_id'"));
			echo "
        	<td width='75' align='right'>".qtdUsaToBr($mov->qtd_pedida)."</td>
        	<td width='75' align='right'>".qtdUsaToBr($mov->qtd_enviada)."</td>";
        }
		?>
        <td width="200"><?=$obs?></td>
        <?php
        if($exibe_obs_chegada){            
        	echo "<td width='200'>$obs_r</td>";
        }
        ?>
        <td></td>	
    	</tr>
       	<?php
			}
		?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
      <thead>
    	<tr>
            <td width="220"></td>
          	<td width="100"></td>                        
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=1&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value+'&produto_id=<?=$_GET['produto_id']?>&unidade_id=<?=$_GET['unidade_id']?>&de=<?=$_GET['de']?>&ate=<?=$_GET['ate']?>'">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('produto_id'=>$_GET['produto_id'],'unidade_id'=>$_GET['unidade_id'],'de'=>$_GET['de'],'ate'=>$_GET['ate'],'data_fim'=>$_GET['data_fim']))?>
    </div>
</div>
<script>
$('#sub3').show();
$('#sub396').show()
</script>