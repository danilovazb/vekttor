<?
function insere_controle_consumo($campos){
		global $vkt_id;
		$data = explode("/",$campos[data]);
		$data = $data[2]."-".$data[1]."-".$data[0];
		
					$sql=mysql_query($t=" INSERT INTO cozinha_controle_consumo 
							SET	 
								vkt_id         = '$vkt_id',
								contrato_id    = '$campos[contrato_id]',
								data           = '$data',
								pedido_cafe    = '$campos[pedido_cafe]',
								pedido_almoco  = '$campos[pedido_almoco]',
								pedido_lanche  = '$campos[pedido_lanche]',
								pedido_jantar  = '$campos[pedido_jantar]',
								pedido_seia    = '$campos[pedido_seia]',
								
								consumido_cafe    = '$campos[consumido_cafe]',
								consumido_almoco  = '$campos[consumido_almoco]',
								consumido_lanche  = '$campos[consumido_lanche]',
								consumido_jantar  = '$campos[consumido_jantar]',
								consumido_seia    = '$campos[consumido_seia]'
								 ");
								
}

function deletar_controle_consumo($id){
	mysql_query("
			DELETE FROM 
				cozinha_controle_consumo
			WHERE
				id='$id'
	");
}

function altera_controle_consumo($campos){
		$id = $campos['id'];
		$data = explode("/",$campos[data]);
		$data = $data[2]."-".$data[1]."-".$data[0];
		$sql=mysql_query("UPDATE cozinha_controle_consumo 
							SET
								contrato_id    = '$campos[contrato_id]',
								data           = '$data',
								pedido_cafe    = '$campos[pedido_cafe]',
								pedido_almoco  = '$campos[pedido_almoco]',
								pedido_lanche  = '$campos[pedido_lanche]',
								pedido_jantar  = '$campos[pedido_jantar]',
								
								consumido_cafe    = '$campos[consumido_cafe]',
								consumido_almoco  = '$campos[consumido_almoco]',
								consumido_lanche  = '$campos[consumido_lanche]',
								consumido_jantar  = '$campos[consumido_jantar]'
							WHERE id = $id
		");
		
}

?>