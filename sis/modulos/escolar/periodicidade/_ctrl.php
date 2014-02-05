<?
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_POST['action']=='Salvar'){
	manipulaPeriodicidade($_POST,$id);
}

if($_POST['action']=='Excluir'){
	excluiPeriodicidade($id);
}

if($id>0){
	$periodicidade=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_periodicidade_avaliacao WHERE id='$id' and vkt_id='$vkt_id'"));
}