<?
if(isset($_GET['id'])){$id=$_GET['id'];}

if(isset($_POST['id'])){$id=$_POST['id'];}

if($_POST['action']=='Salvar'){
	if($id==0){
		cadastraUnidade($_POST['nome'],$_POST['descricao']);
	}
	if($id>0){
		alteraUnidade($id,$_POST['nome'],$_POST['descricao']);
	}
}
if($_POST['action']=='Excluir'&&$id>0){
	deletaUnidade($id);
}
if($id>0){
	$unidade=mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id='$id'"));
}
?>