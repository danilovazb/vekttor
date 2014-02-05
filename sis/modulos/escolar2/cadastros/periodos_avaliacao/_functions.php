<?
function manipulaPeriodoAvaliacao($dados){
	global $vkt_id;
	if($dados['id']>0){
		$sql_inicio=" UPDATE ";
		$sql_fim=" WHERE id='{$dados['id']}' ";
	}else{
		$sql_inicio=" INSERT INTO ";
		$sql_fim;
	}
	
	if( empty($dados['travar_bimestre']) )
		$trava = "nao";
	else
		$trava = "sim";
	
	return mysql_query("
	$sql_inicio 
		escolar2_periodos_avaliacao 
	SET 
		nome='{$dados['nome']}',
		data_inicio = '".dataBrToUsa($dados['data_inicio'])."',
		data_final  = '".dataBrToUsa($dados['data_final'])."',
		unidade_id='{$dados['unidade_id']}',
		travado   = '{$trava}',
		
		vkt_id='$vkt_id'
	 $sql_fim");
}

function manipulaFormula($formula){
	global $vkt_id;
	$media = array();
	//atribuir a nota da média à chave referente ao id do periodo de avaliação da array $media
	//id do primeiro bimestre = 17
	//média do primeiro bimestre = 6,5
	//logo, $media[17]=6,5
	foreach($media as $i=>$nota){
		$formula=str_replace('{'.$i.'}',$nota,$formula);
	}
	return $formula;
}


function manipulaCalculo($dados){
	$formula=$dados['formula_media'];
	mysql_query($a="UPDATE escolar2_unidades SET formula_media='{$dados['formula_media']}' WHERE id='{$dados['id']}'");
}


function deletaPeriodoAvaliacao($id){
	global $vkt_id;
	return mysql_query("DELETE FROM escolar2_periodos_avaliacao WHERE id='$id' ");
}

	
	function dados_avaliacao($bimestre_id = NULL, $unidade_id = NULL){
		global $vkt_id;
		$sql_avaliacao_bimestre = mysql_query(" SELECT * FROM escolar2_avaliacao_bimestre WHERE vkt_id = '$vkt_id' AND unidade_id = '$unidade_id' AND bimestre_id = '$bimestre_id' ORDER BY ordem ");
		
		while($registros=mysql_fetch_array($sql_avaliacao_bimestre)){
				$dados[] = $registros;
		}
		return $dados;
	}

	
