<?php
	include("../../../_config.php");
	global $vkt_id;
	$funcionario_id = $_GET['f'];
	
	$documentos_funcionarios = mysql_query($t="SELECT * FROM rh_funcionarios_documentos WHERE funcionario_id='$funcionario_id' AND vkt_id='$vkt_id'");
	//echo $t;
	while($documento = mysql_fetch_object($documentos_funcionarios)){
		$imagem = "../funcionarios/documentos/$documento->id.$documento->extensao";
		$dimensoes = getimagesize($imagem);
		$altura_imagem = $dimensoes[1];
		$nome = $documento->descricao;
		if($altura_imagem>400){
			$altura_imagem='400';
		}
		
		echo "
		<h3>$nome</h3>
		<img src='$imagem' height='$altura_imagem' style='margin-bottom:25px;'><div style='clear:both'></div>
		";
	}
	
?>
