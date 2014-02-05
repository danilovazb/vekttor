<?php
function manipulaFerias($dados,$vkt_id){
	
	//if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	//}else{
		//$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	//}
	
	mysql_query($t="$inicio rh_ferias SET
		vkt_id='$vkt_id',
		empresa_id='$dados[empresa_id]',
		funcionario_id='$dados[funcionario_id]',
		data_inicio_aquisicao='".DataBrToUsa($dados[data_inicio_aquisicao])."',
		data_fim_aquisicao='".DataBrToUsa($dados[data_final_aquisicao])."',
		data_inicio='".DataBrToUsa($dados[data_inicio])."',
		data_fim='".DataBrToUsa($dados[data_final])."',
		faltas='$dados[faltas]',
		salario_base='".MoedaBrToUsa($dados[salario_base])."'		
		$fim");
	//echo mysql_error()." ".$t;
}

function deleteFerias($dados){
	mysql_query($t="DELETE FROM rh_ferias WHERE id = '$dados[deleta_ferias]'");

}
?>