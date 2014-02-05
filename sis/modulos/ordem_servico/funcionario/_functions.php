<?php
function manipulaFuncionario($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query("$inicio rh_funcionario SET
		vkt_id='$vkt_id',
		nome='$dados[nome]'		
		$fim");
}

function excluiFuncionario($_POST,$vkt_id){
	mysql_query("DELETE FROM rh_funcionario WHERE id='$_POST[id]'");
}
?>