<?php  

?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s1'>
  	Estoque
</a>
<a href="?tela_id=45" class='s2'>
  	Cotação
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span> Cotação Produto
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
</script>
<div id="barra_info">

<form method="get">
<input type="hidden" name="tela_id" value="118" />

<!-- select na tabela projetos -->
<select name="projeto_id" id='projeto_id' >
<option value="0">Grupo Produto</option>
<option value="0">Proteina</option>
<option value="0">Secos</option>
<option value="0">Descartaveirs</option>
<option value="0">Temperos</option>
</select>

<!-- select na tabela projetos_atividades_tipos -->
<select name="tipo_atividade_id" id='tipo_atividade_id' >
<option value="0"> Fornecedor </option>
<option value="0"> Friler </option>
<option value="0"> Makro </option>
<option value="0"> Attak </option>
<option value="0"> Nova Era </option>
<option value="0"> Casa da Carne </option>
<option value="0"> Atacadão X</option>

</select>
<input type="submit" value="Cotar no fornecedor" name="filtrar" />
<input type="submit" value="Filtar" name="filtrar2" />
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%" style="overflow:auto;" >
<thead>
    	<tr>
          <td width="200"><?=linkOrdem("Produto","nome",1)?></td>
          <td width="35">QTD</td>
          <td width="50">R$</td>
          <td width="50">Valor 1</td>
          <td width="120">Fornecedor 1</td>
          <td width="60">Valor 2</td>
          <td width="120">Fornecedor 2</td>
          <td width="60">Valor 3</td>
          <td width="120">Fornecedor 3</td>
          <td>&nbsp;</td>
        </tr>
    </thead>
</table>
<div id='dados' style="overflow:auto;">

<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" style="overflow:auto;">
	<tbody>
   		<tr>
          <td width="200"> Arroz </td>
          <td width="35">35</td>
          <td width="50" >1,50</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px;"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f1">Macro</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f2">Atack</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f3">Friler</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="200">Café</td>
          <td width="35">35</td>
          <td width="50">1,50</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f1">Pao e Companhia</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f2">Comercial Legal</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f3">Friler</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="200"> Macarrao </td>
          <td width="35">35</td>
          <td width="50">1,50</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f1">Comercial Legal</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f2">Local WEB</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f3">Friler</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="200"> Leite </td>
          <td width="35">35</td>
          <td width="50">1,50</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f1">Local WEB</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f2">Macro</td>
          <td width="50" style="" class="tn"><input type="text" value="2,50"  style="width:35px; height:12px"/></td>
          <td width="120" style="" class="tn"><input type="radio" name="f3">Friler</td>
          <td>&nbsp;</td>
        </tr>
     </tbody>
</table>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->

</div>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="200">Total</td>
          <td width="35">&nbsp;</td>
          <td width="50">&nbsp;</td>
          <td width="50">3.045,00</td>
          <td width="120">&nbsp;</td>
          <td width="60">3.045,00</td>
          <td width="120">&nbsp;</td>
          <td width="60">3.045,00</td>
          <td width="120">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
    </thead>
</table>
</div>

<div id='rodape'>
<input type="submit" value="Criar pedidos de compras por fornecedor" name="" style="margin-top:3px;" />
	
</div>
