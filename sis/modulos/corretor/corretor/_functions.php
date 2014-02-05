<?php
function insere_corretor($campos){
	global $login_id;
	global $vkt_id;
	
	$sql = ($t="INSERT INTO corretor SET nome = '{$campos['nome']}', imobiliaria_id = '$login_id', vkt_id='$vkt_id' ");
	
		$result = mysql_query($sql);
		
				if($result){
				} else{
					mysql_error($result);	
				}
	
}

function altera_corretor($campos){
	
		$sql = ("UPDATE corretor SET nome = '{$campos['nome']}' WHERE id = '{$campos['id']}'");
		
			mysql_query($sql); 
	
}

function deletar_corretor($id){

	$sql = mysql_query(" DELETE FROM corretor WHERE id = '$id' ");	
}

?>