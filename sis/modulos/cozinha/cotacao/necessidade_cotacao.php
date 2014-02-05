<?php
	$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
	$caminho =$tela->caminho;
	include '_functions.php'; 
	include '_ctrl.php';
	 
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
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a><a href="./" class='s2'>
    Cozinha 
</a>
<a href="?tela_id=45" class='navegacao_ativo'>
<span></span> Cota&ccedil;&atilde;o
</a>
</div>
<script>
	$("#criar_cotacao").live('click',function(){
		
		var data_inicio = $("#data_inicio").val();
		var data_fim    = $("#data_final").val();
		
		location.href='?tela_id=118&acao=criar_cotacao&data_inicio='+data_inicio+'&data_fim='+data_fim;
		
	});
</script>
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

<form method="post" action="">
<input type="hidden" name="tela_id" value="45"/>

<label>Data Inicio
          <input name="data_inicio" id="data_inicio" style="width:100px;" mascara='__/__/____' calendario='1' value="<?=$_POST['data_inicio']?>"/>
</label>

<!-- select na tabela projetos_atividades_tipos por status -->
<label>Data Fim
          <input name="data_fim" id="data_fim" style="width:100px;" mascara='__/__/____' calendario='1' value="<?=$_POST['data_fim']?>"/>
</label>
<input type="submit" value="Filtrar" name="filtrar">

<a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
</form>

</div>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="120">N&ordm; da Necessidade</td>
          <td width="150">Dias de Necessidade</td>
          <td>Data da Cota&ccedil;&atilde;o</td>
        </tr>
    </thead>
</table>
<div id='dados' >
<?
	if(!empty($_POST['data_inicio']) && !empty($_POST['data_fim'])){
		$fim="AND necessidade_inicio BETWEEN  '".dataBrToUsa($_POST['data_inicio'])."' AND '".dataBrToUsa($_POST['data_fim'])."'";
	}else{
		$fim='';
	}
	if(empty($_GET['busca'])){
		$necessidades_q = mysql_query($t="SELECT * FROM cozinha_necessidade WHERE vkt_id='$vkt_id' $fim ORDER BY id DESC ");
	}else{
		$necessidades_q = mysql_query($t="SELECT * FROM cozinha_necessidade WHERE vkt_id='$vkt_id' AND $fim AND id like '%".$_GET['busca']."%'");
	}
	//echo $t;
?>
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" style="overflow:auto;">
	<tbody>
   		<?
			while($necessidade=mysql_fetch_object($necessidades_q)){
		?>
        <tr onclick="location.href='?tela_id=118&necessidade_id=<?=$necessidade->id?>&acao=necessidade'">
          <td width="120"><?=$necessidade->id?></td>
          <td width="150"><?=dataUsaToBr($necessidade->necessidade_inicio)." a ".dataUsaToBr($necessidade->necessidade_fim) ?></td>
          <td><?=dataUsaToBr($necessidade->data_cotacao)?></td>
        </tr>
        <?
			}
		?>
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
