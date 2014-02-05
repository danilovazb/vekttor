<?
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_POST['action']=='Salvar'&&empty($id)){
	CadastraSala($_POST,$vkt_id,$id);
}

if($_POST['action']=='Salvar'&&$id>0){
	AlteraSala($_POST,$id);
}

if($_POST['action']=='Excluir'){
	ExcluirSala($id);
}

if($id>0){
	$sala=mysql_fetch_object(mysql_query("SELECT * FROM escolar_salas WHERE id='$id'"));
}

if($_POST['actionalu']=='Salvar'){
	mysql_query($t="UPDATE escolar_matriculas SET sala_id='".$_POST['sala']."' WHERE id='".$_POST['mat_id']."'");
	//echo $t;
}

$horarios=mysql_query($t="
		SELECT h.id as id,h.horario_inicio,h.horario_fim, 
		m.nome as nome, 
		ec.nome as curso, 
        ee.nome as escola,
		ep.nome as periodo
		FROM 
		escolar_horarios h, 
		escolar_modulos m, 
		escolar_cursos ec, 
		escolar_escolas ee, 
		escolar_periodos ep 
		WHERE h.modulo_id=m.id 
		and h.curso_id=ec.id 
		and h.escola_id=ee.id 
		and h.periodo_id=ep.id
 ");
?>