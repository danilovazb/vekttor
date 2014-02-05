<?php

$tabela = "matriculas";

	function get_string($nome = NULL, $tamanho = NULL){
	
			if( !empty($nome) and !empty($tamanho) ){
			if( strlen($nome) > $tamanho )
				echo   (substr(strtoupper($nome),0,$tamanho)."...");
			else
				echo strtoupper($nome);
			}
			
	}


function altera_matricula($campos){
	
	global $vkt_id;
	$sql = " 
	UPDATE escolar2_matriculas 
	SET 
		valor_matricula       = '".moedaBrToUsa($campos[valor_matricula])."',
		valor_mensalidade     = '".moedaBrToUsa($campos[valor_mensalidade])."' 		
	WHERE 
		id = '$campos[matricula_id]' ";
	
	mysql_query($sql);
	
}

?>