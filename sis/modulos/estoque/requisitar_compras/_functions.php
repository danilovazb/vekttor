<?
//Funções 

//Produtos Grupos
function cadastraCompra($cliente_fornecedor_id,$empreendimento_id,$data_prevista,$data_inicio,$valor_total,$cond_pag,$produto_id,$produto_qtd){
	
	$erro=0;
		
	if($erro==0){
		mysql_query($trace="
					INSERT INTO compra SET
					cliente_fornecedor_id='".$cliente_fornecedor_id."',
					empreendimento_id='".$empreendimento_id."',
					usuario_id='".$_SESSION['usuario']->id."',
					data_prevista='".dataBrToUsa($data_prevista)."',
					data_inicio='".dataBrToUsa($data_inicio)."',
					valor_total='".moedaBrToUsa($valor_total)."',
					cond_pag='".$cond_pag."',
					status='Aguardo'
					");
		
		$total=count($produto_id);
		
		$id=mysql_insert_id();
		
		if($total>0){
			for($i=0;$i<$total;$i++){
				if($produto_qtd[$i]>0){
					mysql_query("
						INSERT INTO compra_has_produto SET
						compra_id='".$id."',
						produto_id='".$produto_id[$i]."',
						requisitar_produto_qtd='".moedaBrToUsa($produto_qtd[$i])."'
						");
				}
			}
		}			
		
		return 1;
	}
	
	return 0;
}

function alteraCompra($id,$cliente_fornecedor_id,$empreendimento_id,$data_prevista,$data_inicio,$valor_total,$cond_pag,$produto_id,$produto_qtd){
	
	$erro=0;
		
	if($erro==0){
		mysql_query("
					UPDATE compra SET
					cliente_fornecedor_id='".$cliente_fornecedor_id."',
					empreendimento_id='".$empreendimento_id."',
					usuario_id='".$_SESSION['usuario']->id."',
					data_prevista='".dataBrToUsa($data_prevista)."',
					data_inicio='".dataBrToUsa($data_inicio)."',
					valor_total='".moedaBrToUsa($valor_total)."',
					cond_pag='".$cond_pag."',
					status='Aguardo'
					WHERE
					id='".$id."'
					");
		
		mysql_query("DELETE FROM compra_has_produto WHERE compra_id='".$id."'");
		
		$total=count($produto_id);
		
		if($total>0){
			for($i=0;$i<$total;$i++){
				if($produto_qtd[$i]>0){
					mysql_query("
						INSERT INTO compra_has_produto SET
						compra_id='".$id."',
						produto_id='".$produto_id[$i]."',
						requisitar_produto_qtd='".moedaBrToUsa($produto_qtd[$i])."'
						");
				}
			}
		}
		
		return 1;
	}
	
	return 0;
}

function excluiCompra($id){
	
	if($id>0){
		
		if(mysql_query("DELETE FROM compra_has_produto WHERE compra_id='".$id."'")){
		
			mysql_query("
						DELETE FROM compra
						WHERE id='".$id."'
						");			
		}else{
			return 0;		
		}
	}
	
	return 0;
}

?>