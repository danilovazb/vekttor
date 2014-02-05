<?php

	if($_POST["action"] == "Salvar"){
		
		if($_POST["id"] > 0)
			Update($_POST);	
		else
			Cadastra($_POST);
	}
	
	if($_POST["action"] == "Excluir"){
		Delete($_POST["id"]);
	}
	
	if($_GET["id"] > 0){
		$select = mysql_fetch_object( mysql_query($u=" SELECT * FROM ".TBL_CAMPO." WHERE id = '".trim($_GET["id"])."' "));
	}

?>