<?
if($_GET['id']>0){
	$id=$_GET['id'];
	echo $id;
}
if($_GET['deletar']>0){
	mysql_query("DELETE FROM negociacao_cliente WHERE negociacao_id='{$_GET[negociacao_id]}' AND cliente_id='{$_GET[deletar]}' ");
}


if($_POST['action']=='Salvar'){
	adicionaNegociacaoCliente($_POST['negociacao_id'],$_POST['cliente_id']);
}

if($id>0){
	$negociacao=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE id='$id' "));
	$empreendimento=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='{$negociacao->empreendimento_id}'"));
	$empreendimentos_existentes_q=mysql_query($t="SELECT * FROM negociacao_cliente WHERE negociacao_id='$id' ");
	
	echo mysql_error();
}

?>