<?php
function manipulaContratoCliente($dados,$vkt_id){
	
	$texto = $dados[texto];
	
	if($dados['id']>0){
		$inicio="UPDATE";
		$fim="status='{$dados['status']}' WHERE id=".$dados['id'];
	}else{
		$inicio="INSERT INTO";
		$fim="status='1'";
	}
	$sql=mysql_query($t="$inicio odontologo_contrato_cliente SET 
			vkt_id='$vkt_id',
			contrato_modelo_id='{$dados['modelo_id']}',
			cliente_id='{$dados['cliente_id']}',
			nome='{$dados['nome']}',
			html_contrato='$texto',			
			$fim");
			//echo $t;
			
}

function exclui_contrato_cliente($id){
	mysql_query($t="DELETE FROM odontologo_contrato_cliente WHERE id=$id");
	//echo $t." ".mysql_error();
}

?>