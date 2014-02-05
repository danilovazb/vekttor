<?
//Funções para programação do inventário
function checaEstoque($produto_id,$status_inventario,$almoxarifado_id=NULL,$inventario_id=NULL){
	global $vkt_id;
	if($status_inventario==1){
			$estoque=mysql_fetch_object(mysql_query($opa="
			SELECT * FROM estoque_inventario_item WHERE produto_id='$produto_id' AND inventario_id='$inventario_id'  ORDER BY id DESC LIMIT 1"));
		if($estoque->id>0){
			$qtd=$estoque->qtd_estoque;
		}else{
			$qtd=0;
		}
	}else{
		$estoque=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='$produto_id' AND almoxarifado_id='$almoxarifado_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
		//echo $trace;
		if($estoque->id>0){
			$qtd=$estoque->saldo;
		}else{
			$qtd=0;
		}
	}
	return $qtd;
}

function fechaInventario($dados){
	global $vkt_id,$usuario_id;
	$total=count($dados[produto_id]);
	if($total>0){
		// Checa se tá editando um ou se está criando novo registro de inventário

			$acao='editar';
			//edita inventário
		//echo $t.mysql_error();
		
			//	print_r($dados);
			$q = mysql_query("SELECT * FROM estoque_inventario_item as ii, estoque_inventario as i WHERE ii.inventario_id=i.id AND ii.inventario_id='{$dados[inventario_id]}' AND i.status='0'");
			mysql_query($trace="UPDATE estoque_inventario SET usuario_id='$usuario_id', data_modificado=NOW(), status='1' WHERE id='{$dados[inventario_id]}'");
		while($r= mysql_fetch_object($q)){

			if($r->qtd_inventario!=''){
				//verifica se é pra editar ou inserir estoque_inventario_item
				$s=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='".$r->produto_id."' AND almoxarifado_id='".$dados['almoxarifado_id']."' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
				$saldo = $s->saldo;
				//echo $saldo;
				if($r->qtd_inventario!=$saldo){
					if($r->qtd_inventario>$saldo){
						echo 'entrou diferenca maior que zero<br>';
						$entrada = $r->qtd_inventario-$saldo;
						$saida 	 = 0;
						$saldo 	 =	$r->qtd_inventario;
					}else{
						//echo 'entrou diferenca menor que zero<br>';
	
						$entrada =0;
						$saida 	 =	 $saldo-$r->qtd_inventario;
						$saldo 	 =	$r->qtd_inventario;
						//echo "($saida $saldo)";
					}
					
					 mysql_query($t="INSERT INTO estoque_mov 
								 SET produto_id='".$r->produto_id."', 
									usuario_id='$usuario_id', 
									almoxarifado_id='".$dados['almoxarifado_id']."', 
									data_hora=NOW(), 
									saida='$saida', 
									entrada='$entrada',
									saldo='$saldo', 
									doc_tipo='inventario', 
									doc_id='".$dados['inventario_id']."', 
									vkt_id='$vkt_id' ");
					}
				
			}
		}
		return $inventario_id;
	}
		
}
function cancelaInventario($inventario_id){
	global $vkt_id;
	
	$so_pode = mysql_fetch_object(mysql_query("SELECT * FROM estoque_inventario WHERE  vkt_id='$vkt_id' AND status='0'"));
	if($so_pode->id>0){
		mysql_query($t="UPDATE estoque_inventario SET status='2' WHERE id='$inventario_id' AND  vkt_id='$vkt_id'");
	}
	//alert($t);
}





?>