<?

//Funções 

//Produtos Grupos
function cadastraProduto($nome,$produto_grupo_id,$unidade,$conversao1,$unidade_embalagem,$conversao2,$unidade_uso,$estoque_min,$estoque_max,$tempo_reposicao,
						$custo,$preco_compra,$preco_venda,$descricao,$foto,$codigo,$gramatura,$vkt_id){
						//,$prod_comp_id,$prod_comp_qtd	
	
	$erro=0;
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
		
	if($erro==0){
		mysql_query($trace="
					INSERT INTO produto SET
					nome='".$nome."',
					produto_grupo_id='".$produto_grupo_id."',
					unidade='".$unidade."',
					conversao='".converteflutuante($conversao1)."',
					unidade_embalagem='".$unidade_embalagem."',
					conversao2='".converteflutuante($conversao2)."',
					unidade_uso='".$unidade_uso."',
					estoque_min='".$estoque_min."',
					estoque_max='".$estoque_max."',
					tempo_reposicao='".$tempo_reposicao."',
					preco_compra='".moedaBrToUsa($preco_compra)."',
					preco_venda='".moedaBrToUsa($preco_venda)."',
					custo='".moedaBrToUsa($custo)."',
					descricao='".$descricao."',
					foto='".$foto."',
					codigo='".$codigo."',
					gramatura='".converteflutuante($gramatura)."',
					vkt_id='".$vkt_id."'
					");
		//echo $trace;	
		echo mysql_error();			
		$comp_total=count($prod_comp_id);
		
		$produto_id=mysql_insert_id();
		
			if(strlen($_FILES['foto']['name'])>3){
				produto_envia_arquivo($produto_id);
			}
			
			return $produto_id;
	}else{
			return 0;
	}
}

function converteflutuante($valor){
	$v = str_replace('.','', $valor);
	$v = str_replace(',','.', $v);
	return $v;
}
function converteflutuante2($valor){
	$v = str_replace('.',',', $valor);
	return $v;
}

function alteraProduto($id,$codigo,$nome,$produto_grupo_id,$unidade,$conversao1,$unidade_embalagem,$conversao2,$gramatura,$unidade_uso,$estoque_min,$estoque_max,$tempo_reposicao,
						$custo,$preco_compra,$preco_venda,$descricao,$vkt_id){
						//,$prod_comp_id,$prod_comp_qtd
	
	$erro=0;
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
		
	if($erro==0){
		mysql_query($trace="
					UPDATE produto SET
					nome='".$nome."',
					produto_grupo_id='".$produto_grupo_id."',
					unidade='".$unidade."',
					conversao='".converteflutuante($conversao1)."',
					unidade_embalagem='".$unidade_embalagem."',
					conversao2='".converteflutuante($conversao2)."',
					gramatura='".converteflutuante($gramatura)."',
					unidade_uso='".$unidade_uso."',
					estoque_min='".$estoque_min."',
					estoque_max='".$estoque_max."',
					tempo_reposicao='".$tempo_reposicao."',
					preco_compra='".moedaBrToUsa($preco_compra)."',
					preco_venda='".moedaBrToUsa($preco_venda)."',
					custo='".moedaBrToUsa($custo)."',
					descricao='".$descricao."',
					codigo='".$codigo."'
					WHERE
					id='".$id."'
					");
		//echo $trace;
	}
	if(strlen($_FILES['foto']['name'])>3){
		produto_envia_arquivo($id);
	}
	

	
	
	return 0;
}

function excluiProduto($id){
	if($id>0){	
		$r=mysql_fetch_object(mysql_query("SELECT * FROM cozinha_ficha_has_produto WHERE produto_id='$id' LIMIT 1"));
		if($r->id>0){
			echo "<script>alert('Exclusão Inválida! Este produto é ingrediente de 1 ou mais fichas técnicas!');</script>";
			return 0;
		}else{
			mysql_query("
					DELETE FROM produto
					WHERE id='".$id."'
					");			
			return 1;		
		}
	}
	return 0;
}

function produto_envia_arquivo($produto_id){
	
	$filis_autorizados = array('jpg','gif','png','pdf');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id='$produto_id'"));
	
	if(strlen($_FILES['foto']['name'])>4){
	  $pasta 	= 'modulos/estoque/produtos/fotos_produtos/';
	  $extensao = strtolower(substr($_FILES['foto']['name'],-3));
	  $arquivo 	= $pasta.$produto_id.'.'.$extensao;
	  $arquivodel= $pasta.$produto_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['foto'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE produto SET foto='$arquivo' WHERE id='$produto_id'");
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
}

function produto_has_fornecedor($id,$dados){
	
	global $vkt_id;
	
	$fornecedores = mysql_query($t="SELECT * FROM cliente_fornecedor WHERE tipo='Fornecedor' AND cliente_vekttor_id='$vkt_id'");
	
	while($fornecedor = mysql_fetch_object($fornecedores)){
			
		$produto_has_fornecedor = mysql_query($t="SELECT * FROM produto_has_fornecedor WHERE produto_id='$id' AND fornecedor_id='$fornecedor->id' AND vkt_id='$vkt_id'");
		
		if(mysql_num_rows($produto_has_fornecedor)<=0&&@in_array($fornecedor->id,$dados['produto_has_fornecedor'])){
			mysql_query($t="INSERT INTO 
					produto_has_fornecedor 
				SET 
					produto_id='$id',
					fornecedor_id='$fornecedor->id',
					vkt_id='$vkt_id'");
					
					//echo $t."<br>";
		}
		
		if(mysql_num_rows($produto_has_fornecedor)>0&&!in_array($fornecedor->id,$dados['produto_has_fornecedor'])){
			mysql_query($t="DELETE FROM 
					produto_has_fornecedor 
				
					WHERE 
					fornecedor_id ='$fornecedor->id' AND
					produto_id     ='$id' AND
					vkt_id='$vkt_id'");
					
					//echo $t;
		}		
		
		
	}
	
}

function remove_produto_has_fornecedor($id,$dados){
	
	mysql_query($t="DELETE FROM produto_has_fornecedor WHERE produto_id='$id'");
	
}

function produto_envia_foto($id,$dados){
	
	global $vkt_id;
	
	$filis_autorizados = array('jpg','gif','png','pdf','jpeg');
	
	$infomovimento = mysql_fetch_object(mysql_query($t="INSERT INTO produto_fotos SET vkt_id='$vkt_id', produto_id='$id', nome='$dados[foto_nome]'"));
	//alert($t);
	$foto_id = mysql_insert_id();
	
	if(strlen($_FILES['foto_produto_arquivo']['name'])>4){
	  $pasta 	= 'modulos/estoque/produtos/fotos_aba_produtos/';
	  $extensao = strtolower(substr($_FILES['foto_produto_arquivo']['name'],-3));
	  $arquivo 	= $pasta.$foto_id.'.'.$extensao;
	  $arquivodel= $pasta.$foto_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['foto_produto_arquivo'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE produto_fotos SET extensao='$extensao' WHERE id='$foto_id'");
			
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
	return $foto_id;
	
	
}

function excluiFotoProduto($foto_id){
	//alert($foto_id);
	$arquivo = mysql_fetch_object(mysql_query("SELECT * FROM produto_fotos WHERE id='$foto_id'")); 
	
	mysql_query("DELETE FROM produto_fotos WHERE id='$foto_id'");
	@unlink("modulos/estoque/produtos/fotos_aba_produtos/".$arquivo->id.".".$arquivo->extensao);
}

function remove_fotos_produtos($id){
	//alert($foto_id);
	$arquivos = mysql_query("SELECT * FROM produto_fotos WHERE produto_id='$id'"); 
	while($arquivo = mysql_fetch_object($arquivos)){
		mysql_query("DELETE FROM produto_fotos WHERE id='$arquivo->id'");
		@unlink("modulos/estoque/produtos/fotos_aba_produtos/".$arquivo->id.".".$arquivo->extensao);
	}
}

function remove_fornecedor_do_produto($dados){
	global $vkt_id;
	//print_r($dados);
	mysql_query("
	DELETE FROM 
		produto_has_fornecedor 
	WHERE 
		produto_id='$dados[produto_id]'
	AND
		fornecedor_id='$dados[fornecedor_id]'
	AND
		vkt_id='$vkt_id'
	");
}
?>