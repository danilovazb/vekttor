<?
if($_GET['modulo_id']>0){$modulo_id=$_GET['modulo_id'];}
if($_POST['modulo_id']>0){$modulo_id=$_POST['modulo_id'];}
if($_GET['materia_id']>0){$materia_id=$_GET['materia_id'];}
if($_POST['materia_id']>0){$materia_id=$_POST['materia_id'];}
if($_GET['aula_id']>0){$aula_id=$_GET['aula_id'];}
if($_POST['aula_id']>0){$aula_id=$_POST['aula_id'];}
if($_POST['action']=='Salvar'){
	if($aula_id>0){
		alteraAula($aula_id,$_POST);
	}else{
		insereAula($_POST);
	}
}
if($_POST['action']=='Excluir'){
	deletaAula($aula_id);
}

if($materia_id>0&&$modulo_id>0){
	$materia=mysql_fetch_object(mysql_query("SELECT * FROM escolar_materias WHERE vkt_id='$vkt_id' AND id='$materia_id' AND modulo_id='$modulo_id'"));
}
if($aula_id>0){
	$aula=mysql_fetch_object(mysql_query("SELECT * FROM escolar_aulas_online WHERE vkt_id='$vkt_id' AND id='$aula_id'"));
	$modulo_id=$aula->modulo_id;
	$materia_id=$aula->materia_id;
}