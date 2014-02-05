<?
session_start();
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
$periodo_recuperacao = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_periodicidade_avaliacao WHERE recuperacao = '1' "));
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
		window.open('modulos/escolar/area_professor/avaliacao/form_nova_avaliacao.php?id='+id,'carregador');
	});
})

$("#bimestre").live('click',function(){
			var periodo_avaliacao = $(this).val();
			location.href='?tela_id=272&materia=<?=$_SESSION['materia_id']?>&periodo_materia=<?=$_GET['periodo_id']?>&sala=<?=$sala?>&periodo_avaliacao='+periodo_avaliacao;
	
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
    Escolar 
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Turma
</a>
</div>
<div id="barra_info">
	Mat&eacute;ria: <strong style="text-transform:capitalize;"><?php echo $materia;?></strong> | Per&iacute;odo: <strong><?php echo $sql_periodo->nome?></strong>
    
    <a href="modulos/escolar/area_professor/avaliacao/form_nova_avaliacao.php?sala_materia=<?=$sala_materia->id?>" target="carregador" class="mais"></a>
	
    <button type="button" onclick="location.href='?tela_id=266&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_GET['periodo_id']?>&sala=<?=$sala?>'">Cálculo Média Final</button>
    
    <?
    	$periodo_avaliacao = mysql_query("SELECT * FROM escolar_periodicidade_avaliacao WHERE vkt_id = '$vkt_id' AND recuperacao = '1'");
			while($bimestre=mysql_fetch_object($periodo_avaliacao)){
					echo '<button type="button" id="bimestre" value="'.$bimestre->id.'">'.$bimestre->nome.'</button>';
			}
	?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Avalia&ccedil;&atilde;o Recupera&ccedil;&atilde;o</td>
           <td width="70">Data</td>
           <td width="80">Açao</td>
           <td width="70">Status</td>
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
    		$sql_avaliacao = mysql_query($t=" SELECT * FROM escolar_periodicidade_avaliacao epv 
												JOIN 
													escolar_avaliacao ea ON epv.id = ea.periodicidade_id
												WHERE 
													epv.vkt_id = '$vkt_id' AND epv.recuperacao = '1'  
												AND 
													ea.sala_materia_professor_id = '$sala_materia->id' ");
													
					while($avaliacao_rec=mysql_fetch_object($sql_avaliacao)){
								$bimestre = mysql_fetch_object(mysql_query($b="SELECT * FROM escolar_periodicidade_avaliacao 
													WHERE 
														id = '$periodo_recuperacao->id' 
													AND 
														vkt_id = '$vkt_id'"));
	?> 
            <tr id="<?=$avaliacao_rec->id?>">
               <td width="40"><?=$avaliacao_rec->id?></td>
               <td width="250" id="descricao"><?=$avaliacao_rec->descricao?></td>
               <td width="70"><?=dataUsaToBr($avaliacao_rec->data)?></td>
               <td width="80">
               	<?
                	if($avaliacao_rec->status == 0){
				?>
                <a href="#" onclick="location.href='?tela_id=273&sala=<?=$sala?>&avaliacao=<?=$avaliacao_rec->id?>&materia=<?=$_SESSION['materia_id']?>'">Lancar Notas</a>
                <?
					} 
					else if($avaliacao_rec->status == 1){
				?>
                	<a href="#" onclick="location.href='?tela_id=274&sala=<?=$sala?>&avaliacao=<?=$avaliacao_rec->id?>&materia=<?=$_SESSION['materia_id']?>'">Editar Notas</a>
                <?		
					}
				?>
               </td>
               <td width="70">
               	<?
                	if($avaliacao_rec->status == 0){
				?>
                		<strong>Pendente</strong>
                <?
					} else{
				?>
               			<strong>Finalizada</strong>
                <?
					}
				?>
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
</div>
