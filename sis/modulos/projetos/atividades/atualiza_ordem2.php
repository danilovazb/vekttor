<?
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
//echo "Antes:".$_GET['antes']."<br>";
$mudados=array();
if(isset($_GET['ordem'])){
	$depois = explode(',',$_GET['ordem']);
	$antes = explode(',',$_GET['antes']);	
	
	//foreach($depois as $k=>$valor){
		//mysql_query($trace="UPDATE projetos_atividades SET ordenacao_funcionario='$k' WHERE id='$valor' ");
		//echo $trace.'<br/>';
		//echo mysql_error().'<br/>';
	//}
	
	
	for($i=0;$i<count($diferentes_depois);$i++){
		mysql_query($t2="UPDATE projetos_atividades SET ordenacao_funcionario='$i' WHERE id='$depois[$i]' ");
		echo $t2.'<br>';
		
	}
	
	$mudados=NULL;
}
?>