<?
include("../../../_config.php");
include("../../../_functions_base.php");
include('_functions.php');
print_r($_GET);
//verifica se a açao é igual a alterar
if($_GET['acao']=="alterar"){
	
	//verifica se o item já está cadastrado
	$select_item=mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_consumos_item WHERE produto_id='".$_GET['produto_id']."' AND pedido_id='".$_GET['pedido_id']."'"));

	if(empty($select_item)){
		//alert('teste0');
		$sql = "INSERT INTO ";
		$fim='';
	}else{
		//alert('teste');
		$sql="UPDATE ";
		$fim="WHERE id='".$select_item->id."'";
	}
	$query=mysql_query($t="$sql estoque_consumos_item SET 
							vkt_id='$vkt_id', 
							pedido_id='".$_GET['pedido_id']."',
							produto_id='".$_GET['produto_id']."',
							qtd_pedida='".$_GET['qtd']."',
							valor_ini='".$_GET['valor']."',
							unidade='".$_GET['unidade']."',
							unidade_tipo='".$_GET['unidade_tipo']."',
							fatorconversao='".$_GET['conversao']."',
							fatorconversao2='".$_GET['conversao2']."',
							marca='".$_GET['marca']."' $fim");
	echo $t."<br>";
	$atualiza_compra = mysql_query($t="UPDATE estoque_consumos SET
				data_chegada_prevista='".DataBrToUsa($_GET['data_chegada_prevista'])."'
				WHERE id='".$_GET['pedido_id']."'");
	//echo $t;
	//echo mysql_error();
	mysql_query("UPDATE estoque_consumos SET
				unidade_id='".$_GET['unidade_id']."',
				WHERE id='".$_GET['pedido_id']."'");
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
	$query=mysql_query("DELETE FROM estoque_consumos_item WHERE id='".$_GET['id']."'");
}
	if($_GET['acao'] == 'excluir'){
		$query=mysql_query($y="DELETE FROM estoque_consumos_item WHERE produto_id='".$_GET['produto_id']."' 
		AND pedido_id = '".$_GET['pedido_id']."'");
		echo $y;
		
	}
?>