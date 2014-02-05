<?php
function manipulaEventos($dados){
	
	global $vkt_id;
	
	if($dados[id]<=0){
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	if($dados[tributado]=='on'){
		$tributado='sim';
	}else{
		$tributado='nao';
	}
	
		
		
	mysql_query($t="$inicio rh_eventos SET
		vkt_id='$vkt_id',
		nome='$dados[nome]',
		descricao='$dados[descricao]',
		valor='".moedaBrToUsa($dados[valor])."',
		forma_valor='".$dados[forma_valor]."',	
		tributado='$tributado',
		vencimento_ou_desconto='".$dados[vencimento_ou_desconto]."'
		,funcionario_id='".$_POST['funcionario_id']."',empresa_id='".$_POST['empresa_id']."', cargo_id='".$_POST['cargo_id']."',
		regra_desconto ='".$_POST['regra_desconto']."'
		$fim"); 
		//echo mysql_error();
		//pr($t);

}

function excluiCargosSalarios($_POST,$vkt_id){
	mysql_query($t="DELETE FROM rh_eventos WHERE id='$_POST[id]'");
}
?>