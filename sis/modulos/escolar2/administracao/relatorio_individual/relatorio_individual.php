<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
	
	$("#bimestre_id").live("change",function(){
		$("#form_filtro").submit();
	});
	
	$("#filter_turma_id").live("change",function(){
		$("#form_filtro").submit();
	});
});

</script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">&laquo;</div>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>

<a href="" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s2'>
    Escolar 
</a>
<a href="#" class="navegacao_ativo">
<span></span> Relatório Individual
</a>
</div>
<div id="barra_info">
 
 <form method="get" id="form_filtro" style="float:left;">
 <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
 
 <select name="bimestre_id" id="bimestre_id" style="margin-top:3px;"><!-- select bimestre -->
 	<option value="0"><strong>BIMESTRE</strong></option>
    <?
    	$sql_bimestre = mysql_query(" SELECT * FROM  escolar2_periodos_avaliacao AS bimestre WHERE vkt_id = '$vkt_id' ORDER BY id ASC ");
		while($s_bimestre=mysql_fetch_object($sql_bimestre)){
			if( $_GET["bimestre_id"] == $s_bimestre->id ) { $sel = 'selected="selected"';} else {$sel='';}	
	?>
    <option <?=$sel?> value="<?=$s_bimestre->id?>"><?=$s_bimestre->nome?></option>
    <? }?>
 </select>
 
  <select name="turma_id" id="filter_turma_id" style="width:120px;"><!-- select turma -->
      	<option value="0">TURMA</option>
        <?php
        	$sql_turma = mysql_query($t=" SELECT * FROM escolar2_matriculas AS matricula
			JOIN escolar2_turmas AS turma 
				ON turma.id = matricula.turma_id 
			WHERE 
				matricula.vkt_id = '$vkt_id' 
			GROUP BY turma.nome ");
			
			while($turma=mysql_fetch_object($sql_turma)){
				$salas = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_salas WHERE id = '$turma->sala_id' "));
				if( $_GET["turma_id"] == $turma->turma_id){ $selts = 'selected="selected"';} else { $selts = ''; }
		?>
        <option <?=$selts?>  value="<?=$turma->turma_id?>"><?=$turma->nome." - ".$salas->nome?></option>
      	<?php }?>
      </select>
 
 </form>
 
</div>
<!--<div id="result"></div>-->
<input type="hidden" name="aula" id="aula" value="<?=$aula?>">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	 <tr>
           <td width="30">ID</td>
           <td width="140">Bimestre</td>
           <td width="230">Aluno</td>
           <td width="100"></td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
      <?
	  	$filter = "";
		$filterTurma = "";
			
	  	if( !empty($_GET["bimestre_id"]) )
		  $filter = " AND bimestre.id = '".$_GET["bimestre_id"]."'  ";		
	  
		$sql_bimestre = mysql_query($rt=" 
		SELECT * 
		FROM  
			escolar2_periodos_avaliacao AS bimestre 
		WHERE 
			bimestre.vkt_id = '$vkt_id' 
		$filter	
		ORDER BY id ASC ");
		
		while($bimestre=mysql_fetch_object($sql_bimestre)){		
	  ?>
      <tr>
      	 <td width="30"><?=$bimestre->id?></td>
         <td width="140"><?=strtoupper($bimestre->nome)?></td>
         <td width="230"></td>
         <td width="100"><a onclick="window.open('modulos/escolar2/administracao/relatorio_individual/relatorio_impressao.php?bimestre_id=<?=$bimestre->id?>&turma_id=<?=$_GET["turma_id"]?> ')" href="#">  Imprimir Bimestre </a></td>
         <td></td>
      </tr>
      <? 
		
		if( !empty($_GET["turma_id"]) )
			$filterTurma = " AND matricula.turma_id = '".trim($_GET["turma_id"])."' ";	
			
		$sql_relatorio = mysql_query($st=" 
		SELECT 
			aluno.nome AS nome_aluno, 
			relatorio.id AS relatorio_id, 
			turma.nome AS nome_turma,
			matricula.turma_id AS turma_id
			
		FROM  escolar2_relatorio_individual_bimestre AS relatorio
		
		JOIN escolar2_matriculas AS matricula
			ON relatorio.matricula_aluno_id = matricula.id
			
		JOIN escolar2_alunos AS aluno
			ON matricula.aluno_id = aluno.id
			
		JOIN escolar2_turmas AS turma
			ON matricula.turma_id = turma.id
		
		WHERE 
			relatorio.vkt_id = '$vkt_id' 
		AND 
			relatorio.bimestre_id = '$bimestre->id' 
		$filterTurma
		ORDER BY aluno.nome ");
		
		
			while($relatorio=mysql_fetch_object($sql_relatorio)){
	  ?>
      <tr>
      	 <td width="30"></td>
         <td width="140"><div style="padding-left:13px;"><b> Turma: </b> <?=($relatorio->nome_turma)?></div></td>
         <td width="230" title="<?=strtoupper($relatorio->nome_aluno)?>"><?=strtoupper($relatorio->nome_aluno)?></td>
         <td width="100" style="text-align:center; padding-left:0px;"><a href="#"  onclick="window.open('modulos/escolar2/administracao/relatorio_individual/relatorio_impressao.php?relatorio_id=<?=$relatorio->relatorio_id?>')"  > Imprimir </a></td>
         <td></td>
      </tr>
      
      <? 
			}
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
