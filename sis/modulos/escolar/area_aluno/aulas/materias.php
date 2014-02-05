<?
$aluno_id= $_SESSION['aluno']->id;

?>
<script>
$('.ops').live('click',function(){
	salamateria_id=$(this).attr('id');
	location = '?tela_id=287&salamateria_id='+salamateria_id;
});
</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
		<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Matérias
</a>
</div>
<div id="barra_info">
  <select name="matricula_id" id='matricula_id'  >
    <?
	$q = mysql_query($t="SELECT *,ee.nome as escola,
				  ep.nome as periodo,
				  ea.nome as aluno,
				  emodulo.nome as modulo,
				  es.nome as sala,
				  es.id as sala_id,
				  eh.nome as horario,
				  em.id as idmatricula,
				  ea.id as idaluno,
				  ec.nome as curso	 
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
	echo $t;
	$i=0;
	while($r= mysql_fetch_object($q)){
		$i++;
		if($i==1){
			$matricula_id= $r->id;	
			$sala_id= $r->sala_id;	
		}
?>
    <option value="<?=$r->sala_id?>">Matricula: <?=$r->idmatricula?> - <?=$r->escola?> - <?=$r->curso?> - <?=$r->modulo?> - <?=$r->sala?></option>
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
	  $mat_turma_professor = mysql_query($g="SELECT 
									  *,es.id as periodo_materia_id, es.id as smpid
								  FROM 
									  escolar_sala_materia_professor es , 	
										  escolar_materias  m 
								  WHERE 
								  	 es.materia_id = m.id
								  AND
									  es.sala_id  = '$sala_id'
								  AND 
									  es.vkt_id = '$vkt_id' " );
					while($r=mysql_fetch_object($mat_turma_professor)){
		$total++;
		if($total%2){$sel='class="al ops"';}else{$sel='class="ops"';}

	?>
<tr <?=$sel?> id="<?=$r->smpid?>" >
               <td width="250" id="descricao"><?=$r->nome?></td>
               <td>
               <?
               
			   echo @mysql_result(mysql_query($t="SELECT count(*) FROM  escolar_aula WHERE  sala_materia_professor_id='$r->smpid'  "),0,0);
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
<div id='rodape'>
  <div style="float:right; margin:0px 20px 0 0"></div>
</div>
