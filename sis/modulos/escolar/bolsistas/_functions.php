<?
function manipulaBolsista($dados,$vkt_id,$id){
	if($id==''){ $sql_in = " INSERT INTO "; $sql_fim="";}
	if($id>0){ $sql_in = " UPDATE "; $sql_fim = " WHERE aluno_id='$id'";}
	
	mysql_query($t="$sql_in escolar_alunos_bolsistas SET 
	codigo_totvs='".$dados['cod_totvs']."',
	aluno_id='".$dados['busca_id_aluno']."',
	vkt_id='$vkt_id'
	$sql_fim
	");
	//echo $t."<br>";
	//echo mysql_error();
}
function excluiBolsista($id){
	$t=mysql_query("DELETE FROM  escolar_alunos_bolsistas WHERE aluno_id='$id'");
	//echo $t;
}
?>