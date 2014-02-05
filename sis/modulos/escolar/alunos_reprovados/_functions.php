<?php
function manipulaReprovado($dados,$vkt_id,$id){
	if($id==''){ $sql_in = " INSERT INTO "; $sql_fim="";}
	if($id>0){ $sql_in = " UPDATE "; $sql_fim = " WHERE aluno_id='$id'";}
	
	mysql_query($t="$sql_in escolar_alunos_reprovado SET 
	aluno_id='".$dados['busca_id_aluno']."',
	vkt_id='$vkt_id'
	$sql_fim
	");
	//echo $t."<br>";
	//echo mysql_error();
}
function excluiInadimplente($id){
	mysql_query($t="DELETE FROM  escolar_alunos_reprovado WHERE aluno_id='$id'");
	//echo $t;
}

function Importar(){
		global $vkt_id;
	  $http = "http://vkt.srv.br/~nv/sis/";
	  $pasta = 'modulos/escolar/alunos_reprovados/arquivo/';
	  $nome  = ($_FILES['file']['name']);
	  $arquivo = $pasta.$nome; 
	  //echo $pasta.$nome;
	  if(move_uploaded_file($_FILES['file']['tmp_name'],$arquivo)){
			  chmod($arquivo,0777);
			  $lines = file($http.$arquivo);
			  // Percorre o array, mostrando o fonte HTML com numeração de linhas.
			  foreach ($lines as $line_num => $line) {
				//echo "Linha #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n";
				$sql = mysql_fetch_object(mysql_query($t=" SELECT * FROM escolar_alunos WHERE id = '".trim($line)."' AND vkt_id = '$vkt_id' "));
				  if(!empty($sql->id)){
					  $sqlInsert = mysql_query(" INSERT INTO escolar_alunos_reprovado SET aluno_id = '$sql->id', vkt_id = '$vkt_id' ");
				  }
			  }
			  //print_r($lines);
	  }
	  
}
?>