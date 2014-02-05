<?
include("../../../_config.php");
include("../../../_functions_base.php");
include('_functions.php');

if($_GET['acao']=="alterar"){
//verifica se o item já está cadastrado
$select_item=mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_vendas_item WHERE produto_id='".$_GET['produto_id']."' AND pedido_id='".$_GET['pedido_id']."'"));
//echo $t;
	if(empty($select_item)){
		//alert('teste0');
		$sql = "INSERT INTO ";
		$fim='';
	}else{
		//alert('teste');
		$sql="UPDATE ";
		$fim="WHERE id='".$select_item->id."'";
	}
	$query=mysql_query($t="$sql estoque_vendas_item SET vkt_id='$vkt_id', pedido_id='".$_GET['pedido_id']."', produto_id='".$_GET['produto_id']."', fatorconversao='".moedaBrToUsa($_GET['conversao'])."' , unidade='".$_GET['unidade']."', qtd_pedida='".qtdBrToUsa($_GET['qtd'])."', valor_ini='".$_GET['valor']."' $fim");
	echo $t."<br>";
	echo mysql_error();
	//pr($_GET);
	
	if($_GET['item_id']<1){
		//echo mysql_insert_id();
		$ultimo=mysql_insert_id();
		echo "<script>top.document.getElementById('".$_GET[cont]."').innerHTML='$ultimo'</script>";
	}else{
		$ultimo= $_GET[item_id];
		echo "<script>top.document.getElementById('".$_GET[cont]."').innerHTML='$ultimo'</script>";
		//t;
	}
}else{
	$query=mysql_query("DELETE FROM estoque_vendas_item WHERE id='".$_GET['id']."'");
}
?>