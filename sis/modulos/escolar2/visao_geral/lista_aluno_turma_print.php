<?php
include("../../../_config.php");

include ("_functions.php");
include ("_ctrl.php");
include("../../../_functions_base.php");
 
 $turma_id = $_GET["turma_id"];
 
 if( !empty($turma_id) ){
 	$turmas = mysql_fetch_object(mysql_query(" SELECT *,turma.nome AS nome_turma FROM escolar2_turmas AS turma WHERE id = '".trim($turma_id)."' "));
	$nome_turma = $turmas->nome_turma;
 }
	
 
 			$sql_matricula = mysql_query(" SELECT * FROM escolar2_matriculas WHERE 
					vkt_id = '$vkt_id' 
				AND turma_id = ".trim($turma_id)." 
				AND matricula_rematricula = '".trim($_GET["tipo"])."' 
				AND status != 'cancelada' ");
			 
			 if( $_GET["tipo"] == "todos" ){
			 	$sql_matricula = mysql_query(" SELECT * FROM escolar2_matriculas WHERE vkt_id = '$vkt_id' 
				AND turma_id = ".trim($turma_id)." 
				AND status != 'cancelada' ");
					
			 } 
			 
			 if( !empty($_GET["serie_id"])  ){
				 
				 $sql_matricula = mysql_query($t=" 
				 SELECT *,turma.nome AS nome_turma FROM escolar2_matriculas AS matricula
				
				JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
				JOIN escolar2_series AS serie ON serie.id = turma.serie_id 
				
				WHERE matricula.vkt_id = '$vkt_id' 
				AND turma.serie_id = ".trim($_GET["serie_id"])." 
				AND turma.periodo_letivo_id = ".trim($_GET["periodo_letivo"])."
				AND matricula.status != 'cancelada' ORDER BY turma.nome ASC ");	
				 
			  } 
			  
			  if( !empty($_GET["sala_id"])  ){
				 
				 $sql_matricula = mysql_query($t=" 
				 SELECT * FROM escolar2_matriculas AS matricula
				
				JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
				
				WHERE matricula.vkt_id = '$vkt_id' 
				AND matricula.status != 'cancelada' 
				AND turma.sala_id = ".trim($_GET["sala_id"])." 
				AND turma.periodo_letivo_id = ".trim($_GET["periodo_letivo"])."
				ORDER BY turma.nome ASC ");
				 
			  }
			  
			  if( !empty($_GET["turma_id"]) and !empty($_GET["horario_id"]) ){
				   $sql_matricula = mysql_query($t=" 
				 SELECT * FROM escolar2_matriculas AS matricula
				
				JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
				
				WHERE matricula.vkt_id = '$vkt_id' 
				AND matricula.status != 'cancelada' 
				AND matricula.turma_id = '".trim($_GET["turma_id"])."'	
				AND turma.horario_id = '".trim($_GET["horario_id"])."'  
				AND turma.periodo_letivo_id = ".trim($_GET["periodo_letivo"])."
				ORDER BY turma.nome ASC ");
			  }

?>

<style>
*{ box-sizing: border-box;-moz-box-sizing: border-box; }
 body{ margin:0;  padding:0;  background-color:#FAFAFA;  font:12pt "Tahoma"}
 /*.conteudo{margin:0 auto; border:0px solid #666; margin-top:20px}*/
 .header{margin:2px}
 .titulo{padding-left:20px; line-height:30px}
 .conteudo table{border-collapse:collapse; margin:0 auto; width:98%; margin-top:20px; margin-bottom:20px}
 h4{font-size:11pt; padding-left:10px; font-weight:inherit}
 table, th, td{ border-collapse:collapse;  border:1px solid black;  text-align:left;   padding:3px; text-transform:uppercase }
 th{ background-color:lightgrey;font-size:10pt;}
 td{ padding:4px 4px 4px 4px;  font-size:9pt}
 
.page{ width:277mm;  padding:1cm;  margin:1cm auto;  height:21cm;  border:1px #D3D3D3 solid; background:white;  box-shadow:0 0 5px rgba(0,0,0,0.1)}
@page{ size:A4;  margin:0; padding:0;}

@media print{
	.page{margin:0; border:initial; border-radius:initial; width:initial; min-height:initial; box-shadow:initial; background:initial; page-break-after:always;size: landscape}
}
</style>

<div class="page">
    <?php
	  if( !empty($nome_turma) )
    	echo "Turma:".$nome_turma;
	   
	?>
    <table width="100%">
        <thead>
            <tr>
                <th style="width:20px;">N&ordm;</th>
                <th style="width:220px;">Aluno</th>
                 <?php
                	if(empty($_GET['exibe_responsavel'])||$_GET['exibe_responsavel']=='sim'){
                ?>
                <th style="width:180px;">
                	Respons&aacute;vel
                 	
                 </th>
                <?
					}
				?>
                <th style="width:10px;">Idade</th>
                <th style="width:10px;">Nascimento</th>
                <th style="width:150px;">Turma</th>
                <th style="width:150px;">Hor&aacute;rio</th>
            </tr>
        </thead>
            <tbody>
            
            <?php
			 $cont = 0;		 
			 
			  while($turma_matricula = mysql_fetch_object($sql_matricula)){
				  $cont++;
				  //$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$turma_matricula->aluno_id'  "));
				  $aluno = @mysql_fetch_object(mysql_query($al=" SELECT *,(YEAR(CURDATE())- YEAR (a.data_nascimento)) - (RIGHT(CURDATE(),5)<RIGHT(a.data_nascimento,5)) AS age FROM escolar2_alunos as a WHERE a.id = '$turma_matricula->aluno_id' "));
				  $responsavel = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$turma_matricula->responsavel_id'  "));
				  
				  $info_turma = mysql_fetch_object(mysql_query( " SELECT *, horario.nome AS nome_horario, turma.nome AS nome_turma FROM escolar2_turmas AS turma 
				  JOIN escolar2_horarios AS horario ON turma.horario_id = horario.id
				  AND turma.id = '".trim($turma_matricula->turma_id)."'" ));
				 
        	?>
              <tr <?php echo $cl; ?> >
                  <td style="width:20px;"><?=$cont;?></td>
                  <td><?=($aluno->nome)?></td>                   
                   <?php
                		if(empty($_GET['exibe_responsavel'])||$_GET['exibe_responsavel']=='sim'){
                	?>
				  <td ><?=$responsavel->razao_social;?></td>
                  	<?php
						}
					?>
                  <td><?=$aluno->age?></td>
                  <td><?=dataUsaToBr($aluno->data_nascimento)?></td>
                  <td><?=$info_turma->nome_turma." - ".$info_turma->nome_horario;?></td>
                  <td><?=$info_turma->nome_horario;?></td>                   
                 
              </tr>

		   <?php												
			 }				   
	        ?>
            
            </tbody>
        </table>
  </div>