<?
include("../../../_config.php");
include("../../../_functions_base.php");
include('_functions.php');

$produtos_q=mysql_query($trace="SELECT * FROM produto ORDER BY nome");
//print_r($_GET);
	if(isset($_GET['acao'])){
		if($_GET['acao']=='desabilita'){
			CadastraProdutoFornecedor($_GET['fornecedor_id'],$_GET['produto_id'],$vkt_id);
		}else{
			DeletaProdutoFornecedor($_GET['fornecedor_id'],$_GET['produto_id']);
		}
	}
?>