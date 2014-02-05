<?php

//Ações do Formulário

// Cadastrar
if ( $_POST['action'] == "Salvar" ) {
	//alert(sizeof($_POST['semana']));
	if(empty($_POST['modulo_id'])){
		alert("Selecione uma unidade na aba unidade");
		echo "<script>history.go(-1)</script>";
	}else{
		cadastra();
	}
}

// Excluir
if ( $_POST['action'] == "Excluir" ) {
	remover();
}

// Seleciona
if ( isset ($_GET['id']) ){
	$q = mysql_query( $trace = "SELECT *, DATE_FORMAT(horario_inicio, '%H:%i') horario_inicio, DATE_FORMAT(horario_fim, '%H:%i') horario_fim FROM $tabela WHERE id = '" . mysql_real_escape_string($_GET['id']) . "'" )or die(myqsl_error());
	$d = mysql_fetch_object($q);
}

?>