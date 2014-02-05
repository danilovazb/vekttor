<?php
	if(!empty($_GET['id'])){
		$id    = $_GET['id'];
		$exibe = $_GET['exibe'];
		if($exibe == 2){
			$table ="escolar_avaliacao";
		} else{
			$table = "escolar_aula";
		}
		$sql = "SELECT * FROM $table WHERE id = '$id' ";
		$aula = mysql_fetch_object(mysql_query($sql));
		
		/* .:nome da turma :. */
			$smp = mysql_fetch_object(mysql_query($s=" SELECT *,sala.nome AS turma FROM  $table AS currentTable 
													   JOIN escolar_sala_materia_professor AS smp ON currentTable.sala_materia_professor_id = smp.id
													   JOIN escolar_salas AS sala ON smp.sala_id = sala.id
													   WHERE currentTable.id = '$aula->id' "));
			/* .:outros:. */							   
			$professor_id = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE id = '$smp->professor_id'"));
			$professor = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$professor_id->cliente_fornecedor_id'")); 
			$periodo = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_periodicidade_avaliacao WHERE id = '$aula->periodicidade_id'"));
			$materia = mysql_fetch_object(mysql_query(" SELECT * FROM  escolar_materias WHERE id = '$smp->materia_id'"));
			$matricula = mysql_fetch_object(mysql_query($m=" SELECT * FROM  escolar_matriculas WHERE sala_id = '$smp->sala_id'"));
			$curso = mysql_fetch_object(mysql_query($c=" SELECT * FROM   escolar_cursos WHERE id = '$matricula->curso_id'"));
			$escola = mysql_fetch_object(mysql_query(" SELECT * FROM   escolar_escolas WHERE id = '$matricula->escola_id'"));	
	}
	if($_POST['action'] == "Salvar"){
			AlteraStatus($_POST);
	}
?>