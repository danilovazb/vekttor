<?php

//Ações do Formulário

/*if($_POST['action']=="Salvar"){
	transfere_aluno($_POST);
}*/

if($_POST['salva_formulario_contrato_cliente']== '1'){
		transfere_aluno($_POST);
}


// Seleciona
if ( $_GET['sala_id'] > 0 ) {
	
	
	$sala = mysql_fetch_object(mysql_query($ty=" SELECT * FROM escolar2_salas WHERE id = '".$_GET['sala_id']."' "));
	
}

?>