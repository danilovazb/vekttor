<?

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>


<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s2'>
  	Projetos
</a>
<a href="?tela_id=92" class='navegacao_ativo'>
<span></span>    Atividades
</a>
</div>
<div id="barra_info">    
  <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a></div>
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
	
	
	?>      
    	<tr <?=$sel?> >
          	<td width="209" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')"><?=$r->nome?></td>
          	<td width="98" align="right"><?=number_format($totals->entrada,2,',','.')?></td>
       	  <td width="98" align="right"><?=number_format($totals->saida,2,',','.')?></td>
       	  <td width="98" align="right" onclick="location='?tela_id=54&conta_id=<?=$r->id?>&mes_i=<?=$mes_b?>&ano_i=<?=$ano_b?>&mes_f=<?=$mes_b?>&ano_f=<?=$ano_b?>'" title="Ver Movimentação"><?=number_format($ultimo_saldo->saldo,2,',','.')?></td>
          	<td></td>
        </tr>
<?
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
