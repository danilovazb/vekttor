<?
if($_GET['aula_id']>0){$aula_id=$_GET['aula_id'];}
if($_POST['aula_id']>0){$aula_id=$_POST['aula_id'];}
if($_POST['modulo_id']>0){$modulo_id=$_POST['modulo_id'];}
if($_GET['modulo_id']>0){$modulo_id=$_GET['modulo_id'];}
if($_POST['materia_id']>0){$materia_id=$_POST['materia_id'];}
if($_GET['materia_id']>0){$materia_id=$_GET['materia_id'];}
if($_POST['arquivo_id']>0){$arquivo_id=$_POST['arquivo_id'];}

$id_progresso = md5(microtime() . rand());

if($_POST['action'] == 'Salvar'){
	if($aula_id > 0){
		insere_arquivo($_POST);
	}else if($arquivo_id > 0&&$aula_id>0){
		$aula=altera_arquivo($aula_id);
	}
}
if($_POST['action']== 'Excluir'){
	  deletar_aula($_POST['arquivo_id']);
}
	

if($aula_id>0){
	$arquivo=mysql_fetch_object(mysql_query("SELECT * FROM escolar_aulas_online WHERE id='$aula_id' AND vkt_id='$vkt_id'"));
	$modulo_id=$arquivo->modulo_id;
	$materia_id=$arquivo->materia_id;
}