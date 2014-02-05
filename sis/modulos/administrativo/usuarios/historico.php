<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
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
<a href="" class='s1'>
  	Sistema NV
</a>
<a href="" class='s1'>
    Administrativo 
</a>
<a href="" class='s2'>
    Usu&aacute;rios
</a>
<a href="" class="navegacao_ativo">
<span></span>Histórico
</a>
</div>
<div id="barra_info">
    	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="200"><?=linkOrdem("Tela","tela",1)?></td>
          	<td width="140"><a>Registro</a></td>
          	<td width="140"><?=linkOrdem("Ação","acao",0)?></td>
          	<td width="140"><?=linkOrdem("Data e Hora","data_hora",0)?></td>
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
		$busca_add = "AND tela LIKE '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM usuario_historico WHERE usuario_id='{$_GET[usuario_id]}' $busca_add ORDER BY tela"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="tela";
	}
	// colocar a funcao da paginação no limite
	$q= mysql_query($trace="SELECT * FROM usuario_historico WHERE usuario_id='{$_GET[usuario_id]}' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($r=mysql_fetch_object($q)){
		$total++;
		$login = @mysql_result(mysql_query($trace="SELECT login FROM usuario WHERE id ='$r->usuario_id'"),0,0);
	
	?>
    	<tr onclick="window.open('<?=$qualtelata?>form.php','carregador')">
            <td width="200"><?=$r->tela?></td>
          	<td width="140"><?=$login?></td>
          	<td width="140"><?=$r->acao?></td>
          	<td width="140"><?=dataUsaToBr($r->data_hora)?></td>
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
            <td width="200"><a>Total:<?=$total?></a></td>
            <td width="140">&nbsp;</td>
            <td width="140">&nbsp;</td>
            <td width="140">&nbsp;</td>
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
