<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

//Pega informações

if($_POST['action']=='Salvar'&&empty($id)){
	
	$cadastra=salvaArquivo($_POST['tipo'],$_FILES['arquivo'],$_POST['obs']);
}

if($_GET['excluir']>0){
	
	$cadastra=excluiArquivo($_GET['excluir']);
	
}

if($_POST['action']=='Excluir'&&isset($id)){
	
	$cadastra=excluiArquivo($id);
	
}

if($id>0){
	$r=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor_arquivo WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Cliente Fornecedor | Arquivo",'Exibe','interesse',$id);
}
?>