<?
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_POST['action']=='Salvar'){
	ManipulaSalaProfessor($_POST,$vkt_id);
}

if($id>0){
	
	$sala=mysql_fetch_object(mysql_query(
	$t="SELECT s.*,s.id as sala,e.nome as escola,c.nome as curso, h.id as horario_id, h.nome as horario FROM escolar_salas s
	 INNER JOIN escolar_cursos c ON s.curso_id=c.id
	 INNER JOIN escolar_escolas e ON s.escola_id=e.id
	 INNER JOIN escolar_horarios h ON s.horario_id=h.id
	 WHERE s.id='$id'"));

}
?>