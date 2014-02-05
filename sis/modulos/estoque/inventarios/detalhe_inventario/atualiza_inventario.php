<?
include("../../../../_config.php");
include ("../../../../_functions_base.php");

if($_GET['estoque_inventario_item_id']>0){
	
	
	$qtd_nova 		= qtdBrToUsa($_GET[nova_qtd]);
	$qtd_estoque	= $_GET[qtd_estoque];
	$conversao 		= $_GET[conversao2];
	$produto_preco	= $_GET[valor_produto];
	
	if($_GET[unidade]=='unidade_embalagem'){
		$unidade = "unidade de embalagem";
		$qtd_nova = $qtd_nova*$conversao;
		$diferenca = ($qtd_nova)-$qtd_estoque; 	
		$valor_diferenca = $produto_preco*($diferenca/$conversao);
	}else{
		$unidade = "unidade de uso";
		$qtd_nova = $qtd_nova;
		$diferenca = $qtd_nova-$qtd_estoque; 	
		$valor_diferenca =  $produto_preco*($diferenca/$conversao);
	}
	
	
	$sql="
	UPDATE 
		estoque_inventario_item 
	SET 
		qtd_estoque='$qtd_estoque', 
		qtd_inventario='$qtd_nova', 
		qtd_diferenca='$diferenca', 
		valor_diferenca='$valor_diferenca' ,
		ocorrencia='{$_GET[ocorrencia]}',
		unidade='{$_GET[unidade]}'
	WHERE 
		id='{$_GET[estoque_inventario_item_id]}' AND vkt_id='$vkt_id'";
	$altera=mysql_query($sql);
	
	
		echo "* ".$_GET[nova_qtd]. " $unidade";
		
		
}

?>