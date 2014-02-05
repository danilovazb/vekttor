<?php
function manipulaContrato($dados,$vkt_id){
	
	$exists = mysql_fetch_object(mysql_query("SELECT * FROM aluguel_contrato WHERE id='$vkt_id'"));
	
	$texto = $dados[texto];
	
	if($exists->id>0){
		$inicio="UPDATE";
		$fim="WHERE id=".$dados['id'];
	}else{
		$inicio="INSERT INTO";
		$fim="";
	}
	$sql=mysql_query($t="$inicio aluguel_contrato SET 
			id='$vkt_id',
			contrato='$texto'
			$fim");
			
}


?>