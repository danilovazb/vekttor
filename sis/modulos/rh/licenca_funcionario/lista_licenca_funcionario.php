<?
include("_functions.php");
include("_ctrl.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	RH
</a>
<script>
	$("#empresa_id").live('change',function(){
		$("#hempresa_id").val();
	});
</script>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">  
	<strong>Empresa: </strong> <?=$empresa->razao_social?>      
	<a href="modulos/rh/licenca_funcionario/form.php?empresa_id=<?=$_GET['empresa1id']?>" target="carregador" class="mais"></a>
 
  </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
          
            <td width="230">Funcionario</td>
          	<td width="200">Licença</td>
          	<td width="200">Cod. Licença</td>
            <td width="200">Período</td>
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
		$busca_add = "WHERE nome like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM	rh_licencas"),0,0);
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="
		SELECT *,
		rf.id as funcionario_id, rlf.id as rlf_id
		FROM 
			rh_licencas_funcionarios rlf,
			rh_funcionario rf
		WHERE
			rlf.funcionario_id = rf.id AND
			rf.empresa_id      = '".$_GET['empresa1id']."' 
		$busca_add 
		LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($r=mysql_fetch_object($q)){
		//$funcionario = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$r->funcionario_id'"));
		$licenca = mysql_fetch_object(mysql_query("SELECT * FROM rh_licencas WHERE id='$r->licenca_id'"));
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?> onclick="window.open('modulos/rh/licenca_funcionario/form.php?id=<?=$r->rlf_id?>&empresa_id=<?=$_GET['empresa1id']?>','carregador')">
 <td width="230"><?=$r->nome?></td>
          	<td width="200"><?=$licenca->nome?></td>
          	<td width="200"><?=$licenca->codigo?></td>
            <td width="200"><?=DataUsatoBr($r->data_inicio)." a ".DataUsatoBr($r->data_fim)?></td>
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
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
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