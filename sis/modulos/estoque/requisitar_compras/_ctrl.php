<?
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

//Cadastra Novo Usuario
if($_POST['action']=='Salvar'&&empty($id)){
	$cadastra=cadastraCompra($_POST['cliente_fornecedor_id'],$_POST['empreendimento_id'],$_POST['data_prevista'],$_POST['data_inicio'],$_POST['valor_total'],$_POST['cond_pag'],$_POST['prod_comp_id'],$_POST['prod_comp_qtd']);
	salvaUsuarioHistorico("Formulário - Compra",'Cadastrou um Novo','compra',$id);
}
//Altera Usuario
if($_POST['action']=='Salvar'&&isset($id)){
	$altera=alteraCompra($id,$_POST['cliente_fornecedor_id'],$_POST['empreendimento_id'],$_POST['data_prevista'],$_POST['data_inicio'],$_POST['valor_total'],$_POST['cond_pag'],$_POST['prod_comp_id'],$_POST['prod_comp_qtd']);
	salvaUsuarioHistorico("Formulário - Compra",'Alterou o ID $id','compra',$id);
}
//Exclui Usuario
if($_POST['action']=='Excluir'&&isset($id)){
	$exclui=excluiCompra($id);
	salvaUsuarioHistorico("Formulário - Compra",'Excluiu o ID $id','compra',$id);
}
//Pega informações
if($id>0){
	$obj=mysql_fetch_object(mysql_query("SELECT * FROM compra WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Produto - Compra",'Abriu o ID $id','compra',$id);
}
?>