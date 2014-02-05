<?
include("../../../_config.php");
include("../../../_functions_base.php");
include('_functions.php');
if($_GET['acao']=='alterar'){
$select_item=mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_cotacao_item WHERE produto_id='".$_GET['produto_id']."' AND cotacao_id='".$_GET['cotacao_id']."'"));
	if(empty($select_item)){
		$inicio = "INSERT INTO";
		$fim='';
	}else{
		$inicio = "UPDATE";
		$fim ="WHERE id='".$select_item->id."'";
	}
	
	$sql=mysql_query($t="$inicio cozinha_cotacao_item 
			SET 
				vkt_id              = '$vkt_id',
				cotacao_id          = '".$_GET['cotacao_id']."',
				necessidade_id      = '".$_GET['necessidade_id']."',
				necessidade_item_id = '".$_GET['necessidade_item_id']."',
				produto_id          = '".$_GET['produto_id']."',
				qtd_pedida          = '".$_GET['qtd']."',
				valor_ini           = '".$_GET['valor']."',
				marca               = '".$_GET['marca']."',
				unidade_tipo        = '".$_GET['unidade_tipo']."',
				unidade             = '".$_GET['unidade']."',
				fatorconversao      = '".$_GET['conversao']."',
				fatorconversao2     = '".$_GET['conversao2']."'				
				$fim
				");
	echo $t."<br>";
	if($_GET['item_id']<1){
		$ultimo=mysql_insert_id();
		echo "<script>top.document.getElementById('".$_GET[cont]."').innerHTML='$ultimo'</script>";
	}else{
		$ultimo= $_GET[item_id];
		echo "<script>top.document.getElementById('".$_GET[cont]."').innerHTML='$ultimo'</script>";
	}
}else{
	mysql_query("DELETE FROM cozinha_cotacao_item WHERE id='".$_GET['id']."'");
}
?>