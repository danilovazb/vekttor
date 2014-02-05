<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s1'>
  	RH
</a>
<a href="?" class='s1'>
  	Relatórios
</a>
<a href="?tela_id=577" class='s2'>
  	Relatório de Faltas
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<style>
.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}
</style>

<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" /><input type="hidden" name="empresa1id" value="<?=$_GET['empresa1id']?>" />
   
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info"> 
<form style="float:left;">
<label>
	<input type="text" />
</label>
</form>   
	<button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" onclick="window.open('modulos/tela_impressao.php?url=')" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
  </div>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->

 <div id="info_filtro">
 	<?=date('d/m/Y')?>

 	<div style="clear:both"></div>
    <?=date('H:i:s')?>
 </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	
    	<tr>
        	
            <td width="250">Empresa</td>
            <td>Funcionários</td>
          	<td class="wp"></td>
			
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?
	//$empresa_id=$_GET['empresa_id'];
	if(!empty($_GET['busca'])){
		$filtro = " AND nome like '%".$_GET['busca']."%'";
	}
	if($_GET[limitador]<1){
		$_GET[limitador]	=100;
	}
	if(strlen($_GET[ordem])>0){
		$ordem = $_GET[ordem];
	}else{
		$ordem =  'razao_social';
	}
	$registros=mysql_result(mysql_query($t="SELECT COUNT(*) FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1' 
		$busca_add 
		$filtro "),0);
	$empresas= mysql_query($t="SELECT *, cf.id as cliente_forencedor_id FROM 
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
		echo mysql_error();
		$total=0;
		while($empresa=mysql_fetch_object($empresas)){
			if($total%2){$sel='class="al"';}else{$sel='';}
			$total++;
			?>
            <tr <?=$sel?> >
            	<td width="250"><?=$empresa->razao_social?></td>
                <td></td>
                <td class="wp"></td>
            </tr>
            <?
	}
?>
    	
    
</table>
<?
//print_r($_POST);
?>
</div>
<div id="total">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr <?=$sel ?>>
      		<td width="250">&nbsp;</td>
           <td>&nbsp;</td>
          	<td width="" class="wp"></td>
        </tr>
     </thead>
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
<script>
$('#sub93').show();
$('#sub418').show()
</script>