<?php
include("../../../_config.php");
include("../../../_functions_base.php");
global $vkt_id;
function retira_caracteres($texto){
	$acentos = array("á","é","í","ó","ú","à","è","ì","ò","ù","ã","õ","â","ê","î","ô","û","Ç","ç","ã","ç","õ","ê","ã","ã","â","ô","òó","é","ä","ç","é","ç","ç","í","é","","ç","á","á","","ú","ã","õ","ô","EA","â","ç","â","ç","á");
	$vogais  = array("Ã¡","Ã©","Ã­","Ã³","Ãº","Ã","Ã¨","Ã¬","Ã²","Ã¹","Ã£","Ãµ","Ã¢","Ãª","Ã®","Ã´","Ã»","Ã‡","Ã§","àƒ","à§","àµ","àª","à£","à£","à¢","à´","à²ó","à‰","à¤","Ã?","ãÂ©","ãÂ§","ãâ€¡","ãÂ­","ãâ€°","Â£","Â³","ãÂ¡","ãÂ","º","ãÅ¡","ãÆ’","áµ","ãâ€","ãÅ","á¢","à‡","à‚","?","Âª ");
	
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
