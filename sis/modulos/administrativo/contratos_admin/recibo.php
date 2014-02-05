<?
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php"); 

$contratos = mysql_query($t="
SELECT 
	c.id as id,c.nome_contato as cliente, c.naturalidade as naturalidade, c.nacionalidade as nacionalidade, c.rg as rg, c.local_emissao, 
	c.cnpj_cpf as cpf,
	c.rg as rg,
	f.valor as valor,
	f.ato_valor_parcela as ato_valor_parcela,
	d.identificacao as disponibilidade,
	e.nome as empreendimento, e.cnpj, e.tipo as tipo,
	e.administrador as responsavel,
	n.nome as negociacao,
	f.id as contrato_id
FROM
	cliente_fornecedor as c, contrato as f, disponibilidade as d, empreendimento as e, negociacao as n 
WHERE
	f.cliente_fornecedor_id=c.id AND 
	f.disponibilidade_id = d.id AND 
	f.negociacao_id=n.id AND 
	d.empreendimento_id=e.id AND 
	f.vkt_id='$vkt_id' AND
	f.id='".$id."'");
	echo mysql_error();
//echo $t;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo Vekttor</title>
<style type="text/css">
.conteudo{
	font-size:20px;
}
.titulo{
	font-size:20px;
}
p{
	line-height:30px;
}
#break{
	 page-break-after: always;
}
#cabecalho{
	height:100px;
}
</style>
</head>

<body>
<?php
	$cont=1;
	while($contrato=mysql_fetch_object($contratos)){
  		if($cont%2==0){
			echo "<div id='break'></div>";
		}
		$parcelas=mysql_result(mysql_query("SELECT COUNT(*) FROM faturas WHERE contrato_id='{$contrato->contrato_id}' AND tipo='ato'"),0,0);
		echo mysql_error();
?>
<div style="width:830px; margin:0 auto 0 auto;border:solid;"> 
	<div id="cabecalho">
    	<div id="logomarca" style="float:left;width:200px;border:solid 1px;height:100px;">
    		Logomarca
    	</div>
    	<div id="titulo" style="width:626px;border:solid 1px;float:left;height:100px;">
    		<h2><?= $contrato->empreendimento?><br>CNPJ Nº<?=" ".$contrato->cnpj?></h2>
     	</div>
    </div>
    <div class='conteudo' style="margin-top:20px;width:600px;margin-left:100px;">
    	<center><h2>RECIBO</h2>
        <br>
        <p align="justify">Recebemos do Sr(a) <strong><?= $contrato->cliente?> <?=$contrato->id?></strong>, <?=$contrato->nacionalidade?>, <?= $contrato->naturalidade?>, portador(a)
        da carteira de identidade n. <?=$contrato->rg?>, expedida pela <strong><?= $contrato->local_emissao?></strong>, e
         do CPF/MF nº <?= $contrato->cpf?>, a quantia de R$<?= number_format($contrato->ato_valor_parcela,2); ?>, em cheque do Banco
        do (Banco) de n. 1 a <?=$parcelas?> respectivamente, referente a <?= $contrato->negociacao?>
        de aquisicao de(o) <?=$contrato->tipo." ".$contrato->empreendimento." "?>, descrito em Proposta de Venda <?= $contrato->disponibilidade?>.</p>
        Manaus, <?= date("d/m/Y")?>
    ____________________________________________<br>
    <?= $contrato->responsavel?><br><?= $contrato->cnpj?></center>
    </div>
</div>
<?php
		$cont++;
	}
 ?>
</body>
</html>
