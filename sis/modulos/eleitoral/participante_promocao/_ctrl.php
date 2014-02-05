<?
//--------------------Vereador----------------------------------------------------------------
if(isset($_GET['id'])){$id=$_GET['id'];}

if(isset($_POST['id'])){$id=$_POST['id'];}

if($_POST['action']=='Salvar'){
		ManipulaParticipantePromocao($_POST,$vkt_id);

}
if($_POST['action']=='Excluir'){
	ExcluiPromocao($_POST['id']);
}

if($id>0){
	$promocao=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_promocao WHERE id='$id'"));
	//echo $trace;
}
?>