<?php
require("../../../_config.php");
include("../../../_functions_base.php");

global $vkt_id;

if(!empty($_GET['data_ini'])&&!empty($_GET['data_fim'])){
					$data_inicio = explode("/",$_GET['data_ini']);
					$data_fim    = explode("/",$_GET['data_fim']);
					$dia_inicio  = $data_inicio[0];
					$mes_inicio  = $data_inicio[1];
					$dia_fim     = $data_fim[0];
					$mes_fim     = $data_fim[1];
					
					$filtro = "AND month(data_nascimento) BETWEEN '$mes_inicio' AND '$mes_fim' ORDER BY month(data_nascimento),day(data_nascimento)";
				}else{
					$dia = date('d');
					$mes = date('m');
					$filtro = " AND day(data_nascimento) = '$dia' AND month(data_nascimento) = '$mes'";
			}

$sql = mysql_query($t="SELECT telefone1 FROM  eleitoral_eleitores WHERE vkt_id = '$vkt_id' $filtro");

$info[] = strtoupper("Telefone\n");
while($r=mysql_fetch_object($sql)){
	if(!empty($r->telefone1)){
		$telefone_original = $r->telefone1;
	}else{
		$telefone_original = $r->telefone2;
	}
	$info[] = strtoupper("$telefone_original\n");
}

$infos = implode("",$info);
$infos = strtoupper($infos);
	$file = "aniversariantes.csv";
	@unlink("$file");
	$handle = fopen($file, 'a');
	fwrite($handle,$infos);
	fclose($handle);

	$i =date("Ymdhis");
	
	header('Content-type: octet/stream');
    header('Content-disposition: attachment; filename="'.basename($file).'";');
    header('Content-Length: '.filesize($file));
    readfile($file);
	
	//echo "<script>location='$file?$i'";
	exit();
?>