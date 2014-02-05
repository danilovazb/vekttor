<?php
include("../../../../_config.php");
include("_functions.php");
include("_ctrl.php"); 
 		// ESSE ARQUIVO NAO ESTÁ VALENDO
		 $bimestre_id = $_POST["bimestre_id"];
		 $unidade_id  = $_POST["unidade_id"];
		 $ensino_id   = $_POST["ensino_id"];
		 $avaliacao_id = $_POST["avaliacao_id"];
		 $professor_has_turma = $_POST["professor_has_turma"];
		
		 $array_avaliacoes = lista_avaliacao_bimestre($bimestre_id, $unidade_id,$ensino_id,$avaliacao_id);
		 $array_alunos_avaliacao = lista_alunos_para_avaliacao($_POST["turma_id"]);
		 	
		 for($i = 0; $i < count($array_alunos_avaliacao); $i++){
		  	$info[] = strtoupper($array_alunos_avaliacao[$i]["matricula_id"].";");
			$info[] = $avaliacao_id.";";
		  	$info[] = strtoupper($array_alunos_avaliacao[$i]["nome_aluno"].";");
			$info[] = "\n"; //quebra de linha
		 }
		
		 $infos = implode("",$info);
	
		$file = "relatorios_alunos.csv";
		//@unlink("$file");
		$handle = fopen($file, 'w');
		fwrite($handle,$infos);
		fclose($handle);
			
			/*header('Content-type: application/csv');
			header("Cache-Control: no-store, no-cache");
			header('Content-Disposition: attachment; filename="$file"');
			readfile($file); //fputcsv
			//echo $file;
		//$i = date("Ymdhis");
		/*echo "<script>location='$file?$i'</script>";*/
		//echo " $file?$i ";
		//echo $file."-".$i;
		echo "<a href='".$file."'>Dowload Arquivo </a>";
?>