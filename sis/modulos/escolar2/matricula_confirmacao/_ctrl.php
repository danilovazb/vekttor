<?php

//Ações do Formulário

if($_POST['salva_formulario_contrato_cliente']== '1'){
		   echo "<script>html_to_form();</script>";
		//if($_POST["action"] == "Confirmar"){
			cadastra_aluno();
		//}salva_formulario_contrato_cliente
		
}


// Cadastrar
if ( count($_POST['nome']) >0 && (strlen($_POST['f_cnpj_cpf'])== '14'||strlen($_POST['f_cnpj_cpf'])== '18') ){
	//pr($_POST);
	cadastra ($_POST) ;
}

// Excluir
if ( $_POST['action'] == "Excluir" ) {
//	$matricula_id= matricula_id[0]
	delete_matricula($_POST[matricula_id][0]);
}

if($_GET[deleta_imagem]>0){
	remove_imgem($_GET[deleta_imagem]);
	exit();	
}

// Seleciona
if ( $_GET['id'] > 0 ) {
	
	
	$id_aluno = $_GET['id'];
	$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$id_aluno' "));
	$matricula = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_matriculas WHERE aluno_id = '$id_aluno' AND situacao = 'cursando' "));
	
	$responsavel = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$matricula->responsavel_id' "));
	
	$matricula_aluno = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_matriculas WHERE id = '".$_GET['matricula_id']."' "));
	

	
}

if($_POST['action'] == 'Atualizar Valor'){
	AtualizarValor($_POST);
}
if($_POST['action'] == 'Importar'){
	Importar();
}
?>

