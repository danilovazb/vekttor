<?
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

//Cadastra Novo Usuario
if($_POST['action']=='Salvar'){
	$cadastra=baixaInventario($_POST['produto_id'],$_POST['nova_qtd']);
	salvaUsuarioHistorico("Formul�rio - Produto",'Cadastrou um Novo','produto',$id);
}
//Pega informa��es
if($id>0){
	$obj=mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formul�rio - Produto",'Abriu o ID $id','produto',$id);
}
?>