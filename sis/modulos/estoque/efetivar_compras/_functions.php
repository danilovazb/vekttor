<?
//Funções 

function alteraCompra($id,$cliente_fornecedor_id,$empreendimento_id,$data_prevista,$data_inicio,$valor_total,$cond_pag,$produto_compra_id,$produto_qtd){
	
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
					cond_pag='".$cond_pag."'
					WHERE
					id='".$id."'
					");
		
				
		$total=count($produto_compra_id);
		
		if($total>0){
			for($i=0;$i<$total;$i++){
				if($produto_qtd[$i]>0){
					mysql_query("
						UPDATE compra_has_produto SET
						efetivar_produto_qtd='".moedaBrToUsa($produto_qtd[$i])."'
						WHERE
						id='".$produto_compra_id[$i]."'
						");
				}
			}
		}
		
		return 1;
	}
	
	return 0;
}

function cancelaCompra($id){
	
	$erro=0;
		
	if($erro==0){
		mysql_query("
					UPDATE compra SET
					status='Cancelado'
					WHERE
					id='".$id."'
					");
		
		return 1;
	}
	
	return 0;
}

function efetivaCompra($id){
	
	$erro=0;
		
	if($erro==0){
		mysql_query("
					UPDATE compra SET
					status='Efetivado'
					WHERE
					id='".$id."'
					");
		
		return 1;
	}
	
	return 0;
}

?>