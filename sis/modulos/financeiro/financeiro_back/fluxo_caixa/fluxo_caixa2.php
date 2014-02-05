<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
?>
<script src="modulos/financeiro/financeiro.js"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>


<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=52" class='navegacao_ativo'>
<span></span>   Fluxo de Caixa
</a>
</div>
<div id="barra_info">
    <a href="modulos/financeiro/form_movimentacao.php" target="carregador" class="mais"></a>
<form style="float:left; margin:0; padding:0"> 
    Exibi&ccedil;&atilde;o
      
     
    
    Inicio
    <?
    if(empty($_GET[filtro_inicio])&&empty($_GET[filtro_fim])){
		$filtro_inicio 	= date("Y-m-").'01';
		$filtro_fim		= date("Y-m-t");
		
	}else{
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
	}
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
	
	?>
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    
     Fim
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
    <label>Forma de pagamento:
        <select name="forma_pagamento">
            <option value="0" <? if($_GET[forma_pagamento]=='0')echo 'selected'; ?> >Todas</option>
            <option value="1" <? if($_GET[forma_pagamento]=='1')echo 'selected'; ?> >Dinheiro</option>
            <option value="2" <? if($_GET[forma_pagamento]=='2')echo 'selected'; ?> >Cheque</option>
            <option value="3" <? if($_GET[forma_pagamento]=='3')echo 'selected'; ?> >Cartao</option>
            <option value="4" <? if($_GET[forma_pagamento]=='4')echo 'selected'; ?> >Boleto</option>
            <option value="5" <? if($_GET[forma_pagamento]=='5')echo 'selected'; ?> >Permuta</option>
            <option value="6" <? if($_GET[forma_pagamento]=='6')echo 'selected'; ?> >Outros</option>
        </select>
    </label>
    <input type="hidden" name="tela_id" value="80" />
<input type="submit" name="button" id="button" value="Ir" />
</form>
</div>
<div id='dados' style="clear:both;">
  <table cellpadding="0" cellspacing="0"  width="<?=300+(($total_dias+1)*70)?>">
    <thead>
    	<tr>
    	  <td width="209" style="padding:1px;"><div style="width:206px; position:fixed; height:18px; background:url(../fontes/img/bb.jpg) 5px  -2px ; margin:-3px 0 0 -10x; border-right:1px solid  #CCC ">&nbsp;&nbsp;Entradas</div>Entradas</td>
<?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo 	= mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
				$semanainfo = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%w')"),0,0);
				$dtinfo 	= mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%d')"),0,0);
				;
			?>
          	<td width="70" style="margin:0; padding:0; text-align:center"><?=$semana_abreviado[$semanainfo].', '.$dtinfo?></td>
            <?
			}
			?>
            <td width="70" align="center">Total</td>
            <td width=""></td>
			
        </tr>
    </thead>
</table><script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>

<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*70)?>" >
    <tbody>
	<?
	
	if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND forma_pagamento ='{$_GET[forma_pagamento]}'";
	
	$q= mysql_query("
	SELECT 
		*,
		date_format(data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento 
	WHERE 
		cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	AND 
		tipo='receber'  
	AND 
		`status`<'2'
	AND
		extorno='0'
	AND
		transferencia='0'
	AND 
		data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro_forma
	ORDER BY  
		data_vencimento ");
	
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		if($r->status==0){
			$datainfo = $r->data_vencimento;
		}else{
			$datainfo = 	$r->data_info_movimento ;
		}
		
	?>      
    	<tr <?=$sel?> onclick="opf(<?=$r->id?>)">
          	<td width="200" ><div class='sobre' style="width:205px;"><?=$r->descricao?></div><?=$r->descricao?></td>
            <?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			$color='';
			if($datainfo==$diainfo){
				$somadia[$diainfo][]=$r->valor_cadastro ;
				if($r->status ==1){
					$somapago[$diainfo][]=$r->valor_cadastro ;
					$color = 'color:#00F';

				}
				if($r->status ==0){
					if($diainfo<date("Y-m-d")){
						$color = 'color:#F00';
					}
					$somaPendente[$diainfo][]=$r->valor_cadastro ;
				}
				
				$val=  moedaUsaToBr($r->valor_cadastro);
				$somatotal[$r->id]=$r->valor_cadastro;
			}else{
				$val = '';
			}

			?><td style="width:70px;margin:0;padding:0;text-align:right;<?=$color?>"><?=$val?></td><?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr($somatotal[$r->id])?></td>
          	<td width=""></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>

<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*70)?>">
  <thead>
    	<tr>
       	  <td width="200">Total</td>
            <?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
       	  <td width="70" style="margin:0; padding:0; text-align:right"><?
            $totalna= @array_sum($somadia[$diainfo]);
			if($totalna>0){
				$totaln[]= $totalna;
				echo moedaUsaToBr($totalna);
			}else{
			echo "&nbsp;";
			}
			?></td>
            <?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr($total_recebiveis=@array_sum($totaln));$totaln=array();?></td>
          	<td width=""></td>
      </tr>
    </thead>
</table><table cellpadding="0" cellspacing="0"  width="<?=300+(($total_dias+1)*70)?>">
  <thead>
    	<tr>
    	  <td width="209" style="padding:1px;"><div style="width:206px; position:fixed; height:18px; background:url(../fontes/img/bb.jpg) 5px  -2px ; margin:-3px 0 0 -10x; border-right:1px solid  #CCC ">&nbsp;&nbsp;Saidas</div>Saidas</td>
<?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo 	= mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
				$semanainfo = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%w')"),0,0);
				$dtinfo 	= mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%d')"),0,0);
				;
			?>
          	<td width="70" style="margin:0; padding:0; text-align:center">&nbsp;</td>
            <?
			}
			?>
            <td width="70" align="center">Total</td>
            <td width=""></td>
			
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*70)?>" >
  <tbody>
	<?
	
	if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND forma_pagamento ='{$_GET[forma_pagamento]}'";
	
	$q= mysql_query("
	SELECT 
		*,
		date_format(data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento 
	WHERE 
		cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	AND 
		tipo='pagar'  
	AND 
		`status`<'2'
	AND
		extorno='0'
	AND
		transferencia='0'
	AND 
		data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro_forma
	ORDER BY  
		data_vencimento ");
	
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		if($r->status==0){
			$datainfo = $r->data_vencimento;
		}else{
			$datainfo = 	$r->data_info_movimento ;
		}
	?>      
    	<tr <?=$sel?> onclick="opf(<?=$r->id?>)">
          	<td width="200" ><div class='sobre' style="width:205px;"><?=$r->descricao?></div><?=$r->descricao?></td>
            <?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			$color='';
			if($datainfo==$diainfo){
				$somadia_pago[$diainfo][]=$r->valor_cadastro ;
				if($r->status ==1){
					$somapago[$diainfo][]=$r->valor_cadastro ;
					$color = 'color:#00F';

				}
				if($r->status ==0){
					if($diainfo<date("Y-m-d")){
						$color = 'color:#F00';
					}
					$somaPendente[$diainfo][]=$r->valor_cadastro ;
				}
				
				$val=  moedaUsaToBr($r->valor_cadastro);
				$somatotal[$r->id]=$r->valor_cadastro;
			}else{
				$val = '';
			}

			?><td style="width:70px;margin:0;padding:0;text-align:right;<?=$color?>"><?=$val?></td><?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr($somatotal[$r->id])?></td>
          	<td width=""></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>

<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*70)?>">
  <thead>
    	<tr>
       	  <td width="200">Total</td>
            <?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
       	  <td width="70" style="margin:0; padding:0; text-align:right"><?
            $totalna= @array_sum($somadia_pago[$diainfo]);
			if($totalna>0){
				$totaln[]= $totalna;
				echo moedaUsaToBr($totalna);
			}else{
			echo "&nbsp;";
			}
			?></td>
            <?
			}  
			?>
          	<td width="70" align="right"><?=moedaUsaToBr($total_pagaveis=@array_sum($totaln));?></td>
          	<td width=""></td>
      </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0"width="<?=300+(($total_dias+1)*70)?>" >
  <thead>
    <tr>
      <td width="200">Saldo Parcial</td>
            <?
			$totaln=array();
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
       	  <td width="70" style="margin:0; padding:0; text-align:right"><?
            $totalna_recebido= @array_sum($somadia[$diainfo]);
            $totalna_pago= @array_sum($somadia_pago[$diainfo]);
			if($i>0){
				$saldo_dia[$diainfo] = $totalna_recebido-$totalna_pago;
			}else{
				$saldo_dia[$diainfo] = $totalna_recebido-$totalna_pago;
			}
			
			
			echo number_format($saldo_dia[$diainfo],2,',','.')
			?></td>
            <?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr(@array_sum($totaln));?></td>
	      <td width=""></td>
    </tr>
  </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*70)?>">
  <thead>
    <tr>
      <td width="200">Saldo Acumulado</td>
            <?
			$totaln=array();
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
				$diainfo_a = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL ".($i-1)." DAY)"),0,0);

			?>
          	<td width="70" style="margin:0; padding:0; text-align:right;"><?
			if($i>0){
				$saldo_acumulado[$diainfo] = $saldo_dia[$diainfo]+$saldo_acumulado[$diainfo_a];
			}else{
			//	echo"=";
				$saldo_acumulado[$diainfo] = $saldo_dia[$diainfo];
			}
			
			
			echo number_format($saldo_acumulado[$diainfo],2,',','.')
			?></td>
            <?
			}
			?>
           	<td width="70" align="right"><?=moedaUsaToBr($total_recebiveis-$total_pagaveis)?></td>
     <td width=""></td>
    </tr>
  </thead>
</table>


</div>

</div>
<div id='rodape'>
	
</div>
