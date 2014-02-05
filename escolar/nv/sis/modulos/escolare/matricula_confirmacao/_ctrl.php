<?php

//Ações do Formulário

// Cadastrar
if ( count($_POST['nome']) >0 && (strlen($_POST['f_cnpj_cpf'])== '14'||strlen($_POST['f_cnpj_cpf'])== '18') ){
	//pr($_POST);
	cadastra ($_POST) ;
}

// Excluir
//pr($_POST);
if ( $_POST['action'] == "Excluir" ) {
//	$matricula_id= matricula_id[0]
	delete_matricula($_POST[matricula_id][0]);
}

// Seleciona
if ( $_GET['matricula_id'] >0 ) {

	$matricula = mysql_fetch_object (mysql_query($t= "SELECT * FROM escolar_matriculas WHERE id = '" . mysql_real_escape_string($_GET['matricula_id']) . "' AND vkt_id='$vkt_id'" ));
	$aluno = mysql_fetch_object(mysql_query($t="SELECT * FROM `escolar_alunos` WHERE id='$matricula->aluno_id'"));
	$d=$aluno;
	//pr($aluno);
}

if($_POST['action'] == 'Atualizar Valor'){
	AtualizarValor($_POST);
}
if($_POST['action'] == 'Importar'){
	Importar();
}
?>

