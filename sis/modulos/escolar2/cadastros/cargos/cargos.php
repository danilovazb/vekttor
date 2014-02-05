<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
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
<script>
	$(document).ready(function(){
		$("#dados tr:nth-child(2n+1)").addClass('al');
	})
	function checa_cpf(t){
		
	ultima = t.value.substr(13,1);
	
	//alert(id);
		if(ultima!='_' && t.value.length=='14' ){
			window.open('modulos/escolar/professor/form.php?cnpj_cpf='+t.value,'carregador')	
		}
	}
	
	$(document).ready(function(){
			$("tr:odd").addClass('al');
});
</script>
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a><a href="?tela_id=<?=$_GET['tela_id']?>" class="navegacao_ativo">
<span></span><?=$tela->nome?>
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
		   <td width="200">Cargo</td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<?
		if(strlen($_GET[busca])>0){
			$busca_add = "AND cargo like '%{$_GET[busca]}%'";
		}
		$registros= mysql_result(mysql_query("SELECT count(*) FROM cargo_salario WHERE vkt_id='$vkt_id' $busca_add ORDER BY cargo ASC"),0,0);
        $cargos_q=mysql_query("SELECT * FROM cargo_salario WHERE vkt_id='$vkt_id' $busca_add ORDER BY cargo ASC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])." ");
		
		echo mysql_error();
		while($cargo=mysql_fetch_object($cargos_q)){
		?>
    	<tr onClick="window.open('<?=$caminho?>/form.php?id=<?=$cargo->id?>','carregador')">
        	<td><?=$cargo->cargo?></td>
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
           <td width="230"><a>Total: <?=$total?></a></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 1;	
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
