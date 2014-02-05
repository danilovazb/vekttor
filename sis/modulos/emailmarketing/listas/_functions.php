<?php
function manipulaLista($dados){
	
	global $vkt_id;
	
	if($dados['id']>0){
		$inicio="UPDATE";
		$fim="WHERE id=".$dados['id'];
	}else{
		$inicio="INSERT INTO";
		$fim="";
	}
	$sql=mysql_query($t="$inicio emailmarketing_listas SET 
			vkt_id='$vkt_id',
			nome='{$dados['nome']}',
			observacao='{$dados['observacao']}'
			$fim");
			echo $t;
			
}

function exclui_contrato($id){
	mysql_query($t="DELETE FROM odontologo_contrato_modelo WHERE id=$id");
	//echo $t." ".mysql_error();
}

?>