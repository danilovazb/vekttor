<?php
function insere_config($campos){
	
	global $vkt_id;
	
			$CentroCusto = $campos['centro_custo_id'];
			$PlanoConta  = $campos['plano_de_conta_id'];
			
			for($i=0; $i <sizeof($CentroCusto);$i++){
			  $InsertConta = " INSERT INTO  estoque_config 
						  SET
							  vkt_id          = '$vkt_id',         
							  conta_id        = '$campos[conta_id]',
							  centro_custo_id = '$CentroCusto[$i]',
							  plano_conta_id  = '$PlanoConta[$i]',
							  obs_conta       = '".$campos[obsConta]."',
							  almoxarifado_id = '$campos[almoxarifado_id]' 
							  ";
			   mysql_query($InsertConta);			
			}
	
}

function altera_config($campos){
	
		
			global $vkt_id;
	
			$CentroCusto = $campos['centro_custo_id'];
			$PlanoConta  = $campos['plano_de_conta_id'];
			
			for($i=0; $i <sizeof($CentroCusto);$i++){
			  $InsertConta = " UPDATE  estoque_config 
						  SET
							  vkt_id          = '$vkt_id',         
							  conta_id        = '$campos[conta_id]',
							  centro_custo_id = '$CentroCusto[$i]',
							  plano_conta_id  = '$PlanoConta[$i]',
							  obs_conta       = '".$campos[obsConta]."',
							  almoxarifado_id = '$campos[almoxarifado_id]'
						WHERE 
							id = $campos[id]
						 
							  ";
			   mysql_query($InsertConta);			
			}
	
}

function deletar_corretor($id){

	$sql = mysql_query(" DELETE FROM corretor WHERE id = '$id' ");	
}

?>