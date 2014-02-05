<?php
//Ações do Formulário
if(isset ( $_GET['escola_id'] )){$escola_id = $_GET['escola_id'];}
if(isset ( $_POST['escola_id'] )){$escola_id = $_POST['escola_id'];}
if(isset ( $_GET['ensino_id'] )){$ensino_id = $_GET['ensino_id'];}

if($_POST["Cadastra_Turma"] == "Salvar"){
	manipula_turma($_POST);
}
if($_POST["Cadastra_Turma"] == "Atualizar"){
	editar_turma($_POST);
}

if($_GET['acao']=='excluir_turma'){
	excluir_turma($_GET['turma_id']);
}

if( $_POST["acao_form_importacao"] == "importar_periodo_letivo" ){
	importar_turmas($_POST["periodo_exportacao_id"], $_POST["periodo_importacao_id"] );
}

if($_POST["action"] == "Excluir"){
	excluir_turma($_POST["turma_id"]);
}

// Seleciona
if ( $escola_id>0 ) {
	
	$escola = mysql_fetch_object(mysql_query($t= "SELECT * FROM escolar2_unidades WHERE id = '" . $escola_id. "' AND vkt_id='$vkt_id'" ));
	
	$ensino = mysql_fetch_object(mysql_query($t= "SELECT * FROM escolar2_ensino WHERE id = '" . mysql_real_escape_string($_GET['serie_id']) . "' AND vkt_id='$vkt_id'" ));	
	
	$serie = mysql_fetch_object(mysql_query($t= "SELECT * FROM escolar2_series WHERE id = '" . mysql_real_escape_string($_GET['serie_id']) . "' AND vkt_id='$vkt_id'" ));	
	
	$salas = mysql_query("SELECT * FROM escolar2_salas WHERE unidade_id='$escola->id' AND vkt_id='$vkt_id' ORDER BY nome");
}


//-------Chamadas Para funções do Período Letivo------------------------------------------------------

if(isset($_GET['periodo_letivo_id'])){ $periodo_letivo_id = $_GET['periodo_letivo_id'];}

if ( $_POST['action_periodo_letivo'] == "Salvar" ) {
	
	manipula_perido_letivo($_POST);
	//echo "cadastra";
}

if ( $_POST['action_periodo_letivo'] == "Excluir" ) {
	
	deleta_perido_letivo($_POST['id']);
	//echo "cadastra";
}

if( $periodo_letivo_id > 0){
	
	$periodo_letivo = mysql_fetch_object(mysql_query("SELECT * FROM escolar2_periodo_letivo WHERE id='$periodo_letivo_id'"));

}

//-------Chamadas Para funções do Horário------------------------------------------------------

if(isset($_GET['horario_id'])){ $horario_id = $_GET['horario_id'];}

if ( $_POST['action_horario'] == "Salvar" ) {
	
	manipula_horario($_POST);
	//echo "cadastra";
}
if ( $_POST['action_horario'] == "Excluir" ) {
	
	deleta_horarios($_POST['id']);
	//echo "cadastra";
}

if( $horario_id > 0){
	$horario = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_horarios WHERE id='$horario_id'"));
	$ensino = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar2_ensino WHERE id='$ensino_id'"));
}

// Cadastar a turma

?>