<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
		$("#imoveis tr:nth-child(2n+1)").addClass('al');
		
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
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s1'>
  	Eleitoral
</a>
<a href="./" class='s2'>
    Relatórios 
</a>
<a href="?tela_id=103" class="navegacao_ativo">
<span></span>Bens de Eleitores</a></div>
<div id="barra_info">
    <a href="<?=$caminho?>/form_eleitor.php" target="carregador" class="mais"></a>
    <form autocomplete="off" onsubmit="if(document.getElementById('bairro_existe').value!='1'&&document.getElementById('bairro').value!=''){alert('bairro nao cadastrado'); return false;}">
      <label>Bairro
        <input type="text" id='bairro' name="bairro" style="height:10px;" value="<?=$_GET['bairro']?>" busca='modulos/eleitoral/resumo_campanha/busca_bairro.php,@r0,@r0-value>bairro|@r1-value>bairro_existe,0'/>
        <input type="hidden" id="bairro_existe" name="bairro_existe" value="<?=$_GET['bairro_existe']?>" />
      </label>
         <label>Coordenadores
    	<select name="coordenador_id" id="coordenador_id"><option value="0">Todos</option>
        <?	$coordenadores_q=mysql_query("SELECT * FROM eleitoral_colaboradores WHERE tipo_colaborador='0' ");
			while($coordenador=mysql_fetch_object($coordenadores_q)){ ?>
        	<option <? if($_GET['coordenador_id']==$coordenador->id){ echo "selected='selected'";} ?> value="<?=$coordenador->id?>"><?=$coordenador->nome?></option>
        <? }
		 ?>
        </select>
        
        </label>
        <input type="hidden" name="tela_id" value="156" />
        
        <input type="submit" value="Filtrar" />
    </form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<td width="220">Eleitor</td>
            <td width="80">Imóvel</td>
            <td>Serviços</td>
        </tr>
    </thead>
</table>
<div id="dados">
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<?
$eleitor_q="SELECT * FROM eleitoral_eleitores WHERE imovel_qtd>0 AND imovel_servicos!='0'";
if($_GET['bairro']){
	$eleitor_q.=" AND bairro='".$_GET['bairro']."'";
}
if($_GET['zona_id']){
	$eleitor_q.=" AND zona_id='".$_GET['zona_id']."'";
}
if($_GET['coordenador_id']){
	$eleitor_q.=" AND coordenador_id='".$_GET['coordenador_id']."'";
}
//echo $eleitor_q;
$eleitor_q.="AND vkt_id='$vkt_id'";
$eleitor_q=mysql_query($eleitor_q);
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="imoveis">
    <?
    	while($eleitor=mysql_fetch_object($eleitor_q)){
			$total+=$eleitor->imovel_qtd;
	?>
    	<tr onclick="window.open('<?=$caminho?>../eleitores/form_eleitor.php?id=<?=$eleitor->id?>','carregador')">
        	<td width="220"><?= $eleitor->nome?></td>
            <td width="80"><?= $eleitor->imovel_qtd?></td>
            <td><?= $eleitor->imovel_servicos?></td>
       </tr>
    <?
		}
	?>
    </tbody>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
	<thead>
    	<tr>
        	<td width="220">Total</td>
            <td width="80"><?=$total?></td>
            <td width=""></td>
        </tr>
    </thead>
</table>
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