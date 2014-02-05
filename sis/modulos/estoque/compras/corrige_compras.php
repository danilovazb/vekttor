<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

$compras = mysql_query("SELECT * FROM estoque_compras WHERE vkt_id='14'");

while($compra = mysql_fetch_object($compras)){
	//seleciona os itens da compras
	$itens_compras = mysql_query("SELECT * FROM estoque_compras_item WHERE pedido_id='$compra->id' AND valor_fim='0'");
	
	while($item_compra = mysql_fetch_object($itens_compras)){
		$t="UPDATE estoque_compras_item SET valor_fim='$item_compra->valor_ini', qtd_enviada='$item_compra->qtd_pedida' WHERE id='$item_compra->id'";		
		echo $t."<br>";
	}
}
?>