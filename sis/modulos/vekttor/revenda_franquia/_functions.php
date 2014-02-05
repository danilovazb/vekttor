<?
//Funções 

//Cliente Fornecedor
function cadastraFranquiaRevenda($cliente_id,$vkt_id){
			
			$cadastra = mysql_query("INSERT INTO revenda_franquia SET cliente_id = $cliente_id, vkt_id = $vkt_id");
				return 1;
}

function alteraFranquia($id,$cliente_id,$vkt_id){
			$altera = mysql_query(" UPDATE revenda_franquia 
									SET cliente_id = $cliente_id,
									vkt_id = $vkt_id 
									WHERE id = '$id' ");
			return 1;	
}

function excluiFranquia($id){
		
		mysql_query($trace="
					DELETE FROM revenda_franquia
					WHERE id ='".$id."'
					");

		return 1;
	

}

?>