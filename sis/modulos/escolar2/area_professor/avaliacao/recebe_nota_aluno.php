<?php
include('../../../../_config.php');
include("../../../../_functions_base.php");

	$funcao = $_POST["funcao"];
	$funcao();
	
	function verifica_avaliacao(){
		
		$dados = $_POST;
		global $vkt_id;
		
		print_r($dados["dados"]);
		
		$sql = " SELECT * FROM escolar2_avaliacao WHERE vkt_id = '$vkt_id' AND avaliacao_bimestre_id = '".$dados["dados"]["avaliacao_bimestre_id"]."' AND professor_as_turma_id = '".$dados["dados"]["professor_has_turma_id"]."' ";
		
		$info_avaliacao = mysql_fetch_object(mysql_query($sql));
		
			if( empty($info_avaliacao->id) ){
				
				$avaliacao_id = insere_avaliacao($dados);
				
				$dados["dados"]["avaliacao_id"] = $avaliacao_id;
				
				$nota_aluno = verifica_nota_aluno($avaliacao_id,$dados["dados"]["matricula_id"]);
				
				if( $nota_aluno > 0 )
					update_notas($dados);
				 else 
					insere_notas($dados);
				
			} else{
				
				$dados["dados"]["avaliacao_id"] = $info_avaliacao->id;
				
				$nota_aluno = verifica_nota_aluno($dados["dados"]["avaliacao_id"],$dados["dados"]["matricula_id"]);
				
				if( $nota_aluno > 0 )
					update_notas($dados);
				 else 
					insere_notas($dados);
			}
			
	}
	
	function insere_avaliacao(array $dados){
		global $vkt_id;
		
		  mysql_query($s=" INSERT INTO escolar2_avaliacao SET 
		  	vkt_id = '$vkt_id',  
			avaliacao_bimestre_id = '".$dados["dados"]["avaliacao_bimestre_id"]."',
			professor_as_turma_id = '".$dados["dados"]["professor_has_turma_id"]."',
			data = '".date('Y-m-d')."' ,
			status = '1' ");
		  
		  $avaliacao_id = mysql_insert_id();
		  
		  return $avaliacao_id; 
		
	}
	
	function insere_notas(array $dados){
		global $vkt_id;
		
		if( !empty($dados["dados"]["indice"]) )
			$nota = $dados["dados"]["indice"];
		else
			$nota = moedaBrToUsa($dados["dados"]["nota_numerica"]);	
		
		mysql_query($s="   
		  INSERT INTO escolar2_aluno_as_avaliacao SET 
		  vkt_id             = '$vkt_id',
		  status             = '2',
		  nota               = '".($nota)."',
		  avaliacao_id       = '".$dados["dados"]["avaliacao_id"]."', 
		  matricula_aluno_id = '".$dados["dados"]["matricula_id"]."',
		  nota_escrita       = '".utf8_decode($dados["dados"]["nota"])."' ");
		  
		  echo $s;
		
	}
	
	function update_notas(array $dados){
		global $vkt_id;
		
		
		if( !empty($dados["dados"]["indice"]) )
			$nota = $dados["dados"]["indice"];
		else
			$nota = moedaBrToUsa($dados["dados"]["nota_numerica"]);
		
		mysql_query($s=" 
		UPDATE escolar2_aluno_as_avaliacao SET 
			nota_escrita = '".utf8_decode($dados["dados"]["nota"])."',
			nota         = '".$nota."'
		WHERE
			vkt_id = '$vkt_id'
		AND
			avaliacao_id = '".$dados["dados"]["avaliacao_id"]."'
		AND
			matricula_aluno_id = '".$dados["dados"]["matricula_id"]."' ");
			echo $s;
		
	}
	
	function verifica_nota_aluno($avaliacao_id = NULL, $matricula_id = NULL ){
		global $vkt_id;
		 
		 $s_nota = " SELECT * FROM escolar2_aluno_as_avaliacao WHERE vkt_id = '$vkt_id' AND avaliacao_id = '".$avaliacao_id."' AND matricula_aluno_id = '".$matricula_id."'  ";	
		 
		 $nota_aluno = mysql_fetch_object(mysql_query( $s_nota ));
		 
		 return $nota_aluno->id;
		
	}
	
?>