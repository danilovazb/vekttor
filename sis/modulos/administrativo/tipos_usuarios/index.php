<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");

?>
<script type="text/javascript">
$(document).ready(function(){
	$("tr:odd").addClass('al');
});

	$(".exibe_modulos").live('click',function(){
		id = $(this).attr('r');
		
		$(".exibe_modulos").css('font-weight','normal');
		$(this).css('font-weight','bold');
		$(".submodulos").hide();
	
		$("#div"+id).show();
				
	});

	$("#marcarTodos").live("click",function(){
		//alert(this.checked);
		if(this.checked==true){
			$(this).parent().parent().find(".modulo_id").attr("checked","checked");			
		}else{
			$(this).parent().parent().find(".modulo_id").removeAttr("checked");
			
		}
	});
	
	$(".modulo_id").live("click",function(){
		id = $(this).val();

		if(this.checked==true){
			$(".sub"+id).attr("checked","checked");			
		}else{
			$(".sub"+id).removeAttr("checked");						
		}
		
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
<div id='some'>«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Administrativo
</a>
<a href="?tela_id=14" class="navegacao_ativo">
<span></span>Tipos de Usuário
</a>
</div>
<div id="barra_info">
	<!-- " -->
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
    
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
			<td width="240"><?=linkOrdem("Nome","nome",1)?></td>
			 <td width="180"><a>Quantidade de Usuários</a></td>
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
		$busca_add = "AND nome like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM usuario_tipo $busca_add ORDER BY nome"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome";
	}
	// colocar a funcao da paginação no limite
	$q= mysql_query($trace="SELECT * FROM usuario_tipo  WHERE vkt_id='$vkt_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($r=mysql_fetch_object($q)){
		$total++;
		$qtd = @mysql_result(mysql_query($trace="SELECT count(*) FROM usuario WHERE usuario_tipo_id ='$r->id'"),0,0);
	
?>
<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
<td width="240"><?=$r->nome?></td>
<td width="180" align="right"><?=$qtd?></td>
<td></td>
<?
    
	}
	
	?>
    
        </tr>
    </tbody>
</table>
<?

//echo "$trace";
//print_r($tela);

//print_r($_GET);
//print_r($_POST);


?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="240"><a>Total: <?=$total?></a></td>
           <td width="180">&nbsp;</td>
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
