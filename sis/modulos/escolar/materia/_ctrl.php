<?php

//Ações do Formulário

// Cadastrar
if ( $_POST['action'] == "Salvar" ) {
	manipulaMateria($_POST);
}

// Excluir
if ( $_POST['action'] == "Excluir" ) {
	removeMaterias($_POST);
}

if (isset($_GET['remove_materia'])) {
	removeMateria($_GET['remove_materia'],$_GET['curso_id'],$_GET['modulo_id']);
}

// Seleciona
if ( isset ( $_GET['curso_id'] ) ) {
	$q = mysql_query($t= "SELECT * FROM $tabela WHERE vkt_id='$vkt_id' AND id = '" . mysql_real_escape_string($_GET['curso_id']) . "'" );
	$d = mysql_fetch_object ($q);
	//seleciona o módulo
	$modulo = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_modulos WHERE vkt_id='$vkt_id' AND id = " . $_GET['modulo_id']));
}

?>