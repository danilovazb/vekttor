<?
//Funções para programação do inventário


//verifica a situação do produto no inventário

function checaEstoque($produto_id,$almoxarifado_id=NULL,$inventario_id=NULL,$status_inventario){
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

		if($estoque->id>0){
			$qtd=$estoque->saldo;
		}else{
			$qtd=0;
		}
	}
	return $qtd;
}

function salvaInventario($produto_id,$produto_estoque,$nova_qtd,$almoxarifado_id=NULL,$inventario_id=NULL){
	global $vkt_id;
	$total=count($produto_id);
	if($total>0){
		// Checa se tá editando um ou se está criando novo registro de inventário
		if($inventario_id==NULL){
			$acao='inserir';
			//cria novo inventário	
			mysql_query($t="INSERT INTO estoque_inventario 
			SET usuario_id='".$_SESSION['usuario']->id."', almoxarifado_id='$almoxarifado_id', data_criado=NOW(), status='0', vkt_id='$vkt_id' $fim_sql");
			$inventario_id=mysql_insert_id();
			//prepara a movimentacao de itens do invnetario
			$modo_sql="INSERT INTO ";
			$fim_sql="";
		}elseif($inventario_id>0){
			$acao='editar';
			//edita inventário
			mysql_query($trace="UPDATE estoque_inventario 
			SET usuario_id='".$_SESSION['usuario']->id."', data_modificado=NOW(), status='0' WHERE id='$inventario_id'");
		}
		//echo $t.mysql_error();
		
		for($i=0;$i<$total;$i++){
			if($nova_qtd[$i]>0){
				//verifica se é pra editar ou inserir estoque_inventario_item
				if($acao=='editar'){
					//retorna o ultimo estoque_inventario_item do produto
					$inventario_item_id=mysql_result(mysql_query($o="
					SELECT id FROM estoque_inventario_item WHERE produto_id='{$produto_id[$i]}' AND inventario_id='$inventario_id' ORDER BY id DESC LIMIT 1 "),0,'id');
					
					//prepara a movimentacao de itens do invnetario
					$modo_sql= "UPDATE ";
					$fim_sql=" WHERE id='$inventario_item_id' AND vkt_id='$vkt_id' ";
				}elseif($acao=='inserir'){
					$modo_sql="INSERT INTO";
					$fim_sql=", vkt_id='$vkt_id'";
				}
				//pega quanto tem no estoque do produto pra fazer a soma com a nova quantidade conferida no inventário
				$s=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='".$produto_id[$i]."' AND almoxarifado_id='".$_GET[almoxarifado_id]."' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
				//pega o preço do produto pra calcular o valor da diferença
				$info_produto=mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id='{$produto_id[$i]}'"));
				
				$produto_qtd=moedaBrToUsa($nova_qtd[$i]);
				
				mysql_query($inv="
				$modo_sql estoque_inventario_item 
				SET 
					inventario_id='$inventario_id',
					produto_id='{$produto_id[$i]}', 
					qtd_inventario='$produto_qtd', 
					qtd_estoque='{$produto_estoque[$i]}', 
					qtd_diferenca='".($produto_qtd-$produto_estoque[$i])."',
					valor_diferenca='".(($produto_qtd-$produto_estoque[$i])*$info_produto->preco_compra)."'
					$fim_sql
					 ");
				/*
				if($p_qtd>$s->saldo){
					$entrada=$p_qtd-$s->saldo;
					$saida=0;
					$saldo_final=$p_qtd;
				}else{
					$entrada=0;
					$saida=$s->saldo-$p_qtd;
					$saldo_final=$p_qtd;
				}
				
				mysql_query($trace="INSERT INTO estoque_mov SET usuario_id='".$_SESSION['usuario']->id."', almoxarifado_id='".$_SESSION['usuario']->id."', produto_id='".$produto_id[$i]."', data_hora=NOW(), entrada='".$entrada."', saida='".$saida."', saldo='".$saldo_final."', vkt_id='$vkt_id' ");*/
				
				//salvaUsuarioHistorico("Tela - Inventário",'Deu Baixa no Produto ID $produto_id','estoque_mov',$produto_id);
				
			}
		}
		return $inventario_id;
	}
		
}


function fechaInventario($produto_id,$produto_estoque,$nova_qtd,$almoxarifado_id,$inventario_id=NULL){
	global $vkt_id;
	$total=count($produto_id);
	if($total>0){
		// Checa se tá editando um ou se está criando novo registro de inventário
		if($inventario_id==NULL){
			$acao='inserir';
			//cria novo inventário	
			mysql_query($t="INSERT INTO estoque_inventario 
			SET usuario_id='".$_SESSION['usuario']->id."', almoxarifado_id='$almoxarifado_id', data_criado=NOW(), status='0', vkt_id='$vkt_id' $fim_sql");
			$inventario_id=mysql_insert_id();
			//prepara a movimentacao de itens do invnetario
			$modo_sql="INSERT INTO ";
			$fim_sql="";
		}elseif($inventario_id>0){
			$acao='editar';
			//edita inventário
			mysql_query($trace="UPDATE estoque_inventario 
			SET usuario_id='".$_SESSION['usuario']->id."', data_modificado=NOW(), status='0' WHERE id='$inventario_id'");
		}
		//echo $t.mysql_error();
		
		for($i=0;$i<$total;$i++){
			if($nova_qtd[$i]>0){
				//verifica se é pra editar ou inserir estoque_inventario_item
				if($acao=='editar'){
					//retorna o ultimo estoque_inventario_item do produto
					$inventario_item_id=mysql_result(mysql_query($o="
					SELECT id FROM estoque_inventario_item WHERE produto_id='{$produto_id[$i]}' AND inventario_id='$inventario_id' ORDER BY id DESC LIMIT 1 "),0,'id');
					
					//prepara a movimentacao de itens do invnetario
					$modo_sql= "UPDATE ";
					$fim_sql=" WHERE id='$inventario_item_id' AND vkt_id='$vkt_id' ";
				}elseif($acao=='inserir'){
					$modo_sql="INSERT INTO";
					$fim_sql=", vkt_id='$vkt_id'";
				}
				//pega quanto tem no estoque do produto pra fazer a soma com a nova quantidade conferida no inventário
				$s=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='".$produto_id[$i]."' AND almoxarifado_id='".$_GET[almoxarifado_id]."' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
				//pega o preço do produto pra calcular o valor da diferença
				$info_produto=mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id='{$produto_id[$i]}'"));
				
				$produto_qtd=moedaBrToUsa($nova_qtd[$i]);
				
				mysql_query($inv="
				$modo_sql estoque_inventario_item 
				SET 
					inventario_id='$inventario_id',
					produto_id='{$produto_id[$i]}', 
					qtd_inventario='$produto_qtd', 
					qtd_estoque='{$produto_estoque[$i]}', 
					qtd_diferenca='".($produto_qtd-$produto_estoque[$i])."',
					valor_diferenca='".(($produto_qtd-$produto_estoque[$i])*$info_produto->preco_compra)."'
					$fim_sql
					 ");
				/*
				if($p_qtd>$s->saldo){
					$entrada=$p_qtd-$s->saldo;
					$saida=0;
					$saldo_final=$p_qtd;
				}else{
					$entrada=0;
					$saida=$s->saldo-$p_qtd;
					$saldo_final=$p_qtd;
				}
				
				mysql_query($trace="INSERT INTO estoque_mov SET usuario_id='".$_SESSION['usuario']->id."', almoxarifado_id='".$_SESSION['usuario']->id."', produto_id='".$produto_id[$i]."', data_hora=NOW(), entrada='".$entrada."', saida='".$saida."', saldo='".$saldo_final."', vkt_id='$vkt_id' ");*/
				
				//salvaUsuarioHistorico("Tela - Inventário",'Deu Baixa no Produto ID $produto_id','estoque_mov',$produto_id);
				
			}
		}
		return $inventario_id;
	}
		
}
function cancelaInventario($inventario_id){
	global $vkt_id;
	mysql_query("UPDATE estoque_inventario SET status='2' WHERE id='$inventario_id' AND  vkt_id='$vkt_id'");
}





?>