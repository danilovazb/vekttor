<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
 $sql_escola = mysql_fetch_object(mysql_query($t=" SELECT * FROM escolar_escolas WHERE vkt_id = '$vkt_id'"));
 $media_instituicao = $sql_escola->media;
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
table#bimestre tr td{
		background:#F8F8F8;
		padding:5px;
		padding-left:5px;
}

</style>
<script>
	$('#curso_id').live('change',function(){
		var curso=$("select#curso_id").val();
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
    <button type="button" onclick="location.href='?tela_id=256&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$sala?>'">&laquo;</button> <!-- ?tela_id=256&materia=16&periodo_id=1&sala=3&sala_materia=220 -->
  	<button type="button" onclick="location.href='?tela_id=270&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$sala?>&sala_materia=<?=$smp->id?>'">Recuperaç&atilde;o</button> <!-- ?tela_id=270&materia=16&periodo_id=1&sala=3&sala_materia=220 -->
   <?
   		$sql_materia=mysql_fetch_object(mysql_query(" SELECT em.nome as nome FROM escolar2_serie_has_materias as esm, escolar2_materias as em WHERE esm.vkt_id='$vkt_id' AND esm.id = '$professor_turma->serie_has_materia_id' AND em.id=esm.materia_id"));
		echo '<strong> Mat&eacute;ria: </strong>'.$sql_materia->nome.' | <strong> Media da Institui&ccedil;&atilde;o: </strong>'.number_format($unidade->media, 1, '.', ' ');
   ?> 
</div>

<table cellpadding="0" cellspacing="0" width="100%" id="bimestre">
    <thead>
     <tr>
           <td width="40">Codigo</td>
           <td width="200">Nome</td>
           <? 
		   $periodos_aval_q=mysql_query("SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id='$vkt_id' AND unidade_id='{$turma->unidade_id}'");
		   while($periodo=mysql_fetch_object($periodos_aval_q)){
		   ?>
	           <td width="90"><div style="padding-left:8px;"><!--Nota--><?=$periodo->nome?></div><div style="font-weight:normal; padding-left:3px;"><?=substr($r->descricao,0,16)?></div></td>
           <? } ?>
           <td width="70">Média Final</td>
           <td width="80">% Faltas</td>
           <td width="80">Situaç&atilde;o</td>
           <td></td>
           
     </tr>
     
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <? 
	$matriculas_q=mysql_query("SELECT m.id as id, a.nome as nome FROM escolar2_matriculas as m, escolar2_alunos as a WHERE m.vkt_id='$vkt_id' AND m.turma_id='$turma->id' AND a.id= m.aluno_id ");
	echo mysql_error();
	while($mat=mysql_fetch_object($matriculas_q)){
	?>
	<tr>
   		<td width="40"> <?=$mat->id?></td>
   		<td width="200"><?=$mat->nome?></td>
        <? 
		$periodos=mysql_query("SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id='$vkt_id' AND unidade_id='{$turma->unidade_id}'");
		while($p=mysql_fetch_object($periodos)){
			$notas=mysql_fetch_object(mysql_query($a="
			SELECT 
				ea.periodicidade_id as periodo_avaliacao_id, (ROUND(SUM(eaa.nota),1)/COUNT(eaa.id)) as media_bimestre 
			FROM 
				escolar2_aluno_as_avaliacao as eaa, escolar2_avaliacao as ea 
			WHERE 
				eaa.vkt_id='$vkt_id' AND eaa.matricula_aluno_id='$mat->id' AND ea.status='2' AND ea.id = eaa.avaliacao_id AND ea.periodicidade_id='$p->id' GROUP BY eaa.matricula_aluno_id "));
			echo mysql_error();
			
		?>
        	<td width="90"><?=moedaUsaToBR($notas->media_bimestre)?></td>
        <?
		}
		?>
        <td></td>
        
	</tr>   
	<?
	}
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
