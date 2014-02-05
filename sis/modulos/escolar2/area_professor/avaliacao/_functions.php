<?php

	function ImportarArquivo(){
		global $vkt_id;
		$av_id = "";
		$lines = file($_FILES["arquivo"]["tmp_name"]);

		  foreach ($lines as $line_num => $line) {
			  $array_arquivo =  explode("\r",$line);
		  }	
		  
		  foreach($array_arquivo as $indice => $valor){
			  $array_notas = explode(";",$valor);
			  
			  for($i=0; $i < count($array_notas);$i++){
				  
				  if( empty($av_id) ){
					 $verifica_avaliacao =  verifica_avaliacao_importacao($array_notas[1],$_POST["professor_has_turma"]);
						
					if( empty($verifica_avaliacao) ) {
						$acao = " INSERT INTO  ";
						$av_id = insere_avaliacao_importacao($array_notas[1],$_POST["professor_has_turma"]);
					} else {
						$acao = " UPDATE ";
						$av_id = $verifica_avaliacao;
					}
				  }
					
					if( empty($verifica_avaliacao) )
						$where = "";
					else
				 		$where = " WHERE avaliacao_id = '$av_id' AND matricula_aluno_id = '$array_notas[0]' ";	
	
				  $sql = " $acao escolar2_aluno_as_avaliacao SET  
				  vkt_id             = '$vkt_id',
				  matricula_aluno_id = '".($array_notas[0])."',
				  avaliacao_id       = '".($av_id)."',
				  nota = '".moedaBrToUsa($array_notas[3])."' $where ";
				 
			  }
			   mysql_query($sql);
		  }	
	}
	
	function verifica_avaliacao_importacao($av_bimestre=NULL, $professor = NULL){
		global $vkt_id;
		$verifica_avaliacao = " SELECT * FROM escolar2_avaliacao WHERE 
		  vkt_id = '$vkt_id' 
		AND avaliacao_bimestre_id = ".$av_bimestre." 
		AND professor_as_turma_id = ".$professor." ";	
		  
		  $info_avaliacao = mysql_fetch_object(mysql_query($verifica_avaliacao));
		  	return $info_avaliacao->id;
	}
	
	function insere_avaliacao_importacao($av_bimestre = NULL,$professor_has_turma = NULL){
		 global $vkt_id;
		 mysql_query(" INSERT INTO escolar2_avaliacao SET 
			vkt_id = '$vkt_id',
			avaliacao_bimestre_id = ".$av_bimestre.", 
			professor_as_turma_id = ".$professor_has_turma.", 
			data = ".date("Y-m-d")." "); 
				  	
		$av_id = mysql_insert_id();
		return $av_id;
	}
	
	function verifica_nota_aluno_importacao($avaliacao_id = NULL, $matricula_id = NULL ){
		global $vkt_id;
		 
		 $s_nota = " SELECT * FROM escolar2_aluno_as_avaliacao WHERE vkt_id = '$vkt_id' AND avaliacao_id = '".$avaliacao_id."' AND matricula_aluno_id = '".$matricula_id."'  ";	
		
		 $nota_aluno = mysql_fetch_object(mysql_query( $s_nota )); 
		 return $nota_aluno->id;
		
	}
	
	function consulta_materia($professor_turma){
		global $vkt_id;
		
		$dados = array();
		
		$result = mysql_fetch_object(mysql_query(" 
		SELECT *, materia.nome AS materia_nome, turma.nome AS turma_nome FROM escolar2_professor_has_turma AS professor_turma 
			JOIN escolar2_turmas AS turma 
				ON turma.id = professor_turma.turma_id
			
			JOIN escolar2_serie_has_materias AS serie_materia 
				ON serie_materia.id = professor_turma.serie_has_materia_id
			
			JOIN escolar2_materias AS materia 
				ON materia.id = serie_materia.materia_id
			
			WHERE professor_turma.id = '$professor_turma' "));
		
		$result2 = mysql_fetch_object(mysql_query("SELECT *, funcionario.nome AS nome_professor FROM escolar2_professor_has_turma AS professor_turma
			JOIN escolar2_professores AS professor 
				ON professor.id = professor_turma.professor_id
			
			JOIN rh_funcionario AS funcionario 
				ON funcionario.id = professor.funcionario_id
			
			WHERE professor_turma.id = '$professor_turma'		
		"));
		
		
		$dados["materia"] = $result->materia_nome;
		$dados["turma"] = $result->turma_nome;
		$dados["professor"] = $result2->nome_professor;
		
		return $dados;
			
	}
	
	function altera_avaliacao($campos){
		global $vkt_id;
			$sql_update = " UPDATE escolar_avaliacao
							 SET
									 descricao        = '$campos[descricao]',
									 data             = '".dataBrToUsa($campos[data_avaliacao])."',
									 obs              = '$campos[obs]',
									 periodicidade_id = '$campos[periodicidade_id]'
							 WHERE 
							 		id = '$campos[id]'
							 AND 
							 		vkt_id = '$vkt_id'
							 	
			";
			//echo $sql_update;
			mysql_query($sql_update);
	}
	
	function update_relatorio($campos){
		$sql = mysql_query(" UPDATE escolar2_relatorio_individual_bimestre SET texto = '$campos[texto]' WHERE id = '$campos[relatorio_id]' ");
	}
	
	function insere_avaliacao($campos){
			global $vkt_id;
			
		$acao = "INSERT INTO";
		$where = "";
		
		if (!empty($_POST['id']) ){
			$acao = "UPDATE";
			$where = "WHERE id = '" . mysql_real_escape_string($_POST['id']) . "'";
		} 		
						
		  $sql_insert = " $acao escolar2_avaliacao SET
		  	
			vkt_id = '$vkt_id',
			periodicidade_id = '$campos[periodicidade_id]',
			professor_as_turma_id = '$campos[professor_as_turma_id]',
			descricao        = '$campos[descricao]',
			data             = '".dataBrToUsa($campos['data_avaliacao'])."',
			status           = '1',
			observacao       = '$campos[observacao]',
			nota_escrita     = '$campos[nota_escrita]'
			$where ";
						  
		  //echo $sql_insert;
		  mysql_query($sql_insert);
	}
	
	function lista_alunos_para_avaliacao($turma_id = NULL, $busca = NULL){
		global $vkt_id;
		$filter = "";
		
		if( !empty($busca) )
			$filter = " AND aluno.nome like '%".$busca."%' ";	
		
		
		$sql = mysql_query($s=" 
		SELECT 
	
			matricula.id AS matricula_id,
			aluno.nome   AS nome_aluno
			 
		FROM escolar2_matriculas AS matricula 
		
		JOIN escolar2_alunos AS aluno
			ON matricula.aluno_id = aluno.id
		
		WHERE 
			matricula.vkt_id = '$vkt_id' 
		AND 
			matricula.turma_id = '$turma_id' 
		AND
			matricula.status != 'cancelada'	
		$filter	");
		
		while($registro = mysql_fetch_array($sql)){
			$dados[] = $registro;
		}
		
		return $dados;
			
	}
	
	function lista_avaliacao_bimestre($bimestre_id = NULL, $unidade_id = NULL, $ensino_id = NULL, $avaliacao_id = NULL){
		global $vkt_id;
		
		$filterAv = !empty($avaliacao_id) ? "AND id = {$avaliacao_id} " : NULL;
	
		$sql=mysql_query($s="
		SELECT 
		* 
		FROM escolar2_avaliacao_bimestre 
		WHERE 
			vkt_id = '$vkt_id' 
		AND 
			bimestre_id = '$bimestre_id'
		AND
			ensino_id = '$ensino_id'
		AND
			unidade_id = '$unidade_id'
		$filterAv
		ORDER BY ordem 	");
		
		while($registro = mysql_fetch_array($sql)){
			$dados[] = $registro;
		}	
		
		return $dados;
		
	}
	
	function tipo_campo($tipo=NULL,$matricula_id = NULL, $avaliacao_id = NULL, $nota = NULL){
		
		if( !empty($tipo) ){
		
				if($tipo == "nota"){
					echo " <input type='text' style='width:40px;text-align:right;' matricula='".$matricula_id."' avaliacao='".$avaliacao_id."' sonumero='1' decimal='1' name='nota_aluno' id='nota_aluno' value='".qtdUsaToBr($nota,1)."' /> ";	
				} 
				else if($tipo == "letra"){
					echo " <input type='text' style='width:40px; text-align:right;text-transform:uppercase' matricula='".$matricula_id."' avaliacao='".$avaliacao_id."' name='nota_aluno' maxlength='5' id='nota_aluno' value='".qtdUsaToBr($nota,1)."' /> ";
				} 
			
		}
	}
	
	function tipo_conceito($texto = NULL,$matricula_id=NULL,$avaliacao_id = NULL, $nota_dada = NULL){
		$erro = 0;
		$encontrar = ",";
			
		$pos = strpos(trim($texto), $encontrar);
				
			if ( !($pos === false) ) {
				
				$array_conceito = explode(",",$texto);
				$sel = "";
				foreach($array_conceito as $indice => $conceito){
					
					if( $conceito == $nota_dada)
						$sel = 'checked="checked"';
					else 
						$sel = '';
						
					echo " <div><input type='radio' ".$sel." indice='".$indice."' matricula='".$matricula_id."' avaliacao='".$avaliacao_id."' name='nota_conceito_".$matricula_id."_".$avaliacao_id."' id='nota_conceito' value='".$conceito."'> ".$conceito."</div>";
				}
				
			} else{
				$erro++;	
			}
		
		
		if($erro > 0){
			echo " Verifique o texto para conceito de notas ";	
		}
		
	}
	
	function verifica_nota_lancada($avalicao_bimestre_id = NULL, $professor_turma_id = NULL, $matricula_aluno_id = NULL){
		global $vkt_id;
		$sql_avaliacao = mysql_fetch_object(mysql_query(" 		
			SELECT * FROM escolar2_avaliacao AS avaliacao 
				JOIN escolar2_aluno_as_avaliacao AS nota_avaliacao 
					ON avaliacao.id = nota_avaliacao.avaliacao_id
			WHERE 
				avaliacao.vkt_id = '$vkt_id' 
			AND 
				avaliacao.avaliacao_bimestre_id = '".$avalicao_bimestre_id."' 
			AND 
				avaliacao.professor_as_turma_id = '".$professor_turma_id."' 
			AND
				nota_avaliacao.matricula_aluno_id = '".$matricula_aluno_id."'	
			"));
			
		return $sql_avaliacao->nota_escrita;
		
	}
	
	function verifica_nota_lancada_numerica($avalicao_bimestre_id = NULL, $professor_turma_id = NULL, $matricula_aluno_id = NULL){
		global $vkt_id;
		$sql_avaliacao = mysql_fetch_object(mysql_query(" 		
			SELECT * FROM escolar2_avaliacao AS avaliacao 
				JOIN escolar2_aluno_as_avaliacao AS nota_avaliacao 
					ON avaliacao.id = nota_avaliacao.avaliacao_id
			WHERE 
				avaliacao.vkt_id = '$vkt_id' 
			AND 
				avaliacao.avaliacao_bimestre_id = '".$avalicao_bimestre_id."' 
			AND 
				avaliacao.professor_as_turma_id = '".$professor_turma_id."' 
			AND
				nota_avaliacao.matricula_aluno_id = '".$matricula_aluno_id."'	
			"));
			
		return $sql_avaliacao->nota;
		
	}
	
	function cadastra_relatorio_individual($campos){
		 global $vkt_id;
		$sql = " 
		INSERT INTO escolar2_relatorio_individual_bimestre SET
		vkt_id      = '$vkt_id',
		bimestre_id = '{$campos[bimestre_id]}',
		modelo_relatorio_id    = '{$campos[modelo_relatorio_id]}',
		matricula_aluno_id     = '{$campos[matricula_aluno_id]}',
		texto                  = '".($campos["texto"])."' ";
		
		mysql_query($sql);
	}
	
	function ExportarArquivo(){
		
		 $bimestre_id = $_POST["bimestre_id"];
		 $unidade_id = $_POST["unidade_id"];
		 $ensino_id = $_POST["ensino_id"];
		 $avaliacao_id = $_POST["avaliacao_id"];
		 $professor_has_turma = $_POST["professor_has_turma"];
		 
		  $array_avaliacoes = lista_avaliacao_bimestre($bimestre_id, $unidade_id,$ensino_id,$avaliacao_id);
		  $array_alunos_avaliacao = lista_alunos_para_avaliacao($_POST["turma_id"]);
		 
		  //$info[] = strtoupper("Matricula;");
		  //$info[] = strtoupper("Avaliacao;");
		  //$info[] = strtoupper("Aluno;");
		 
		/*for($j=0; $j < count($array_avaliacoes); $j++){ 
		  $info[] = substr($array_avaliacoes[$j]["nome"],0,12).";";
		}*/
		  //$info[] = "\n"; //quebra de linha
		 
		 for($i = 0; $i < count($array_alunos_avaliacao); $i++){
		  	$info[] = strtoupper($array_alunos_avaliacao[$i]["matricula_id"].";");
			$info[] = $avaliacao_id.";";
		  	$info[] = strtoupper($array_alunos_avaliacao[$i]["nome_aluno"].";");
			$info[] = "\n"; //quebra de linha
		 }
		
		 
		 $infos = implode("",$info);
	
		$file = "relatorios_alunos.csv";
		@unlink("$file");
		$handle = fopen($file, 'a');
		fwrite($handle,$infos);
		fclose($handle);
			
		$i = date("Ymdhis");
		echo "<script>location='$file?$i'</script>";
			
	}

?>