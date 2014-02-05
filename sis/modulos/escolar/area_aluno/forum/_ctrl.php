<?php

	
	if($_POST['action']== 'Salvar'){
		
			if($_POST['pergunta_id'] > 0){
				//altera_pergunta_professor($_POST);
				//echo "altera";
			} else{
				insere_pergunta_professor($_POST);
				//echo "Cadastra";
			}
	}
	
	
	if($_GET['pergunta_id'] and $_GET['aula_id']){
				$pergunta_id = $_GET['pergunta_id'];
				$aula_id     = $_GET['aula_id'];
				
				$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_alunos WHERE id = '".$_SESSION['aluno']->id."' AND vkt_id = '$vkt_id'"));
				$aula_descricao =  mysql_fetch_object(mysql_query(" SELECT * FROM escolar_aula WHERE id = '$aula_id' AND vkt_id = '$vkt_id' "));
				$smp = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_sala_materia_professor 
																						WHERE 
																							id = '$aula_descricao->sala_materia_professor_id'" ));
				$professor = mysql_fetch_object(mysql_query(" SELECT *
																		FROM escolar_professor AS p, cliente_fornecedor AS c
																		WHERE p.cliente_fornecedor_id = c.id
																		AND p.id = '".$smp->professor_id."'"));
			/*------ PARA EDICAO DA PERGUNTA --------*/
				$pergunta_forum = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_forum WHERE id = '$pergunta_id' AND vkt_id = '$vkt_id'"));
				$pergunta       = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_forum_pergunta WHERE id = '$pergunta_forum->pergunta_id'")); 	
	}
	
	
	if($_GET['id'] > 0){
		$id = $_GET['id'];
				$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_alunos WHERE id = '".$_SESSION['aluno']->id."' AND vkt_id = '$vkt_id'"));
				$aula_descricao =  mysql_fetch_object(mysql_query(" SELECT * FROM escolar_aula WHERE id = '$id' AND vkt_id = '$vkt_id' "));
				$smp = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_sala_materia_professor 
																						WHERE 
																							id = '$aula_descricao->sala_materia_professor_id'" ));
				$professor = mysql_fetch_object(mysql_query(" SELECT *
																		FROM escolar_professor AS p, cliente_fornecedor AS c
																		WHERE p.cliente_fornecedor_id = c.id
																		AND p.id = '".$smp->professor_id."'"));
																						
																							
	}
?>