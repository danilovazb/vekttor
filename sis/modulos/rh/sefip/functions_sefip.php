<?php
	function retirar_caracter($string){
	
		$array = array(
					 "-"=>"",
					 "[ÂAÁÄA]"=>"A",
					 "'"=>"",
					 "`"=>"",
					 "[EEÉË]"=>"E",
					 "[eeéë]"=>"e",
					 "[ÎÍII]"=>"I",
					 "[îíii]"=>"i",
					 "[ÔOOÓÖ]"=>"O",
					 "[ôooóö]"=>"o",
					 "[UUÚÜ]"=>"U",
					 "("=>"",")"=>"",
					 "Í"=>"I","í"=>"i",
					 "Ã"=>"A","Ä"=>"A","ã"=>"a","Á"=>"A","á"=>"a", "à"=>"a",
					 "Ú"=>"U","ú"=>"u",
					 "Ó"=>"O","Ô"=>"O","ó"=>"o","ô"=>"o",
					 "  "=> " ",
					 ","=>"",
					 "/"=>"",
					 "."=>"",
					 "ç"=>"c",
					 "Ç"=>"C"
				);
			return (str_replace(array_keys($array), array_values($array), $string));
 	}
	
	/* array de condiçoes para o (registro tipo 10) linha no 5, inscriçao tomador/obra de const. civil(*) */
	$array_tomador_obra_const_civil = array("130","135","150","155","211","317","337","608");
	
	/* Registro Tipo 10 - Alíquota RAT */
	$array_rat_cod_recolhimento = array("145","307","317","327","337","345","640","660");
	
	/* Registro Tipo 10 - Códigos de Outras Entidades */
	$array_cod_recolhimento_informa  = array("115","130","135","150","155","211","608","650");
	$array_cod_recolhimento_ninforma = array("145","307","317","327","337","345","640","660");
	
	/* Registro Tipo 10 Código de Pagamento GPS linha 20 */
	$array_cod_recolhimento_gps = array("115","150","211","650");
	
	/* Registro Tipo 32, tipo de instrução-Tomador/ Obra Const. Civil, Linha 4 */
	$tipo_const_civil_t32 = array("130","135","150","155","608");
	
	/* Registro Tipo 30, remuneração sem décimo terceiro */
	$array_sem_decimo = array("05","11","13","14","15","16","17","18","22","23","24","25");