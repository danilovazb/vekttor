<?
require('../../../_config.php');
require('../../../_functions_base.php');
require('_functions.php');
$folha_pagamento= mysql_fetch_object(mysql_query("SELECT * from rh_folha_empresa WHERE id='".$_GET[folha_id]."'"));

//print_r($folha_pagamento);
$folha_numero = $folha_pagamento->mes+1;
if($folha_numero<10){
	$mes_folha = '0'.$folha_numero;
}else{
	$mes_folha = $folha_numero;
}

$ano_folha =$folha_pagamento->ano;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Folha de pagamento de <?=$mes_extenso[$_GET['mes']]?> de <?=$_GET['ano']?> </title>
</head>
<body>
<style>
body{margin:0; padding:0}
*{ font-family:Arial, Helvetica, sans-serif; font-size:11px;}
td{ border-left:1px solid #000; border-bottom:1px solid #000}
table{border-right:1px solid #000; border-top:1px solid #000}
</style>
<?
if($_GET['empresa_id']>0){
	$empresa_q=mysql_query($a="SELECT * FROM cliente_fornecedor WHERE id='{$_GET['empresa_id']}'");
	$empresa=mysql_fetch_object($empresa_q);
}
if($_GET['mes']=='12'){
	$folha_mes = "Ref.50% 13° Integral";
}
if($_GET['mes']=='13'){
	$folha_mes = "Ref.50% 13° 1/2";
}
if($_GET['mes']=='14'){
	$folha_mes = "Ref.50% 13° 2/2";
}
if(empty($folha_mes)){
	$folha_mes = $mes_extenso[$_GET['mes']];
}

?>
<div style=" clear:both;"></div>
<table cellpadding="2" cellspacing="0" border="0" bordercolor="#000000" style="border-color:black;" width="1400">

<thead>
	<tr>
    	<td colspan="2" rowspan="2" width="150"></td>
        <td colspan="26" style="font-weight:bold; font-size:22px; padding:0">Folha de Pagamento - <?=$folha_mes?>, <?=$_GET['ano']?>
        <div style=" float:right; background-color:#CCC; border-left:solid 1px black; padding:5px;">
<?=$empresa->razao_social?> - <?=$empresa->cnpj_cpf?><br />
<span style="font-size:12px;">
<?=$empresa->endereco?>, <?=$empresa->bairro?><br />
<?=$empresa->cidade?>, <?=$empresa->estado?> 

</span>
</div>
        
        
        </td>
    </tr>
    <tr>
    	<td colspan="17" align="center" style="background-color:#CCC; font-weight:bold; border-right:black 3px solid;">Vencimentos
        </td>
        <td colspan="9" align="center" style="background-color:#CCC; font-weight:bold;">
        Descontos
        </td>
    </tr>
    <tr style=" background-color:#CCC;">
    	<td rowspan="3" >Nº</td>
    	<td rowspan="3" >Nome</td>
        <td rowspan="2" width="100" align="center">Salário Base</td>
        <td rowspan="2" width="30" align="center"><!--Horas-->13&ordm; Sal</td>
        <td colspan="2" rowspan="2" align="center">Hora Extra 50%</td>
        <td colspan="2" rowspan="2" align="center">Hora Extra 100%</td>
        <td rowspan="2" width="60" align="center">Adc. Noturno</td>
        <td rowspan="2" align="center">DSR</td>
        <td rowspan="2" align="center">Comissão</td>
        <td rowspan="2" align="center" width="40">DSR</td>
        <td rowspan="2" align="center" width="60">Gratificação</td>
        <td rowspan="2" width="60" align="center">Periculosidade/<br />
Adcional Noturno</td>
        <td rowspan="2" width="60" align="center">Insalubridade</td>
        
        <td colspan="2" rowspan="2" align="center" >Salário Família</td>
        
        <td rowspan="2" align="center" width="80">Total dos Vencimentos</td>
        <td rowspan="2" align="center" width="80" style="border-right:black 3px solid;">Base de Cálculo</td>
        <td rowspan="2" colspan="2" align="center" width="60">Faltas</td>
        <td rowspan="2" colspan="2" align="center" width="60">Vale transporte</td>
        <td rowspan="2" align="center" width="60">Adiantamento</td>
        <td colspan="2" align="center">Deduções</td>
        <td rowspan="2" align="center">Saldo</td>
        <td rowspan="2" align="center">FGTS</td>
    </tr>
    <tr style=" background-color:#CCC;">
    	
        <td align="center">IRPF</td>
        <td align="center">INSS</td>
    </tr>
    <tr style="background-color:#CCC;">
    	<td align="center">R$</td>
        <td align="center"><!--Qtd<-->Mês</td>
        <td align="center">Qtd</td>
        <td align="center">R$</td>
        <td align="center">Qtd</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">Qtd</td>
        <td align="center">R$</td>
        
        <td align="center">R$</td>
        <td align="center" style="border-right:black 3px solid;">R$</td>
        <td align="center">Qtd</td>
        <td align="center">R$</td>
         <td align="center">%</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
        <td align="center">R$</td>
    </tr>
</thead>
<tbody>
<?
$q = mysql_query($t="SELECT re.*,rf.*, re.id as funcioraio_id FROM 
					  	rh_funcionario as re,
						rh_folha_funcionarios as rf
					  WHERE 
					  	rf.rh_folha_id='".$_GET['folha_id']."' AND
						re.vkt_id='$vkt_id'	
						AND re.id = rf.funcionario_id
					ORDER BY re.nome ASC");
$i=0;
while($r=mysql_fetch_object($q)){
$i++;

 $ferias = mysql_fetch_object(mysql_query($t="SELECT *
FROM `rh_ferias` WHERE  funcionario_id ='$r->funcioraio_id' AND month(data_inicio)=$mes_folha AND YEAR(data_inicio)=$ano_folha"));  
//echo $t;
if($ferias->id<1){
	

?>

	<tr>
    	<td><?=$i?></td>
    	<td><?=$dados_ferias.$r->nome?></td>
        <td align="right"><?=moedaUsaToBr($total_salario_base[]=$r->salario_base)?></td>
        <td align="right"><?=$r->decimo_terceiro_proporcional."/12";//substr($r->horas_trabalhadas,0,-3)?></td>
        <td align="right"><?=substr($total_horas_extras_horas50[]=$r->horas_extras_horas_50,0,-3)?></td>
        <td align="right"><?=moedaUsaToBr($total_horas_extras_valor50[]=$r->horas_extras_valor_50)?></td>
        <td align="right"><?=substr($total_horas_extras_horas100[]=$r->horas_extras_horas_100,0,-3)?></td>
        <td align="right"><?=moedaUsaToBr($total_horas_extras_valor100[]=$r->horas_extras_valor_100)?></td>
        <td align="right"><?=moedaUsaToBr($total_noturno[]=$r->valor_adicional_noturno)?></td>
        <td align="right"><?=moedaUsaToBr($total_dsr[]=$r->dsr_hora_extra)?></td>
        <td align="right"><?=moedaUsaToBr($total_comissao[]=$r->comissao)?></td>
        <td align="right"><?=moedaUsaToBr($total_dsr_comissao[]=$r->dsr_comissao)?></td>
        <td align="right"><?=moedaUsaToBr($total_gratificacao[]=$r->gratificacao)?></td>
        
        <td align="right"><?=moedaUsaToBr($total_periculosidade[]=$r->valor_periculosidade+$r->valor_adiciona_noturno_salario)?></td>
        <td align="right"><?=moedaUsaToBr($total_insalubridade[]=$r->valor_insalubridade)?></td>
        
        <td align="right"><?=$total_salario_familia_qtd[]=$r->salario_familia_qtd?></td>
        <td align="right"><?=moedaUsaToBr($total_salario_familia_valor[]=$r->salario_familia_valor)?></td>
        
        <td align="right"><?=moedaUsaToBr($total_subtotal[]=$r->sub_total_valor)?></td>
        <td align="right" style="border-right:black 3px solid;"><?=moedaUsaToBr($total_base_calculo[]=$r->base_calculo_inss)?></td>
        <td align="right"><?=qtdUsaToBr_($total_faltas[]=$r->faltas)?></td>
        <td align="right"><?=moedaUsaToBr($total_faltas_valor[]=$r->faltas_valor)?></td>
         <td align="right"><?=limitador_decimal_br($total_porc_transporte[]=$r->porcentagem_valetransporte)?></td>
        <td align="right"><?=moedaUsaToBr($total_transporte_valor[]=($r->porcentagem_valetransporte*$r->salario_base/100))?></td>
        <td align="right"><?=moedaUsaToBr($total_adiantamento[]=$r->deducao_adiantamento)?></td>
        <td align="right"><?=moedaUsaToBr($total_deducao_irpf[]=$r->deducao_irpf)?></td>
        <td align="right"><?=moedaUsaToBr($total_deducao_inss[]=$r->deducao_inss)?></td>
        <td align="right"><?=moedaUsaToBr($total_saldo[]=$r->saldo_a_receber_salario)?></td>
        <td align="right"><?=moedaUsaToBr($total_fgts[]=$r->fgts)?></td>
    </tr>
<? }else{
	
	?>
	<tr>
    	<td><?=$i?></td>
    	<td><?=$dados_ferias.$r->nome?></td>
        <td align="right">Ferias</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        
        <td align="right">-</td>
        <td align="right">-</td>
        
        <td align="right"><?=$total_salario_familia_qtd[]=$r->salario_familia_qtd?></td>
        <td align="right"><?=moedaUsaToBr($total_salario_familia_valor[]=$r->salario_familia_valor)?></td>
        
        <td align="right"><?=moedaUsaToBr($total_subtotal[]=$r->salario_familia_valor)?></td>
        <td align="right" style="border-right:black 3px solid;">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right">-</td>
        <td align="right"><?=moedaUsaToBr($total_saldo[]=$r->salario_familia_valor)?></td>
        <td align="right">-</td>
    </tr>

	<?
	
	
	
	}
	
	} ?>
</tbody>
<tfoot>
	<tr style="font-weight:bold; background-color:#CCC;">
    	<td align="right">&nbsp;</td>
    	<td align="right">Totais</td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_salario_base))?></td>
        <td align="right">&nbsp;</td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_horas_extras_horas50))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_horas_extras_valor50))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_horas_extras_horas100))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_horas_extras_valor100))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_noturno))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_dsr))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_comissao))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_dsr_comissao))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_gratificacao))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_periculosidade))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_insalubridade))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_salario_familia_qtd))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_salario_familia_valor))?></td>
        
        <td align="right"><?=moedaUsaToBR(@array_sum($total_subtotal))?></td>
        <td align="right" style="border-right:black 3px solid;"><?=moedaUsaToBR(@array_sum($total_base_calculo))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_faltas))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_faltas_valor))?></td>
         <td align="right"><?=moedaUsaToBR(@array_sum($total_porc_transporte))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_transporte_valor))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_adiantamento))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_deducao_irpf))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_deducao_inss))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_saldo))?></td>
        <td align="right"><?=moedaUsaToBR(@array_sum($total_fgts))?></td>
    </tr>
</tfoot>
</table>
</body>
</html>