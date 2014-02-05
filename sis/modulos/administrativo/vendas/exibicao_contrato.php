

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php"); 

?>
<div id='navegacao'>
<a href="" class='s1'>
  	Sistema NV
</a>
<a href="" class='s1'>
  	Administrativo
</a>
<a href="" class="s2">
Contratos
</a>
<a href="" class="navegacao_ativo">
<span></span> Contrato Nº.<?=$contrato->id?>
</a>
</div>
<div id="barra_info"><strong>Cliente:</strong> <a href="modulos/administrativo/clientes/form.php?id=<?=$cliente->id ?>" target="carregador" title="Dados do Cliente"><?=$cliente->razao_social ?></a> <strong>Valor:</strong> R$ <?=moedaUsaToBr($contrato->valor)?> 
  <strong>Objeto:</strong> Tipo disponibilidade <?=$disponibilidade_tipo->nome?>  (<?=$disponibilidade->identificacao ?>)
   <strong>Situação:</strong> <?=$contrato->situacao ?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="60">Fatura</td>
          	<td width="90">Vencimento</a></td>
			<td width="90">Valor</td>
   		   <td width="250">Descricao</td>
   		   <td width="90">Situa&ccedil;&atilde;o </td>
            <td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <? 
	$q = mysql_query("SELECT * FROM faturas WHERE contrato_id='$_GET[id]' ORDER BY data_vencimento ");
	while($r=mysql_fetch_object($q)){
	?>
    	<tr onclick="window.open('<?=$caminho?>form_fatura.php','carregador')">
            <td width="60"><?=$r->id?></td>
          	<td width="90"><?=$r->data_vencimento ?></td>
			<td width="90" style="text-align:right; padding:0 5px 0 5px;"><?=$somatorio[]=$r->valor?></td>
     		<td width="250"><?=$r->descricao?></td>
     		<td width="90"><?=$r->situacao?></td>
            <td width=""></td>
        </tr>
<?
	}
?>
    </tbody>
</table>
<?
echo "<pre>";
print_r($_POST);
echo "</pre>";
?>

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="60">&nbsp;</td>
       	  <td width="90">&nbsp;</td>
			<td width="90" style="text-align:right; padding:0 5px 0 5px;"><?=@array_sum($somatorio)?></td>
      		<td width="250">&nbsp;</td>
      		<td width="90">&nbsp;</td>
            <td width=""></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>

<input name="action" type="button"  value="Cancelamento" style=""  />
<input name="action" type="button"  value="Tranferencia de Crédito" />
<input name="action" type="button"  value="Tranferencia de Titularidade" />

  <input type="button" value="Contrato" style="float:right; margin:3px 3px 0 0 ;" onclick="window.open('<?=$caminho?>/contrato.php?id=<?=$_GET[id]?>','_BLANK')" />
</div>
</div>
