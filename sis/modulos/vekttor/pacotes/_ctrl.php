<?php

if($_POST['action']== 'Salvar'){
	
		if($_POST['id'] > 0)
				UpdadePacote($_POST);
		else
				CadPacote($_POST);
}

if($_POST['action']== 'Excluir'){
			Deleta($_POST['id']);
}

if($_GET['id'] > 0){
			$id = $_GET['id'];	
			$pacote = mysql_fetch_object(mysql_query(" SELECT * FROM pacotes WHERE id = '$id' "));
}


?>