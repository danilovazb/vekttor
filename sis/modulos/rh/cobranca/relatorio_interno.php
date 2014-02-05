<?
include("_functions.php");
include("_ctrl.php"); 


?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some"><<</div>

<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s1'>
  	RH
</a>
<a href="?" class='s2'>
  	Cobranca
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">
   <strong>Ano:</strong><?=$_GET['ano']?>  <strong>Mes:</strong><?=mes($_GET['mes'])?> <strong>Situaçao:</strong><? if($_GET['situacao']=='1'){ echo "Pago";}else{echo "Nao Pago";}?>
  </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200">Empresa</td>
            <td width="120">Data de Vencimento</td>
          	<td width="110">Valor</td>
                                  	
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
			
		$valor_total= mysql_query($t="SELECT * FROM 
		rh_cobranca_empresas rc,
		cliente_fornecedor cf
		WHERE 
		rc.cliente_fornecedor_id = cf.id AND
		MONTH(rc.data_vencimento)='".$_GET['mes']."' AND
		YEAR(rc.data_vencimento)='".$_GET['ano']."' AND
		rc.situacao ='".$_GET['situacao']."' AND
		rc.vkt_id ='$vkt_id' 
		");
		
		//echo $t." ".mysql_error()."<br>";
		while($valor = mysql_fetch_object($valor_total)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
	?>
<tr <?=$sel?>>
   <td width="200"><?=$valor->razao_social?></td>
            <td width="120"><?=DataUsaToBr($valor->data_vencimento)?></td>
          	<td width="110"><?=MoedaUsaToBr($valor->valor)?></td>
<td></td>
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
           <td width="50">&nbsp;</td>
           <td width="230"><a></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

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
<script>
$('#sub93').show();
$('#sub428').show();
</script>