<?
//Funções 

function alteraCompra($id,$cliente_fornecedor_id,$empreendimento_id,$data_prevista,$data_inicio,$data_fim,$valor_total,$cond_pag,$numero_nota,$produto_compra_id,$produto_id,$produto_qtd){
	
	$erro=0;
		
	if($erro==0){
		mysql_query("
					UPDATE compra SET
					cliente_fornecedor_id='".$cliente_fornecedor_id."',
					empreendimento_id='".$empreendimento_id."',
					usuario_id='".$_SESSION['usuario']->id."',
					data_prevista='".dataBrToUsa($data_prevista)."',
					data_inicio='".dataBrToUsa($data_inicio)."',
					data_fim='".dataBrToUsa($data_fim)."',
					valor_total='".moedaBrToUsa($valor_total)."',
					cond_pag='".$cond_pag."',
					numero_nota='".$numero_nota."'
					WHERE
					id='".$id."'
					");
		
				
		$total=count($produto_compra_id);
		
		if($total>0){
			for($i=0;$i<$total;$i++){
				if($produto_qtd[$i]>0){
					mysql_query("
						UPDATE compra_has_produto SET
						finalizar_produto_qtd='".moedaBrToUsa($produto_qtd[$i])."'
						WHERE
						id='".$produto_compra_id[$i]."'
						");
						
					$s=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='".$produto_id[$i]."' AND obra_id='".$_SESSION['usuario']->obra_id."' ORDER BY id DESC LIMIT 1"));
					
					mysql_query($trace="INSERT INTO estoque_mov SET usuario_id='".$_SESSION['usuario']->id."', obra_id='".$_SESSION['usuario']->obra_id."', produto_id='".$produto_id[$i]."', data_hora=NOW(), entrada='".moedaBrToUsa($produto_qtd[$i])."', saida='0', saldo='".($s->saldo+$produto_qtd[$i])."'");
					
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

function finalizaCompra($id){
	
	$erro=0;
		
	if($erro==0){
		mysql_query("
					UPDATE compra SET
					status='Finalizado'
					WHERE
					id='".$id."'
					");
		
		return 1;
	}
	
	return 0;
}

?>