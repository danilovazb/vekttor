<?
	
	$nome = $_POST['nome'];
	$salario = $_POST['salario'];
	
	$sql = "INSERT INTO rh_funcionario SET nome='$nome', valor_salario='$salario'";
	
		//$registro = mysql_query();
	if(mysql_query($sql)){
		echo 'sucesso';	
	}
	
?>