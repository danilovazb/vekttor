<?php


	function atualiza_forum_resposta(){
				$sql_atualiza=mysql_query(" UPDATE escolar_forum 
												SET
													resposta = '".$_POST['resposta']."'
												WHERE
													id = '".$_POST['id']."'
												AND
													aula_id = '".$_POST['aula_id']."'
				");	
	}
	
	
	function consulta_materia($materia){	
			$sql_m = " SELECT * FROM escolar_materias WHERE id = '$materia'";
			//echo $sql_m;
			$nome_materia = mysql_fetch_object(mysql_query($sql_m));
			return $nome_materia->nome;
	}
	
	function altera_aula($campos){
			$sql_update = " UPDATE escolar_aula
										SET
									 descricao  = '$campos[descricao]',
									 obs        = '$campos[obs]',
									 texto_aula = '$campos[texto_aula]',
									 data       = '".dataBrToUsa($campos[data_aula])."',
									 periodicidade_id  = '$campos[periodicidade_id]'
							 WHERE 
							 		id = '$campos[id]'
							 	
			";
			mysql_query($sql_update);
	}
	
	function deletar_aula($id){

		$sql = mysql_query(" DELETE FROM escolar_aula WHERE id = '$id' ");	
	}
	
	function insere_aula($campos){
		
				global $vkt_id;
					$sql_insert = " 
								INSERT INTO escolar_aula
										SET
										 sala_materia_professor_id = '$campos[sala_materia]',
										 descricao                 = '$campos[descricao]',
										 data                      = '".dataBrToUsa($campos[data_aula])."',
										 obs                       = '$campos[obs]',
										 texto_aula                = '$campos[texto_aula]',
										 vkt_id                    = '$vkt_id',
										 status                    = '0',
										 periodicidade_id          = '$campos[periodicidade_id]'
								
							";
							//echo $sql_insert;
							mysql_query($sql_insert);
							
							return mysql_insert_id();
	}

	function insere_frequencia($dados,$aula){
		global $vkt_id;
			
			//consulta os alunos da turma
			$alunos = mysql_query("SELECT * FROM escolar_matriculas WHERE sala_id='$dados[sala]'");
			
			//insere falta para os alunos
			while($a = mysql_fetch_object($alunos)){
				mysql_query($t="INSERT INTO escolar_frequencia_aula SET 
							aula_id='$aula',
							matricula_aluno_id='$a->aluno_id',
							presenca='0',
							status='1'");
						//echo $t;  
			}
	}
?>