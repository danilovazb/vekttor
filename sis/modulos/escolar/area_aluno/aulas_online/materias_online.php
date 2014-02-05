<?
$aluno_id= $_SESSION['aluno']->id;

?>
<script>
$('.ops').live('click',function(){
	materia_id=$(this).attr('id');
	location = '?tela_id=328&materia_id='+materia_id;
});

</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'><div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Matérias
</a>
</div>
<div id="barra_info">
  <select name="modulo_id" id='modulo_id'  >
    <?
	$q = mysql_query($t="SELECT *,ee.nome as escola,
				  ep.nome as periodo,
				  ea.nome as aluno,
				  emodulo.nome as modulo,
				  emodulo.id as modulo_id,
				  em.id as idmatricula,
				  ea.id as idaluno
			  FROM escolar_matriculas em
				  INNER JOIN escolar_escolas ee ON em.escola_id=ee.id
				  INNER JOIN escolar_periodos ep ON em.periodo_id=ep.id
				  INNER JOIN escolar_alunos ea ON em.aluno_id=ea.id
				  INNER JOIN escolar_modulos emodulo ON em.modulo_id=emodulo.id
				  INNER JOIN escolar_salas es ON em.sala_id=es.id
				  INNER JOIN escolar_horarios eh ON em.horario_id=eh.id
				  INNER JOIN escolar_cursos ec ON em.curso_id=ec.id
			  WHERE em.aluno_id='$aluno_id'
			 	  AND em.vkt_id='$vkt_id'
				  ORDER BY em.id DESC
");
	$i=0;
	while($r= mysql_fetch_object($q)){
		$i++;
		if($i==1){
			$modulo_id= $r->modulo_id;	
		}
		if($_GET['modulo_id']>0){
			$modulo_id=$_GET['modulo_id'];
		}
		if($_GET['modulo_id']==$r->modulo_id){
			$sel="selected='selected'";
		}else{
			$sel='';
		}
?>
    <option <?=$sel?> value="<?=$r->modulo_id?>">Matricula: <?=$r->idmatricula?> - <?=$r->escola?>  <?=$r->modulo?></option>
    <?
	}
	?>
  </select>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="250">Mat&eacute;rias</td>
           <td>Aulas</td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	<?php
	if($_GET['modulo_id']>0){
		$modulo_id=$_GET['modulo_id'];
	}
	  $aulas_modulo_q = mysql_query($g="
	  SELECT 
		*			 
	  FROM 
		 escolar_materias 
	  WHERE 
		  modulo_id='$modulo_id'
	  AND 
		  vkt_id = '$vkt_id' " );
		  //echo $g;
					while($r=mysql_fetch_object($aulas_modulo_q)){
		$total++;
		if($total%2){$sel='class="al ops"';}else{$sel='class="ops"';}

	?>
<tr <?=$sel?> id="<?=$r->id?>" >
               <td width="250" id="descricao"><?=$r->nome?></td>
               <td>
               <?
               
			   echo @mysql_result(mysql_query($t="SELECT count(*) FROM  escolar_aulas_online WHERE  materia_id='$r->id' AND modulo_id='$modulo_id'  "),0,0);
			   ?>
               
               </td>
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
           <td width="230">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<script>
$("#modulo_id").change(function(t){
	modulo_id=$(this).val();
	location='?tela_id=327&modulo_id='+modulo_id;
})
</script>
<div id='rodape'>
  <div style="float:right; margin:0px 20px 0 0"></div>
</div>
