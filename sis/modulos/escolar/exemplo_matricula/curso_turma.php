<?php

		echo  $_GET['curso'];
		
		if($_GET['curso'] == '1'){
			// Desenvolvimento de Sistemas
			$turmas = array('DSVKTSM101 - Modulo 1','DSVKTSM202 - Modulo 2');
					foreach($turmas as $turma){
							echo '<option value="'.$turma.'">'.$turma.'</option>';
					}
		}
		if($_GET['curso'] == '2'){
			// Segurança do Trabalho
			$turmas = array('STVKTSM101 - Modulo 1','STVKTSM202 - Modulo 2');
				foreach($turmas as $turma){
							echo '<option value="'.$turma.'">'.$turma.'</option>';
					}
		}
		if($_GET['curso'] == '3'){
			//Designer
			$turmas = array('DGVKTSM101 - Modulo 1','DGVKTSM202 - Modulo 2');
			foreach($turmas as $turma){
							echo '<option value="'.$turma.'">'.$turma.'</option>';
					}
		}

?>