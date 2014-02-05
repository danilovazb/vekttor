<?
include('../../../_config.php');
include('../../../_functions_base.php');
include("_functions.php");
include("_ctrl.php");
$atendimento_id=$_GET['atendimento_id'];
?>
 <div id="procedimentos_novos" style="width:310px; margin-left:10px; margin-bottom:10px; float:left; height:200px; overflow:auto; position:relative;">
<table cellspacing="0" cellpadding="0" style="background:white;">
<thead>
    <tr><td></td><td>Dente</td><td width="200">Procedimentos</td><td width="50">Valor</td></tr>
</thead>
<!-- os itens serão colocados via AJAX no formulário extra q tem nesse fieldset no começo -->
<tbody>
<?  $aprovado[1]="checked='checked'";
    $procedimentos_novos_q=mysql_query("SELECT * FROM odontologo_atendimento_item WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento_id' AND status!='2' "); 
    while($proc=mysql_fetch_object($procedimentos_novos_q)){
    $i++; if($i%2){$f="class='al'";}else{$f='';}
	if($proc->aprovado==1){$dis='disabled="disabled"';}else{$dis='';}
    $servico=mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id = '$proc->servico_id' "));
    $total[]=$proc->valor;
	$dente[$proc->dente_id]=$proc->dente_id;
?>
    <tr <?=$f?> >
        <td style="padding:0;">
        	<input title="Aprovar procedimento" rel='tip' data-placement='right' <?=$aprovado[$proc->aprovado]?> onclick="manipulaAprovacao(this)" value="<?=$proc->id?>" type="checkbox" />
        </td>
        <td onclick="abreAnalise(<?=$proc->id?>,'novo','<?=$proc->dente_id?>')">
        	<?=$proc->dente_id?>(<?=$face[$proc->face_id]?>)
        </td>
        <td width="300" onclick="abreAnalise(<?=$proc->id?>,'novo','<?=$proc->dente_id?>')">
			 <?=utf8_encode($servico->nome)?>
        </td>
        <td width="50" align="center">
        	<input type="text" id="<?=$proc->id?>" <?=$dis?> class="preco_procedimento" onblur="manipulaPreco(this)" value="<?=moedaUsaToBR($proc->valor)?>" style="height:12px;width:40px;" sonumero="1" />
        </td>
    </tr>
<?
    }
	$dente_proc=@array_keys($dente);
	$dente_proc=@implode('|',$dente_proc);
	
?>                    
    </tbody>
    <tfoot id="footer" dentes='<?=$dente_proc?>'>
        <tr><td colspan="3"></td><td id="total_preco_procedimentos"><?=moedaUsaToBR(@array_sum($total))?></td></tr>
    </tfoot>
</table>
</div>

<div id="procedimentos_passados" style="width:310px; margin-left:10px; float:left; height:220px;overflow:auto;">
<table cellspacing="0" cellpadding="0" style="background:white;" width="100%">
<thead>
    <tr><td>Procedimentos passados</td></tr>
</thead>
<tbody>
<? 
    $procedimentos_novos_q=mysql_query("SELECT * FROM odontologo_atendimento_analise WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento_id'"); 
    while($proc=mysql_fetch_object($procedimentos_novos_q)){
        $i++; if($i%2){$f="class='al'";}else{$f='';}
    $servico=mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id = '$proc->servico_id' "));
	$dente[$proc->dente_id]=$proc->dente_id;
?>
    <tr <?=$f?> >
         <td width="200" onclick="abreAnalise(<?=$proc->id?>,'passado','<?=$proc->dente_id?>')"><?=$proc->dente_id?>(<?=$face[$proc->face_id]?>) - <?=utf8_encode($servico->nome)?></td>
    </tr>
<?
    }
?>
    </tbody>
    <tfoot>
        <tr><td>&nbsp;</td></tr>
    </tfoot>
</table>
</div>