<?php

$tabela = "escolar_cursos";
// Controlador

//Cadastra/Altera Mat�ria 
function manipulaMateria($dados) {
	global $vkt_id;
	$materias = $dados['nome'];
	//echo "Modulo: ".$dados['modulo_id'];
	$cont=0;
	foreach($materias as $materia){
		
		if($dados['materia_id'][$cont]>0){
			$inicio="UPDATE";$fim="WHERE id='{$dados['materia_id'][$cont]}'";
		}else{
			$inicio="INSERT INTO";$fim="";
		}//$dados['materia_id']
		
		mysql_query($t="$inicio escolar_materias SET
			vkt_id='$vkt_id',
			modulo_id='{$dados[modulo_id]}',
			nome='$materia'
			$fim");
		//echo $t."<br>";
		$cont++;
		
	}//$materias
	
}//ManipulaMateria

//remove todas as mat�rias
function removeMaterias($dados){
	global $vkt_id;
	$ids = $dados['materia_id'];
	foreach($ids as $id){
		//verifica se h� professor vinculado a mat�ria
		$professor_materia = mysql_fetch_object(mysql_query("SELECT * FROM escolar_sala_materia_professor esp WHERE materia_id=$id
						  and vkt_id=$vkt_id"));
						  
		//verifica se h� avalia�oes vinculado a mat�ria
		$avalia�ao_materia = mysql_fetch_object(mysql_query("SELECT * FROM escolar_sala_materia_professor esp 
						  INNER JOIN 
						  escolar_avaliacao av ON esp.id=av.sala_materia_professor_id 
						  WHERE 
						  esp.materia_id=$id and esp.vkt_id=$vkt_id"));
		
		if(empty($professor_materia) and empty($avaliacao_materia)){
			mysql_query($t="DELETE FROM escolar_materias WHERE id='".$id."'");
		}else{
			alert("H� avalia�oes ou professores vinculados a esta mat�ria");
		}
		
	}//$ids
}//removeMaterias

//remove uma mat�ria
function removeMateria($id,$curso_id,$modulo_id){
	
	global $vkt_id;
	
	//verifica se h� professor vinculado a mat�ria
	$professor_materia = mysql_fetch_object(mysql_query("SELECT * FROM escolar_sala_materia_professor esp WHERE materia_id=$id
						  and vkt_id=$vkt_id and professor_id!=0 ORDER BY id DESC LIMIT 1"));
	//alert($professor_materia->id);
						  
	//verifica se h� avalia�oes vinculado a mat�ria
	$avaliacao_materia = mysql_fetch_object(mysql_query("SELECT *, esp_id as id FROM escolar_sala_materia_professor esp 
						  INNER JOIN escolar_avaliacao av ON esp.id=av.sala_materia_professor_id 
						  WHERE esp.materia_id=$id and esp.vkt_id=$vkt_id"));
	
	//alert($avalaicao_materia->id);
	if(empty($professor_materia) and empty($avaliacao_materia)){
		mysql_query($t="DELETE FROM escolar_materias WHERE id='".$id."'");
	}else{
		alert("H� avalia�oes ou professores vinculados a esta mat�ria");
		//alert($modulo_id);
		echo "<script>window.open('modulos/escolar/materia/form.php?curso_id=$curso_id&modulo_id=$modulo_id','carregador')</script>";
	}//if
	
}//removeMateria
?>