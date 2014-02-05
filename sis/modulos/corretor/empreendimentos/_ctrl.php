<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

//Pega informações
if($id>0){
	$r=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Empreendimento",'Exibe','empreendimento',$id);
}

?>