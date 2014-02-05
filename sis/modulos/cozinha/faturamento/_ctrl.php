<?

if($_POST['action']== 'Salvar'){
	if($_POST['id']>0){
		//echo "altera";
		altera_faturamento($_POST);
	} else{
		//echo "cadastra";
		insere_faturamento($_POST);	
	}
}
if($_POST['action']== 'Excluir'){
	deletar_faturamento($_POST['id']);
}

if($_GET['id']>0){
	
	$id = $_GET['id'];
	
		$faturamento = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_faturamento WHERE id = ".$id));
		
		if(!empty($faturamento->data_inicio))
					$data_ini = dataUsaToBr($faturamento->data_inicio);
				else
					$data_ini = "";
		
		if(!empty($faturamento->data_fim))
					$data_fim = dataUsaToBr($faturamento->data_fim);
				else
					$data_fim = "";
	
	
}

	

?>