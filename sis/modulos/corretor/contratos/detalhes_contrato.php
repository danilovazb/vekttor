

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php"); 
include("_functions_fatura.php");
include("_ctrl_fatura.php"); 

	if(isset($_GET['status'])){
		echo $_GET['status'];	
	}
?>
<script>
$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<div id="result_contrato"></div>
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
<span></span> Contrato No.<?=$contrato->id?>
</a>
</div>
<div id="barra_info"><strong>Cliente:</strong> <a href="modulos/administrativo/clientes/form.php?id=<?=$cliente->id ?>" target="carregador" title="Dados do Cliente"><?=$cliente->razao_social ?></a> <strong>Valor:</strong> R$ <?=moedaUsaToBr($contrato->valor)?> 
  <strong>Objeto:</strong> Tipo disponibilidade <?=$disponibilidade_tipo->nome?>  (<?=$disponibilidade->identificacao ?>)
   <strong>Situaç&#259;o:</strong> <?=$contrato->situacao ?>
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
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?php 
	$q = mysql_query("SELECT * FROM faturas_comissao WHERE contrato_id='$_GET[id]' ORDER BY data_vencimento ");
	while($r=mysql_fetch_object($q)){
	?>
    	<tr style=" cursor:pointer;">
            <td width="60"><?=$r->id?></td>
          	<td width="90"><?=dataUsaToBr($r->data_vencimento) ?></td>
			<td width="90" style="text-align:right; padding:0 5px 0 5px;"><?=moedaUsaToBr($somatorio[]=$r->valor)?></td>
     		<td width="250"><?=$r->descricao?></td>
     		<td width="90"><?=$situacao[$r->situacao]?></td>
            <td width=""></td>
        </tr>
<?
	}
?>
    <?php 
	$q = mysql_query("SELECT * FROM faturas WHERE contrato_id='$_GET[id]' ORDER BY data_vencimento ");
	while($r=mysql_fetch_object($q)){
	?>
    	<tr style=" cursor:pointer;" onclick="window.open('<?=$caminho?>form_fatura.php?id_fatura=<?=$r->id?>','carregador')">
            <td width="60"><?=$r->id?></td>
          	<td width="90"><?=dataUsaToBr($r->data_vencimento) ?></td>
			<td width="90" style="text-align:right; padding:0 5px 0 5px;"><?=moedaUsaToBr($somatorio[]=$r->valor)?></td>
     		<td width="250"><?=$r->descricao?></td>
     		<td width="90"><?=$situacao[$r->situacao]?></td>
            <td width=""></td>
        </tr>
<?
	}
?>
    </tbody>
</table>


</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="60">&nbsp;</td>
       	  <td width="90">&nbsp;</td>
			<td width="90" style="text-align:right; padding:0 5px 0 5px;"><?=moedaUsaToBr(@array_sum($somatorio))?></td>
      		<td width="250">&nbsp;</td>
      		<td width="90">&nbsp;</td>
            <td width=""></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>

<input name="action" type="button"  value="Tranferencia de Crédito" />
<input name="action" type="button"  value="Tranferencia de Titularidade" />
    	
    
  <?
  	if($cliente->estado_civil=='Casado'){
		$contrato = 'contrato_casado';
	}else{
		$contrato = 'contrato_solteiro';
	}
  ?>
  <input type="button" value="Contrato" style="float:right; margin:3px 3px 0 0 ;" onclick="window.open('modulos/administrativo/contratos_admin/<?=$contrato?>.php?id=<?=$_GET[id]?>','_BLANK')" />
  <input type="button" value="Proposta" style="float:right; margin:3px 3px 0 0 ;" onclick="window.open('modulos/administrativo/contratos_admin/proposta.php?id=<?=$_GET[id]?>','_BLANK')" />
  <input type="button" value="Recibo" style="float:right; margin:3px 3px 0 0 ;" onclick="window.open('modulos/administrativo/contratos_admin/recibo.php?id=<?=$_GET[id]?>','_BLANK')" />
    <input type="button" value="Imprimir Contrato" style="float:right; margin:3px 3px 0 0 ;" onclick="window.open('modulos/corretor/contratos/impressao_contrato.php?contrato_id=<?=$_GET[id]?>','_BLANK')" />
  
 
  
</div>
</div>
