<?
//------------------------------------------------------------------
$compra=$_GET['compra_id'];
$verifica = mysql_fetch_object(mysql_query("SELECT * FROM estoque_compras WHERE vkt_id='$vkt_id' AND id='$compra'"));

if(empty($verifica)){
	
	if($_GET['fornecedor_id']){
		$pedido_id=cadastraPedido($_GET['fornecedor_id'],$_GET['estoque_id'],$vkt_id);	
	}
	$status = $_GET['status'];
	echo "
	<script>
		location='?tela_id=124&compra_id=$pedido_id&fornecedor_id={$_GET['fornecedor_id']}&status=$status&estoque_id={$_GET['estoque_id']}'
	</script>
	";
	exit();
	
}else{
	
	$pedido_id=$_GET['compra_id'];
}

if(!empty($_GET['status'])){
	$status = $_GET['status'];
	mysql_query($t="UPDATE estoque_compras SET status='$status' WHERE id='".$pedido_id."'");
	$verifica->status=$status;
}
$fornecedor_id=$_GET['fornecedor_id'];
$estoque_id=$_GET['estoque_id'];
$fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$fornecedor_id."'"));
$estoque = mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_unidades WHERE id='".$estoque_id."'"));

//echo $t;
$pedido = $verifica;
if(($pedido->status=='Finalizado')||($pedido->status=='cancelado')){
	$disabled = "disabled='disabled'";
}
//echo $t;

if($_GET['acao']=="alterar_fatores"){
	//$item_compra = mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_compras_item WHERE compra_id='".$_GET['compra_id']."' AND produto_id = '".$_GET['produto_id']."'"));
	$produto     = mysql_fetch_object(mysql_query($t="SELECT * FROM produto WHERE id='".$_GET['produto_id']."'"));
	
}
if(isset($_POST['action2'])){
	include("modulos/estoque/produtos/_functions.php");
	$cadastra=cadastraProduto($_POST['nome'],$_POST['produto_grupo_id'],$_POST['unidade'],$_POST['conversao1'],$_POST['unidade_embalagem'],$_POST['conversao2'],$_POST['unidade_uso'],$_POST['estoque_min'],$_POST['estoque_max'],$_POST['tempo_reposicao'],$_POST['custo'],$_POST['preco_compra'],$_POST['preco_venda'],$_POST['descricao'],$_POST['foto'],$_POST['codigo'],$_POST['gramatura'],$vkt_id);
	if($cadastra > 0){
		produto_has_fornecedor($cadastra,$_POST);
	}
}
?>