<?php

if($_POST['acao']=="consulta_materias"){
	include("../../../_config.php");
	include '_functions.php';
	$materias = consulta_materias($_POST);
	echo $materias;
	exit();
}

?>