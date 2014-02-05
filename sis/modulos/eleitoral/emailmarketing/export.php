email,nome
<?php
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

   $arquivo = DIR_DOWNLOAD.$arquivo; // Aqui a gente só junta o diretório com o nome do arquivo
	$emails = mysql_query($t="SELECT distinct(email),id FROM eleitoral_eleitores WHERE vkt_id='$vkt_id'  AND recebe_email='sim' AND email not like '%facebook%' AND  email LIKE '%@%.%'  limit ".($_GET[i]*1000).", 2000 ");
		while($email = mysql_fetch_object($emails)){
			if(strlen($email->email)>3){
			$arq[]= utf8_encode(trim($email->email).", \n");
			}
		}
		
	$file = "export_".$_GET[i]."_.csv";
	echo $file;
	@unlink("$file");
	$handle = fopen($file, 'a');
	fwrite($handle,implode('',$arq));
	fclose($handle);

   $arquivo = $file; // Aqui a gente só junta o diretório com o nome do arquivo
   header('Content-type: octet/stream');
   header('Content-disposition: attachment; filename="'.basename($arquivo).'";');
   header('Content-Length: '.filesize($arquivo));
   readfile($arquivo);
   
   
?>