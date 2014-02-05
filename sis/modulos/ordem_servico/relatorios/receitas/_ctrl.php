<?php

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$os = mysql_fetch_object(mysql_query($t="SELECT * FROM os WHERE id='$id' AND vkt_id='$vkt_id'"));
	
	$servicos = mysql_query($t="SELECT * FROM os_item WHERE os_id='$id' AND qtd_servico>0 AND vkt_id='$vkt_id'");
	
	$produtos = mysql_query($t="SELECT * FROM os_item_produto WHERE os_id='$id' AND qtd_produto>0 AND vkt_id='$vkt_id'");
	//echo $t;
	$produtos_id = mysql_query($t="SELECT DISTINCT(produto_id) as produto_id FROM os_item_produto WHERE os_id=$id AND vkt_id='$vkt_id'");
			//echo $t;
	$soma_vlr_produtos = 0;
	while($produto_id=mysql_fetch_object($produtos_id)){
		$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id=$produto_id->produto_id"));
		$soma_vlr_produtos+=$produto->preco_compra;
	}
	
		
	$comissao_funcionario = mysql_query($t="SELECT * FROM os_item WHERE os_id='$id' AND vkt_id='$vkt_id'");
	
	$custos_os = mysql_query($t="SELECT * FROM os_custo WHERE os_id='$id' AND vkt_id='$vkt_id'");
	
}

?>