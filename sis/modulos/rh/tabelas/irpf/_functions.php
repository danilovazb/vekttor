<?php
function manipulaIrpf($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio rh_irpf SET
		valor_minimo='".MoedaBrToUsa($dados[menor_salario])."',
		valor_maximo='".MoedaBrToUsa($dados[maior_salario])."',	
		percentual_aliquota='".MoedaBrToUsa($dados[valor_aliquota])."',
		valor_deducao='".MoedaBrToUsa($dados[valor_deducao])."'		
		$fim");
	//echo $t." ".mysql_error();
}

function excluiIrpf($dados){
	mysql_query("DELETE FROM rh_irpf WHERE id='$dados[id]'");
} 
?>