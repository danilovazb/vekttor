<?
function manipulaInadimplente($dados,$vkt_id,$id){
	if($id==''){ $sql_in = " INSERT INTO "; $sql_fim="";}
	if($id>0){ $sql_in = " UPDATE "; $sql_fim = " WHERE aluno_id='$id'";}
	
	mysql_query($t="$sql_in escolar_alunos_inadimplentes SET 
	cliente_fornecedor_id_responsavel='".$dados['busca_id_aluno']."',
	vkt_id='$vkt_id'
	$sql_fim
	");
	//echo $t."<br>";
	//echo mysql_error();
}
function excluiInadimplente($id){
	mysql_query($t="DELETE FROM  escolar_alunos_inadimplentes WHERE id='$id'");
	//echo $t;
}
function Importar(){
		global $vkt_id;
	  $http = "http://vkt.srv.br/~nv/sis/";
	  $pasta = 'modulos/escolar/Inadimplentes/arquivo/';
	  $nome  = ($_FILES['file']['name']);
	  $arquivo = $pasta.$nome; 
	  //echo $pasta.$nome;
	  if(move_uploaded_file($_FILES['file']['tmp_name'],$arquivo)){
			  chmod($arquivo,0777);
			  $lines = file($http.$arquivo);
			  // Percorre o array, mostrando o fonte HTML com numeração de linhas.
			  $ja_estavam=0;
			  $encontrados=0;
			  $naoencontrados=0;
			  foreach ($lines as $line_num => $line) {
				//echo "Linha #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n";
				$sql = mysql_fetch_object(mysql_query($t=" SELECT * FROM cliente_fornecedor WHERE cnpj_cpf = '".trim($line)."' AND cliente_vekttor_id = '$vkt_id' "));
				  if(!empty($sql->id)){
					  $sejatem = mysql_fetch_object(mysql_query("SELECT * FROM  escolar_alunos_inadimplentes WHERE cliente_fornecedor_id_responsavel ='$sql->id'"));
					  if($sejatem->id<1){
						  $encontrados++; 
						  $sqlInsert = mysql_query(" INSERT INTO  escolar_alunos_inadimplentes SET cliente_fornecedor_id_responsavel = '$sql->id', vkt_id = '$vkt_id' ");
					  }else{
						$ja_estavam++;  
					  }
					  
				  }else{
					  $naoencontrados++;
					  $cpf_nao_encontrado .= trim($line).", \n";
				  }
			  }
			  //print_r($lines);
			  
			  alert("$encontrados CPF`s encontrados e colocados como inadimplentes,\n $ja_estavam já estavam como inadimplentes, \n $naoencontrados nao encontrados: \n $cpf_nao_encontrado");
	  }
	  
}
?>