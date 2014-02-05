<?
include('../../../_config.php');
include('../../../_functions_base.php');
include("_functions.php");
include("_ctrl.php");

?>

Procedimentos Aprovados

<table cellpadding="0" cellspacing="0" style=" background:white;" width="100%">
<thead>
    <tr>
        <td width="200">Procedimento</td><td>Dente</td><td>Situa&ccedil;&atilde;o</td>
    </tr>
</thead>
<tbody>

<?

$status[1]='<span style="color:#CC0">Em andamento</span>';
$status[0]='<span style="color:black">Pendente</span>';
$status[2]='<span style="color:green">Conclu&iacute;do</span>';
$atendimento_id=$_GET['atendimento_id'];
$consulta_id=$_GET['consulta_id'];
/*
if($consulta_id>0){
	?>
    <script>top.document.getElementById('concluir_consulta').style.display='block'</script>
    <?
}else{
	?>
	<script>top.document.getElementById('concluir_consulta').style.display='none'</script>
	
	<?
}
*/
$proc_aprovados_q=mysql_query("SELECT * FROM odontologo_atendimento_item WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento_id' AND aprovado='1' AND status!='2'");
if(mysql_num_rows($proc_aprovados_q)<1){
?>
<tr><td colspan="3">( Aprove um procedimento para incluir na consulta )</td></tr>
<script>/*top.document.getElementById('concluir_consulta').style.display='none'*/</script>
<?
}else{
while($aprov=mysql_fetch_object($proc_aprovados_q)){
	$i++; if($i%2){$f="class='al'";}else{$f='';}
    $servico=mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE vkt_id='$vkt_id' AND id='$aprov->servico_id'"));
?>
    <tr <?=$f?> onclick="abreConsultasProcedimento('<?=$aprov->id?>','<?=utf8_encode($servico->nome)?>','<?=$aprov->dente_id?>')">
        <td width="200">
			<?=utf8_encode($servico->nome)?><input type="hidden" name="procedimento_aprovado_item_id" />
        </td>
        <td>
        	<?=$aprov->dente_id?> - <?=$face[$aprov->face_id]?>
        </td>
        <td style="color:">
	        <?=$status[$aprov->status]?>
        </td>
    </tr>
<? } 

}?>
</tbody>
<tfoot>
    <tr>
        <td colspan="3"></td>
    </tr>
</tfoot>
</table>