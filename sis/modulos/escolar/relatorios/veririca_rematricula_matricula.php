<?
include("../../../_config.php");
include("../../../_functions_base.php");


  
  		  $periodo_atual =mysql_fetch_object(mysql_query($t="SELECT *
															FROM escolar_periodos AS p
															WHERE vkt_id = '7'
															AND (
															(
															date( now( ) )
															BETWEEN p.inicio_matricula
															AND p.fim_matricula
															)
															OR (
															date( now( ) )
															BETWEEN p.inicio_rematricula
															AND p.fim_rematricula
															)
															)
															ORDER BY id DESC
															LIMIT 1"));

  		$m  = mysql_query($t="SELECT * FROM escolar_matriculas WHERE periodo_id='$periodo_atual->id' and vkt_id='$vkt_id' AND pago='S' ORDER BY id DESC");
		//echo $t;
		
		echo "<pre>";
		while($matricula=mysql_fetch_object($m)){
				$responsavel= mysql_fetch_object(mysql_query("SELECT * FROM  cliente_fornecedor WHERE id='$matricula->responsavel_id'"));
				$aluno		= mysql_fetch_object(mysql_query("SELECT *,
				(YEAR(CURDATE())-YEAR(a.data_nascimento))
				- (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5))
				AS idade FROM escolar_alunos as a WHERE a.id='$matricula->aluno_id'"));
				$unidade	= mysql_fetch_object(mysql_query("SELECT * FROM escolar_escolas WHERE id='$matricula->escola_id'"));
				$curso 		= mysql_fetch_object(mysql_query("SELECT * FROM escolar_cursos WHERE id='$matricula->curso_id'"));
				$modulo		= mysql_fetch_object(mysql_query("SELECT * FROM escolar_modulos WHERE id='$matricula->modulo_id'"));
				$horario	= mysql_fetch_object(mysql_query("SELECT * FROM escolar_horarios WHERE id='$matricula->horario_id'"));
				
				$quantidade_de_matriculas = mysql_fetch_object(mysql_query("SELECT count(*) as qtd FROM escolar_matriculas WHERE responsavel_id='$matricula->responsavel_id' AND periodo_id='$matricula->periodo_id' AND pago='S'"));
				$matricula_periodo_passado = mysql_fetch_object(mysql_query("SELECT count(*) as qtd FROM escolar_matriculas WHERE responsavel_id='$matricula->responsavel_id' AND periodo_id='2'  AND pago='S'"));
		
			if($matricula_periodo_passado->qtd>0){
				$i++;
				echo "$i $responsavel->razao_social > $aluno->nome $aluno->data_nascimento  ($quantidade_de_matriculas->qtd) ($matricula_periodo_passado->qtd) \n";
				
  				$mm  = mysql_query($t="SELECT * FROM escolar_matriculas WHERE responsavel_id='$matricula->responsavel_id' AND periodo_id='2'  AND pago='S'");
				while($rr=mysql_fetch_object($mm)){
							$aluno_sub		= mysql_fetch_object(mysql_query("SELECT *,
							(YEAR(CURDATE())-YEAR(a.data_nascimento))
							- (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5))
							AS idade FROM escolar_alunos as a WHERE a.id='$rr->aluno_id'"));
							
							if($aluno->data_nascimento==$aluno_sub->data_nascimento){
								$rm= "<strong>Rematricula</strong>";	
								$sql = "UPDATE escolar_matriculas SET tipo_matricula ='REMATRÍCULA' WHERE id='$matricula->id'";
								//mysql_query($sql);
								$editarr++;
							}else{
								$rm= '';
							}
							
							echo "	$aluno_sub->nome $aluno_sub->data_nascimento $rm \n";
				}
			
			}
		
		
		}
		echo "total de rematricuas editadas $editarr</pre>";
?>