<? 

function cadastraUnidade($nome,$descricao){
	$query=mysql_query("INSERT INTO cozinha_unidades SET nome='$nome', descricao='$descricao', vkt_id='$vkt_id'");
}

function alteraUnidade($id,$nome,$descricao){
	$query=mysql_query("UPDATE cozinha_unidades SET nome='$nome', descricao='$descricao' WHERE id='$id'");
}

function deletaUnidade($id){
	$query=mysql_query("DELETE FROM cozinha_unidades WHERE id='$id'");
}

?>
