<?

function insereCargo($dados){
	global $vkt_id;
	$sql = "INSERT INTO cargo_salario SET vkt_id='$vkt_id', cargo='{$dados['cargo']}', valor_salario='".moedaBrToUsa($dados['salario'])."'";
	mysql_query($sql);
}

function alteraCargo($dados){
	global $vkt_id;
	$sql = "UPDATE cargo_salario SET cargo='{$dados['cargo']}', valor_salario='".moedaBrToUsa($dados['salario'])."' WHERE id='{$dados['id']}' AND vkt_id='$vkt_id'";
	mysql_query($sql);
}

function deletaCargo($id){
	global $vkt_id;
	mysql_query("DELETE FROM cargo_salario WHERE id='$id' AND vkt_id='$vkt_id'");
}