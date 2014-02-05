<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
//include("../../../_config.php");
//include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php"); 
?>
<script>

$(document).ready(function(){
	$("#tabela_dados tr.produtos_tabela:nth-child(2n+1)").addClass('al');
})

function o1(id,t){
//	alert(t.checked);
	if(t.checked){	
			window.open('<?=$caminho?>atualiza_fornecedor.php?fornecedor_id=<?=$_GET['fornecedor_id']?>&acao=desabilita&produto_id='+id,'carregador');
	}else{

			window.open('<?=$caminho?>atualiza_fornecedor.php?fornecedor_id=<?=$_GET['fornecedor_id']?>&acao=habilita&produto_id='+id,'carregador');
	}
}
</script>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form style="display:none;" action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span>    Produtos por Fornecedor 
</a>
</div>
<div id="barra_info">
  <form>
    <label>
    <select name="fornecedor_id" id="fornecedor_id" onchange="this.form.submit();" method="GET">
    <option>- Escolha um Fornecedor -</option>
        <?
			$fornecedor_q=mysql_query($t="SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND tipo='Fornecedor'");
			while($fornecedor=mysql_fetch_object($fornecedor_q)){
			if($_GET['fornecedor_id']==$fornecedor->id){$sel='selected="selected"';}else{$sel='';}
		?>
			<option <?=$sel?> value="<?=$fornecedor->id?>"><?=$fornecedor->razao_social?></option>
            
		<? 
		} ?>
    </select>
    <input name='tela_id' value="108" type="hidden" />
    </label>
  </form>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="50"></td>
        	<td width="150">Fornecedor</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->

<?
if($_GET['fornecedor_id']>0){
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="tabela_dados">
    <? 
	$grupo='0';
	$registros=mysql_result(mysql_query("SELECT COUNT(*) FROM produto WHERE vkt_id='$vkt_id' ORDER BY produto_grupo_id,nome ASC"),0,0);
	
	$produto_q=mysql_query("SELECT * FROM produto WHERE vkt_id='$vkt_id' ORDER BY produto_grupo_id,nome ASC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	echo mysql_error();
	while($produto=mysql_fetch_object($produto_q)){
	if($produto->produto_grupo_id!=$grupo){
		$grupo=$produto->produto_grupo_id;
		$grupo_nome=mysql_fetch_object(mysql_query("SELECT * FROM produto_grupo WHERE id='{$produto->produto_grupo_id}' AND vkt_id='$vkt_id'" ));
	?>
    <tr>
    		<td colspan="7" style="background-color:#999; color:white;"><?=$grupo_nome->nome;?> <?=$produto->produto_grupo_id?></td>
    </tr>
    <?
		}
		if($_GET['fornecedor_id']!=0){
			$fornecedor_has_produto = mysql_fetch_object(mysql_query("SELECT * FROM produto_has_fornecedor WHERE fornecedor_id='{$_GET['fornecedor_id']}' AND produto_id='{$produto->id}' AND vkt_id='$vkt_id'"));
		}
	?>
    <tr class="produtos_tabela">
        <td width="50"><input class="produto_fornecedor" value="<?=$produto->id?>" type="checkbox"<? if(!empty($fornecedor_has_produto->id)){ echo "checked=checked";}?> onclick="o1(<?=$produto->id?>,this)" /></td>
        <td width="150"><?= $produto->nome;?></td>
        <td></td>
    </tr>
    <? } ?>
    </tbody>
</table>
<?
}
?>
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&fornecedor_id=<?=$_GET[fornecedor_id]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
        
  </select>
  
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('fornecedor_id'=>$_GET[fornecedor_id]))?>
    </div>
</div>
