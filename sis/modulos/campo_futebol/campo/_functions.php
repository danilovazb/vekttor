<?php
define("TBL_CAMPO", "campo_futebol");
define("VKT_ID", $vkt_id);
	
	function Cadastra($campos){
		$sql = " INSERT INTO ".TBL_CAMPO." (vkt_id, nome, valor1, valor2, valor3 ) VALUES 
		( ".VKT_ID.", '{$campos[nome]}', '{$campos[valor_1]}', '{$campos[valor_2]}', '{$campos[valor_3]}'  ) ";
		
		mysql_query($sql);
	}
	
	function Update($campos){
		$sql = " UPDATE ".TBL_CAMPO." SET 
		nome = '{$campos[nome]}', 
		valor1 = '{$campos[valor_1]}',
		valor2 = '{$campos[valor_2]}',
		valor3 = '{$campos[valor_3]}' WHERE
		id = {$campos[id]} ";
		mysql_query($sql);
	}
	
	function Delete($id){
		$sql = " DELETE FROM ".TBL_CAMPO." WHERE id = {$id} ";
		mysql_query($sql);
	}

?>