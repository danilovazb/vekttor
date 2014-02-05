<?php

if($_POST['action']== 'Salvar'){
	manipulaFeriado($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	excluiFeriado($_POST,$vkt_id);
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	$registro = mysql_fetch_object(mysql_query("SELECT * FROM rh_feriado WHERE id='$id' "));

}



?>