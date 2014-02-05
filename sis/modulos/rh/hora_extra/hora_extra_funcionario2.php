<?php
	$empresa_id  =mysql_fetch_object(mysql_query($t="SELECT id FROM rh_empresas WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='".$_GET['empresa1id']."' LIMIT 1")); 
	$configuracao=mysql_fetch_object(mysql_query($t="SELECT * FROM rh_folha_ponto_configuracao WHERE vkt_id='$vkt_id' AND empresa_id='".$empresa_id->id."' LIMIT 1"));

	$dia_abertura=$configuracao->dia_abertura;
	if($dia_abertura<10){$dia_abertura='0'.$dia_abertura;}
	
	$mes        = $_GET['mes'];
	//if($mes<10){$mes='0'.$mes;}	
	$ano        = $_GET['ano'];
	
	if($dia_abertura==1){
		$adicao_data=" AND DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)";
		$ultima_data_fechamento=mysql_result(mysql_query("SELECT DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH)"),0);
							
	}elseif($dia_abertura>1){
		$adicao_data=" AND DATE_SUB(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH), INTERVAL 1 DAY)";
		$ultima_data_fechamento=mysql_result(mysql_query("SELECT DATE_SUB(DATE_ADD('$ano-$mes-$dia_abertura', INTERVAL 1 MONTH), INTERVAL 1 DAY)"),0);
							
	}
	$qtd_dias =mysql_result(mysql_query("SELECT DATEDIFF('$ultima_data_fechamento','$ano-$mes-$dia_abertura')"),0);
	
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150" align="center">Data</td>
            <td width="60" >Entrada</td>
            <td width="90" >Saída</td>
            <td width="90" >Retorno</td>
       	 	<td width="60" >Saída</td>
            <td width="35" >Faltas</td>
            <td width="100" >Falta Jus.</td>
            <td width="35" >Total</td>
            <td width="35" >Saldo</td>
            <td width="80" >Horas 50%</td>
            <td width="80" >Horas 100%</td>
            <td width="100" >Ad. noturno</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<input type="hidden" name="listagem" id="listagem" value="2" />
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
<?php
	$utlimo_dia= date('t',mktime(01,01,01,$mes,01,$_GET[ano]));
	
	 $total_horas  = 0;
	 $total_horas_entrada      = "00:00";
	 $total_horas_saida_almoco = "00:00";
	 $total_horas_volta_almoco = "00:00";
	 $total_horas_saida        = "00:00";
	 $total_horas_50           = "00:00";
	 $total_horas_100          = "00:00";
	 $total_horas_noturna      = "00:00";
	 $saldo_horas = 0;
	 
	 for($i=1;$i<=$qtd_dias;$i++){
		if($i<10){
			$dia = '0'.$i;	
		}else{
			$dia = $i;
		}
		
		if($dia_abertura>$utlimo_dia){
			$dia_abertura="1";
			if($mes==12){
				$mes=01;
				$ano++;
			}else{
				$mes++;
			}
			//if($mes<10&&$mes!="01"){$mes='0'.$mes;}
		}
		
		if($dia_abertura<10&&$dia_abertura!='01'){$dia_abertura='0'.$dia_abertura;}
		
		$data = "$dia_abertura/".$mes.'/'.$ano;
		$data_folha = dataBrToUsa($data);
		$dia_abertura++;
		
		//if()
		$dia_batida_ponto = $dia;
		
		$hora_extra = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_hora_extra WHERE empresa_id='".$_GET[empresa1id]."' AND funcionario_id='".$_GET[funcionario_id]."' AND data='$ano-$mes-$dia_batida_ponto'"));
		//echo $t."<br>";
		//data BETWEEN '$ano-$mes-$dia_abertura' AND '$ultima_data_fechamento' AND vkt_id='$vkt_id'"));
		$diasemana = mysql_fetch_object(mysql_query($t="SELECT DATE_FORMAT('$ano-$mes-$dia_batida_ponto','%w') as dia_semana"));
		
		$feriado   = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_feriado WHERE vkt_id='$vkt_id' AND mes='$mes' AND dia='$dia'"));
		
		$horas_50="00:00";
		$horas_100="00:00";
		
		if($hora_extra->saldo_horas>0&&!$feriado->id>0&&$diasemana->dia_semana!=0){
			if($hora_extra->adicional_noturno>0){
				$horas_50 = $hora_extra->saldo_horas - $hora_extra->adicional_noturno;
			}else{
				$horas_50 = $hora_extra->saldo_horas;
			}
			$horas_50 = $horas_50*60*60;
												
			$horas_50 = mysql_result(mysql_query("SELECT TIME_FORMAT(SEC_TO_TIME('$horas_50'),'%H:%i')"),0,0);
		}
		if($hora_extra->saldo_horas>0&&($feriado->id>0||$diasemana->dia_semana==0)){
			if($hora_extra->adicional_noturno>0){
				$horas_100 = $hora_extra->saldo_horas - $hora_extra->adicional_noturno;
			}else{
				$horas_100 = $hora_extra->saldo_horas;
			}
			$horas_100 = $horas_100*60*60;
												
			$horas_100 = mysql_result(mysql_query("SELECT TIME_FORMAT(SEC_TO_TIME('$horas_100'),'%H:%i')"),0,0);
		}	
		
		
		$hora_entrada = substr($hora_extra->hora_entrada,0,-3);
		$hora_saida_almoco = substr($hora_extra->hora_saida_almoco,0,-3);
		$hora_retorno_almoco = substr($hora_extra->hora_retorno_almoco,0,-3);
		$hora_saida = substr($hora_extra->hora_saida,0,-3);
		$faltas     = $hora_extra->falta_integral;
		$falta_justificada   = $hora_extra->falta_justificada;
		$horas_50   = substr($hora_extra->hora_extra50,0,-3);
		$horas_100  = substr($hora_extra->hora_extra_100,0,-3);
		$horas_adicional_noturno = (int)($hora_extra->adicional_noturno/60/60);
		if($horas_adicional_noturno<10){
			$horas_adicional_noturno = "0".$horas_adicional_noturno;
		}
		$minutos_adicional_noturno = ($hora_extra->adicional_noturno/60%60);
		if($minutos_adicional_noturno<10){
			$minutos_adicional_noturno = "0".$minutos_adicional_noturno;
		}
		$adicional_noturno = $horas_adicional_noturno.":".$minutos_adicional_noturno;
		//echo $t.mysql_error();
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$color='';$bold='';
		if($diasemana->dia_semana==0){ $bold="bold";}
		if($feriado->id>0){ $bold="bold";$color="red";}
	?>       
    	<tr <?=$sel ?> style="font-weight:<?=$bold?>;color:<?=$color?>">
    	  <td width="150">
    	    <?
			echo $data." (".substr($semana_extenso[$diasemana->dia_semana],0,3).")";
			 ?>
          <input type="hidden" name="data_hora_extra" class="data_hora_extra" value="<?=$data?>" />
          <input type="hidden" name="dia" class="dia" value="<?=$dia?>" />
          <input type="hidden" name="funcionario_id" class="funcionario_id" value="<?=$_GET[funcionario_id]?>" />
          
  	    </td>
          	<td width="60" ><input type="text" name="hora_entrada" class="hora_entrada" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_entrada?>"></td>
            <td width="90" align="center"><input type="text" class="hora_saida_almoco" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_saida_almoco?>"></td>
            <td width="90" align="center"><input type="text" class="hora_retorno_almoco" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_retorno_almoco?>"></td>
       	 	<td width="60" ><input type="text" name="hora_saida" class="hora_saida" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_saida?>"></td>
           <td width="35" ><input type="checkbox" name="faltas" class="faltas" <?php if($faltas==1){echo "checked='checked'";}?> /></td>
            <td width="100" ><input type="checkbox" name="falta_justificada" class="falta_justificada" <?php if($falta_justificada==1){echo "checked='checked'";}?>/></td> 
            <td width="35" id="t<?=substr($data,0,2)?>"><?=decimal_hora($hora_extra->total)?></td>
            
            <td width="35" id="s<?=substr($data,0,2)?>"><?=decimal_hora($hora_extra->saldo_horas)?></td>
             <td width="80" ><input type="text" id="r<?=substr($data,0,2)?>" name="horas50[]" class="horas_50" value="<?=$horas_50?>" mascara="__:__" sonumero="1" style="width:50px; height:10px;"/></td>
            <td width="80" ><input type="text" name="horas100[]" id="x<?=substr($data,0,2)?>" class="horas_100" value="<?=$horas_100?>" mascara="__:__" sonumero="1" style="width:50px; height:10px;"/></td>
            <td width="100" ><input type="text" id="n<?=substr($data,0,2)?>" name="horasnoturnas[]" class="horasnoturnas" value="<?=$adicional_noturno?>" sonumero="1"
            style="width:50px; height:10px;" mascara="__:__"/></td>
          	<td width=""><?=$feriado->nome?></td>
        </tr>
      
<?
		if($hora_extra->id > 0){
			$total_horas_entrada      = mysql_result(mysql_query($t="SELECT ADDTIME('$total_horas_entrada','$hora_entrada')"),0,0);
			$total_horas_saida_almoco = mysql_result(mysql_query($t="SELECT ADDTIME('$total_horas_saida_almoco','$hora_saida_almoco')"),0,0);
			$total_horas_volta_almoco = mysql_result(mysql_query($t="SELECT ADDTIME('$total_horas_volta_almoco','$hora_retorno_almoco')"),0,0);
			$total_horas_saida        = mysql_result(mysql_query($t="SELECT ADDTIME('$total_horas_saida','$hora_saida')"),0,0);
			$total_horas_50           = mysql_result(mysql_query($t="SELECT ADDTIME('$total_horas_50','$horas_50')"),0,0);
			$total_horas_100          = mysql_result(mysql_query($t="SELECT ADDTIME('$total_horas_100','$horas_100')"),0,0);
			$total_horas_noturna      = mysql_result(mysql_query($t="SELECT ADDTIME('$total_horas_noturna','$adicional_noturno')"),0,0);
			
		}
		//echo $t."<br>";
		$total_horas   += $hora_extra->total;$saldo_total+=$hora_extra->saldo_horas;
		
	}
	
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>

</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr <?=$sel ?> style="font-weight:<?=$bold?>;color:<?=$color?>">
    	  <td width="150"></td>
          	<td width="60" ><?=substr($total_horas_entrada,0,6)?></td>
            <td width="90" align="center"><?=substr($total_horas_saida_almoco,0,6)?></td>
            <td width="90" align="center"><?=substr($total_horas_volta_almoco,0,6)?></td>
       	 	<td width="60" ><?=substr($total_horas_saida,0,6)?></td>
           <td width="35" ></td>
            <td width="100"></td> 
            <td width="35" ><?=decimal_hora($total_horas)?></td>            
            <td width="35" ><?=decimal_hora($saldo_total)?></td>
             <td width="80" ><?=substr($total_horas_50,0,5)?></td>
            <td width="80" ><?=substr($total_horas_100,0,5)?></td>
            <td width="100" ><?=substr($total_horas_noturna,0,5)?></td>
          	<td width=""></td>
        </tr>
    </thead>
</table>
</div>
<div id='rodape'>

</div>
<script>
$('#sub93').show();
$('#sub418').show()
</script>