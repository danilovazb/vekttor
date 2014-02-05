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
		observacao='".$dados['observacao']."',
		motivo='".$dados['motivo']."',
		data='".DataBrToUsa($dados[data_alteracao])."'		
		$fim");
	mysql_query("UPDATE rh_funcionario SET salario='".MoedaBrToUsa($dados[vlr_salario_novo])."' WHERE id='".$dados[funcionario_id]."'");
	//echo $t;
}

$motivos = array(1=>'BONIFICAวรO',2=>'GRATIFICAวรO POR FUNวรO',3=>'MUDANวA DE FUNวรO');

/*function excluiCargosSalarios($_POST,$vkt_id){
	mysql_query("DELETE FROM cargo_salario WHERE id='$_POST[id]'");
}*/
?>