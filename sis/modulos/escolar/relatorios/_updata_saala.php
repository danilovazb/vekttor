<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");

if($_GET[muda_sala]>0&&$_GET[matricula_id]>0){
	mysql_query($t="UPDATE escolar_matriculas SET sala_id='{$_GET[muda_sala]}' WHERE id='{$_GET[matricula_id]}'");
	//echo $t;
	exit();
}

?>
