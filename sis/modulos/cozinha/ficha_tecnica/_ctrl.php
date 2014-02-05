<?
//print_r($_POST);
//print_r($_GET);
if(isset($_POST['id'])){$id=$_POST['id'];}
if(isset($_GET['id'])){$id=$_GET['id'];}

if(($id==0 || empty($id)) && $_POST['action']=='Salvar'){
	$cadastro=adicionaFicha($_POST,$vkt_id);
}

if($id>0){
	if($_POST['action']=='Salvar'){
		alteraFicha($id,$_POST);
	}
	if($_POST['action']=='Inativar'){
		deletaFicha($id,'inativo');
	}
	if($_POST['action']=='Ativar'){
		deletaFicha($id,'ativo');
	}
	$ficha=mysql_fetch_object(mysql_query("SELECT * FROM cozinha_fichas_tecnicas WHERE vkt_id='$vkt_id' AND id='$id'"));	
}

?>