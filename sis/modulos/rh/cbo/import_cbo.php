<?php

	include("../../../_config.php");
	include("../../../_functions_base.php");
	$arquivo = file("CBO2002 - SubGrupo Principal.txt");
	
	foreach($arquivo as $a){
		
		$cbo       = explode("    ",$a);
		$codigo    = $cbo[0];
		
		$descricao = $cbo[1];
		
		$tipo      = "SubGrupo";
		echo $codigo." ".$descricao."<br>";
		 
	
		mysql_query("INSERT INTO rh_cbo SET cbo='$codigo', descricao='$descricao', tipo='$tipo'");
		echo mysql_error()."<br>";
	}
?>