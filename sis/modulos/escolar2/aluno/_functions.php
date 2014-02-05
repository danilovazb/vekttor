<?php

$tabela = "escolar2_alunos";
	
  /* Funçoes Boletim  */
  function retorna_periodo_avaliacao($unidade_id = NULL){
	  global $vkt_id;
	  
	  if( !empty($unidade_id) ){
	  
		$sql_periodo_avaliacao = mysql_query($t=" 
		SELECT ab.id AS id, pa.nome AS nome, pa.id AS periodo_av 
		
		 FROM escolar2_periodos_avaliacao AS pa 
		 JOIN escolar2_avaliacao_bimestre AS ab ON ab.bimestre_id = pa.id
		
		  WHERE pa.vkt_id = '$vkt_id' AND pa.unidade_id = '$unidade_id' GROUP BY ab.bimestre_id ORDER BY pa.id ASC ");
		  
		  while($periodo_avaliacao = mysql_fetch_array($sql_periodo_avaliacao)){
			$dados[] = $periodo_avaliacao;
		  }
	  }
	  
	  if( count($dados) > 0 )
		  return $dados;
  }  
  
  function retorna_media_aluno($professor_as_turma_id = NULL, $aluno_matricula_id = NULL,$periodo_avaliacao_id = NULL, $materia_id = NULL){
	  
	  global $vkt_id;
	  
	  	$info_nota = mysql_fetch_object(mysql_query($sql=" 
		SELECT SUM(nota.nota) AS soma_nota,COUNT(*) AS qtd	  						
		 
		 FROM escolar2_avaliacao_bimestre AS avb
		 
		 JOIN escolar2_avaliacao AS av ON av.avaliacao_bimestre_id = avb.id
		 JOIN escolar2_aluno_as_avaliacao AS nota ON nota.avaliacao_id = av.id
		 
		 JOIN escolar2_professor_has_turma AS pt ON pt.id = av.professor_as_turma_id 
		 JOIN escolar2_serie_has_materias AS sm ON sm.id = pt.serie_has_materia_id
		 	
		  WHERE avb.vkt_id = '$vkt_id'
		  AND avb.bimestre_id = '$periodo_avaliacao_id'	
		  AND sm.materia_id = '$materia_id' "));
			
		if( !empty($info_nota->qtd) )	
			return number_format($info_nota->soma_nota/$info_nota->qtd,1,".",",");
			
		
  } 
  
  /*function retorna_nota_avaliacao($professor_as_turma_id = NULL, $aluno_matricula_id = NULL,$periodo_avaliacao_id = NULL, $avaliacao_id = NULL ){
	  
	  global $vkt_id;
	  	$sql_nota = mysql_query($sql="
			SELECT * FROM
			
				escolar2_avaliacao AS avaliacao
			
			JOIN escolar2_aluno_as_avaliacao AS avaliacao_nota
				ON avaliacao_nota.avaliacao_id = avaliacao.id 
			
			WHERE
				avaliacao.avaliacao_bimestre_id = '$periodo_avaliacao_id'
			AND
				matricula_aluno_id = '$aluno_matricula_id'
			AND
				avaliacao.professor_as_turma_id = '$professor_as_turma_id'
			"
			);
		//	echo $sql;
			
		
			while($r=mysql_fetch_object($sql_nota)){
				$nota[] = $r->nota;
			}
			
			return $nota;
				
		
		
  } */
  
  function retorna_nota_avaliacao($av_bimestre = NULL, $mat_aluno_id = NULL,$materia_id = NULL){
		 
	global $vkt_id;
	  		
		$sql =  mysql_fetch_object(mysql_query( $y=" 
		SELECT * 		
		  FROM escolar2_avaliacao AS av 
	  
		  JOIN escolar2_aluno_as_avaliacao AS lav ON lav.avaliacao_id = av.id
		  
		  JOIN escolar2_professor_has_turma AS pt ON pt.id = av.professor_as_turma_id
		  
		  JOIN escolar2_serie_has_materias AS sm ON sm.id = pt.serie_has_materia_id
		  
		  WHERE av.avaliacao_bimestre_id = '".$av_bimestre."'
		  AND av.vkt_id = '$vkt_id'  
		  AND lav.matricula_aluno_id = '".$mat_aluno_id."'
		  AND sm.materia_id = '".$materia_id."' "));
		
		return $sql->nota;
		
  }
  
  function retorna_faltas_presenca_aluno($professor_as_turma_id = NULL, $aluno_matricula_id = NULL,$periodo_aula_id = NULL, $tipo = 2){
	  global $vkt_id;
	  $filtro = 2;
	  
	if( $tipo == "presenca" )
		  $filtro = 1;
		  
	  $info_faltas = mysql_fetch_object(mysql_query($sql=" 	
	  SELECT  COUNT(*) AS numero_faltas
	  
	   FROM escolar2_aula AS aula 
		  
	    JOIN escolar2_frequencia_aula AS frequencia ON frequencia.aula_id = aula.id
			  
		WHERE aula.vkt_id = '$vkt_id'	  
		  AND aula.professor_as_turma_id = '$professor_as_turma_id'
		  AND aula.periodicidade_id = '$periodo_aula_id'
		  AND frequencia.matricula_aluno_id = '$aluno_matricula_id'
		  AND frequencia.presenca = '$filtro' "));
				 
	
	  if( !empty($info_faltas->numero_faltas) )
		  return $info_faltas->numero_faltas;
	  else 
		  return 0;
	  	
  }
  
  function retorna_qtd_aula_periodo($professor_as_turma_id = NULL,$periodo_id = NULL){
	  
	  global $vkt_id;
	  
	  $info_aula =  mysql_fetch_object(mysql_query(" 
	  		SELECT COUNT(*) AS qtd_aula FROM escolar2_aula 
				
			 WHERE vkt_id = '$vkt_id' 
			  AND periodicidade_id = '$periodo_id'  
			  AND professor_as_turma_id = '$professor_as_turma_id'	"));
	 	
		return $info_aula->qtd_aula;
  }
  
   function retorna_serie_materia($serie_id = NULL, $turma_id = NULL){
	  	
	  $sql_materia = mysql_query($ty=" 
	  SELECT materia.nome AS nome_materia, 
		materia.id AS materia_id, 
		serie_materia.serie_id AS serie_id, 
		turma.id AS turma_id, 
		pt.id AS professor_has_turma   
					
		FROM escolar2_serie_has_materias AS serie_materia		
		  
		  JOIN escolar2_materias AS materia ON materia.id = serie_materia.materia_id
			  
		  JOIN escolar2_turmas AS turma ON turma.serie_id = serie_materia.serie_id
			  
		  JOIN escolar2_professor_has_turma AS pt ON pt.turma_id = turma.id
		  
		  AND serie_materia.serie_id = '$serie_id'
		  
		  AND turma.id = '$turma_id'
			  
		  GROUP BY materia_id
		 ");
		
		 while($materia = mysql_fetch_array($sql_materia)){
			 $dados[] = $materia;
		  }
		  
		  
		  if( count($dados) > 0 )
		  return $dados;
			
  }
  
  function retorna_avaliacao_periodo($serie_id = NULL, $turma_id = NULL, $avaliacao_bimestre_id = NULL){
	  global $vkt_id;
	  /*$sql =  mysql_fetch_object (mysql_query($ty="
	  	SELECT COUNT(*) AS qtd FROM escolar2_avaliacao 
			WHERE  vkt_id = '$vkt_id'	AND
			avaliacao_bimestre_id = '$avaliacao_bimestre_id'
			GROUP BY professor_as_turma_id
			ORDER BY qtd DESC LIMIT 1 "));
	  	
		   for( $i=1; $i <= ($sql->qtd); $i++ ){
			   $dados[] = $i;
			}
			return $dados;*/		
	$sql = mysql_query(" SELECT * FROM escolar2_avaliacao_bimestre 	WHERE bimestre_id = '$avaliacao_bimestre_id' ");
	while($result = mysql_fetch_array($sql)){
		$dados[] = $result;
	}
	//echo $sql."<br/>";
	return $dados;
  }
  
  function retorna_avaliacao_periodo_id($serie_id = NULL, $turma_id = NULL, $avaliacao_bimestre_id = NULL){
	  	$sql_materia = mysql_query($ty=" SELECT 
		  
		  materia.nome AS nome_materia, 
		  materia.id   AS materia_id, 
		  serie_materia.serie_id AS serie_id, 
		  turma.id		AS turma_id, 
		  professor_turma.id AS professor_has_turma,
		  avaliacao.avaliacao_bimestre_id AS avaliacao_bimestre_id,
		  avaliacao.descricao AS descricao,
		  avaliacao.id AS avaliacao_id
					  
		  FROM escolar2_serie_has_materias AS serie_materia			/* Seleciona as materias da Serie */
		  	
			JOIN escolar2_materias AS materia
				ON materia.id = serie_materia.materia_id			/* Comparaçao com ( materia )*/
				
			JOIN escolar2_turmas AS turma							/* Comparaçao com ( turma )*/
				ON turma.serie_id = serie_materia.serie_id
				
			JOIN escolar2_professor_has_turma AS professor_turma
				ON professor_turma.serie_has_materia_id = serie_materia.id	/* Comparaçao com ( professor turma )*/
				
			JOIN escolar2_avaliacao AS avaliacao ON avaliacao.professor_as_turma_id = professor_turma.id
			
			AND serie_materia.serie_id = '$serie_id'
			
			AND turma.id = '$turma_id'
			
			AND avaliacao.avaliacao_bimestre_id = '$avaliacao_bimestre_id' ");
		   
		 //echo $ty."<br/>";
		   
		   while($materia = mysql_fetch_array($sql_materia)){
			   $dados[] = $materia;
			}
			
			
			if( count($dados) > 0 )
			return $dados;
  }  
  
  function ocorrencia_aluno($aluno_matricula_id = NULL){
	  
	  $sql = mysql_query(" 
	  	SELECT 
			 aula_ocorrencia.observacao AS ocorrencia,
			 aula.data AS data_aula
		FROM 
			escolar2_obs_aluno_aula AS aula_ocorrencia 
		JOIN escolar2_aula AS aula
			ON aula.id = aula_ocorrencia.aula_id
		
		WHERE 
			aula_ocorrencia.matricula_aluno_id = '$aluno_matricula_id' ");
	  
	  while($registros = mysql_fetch_array($sql)){
		  $dados[] = $registros;
	  }
	  
	  return $dados;
  }  
  
  
  function calculo_porcentagem_faltas($numero_faltas = NULL, $numero_aulas = NULL){
	  
	  if( !empty($numero_faltas) )
	  	$porcent_falta = ((100 * $numero_faltas) / $numero_aulas); 
	  
	  return $porcent_falta;
  }
  function formula_unidade($unidade_id = NULL){
	   global $vkt_id;
	   
	   $sql =  mysql_fetch_object( mysql_query(" SELECT escolar2_unidades.formula_media AS formula FROM escolar2_unidades WHERE vkt_id = '$vkt_id' AND id = '$unidade_id' "));
	   
	   return $sql->formula;
	   
  }
  
  /*
  	Fim Funçoes Boletim  
  */

  function cadastra () {
	  
	  global $tabela,$vkt_id;
	  
	  $acao = "";
	  $where = "";
	  
	  if (!empty($_POST['aluno_id']) ){
		  $acao = "UPDATE";
		  $where = "WHERE id = '" . mysql_real_escape_string($_POST['aluno_id']) . "'";
	  } else {
		  $acao = "INSERT INTO";	
	  }
	  
	  mysql_query ($ty="$acao $tabela SET
	   vkt_id                 = '$vkt_id',
	   cor                    = '{$_POST['cor']}',
	   codigo_interno         = '{$_POST['codigo_interno']}',
	   nome 					= '{$_POST['nome']}',
	   data_nascimento		= '".dataBrToUsa($_POST['data_nascimento'])."',
	   endereco				= '{$_POST['endereco']}',
	   bairro					= '{$_POST['bairro']}',
	   escolaridade			= '{$_POST['escolaridade']}',
	   profissao				= '{$_POST['profissao']}',
	   complemento			= '{$_POST['complemento']}',
	   telefone1				= '{$_POST['telefone1']}',
	   telefone2				= '{$_POST['telefone2']}',
	   cep					= '{$_POST['cep']}',
	   cidade					= '{$_POST['cidade']}',
	   uf						= '{$_POST['uf']}',
	   rg						= '{$_POST['rg']}',
	   rg_dt_expedicao		= '{$_POST['rg_dt_expedicao']}',
	   cpf					= '{$_POST['cpf']}',
	   email					= '{$_POST['email']}',
	   
	   turma                  = '{$_POST['turma']}',
	   turno                  = '{$_POST['turno']}',
	   responsavel_id         = '{$_POST['responsavel_id']}',
	   
	   mae                    = '{$_POST['mae']}',
	   cpf_mae                = '{$_POST['cpf_mae']}',
	   tel_mae                = '{$_POST['telefone_mae']}',
	   profissao_mae          = '{$_POST['profissao_mae']}',
	   local_trabalho_mae     = '{$_POST['local_trabalho_mae']}',
	   tel_trabalho_mae       = '{$_POST['tel_trabalho_mae']}',
	   email_mae              = '{$_POST['email_mae']}',
	   
	   pai                    = '{$_POST['pai']}',
	   cpf_pai                = '{$_POST['cpf_pai']}',
	   tel_pai                = '{$_POST['telefone_pai']}',
	   profissao_pai          = '{$_POST['profissao_pai']}',
	   local_trabalho_pai     = '{$_POST['local_trabalho_pai']}',
	   tel_trabalho_pai       = '{$_POST['tel_trabalho_pai']}',
	   email_pai              = '{$_POST['email_pai']}',
	   
	   pessoa_trazer_buscar_1 = '{$_POST['pessoa_trazer_buscar_1']}',
	   pessoa_trazer_buscar_2 = '{$_POST['pessoa_trazer_buscar_2']}',
	   pessoa_trazer_buscar_3 = '{$_POST['pessoa_trazer_buscar_3']}',
	   pessoa_trazer_buscar_4 = '{$_POST['pessoa_trazer_buscar_4']}',
	   
	   pessoa_caso_emergencia_1 = '{$_POST['pessoa_emergencia_1']}',
	   telefone_caso_emergencia_1  = '{$_POST['fone_emergencia_1']}',
	   
	   pessoa_caso_emergencia_2   = '{$_POST['pessoa_emergencia_2']}',
	   telefone_caso_emergencia_2 = '{$_POST['fone_emergencia_2']}',
	   restricao_alimentar        = '{$_POST['restricao_alimentar']}',
	   senha	 					= '{$_POST['senha']}',
	   observacao                 = '{$_POST['observacao']}'
	   
	   $where");
	   //echo $ty;
	   
		if($_POST['aluno_id'] > 0){
		   $aluno_id = $_POST['aluno_id'];
	   }else{
		  $aluno_id = mysql_insert_id();
	   }
	   
	   
	   $extensao = getExtensao($_FILES['file']['name'][0]);
	  if($extensao!='php'){
		  
		  if(move_uploaded_file($_FILES['file']['tmp_name'][0], "modulos/escolar/alunos_inscritos/img/".$aluno_id.".$extensao")){
			  
			  mysql_query($ql="UPDATE $tabela set extensao = '$extensao' WHERE id = '$aluno_id' AND vkt_id='$vkt_id'");
		  }
	  }	
	  
	  //echo '<br/>'.$aluno_id;
	  
  } /*fim*/

  function remove_imgem($id){
	  global $tabela,$vkt_id;
	  $info = mf(mq("SELECT * FROM $tabela WHERE id='$id' AND vkt_id='$vkt_id'"));
	  $extensao = $info->extensao;
	  if($info->id>0){
		  unlink("modulos/escolar/alunos_inscritos/img/".$id.".$extensao");
		  mysql_query($q="UPDATE $tabela set extensao ='' WHERE id= '$id' AND vkt_id='$vkt_id'");
	  }
	  
	  
  }

  function remover () {
	  global $tabela,$vkt_id;
	  $info = mf(mq("SELECT * FROM escolar_matriculas WHERE aluno_id='{$_POST[aluno_id]}' AND vkt_id='$vkt_id'"));
	  if($info->id<1){
		  $q = mysql_query ($trace = "DELETE FROM $tabela WHERE id = '" . mysql_real_escape_string($_POST['aluno_id']) . "' AND vkt_id='$vkt_id'");	
	  }
  }
?>