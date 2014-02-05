<?php

//Ações do Formulário

// Cadastrar
if ( $_POST['action'] == "Salvar" ) {
	
	if(!empty($_POST['id'])){
		UpdateConta($_POST);
	}else{
		CadastraConta($_POST);
	}
}

// Excluir
if ( $_POST['action'] == "Excluir" ) {
	remover($_POST['id']);
}

// Seleciona
if (!empty( $_GET['id'])) {
	
	$conta = mysql_fetch_object(mysql_query( "SELECT * FROM escolar2_config WHERE id = '" . mysql_real_escape_string($_GET['id']) . "'" ));

	
}

?>