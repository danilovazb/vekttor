<?
session_start();
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php");
//$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE usuario_id = '$usuario_id'"));
//$aula = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_aula WHERE vkt_id = '$vkt_id' AND id = '".$_GET['aula']."' "));
?>

<script>
$("table tbody tr.pergunta").live("click",function(){
		var id = $(this).attr('id');
		//alert(id);
		window.open('modulos/escolar/area_professor/forum/form_resposta.php?id='+id,'carregador');
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
<a href="#" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s1'>
  	Escolar
</a>
<a href="#" class='s2'>
    Área do Professor 
</a>
<a href="#" class="navegacao_ativo">
<span></span>Forum
</a>
</div>
<div id="barra_info">
<input type="button" name="voltar" value="&laquo;" onclick="location.href='?tela_id=259&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$_SESSION['sala']?>&sala_materia=<?=$_SESSION['sala_materia']?>'"> Todas as Perguntas do FORUM
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Descriçao Aula</td>
           <td width="70">Data</td>
           <td width="85">Status</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	<?php
	
			$s_forum = (mysql_query(" SELECT * FROM escolar_forum WHERE vkt_id = '$vkt_id'  
											AND 
												professor_id = '".$_GET['professor']."'
											AND 
												status = '1' ORDER BY id ASC	
											"));
 							
					while($forum=mysql_fetch_object($s_forum)){
							
						$aula = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_aula WHERE vkt_id = '$vkt_id' AND id = '$forum->aula_id' "));
						
	?> 
            <tr id="titulo_aula" style="background:#999; color:#FFF;">
               <td width="40"><?=$aula->id?></td>
               <td width="250" ><?=$aula->descricao?></td>
               <td width="70"><?=dataUsaToBr($aula->data)?></td>
               <td width="85">&nbsp;</td>
               <td></td>
            </tr>
            <tr class="pergunta" id="<?=$forum->id?>">
               <td width="40"><?=$forum->id?></td>
               <td width="250"><div style="padding-left:10px;"><strong>Pergunta: </strong><?=substr($forum->pergunta,0,32)?></div></td>
               <td width="70"><?=dataUsaToBr($forum->data_hora)?></td>
               <td width="85">
               	<?
                	if($forum->resposta == NULL){
						echo "Pendente";	
					} else{
						echo "Respondida";
					}
				?>
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

<script>
$(document).ready(function(){
	$("#tabela_dados tr.pergunta:nth-child(2n+1)").addClass('al');

})
</script>