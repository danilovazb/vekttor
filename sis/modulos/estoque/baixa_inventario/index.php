<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

?>
<script>

$(document).ready(function(){
	$("#tabela_dados tr.produtos_tabela:nth-child(2n+1)").addClass('al');
})
</script>

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
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s2'>
    Estoque 
</a>
<a href="?tela_id=42" class="navegacao_ativo">
<?
$obra=mysql_fetch_object(mysql_query("SELECT nome FROM empreendimento WHERE id='".$_SESSION['usuario']->obra_id."'"));
?>
<span></span>    Inventário	<? echo "- "; if($obra->nome)echo $obra->nome; else echo "Central"; ?>
</a>
</div>
<form action="" method="post">
<div id="barra_info">
	<div style="padding:2px; width:120px; float:left;">
	<select name="projeto_id" id='projeto_id' >
		<option value="0">Selecione Filial</option>
		<option value="und1">Unidade 1 </option>
        <option value="und2">Unidade  </option>
	</select>
    </div>
    <input name="action" type="submit" value="Salvar" style="margin:3px; float:right" />	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="50"><?=linkOrdem("ID","id",1)?></td>
          	<td width="150"><?=linkOrdem("Nome","nome",0)?></td>
          	<td width="100"><a>Estoque</a></td>
			<td width="100"><a>Atualizar QTD.</a></td>
			<td width="100">Diferen&ccedil;a</td>
            <td width="100"><a>Unidade</a></td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="tabela_dados">
	<tr>
    	<td colspan="7" style="background-color:#999; color:white;">Proteina</td>
    </tr>
	   	<tr class="produtos_tabela">
            <td width="50" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">5</td>
          	<td width="150" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Maminha</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
			<td width="100" align="center">
				<input name="produto_id[]" type="hidden" value="<?=$r->id?>" />
				<input name="nova_qtd[]" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" />
			</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
            <td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
            <td></td>
        </tr>
        <tr class="produtos_tabela">
            <td width="50" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">9</td>
          	<td width="150" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Fraldinha</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
			<td width="100" align="center">
				<input name="produto_id[]" type="hidden" value="<?=$r->id?>" />
				<input name="nova_qtd[]" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" />
			</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
            <td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
            <td></td>
        </tr>
        <tr class="produtos_tabela">
            <td width="50" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">12</td>
          	<td width="150" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Picanha</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
			<td width="100" align="center">
				<input name="produto_id[]" type="hidden" value="<?=$r->id?>" />
				<input name="nova_qtd[]" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" />
			</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
            <td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
            <td></td>
        </tr>
        <tr>
          <td colspan="7" style="background-color:#999; color:white;">Secos</td>
        </tr>
        <tr class="produtos_tabela">
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">10</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Arroz</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
          <td align="center"><input name="produto_id[]2" type="hidden" value="<?=$r->id?>" />
            <input name="nova_qtd[]2" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" /></td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
          <td></td>
        </tr>
        <tr class="produtos_tabela">
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">13</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Feij&atilde;o</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
          <td align="center"><input name="produto_id[]2" type="hidden" value="<?=$r->id?>" />
            <input name="nova_qtd[]2" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" /></td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
          <td></td>
        </tr>
        <tr class="produtos_tabela">
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">10</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Macarr&atilde;o</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
          <td align="center"><input name="produto_id[]2" type="hidden" value="<?=$r->id?>" />
            <input name="nova_qtd[]2" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" /></td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
          <td></td>
        </tr>
        <tr class="produtos_tabela">
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">13</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Trigo</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
          <td align="center"><input name="produto_id[]2" type="hidden" value="<?=$r->id?>" />
            <input name="nova_qtd[]2" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" /></td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
          <td></td>
        </tr>
        <tr class="produtos_tabela">
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">10</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">A&ccedil;ucar</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
          <td align="center"><input name="produto_id[]2" type="hidden" value="<?=$r->id?>" />
            <input name="nova_qtd[]2" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" /></td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
          <td></td>
        </tr>
        <tr class="produtos_tabela">
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">13</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Caf&eacute;</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
          <td align="center"><input name="produto_id[]2" type="hidden" value="<?=$r->id?>" />
            <input name="nova_qtd[]2" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" /></td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
          <td onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
          <td></td>
        </tr>
	<tr>
    	<td colspan="7" style="background-color:#999; color:white;">Temperos</td>
    </tr>
    <tr class="produtos_tabela">
            <td width="50" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">10</td>
          	<td width="150" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Cabeça</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
			<td width="100" align="center">
				<input name="produto_id[]" type="hidden" value="<?=$r->id?>" />
				<input name="nova_qtd[]" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" />
			</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
            <td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
            <td></td>
        </tr>
        <tr class="produtos_tabela">
            <td width="50" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">13</td>
          	<td width="150" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Lombo</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">30</td>
			<td width="100" align="center">
				<input name="produto_id[]" type="hidden" value="<?=$r->id?>" />
				<input name="nova_qtd[]" type="text" value="" maxlength="23" decimal="2" sonumero="1" style="width:60px; height:10px;  text-align:right" />
			</td>
			<td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">&nbsp;</td>
            <td width="100" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">Kg</td>
            <td></td>
        </tr>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="50"><a>Total: <?=$total?></a></td>
            <td width="150">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="165">&nbsp;</td>
            <td></td>
      </tr>
    </thead>
</table>
</form>

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
