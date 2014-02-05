<?php
if(!empty($_GET['matricula'])){
	$fim="WHERE id='".$_GET['matricula']."' AND vkt_id='$vkt_id'";
}else{
	$fim="WHERE aluno_id=$aluno_id AND vkt_id=$vkt_id ORDER BY id DESC";
}
if($_SESSION['aluno']->id>0){
	$matricula=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_matriculas $fim"));
}
$aluno=selecionaAluno($aluno_id,$matricula->id);
$mat=selecionaMatriculas($_SESSION['aluno']->id);
?>