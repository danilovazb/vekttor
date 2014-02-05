<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conudo'>
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
	  
	  $("#dados tbody tr").live("click",function(){
		  var id = $(this).attr("id");
		  window.open("modulos/escolar2/cadastros/grupo_materias/form.php?id="+id+"","carregador");
	  });
  });
</script>
  <div id="some">«</div>
        <a href="#" class='s1'>SISTEMA</a>
        <a href="./" class='s1'>Escolar</a>
        <a href="./" class='s2'>Cadastro</a>
        <a href="?tela_id=232" class="navegacao_ativo">
			<span></span>Grupo de Matérias
		</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
		   <td width="30">ID</td>
           <td width="210">Grupo matéria</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<?php
		$busca = "";
		
        if( !empty($_GET["busca"]) )
			$busca = " AND nome like '%".$_GET["busca"]."%' ";
		
		
		$sql = mysql_query(" SELECT * FROM escolar2_grupo_materia WHERE vkt_id = '$vkt_id' $busca ORDER BY nome ");
		while( $grupo=mysql_fetch_object($sql) ){
		
		?>
    	<tr id="<?=$grupo->id?>">
        	<td width="30"><?=$grupo->id?></td>
        	<td width="210"><?=$grupo->nome?></td>
            <td></td>
        </tr>
        <?php
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
