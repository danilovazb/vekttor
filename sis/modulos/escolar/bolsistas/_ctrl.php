<?
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_POST['action']=='Salvar'){
	if(empty($id)){
	$aluno=mysql_fetch_object(mysql_query("SELECT * FROM escolar_alunos_bolsistas WHERE aluno_id='".$_POST['busca_id_aluno']."'"));
	}	
	if(empty($aluno)){
		manipulaBolsista($_POST,$vkt_id,$id);
	}else{
		alert("O aluno já é um bolsista");
	}
}

if($_POST['action']=='Excluir'){
	excluiBolsista($id);
}

if($id>0){
	$bolsista=mysql_fetch_object(mysql_query($t="SELECT a.*,ab.* FROM escolar_alunos a, escolar_alunos_bolsistas ab WHERE a.id='$id' and a.id=ab.aluno_id LIMIT 1"));
	//echo $t;
}