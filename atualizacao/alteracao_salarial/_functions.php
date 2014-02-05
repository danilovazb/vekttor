<?php
function manipulaSalarios($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio rh_alteracao_salario SET
		vkt_id='$vkt_id',
		empresa_id='$dados[empresa_id]',
		funcionario_id='$dados[funcionario_id]',
		salario='".MoedaBrToUsa($dados[vlr_salario_novo])."',
		data='".DataBrToUsa($dados[data_alteracao])."'		
		$fim");
	//echo $t;
}

/*function excluiCargosSalarios($_POST,$vkt_id){
	mysql_query("DELETE FROM cargo_salario WHERE id='$_POST[id]'");
}*/
?>