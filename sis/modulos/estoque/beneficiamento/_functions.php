<?php
session_start();

function insere_beneficiamento($campos){
			global $login_id;
			global $vkt_id;
			
			$produto_derivado_id = $campos['produto_derivado_id'];
			$qtd_derivado        = $campos['qtd_derivado'];
			$obs_derivado1        = $campos['obs_derivado1'];
			
			
			
			$produto_beneficiado = $campos['produto_beneficiado_id'];
			$pedido_id           = $campos['pedido_beneficiamento_id'];
			$item_pedido_id      = $campos['pedido_id'];
			$data_pedido         = dataBrToUsa($campos['data_pedido']);
			$qtd_pedido          = moedaBrToUsa($campos['qtd_produto_beneficiado']);
			$obs_pedido          = $campos['obs_pedido'];
				
				$sql=" INSERT INTO estoque_beneficiamento_pedido
							SET 
								vkt_id                 = '$vkt_id',
								produto_beneficiado_id = '$produto_beneficiado',
								pedido_id              = '$pedido_id',
								item_pedido_id         = '$item_pedido_id',
								data_pedido            = '$data_pedido',
								qtd_pedido             = '$qtd_pedido',
								desperdicio            = '$campos[desperdicio]',
								obs                    = '$obs_pedido',								
								status                 = '1'								
				";
				//echo $sql;
				mysql_query($sql);
				$ultimo_beneficiado = mysql_insert_id();
				
				
				for($i = 0; $i < count($produto_derivado_id);$i++){
						$sql_item="
						INSERT INTO estoque_beneficiamento_item
								SET 
									beneficiamento_id = '$ultimo_beneficiado',
									vkt_id            = '$vkt_id', 
									produto_id        = '$produto_derivado_id[$i]',
									qtd_pedida        = '".$qtd_derivado[$i]."',
									obs_item_pedido	  = '$obs_derivado1[$i]'
						";
						//altera_beneficiamentoecho $sql_item."<br>";
					mysql_query($sql_item);
				}		
}

function altera_beneficiamento($campos){
	
		global $vkt_id;
			
			$produto_derivado_id = $campos['produto_derivado_id'];
			$qtd_derivado        = $campos['qtd_derivado'];
			$obs_derivado1       = $campos['obs_derivado1'];
			
			$item_pedido_id      = $campos['pedido_id'];
			$produto_beneficiado = $campos['produto_beneficiado_id'];
			$pedido_id           = $campos['pedido_beneficiamento_id'];
			$data_pedido         = dataBrToUsa($campos['data_pedido']);
			$qtd_pedido          = moedaBrToUsa($campos['qtd_produto_beneficiado']);
			$obs_pedido          = $campos['obs_pedido'];
			
		$sql = ($t="UPDATE estoque_beneficiamento_pedido 
		
					SET 
						vkt_id                 = '$vkt_id',
						qtd_pedido             = '$qtd_pedido',
						desperdicio            = '".moedaBrToUsa($campos[desperdicio])."',
						obs                    = '$obs_pedido',
						item_pedido_id         = '$item_pedido_id'		
					WHERE 
						id = '{$campos['id_pedido']}'");
		//echo $t." ".mysql_error();
			mysql_query($sql); 
		for($i = 0; $i < count($produto_derivado_id);$i++){
						
						if($produto_derivado_id>0){
						$sql_item="
						INSERT INTO estoque_beneficiamento_item
								SET 
									beneficiamento_id = '".$campos['id_pedido']."',
									vkt_id            = '$vkt_id',
									produto_id        = '$produto_derivado_id[$i]',
									qtd_pedida        = '".$qtd_derivado[$i]."',
									obs_item_pedido	  = '$obs_derivado1[$i]'
						";
						
					mysql_query($sql_item);
						}
					//echo $t." ".mysql_error();
				}
}

function deletar_corretor($id){

	$sql = mysql_query(" DELETE FROM corretor WHERE id = '$id' ");	
}

function Saldo($total_derivado,$total_beneficido){
	
		$saldo = $total_beneficido = $total_derivado;
		
			echo $saldo;
}

?>