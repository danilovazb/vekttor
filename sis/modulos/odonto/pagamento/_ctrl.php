<?

	/* === 
		Criado por Jaime Neves antes de alterar qualquer linha de código fale com o autor 
	===*/
	
	if($_POST['action'] == 'MandarFinanceiro'){		
		MandarFinanceiro($_POST);
	}

	if($_POST['action']=='Excluir'){
			excluir($_POST['id']);		
	}

	if($_POST['action'] == 'Anexar'){}

	if($_GET['id'] > 0){
	
		$cliente_id = $_GET['cliente_id'];
		$atendimento_id = $_GET["id"];
		$paciente = mysql_fetch_object(mysql_query($t=" SELECT * FROM cliente_fornecedor WHERE id = '$cliente_id' AND cliente_vekttor_id = '$vkt_id' "));	
	}

	if($_GET['contato_id']>0){}
?>