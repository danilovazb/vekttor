<?
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

//Altera Compra
if($_POST['action']=='Salvar'&&isset($id)){
	$altera=alteraCompra($id,$_POST['cliente_fornecedor_id'],$_POST['empreendimento_id'],$_POST['data_prevista'],$_POST['data_inicio'],$_POST['valor_total'],$_POST['cond_pag'],$_POST['produto_compra_id'],$_POST['prod_comp_qtd']);
	salvaUsuarioHistorico("Formulário - Compra",'Alterou o ID $id','compra',$id);
}
//Cancela Compra
if($_POST['action']=='Cancelar'&&isset($id)){
	$exclui=cancelaCompra($id);
	salvaUsuarioHistorico("Formulário - Compra",'Cancelou o ID $id','compra',$id);
}

//Autoriza Compra
if($_POST['action']=='Autorizar'&&isset($id)){
	$altera=alteraCompra($id,$_POST['cliente_fornecedor_id'],$_POST['empreendimento_id'],$_POST['data_prevista'],$_POST['data_inicio'],$_POST['valor_total'],$_POST['cond_pag'],$_POST['produto_compra_id'],$_POST['prod_comp_qtd']);
	$autoriza=autorizaCompra($id);
	salvaUsuarioHistorico("Formulário - Compra",'Autorizou o ID $id','compra',$id);
}

//Pega informações
if($id>0){
	$obj=mysql_fetch_object(mysql_query("SELECT * FROM compra WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Compra",'Abriu o ID $id','compra',$id);
}
?>