<?php
include("_ctrl.php");
$caminho = $tela->caminho;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Eleitoral-Etiquetas</title>
</head>
<style>
body{
	margin:0;
}
.etiqueta{
	height:25.5mm;
	overflow:hidden;
	float:left;
	font-family:Arial, Helvetica, sans-serif;
	font-size:7pt;
	/*border:solid 1px #000000;*/
	margin-right:6mm;
}
.c1{	width:57mm;}
.c2{	width:60mm;margin-left:-13px;}
.c3{	width:60mm; margin-right:0;margin-left:18px;}

.c1 i{ font-style:normal; padding:9px 0 0 0px; display:block}
.c2 i,.c3 i{ font-style:normal; padding:9px 0 0 17px; display:block}


.quebra_linha{
	clear:both;
}

.quebra_pagina{
	page-break-before:always;
	clear:both;

}
.margem_superior{
}
</style>
<body>
	<?
		$i=1;
		$cont_paginas=0;
		$max_paginas = $_GET['max_paginas'];
		while($eleitor = mysql_fetch_object($eleitores)){
				$c++;
				$pp++;
	?><div class="etiqueta c<?=$c?>"><i><?=$eleitor->nome?><br/><?=$eleitor->endereco." - ".$eleitor->bairro." ".$eleitor->cep." ".$eleitor->cidade."/".$eleitor->estado?></i></div><?
			if($i%3==0 && $i>1){
				$c=0;
				if($pp==30){
					$pp=0;
				}else{
					echo "<div class='quebra_linha'></div>";
				}
			}
			if($i%30==0 && $i>1){
				echo "\n<div class='quebra_pagina'></div>";
				$cont_paginas++;
				
			}
			if($cont_paginas==$max_paginas){
				break;
			}
			$i++;
		}	
	?>
</div>
</body>
</html>