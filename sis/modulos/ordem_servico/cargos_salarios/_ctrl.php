<?php

if($_POST['action']== 'Salvar'){
	manipulaCargosSalarios($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiCargosSalarios($_POST,$vkt_id);
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$cargo_salario = mysql_fetch_object(mysql_query("SELECT * FROM cargo_salario WHERE id='$id'"));
}

?>