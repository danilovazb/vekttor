<?php
if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_POST['action']=='Salvar'){
	if(empty($id)){
	$aluno=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_alunos_reprovado WHERE aluno_id='".$_POST['busca_id_aluno']."'"));
		echo $t;
	}	
	if(empty($aluno)){
		manipulaReprovado($_POST,$vkt_id,$id);
	}else{
		alert("O aluno já está reprovado");
	}
}

if($_POST['action']=='Excluir'){
	excluiInadimplente($id);
}

if($id>0){
	$reprovado=mysql_fetch_object(mysql_query($t="SELECT a.*,reprovado.* FROM escolar_alunos a, escolar_alunos_reprovado reprovado 
	WHERE a.id=reprovado.aluno_id AND reprovado.vkt_id='$vkt_id' AND a.id='$id'"));
	//echo $t;
}
if($_POST['action'] == 'Importar'){
	Importar();
}