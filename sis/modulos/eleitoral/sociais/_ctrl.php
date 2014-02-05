<?
//--------------------Vereador----------------------------------------------------------------
if(isset($_GET['id'])){$id=$_GET['id'];}

if(isset($_POST['id'])){$id=$_POST['id'];}

if($_POST['action']=='Salvar'){
	if($id==0){
		CadastraSociais($_POST['nome'],$vkt_id);
	}
	if($id>0){
		AlteraSociais($_POST['nome'],$id);
	}
}
if($_POST['action']=='Excluir'){
	ExcluiSociais($id);
}

if($id>0){
	$sociais=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_grupos_sociais WHERE id='$id'"));
	//echo $trace;
}
?>