<?
function CadastraSala($dados,$vkt_id,$id){
	$campos=mysql_fetch_object(mysql_query("SELECT h.id,h.curso_id,h.modulo_id,h.escola_id,h.periodo_id 
		FROM 
		escolar_horarios h, 
		escolar_modulos m, 
		escolar_cursos ec, 
		escolar_escolas ee, 
		escolar_periodos ep 
		WHERE h.modulo_id=m.id 
		and h.curso_id=ec.id 
		and h.escola_id=ee.id 
		and h.periodo_id=ep.id 
	
	and h.id='".$dados['horario_id']."'"));
	mysql_query($t="INSERT INTO escolar_salas SET 
	vkt_id='$vkt_id',
	curso_id='".$campos->curso_id."',
	modulo_id='".$campos->modulo_id."',
	escola_id='".$campos->escola_id."',
	horario_id='".$dados['horario_id']."',
	nome='".$dados['nome']."',
	idade_minima='".$dados['idade_min']."',
	idade_maxima='".$dados['idade_max']."'
	");
	//echo $t."<br>";
	//echo mysql_error();
}

function AlteraSala($dados,$id){
	$campos=mysql_fetch_object(mysql_query("SELECT h.id,h.curso_id,h.modulo_id,h.escola_id,h.periodo_id 
		FROM 
		escolar_horarios h, 
		escolar_modulos m, 
		escolar_cursos ec, 
		escolar_escolas ee, 
		escolar_periodos ep 
		WHERE h.modulo_id=m.id 
		and h.curso_id=ec.id 
		and h.escola_id=ee.id 
		and h.periodo_id=ep.id 
	
	and h.id='".$dados['horario_id']."'"));
	
	mysql_query($t="UPDATE escolar_salas SET 
	curso_id='".$campos->curso_id."',
	modulo_id='".$campos->modulo_id."',
	escola_id='".$campos->escola_id."',
	horario_id='".$dados['horario_id']."',
	nome='".$dados['nome']."',
	idade_minima='".$dados['idade_min']."',
	idade_maxima='".$dados['idade_max']."'
	WHERE id='$id'");
	//echo $t."<br>";
	//echo mysql_error();
}

function ExcluirSala($id){
	$sala_mat=mysql_fetch_object(mysql_query("SELECT * FROM escolar_matriculas WHERE sala_id='".$id."'"));
	if(!empty($sala_mat)){
		alert("HA MATRICULAS PARA ESTA SALA, NAO PODE SER EXCLUIDA!");
	}else{
		mysql_query($t="DELETE FROM escolar_salas WHERE id='$id'");
		//echo $t;		
	}	
}

function remover () {
	global $tabela;
	
	$q = mysql_query ($t="DELETE FROM $tabela WHERE id = '" . mysql_real_escape_string($_POST['horario_id']) . "'");	
	//echo mysql_error().$t;
}

function converte_numeros_comvirgula_em_dias_semanas($dias,$semana_abreviado){
	
	$dias = explode(',',$dias );
	
	for($i=0;$i<count($dias);$i++){
		$dias_semana[] = $semana_abreviado[$dias[$i]];	
	}
	return implode(', ',$dias_semana);
}
?>