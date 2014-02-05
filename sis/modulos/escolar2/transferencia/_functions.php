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


function transfere_aluno($campos){
	
	global $vkt_id;
	$sql = " 
	UPDATE escolar2_matriculas 
	SET 
		turma_id              = '$campos[turma_transferencia]',
		contrato              = '$campos[texto]',
 		modelo_contrato_id    = '$campos[modelo_id]' 
	WHERE 
		id = '$campos[matricula_id]' ";

	mysql_query($sql);
	
}

?>