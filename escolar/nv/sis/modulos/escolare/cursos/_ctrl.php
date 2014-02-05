<?php

//Ações do Formulário

// Cadastrar
if ( $_POST['action'] == "Salvar" ) {
	if(empty($_POST['conta_id'])){
		alert("Selecione uma conta para o curso");
		echo "<script>history.go(-1)</script>";
	}else{
		cadastra();
	}
}

// Excluir
if ( $_POST['action'] == "Excluir" ) {
	remover();
}

if($_GET[deleta_imagem]>0){
	remove_imgem($_GET[deleta_imagem]);
	exit();	
}
if($_GET[remove_modulo]>0){
	remove_modulos($_GET[remove_modulo]);
	exit();	
}
// Seleciona
if ( isset ( $_GET['curso_id'] ) ) {
	$q = mysql_query( "SELECT * FROM $tabela WHERE id = '" . mysql_real_escape_string($_GET['curso_id']) . "'" );
	$d = mysql_fetch_object ($q);
}

?>