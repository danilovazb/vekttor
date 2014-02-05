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
if ( isset ( $_GET['aluno_id'] ) ) {
	$q = mysql_query($t= "SELECT * FROM $tabela WHERE id = '" . mysql_real_escape_string($_GET['aluno_id']) . "' AND vkt_id='$vkt_id'" );
	echo $t;
	$d = mysql_fetch_object ($q);
	
	$s_matricula = mysql_query($s="SELECT * FROM escolar_matriculas WHERE aluno_id = '$d->id' AND vkt_id='$vkt_id'");
	
	$responsavel=mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = ".$d->responsavel_id));
}

?>