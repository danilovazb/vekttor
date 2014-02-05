<?php
	// configuraçao inicial do sistema
	include("../../../_config.php");
	// funções base do sistema
	include("../../../_functions_base.php");
	include("_functions.php");
	
	global $vkt_id;
	
	if(!empty($_GET['de'])&&!empty($_GET['ate'])){
		$filtro.="AND data_hora BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
	}
	if(!empty($_GET['quantidade'])){
		$filtro.=" LIMIT ".$_GET['quantidade']."";
	}
	
	$mensagens = mysql_query("SELECT * FROM eleitoral_sms_importados WHERE vkt_id = '$vkt_id'");
	
	while($mensagem=mysql_fetch_object($mensagens)){
		$telefone = substr($mensagem->telefone,3);
		$telefone = "(".substr($telefone,0,2).")".substr($telefone,2,4)."-".substr($telefone,6,4).","; 
		//$texto_mensagem = str_replace("\n","",$mensagem->mensagem);
		//$texto_mensagem = str_replace(";","",$texto_mensagem);
		//$tam_mensagem = strlen($texto_mensagem);
		//$texto_mensagem = substr($texto_mensagem,0,$tam_mensagem-1);
	 	$info[] = strtoupper(trataTxt("$telefone\n"));	
		
	 }
	 
	$infos = implode("",$info);
	
	$file = "sms_importado_exportacao.csv";
	@unlink("$file");
	$handle = fopen($file, 'a');
	fwrite($handle,$infos);
	fclose($handle);

	$i =date("Ymdhis");
	echo "<script>location='$file?$i'</script>";
	exit();					
?>
