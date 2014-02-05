<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s1'>
  	Eleitoral
</a>
<a href="./" class='s2'>
    Relatórios 
</a>
<a href="?tela_id=103" class="navegacao_ativo">
<span></span>Relatório do Candidato</a></div>
<div id="barra_info">
    <a href="<?=$caminho?>/form_eleitor.php" target="carregador" class="mais"></a>
    <form></form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="220">Político</td>
            <td width="80">Votos Certos</td>
            <td width="120">Votos Negativos</td>
            <td width="80">Incerto</td>
            <td width="80">Em Aberto</td>
            <td width="70">Cadastros</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id="dados">
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<?
//$eleitor_q=mysql_query("SELECT * FROM eleitoral_eleitores ");
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?
    	//$politico_q = mysql_query($trace="SELECT * FROM eleitoral_intencoes_voto WHERE politico_id=0 AND vkt_id='$vkt_id'");
		//echo $trace;
		//while($politico=mysql_fetch_object($politico_q)){
			$votoscertos = mysql_fetch_array(mysql_query($trace="SELECT COUNT(*) FROM eleitoral_intencoes_voto WHERE politico_id='0' AND status='0' AND status_voto='sim' AND vkt_id='$vkt_id'"));
			//echo $trace;
			$votosnegativos = mysql_fetch_array(mysql_query($trace="SELECT COUNT(*) FROM eleitoral_intencoes_voto WHERE politico_id='0' AND status='0' AND status_voto='nao' AND vkt_id='$vkt_id'"));
			$votosincertos = mysql_fetch_array(mysql_query($trace="SELECT COUNT(*) FROM eleitoral_intencoes_voto WHERE politico_id='0' AND status='0' AND status_voto='incerto' AND vkt_id='$vkt_id'"));
			//echo $votosincertos[0];
			$votosabertos = mysql_fetch_array(mysql_query($trace="SELECT COUNT(*) FROM eleitoral_intencoes_voto WHERE politico_id='0' AND status='0' AND status_voto='aberto' AND vkt_id='$vkt_id'"));
			$totalvotos = $votoscertos[0]+$votosnegativos[0]+$votosincertos[0]+$votosabertos[0];
			//echo "Total de votos: ".$totalvotos;
	?>
    <tr onclick="window.open('<?=$caminho?>/form_eleitor.php?id=<?=$politico_q->id?>','carregador')">
    	<td width="220"><?= ($politico->nome) ?></td>
        <td width="80"><? if($totalvotos!=0){echo ($votoscertos[0]/$totalvotos)/100;}?></td>
        <td width="120"><? if($totalvotos!=0){echo ($votosnegativos[0]/$totalvotos)/100;}?></td>
        <td width="80"><? if($totalvotos!=0){echo ($votosincertos[0]/$totalvotos)/100;}?></td>
        <td width="80"><? if($totalvotos!=0){echo (($votosabertos[0]/$totalvotos)/100);}?></td>
        <td width="70"><?= $totalvotos?></td>
        <td></td>
    </tr>
    <?
		//}
	?>
    </tbody>
</table>
</div>
</div>

<div id='rodape'>
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>