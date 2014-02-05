<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
	if(!empty($_GET['vkt_id'])){
		$vkt_id = $_GET['vkt_id'];
	}
function mes($mes){
	switch($mes){
		case 1: echo "Janeiro";break;
		case 2: echo "Fevereiro";break;
		case 3: echo "Março";break;
		case 4: echo "Abril";break;
		case 5: echo "Maio";break;
		case 6: echo "Junho";break;
		case 7: echo "Julho";break;
		case 8: echo "Agosto";break;
		case 9: echo "Setembro";break;
		case 10: echo "Outubro";break;
		case 11: echo "Novembro";break;
		case 12: echo "Dezembro";break;
		
	}
} /*fim da funcao*/
if($vkt_id == '1'){
	$logo="http://vkt.srv.br/~nv/fontes/img/vekttor.png";
}else{
	$logo="http://vkt.srv.br/~nv/sis/modulos/vekttor/clientes/img/".$vkt_id.".png";
}
//alert($logo);
$email=mysql_fetch_object(mysql_query($t="SELECT *
															
											FROM 
												emailmarketing 
											WHERE
												id='".$_GET['id']."'"));

												
$cliente_vekttor = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='$vkt_id'"));
?>
<html>
<head>
   	<title>Dentista</title>
    <style>
	
	body{ font-family:Verdana, Geneva, sans-serif; font-size: 12px;}
	table tr td {font-family:Tahoma, Geneva, sans-serif; border:1px solid #333;}
	#pagina{
		/*border:1px solid #000;
		width:100%;
		*/			
	}
	/*#cabecalho{
		width:100%;
	}
	#cab_direita{
		width:20%;
		float:left;
	}*/
	#cab_esquerda{
		width:78%;
		float:right;
	}
	#cliente{
		margin:70px 0 50px 0;
		font-weight:bolder;
		margin-left:30px;
	}
	#servicos{
		height:750px;
		
	}
	#produtos{
			border-collapse:collapse;
			border-style:solid 1px;
			padding-left:13px;
			
	}
	#servicos table tr td{
		border-collapse:collapse;
		border-style:solid 1px;
		
	}

    </style>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
</head>
<body>
<div id="pagina" style="width:100%">
		
   <div id="cabecalho" style="width:100%;">
		
       <div id="cab_direita" style="float:left;width:10%;">
       <img src="<?=$logo?>"/> 
       </div>
       <div id="cab_esquerda" style="float:right;width:89%;text-align:left;">
       Manaus, <?=date("d")?> de <?=mes(date("m"))?> de <?=date("Y")?><br>
       <strong style="text-transform:capitalize;"><?=$cliente_vekttor->nome?></strong><br>
		CNPJ: <?=$cliente_vekttor->cnpj?><br>
		</div>
    </div>
   
  <div style="clear:both"></div>
  
  <div id="cliente" style="width:100%;margin:50px 0 50px 0;">
  	<?php echo $email->html;?>
  </div>
  <div style="clear:both"></div>
    <div>
    Endereço: <?=$cliente_vekttor->endereco?>, <?=$cliente_vekttor->bairro?>
    <div style="clear:both"></div>
	<?=$cliente_vekttor->cidade?> - <?=$cliente_vekttor->estado?>
    <div style="clear:both"></div>
    CEP: <?=$cliente_vekttor->cep?>
    </div>
    
</body>
</html>