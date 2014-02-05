<?
$caminho =$tela->caminho; 
include("_functions.php"); 
include("_ctrl.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>

<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>

<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
</div>
<div id="barra_info">    
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="300"><?=linkOrdem("Formas de Pagamento","nome",1)?></td>	
            <td width="100"><?=linkOrdem("% desconto","valor_percentual",1)?></td>	
            <td width="100"><?=linkOrdem("Desconto fixo","valor_fixo",1)?></td>	
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	// colocar a funcao da paginação no limite
	$q= mysql_query($a="SELECT * FROM financeiro_formas_pagamento WHERE vkt_id='$vkt_id' ORDER BY ".$ordem." ".$ordem_tipo." ");
	while($forma_pagamento=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
	
	?>      
    	<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$forma_pagamento->id?>','carregador')" <?=$sel?>>
          	<td width="300" ><?=$forma_pagamento->nome?></td>
            <td width="100"><?=moedaUsaToBr($forma_pagamento->valor_percentual)?></td>
            <td width="100"><?=moedaUsaToBr($forma_pagamento->valor_fixo)?></td>
          	<td></td>
        </tr>
<?
	}
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
            <td width="300"align="right"></td>
            <td width="100"align="right"></td>
            <td width="100"align="right"></td>
          	<td width=""></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	
</div>
