<?
include '../../../_config.php';
include '../../../_functions_base.php';
if($_GET['contrato_id']){
	$contrato=mysql_fetch_object(mysql_query("SELECT * FROM contrato WHERE id='{$_GET['contrato_id']}'"));
	$empreendimento=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='{$contrato->empreendimento_id}'"));
	$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='{$contrato->disponibilidade_id}'"));
	$disponibilidade_tipo=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='{$disponibilidade->disponibilidade_tipo_id}'"));
	$cliente=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='{$contrato->cliente_fornecedor_id}'"));
	$corretor=mysql_fetch_object(mysql_query("SELECT * FROM corretor WHERE id='{$contrato->corretor_id}'"));
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Impressão</title>
</head>

<body>

<div id="root" style=" width:800px;  height:500px; margin:0 auto;">
	<span style="float:left; font-size:28px; font-weight:bold;"><?=$cliente->nome_fantasia?></span>
    <span style="float:right; font-size:14px; width:200px; text-align:center;"><?=$disponibilidade_tipo->descricao?></span>
    <span style="float:right; font-size:28px; font-weight:bold;">UNIDADE</span>
    
    <table style="width:800px; margin-top:10px; text-align:center; font-size:12px; float:left;" cellpadding="3" cellspacing="0" border="1">
    	<thead><tr>
        <td>VALOR TOTAL</td>
        <td>VALOR COMISSÃO</td>
        <td>VALOR DE CONTRATO</td>
        <td>VALOR SINAL</td>
        <td>FINANCIAMENTO CAIXA</td>
        </tr></thead>
        <tbody><tr>
        <td>R$ <?=moedaUsaToBr($contrato->valor)?></td>
        <td>R$ <?=moedaUsaToBr($contrato->valor_comissao)?></td>
        <td>R$ <?=moedaUsaToBr($contrato->valor_contrato)?></td>
        <td>R$ <?=moedaUsaToBr($contrato->valor-$contrato->banco_valor)?></td>
        <td>R$ <?=moedaUsaToBr($contrato->banco_valor)?></td>
        </tr></tbody>
    </table>
    <table style="float:left; font-size:12px; text-align:center; margin-top:15px; width:593px;" border="1" cellspacing="0" cellpadding="3">
    	<thead>
        <tr>
        <td colspan="4" align="left" style="padding-left:35px;">ENTRADA</td>
        </tr>
        <tr>
        <td>PARCELA</td>
        <td>IMOBILIÁRIA</td>
        <td>BELA VISTA</td>
        <td>TOTAL</td>
        </tr>
        </thead>
        <tbody>
        <? 
		$faturas_q=mysql_query("SELECT * FROM faturas WHERE contrato_id ='{$_GET['contrato_id']}' AND tipo='ato' ORDER BY id ASC"); 
		$i=0;
		while($fatura=mysql_fetch_object($faturas_q)){
			$comissao_q=mysql_query("SELECT * FROM faturas_comissao WHERE contrato_id='{$_GET['contrato_id']}' ORDER BY id ASC");
			$valor_comissao=mysql_result($comissao_q,$i,3);
			$i++;
		?>
        <tr>
            <td><?=dataUsaToBr($fatura->data_vencimento)?></td>
            <td>R$ <?=moedaUsaToBr($valor_comissao)?></td>
            <td>R$ <?=moedaUsaToBr($fatura->valor)?></td>
            <td>R$ <?=moedaUsaToBr($fatura->valor+$valor_comissao)?></td>
            <? $total_entrada+=$fatura->valor+$valor_comissao; ?>
        </tr>
        <? } ?>
        <tr style="border:none !important;">
        	<td colspan="3" style="border:none !important;">TOTAL DE VALOR DE ENTRADA CAPTADO NA VENDA</td>
            <td colspan="1" style="border:none !important;">R$ <?=moedaUsaToBr($total_entrada)?></td>
        </tr>
        </tbody>
    </table>
    <div style="float:left;  width:205px; margin-top:15px; text-align:center;">
        <span style="font-weight:bold;"><?=$empreendimento->nome?></span>
        <span style="display:block; margin-top:5px; font-size:12px;"><?=$corretor->nome?></span>
        <span style="display:block; font-size:10px; margin-top:10px;">PASTA APROVADA EM 05/10/2012</span>
    </div>
	<table style="float:left; border-top:solid 1px black;border-bottom:solid 1px black;border-right:solid 1px black; margin-top:10px; font-size:12px; text-align:center; width:800px;" cellspacing="0" cellpadding="3" border="0">
    	<thead style=" font-weight:bold; ">
        	<tr>
            	<td style="border-left:solid 1px black; border-bottom:solid 1px black;">VENCIMENTOS</td>
                <td style="border-left:solid 1px black;border-bottom:solid 1px black;">PARCELA</td>
                <td style="border-left:solid 1px black;border-bottom:solid 1px black;">SALDO DEVEDOR</td>
                <td style="border-left:solid 1px black;border-bottom:solid 1px black;">VALOR PARCELA</td>
                <td style="border-left:solid 1px black;border-bottom:solid 1px black;">SITUAÇÃO</td>
            </tr>
        </thead>
        <tbody>
        <?
        $faturas_q=mysql_query("SELECT * FROM faturas WHERE  vkt_id='$vkt_id' AND contrato_id='{$_GET['contrato_id']}' ORDER BY id ASC");
		$total_sinal= $contrato->valor-$contrato->banco_valor;
		while($fatura=mysql_fetch_object($faturas_q)){
			
		?>
        	<tr>
            	<td style="border-left:solid 1px black;"><?=dataUsaToBr($fatura->data_vencimento)?></td>
                <td style="border-left:solid 1px black;"><?=strtoupper($fatura->tipo)?></td>
                <td style="border-left:solid 1px black;">R$ <?=moedaUsaToBr($total_sinal-=$fatura->valor)?></td>
                <td style="border-left:solid 1px black;">R$ <?=moedaUsaToBr($fatura->valor)?></td>
                <td style="border-left:solid 1px black;">CH 559436-7</td>
            </tr>
            <? }  ?>
            <tr>
                <td style="border-left:solid 1px black;" colspan="3">TOTAL</td>
                <td>R$ <?=$total_sinal?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

</div>
</body>
</html>