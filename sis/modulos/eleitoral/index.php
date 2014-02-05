<?php
	$_SESSION['usuario']->cliente_vekttor_id='169';
	echo "Session: ".$_SESSION['usuario']->cliente_vekttor_id;
	$_SESSION['usuario']->usuario_tipo_id='200';
	include('../../../_config.php');
	include('../../_functions_base.php');
	include('eleitores/_function.php');
	include('eleitores/_ctrl.php');
	
?>