<?php
function manipulaAtendimento($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio os_atendimento SET
		vkt_id='$vkt_id',
		descricao='$dados[descricao]',
		observacao='$dados[observacao]'
		$fim");
		//echo $t."<br>";
		
}

function excluiAtendimento($_POST,$vkt_id){
	$t=mysql_query("DELETE FROM os_atendimento WHERE id='$_POST[id]'");
}
?>