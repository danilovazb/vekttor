<?
//Funções 

//dah a baixa de inventario
function baixaInventario($produto_id,$produto_qtd){
	
	$total=count($produto_id);
		
	if($total>0){
		for($i=0;$i<$total;$i++){
			if($produto_qtd[$i]>0){
								
				$s=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='".$produto_id[$i]."' AND obra_id='".$_SESSION['usuario']->obra_id."' ORDER BY id DESC LIMIT 1"));
				
				$p_qtd=moedaBrToUsa($produto_qtd[$i]);
				
				if($p_qtd>$s->saldo){
					
					$entrada=$p_qtd-$s->saldo;
					$saida=0;
					$saldo_final=$p_qtd;
					
				}else{
					
					$entrada=0;
					$saida=$s->saldo-$p_qtd;
					$saldo_final=$p_qtd;
					
				}
				
				mysql_query($trace="INSERT INTO estoque_mov SET usuario_id='".$_SESSION['usuario']->id."', obra_id='".$_SESSION['usuario']->obra_id."', produto_id='".$produto_id[$i]."', data_hora=NOW(), entrada='".$entrada."', saida='".$saida."', saldo='".$saldo_final."'");
				
				salvaUsuarioHistorico("Tela - Inventário",'Deu Baixa no Produto ID $produto_id','estoque_mov',$produto_id);
				
			}
		}
	}
		
}
?>