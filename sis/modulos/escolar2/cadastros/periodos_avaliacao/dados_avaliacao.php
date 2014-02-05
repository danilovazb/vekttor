<?php
include("../../../../_config.php");

  	$acao = $_POST["dados_avaliacao"];


	switch ($acao) {
    case "add":
        insereAvaliacao($_POST);
        break;
    case "del":
        deleteAvaliacao($_POST);
        break;
    case 2:
        echo "i equals 2";
        break;
	}

	
	function insereAvaliacao($dados){
		global $vkt_id;
		
		$sql = " INSERT INTO escolar2_avaliacao_bimestre SET
		vkt_id      = ".$vkt_id.",
		bimestre_id = ".$dados["dados"]["bimestre"].", 
		ensino_id   = ".$dados["dados"]["ensino"].",
		unidade_id  = ".$dados["dados"]["unidade"].",
		nome        = '".utf8_decode($dados["dados"]["nome_av"])."',
		ordem       = ".$dados["dados"]["ordem"].",
		tipo		= '".$dados["dados"]["tipo"]."',
		texto_tipo_avaliacao = '".utf8_decode($dados["dados"]["texto_tipo_avaliacao"])."' ";
		
		mysql_query($sql);
		$ultimo = mysql_insert_id();
		echo $ultimo;
	}
	
	function deleteAvaliacao($dados){
		//print_r($dados);
		global $vkt_id;
		
		$sql = mysql_query(" DELETE FROM escolar2_avaliacao_bimestre WHERE vkt_id = '$vkt_id' AND id = '".$dados["id"]."' "); 
	}
	
?>