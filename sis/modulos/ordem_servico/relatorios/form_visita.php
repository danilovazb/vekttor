<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
if($vkt_id==1){
	$logo="../../../../fontes/img/vekttor.png";
}else{
	$logo="modulos/vekttor/clientes/img/".$vkt_id.".png";
}
$visita=mysql_fetch_object(mysql_query($t="SELECT *,ag.id as agenda_id FROM os_agenda_visita ag,
									cliente_fornecedor cf
									WHERE cf.id=ag.cliente_id
									AND ag.id=".$_GET['id']." AND vkt_id=$vkt_id"));
?>
<html>
<head>
   	<title>VISITA T&Eacute;CNICA</title>
<style>
*{ margin:0px ; padding:0px;}
body,html{font-family:Tahoma, Geneva, sans-serif;font-size:10pt;}
table tr td {font-family:Tahoma, Geneva, sans-serif; border:1px solid #333;}
#pagina{
	border:1px solid #000;
	width:210mm;
	height:297mm;
	margin-left:auto;
	margin-right:auto;
	background:#FFFFFF;			
}
#os{font-family:Tahoma, Geneva, sans-serif;}
#cabecalho{
	height:75px;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:14px;
}
#cliente{			
	width:880px;
	height:200px;
	font-family: arial, sans-serif;
	font-size:10pt;
	padding:10px;
}
#cliente div p{ padding:2px; margin:2px}
#produtos{
	border-collapse: collapse;
}
		#produtos tr td{ 
			/*border:solid 1px;*/
		}
		#rodape{
			margin-left:-200px;
			margin-top:120px;	
		}
		#rodape1{
			float:left;
			width:70%;
			height:114px;
			border-right:solid 1px;
		
		}
		#rodape2{			
			
			height:113px;
		}
		#rodapea,#rodapeb{
			font-weight:bold;
			
		}
		.titulo_os{ font-family:Arial, Helvetica, sans-serif;font-weight:bold;}
</style>
</head>
<body>
<?
	if(!empty($visita)){
?>

<div id="pagina">
	<div id="cabecalho" style="padding:10px">
		<strong style="text-transform:capitalize;"><?=$empresa[nome]?></strong><br/>
        <strong>CNPJ: </strong><?=$empresa[cnpj]?><br/>
        Endere&ccedil;o: <?=$empresa[endereco]?> <strong>Bairro</strong>:<?=$empresa[bairro]?><br/>
      	<div style="background:url('<?=$empresa[img]?>') no-repeat; background-position:center;float:right; width:100px;height:50px;margin-top:-70px; padding-right:50px;">&nbsp;</div>
        
	</div>
    <div class="titulo_os" style=" margin:0px auto; text-align:center; border-bottom:1px solid #999; padding:3px; width:95%">
     VISITA N&ordm; <?=$visita->agenda_id?>
    </div>
    
    <div id="cliente">
    	<div style="float:left;width:400px;">
    		<? $tecnico=mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario WHERE id=$visita->funcionario_id AND vkt_id='$vkt_id'"));?>
            <p><strong>T&eacute;cnico:</strong> <?=$tecnico->nome?></p>
    		<p><strong>Cliente:</strong> <?=$visita->razao_social?></p>
            <p><strong>Pessoa P/ Contato:</strong> <?=$visita->nome_contato?></p>
    		<p><strong>Tel. Comercial:</strong> <?=$visita->telefone1?> <strong>Tel. Residencial:</strong> <?=$visita->telefone2?></p>
    		<p><strong>Endereco:</strong> <?=$visita->endereco?><br>
    		<p><strong>Cidade:</strong> <?=$visita->cidade?> <strong>Bairro:</strong> <?=$visita->bairro?></p>
        	<p><strong>E-mail:</strong> <?=$visita->email?></p>
        </div>
        
        <div style="float:left;width:250px;">
          <p><strong>Data:</strong> <?=DataUsatoBr($visita->data_visita)?></p>
          <p><strong>Estado</strong> <?=$visita->estado?></p>
          <p><strong>Hora:</strong> <?=substr($visita->hora_inicial,0,5)?></p>
          <p><strong>CEP:</strong> <?=$visita->cep?></p>
        </div>
    </div>
    <div style="position:relative; margin:0 auto; width:800px;">       
		<div style="padding-left:20px;">     	
            <div style="float:left; width:320px; padding:8px; margin:5px;">
                <p style="border-bottom:1px solid #999;">Motivo:</p> 
                <p style="padding:5px;"><?=$visita->motivo_visita?></p>
            </div>
            
            <div style="float:left; width:320px;padding:8px; margin:5px;">
                <p style="border-bottom:1px solid #999;">Observaçoes Gerais:</p>
            </div>
        </div>
     </div>  
    
</div>

<?php
	}
	else{
		echo "AGENDA NAO EXISTE";
	}
?>
</body>
</html>