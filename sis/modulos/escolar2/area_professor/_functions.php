<?php

function converte_numeros_comvirgula_em_dias_semanas($dias,$semana_abreviado){
	
	$dias = explode(',',$dias );
	
	for($i=0;$i<count($dias);$i++){
		$dias_semana[] = $semana_abreviado[$dias[$i]];	
	}
	return implode(', ',$dias_semana);
}
?>