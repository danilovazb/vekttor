<?php
include("../../../_config.php");
include("../../../_functions_base.php");
global $vkt_id;
function retira_caracteres($texto){
	$acentos = array("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","��","�","�","�","�","�","�","�","�","","�","�","�","","�","�","�","�","EA","�","�","�","�","�");
	$vogais  = array("á","é","í","ó","ú","�","è","ì","ò","ù","ã","õ","â","ê","î","ô","û","Ç","ç","��","�","�","�","�","�","�","�","��","��","�","�?","�©","�§","�‡","�­","�‰","£","³","�¡","��","�","�š","�ƒ","�","��","��","�","��","��","?","ª ");
	
	$texto   = str_replace($vogais,$acentos,$texto);
	
	return $texto; 
	
}
$eleitores = mysql_query($t="SELECT * FROM eleitoral_eleitores WHERE vkt_id='$vkt_id' AND nome !=''");

while($eleitor = mysql_fetch_object($eleitores)){
	echo $eleitor->nome."<br>";
	$nome = retira_caracteres($eleitor->nome);
	$t="UPDATE eleitoral_eleitores SET nome='$nome' WHERE id='$eleitor->id' AND vkt_id='169'";
	echo $t." ".mysql_error()."<br>";
}
?>
