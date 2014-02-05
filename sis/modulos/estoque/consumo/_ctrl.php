<?
//------------------------------------------------------------------
$compra=$_GET['compra_id'];
$verifica = mysql_fetch_object(mysql_query("SELECT * FROM estoque_consumos WHERE vkt_id='$vkt_id' AND id='$compra'"));

if(empty($verifica)){
	
	//if($_GET['fornecedor_id']){
		$pedido_id=cadastraPedido($_GET['estoque_id'],$vkt_id);	
	//}
	$status = $_GET['status'];
	echo "
	<script>
		location='?tela_id=499&compra_id=$pedido_id&status=$status&estoque_id={$_GET['estoque_id']}'
	</script>
	";
	exit();
	
}else{
	
	$pedido_id=$_GET['compra_id'];
}

if($_GET['acao']=="alterar_fatores"){
	//$item_compra = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_compras_item WHERE compra_id='".$_GET['compra_id']."' AND produto_id = '".$_GET['produto_id']."'"));
	$produto     = mysql_fetch_object(mysql_query($t="SELECT * FROM produto WHERE id='".$_GET['produto_id']."'"));
	
}
if($_GET['acao']=="Finalizar"){
	finaliza_pedido($_GET);	
}

if(!empty($_GET['status'])){
	$status = $_GET['status'];
	mysql_query($t="UPDATE estoque_consumos SET status='$status' WHERE id='".$pedido_id."'");
	//echo $t;
}

$estoque_id=$_GET['estoque_id'];
$estoque = mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_unidades WHERE id='".$estoque_id."'"));

//echo $t;
$pedido = mysql_fetch_object(mysql_query("SELECT * FROM estoque_consumos WHERE vkt_id='$vkt_id' AND id='$compra'"));
if(($pedido->status=='Finalizado')||($pedido->status=='cancelado')){
	//echo $pedido->status." ".$_GET['status']."<br>";
	$disabled = "disabled='disabled'";
}else{
	$disabled = '';
}
//echo $t;


?>