<?

include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
tbody tr:nth-child(even) {background:#F1F5FA;}

</style>
<div id='conteudo'>
<div id='navegacao'>
  <div id="some">«</div>
<a href="./" class='s1' >
  	Sistema
</a>
<a href="./" class='s2'>
    Vekttor 
</a>
<a href="?tela_id=<?=$tela->id?>" class="navegacao_ativo">
<span></span>    <?=$tela->nome?> 
</a>
</div>
<div id="barra_info">

<form method="get" style="margin:0; padding:0">
Filtrar com tempo Maior que <?
if($_GET[segundos]){
	$tempo = $_GET[segundos];
}else{
	$tempo = 3;
}
?>
<input name="segundos" type="text" size="2" value="<?=$tempo?>" > Segundos <input type="submit"  value="Filtrar">
<input type="hidden" name="tela_id" value="<?=$_GET[tela_id]?>">
</form>

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="50">Tempo</td>
            <td width="200">Cliente</td>
          	<td width="130">M&oacute;dulo</td>
            <td>Data</td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?php
	
	// colocar a funcao da paginação no limite
	$filtro = " AND tempo_carregamento>3 ";
	
	if($_GET[segundos]){
		$filtro = " AND tempo_carregamento>$_GET[segundos] ";
	}
	
	
	$q=mysql_query($t="SELECT *, datediff(datahora,now()) as ha
FROM `sis_modulos_avaliacao` WHERE 1=1  $filtro ORDER BY id DESC LIMIT 0,400");	
	//echo $t.mysql_error();
	while($r=mysql_fetch_object($q)){
		$usuario = mysql_fetch_object(mysql_query($t="SELECT * FROM usuario WHERE id='$r->usuario_id' ORDER BY id LIMIT 1"));
		$cliente = mysql_fetch_object(mysql_query($t="SELECT * FROM clientes_vekttor WHERE id='$r->vkt_id' ORDER BY id LIMIT 1"));
		$tela = mysql_fetch_object(mysql_query($t="SELECT * FROM sis_modulos WHERE id='$r->modulo_id' ORDER BY id LIMIT 1"));
		
		//$acesso = mysql_fetch_object(mysql_query("SELECT * FROM `sis_modulos_avaliacao` WHERE vkt_id = '$r->id' ORDER BY id DESC limit 1"));
		//$ultimo_acesso = explode(" ",$acesso->datahora);
		

	?>
<tr <?=$sel?> >
<td  width="50" ><?
if($r->tempo_carregamento>3){
	$corred = 'style="color:#F00"';
}else{
	$corred = '';
}
?><a <?=$corred?>id='l<?=$r->id?>' rel='tip' title='<?=number_format(($r->memoria_pico/1000),2,',','.')?> Mb' ><?=$r->tempo_carregamento?></a></td>
<td width="200" title="<?=$usuario->login?>"><?=$cliente->nome?></td>
<td width="130"><a href="http://jobs.vkt.com.br/sis/?<?=$r->parametros?>"><?=$tela->nome?></a></td>
<td><?=$r->datahora." ha $r->ha"?></td>
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
           <td width="230"></td>
           <td width="130">&nbsp;</td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
