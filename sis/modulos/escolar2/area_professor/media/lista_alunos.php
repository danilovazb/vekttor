<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
//$periodo_recuperacao = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_periodicidade_avaliacao WHERE recuperacao = '1' "));

?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
	$('#curso_id').live('change',function(){
		var curso=$("select#curso_id").val();
			//alert(curso);
		$('#result_curso').load('modulos/escolar/exemplo_matricula/curso_turma.php?curso='+curso);
	})
	$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="?tela_id=233" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=233" class='s2'>
    Escolar 
</a>
<a href="?tela_id=233" class="navegacao_ativo">
<span></span>Modulos
</a>
</div>
<div id="barra_info">
      <button type="button" onclick="location.href='?tela_id=478&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$sala?>'">&laquo;</button> <!-- ?tela_id=256&materia=16&periodo_id=1&sala=3&sala_materia=220 -->
	  <?php
   		$materia=mysql_fetch_object(mysql_query(" SELECT em.nome as nome FROM escolar2_serie_has_materias as esm, escolar2_materias as em WHERE esm.vkt_id='$vkt_id' AND esm.id = '$professor_turma->serie_has_materia_id' AND em.id=esm.materia_id "));
				echo '<strong> Mat&eacute;ria: </strong>'.$materia->nome;
   	  ?>
</div>
<table id="bimestre" cellpadding="0" cellspacing="0" width="100%">
    <thead>
     <tr>
           <td width="40">Codigo</td>
           <td width="200">Nome</td>
           <? 
		   $periodos_aval_q=mysql_query("SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id='$vkt_id' AND unidade_id='$turma->unidade_id' ");
		   while($p=mysql_fetch_object($periodos_aval_q)){
			   ?>
			   <td width="80"><?=$p->nome?></td>
			   <?
		   }
		   ?>
           
           <td width="60">Nota <?=$j?></td>
           <td width="70">Média</td>
           <!--<td width="80">Situaç&atilde;o</td>-->
           <td></td>
           
     </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    
	<tr>
   		<td width="40"> <?=$matricula->id?></td>
   		<td width="200"><?=$aluno->nome?></td>
        <td width="70"><? if($cont != 0){ $media = ($soma/$cont); echo '<strong>'.number_format($media,2,'.','').'</strong>'; }?></td>
        <!--<td width="80"><? // if($media >= 7 and $cont != 0){echo '<strong style="color:#32870E">Aprovado</strong>';} else{echo '<strong style="color:#A42B2B">Reprovado</strong>';}?></td>-->
        <td ></td>
        
	</tr>
      
	<?
	// necessario para paginacao
    $registros= mysql_result(mysql_query($t="SELECT count(*) FROM escolar_alunos a, escolar_alunos_bolsistas ab WHERE ab.vkt_id=$vkt_id $busca_add ORDER BY a.id DESC"),0,0);
   //echo $t;
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="codigo_totvs";
	}
	// colocar a funcao da paginação no limite
	$q= mysql_query($t="SELECT a.*,ab.* FROM escolar_alunos a, escolar_alunos_bolsistas ab WHERE  a.id=ab.aluno_id AND ab.vkt_id='$vkt_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>

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
<?php
include("calculo_media_final.php");
?>