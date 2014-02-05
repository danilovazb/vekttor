<?php
?>
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
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s2'>
  	Estoque
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span> Cota&ccedil;&atilde;o
</a>
</div>
<style type="text/css" media="all">
thead tr th {text-align:center;border-bottom: 2px solid #999;}
tr th {padding: 1px 6px;font-size: 0.9em;} 
tfoot tr td {text-align:center;border-top: 2px solid #999;}
tr.sub {background:#999;color:#FFF;}
#row{font-weight:500;}
#prod{text-align:left;}
#tabela_dados{ overflow:auto;}
</style>
<script>
$(document).ready(function(){
	$('table#tabela_dados tbody tr:odd').addClass('al');
	//------------------------------------------------
	 
  	$("table .tn").mouseover(function() {
    	$('table .tn').css('color','#000');
  	}).mouseout(function(){
    	$('table .tn').css('color','');
  	});
	
})
/*$("#tabela_dados tr").live("click",function(){
	var atividade_id = $(this).attr('id');
	
	window.open('<?=$tela->caminho?>/cotacao_produto.php','conteudo_modelo');
});*/
</script>
<div id="barra_info">

<form method="get">
<input type="hidden" name="tela_id" value="96" />

<label>Data Inicio
          <input name="data_inicio" id="data_inicio" style="width:100px;" mascara='__/__/____' calendario='1' />
</label>

<!-- select na tabela projetos_atividades_tipos por status -->
<label>Data Fim
          <input name="data_fim" id="data_fim" style="width:100px;" mascara='__/__/____' calendario='1' />
</label>
<input type="submit" value="Filtar" name="filtrar">
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="80">N&ordm; da Cota&ccedil;&atilde;o</td>
          <td width="150">Dias de Necessidade</td>
          <td width="80">Data</td>
          <td>Fornecedores</td>
        </tr>
    </thead>
</table>
<div id='dados' >

<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" style="overflow:auto;">
	<tbody>
   		<tr onclick="location.href='?tela_id=118'">
          <td width="80">12345</td>
          <td width="150">01/02/2012 a 30/01/2012</td>
          <td width="80">01/01/2012</td>
          <td>5</td>
        </tr>
        <tr onclick="location.href='?tela_id=118'">
          <td width="80">12333</td>
          <td width="150">01/03/2012 a 30/03/2012</td>
          <td width="80">01/02/2012</td>
          <td>6</td>
        </tr>
     </tbody>
</table>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->

</div>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="80">&nbsp;</td>
          <td width="35">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
