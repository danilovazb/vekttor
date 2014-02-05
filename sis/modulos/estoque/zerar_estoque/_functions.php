<?php

function verifica_saldos($unidade_id,$modo){
	
	global $vkt_id; 
	
	$saldo_produtos = "SELECT 
					m.*
				FROM 
					produto p, estoque_mov m
				WHERE 
					p.id = m.produto_id AND
					m.id = (SELECT id FROM estoque_mov WHERE produto_id=p.id AND almoxarifado_id = '$unidade_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1) AND
					m.almoxarifado_id = '$unidade_id' AND 
					p.vkt_id          = '$vkt_id'";
	
	
	if($modo=='inventario'){
		$inventario_id = manipula_inventario($unidade_id, $saldo_produtos);
		zera_saldos($inventario_id, $saldo_produtos,'inventario');
	}else{
		$consumo_id = manipula_consumo($unidade_id, $saldo_produtos);
		//alert($consumo_id);
		zera_saldos($consumo_id, $saldo_produtos,'consumo');
	}
}
//----------------------------------------------------------------------
function manipula_inventario($unidade_id, $saldo_produtos){
	global $vkt_id;
	global $usuario_id;
	
	$saldo_produtos = mysql_query($saldo_produtos);
	
	mysql_query($t="INSERT INTO 
			estoque_inventario 
		SET 
			vkt_id          = '$vkt_id',
			usuario_id      = '$usuario_id',
			status          = '0',
			data_criado     = NOW(),
			almoxarifado_id = '$unidade_id'");
	//alert(mysql_error());
	
	$id = mysql_insert_id();
	//alert($id);
		
	while($saldo_produto= mysql_fetch_object($saldo_produtos)){
		
		mysql_query($t="INSERT INTO
				estoque_inventario_item
			SET
				vkt_id = '$vkt_id',
				inventario_id   = '$id',
				produto_id      = '$saldo_produto->produto_id',
				qtd_estoque     = '0',
				qtd_inventario  = '0',
				qtd_diferenca   = '0',
				valor_diferenca = '0',
				ocorrencia      = ''
				");
		
	}
	
	return $id;
}
//----------------------------------------------------------------------
function manipula_consumo($unidade_id, $saldo_produtos){
	global $vkt_id;
	global $usuario_id;
	
	$saldo_produtos = mysql_query($saldo_produtos);
	
	$data_chegada_prevista = mysql_fetch_object(mysql_query("SELECT DATE_ADD(CURDATE(), INTERVAL 2 DAY) as data_chegada"));
	
	mysql_query($t="INSERT INTO 
			estoque_consumos 
		SET 
			vkt_id          = '$vkt_id',
			fornecedor_id   = '0',
			status          = 'Em aberto',
			unidade_id      = '$unidade_id',
			data_inicio     = 'NOW()',
			data_chegada_prevista  = '$data_chegada_prevista->data_chegada'
			");
	
	
	$id = mysql_insert_id();
	
		
	while($saldo_produto= mysql_fetch_object($saldo_produtos)){
		
		$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id='$saldo_produto->produto_id'"));
		
		mysql_query($t="INSERT INTO
				estoque_consumos_item
			SET
				vkt_id = '$vkt_id',
				pedido_id   = '$id',
				produto_id      = '$saldo_produto->produto_id',
				qtd_pedida      = '0',
				qtd_enviada     = '0',
				valor_ini       = '0',
				valor_fim       = '0',
				ocorrencia      = '',
				unidade         = '$produto->unidade',
				unidade_tipo    = 'compra',
				fatorconversao  = '$produto->conversao1',
				fatorconversao2  = '$produto->conversao2'
				");
		
	}
	
	return $id;
}
//----------------------------------------------------------------------
function zera_saldos($doc_id,$saldo_produtos,$modo){
	global $usuario_id;
	global $vkt_id; 
	//alert($doc_id);
	$saldo_produtos = mysql_query($saldo_produtos);
	
	while($saldo_produto = mysql_fetch_object($saldo_produtos)){
		
		if($saldo_produto->saldo >0){
					
			mysql_query($t="INSERT INTO 
				estoque_mov 
			SET
				vkt_id          = '$vkt_id', 
				usuario_id      = '$usuario_id',
				produto_id      = '$saldo_produto->produto_id',
				almoxarifado_id = '$saldo_produto->almoxarifado_id',
				data_hora       = NOW(),
				saida           = '$saldo_produto->saldo',
				saldo           = '0',
				doc_id          = '$doc_id',
				doc_tipo        = '$modo'				
			");
		//echo $t."<br>";
		}
		
	}
	
	alert("Estoque da Unidade Selecionada Zerado.");

}
?>