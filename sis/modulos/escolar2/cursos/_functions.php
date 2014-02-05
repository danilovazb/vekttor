
<?php

$tabela = "escolar_cursos";
// Controlador

	function exluir_ensino($id){
		$consulta =  mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE ensino_id = '$id' "));
		if( !empty($consulta->id) ){
			alert("Este Ensino nao pode ser excluido!");
		} else{
			mysql_query(" DELETE FROM escolar2_ensino WHERE id = '$id' ");
		}
	}

	function atualiza_serie(){
		global $vkt_id;
		if (!empty($_POST['serie_id']) ){
			$where = "WHERE id = '" . mysql_real_escape_string($_POST['serie_id']) . "' AND vkt_id='$vkt_id'";
		} 
		
		mysql_query($t=" UPDATE  escolar2_series  SET  
		 ensino_id        = '{$_POST['ensino_id']}',
		 nome             = '{$_POST['nome_serie']}',
		 materias_por_dia = '{$_POST['materia_por_dia']}',
		 ordem_ensino     = '{$_POST['ordem_ensino']}',
		 idade_minima     = '{$_POST['idade_minima']}',
		 idade_maxima     = '{$_POST['idade_maxima']}'
		 $where ");	
	}

	function atualizar_ensino(){
		
		global $vkt_id;
		$where = "";
		if (!empty($_POST['ensino_id']) ){
			$where = "WHERE id = '" . mysql_real_escape_string($_POST['ensino_id']) . "' AND vkt_id='$vkt_id'";
		} 
		
		mysql_query($t=" UPDATE  escolar2_ensino 
				SET  
				 vkt_id       = '$vkt_id',
				 nome         = '{$_POST['nome']}',
				 ordem_ensino = '{$_POST['ord_ensino']}',
				 porcentagem_falta = '{$_POST['percentagem_faltas']}'
				 $where ");		 
		
	}

function cadastra_ensino() {
	
	global $vkt_id;
	
	$tabela = "escolar2_ensino";
	
	$acao = "";
	$where = "";
	
	if (!empty($_POST['id']) ){
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($_POST['id']) . "' AND vkt_id='$vkt_id'";
	} else {
		$acao = "INSERT INTO";	
	}
	
	mysql_query($t=" $acao $tabela 
	SET  
	 vkt_id='$vkt_id',
	 nome         = '{$_POST['nome']}',
	 ordem_ensino = '{$_POST['ordem_ensino']}'
	 $where ");

	
} //fim da funcao cadastra_ensino

function cadastra () {
	
	global $tabela,$vkt_id;
	
}

function insert_modulos($id,$curso_id,$modulo_id,$nome){
	global $tabela,$vkt_id;
	if(strlen($nome)>0){
		if($id>0){
			$acao = "UPDATE";
			$where = "WHERE id = '" . mysql_real_escape_string($id) . "'";
		} else {
			$acao = "INSERT INTO";	
		}
				
		if(mq($q= "$acao escolar_modulos SET vkt_id 		= '$vkt_id',
												modulo_id 	= '$modulo_id',
												curso_id 	='$curso_id',
												nome 		='$nome'
												$where ")){
			return true;	
		}else{
			echo $q;
			echo mysql_error();	
		}
	}
}

function movimento_unidade_contas($conta_id,$curso_id,$unidade_id){
	global $tabela,$vkt_id;
	
		$acao = "INSERT INTO";	
				
		if(mq($q= "$acao escolar_cursos_unidades_contas 
			SET vkt_id 		= '$vkt_id',
			conta_id 	= '$conta_id',
			curso_id 	= '$curso_id',
			unidade_id 	= '$unidade_id'
			$where ")){
			return true;	
		}else{
			echo $q;
			echo mysql_error();	
		}
}

function remove_modulos($modulo_id){
	global $tabela,$vkt_id;

	$check = mysql_result(mysql_query("SELECT count(*) FROM escolar_matriculas WHERE modulo_id =  '" . $modulo_id . "' AND vkt_id='$vkt_id'"), 0);
	
	// Se a checagem falhar (ou seja, não há nenhum registro pendente) deixa excluir.
	if(!$check) {
		$q = mysql_query ($trace = "DELETE FROM escolar_modulos WHERE id = '$modulo_id' AND vkt_id='$vkt_id'");
	}	


}

function remove_imgem($id){
	global $tabela,$vkt_id;
	$info = mf(mq("SELECT * FROM $tabela WHERE id='$id' AND vkt_id='$vkt_id'"));
	$extensao = $info->extensao;
	if($info->id>0){
		unlink("modulos/escolare/cursos/img/".$id.".$extensao");
		mysql_query($q="UPDATE $tabela set extensao ='' WHERE id= '$id' AND vkt_id='$vkt_id'");
	}
	
	
}

function remover () {
	global $tabela,$vkt_id;
	
	// Procura por registros dependentes em outras tabelas
	$check = mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE curso_id =  '" . mysql_real_escape_string($_POST['curso_id']) . "' AND vkt_id='$vkt_id'"), 0);
	//echo $t;
	
	// Se a checagem falhar (ou seja, não há nenhum registro pendente) deixa excluir.
	if(!$check) {
		$q = mysql_query ($trace = "DELETE FROM $tabela WHERE id = '" . mysql_real_escape_string($_POST['curso_id']) . "'");
		$q = mysql_query ($trace = "DELETE FROM escolar_modulos WHERE curso_id = '" . mysql_real_escape_string($_POST['curso_id']) . "' AND vkt_id='$vkt_id'");
	}	
}

?>