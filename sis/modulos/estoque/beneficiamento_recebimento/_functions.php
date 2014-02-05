<?php
session_start();

function insere_item_beneficiamento($campos){
	global $login_id;
	
		echo "insere item beneficiamento";
	
}

function movimenta_estoque($pedido_id, $almoxarifado_id){
	global $vkt_id;
	global $usuario_id;
	
	$pedido = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_beneficiamento_pedido WHERE id='$pedido_id'"));
	$saldo_produto = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_mov WHERE almoxarifado_id='$almoxarifado_id' AND produto_id='$pedido->produto_beneficiado_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
	//echo $t."<br>";
	$items_pedido = mysql_query("
	SELECT 
		* 
	FROM 
		estoque_beneficiamento_item ebi,
		produto p
	WHERE
		ebi.vkt_id='$vkt_id' AND 
		ebi.produto_id=p.id  AND
		beneficiamento_id='$pedido_id'");
	
	//echo "Produto_id = $pedido->produto_benficiado_id Saldo Anterior:".$saldo_produto->saldo;
	$saldo_produto = (double)$saldo_produto->saldo - (double)$pedido->qtd_realizada; 
	//echo " Novo Saldo: $saldo_produto <br>";
	mysql_query($t="INSERT INTO estoque_mov SET produto_id='$pedido->produto_beneficiado_id', almoxarifado_id='$almoxarifado_id', data_hora=NOW(), saida='$pedido->qtd_realizada', saldo='$saldo_produto', vkt_id='$vkt_id', doc_id='$pedido_id', doc_tipo='beneficiamento', usuario_id='$usuario_id'");	
	//echo $t." ".mysql_error()."<br>";
	while($item_pedido = mysql_fetch_object($items_pedido)){
		$saldo_item = mysql_fetch_object(mysql_query($t="
		SELECT 
			* 
		FROM 
			estoque_mov em
			
		WHERE
			em.vkt_id='$vkt_id' AND
			almoxarifado_id='$almoxarifado_id' AND 
			produto_id='$item_pedido->produto_id'  
			ORDER BY id DESC LIMIT 1"));
		//echo $t."<br>";
		$entrada = $item_pedido->qtd_realizada * $item_pedido->conversao2;
		$saldo_item = $saldo_item->saldo+($item_pedido->qtd_realizada*$item_pedido->conversao2);
		
		//echo $saldo_item."<br>";
		mysql_query($t="INSERT INTO estoque_mov SET produto_id='$item_pedido->produto_id', almoxarifado_id='$almoxarifado_id', data_hora=NOW(), entrada='$entrada', saldo='$saldo_item', vkt_id='$vkt_id', doc_id='$pedido_id', doc_tipo='beneficiamento', usuario_id='$usuario_id'");
		//echo $t." ".mysql_error()."<br>";
	}
}

function altera_pedido($campos){
			$data_entrega = date('Y-m-d');
			
			$aparas   = moedaBrToUsa($campos['aparas']);
			$descarte = moedaBrToUsa($campos['descarte']);
			$perda    = moedaBrToUsa($campos['perda']);
			$qtd_realizada = moedaBrToUsa($campos['qtd_realizada']);
			$almoxarifado_id = $campos['almoxarifado_id_filt'];
			
		$sql = ("
		UPDATE estoque_beneficiamento_pedido 	
			SET 
				aparas          = '$aparas',
				descarte        = '$descarte',
				perda           = '$perda',
				qtd_realizada   = '$qtd_realizada',
				data_entrega    = '$data_entrega',
				obs_recebimento = '$campos[obs_recebimento]',
				status          = '2' 
			
		WHERE id = '$campos[pedido_id]' 
		
		");
			//echo $sql;
		mysql_query($sql);
		
		movimenta_estoque($campos['pedido_id'],$almoxarifado_id);
	
}
?>