<?
if(isset($_GET['id'])){$id=$_GET['id'];}

if(isset($_POST['id'])){$id=$_POST['id'];}

if($_POST['action']=='Salvar'){
	if($id==0){
		cadastraUnidade($_POST['nome'],$_POST['descricao'],$vkt_id);
	}
	if($id>0){
		alteraUnidade($id,$_POST['nome'],$_POST['descricao']);
	}
}
if($_POST['action']=='Excluir'&&$id>0){
	deletaUnidade($id);
}
if($id>0){
	$grupo=mysql_fetch_object(mysql_query("SELECT * FROM produto_grupo WHERE id='$id'"));
}
?>