<?
if(isset($_GET['id'])){$id=$_GET['id'];}

if(isset($_POST['id'])){$id=$_POST['id'];}
if($_POST['action']=='Salvar'){
	if($id==0){
		CadastraPedido($_POST,$vkt_id);
	}
	if($id>0){
		AlteraPedido($_POST,$id);
	}
}

if($_POST['action']=='Excluir'){
	ExcluiPedido($id);
}

if($_POST['action']=='Imprimir'){
	//ImprimePedido($id);
	echo "<script>window.open('http://10.0.1.22/clientes/nv/nv/sis/modulos/eleitoral/pedidos//imprime_pedidos.php?id=".$id."');</script>";
}

if($id>0){
	$pedido_q=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_pedidos WHERE id='$id'"));
	//echo "trace:".$trace;
}
?>