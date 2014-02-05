<?
	include("../../../_config.php");
	include("../../../_functions_base.php");
	
	mysql_query($t="UPDATE escolar_sala_materia_professor SET professor_id=0 WHERE id='".$_GET['id']."' AND	vkt_id='$vkt_id'");
	
	//mysql_query($t="DELETE FROM escolar_sala_materia_professor WHERE id='".$_GET['id']."' AND	vkt_id='$vkt_id'");
	echo $t;
?>