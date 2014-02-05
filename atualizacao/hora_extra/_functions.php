<?php
function manipulaINSS($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio rh_inss SET
		valor_minimo='".MoedaBrToUsa($dados[menor_salario])."',
		valor_maximo='".MoedaBrToUsa($dados[maior_salario])."',	
		valor_beneficio='".MoedaBrToUsa($dados[valor_beneficio])."'	
		$fim");
	//echo $t." ".mysql_error();
}

function excluiinss($_POST){
	mysql_query("DELETE FROM rh_inss WHERE id='$_POST[id]'");
} 
?>