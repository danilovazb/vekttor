<?php
	include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
$id=$_GET['id'];
$solicitacao_hora_extra = mysql_fetch_object(mysql_query($t="
	SELECT *, she.id as she_id FROM 
		rh_solicitacao_hora_extra she,
		cliente_fornecedor cf,
		rh_funcionario rh_f 
		WHERE 
		she.id='$id' AND
		she.vkt_id='$vkt_id' AND
		she.empresa_id = cf.id AND
		she.funcionario_id=rh_f.id
		"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Autorização de Hora Extra</title>
<style>
	#pagina{
		width:400px;
		height:400px;
		border:solid 1px #000000;
	}
</style>
</head>

<body>
<div id="pagina">
	<h3 style="text-align:center">AUTORIZAÇÃO DE HORA EXTRA</h3>

	<div id="empresa">
    	<strong>Empresa :</strong> <?=$solicitacao_hora_extra->nome_fantasia?>
	</div>
    
    
    <div id="funcionario" style="margin-top:45px;">
    	<strong>Funcionario :</strong> <?=$solicitacao_hora_extra->nome?>
	</div>
    
    <div id="data" style="margin-top:45px;">
    	<strong>Data:</strong> <?=DataUsaToBr($solicitacao_hora_extra->data)?>
	</div>
    
    <div id="hinicio" style="margin-top:45px;">
    	<strong>Início:</strong> <?=substr($solicitacao_hora_extra->hora_inicio,0,5)?>
	</div>
    
    <div id="hfim" style="margin-top:45px;">
    	<strong>Fim:</strong> <?=substr($solicitacao_hora_extra->hora_fim,0,5)?>
	</div>
    
    <div id="obs" style="margin-top:45px;">
    	<strong>Observação:</strong> <?=$solicitacao_hora_extra->observacao?>
	</div>
    
</div>
</body>
</html>