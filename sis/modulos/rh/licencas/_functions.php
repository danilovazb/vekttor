<?php
function manipulaLicenca($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio rh_licencas SET
		vkt_id='$vkt_id',
		nome                = '$dados[nome]',
		codigo              = '$dados[codigo]',
		remunerado          = '$dados[remunerado]',
		tipo                = '$dados[tipo_licenca]'
		$fim");	
		
}

function excluiLicenca($_POST,$vkt_id){
	$licenca_funcionario = mysql_result(mysql_query("SELECT COUNT(*) FROM rh_licencas_funcionarios WHERE licenca_id='$_POST[id]'"),0,0);
	
	if(!$licenca_funcionario>0){	
		mysql_query($t="DELETE FROM rh_licencas WHERE id='$_POST[id]'");
	}else{
		alert("Licença não pode ser excluída, há funcionários associados a ela!");
	}
	
}
?>