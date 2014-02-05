<? 

function cadastraUnidade($nome,$descricao){
	global $vkt_id;
	$query=mysql_query("INSERT INTO cozinha_unidades SET nome='$nome', descricao='$descricao', vkt_id='$vkt_id'");
}

function alteraUnidade($id,$nome,$descricao){
	global $vkt_id;
	$query=mysql_query("UPDATE cozinha_unidades SET nome='$nome', descricao='$descricao' WHERE id='$id' AND vkt_id='$vkt_id'");
}

function deletaUnidade($id){
	global $vkt_id;
	$verifica_contratos_q=mysql_query("SELECT * FROM cozinha_contratos WHERE unidade_id='$id' AND vkt_id='$vkt_id'");
	if(mysql_num_rows($verifica_contratos_q)>0){
		alert("Existem contratos para esta unidade");
	}else{
		$query=mysql_query("DELETE FROM cozinha_unidades WHERE id='$id'");
	}
	
}

?>
