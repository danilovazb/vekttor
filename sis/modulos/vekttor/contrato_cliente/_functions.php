<?php
function manipulaContrato($dados,$vkt_id){
	
	$exists = mysql_fetch_object(mysql_query("SELECT * FROM contrato_modelo_cliente WHERE id='$vkt_id'"));
	
	$texto = $dados[texto];
	
	if($exists->id>0){
		$inicio="UPDATE";
		$fim="WHERE id=".$dados['id'];
	}else{
		$inicio="INSERT INTO";
		$fim="";
	}
	$sql=mysql_query($t="$inicio contrato_modelo_cliente SET 
			id='$vkt_id',
			contrato='$texto'
			$fim");
			//echo $t;
			
}


?>