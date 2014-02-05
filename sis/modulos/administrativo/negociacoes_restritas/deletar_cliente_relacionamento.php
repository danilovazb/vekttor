<?

include '../../../_config.php';
if($_GET['deletar']>0){
	mysql_query("DELETE FROM negociacao_cliente WHERE negociacao_id='{$_GET[negociacao_id]}' AND cliente_id='{$_GET[deletar]}' ");
	echo "<script>alert('{$_GET[negociacao_id]} {$_GET[deletar]} ".mysql_error()."')</script>";
}
?>