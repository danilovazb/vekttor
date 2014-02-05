<?php

if($_POST[acao]=='Salvar'){
	manipulaPergunta($_POST,$vkt_id);
}
if($_GET['id']>0){
	$mensagem=mysql_fetch_object(mysql_query($t="SELECT * FROM  escolar_mensagens_privadas WHERE id='".$_GET['id']."' AND vkt_id='$vkt_id'"));
	$professor=mysql_fetch_object(mysql_query($t="SELECT * FROM  cliente_fornecedor WHERE id='".$mensagem->professor_id."' AND cliente_vekttor_id='$vkt_id'"));
	$aluno=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_alunos WHERE id='".$mensagem->aluno_id."' AND vkt_id='$vkt_id'"));
	//echo $t."<br>";
	$aula=mysql_fetch_object(mysql_query("SELECT * FROM escolar_aula WHERE id='".$mensagem->aula_id."' AND vkt_id='$vkt_id'"));
	$materia=mysql_fetch_object(mysql_query("SELECT * FROM escolar_materias WHERE id='".$mensagem->materia_id."' AND vkt_id='$vkt_id'"));
	
	if($mensagem->status==2){
		atualizaStatus($mensagem->id,$vkt_id);
	}
}
?>