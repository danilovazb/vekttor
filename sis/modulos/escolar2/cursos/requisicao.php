<?php
include("../../../_config.php");
include("../../../_functions_base.php");
	
	function atualiza_materia(){
		global $vkt_id;
		$dados = $_POST["dados"];
		$sql = " UPDATE escolar2_materias SET nome = '".utf8_decode($dados['nome'])."' WHERE id = {$dados['id']} ";
		$result = mysql_query($sql);
		if($result)
			echo "success";
		
	}
	
	function serie_has_materia(){
		
		global $vkt_id;
		$serie_id = $_POST["serie_id"];
		$qtd_aula = $_POST["qtd_aula"];
		$materia  = utf8_decode($_POST["materia"]);
		$grupo_id = $_POST["grupo_id"];
		
		
		if(!empty($_POST["materia_id"])){
			
			$materia_id = $_POST["materia_id"];
		
		} else {
		
			mysql_query(" INSERT INTO escolar2_materias SET vkt_id = '$vkt_id', nome = '$materia', grupo_id = '$grupo_id' ");
			$materia_id = mysql_insert_id();
			$result["materia_id"] = $materia_id;
		}
		
		if( !empty($materia_id) ){
		mysql_query(" INSERT INTO escolar2_serie_has_materias 
		SET 
		vkt_id     = '$vkt_id',
		serie_id   = '$serie_id', 
		materia_id = '$materia_id',
		quantidade_de_aulas = '$qtd_aula' ");
		$ultimo = mysql_insert_id();
		$result["serie_materia_id"] = $ultimo;
		
		$json[] = $result;
		
		
		}
		 echo '{"result":' . json_encode($json) . '}';
	
	}
	
	function serie_as_ensino(){
		
		$serie     = utf8_decode($_POST["serie"]);
		$ordem     = $_POST["ordem"];
		$ensino_id = $_POST["ensino_id"];
		
		$idade_min = $_POST["idade_min"];
		$idade_max = $_POST["idade_max"];
		
		mysql_query($r=" INSERT INTO escolar2_series 
			SET
				vkt_id    = '$vkt_id',
				nome      = '$serie',
				ensino_id = '$ensino_id',
				materias_por_dia = '".$_POST["aula_dia"]."',
				aula_por_dia = '".$_POST["aula_dia"]."',
				ordem_ensino = '$ordem',
				idade_minima = '$idade_min',
				idade_maxima = '$idade_max'
				");
		
		$ultimo_reg = mysql_insert_id();		
		echo $ultimo_reg;		
		
	} // 
	
	function remove_serie_has_materia(){
		
		$id = $_POST["id"];  
		
		$busca_ligacao =  mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_professor_has_turma WHERE serie_has_materia_id = '$id' "));
		
		if($busca_ligacao->id > 0)
			echo "erro";
		else {
			echo "success";	
			mysql_query(" DELETE FROM escolar2_serie_has_materias WHERE id = '$id'  ");
		}
		  
		  
	} 
	
	function remove_serie(){
		
		$id = $_POST["id"];
		
		$sql_materia = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_serie_has_materias WHERE serie_id = '$id' "));
			
			if($sql_materia->id > 0){
				echo "erro";
			} else {
				mysql_query(" DELETE FROM escolar2_series WHERE id = '$id' ");
				echo "success";
			}
		
	}
	
	$funcao = $_POST["funcao"];
	$funcao();

?>