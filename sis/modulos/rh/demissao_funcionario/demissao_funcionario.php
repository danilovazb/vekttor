<?
include("_functions.php");
include("_ctrl.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>

<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	RH
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
	SELECIONE UMA EMPRESA
 
  </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">Codigo</td>
            <td width="230">Razao Social</td>
          	<td width="130">CNPJ</td>
          	<td width="110">Qtd. Funcionários</td>
            <td width="110">Func. Demitidos</td>
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
	
	$filtro = '';
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="cf.nome_fantasia";
	}
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1'"),0,0);
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, cf.id as cliente_fornecedor_id FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1' 
		$busca_add 
		$filtro 
		ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
			$qtd_func = mysql_num_rows(mysql_query($t="
		SELECT 
			* 
		FROM 
			rh_funcionario 
		WHERE 
			empresa_id='$r->id' AND
			status = 'admitidos' AND
			vkt_id='$vkt_id'
			"));
			
		//quantidade funcionários demitidos
			$qtd_func_demitidos = mysql_num_rows(mysql_query($t="
		SELECT 
			* 
		FROM 
			rh_funcionario 
		WHERE 
			empresa_id='$r->id' AND
			status = 'demitidos' AND
			vkt_id='$vkt_id'
			"));
				
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="location.href='?tela_id=427&empresaid=<?=$r->cliente_fornecedor_id?>'">
<td width="50" align="right"><?=str_pad($r->cliente_fornecedor_id,5,"0",STR_PAD_LEFT)?></td>
<td width="230"><?=$r->razao_social?></td>
<td width="130"><?=$r->cnpj_cpf?></td>
<td width="110"><?=$qtd_func?></td>
<td width="110"><?=$qtd_func_demitidos?></td>
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