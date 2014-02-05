<?
session_start();
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
$periodo_recuperacao = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_periodicidade_avaliacao WHERE recuperacao = '1' "));

$_SESSION["url_voltar"] =  $_SERVER['REQUEST_URI'];
$materia = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_materias WHERE id = '{$_GET['materia']}'"));

$dados = consulta_materia($_GET["professor_as_turma"]);
//echo $dados;
?>
<script>
$(function(){
	//some_menu();
});
</script>
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
		window.open('modulos/escolar2/area_professor/avaliacao/form_nova_avaliacao.php?id='+id+'&unidade_id='+$("#unidade_id").val()+'&professor_as_turma='+$("#professor_has_turma_id").val(),'carregador');
	});
});//

$("#bimestre").live('click',function(){
	var periodo_avaliacao = $(this).val();
	location.href='?tela_id=262&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_GET['periodo_id']?>&sala=<?=$sala?>&periodo_avaliacao='+periodo_avaliacao;
	
});//

$('#clickAvaliacao').live('click',function(){
	
	var avaliacao = $(this).parent().parent().attr('id');
	var status = $(this).prev('input').val();
	 	if(status == 1){
		  location.href="?tela_id=494&avaliacao_id="+avaliacao;
	    }
	   else{
		  alert('As Notas foram finalizadas, para acessar comunique a Coordenação');
		  return false;
	   }	
});//

$("#visualizar_notas").live("click",function(){
	location.href="?tela_id=494&avaliacao_id="+$("#id").val();
});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.notas{
  display: inline-block;
  padding: 2px 4px 2px;
  font-size: 9.844px;
  font-weight: bold;
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  vertical-align: baseline;
  width:42px;
  text-align:center;
}
.lancado{ background-color: #b94a48;}

.lancar{ background-color: #468847;}
</style>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
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
<a href="?tela_id=231" class='s1'>
  	Escolar
</a>
<a href="?tela_id=231" class='s2'>
    Turma 
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Avalia&ccedil;&otilde;es
</a>
</div>
<div id="barra_info">
	<!-- input hidden -->
    	<input type="hidden" name="turma" id="turma" value="<?=$sala?>" style="width:90px;">
        <input type="hidden" name="unidade_id" id="unidade_id" value="<?=$_GET["unidade_id"]?>">
        <input type="hidden" name="professor_has_turma_id" id="professor_has_turma_id" value="<?=$_GET["professor_as_turma"]?>">
    <!-- -->
	Mat&eacute;ria: <strong style="text-transform:capitalize;"><?=$dados["materia"]?></strong> | Turma: <strong><?=$dados["turma"]?></strong> | <strong>Professor:</strong> <?=$dados["professor"]?>
    
    <a href="modulos/escolar2/area_professor/avaliacao/form_nova_avaliacao.php?professor_as_turma=<?=$_GET["professor_as_turma"]?>&unidade_id=<?=$_GET["unidade_id"]?>" target="carregador" class="mais"></a>
    
    <?
    	
		
		/*$periodo_avaliacao = mysql_query("SELECT * FROM escolar2_avaliacao WHERE vkt_id = '$vkt_id' ORDER BY id"); //AND id <> '$periodo_recuperacao->id'
			while($bimestre=mysql_fetch_object($periodo_avaliacao)){
					echo '<button type="button" id="bimestre" value="'.$bimestre->id.'">'.$bimestre->nome.'</button>';
			}*/
	?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Descriçao</td>
           <td width="70">Data</td>
           <td width="60">Notas</td>
           <td width="70">Avaliaç&atilde;o</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	<?php
    		
		$sql_avaliacao = mysql_query(" SELECT * FROM escolar2_avaliacao WHERE vkt_id = '$vkt_id' AND professor_as_turma_id = '{$_GET['professor_as_turma']}'  ORDER BY periodicidade_id "); //AND sala_materia_professor_id = '$sala_materia->id' AND periodicidade_id <> '$periodo_recuperacao->id'
					while($r=mysql_fetch_object($sql_avaliacao)){
						$bimestre = mysql_fetch_object(mysql_query($b="SELECT * FROM escolar2_periodos_avaliacao WHERE id = '$r->periodicidade_id' AND vkt_id = '$vkt_id' AND unidade_id = {$_GET[unidade_id]}"));
	?> 
            <tr id="<?=$r->id?>">
               <td width="40"><?=$r->id?></td>
               <td width="250" id="descricao"><?=$r->descricao?></td>
               <td width="70"><?=dataUsaToBr($r->data)?></td>
               <td width="60"><input type="hidden" name="statusAvaliacao" id="statusAvaliacao" value="<?=$r->status;?>">
                  <a href="#" id="clickAvaliacao"> <? if($r->status == 1){ echo "<span class='notas lancar'>Lancar</span>";} else{ echo " <span class='notas lancado'>Lan&ccedil;ada</span>";}?></a>
               </td>
               <td width="70"><?=$bimestre->nome?></td>
               <!--<td width="90">
               		<select>
                    	    <option>Selecione</option>
                            <option>1&deg;</option>
                            <option>2&deg;</option>
                            <option>3&deg;</option>
                            <option>4&deg;</option>
                    </select>
               </td>-->
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
</d