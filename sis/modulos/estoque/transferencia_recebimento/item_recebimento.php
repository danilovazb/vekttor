<?php
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");

if($_GET['acao'] == 'recebe_upqtd'){
			$qtd           = qtdBrToUsa($_POST['qtd'],2);
			$id_p          = $_POST['id_p'];
			$transferencia = $_POST['t'];
			$conversao2    = $_POST['conversao2'];
			$unidade_tipo  = $_POST['unidade_tipo'];
			
			if($unidade_tipo=='unidade_uso'){
				
				$qtd = $qtd/$conversao2;
				
			}
			
			mysql_query($t=" UPDATE estoque_transferencia_item SET qtd_recebida = '$qtd' WHERE produto_id = '$id_p' AND transferencia_id = '$transferencia' AND vkt_id = '$vkt_id' ");
			
}

if($_GET['acao'] == 'oc_recebimento'){

	$transferencia  = $_POST['trans_id'];
	$oc_recebimento = iconv('utf-8','iso-8859-1',$_POST['oc_recebimento']);	
	
			mysql_query($t="
					UPDATE estoque_transferencia
					
					SET 
						ocorrencia_recebimento = '$oc_recebimento'
					WHERE 
						id = '$transferencia'
					AND
						vkt_id = '$vkt_id'
			");
}

if($_GET['acao'] == 'oc_item'){
	
		$trans_id = $_POST['trans_id'];
		$p_id     = $_POST['p_id'];
		$oc_item  = iconv('utf-8','iso-8859-1',$_POST['oc']);
		
			mysql_query($t="
				UPDATE estoque_transferencia_item
					SET 
						ocorrencia_recebimento = '$oc_item' 
					WHERE 
						produto_id = '$p_id'
					AND
						transferencia_id = '$trans_id' 
					AND
						vkt_id = '$vkt_id'	
					
			");
			echo $t;

}
if($_GET['acao'] == 'recebido'){
		
		$trans_id = $_POST['trans_id'];
		$data = date('Y-m-d');	
		
			/*mysql_query(" UPDATE estoque_transferencia
							SET
								data_fim = '$data',
								status   = '2'
							WHERE 
								id = '$trans_id'
							AND
								vkt_id = '$vkt_id'
						");*/
	
}
?>