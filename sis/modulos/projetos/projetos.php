<?
// funções do modulo empreendimento
include("_function_projeto.php");
include("_ctrl_projeto.php"); 

?>
<link href="../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s1'>
    Imobili&aacute;ria 
</a>
<a href="?" class='s2'>
  	Projetos
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
</div>
<div id="barra_info">    
  <a href="<?=$tela->caminho?>form.php" target="carregador" class="mais"></a></div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
       	  <td width="150">Cliente</td>
            <td width="209"><?=linkOrdem("Nome","nome",1)?></td>
       	  <td width="50" align="right">Tempo</td>
       	  <td width="60" align="right">Entrega</td>
          	<td width="250" align="right">Descricao</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" style="overflow:auto;">
    <tbody>
	<?
	$q = mysql_query("SELECT *, TIME_FORMAT(tempo,'%H:%i') as tempo FROM projetos WHERE vkt_id='$vkt_id' AND status='em andamento' ORDER BY data_limite");
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$c = mysql_fetch_object(mysql_query("SELECT razao_social FROM cliente_fornecedor WHERE id='".$r->cliente_fornecedor_id."'"));
	
	?>      
    	<tr <?=$sel?> onclick="window.open('<?=$tela->caminho?>/form.php?id=<?=$r->id?>','carregador')" >
       	    <td width="150"><?=$c->razao_social;?> </td>
          	<td width="209"><?=$r->nome;?></td>
       	    <td width="50" align="right"><?=$r->tempo;?></td>
       	    <td width="60" align="right"><?=dataUsaToBr($r->data_limite) ;?></td>
          	<td width="250"><?=$r->descricao;?></td>
            
           
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
       	  <td width="150">&nbsp;</td>
            <td width="209">&nbsp;</td>
       	  <td width="50" align="right">&nbsp;</td>
       	  <td width="60" align="right">&nbsp;</td>
          	<td width="250" align="right">&nbsp;</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	
</div>
