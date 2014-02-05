<?
function insereAula($dados){
	global $vkt_id;
	mysql_query($a="INSERT INTO escolar2_aulas_online SET 
	vkt_id='".$vkt_id."',
	modulo_id='".$dados['modulo_id']."',
	materia_id='".$dados['materia_id']."',
	data_cadastrado=NOW(),
	data_referente='".dataBrTousa($dados['data_referente'])."',
	titulo='".$dados['titulo']."',
	conteudo='".$dados['conteudo']."'
	");
}

function alteraAula($aula_id,$dados){
	mysql_query("UPDATE escolar2_aulas_online SET
	modulo_id='".$dados['modulo_id']."',
	materia_id='".$dados['materia_id']."',
	data_referente='".dataBrTousa($dados['data_referente'])."',
	titulo='".$dados['titulo']."',
	conteudo='".$dados['conteudo']."'
	WHERE id='$aula_id'");
}

function deletaAula($aula_id){
	mysql_query("DELETE FROM escolar_aulas_online WHERE id='$aula_id'");
}