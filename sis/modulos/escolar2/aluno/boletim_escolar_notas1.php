<?php
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
//include("_ctrl.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Boletim Escolar</title>
<style>
body{font-family:Arial,Helvetica,sans-serif; font-size:11pt}
.cabecalho{background-color:#CCC}
.conteudo-geral{border:2px outset #333; margin:0 auto; width:960px}
.boletim_header{ padding:10px}
.boletim_header .negrito{font-weight:bold}
.titulo_boletim{font-size:40px}
.titulo_boletim .titulo h4{font-family:Verdana,Geneva,sans-serif; float:left; margin-top:25px; margin-left:20px}
.logo{float:left; margin-top:10px}
.content-table{padding:20px}
table{border-collapse:collapse}
.tbl_header_1 th, .tbl_header_2 th{padding:8px 8px; border-bottom:1px solid #999; font-size:10pt;}
.cinza{color:#999}
.maiuscula{text-transform:uppercase}
td{padding:4px; padding-left:3px}
.table-content tr td{border-bottom:1px solid #999; border-right:1px solid #999; font-size:10px; font-weight:bold}
.table-content tr, .table-content th{border:1px solid #666;font-size:10pt;}
</style>
</head>

<body>

<div class="conteudo-geral">

<?php
 	
	$info_header = mysql_fetch_object(mysql_query($gh="  
	  SELECT 
		  
	  periodo_letivo.nome AS ano_letivo, periodo_letivo.id AS ano_letivo_id,	/* Informações Ano Letivo */
	  unidade.nome        AS nome_unidade, unidade.id AS unidade_id,			/* Informações da Unidade */
	  serie.nome          AS nome_serie, serie.id AS serie_id,					/* Informações da Série */
	  aluno.nome          AS nome_aluno,										/* Nome do aluno */
	  turma.nome		  AS nome_turma, turma.id AS turma_id, 					/* Informações da Turma */
	  horario.nome		  AS nome_horario,										/* Nome do Horário */
	  matricula.id        AS matricula_aluno									/* Matricula do aluno */
	  
	  FROM escolar2_matriculas AS matricula 									/* Seleciona a tabela matriculas */
	  
	  JOIN escolar2_turmas AS turma
		  ON turma.id = matricula.turma_id				/* Comparação com ( turmas ) */
		  
	  JOIN escolar2_alunos AS aluno
		  ON aluno.id = matricula.aluno_id				/* Comparação com ( aluno ) */
		  
	  JOIN escolar2_periodo_letivo AS periodo_letivo
		  ON turma.periodo_letivo_id = periodo_letivo.id	/* Comparação ( período letivo ) */
	  
	  JOIN escolar2_unidades AS unidade
		  ON unidade.id = turma.unidade_id 				/* Comparação ( unidade ) */	
		  
	  JOIN escolar2_series AS serie
		  ON serie.id = turma.serie_id					/* Comparação ( serie ) */
		  
	  JOIN escolar2_horarios AS horario
		  ON horario.id = turma.horario_id				/* Comparação ( horario ) */
	  
	  WHERE 
		  aluno.id = '".$_GET["aluno_id"]."' "));
		  		 
		 $formala_unidade = formula_unidade($info_header->unidade_id);
		 
		 /* retorna os períodos de avaliacao da unidade */
		 $periodo_avaliacao = retorna_periodo_avaliacao($info_header->unidade_id);
		 /*
		 echo "<pre>";
		 		 print_r($info_header);
		 echo "Formula Unidade";
		 		 print_r($formala_unidade);
		 echo "Periodo";
		 		 print_r($periodo_avaliacao);

		 echo "</pre>";
			*/		
?>

<div class="boletim_header">
  
  <div class="titulo_boletim">
    <div class="logo"><img src="http://vkt.srv.br/~nv/sis/<?=$logo?>"  /></div>
    <div class="titulo"> <h4> Boletim Escolar</h4> </div>
  </div>
  <div style="clear:both;"></div>
  
 
  
  <table class="tbl_header_1" width="100%">
    <thead>
      <tr>
        <th align="left"> <span class="negrito maiuscula"> Escola: </span> <span  class="cinza"> &nbsp; <?=strtoupper($info_header->nome_unidade)?> </span> </th>
        <th align="left"> <span class="negrito maiuscula"> Ano Letivo: </span> <span  class="cinza maiuscula"> &nbsp; <?=$info_header->ano_letivo?> </span> </th>
      </tr>
    </thead>
  </table>
  <br/>
  <table class="tbl_header_2" width="100%" >
    <thead>
      <tr>
        <th align="left"> <span class="maiuscula"> Aluno: </span> <span style="width:280px;text-align:left" class="cinza maiuscula"> <?=$info_header->nome_aluno?></span></th>
        <th align="left"> <span class="maiuscula"> Série: </span> <span style="width:100px;text-align:left" class="cinza maiuscula"> <?=$info_header->nome_serie?></span></th>
        <th align="left"> <span class="maiuscula"> Turma: </span> <span style="width:165px;text-align:left" class="cinza maiuscula"> <?=$info_header->nome_turma?></span></th>
        <th align="left"> <span class="maiuscula"> Turno: </span> <div style="float:right; width:115px;" class="cinza maiuscula"> <?=$info_header->nome_horario?></div></th>
      </tr>
    </thead>
  </table>
  
  
 
</div>
	
	<div style="margin:0px auto;" >
       
       <div style="min-height:250px;"  class="content-table">
       
       	<table class="table-content" style="width:100%;">
          
          <tr align="center" class="cabecalho"><!--tr-->
             <th rowspan="2" width="150">Disciplinas</th>
             	<?
                for($i=0;$i<count($periodo_avaliacao);$i++){
				?>
                <th colspan="<?=count( $periodo_avaliacao[$i][avaliacoes])+1?>"> <?php echo $periodo_avaliacao[$i][nome]?> </th>
                <?
				}
				?>
                <th width="80"> Média Final </th>
                <th width="80"> Resultado Final </th>
                                              
          </tr> <!--/tr-->
          
          <tr><!--tr-->
               	<?
                for($i=0;$i<count($periodo_avaliacao);$i++){
				$avaliacoes = count($periodo_avaliacao[$i][avaliacoes]);
               	 for($j=0;$j<$avaliacoes;$j++){
				?>
            <td align="center" ><?=$periodo_avaliacao[$i][avaliacoes][$j].'ª' ?></td>
                <?
				 }
				 ?>
            <td align="center" > Media </td>
				 <?
				}
				?>
            
              <td width="80"></td>
              <td width="80"></td>
                           
          </tr> <!--/tr-->
          
          <?php          	
			$info_serie_materia  =  retorna_serie_materia($info_header->serie_id,$info_header->turma_id);
			
			for($s=0;$s < count($info_serie_materia); $s++){
			
		  ?>
           <tr>
           		<td><?=$info_serie_materia[$s]["nome_materia"]?></td>
                
               	<?
                for($i=0;$i<count($periodo_avaliacao);$i++){
					$notas = retorna_nota_avaliacao($info_serie_materia[$s]["professor_has_turma"],$info_header->matricula_aluno, $periodo_avaliacao[$i][id],0);
					 $avaliacoes = count($periodo_avaliacao[$i][avaliacoes]);
					 for($j=0;$j<$avaliacoes;$j++){
				?>
            <td align="center" ><?=$soma_bimestre[$info_serie_materia[$s]["nome_materia"]][]=$notas[$j]?></td>
                <?
				}
			?>
			                <td align="center" ><?=@(@array_sum($soma_bimestre[$info_serie_materia[$s]["nome_materia"]])/count($notas))?></td>

			<?
				}
				?>
                <td align="center" >-</td>
                <td align="center" >-</td>
           </tr> 
           
          <?
			}
		  ?>
		</table>
      </div> 
      
    </div>
  <div>           	
</div>
 	<div style="color: #666;font-size: 10px; margin:0 auto; text-align:center; padding:3px;"> &copy; Vekttor </div>		
</div>
</body>
</html>
