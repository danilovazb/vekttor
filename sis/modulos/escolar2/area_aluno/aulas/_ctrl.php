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

if( !empty($_GET["aula_id"]) ){
	$aula_info = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_aula WHERE id = '".trim($_GET["aula_id"])."' "));
	$professor = mysql_fetch_object(mysql_query( " 
	SELECT * FROM escolar2_professor_has_turma AS p_turma 
	
	JOIN escolar2_professores As professor
		ON p_turma.professor_id = professor.id
		
	JOIN rh_funcionario As func
		ON professor.funcionario_id = func.id
	
	WHERE p_turma.id = '$aula_info->professor_as_turma_id' " ));
}


if($id>0){$cargo=mysql_fetch_object(mysql_query("SELECT * FROM cargo_salario WHERE id='$id' AND vkt_id='$vkt_id' LIMIT 1 "));}