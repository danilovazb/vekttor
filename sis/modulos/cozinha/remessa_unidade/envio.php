<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
$tela_id=$tela->id;

?>
<script>

$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
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
<a href="./" class='s1'>
  	Cozinha 
</a>
<a href="../remessa_unidade/?tela_id=114" class='s2'>
    Envio de Remessa
</a>
<a href="../remessa_unidade/?tela_id=115" class="navegacao_ativo">
<span></span>    <?=$tela->nome?>
</a>
</div>
<div id="barra_info">
   
<form method="get">
Filtrar:
    
      
  
    <input type="hidden" name="tela_id" value="52" />
    Inicio
    <?
    if(empty($_GET[filtro_inicio])&&empty($_GET[filtro_fim])){
		$filtro_inicio 	= date("Y-m-").'01';
		$filtro_fim		= date("Y-m-t");
		
	}else{
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
	}
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
	
	?>
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    
     Fim
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
    <? if($tela_id=='115'){ ?>
    <label>Unidade:
        <select name="forma_pagamento">
          <option value="0" >Contrato Evadin</option>
            <option value="1"  >Unidade Y</option>
            <option value="2">Unidade Z</option>
            <option value="3">Unidade A</option>
            <option value="4" >Unidade B</option>
            <option value="5">Unidade C</option>
            <option value="6">Unidade D</option>
        </select>
    </label>
    <? } ?>
    </label>
    <label>
	<input name="action" type="button" value="Enviar" style="margin:3px; float:right" onclick="location='?tela_id=115'" />
	<input name="action" type="button" value="Salvar" style="margin:3px; float:right" onclick="location='?tela_id=115'" />
    </label>
<label>
	<input name="action" type="button" value="Imprimir" style="margin:3px; float:right" onclick="window.open('modulos/cozinha/remessa_unidade/impressao_pedido.php')"  />
</label>

</form>
	
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><?=linkOrdem("Produto.","nome",1)?></td>
          	<td width="100">Em Estoque</td>
            <td width="80">Necessidade</td>
            <td width="80">Estoque Min</td>
            <td width="80">Qtd Cotacao</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
	
    	<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
            <td width="150">Pão</td>
          	<td width="100">5kg</td>
            <td width="80">10kg</td>
            <td width="80">10kg</td>
            <td width="80" align="left"><input type="text" style=" width:50px; height:10px;" value="5" />kg</td>
            <td></td>
        </tr>
        <tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
            <td width="150">Carne</td>
          	<td width="100">15kg</td>
            <td width="80">27kg</td>
            <td width="80">27kg</td>
            <td width="80" align="left"><input type="text" style=" width:50px; height:10px;" value="12" />kg</td>
            <td></td>
        </tr>
        <tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
            <td width="150">Suco de Laranja</td>
          	<td width="100">12L</td>
            <td width="80">5L</td>
            <td width="80">5L</td>
            <td width="80" align="left"><input type="text" style=" width:50px; height:10px;" value="0" />L</td>
            <td></td>
        </tr>
        <tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
            <td width="150">Pão de Queijo</td>
          	<td width="100">100un</td>
            <td width="80">320un</td>
            <td width="80">320un</td>
            <td width="80" align="left"><input type="text" style=" width:50px; height:10px;" value="220" />un</td>
            <td></td>
        </tr>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><a>Total: <?=$total?></a></td>
            <td width="400">&nbsp;</td>
            <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	<input name="action" type="submit" value="Gerar Cotação de acordo com essa necessidade" style="margin:3px; float:right"  />

</div>
