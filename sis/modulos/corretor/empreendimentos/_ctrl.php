<?
//A��es do Formul�rio

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

//Pega informa��es
if($id>0){
	$r=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formul�rio - Empreendimento",'Exibe','empreendimento',$id);
}

?>