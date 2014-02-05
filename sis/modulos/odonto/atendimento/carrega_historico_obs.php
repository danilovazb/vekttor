<?
include('../../../_config.php');
include('../../../_functions_base.php');
include("_functions.php");
include("_ctrl.php");
$atendimento_id=$_GET['atendimento_id'];
$procedimento_id=$_GET['procedimento_id'];
?>
<div style=" background:rgb(237, 237, 237)"><?=urldecode($_GET['servico']).' - dente: '.$_GET['dente_id']?></div>
<table cellpadding="0" cellspacing="0" style="background:white;">
    <thead>
        <tr>
        	<td style="padding:0" width="20"></td>
            <td width="60">Data</td>
            <td width="300">Obs</td>
        </tr>
    </thead>
    <tbody>
    <?
	$consultas_q=mysql_query($a="
	SELECT c.data as data, o.obs as obs, c. status as status ,o.id as id
	FROM 
		odontologo_consulta_has_odontologo_atendimento_item as o, 
		odontologo_consultas as c
	WHERE 
		o.odontologo_atendimento_item_id='$procedimento_id' 
	AND 
		o.odontologo_consulta_id=c.id 
	AND 
		c.odontologo_atendimento_id='$atendimento_id' 
	ORDER BY c.data DESC ");
	echo mysql_error();
	$i=0;
	while($c=mysql_fetch_object($consultas_q)){
		$i++;
		if($i%2){$al="class='al'";}else{$al='';}
	?>
        <tr <?=$al?>><td align="center" style="padding:0; color:red;" width="20" ><a href="#" style="color:red; font-weight:bold; text-decoration:none;" onclick="excluirConsultaProcedimento(<?=$c->id?>,this)">X</a></td><td><?=dataUsaToBr($c->data)?></td><td align="left"><?=utf8_encode($c->obs)?></td></tr>
    <? } ?>
    </tbody>
</table>