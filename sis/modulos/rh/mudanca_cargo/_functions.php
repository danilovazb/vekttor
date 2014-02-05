<?php
function manipulaContrato($dados,$vkt_id){
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio rh_alteracao_contrato SET
		vkt_id='$vkt_id',
		empresa_id='$dados[empresa_id]',
		funcionario_id='$dados[funcionario_id]',
		cargo_id='$dados[f_cargo_id]',
		cargo='$dados[f_cargo]',
		cbo='$dados[f_cbo]',
		motivo='".$dados['motivo']."',
		data='".DataBrToUsa($dados['f_data'])."'		
		$fim");
		//echo $t."<br>";
	
	mysql_query($t="$inicio rh_alteracao_salario SET
		vkt_id='$vkt_id',
		empresa_id='$dados[empresa_id]',
		funcionario_id='$dados[funcionario_id]',
		salario='".MoedaBrToUsa($dados[f_salario])."',
		motivo='3',
		observacao='".$dados['motivo']."',
		data=NOW()		
		$fim");
	mysql_query("UPDATE rh_funcionario SET cargo_id='".$dados[f_cargo_id]."', cargo='".$dados[f_cargo_id]."', 'salario='".MoedaBrToUsa($dados[vlr_salario_novo])."' WHERE id='".$dados[funcionario_id]."'");	
		//echo $t."<br>";
}

/*function excluiCargosSalarios($_POST,$vkt_id){
	mysql_query("DELETE FROM cargo_salario WHERE id='$_POST[id]'");
}*/
?>