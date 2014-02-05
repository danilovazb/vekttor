<?
session_start();
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_professor WHERE usuario_id = '$usuario_id'"));
?>
<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
	$('#modulo_mais').live('click',function(){
			var html = $('<div> <label>Materia<input type="text" name="nome" size="30"></label></div><div style="clear:both"></div>');
			$("#result_mateira").append(html);
	});
$(document).ready(function(){
	$("#tabela_dados tr td#descricao").live("click",function(){
		var id = $(this).parent().attr('id');
			//alert(id);
		window.open('<?=$caminho?>form_nova_aula.php?aula_id='+id,'carregador');
	});
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
<a href="?tela_id=231" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=231" class='s2'>
  	Aulas Online
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span><?=$tela->nome?>
</a>
</div>
<div id="barra_info">
	Materia: <strong style="text-transform:capitalize;"><?php echo $materia->nome;?></strong>
    <a href="<?=$caminho?>form_nova_aula.php?modulo_id=<?=$_GET['modulo_id']?>&materia_id=<?=$materia_id?>" target="carregador" class="mais"></a>
	<button type="button" onclick="location.href='?tela_id=267&materia=<?=$_SESSION['materia_id']?>&turma=<?=$sala?>&professor=<?=$professor->id?>'">Total Faltas</button>
    <input type="button" name="todas_perguntas" onclick="location.href='?tela_id=292&professor=<?=$professor->id?>'" value="Todas Perguntas Forum">
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Título Aula</td>
           <td width="70">Data</td>
           <td width="95">Status</td>
           <td width="150">Op&ccedil;&otilde;es</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	<?php
    		$sql_aula = mysql_query(" SELECT * FROM escolar_aulas_online
											WHERE vkt_id = '$vkt_id' 
											AND modulo_id = '{$_GET['modulo_id']}'
											AND materia_id ='{$_GET['materia_id']}'  ");
											
					while($aula=mysql_fetch_object($sql_aula)){
	?> 
            <tr id="<?=$aula->id?>">
               <td width="40"><?=$aula->id?></td>
               <td width="250" id="descricao"><?=$aula->titulo?></td>
               <td width="70"><?=dataUsaToBr($aula->data_referente)?></td>
               <td width="95">
               	<?
                	if($aula->status == 0){
				?>
                		<strong>Aula Aberta</strong>
                <?
					} else{
				?>
               			<strong>Aula Finalizada</strong>
                <?
					}
				?>
               </td>
               <td width="150">
               	<a href="#" onclick="location.href='?tela_id=326&aula_id=<?=$aula->id?>'">Arquivo</a>
                </td>
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
