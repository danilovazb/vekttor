<?php
	
		$t = selecionaTodosAlunos($_GET['curso'],$_GET[periodo],$_GET[escola],$_GET[modulo],$_GET[horario]);
		
		//armazena id dos alunos
		$alunos = array();
		$c=0;
		while($aluno = mysql_fetch_object($t)){
			$alunos[$c] = $aluno->aluno_id;
			$c++;
		}
?>