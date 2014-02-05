<?php

//Ações do Formulário

// Cadastrar
if ( $_POST['action'] == "Salvar" ) {
	
  /*echo "<script>history.go(-1)</script>";*/
  
  if( $_POST["acao"] == "salvar_ensino"){
	  cadastra_ensino();
  } else if($_POST["acao"] == "atualizar_ensino"){
	  atualizar_ensino();
  } else if($_POST["acao"] == "atualiza_serie"){
	  atualiza_serie();
  }
	
} 


// Excluir
if ( $_POST['action'] == "Excluir Ensino" ) {
	exluir_ensino($_POST["ensino_id"]);
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
if ( isset( $_GET['id'] ) ) {
	
	$ensino = mysql_fetch_object(mysql_query( "SELECT * FROM escolar2_ensino WHERE id = '" . mysql_real_escape_string($_GET['id']) . "'" ));
	$ensino_id = $_GET['id'];
	
	$serie_id = $_GET["serie_id"];
	$sql_serie = mysql_query(" SELECT * FROM escolar2_series WHERE ensino_id = '$ensino->id' ORDER BY ordem_ensino ASC");	
	
}

if(isset($_GET["serie_id"])){
	
	$serie = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '" . mysql_real_escape_string($_GET['serie_id']) . "' "));
	
	$sql_serie_materia = mysql_query(" SELECT * FROM escolar2_serie_has_materias WHERE serie_id = '" . mysql_real_escape_string($_GET['serie_id']) . "' ");

}


?>