<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];



//Cadastra Registro
if($_POST['action']=='Finalizar Venda'&&empty($id)){
	//cadastraEmpreendimento($nome,$tipo,$orcamento,$inicio,$fim,$obs)
	novaVenda();
}
//Altera Registro
if($_POST['action']=='Salvar'&&isset($id)){
	$altera=alteraContrato($id,$_POST['nome'],$_POST['tipo'],$_POST['orcamento'],$_POST['inicio'],$_POST['fim'],$_POST['obs']);
}
//Exclui Usuario
if($_POST['action']=='Excluir'&&isset($id)){
	
		$exclui=excluiContrato($id);
}
//Pega informações
if($id>0){
	$contrato=mysql_fetch_object(mysql_query("SELECT * FROM contrato WHERE id='".$id."' LIMIT 1"));
	$cliente=mysql_fetch_object(mysql_query($trace="SELECT * FROM cliente_fornecedor WHERE id='".$contrato->cliente_fornecedor_id ."' LIMIT 1"));
	//echo $trace;
	//print_r($cliente);
	$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='".$contrato->disponibilidade_id."' LIMIT 1"));
	$disponibilidade_tipo=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade_tipo WHERE id='".$disponibilidade->disponibilidade_tipo_id."' LIMIT 1"));
	$negociacao=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE id='".$contrato->negociacao_id."' LIMIT 1"));
}

?>