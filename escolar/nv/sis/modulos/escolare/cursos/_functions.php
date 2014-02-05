<?php

$tabela = "escolar_cursos";
// Controlador

function cadastra () {
	
	global $tabela,$vkt_id;
	
	$acao = "";
	$where = "";
	
	if( isset($_POST['curso_id']) && !empty($_POST['curso_id']) ){
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($_POST['curso_id']) . "'";
	} else {
		$acao = "INSERT INTO";	
	}
	
	mysql_query ($t="$acao $tabela SET 
				vkt_id 		='$vkt_id',
				nome 		='{$_POST['nome']}',
				descricao 	='{$_POST['descricao']}',
				conteudo_programatico 	='{$_POST['conteudo_programatico']}',
				termos		='{$_POST['termos']}',
				perc_faltas		='{$_POST['perc_faltas']}' 	 
	 $where");
	
	 if( $_POST['curso_id']>0 ){
		 $curso_id = $_POST['curso_id'];
	 }else{
		$curso_id = mysql_insert_id();
	 }
	 
	 for($i=0;$i<count($_POST['modulo_nome']);$i++){
		 insert_modulos($_POST['modulo_id'][$i],$curso_id,$modulo_id,$_POST['modulo_nome'][$i]);
	 }
	mq("DELETE FROM escolar_cursos_unidades_contas WHERE vkt_id='$vkt_id' AND curso_id='$curso_id'");
	 for($i=0;$i<count($_POST['escola_id']);$i++){
		 movimento_unidade_contas($_POST['conta_id'][$i],$curso_id,$_POST['escola_id'][$i]);
	 }
	 
	$extensao = getExtensao($_FILES['file']['name'][0]);
	if($extensao!='php'){
		if(move_uploaded_file($_FILES['file']['tmp_name'][0], "modulos/escolar/cursos/img/".$curso_id.".$extensao")){
			
			mysql_query($q="UPDATE $tabela set extensao ='$extensao' WHERE id= '$curso_id' AND vkt_id='$vkt_id'");
		}
	}	
	
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
												$where
												")){
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
												$where
												")){
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