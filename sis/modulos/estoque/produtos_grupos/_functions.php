<? 

function cadastraUnidade($nome,$descricao,$vkt_id){
	$query=mysql_query("INSERT INTO produto_grupo SET nome='$nome', descricao='$descricao',vkt_id='$vkt_id'");
}

function alteraUnidade($id,$nome,$descricao){
	$query=mysql_query("UPDATE produto_grupo SET nome='$nome', descricao='$descricao' WHERE id='$id'");
}

function deletaUnidade($id){
	$verifica_produto_q=mysql_query("SELECT * FROM produto WHERE produto_grupo_id='$id' ");
	if(mysql_num_rows($verifica_produto_q)>0){
		alert("Este grupo possui produtos vinculados.");
	}else{
		$query=mysql_query("DELETE FROM produto_grupo WHERE id='$id'");
	}
	
}

?>
