<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	$receituario_id = $_GET['receituario_id'];
	
	$receituario = mysql_fetch_object(mysql_query("SELECT * FROM odontologo_receituario WHERE id='$receituario_id'"));
	$cliente     = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$receituario->cliente_fornecedor_id'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Receituário - Odontólogo</title>
<style>
	#receituario{
		border:#000 solid 1px;
		width:500px;
		height:600px;
	}
	
		
	#titulo_receituario{
		text-decoration:underline;
		font-family:Arial, Helvetica, sans-serif;
		font-size:20px;
		margin-top:30%;
		text-align:center;
	}
	
	#texto_receituario{
		margin-top:5%;
		padding:0 5% 5% 5%;
		height:170px;  
	}
	#cliente{
		font-family:Arial, Helvetica, sans-serif;
		font-size:10px;
		margin-top:25%;
	}
</style>
</head>

<body>
<div id="receituario">
	
    <div id="titulo_receituario">
    	RECEITUÁRIO
    </div>
    <div id="texto_receituario">
    	<?php
			echo $receituario->txt;
		?>
    </div>
    <div id="cliente">
    	<strong>Cliente:</strong>  <?=$cliente->razao_social?>
        <strong>Atendimento:</strong> <?=$receituario->odontologo_atendimento_id?> 
    </div>
</div>
</body>
</html>