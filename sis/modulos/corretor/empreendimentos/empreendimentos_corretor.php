
<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_ctrl.php"); 
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
    Corretor 
</a>
<a href="?tela_id=39" class="navegacao_ativo">
<span></span>Empreendimentos
</a>
</div>
<div id="barra_info">
    
	
</div>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"><?=linkOrdem("Empreendimento","nome",1)?></td>
          	<td width="97"><a>Disponibilidade</a></td>
			<td width="62"><a>Vendido</a></td>
			<td width="73">&nbsp;</td>
            <td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND nome like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM empreendimento WHERE tipo='Empreendimento' AND vkt_id='$vkt_id' $busca_add ORDER BY nome"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query("SELECT *,DATEDIFF(fim,inicio) as dias FROM empreendimento WHERE tipo='Empreendimento' AND vkt_id='$vkt_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($r=mysql_fetch_object($q)){
		$total++;
		
		$disponiveis = mysql_result(mysql_query("SELECT COUNT(*) as disponiveis FROM disponibilidade WHERE empreendimento_id ='$r->id' AND situacao='0' "),0,0);
		$vendidos=  mysql_result(mysql_query("SELECT COUNT(*) FROM disponibilidade WHERE empreendimento_id ='$r->id' AND situacao='2' "),0,0);
	?>      
    	<tr onclick="location.href='?tela_id=66&empreendimento_id=<?=$r->id?>'">
          	<td width="209"><?=$r->nome?></td>
            <td width="97"><?=$disponiveis?></td>
			<td width="62"><?=$vendidos?></td>
			<td width="73">&nbsp;</td>
           	<td width=""></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>
</div>

<?
//print_r($_POST);
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="80">&nbsp;</td>
            <td width="80">&nbsp;</td>
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
