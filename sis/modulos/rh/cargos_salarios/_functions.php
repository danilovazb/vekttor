<?php
function manipulaCargosSalarios($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio cargo_salario SET
		vkt_id='$vkt_id',
		cbo='$dados[cbo]',
		cargo='$dados[cargo]',
		valor_salario='".moedaBrToUsa($dados[vlr_salario])."',
		empresa_id='".$dados[empresa_id]."'		
		$fim");
	
}

function excluiCargosSalarios($_POST,$vkt_id){
	mysql_query("DELETE FROM cargo_salario WHERE id='$_POST[id]'");
}
?>