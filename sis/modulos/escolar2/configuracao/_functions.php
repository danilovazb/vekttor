<?php
$tabela = "escolar2_config";

function UpdateConta($campos){
			global $vkt_id,$tabela;
			$CentroCusto = $campos['centro_custo_id'];
			$PlanoConta  = $campos['plano_de_conta_id'];
			
			for($i=0;$i<sizeof($CentroCusto);$i++){
			$UpdateConta = " UPDATE $tabela  
										  SET 
											conta_id        = '$campos[conta_id]',
											centro_custo_id = '$CentroCusto[$i]',
											plano_conta_id  = '$PlanoConta[$i]',
											obs_conta       = '$campos[obsConta]'
										  WHERE 
										  	id = $campos[id] 
			";
			}
			//echo $UpdateConta;
	mysql_query($UpdateConta);
}


function CadastraConta($campos){
	
	global $vkt_id,$tabela;
	
			$CentroCusto = $campos['centro_custo_id'];
			$PlanoConta  = $campos['plano_de_conta_id'];
			for($i=0; $i <sizeof($CentroCusto);$i++){
							$InsertConta = " INSERT INTO  $tabela 
										SET
											vkt_id          = '$vkt_id',         
											conta_id        = '$campos[conta_id]',
											centro_custo_id = '$CentroCusto[$i]',
											plano_conta_id  = '$PlanoConta[$i]',
											obs_conta       = '".$campos[obsConta]."'
							";
				//echo $InsertConta;
			   mysql_query($InsertConta);			
			}
}

?>