<?php
	function retirar_caracter($string){
	
		$array = array(
					 "-"=>"",
					 "[�A��A]"=>"A",
					 "'"=>"",
					 "`"=>"",
					 "[EE��]"=>"E",
					 "[ee��]"=>"e",
					 "[��II]"=>"I",
					 "[��ii]"=>"i",
					 "[�OO��]"=>"O",
					 "[�oo��]"=>"o",
					 "[UU��]"=>"U",
					 "("=>"",")"=>"",
					 "�"=>"I","�"=>"i",
					 "�"=>"A","�"=>"A","�"=>"a","�"=>"A","�"=>"a", "�"=>"a",
					 "�"=>"U","�"=>"u",
					 "�"=>"O","�"=>"O","�"=>"o","�"=>"o",
					 "  "=> " ",
					 ","=>"",
					 "/"=>"",
					 "."=>"",
					 "�"=>"c",
					 "�"=>"C"
				);
			return (str_replace(array_keys($array), array_values($array), $string));
 	}
	
	/* array de condi�oes para o (registro tipo 10) linha no 5, inscri�ao tomador/obra de const. civil(*) */
	$array_tomador_obra_const_civil = array("130","135","150","155","211","317","337","608");
	
	/* Registro Tipo 10 - Al�quota RAT */
	$array_rat_cod_recolhimento = array("145","307","317","327","337","345","640","660");
	
	/* Registro Tipo 10 - C�digos de Outras Entidades */
	$array_cod_recolhimento_informa  = array("115","130","135","150","155","211","608","650");
	$array_cod_recolhimento_ninforma = array("145","307","317","327","337","345","640","660");
	
	/* Registro Tipo 10 C�digo de Pagamento GPS linha 20 */
	$array_cod_recolhimento_gps = array("115","150","211","650");
	
	/* Registro Tipo 32, tipo de instru��o-Tomador/ Obra Const. Civil, Linha 4 */
	$tipo_const_civil_t32 = array("130","135","150","155","608");
	
	/* Registro Tipo 30, remunera��o sem d�cimo terceiro */
	$array_sem_decimo = array("05","11","13","14","15","16","17","18","22","23","24","25");