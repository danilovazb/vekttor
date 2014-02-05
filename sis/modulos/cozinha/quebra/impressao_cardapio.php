<?
require '../../../_config.php';
include '../../../_functions_base.php';

function exibe_fichas($contrato_id,$refeicao,$data_oficial){
	global $vkt_id;
$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='$refeicao' ");
				//echo $t;
				$i=0;
				while($ficha=mysql_fetch_object($fichas_q)){
					$i++;
					echo "<div>{$ficha->pessoas} - {$ficha->ficha}</div>";
				}
				if($i==0){
					echo "&nbsp;";	
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
$mes = mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[filtro_inicio]}','%m')"),0,0);
$ano= mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[filtro_inicio]}','%Y')"),0,0);


$ultimo_dia_mes_anterior_d = mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_SUB('$ano-$mes-01',interval 1 day),'%d')"),0,0);

$anterior_mes = mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_SUB('$ano-$mes-01',interval 1 day),'%m')"),0,0);

$ultimo_dia_mes_anterior = mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_SUB('$ano-$mes-01',interval 1 day),'%w')"),0,0);


$ultimo_dia_mes_atual = mysql_result(mysql_query("SELECT DATE_FORMAT(LAST_DAY('$ano-$mes-01'),'%d')"),0,0);

$proximo_mes = mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$ano-$mes-01', interval 1 month),'%m')"),0,0);

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style type="text/css">
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
</style>



  <div  style="padding:10px 0px 10px 0px "><strong>Unidade: </strong>Central
  </div>
  <H1 style="margin:0;"> <?=$mes_extenso[$mes*1-1]?> de <?=$ano?></H1>
<table  cellpadding="0" id='linha' cellspacing="0" class='linha'>

<?
for($i=0;$i<5;$i++){
?>
	<tr class="al">
    	<td width="60">&nbsp;</td>
        <?  
		for($c=0;$c<7;$c++){ $d = $c+($i*7);
		if($ultimo_dia_mes_anterior>=$d){
			$d=$ultimo_dia_mes_anterior_d-$ultimo_dia_mes_anterior+$c;
			$mes_info=$anterior_mes;
		}else{
			 $d = dd($c+($i*7)-$ultimo_dia_mes_anterior);
			$mes_info=$mes;
		}
		if($d>$ultimo_dia_mes_atual){
			$d=dd($d-$ultimo_dia_mes_atual);
			$mes_info=$proximo_mes;
		}
		$dia_escrito=mysql_result(mysql_query($o="SELECT DATE_FORMAT('$ano-$mes_info-$d','%w')"),0,0);
	?>
        <td width="150"><? echo $d.'/'. $mes_info.'/'.$ano; if($i==0){echo ', '.$semana_abreviado[$dia_escrito];}?></td>
        <? } ?>
     </tr>
	<tr>
	<tr>
    	<td width="60" >Café </td>
        <?  
		for($c=0;$c<7;$c++){ $d = $c+($i*7);
		if($ultimo_dia_mes_anterior>=$d){
			$d='&nbsp;';
		}else{
			 $d = dd($c+($i*7)-$ultimo_dia_mes_anterior);
		}
		?>
        <td width="150"><? exibe_fichas($contrato_id,'cafe',"$ano-$mes-$d")?></td>
        <? } ?>
     </tr>
	<tr class='dif'>
    	<td width="60">Almoço</td>
        <? for($c=0;$c<7;$c++){ $d = $c+($i*7);
		if($ultimo_dia_mes_anterior>=$d){
			$d='&nbsp;';
		}else{
			 $d = dd($c+($i*7)-$ultimo_dia_mes_anterior);
		}

		?>
        <td width="150"><?  exibe_fichas($contrato_id,'almoco',"$ano-$mes-$d") ?></td>
        <? } ?>
     </tr>
	<tr>
     	<td width="60">Lanche</td>
       <? for($c=0;$c<7;$c++){ $d = $c+($i*7); 
	   	if($ultimo_dia_mes_anterior>=$d){
			$d='&nbsp;';
		}else{
			 $d = dd($c+($i*7)-$ultimo_dia_mes_anterior);
		}
		?>
        <td width="150"><?  exibe_fichas($contrato_id,'lanche',"$ano-$mes-$d")?></td>
        <? } ?>
     </tr>
	<tr class='dif'>
     	<td width="60">Janta</td>
        <?  for($c=0;$c<7;$c++){$d = $c+($i*7); 
		if($ultimo_dia_mes_anterior>=$d){
			$d='&nbsp;';
		}else{
			 $d = dd($c+($i*7)-$ultimo_dia_mes_anterior);
		}

		
		?>
        <td width="150"><?  exibe_fichas($contrato_id,'janta',"$ano-$mes-$d")?></td>
        <? } ?>
     </tr>
	<tr class='seia'>
     	<td width="60">Seia</td>
        <? for($c=0;$c<7;$c++){$d = $c+($i*7);

		if($ultimo_dia_mes_anterior>=$d){
			$d='&nbsp;';
		}else{
			 $d = dd($c+($i*7)-$ultimo_dia_mes_anterior);
		}

	?>
        <td width="150"><?  exibe_fichas($contrato_id,'seia',"$ano-$mes-$d")?></td>
        <? } 
		
		
		?>
     </tr>

<?
}
?></table>

<br /><br /><br />

<div style="page-break-before: always;"> </div>

