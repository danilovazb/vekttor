<?
//Arquivo

function enviaArquivo($arquivo){

	$tamanho = 1024 * 1024 * 10;
	$extensao = strtolower(end(explode('.',$arquivo['name'])));
	$nome_final = time().".".$extensao;
	
	if (move_uploaded_file($arquivo['tmp_name'], "upload/". $nome_final)) {
		// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
		echo "<script>alert('"."Upload efetuado com sucesso!"."')</script>";
		return $nome_final; // Para a execução do script
	}
	return 0;
}

function salvaArquivo($tipo,$arquivo,$obs){
	
	//salva arquivo no diretorio
	$envio=enviaArquivo($arquivo);
	
	if($envio){
		if(mysql_query("
					INSERT INTO cliente_fornecedor_arquivo SET
					usuario_id='".$_SESSION['usuario']->id."',
					cliente_fornecedor_id='".$_GET['cliente_fornecedor_id']."',
					tipo='".$tipo."',
					arquivo='".$envio."',
					localizacao='upload/',
					obs='".$obs."'
					")){
				
			salvaUsuarioHistorico("Formulário - Cliente Fornecedor | Arquivo",'cadastrou','cliente_fornecedor_arquivo',mysql_insert_id());
					
			return 1;
		}
	}
	return 0;
}

function excluiArquivo($id){
	
	if($id>0){
		salvaUsuarioHistorico("Formulário - Cliente Fornecedor | Arquivo",'excluiu','cliente_fornecedor_arquivo',$id);
		
		$arquivo=mysql_fetch_object(mysql_query("SELECT arquivo FROM cliente_fornecedor_arquivo WHERE id='".$id."'"));
		
		if(unlink("upload/".$arquivo->arquivo)){
		
			mysql_query("
						DELETE FROM cliente_fornecedor_arquivo
						WHERE id='".$id."'
						");
			
			return 1;
			
		}
		
	}
	
	return 0;
}
?>