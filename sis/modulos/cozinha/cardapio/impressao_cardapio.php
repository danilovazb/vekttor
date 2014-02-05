<?
require '../../../_config.php';
include '../../../_functions_base.php';

function exibe_fichas($contrato_id,$refeicao,$data_oficial,$data_ini=NULL,$data_fim=NULL){
global $vkt_id;
if($data_ini!=NULL&&$data_fim!=NULL){
	
	$data_oficial_s=strtotime($data_oficial);
	$data_ini_s=strtotime($data_ini);
	$data_fim_s=strtotime($data_fim);
	if($data_ini_s <= $data_oficial_s && $data_fim_s >= $data_oficial_s){
		$fichas_q = mysql_query($t="
				SELECT f.nome_cliente as ficha, c.pessoas as pessoas,g.nome as grupo_cardapio, g.id as grupo_id
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g  
				WHERE 
				contrato_id='$contrato_id' 
				AND f.grupo_cardapio_id=g.id
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='$refeicao'
				AND f.exibir_cliente='1'

				ORDER BY g.nome,f.nome ASC");
				//echo $t;
				$i=0;
				$grupo_anterior='';
				while($ficha=mysql_fetch_object($fichas_q)){
					$i++;
					$grupo_id=$ficha->grupo_id;
					if($grupo_id!=$grupo_anterior){
						echo "<span style='display:block;font-weight:bold'>$ficha->grupo_cardapio</span>";
						$grupo_anterior=$grupo_id;
					}
					
					$nome_ficha = str_replace("[T]",'',$ficha->ficha);
					$nome_ficha = str_replace("*",'',$nome_ficha);
					echo "<div >$nome_ficha</div>";
				}
				if($i==0){
					echo "&nbsp;";	
				}	
	}else{
		echo "&nbsp;";
	}
	}				
}

function dd($d){
	if($d<10){
		return '0'.$d;	
	}else{
		return $d;
	}
}


//receber dados
$contrato_id = $_GET['contrato_id'];
$contrato = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_contratos WHERE id='$contrato_id'"));
$almoxarifado = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id='$contrato->unidade_id'"));
$mes = mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[filtro_inicio]}','%m')"),0,0);
$ano= mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[filtro_inicio]}','%Y')"),0,0);
 

$ultimo_dia_mes_anterior_d = mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_SUB('$ano-$mes-01',interval 1 day),'%d')"),0,0);

$anterior_mes = mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_SUB('$ano-$mes-01',interval 1 day),'%m')"),0,0);

$ultimo_dia_mes_anterior = mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_SUB('$ano-$mes-01',interval 1 day),'%w')"),0,0);


$ultimo_dia_mes_atual = mysql_result(mysql_query("SELECT DATE_FORMAT(LAST_DAY('$ano-$mes-01'),'%d')"),0,0);

$proximo_mes = mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$ano-$mes-01', interval 1 month),'%m')"),0,0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Card&aacute;pio</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

table#linha td{border-right:0; margin:0; padding:0; padding-left:2px;}
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;
}
pre{ display:none}
.linha td{ border-left:1px solid #000;border-bottom:1px solid #CCC;}
.seia td{ border-bottom:4px solid #000;}
.linha{border-right:1px solid #000; border-top:2px solid #000}

.dif td{ background:#F4F4F4;}
body {
	margin-left: 0px;
}
</style>
</head>

<body>
<!--<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />-->
<style type="text/css">

</style>


 
  <div style="clear:both"></div>
<table width="1100" cellpadding="0" cellspacing="0" class='linha' id='linha'>
<tr>
	<td colspan="3" align="center">
    &nbsp;
    <?php
		if(file_exists("../../vekttor/clientes/img/".$vkt_id.".png")){
		echo "<img src='../../vekttor/clientes/img/".$vkt_id.".png' height='70'/>";
	}
	?>
    </td>
    <td colspan="3" align="center">
  <div  style="padding:10px 0px 10px 0px "><strong>Unidade: </strong><?=$almoxarifado->nome?>
  </div>
  
  <H1 style="margin:0;">Card&aacute;pio</H1>
    </td>
    <td colspan="2" align="center" >
    &nbsp;
	<?php
     	    
   if(file_exists("../../administrativo/clientes/fotos_clientes/".$contrato->cliente_id.".png")){
    	//echo "<img src='../../vekttor/clientes/img/".$vkt_id.".png' height='70'/>";
		echo "<img src='../../administrativo/clientes/fotos_clientes/".$contrato->cliente_id.".png'/>";
	}
	?>
    </td>
</tr>
</table>
<table width="1100" cellpadding="0" cellspacing="0" class='linha' id='linha'>
<?
	$inicio_semana = 1+($i*7);
	$fim_semana = 7+($i*7);
	//primeiro dia da semana
	if($ultimo_dia_mes_anterior>=$inicio_semana){
		$inicio_semana=$ultimo_dia_mes_anterior_d-$ultimo_dia_mes_anterior+1;
		$mes_info_inicio_semana=$anterior_mes;
	}else{
		$inicio_semana = dd(1+($i*7)-$ultimo_dia_mes_anterior);
		$mes_info_inicio_semana=$mes;
	}
	if($inicio_semana>$ultimo_dia_mes_atual){
		$inicio_semana=dd($inicio_semana-$ultimo_dia_mes_atual);
		$mes_info_inicio_semana=$proximo_mes;
	}
	//ultimo dia da semana
	if($ultimo_dia_mes_anterior>=$fim_semana){
		$fim_semana=$ultimo_dia_mes_anterior_d-$ultimo_dia_mes_anterior+7;
		$mes_info_fim_semana=$anterior_mes;
	}else{
		$fim_semana = dd(7+($i*7)-$ultimo_dia_mes_anterior);
		$mes_info_fim_semana=$mes;
	}
	if($fim_semana>$ultimo_dia_mes_atual){
		$fim_semana=dd($fim_semana-$ultimo_dia_mes_atual);
		$mes_info_fim_semana=$proximo_mes;
	}
	$inicio_semana=mysql_result(mysql_query("SELECT DATE_FORMAT('$ano-$mes_info_inicio_semana-$inicio_semana','%v')"),0,0);
	$fim_semana=mysql_result(mysql_query("SELECT DATE_FORMAT('$ano-$mes_info_fim_semana-$fim_semana','%v')"),0,0);
	$filtro_inicio_s=mysql_result(mysql_query("SELECT DATE_FORMAT('".$_GET['filtro_inicio']."','%v')"),0,0);
	$filtro_fim_s=mysql_result(mysql_query("SELECT DATE_FORMAT('".$_GET['filtro_fim']."','%v')"),0,0);
	$qtd_semanas=$filtro_fim_s-$filtro_inicio_s+1;
	
for($i=0;$i<$qtd_semanas;$i++){

	
?>
  <tr>
   	<td>&nbsp;</td>
      <?  
		$dia_da_semana=mysql_result(mysql_query($o="SELECT DATE_FORMAT('".$_GET['filtro_inicio']."','%w')"),0,0);
		for($c=0;$c<7;$c++){
		if($dia_da_semana==0){$dia_da_semana=7;}
		$d=mysql_result(mysql_query($a="SELECT DATE_ADD(DATE_SUB('".$_GET['filtro_inicio']."', INTERVAL ".($dia_da_semana-1)." DAY), INTERVAL ".(7*$i+$c)." DAY)"),0,0);
		$dia_escrito=mysql_result(mysql_query($o="SELECT DATE_FORMAT('$d','%w')"),0,0);
		$dia_formatado=mysql_result(mysql_query($o="SELECT DATE_FORMAT('$d','%d/%m/%Y')"),0,0);
		$dia_s=strtotime("$ano-$mes_info-$d");
		$dia_semana_ini=strtotime($_GET['filtro_inicio']);
		$dia_semana_fim=strtotime($_GET['filtro_fim']);
	?>
      <td width="140"><? echo $dia_formatado; if($i==0){echo ', '.$semana_abreviado[$dia_escrito];}?></td>
      <? } ?>
    </tr>
	<tr>
  <tr>
   	<td >Café </td>
      <?  
		for($c=0;$c<7;$c++){
			if($dia_da_semana==0){$dia_da_semana=7;}
			$d=mysql_result(mysql_query($a="SELECT DATE_ADD(DATE_SUB('".$_GET['filtro_inicio']."', INTERVAL ".($dia_da_semana-1)." DAY), INTERVAL ".(7*$i+$c)." DAY)"),0,0);
		?>
      <td width="140" valign="top"><? exibe_fichas($contrato_id,'cafe',$d,$_GET["filtro_inicio"],$_GET["filtro_fim"])?></td>
      <? } ?>
    </tr>
  <tr class='dif'>
   	<td>Almoço</td>
      <? for($c=0;$c<7;$c++){
			if($dia_da_semana==0){$dia_da_semana=7;}
			$d=mysql_result(mysql_query($a="SELECT DATE_ADD(DATE_SUB('".$_GET['filtro_inicio']."', INTERVAL ".($dia_da_semana-1)." DAY), INTERVAL ".(7*$i+$c)." DAY)"),0,0);
		?>
      <td width="140" valign="top"><?  exibe_fichas($contrato_id,'almoco',$d,$_GET["filtro_inicio"],$_GET["filtro_fim"]) ?></td>
      <? } ?>
    </tr>
  <tr>
   	<td>Lanche</td>
     <? for($c=0;$c<7;$c++){
			if($dia_da_semana==0){$dia_da_semana=7;}
			$d=mysql_result(mysql_query($a="SELECT DATE_ADD(DATE_SUB('".$_GET['filtro_inicio']."', INTERVAL ".($dia_da_semana-1)." DAY), INTERVAL ".(7*$i+$c)." DAY)"),0,0);
		?>
      <td width="140" valign="top"><?  exibe_fichas($contrato_id,'lanche',$d,$_GET["filtro_inicio"],$_GET["filtro_fim"])?></td>
      <? } ?>
    </tr>
  <tr class='dif'>
   	<td>Jantar</td>
      <?  for($c=0;$c<7;$c++){
			if($dia_da_semana==0){$dia_da_semana=7;}
			$d=mysql_result(mysql_query($a="SELECT DATE_ADD(DATE_SUB('".$_GET['filtro_inicio']."', INTERVAL ".($dia_da_semana-1)." DAY), INTERVAL ".(7*$i+$c)." DAY)"),0,0);
		?>
      <td width="140" valign="top"><?  exibe_fichas($contrato_id,'janta',$d,$_GET["filtro_inicio"],$_GET["filtro_fim"])?></td>
      <? } ?>
    </tr>
  <tr class='seia'>
   	<td>Ceia</td>
      <? for($c=0;$c<7;$c++){
			if($dia_da_semana==0){$dia_da_semana=7;}
			$d=mysql_result(mysql_query($a="SELECT DATE_ADD(DATE_SUB('".$_GET['filtro_inicio']."', INTERVAL ".($dia_da_semana-1)." DAY), INTERVAL ".(7*$i+$c)." DAY)"),0,0);
	?>
      <td width="140" valign="top"><?  exibe_fichas($contrato_id,'seia',$d,$_GET["filtro_inicio"],$_GET["filtro_fim"])?></td>
      <? } 
		
		
		?>
    </tr>
    </table>
    <table width="1100" cellpadding="0" cellspacing="0" class='linha' id='linha'>


<?
		if($i==$qtd_semanas-1){
?>
		<tr style="font-size:10px;font-weight:bold">
        	<td colspan="4">Interlocutor:</td>
            <td colspan="3">Nutricionista:</td>
            <td colspan="1" rowspan="2" align="center"><img src="../../../../fontes/img/PAS.jpg" height="30"/></td>
        </tr>
        <tr style="font-size:10px;font-weight:bold">
        	<td colspan="7" align="center">OBS:SUJEITO A ALTERAÇÕES</td>
            
        </tr>
<?
		}
}
?></table>

<br /><br /><br />

<div style="page-break-before: always;"> </div>


</body>
</html>