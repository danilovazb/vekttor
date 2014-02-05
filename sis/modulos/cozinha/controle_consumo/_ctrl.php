<?

if($_POST['action'] == 'Salvar'){
	if($_POST['id']>0){
		altera_controle_consumo($_POST);
		//echo "Altera";
	} else{
		//echo "insere";
		insere_controle_consumo($_POST);
	}
}

if($_POST['action']== 'Excluir'){
	deletar_controle_consumo($_POST['id']);
}

if($_GET['id']>0){
	
	$id = $_GET['id'];
	
		$controle_consumo = mysql_fetch_object(mysql_query("SELECT *, 
							cf.razao_social as razao,
							cc.data as data_cc,
							cc.id   as c_id,
							cc.contrato_id as contrato_id			 			  
						FROM cozinha_controle_consumo cc
						JOIN cozinha_contratos ct
	  					  	ON cc.contrato_id=ct.id
					    JOIN cliente_fornecedor cf
	                      	ON ct.cliente_id = cf.id
	  
	 	 				WHERE cc.vkt_id = '$vkt_id'
	 	 				
	 	 				AND cc.id = '$id' "));
}

	

?>