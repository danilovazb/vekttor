<?

if($_POST['action_contrato']==1){
	
	if($_POST['action']=='Excluir'){
		gerencia_contrato($_POST[contrato_id],$_POST,'DELETE');
	}else{
		gerencia_contrato($_POST[contrato_id],$_POST,'INSERT_UPDATE');
	}
}

if($_GET['contrato_id']>0){
	
	$contrato_id= $_GET['contrato_id'];
	$contrato = mysql_fetch_object(mysql_query($t="SELECT * FROM financeiro_contratos WHERE id='$contrato_id' AND vkt_id ='$vkt_id'"));
	$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$contrato->cliente_fornecedor_id'"));
	$movimento_contrato = conta_movimento_de_contrato($contrato->id);
	
}


?>