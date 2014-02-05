<? 
function CadastraProdutoFornecedor($fornecedor_id,$produto_id,$vkt_id){
	$query=mysql_query($trace="INSERT INTO produto_has_fornecedor SET fornecedor_id='$fornecedor_id', produto_id='$produto_id', vkt_id='$vkt_id'");
	//echo $trace;
}

function DeletaProdutoFornecedor($fornecedor_id,$produto_id){
	$query=mysql_query($trace="DELETE FROM produto_has_fornecedor WHERE produto_id='$produto_id' AND fornecedor_id='$fornecedor_id'");
	//echo $trace;
}

?>
