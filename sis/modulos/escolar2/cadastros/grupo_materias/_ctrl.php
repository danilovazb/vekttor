<?php

	
	if($_POST['action']=='Salvar'){
		
		if( empty($_POST["id"]) )
			insereGrupoMateria($_POST);
		 else 
		 	updateGrupoMateria($_POST);		
	}
	
	if($_POST['action']=='Excluir'){
		delete($_POST["id"]);
	}
	
	if( $_GET["id"] > 0 ){
		$id = $_GET["id"];
		$info_grupo = mysql_fetch_object( mysql_query(" SELECT * FROM escolar2_grupo_materia WHERE vkt_id = '$vkt_id' AND id = '$id'  "));
	}
