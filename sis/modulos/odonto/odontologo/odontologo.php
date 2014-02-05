<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
//echo $vkt_id;
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$('#f_nome_contato').live('keyup',function(){
	$("#nome_usuario").val($(this).val());
});
</script>
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
<a href="#" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Ondontologo 
</a>
<a href="#" class="navegacao_ativo">
<span></span>  <?=$tela->nome?>
</a>
</div>
<div id="barra_info">
       
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">Codigo</td>
            <td width="230"><?=linkOrdem("Nome","nome_fantasia",1)?></td>
          	<td width="130"><?=linkOrdem("CPF","cnpj_cpf",0)?></td>
          	<td width="110"><?=linkOrdem("Telefone","telefone1",0)?></td>
          	<td width="80"><?=linkOrdem("Tipo","tipo_cadastro",0)?></td>
			<td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
		odontologo_odontologo oc,
		cliente_fornecedor cf
		WHERE
		oc.cliente_fornecedor_id = cf.id AND
		oc.vkt_id = '$vkt_id'
		$busca_add $filtro"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome_fantasia";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query($t="SELECT *,oc.id as oc_id, cf.id as cf_id FROM 
		odontologo_odontologo oc,
		cliente_fornecedor cf
		WHERE
		oc.cliente_fornecedor_id = cf.id AND
		oc.vkt_id = '$vkt_id'
		$busca_add $filtro ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>/form.php?id=<?=$r->oc_id?>','carregador')">
<td width="50" align="right"><?=str_pad($r->id,5,"0",STR_PAD_LEFT)?></td>
<td width="230"><?=$r->nome_fantasia?></td>
<td width="130"><?=$r->cnpj_cpf?></td>
<td width="110"><?=$r->telefone1?></td>
<td width="80"><?=$r->tipo_cadastro?></td>
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
           <td width="230"><a>Total: <?=$total?></a></td>
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
