<?
include("_function_funcionario.php");
include("_ctrl_funcionario.php"); 
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
	<strong>EMPRESA:</strong> <?=$empresa->razao_social?> CNPJ:<?=$empresa->cpj_cnpj?>
  <a href="modulos/rh/funcionarios/form.php" target="carregador" class="mais"></a>
  </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"><?=linkOrdem("Funcionário","nome",1)?></td>
          	<td width="200" >Empresa</td>
            <td width="98" >Cargo</td>
       	 
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?
	
	if(!empty($_GET['busca'])){
		$filtro = " AND nome like '%".$_GET['busca']."%'";
	}
	$registros= mysql_result(mysql_query("SELECT count(*) FROM 
					  	rh_funcionario 
					  WHERE
					  	empresa_id='$empresa_id' AND 
					  	vkt_id='$vkt_id'
						$filtro"),0,0);
	$q = mysql_query($t="SELECT * FROM 
					  	rh_funcionario
					  	
					  WHERE
					   	empresa_id='$empresa_id' AND 
					  	status!='demitidos' AND
						vkt_id='$vkt_id'
						$filtro
						ORDER BY nome
						LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	echo $t;
	
	while($r=mysql_fetch_object($q)){
		$empresa = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$r->empresa->id'"));
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
	?>       
    	<tr <?=$sel ?> onclick="window.open('<?=$tela->caminho?>/form.php?id=<?=$r->id?>','carregador')" >
          	<td width="209" ><?=$r->nome?></td>
          	<td width="200" ><?=$empresa->empresa?></td>
            <td width="98" align="right"><?=$r->ocupacao?></td>
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
            <td width="209"></td>
            <td width="98"align="right"></td>
            <td width=""></td>
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
$('#sub418').show()
</script>