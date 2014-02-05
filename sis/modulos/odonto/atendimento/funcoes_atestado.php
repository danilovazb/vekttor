<?php
include("../../../_config.php");
include("../../../_functions_base.php");
	
$acao  = $_POST['acao'];
$cid               = $_POST['cid'];
$data_atestado     = $_POST['data_atestado'];
$hora_inicio       = $_POST['hora_inicio'];
$hora_fim          = $_POST['hora_fim'];
$dias_afastamento  = $_POST['dias_afastamento'];
$atendimento_id    = $_POST['atendimento_id'];
$cliente_id        = $_POST['cliente_id'];
//echo $data_atestado;

if($acao=='add'){	
	mysql_query($t="INSERT INTO odontologo_atestados SET 
	vkt_id                     = '$vkt_id',
	cliente_fornecedor_id      = '$cliente_id',
	odontologo_atendimento_id  = '$atendimento_id',
	cid                        = '$cid',
	data                       = '".DataBrToUsa($data_atestado)."',
	hora_inicio                = '$hora_inicio',
	hora_fim                   = '$hora_fim',
	dias_afastado              = '$dias_afastamento'
	");
	echo mysql_insert_id();
}else{
	$id = $_POST['id'];
	mysql_query($t="DELETE FROM odontologo_atestados WHERE id=$id");
}
?>