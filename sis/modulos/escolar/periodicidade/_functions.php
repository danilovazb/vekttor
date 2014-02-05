<?
function manipulaPeriodicidade($dados,$id){
	
	global $vkt_id;
	
	if($id==''){ $sql_in = " INSERT INTO "; $sql_fim="";}
	if($id>0){ $sql_in = " UPDATE "; $sql_fim = " WHERE id='$id' AND vkt_id='$vkt_id'";}
	
	mysql_query($t="$sql_in escolar_periodicidade_avaliacao SET 
	nome='".$dados['nome']."',
	recuperacao='".$dados['recuperacao']."',
	peso='".moedaBrToUsa($dados['peso'])."',
	vkt_id='$vkt_id'
	$sql_fim
	");
	
}
function excluiPeriodicidade($id){
	global $vkt_id;
	
	$avaliacao = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_avaliacao WHERE periodicidade_id=$id AND vkt_id='$vkt_id'"));
	
	if(empty($avaliacao)){
		mysql_query($t="DELETE FROM escolar_periodicidade_avaliacao WHERE id='$id'");
	}else{
		alert("Há avaliaçoes vinculadas a esta matéria");
	}
	//echo $t;
}
?>