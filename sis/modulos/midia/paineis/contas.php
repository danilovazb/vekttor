<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("_functions.php"); 
include("_ctrl.php"); 
if(!empty($_GET[mes])){
		$mes_b= $_GET[mes];
		$ano_b= $_GET[ano];
		$sql_add="
			AND 
				data_info_movimento >= '$ano_b-$mes_b-01' 
			AND 
				data_info_movimento <= '$ano_b-$mes_b-31' ";
}
$mes_s[$mes_b] = 'selected="selected"';
$ano_s[$ano_b] = 'selected="selected"';
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<script>
function trocaBanco(d) {
	$(".dvboletos").hide();
	$('#num_inicio_boleto').show();
	if(d.value == 001) {//Banco do Brasil
		$('#convenio').show();
		$('#contrato').show();
		$('#carteira').show();
		$('#variacao_carteira').show();
		
	}
	
	if(d.value == 237) {//Bradesco
		//$('#convenio').show();
		$('#carteira').show();
		
	}
	
	if (d.value ==104) {//Caixa Econômica
		$('#convenio').show();
	
	} 
	if (d.value ==409) {//Itaú
		$('#carteira').show();
	
	} 
	if (d.value ==399) {//HSBC
		$('#codigo_cedente').show();
		$('#carteira').show();
	
	} 
	
	
	
	
}

</script>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>

<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=49" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
</div>
<div id="barra_info">    
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
    <form method="get">
    Periodo
      <select name="mes" onchange="this.parentNode.submit()">
    	<option value="01"<?=$mes_s['01']?> >Janeiro</option>
    	<option value="02"<?=$mes_s['02']?> >Fevereiro</option>
    	<option value="03"<?=$mes_s['03']?> >Março</option>
    	<option value="04"<?=$mes_s['04']?> >Abril</option>
    	<option value="05"<?=$mes_s['05']?> >Maio</option>
    	<option value="06"<?=$mes_s['06']?> >Junho</option>
    	<option value="07"<?=$mes_s['07']?> >Julho</option>
    	<option value="08"<?=$mes_s['08']?> >Agosto</option>
    	<option value="09"<?=$mes_s['09']?> >Setembro</option>
    	<option value="10"<?=$mes_s['10']?> >Outubro</option>
    	<option value="11"<?=$mes_s['11']?> >Novembro</option>
    	<option value="12"<?=$mes_s['12']?> >Dezembro</option>
    </select>
      <select name="ano" onchange="this.parentNode.submit()">
      <?
      for($i=date("Y");$i>date("Y")-5;$i--){
		echo "<option value='$i'".$ano_s[$i].">$i</option>";  
		}
	  ?>
    	
    </select>
    <input type="hidden" name="tela_id" value="49" />
    <input type="checkbox" name="considera_transferencia" value="1" onclick="this.parentNode.submit()" <? if($_GET['considera_transferencia']==1){ echo 'checked="checked"';}?> /> 
    <span style="color:#999; font-size:11px;">Sem Transferencias</span>
    </form>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"><?=linkOrdem("Identificação","nome",1)?></td>
          	<td width="98" align="right">Entradas</td>
       	  <td width="98" align="right">Saidas</td>
       	  <td width="98" align="right">Saldo</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	
	
	
	// necessario para paginacao
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query("SELECT * FROM financeiro_contas WHERE cliente_vekttor_id='$cliente_id'   ORDER BY ".$ordem." ".$_GET['ordem_tipo']." ");
	$tentradas=0;
	$tsaidas=0;
	$saldof=0;
	
	if($_GET['considera_transferencia']){
		$considera_transferencia = " AND transferencia!= '1' "	;
	}else{
		$considera_transferencia ='';
	}
	
	
	
	
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$totals = mysql_fetch_object(mysql_query($trace="SELECT 
				SUM(entrada) as entrada, 
				sum(saida) as saida 
			FROM 
				financeiro_movimento 
			WHERE 
				conta_id='$r->id' 
			$sql_add
			AND 
				status ='1' 
			AND 
				movimentacao = 'financeiro' 
			$considera_transferencia"));
		//echo $trace;
		$ultimo_saldo = mysql_fetch_object(mysql_query($t="SELECT * FROM 
			financeiro_movimento 
		WHERE 
			conta_id='$r->id' 
		$sql_add
		AND  
			status ='1' 
		$considera_transferencia
		ORDER BY 
			data_movimento 
		DESC LIMIT 1"));
		//echo $t;
		$tentradas+=$totals->entrada;
		$tsaidas+=$totals->saida;
		$saldof+=$ultimo_saldo->saldo;
	?>      
    	<tr <?=$sel?> >
          	<td width="209" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')"><?=$r->nome?></td>
          	<td width="98" align="right"><?=number_format($totals->entrada,2,',','.')?></td>
       	  <td width="98" align="right"><?=number_format($totals->saida,2,',','.')?></td>
       	  <td width="98" align="right" onclick="location='?tela_id=54&conta_id=<?=$r->id?>&mes_i=<?=$mes_b?>&ano_i=<?=$ano_b?>&mes_f=<?=$mes_b?>&ano_f=<?=$ano_b?>'" title="Ver Movimentação"><?=number_format($ultimo_saldo->saldo,2,',','.')?></td>
          	<td></td>
        </tr>
<?
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
    	<tr>
            <td width="209">Total</td>
            <td width="98"align="right"><?=number_format($tentradas,2,',','.')?></td>
            <td width="98"align="right"><?=number_format($tsaidas,2,',','.')?></td>
            <td width="98"align="right"><?=number_format($saldof,2,',','.')?></td>
          	<td width=""></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	
</div>
