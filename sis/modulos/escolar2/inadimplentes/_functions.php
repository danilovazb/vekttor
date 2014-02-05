<?php
   
   function get_nome($nome = NULL, $tamanho = NULL){
	
			if( !empty($nome) and !empty($tamanho) ){
			if( strlen($nome) > $tamanho )
				echo strtoupper(substr($nome,0,$tamanho))."...";
			else
				echo strtoupper($nome);
			}
			
	}
?>