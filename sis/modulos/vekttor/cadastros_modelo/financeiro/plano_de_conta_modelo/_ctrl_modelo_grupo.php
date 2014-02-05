<?
if($_POST['id_grupo'])$id_grupo=$_POST['id_grupo'];
if($_GET['id_grupo'])$id_grupo=$_GET['id_grupo'];


if($_POST['action']=="Salvar"&&$_POST['eh_grupo']=='1'){
	manipulaModeloGrupoPlanoConta($_POST);
}

if($_POST['action']=="Excluir"&&$_POST['eh_grupo']=='1'){
	excluiModeloGrupoPlanoConta($_POST);
}

if($id_grupo>0){
	$modelo_grupo=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo_modelo_grupo WHERE id='$id_grupo' ORDER BY id DESC LIMIT 1"));
}
