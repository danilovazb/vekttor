<?
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
if(isset($_GET['ordem'])){
	$ordem = explode(',',$_GET['ordem']);
	
	foreach($ordem as $k=>$valor){
		mysql_query($trace="UPDATE projetos_atividades SET ordenacao_funcionario='$k' WHERE id='$valor' ");
		echo $trace.'<br/>';
		echo mysql_error().'<br/>';
	}
}
?>