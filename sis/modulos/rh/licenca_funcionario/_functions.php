<?php
function manipulaLicencaFuncionario($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio rh_licencas_funcionarios SET
		vkt_id              ='$vkt_id',
		licenca_id          ='$dados[licenca_id]',
		funcionario_id      ='$dados[funcionario_id]', 
		data_inicio	        ='".DataBrToUsa($dados[data_inicio])."',
		data_fim  	        ='".DataBrToUsa($dados[data_fim])."'
		$fim");	
		
}

function excluiLicenca($_POST,$vkt_id){
	mysql_query($t="DELETE FROM rh_licencas_funcionarios WHERE id='$_POST[id]'");
}
?>