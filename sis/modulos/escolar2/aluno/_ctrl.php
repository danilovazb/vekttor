<?php
//Ações do Formulário

// Cadastrar
if ( $_POST['action'] == "Salvar" ) {
	cadastra();
	//echo "cadastra";
}

// Excluir
if ( $_POST['action'] == "Excluir" ) {
	remover();
}

if($_GET[deleta_imagem]>0){
	remove_imgem($_GET[deleta_imagem]);
	exit();	
}

// Seleciona
if (isset( $_GET['aluno_id'])) {
	
	$aluno = mysql_fetch_object(mysql_query($t= "SELECT * FROM escolar2_alunos WHERE id = '" . mysql_real_escape_string($_GET['aluno_id']) . "' AND vkt_id='$vkt_id'" ));

	$select_matricula = mysql_query($s="SELECT * FROM escolar2_matriculas WHERE aluno_id = '$aluno->id' AND vkt_id='$vkt_id'");
	//$responsavel=mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = ".$d->responsavel_id));
}

?>