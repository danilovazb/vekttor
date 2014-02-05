<?php
include("../../../../_config.php");
?>
<style>
#pagina{
	width:840px;
	background:#FFFFFF;
	margin:0px auto;
}
.info_qtd_registro{
	background:#f9f9f9;
	border:1px solid #f5f5f5;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;	
}

@media (min-width: 768px) and (max-width: 979px) { .info_qtd_registro{background:#CCC;}} 
@media (max-width: 767px) { .info_qtd_registro{ background:#CCC;}}

</style>
<?php

	if( !empty($_GET["relatorio_id"]) ){
		$id = $_GET["relatorio_id"];
		$sql = mysql_query($s=" SELECT  aluno.nome AS aluno_nome,  relatorio.texto AS texto
			FROM escolar2_relatorio_individual_bimestre AS relatorio
	
			JOIN escolar2_matriculas AS matricula
				ON relatorio.matricula_aluno_id = matricula.id
				
			JOIN escolar2_alunos AS aluno
				ON matricula.aluno_id = aluno.id
	
			WHERE relatorio.id = '$id'");
	}
	
	if( !empty($_GET["turma_id"]) and !empty($_GET["bimestre_id"]) ){
		
		$sql = mysql_query($s=" SELECT  aluno.nome AS aluno_nome,  relatorio.texto AS texto
			FROM escolar2_relatorio_individual_bimestre AS relatorio
	
			JOIN escolar2_matriculas AS matricula
				ON relatorio.matricula_aluno_id = matricula.id
				
			JOIN escolar2_alunos AS aluno
				ON matricula.aluno_id = aluno.id
	
			WHERE 
			
			matricula.turma_id = '".trim($_GET["turma_id"])."' AND relatorio.bimestre_id = '".trim($_GET["bimestre_id"])."' ");
	}
	
	if( !empty($_GET["bimestre_id"]) and empty($_GET["turma_id"])){
		
		$sql = mysql_query($s=" SELECT  aluno.nome AS aluno_nome,  relatorio.texto AS texto
			FROM escolar2_relatorio_individual_bimestre AS relatorio
	
			JOIN escolar2_matriculas AS matricula
				ON relatorio.matricula_aluno_id = matricula.id
				
			JOIN escolar2_alunos AS aluno
				ON matricula.aluno_id = aluno.id
	
			WHERE 
			
			 relatorio.bimestre_id = '".trim($_GET["bimestre_id"])."' ");
	}
	
  	$cont= 0;
	while($info_relatorio=mysql_fetch_object($sql)){
	$cont++;
	$mods = array( '@aluno_nome'=>"$info_relatorio->aluno_nome");
	 
	  
	  foreach ($mods as $key => $value) {
		  $texto = str_replace($key,$value,$info_relatorio->texto);
		  
	  }
	  
	  ?>
      <div id="pagina" style="text-align:justify">
		<div style="clear:both"></div><?php echo $texto; ?>
	  </div>
      <?
	
	}
	
?>
<div class="info_qtd_registro" style="color: #666;font-size: 12px; text-align:right; top:20px; padding:3px; width:200px; position:fixed; font-weight:bold; " > <?php echo " Total : ".$cont." Relat&oacute;rios ";?> </div>



