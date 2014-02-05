<?php
function total_compras($almoxarifado_id, $grupo_id, $filtro){
	global $vkt_id;
	
	$total = mysql_fetch_object(mysql_query($t="SELECT 
			SUM(eci.qtd_enviada * eci.valor_fim) as total 
		FROM 
			estoque_compras_item eci,
			estoque_compras ec,
			produto_grupo pg,
			produto p			
		WHERE
			eci.vkt_id         = '$vkt_id' AND
			eci.pedido_id      = ec.id AND
			eci.produto_id     = p.id AND
			p.produto_grupo_id = pg.id AND
			ec.unidade_id      = '$almoxarifado_id' AND
			pg.id              = '$grupo_id' AND
			ec.status          = 'Finalizado'
			$filtro 
		"));
		//echo $t."<br>";
		return $total->total;	
}

function compras($almoxarifado_id, $grupo_id, $filtro){
	global $vkt_id;
	
	$t="SELECT 
			*, ec.id as compra_id 
		FROM 
			estoque_compras_item eci,
			estoque_compras ec,
			produto_grupo pg,
			produto p			
		WHERE
			eci.vkt_id         = '$vkt_id' AND
			eci.pedido_id      = ec.id AND
			eci.produto_id     = p.id AND
			p.produto_grupo_id = pg.id AND
			ec.unidade_id      = '$almoxarifado_id' AND
			pg.id              = '$grupo_id' AND
			ec.status          = 'Finalizado'
			$filtro 
		";
		//echo $t."<br>";
		return $t;	
}



function total_consumo($almoxarifado_id, $grupo_id,$filtro){
	global $vkt_id;
	
	$total = mysql_fetch_object(mysql_query($t="SELECT 
			SUM(eci.qtd_enviada * eci.valor_fim) as total 
		FROM 
			estoque_consumos_item eci,
			estoque_consumos ec,
			produto_grupo pg,
			produto p			
		WHERE
			eci.vkt_id         = '$vkt_id' AND
			eci.pedido_id      = ec.id AND
			eci.produto_id     = p.id AND
			p.produto_grupo_id = pg.id AND
			ec.unidade_id      = '$almoxarifado_id' AND
			pg.id              = '$grupo_id' AND
			ec.status          = 'Finalizado'
			$filtro
		"));
		
		return $total->total;	
}
function consumo($almoxarifado_id, $grupo_id,$filtro){
	global $vkt_id;
	
	$total = mysql_fetch_object(mysql_query($t="SELECT 
			* 
		FROM 
			estoque_consumos_item eci,
			estoque_consumos ec,
			produto_grupo pg,
			produto p			
		WHERE
			eci.vkt_id         = '$vkt_id' AND
			eci.pedido_id      = ec.id AND
			eci.produto_id     = p.id AND
			p.produto_grupo_id = pg.id AND
			ec.unidade_id      = '$almoxarifado_id' AND
			pg.id              = '$grupo_id' AND
			ec.status          = 'Finalizado'
			$filtro
		"));
		
		return $t;	
}
?>