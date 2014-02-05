<?
$caminho =$tela->caminho;
$dia_atual = date('d');
$mes_atual=date('m');
$ano_atual=date('Y');
if($_GET[mes])$mes=$_GET[mes];else $mes=$mes_atual;
if($_GET[ano])$mes=$_GET[ano];else $ano=$ano_atual;
//Includes
// configuração inicial do sistema
// funções base do sistema
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=87" class='navegacao_ativo'>
<span></span>    Contratos
</a>
</div>
<div id="barra_info">
  <a href="modulos/financeiro/contratos/form_contrato.php" target="carregador" class="mais"></a></div>


<?
//pr($_POST);
include("modulos/financeiro/_functions_financeiro.php");
include("_functions_contrato.php");
include("_ctrl_contrato.php");

?>

<table cellpadding="0" cellspacing="0" width="100%" >
    <thead>
    	<tr>
        	<td width="60" align="center">Dia Venc.</td>
    	  	<td width="200">Descricao</td>
    	  	<td width="80" style="margin:0; padding-left:10px; text-align:center">R$ Contrato</td>
    	  	<td width="70" align="center" >R$ Entrada</td>
    	  	<td width="70" align="center" >Parcela</td>
    	  	<td width="80" style="margin:0; padding-left:10px; text-align:center">R$ Parcela</td>
		  <td width="80" style="margin:0; padding-left:10px; text-align:center">R$ Previsto</td>
		  <td width="80">R$ Acrecimo</td>
            <td width="80">R$ Pago</td>
            <td width="80">R$ Pendente</td>
            <td></td>
        </tr>
    </thead>
</table>

<script>
function opf(id){
	window.open('modulos/financeiro/contas_fixas/form_conta_fixa.php?id='+id,'carregador')
}

</script>
<div id="dados">
<table cellpadding="0" cellspacing="0" width="100%"  >
    <tbody id="tabela_dados">
    <?
    $contas_q=mysql_query(
	"
	SELECT * ,date_format(data_pagamento,'%d') as dia_vencimento
	FROM financeiro_contratos 
	WHERE vkt_id='$vkt_id'
	ORDER BY date_format(data_pagamento,'%d') ASC
	");
	$linha=0;
	$total_previsto;
	while($r=mysql_fetch_object($contas_q)){
		if($linha%2)$sel="";else $sel=' class="al" ';
		
		$diavencimento = $r->dia_vencimento;
		if($diavencimento<10){
			$diavencimento="0".$diavencimento;
		}
		
		
		$movimento_contrato = conta_movimento_de_contrato($r->id);
		
		$parcelas_pagas = $r->parcelas_pagas+$movimento_contrato['parcelas'];
		
		
		$valor_pago = $r->valor_entrada+$r->valor_pago_em_parcelas+$movimento_contrato['total'];
		
		$valor_pendente = ($r->parcelas - $parcelas_pagas) *$r->valor_parcela ;
		
		$parcelas_pendentes = $r->parcelas - $parcelas_pagas;
		
		$valor_previsto = $valor_pago + $valor_pendente;
		
		$valor_acrecimo = $valor_previsto- $r->valor_contrato;
		?>
			<tr <?=$sel?>  onclick="window.open('<?=$caminho?>form_contrato.php?contrato_id=<?=$r->id?>','carregador')">
				<td width="60" align="center"><?=$diavencimento?></td>
				<td width="200" ><?=$r->nome?></td>
				<td width="80" align="right"><?=moedaUsaToBr($total_contrato[]=$r->valor_contrato)?></td>
				<td width="70" align="right"><?=moedaUsaToBr($total_entrada[]=$r->valor_entrada)?></td>
				<td width="70" align="right"><?=$parcelas_pagas?>/<?=$r->parcelas?> (<?=$parcelas_pendentes?>)</td>
				<td width="80" align="right"><?=moedaUsaToBr($total_parcela[]=$r->valor_parcela )?></td>
			  <td width="80" align="right"><?=moedaUsaToBr($total_previsto[]=$valor_previsto)?></td>
			  <td width="80" align="right"><?=moedaUsaToBr($total_acrecimo[]=$valor_acrecimo)?></td>
				
				<td width="80" align="right"><?=moedaUsaToBr($total_pago[]=$valor_pago)?></td>
				
				<td width="80" align="right"><?=moedaUsaToBr($total_pendente[]=$valor_pendente)?></td>
				<td></td>
			</tr>
		<? 
		$linha++; 
	} ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%" >
  <thead>
    <tr>
    	<td width="60"></td>
      <td width="200">Total</td>
      <td width="80" align="right" ><?=moedaUsaToBr(@array_sum($total_contrato))?></td>
      <td width="70" align="center" >&nbsp;</td>
      <td width="70" align="center" >&nbsp;</td>
      <td width="80" align="right"><span style="margin:0; padding:0; text-align:right">
        <?=moedaUsaToBr(@array_sum($total_parcela))?>
      </span></td>
      <td width="80" style="margin:0; padding:0; text-align:right"><?=moedaUsaToBr(@array_sum($total_previsto))?></td>
      <td width="80" align="right" ><?=moedaUsaToBr(@array_sum($total_acrecimo))?></td>
      <td width="80" align="right" ><?=moedaUsaToBr(@array_sum($total_pago))?></td>
      <td width="80" align="right" ><?=moedaUsaToBr(@array_sum($total_pendente))?></td>
      <td></td>
    </tr>
  </thead>
</table>

<script>resize()</script><!-- Isso é Necessário para a criação o resize -->

</div>
<div id='rodape'>
<script>
function atualizaDado(t,id,dia,mes,ano){
	valor = t.parentNode.parentNode.getElementsByClassName('valor')[0].value;
	window.open('modulos/financeiro/contas_fixas/atualiza.php?id='+id+'&valor='+valor+'&mes='+mes+'&ano='+ano+'&dia='+dia,'carregador');
}
</script>
<script>
	$("#centro_escolha").click(function(){
		$("#centro").show();$("#plano").hide();
	})
	
	$("#plano_escolha").click(function(){
		$("#centro").hide();$("#plano").show();
	})

</script>
</div>
