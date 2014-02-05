<?php

if($_POST['action']== 'Salvar'){
	if($_POST['id_pedido']>0){
		altera_beneficiamento($_POST);
		//echo "altera";
	}else{
		//print_r($_POST);
		insere_beneficiamento($_POST);
		//echo "insere";
	}
}

if($_GET['produto_id'] > 0 and ($_GET['pedido_id'])>0){
	
	$produto_id = $_GET['produto_id'];
	$pedido_id  = $_GET['pedido_id'];
	//$beneficiamento_id = $_GET['beneficiamento_id'];

	$pedido = mysql_fetch_object(mysql_query($tb="
		SELECT 
			*, ebp.id as beneficiamento_id, ebp.pedido_id as pedido_id, ebp.data_pedido as data_pedido_beneficiamento 
		FROM 
			estoque_beneficiamento_pedido ebp,
			produto p 
		WHERE
			ebp.vkt_id = '$vkt_id' AND
			ebp.produto_beneficiado_id = p.id AND
			ebp.id='$pedido_id'"));
													
	$estoque_compras = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_compras WHERE id = ".$pedido->pedido_id));
	
	$fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = ".$estoque_compras->fornecedor_id));
	
	$item = mysql_query($t="SELECT 
								*, ebi.id as item_id 
							FROM 
								estoque_beneficiamento_item ebi,
								produto p 
							WHERE
								ebi.vkt_id = '$vkt_id' AND
								ebi.produto_id = p.id AND 
								ebi.beneficiamento_id = '$pedido->beneficiamento_id'");
	$saldo = mysql_result(mysql_query($t="SELECT 
								SUM(qtd_pedida) as saldo
							FROM 
								estoque_beneficiamento_item ebi,
								produto p 
							WHERE
								ebi.vkt_id = '$vkt_id' AND
								ebi.produto_id = p.id AND 
								ebi.beneficiamento_id = '$pedido->beneficiamento_id'"),0,0);
	
	$saldo = ($pedido->qtd_pedido * $pedido->desperdicio)/100 ;
	$saldo = $pedido->qtd_pedido - $saldo; 									
	$status = $pedido->status;
	if($status == '3' || $status == '2'){
			$disable  = 'disabled="disabled"';
	} 
}

?>