<?
	function CadastraPedido($dados,$vkt_id){
		
		$datadiff=mysql_fetch_object(mysql_query($trace="SELECT to_days('".DataBrToUsa($dados['data_retorno'])."') - to_days('".DataBrToUsa($dados['data_pedido'])."') as diferenca"));
		
		if(($datadiff->diferenca>=0)){
			//echo "Diferença de datas:".$datadiff->diferenca;
			$query=mysql_query($trace="INSERT INTO eleitoral_pedidos SET eleitor_id='{$dados['eleitor_id']}', coordenador_id='{$dados['coordenador_id']}',
					   data_inicio='".DataBrToUsa($dados['data_pedido'])."',setor_id='{$dados['setor_id']}', tipo_contato='{$dados['tipo_pedido']}'
					   , data_retorno='".DataBrToUsa($dados['data_retorno'])."',solicitacao='{$dados['solicitacao']}',
					   narrativa_solucao='{$dados['narrativa_solucao']}', prioridade='{$dados['prioridade_pedido']}', status_pedido='emandamento', vkt_id='$vkt_id'");
						   //echo $trace;
		}else{
			echo "<script>alert(\"SELECIONE UMA DATA POSTERIOR OU IGUAL A HOJE\")</script>";
			echo "<script>window.open('http://10.0.1.22/clientes/nv/nv/sis/modulos/eleitoral/pedidos/form_pedido.php','carregador' )</script>";
		}
		
	}
	
	function AlteraPedido($dados,$id){
		
		//$datadiff=mysql_fetch_object(mysql_query($trace="SELECT to_days('".DataBrToUsa($data_retorno)."') - to_days('".DataBrToUsa($data_pedido)."') as diferenca"));
		
		//echo "Diferença de datas=".$datadiff->diferenca;
		$query=mysql_query($trace="UPDATE eleitoral_pedidos SET eleitor_id='{$dados['eleitor_id']}', coordenador_id='{$dados['coordenador_id']}',
					   data_inicio='".DataBrToUsa($dados['data_pedido'])."',setor_id='{$dados['setor_id']}', tipo_contato='{$dados['tipo_pedido']}'
					   , data_retorno='".DataBrToUsa($dados['data_retorno'])."',solicitacao='{$dados['solicitacao']}',
					   narrativa_solucao='{$dados['narrativa_solucao']}', prioridade='{$dados['prioridade_pedido']}', status_pedido='{$dados['status_pedido']}' WHERE id='$id'");
					  //echo $trace;
		
	}
	
	function ExcluiPedido($id){
		$query=mysql_query($trace="DELETE FROM eleitoral_pedidos WHERE id='$id'");
		//echo $trace."<br>";
	}
	
	function AtualizaStatusPedido($id){
		$query=mysql_query($trace="UPDATE eleitoral_pedidos SET status_pedido=\"naoresolvido\" WHERE id='$id'");
		//echo $trace;
	}
	
	function SubtraiData($id){
		$diferenca=mysql_fetch_object(mysql_query($trace="SELECT to_days(data_retorno) - TO_DAYS(NOW()) as diferenca from eleitoral_pedidos WHERE id='$id'")); 
	    return $diferenca->diferenca;
	}
?>