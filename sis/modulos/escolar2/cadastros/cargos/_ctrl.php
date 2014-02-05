<?
if($_GET['id']>0){$id=$_GET['id'];}
if($_POST['id']>0){$id=$_POST['id'];}

if($_POST['action']=='Salvar'){
	if($id>0){
		alteraCargo($_POST);	
	}else{
		insereCargo($_POST);
	}
}

if($_POST['action']=='Excluir'&&$id>0){
	deletaCargo($id);
}


if($id>0){$cargo=mysql_fetch_object(mysql_query("SELECT * FROM cargo_salario WHERE id='$id' AND vkt_id='$vkt_id' LIMIT 1 "));}