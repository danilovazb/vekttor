<?php
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");
		 
		if($_GET['acao'] == 'cadastra'){
				$transferencia_id = $_POST['transferencia'];
				$produto_id       = $_POST['produto_id'];
				$origem           = $_POST['origem'];
				$destino          = $_POST['destino'];
				$qtd              = $_POST['qtd'];
				
				// Consulta na tabela produto para pegar suas informaçoes Ex.: valor_ini = preco_compra 
				$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id = ".$produto_id." AND vkt_id = '$vkt_id'"));
				$estoque_mov_origem = mysql_fetch_object(mysql_query(" SELECT * FROM estoque_mov WHERE produto_id = '".$produto_id."' AND almoxarifado_id = '".$origem."' AND vkt_id = '$vkt_id' ORDER BY id DESC LIMIT 1"));
				$estoque_mov_destino = mysql_fetch_object(mysql_query(" SELECT * FROM estoque_mov WHERE produto_id = '".$produto_id."' AND almoxarifado_id = '".$destino."' AND vkt_id = '$vkt_id' ORDER BY id DESC LIMIT 1"));
				
				$saldo_origem = $estoque_mov_origem->saldo / $produto->conversao2;
				$saldo_destino = $estoque_mov_destino->saldo / $produto->conversao2;
				// saldo / conversao2
				
				// insere o produto na tabela estoque_transferencia_item sendo um item do produto
				mysql_query(" INSERT INTO estoque_transferencia_item 
							SET 
								vkt_id           = '$vkt_id',
								transferencia_id = '$transferencia_id',
								produto_id       = '$produto_id',
								qtd_enviada      = '".qtdBrToUsa($qtd)."',
								valor_ini        = '".$produto->preco_compra."',
								ocorrencia       = '$ocorrencia',
								unidade          = '".$produto->unidade_embalagem."',
								fatorconversao   = '".$produto->conversao."',
								recebido         = 'nao',
								marcado          = 'sim'
				");				
		
				$dados[] = array("produto_id"=>$produto->id,"produto_nome"=>utf8_encode($produto->nome),"conversao2"=>$produto->conversao2,"saldo_origem"=>substr($saldo_origem,0,4),"saldo_destino"=>substr($saldo_destino,0,4), "embalagem"=>substr($produto->unidade_embalagem,0,3),"qtd"=>$qtd,"id"=>mysql_insert_id());
				echo json_encode($dados);
				//print_r($dados);
		} // fim de if acao
		
		if($_GET['acao'] == 'upqtd'){
				$qtd              = qtdBrToUsa($_POST['qtd'],2);
				$produto          = $_POST['id_p'];
				$transferencia_id = $_POST['trans_id'];
				$item_id          = $_POST['item_id'];
				$unidade_tipo     = $_POST['und'];
				$fator_conversao  = $_POST['conversao'];
				
				if($unidade_tipo=='unidade_uso'){
					$qtd = $qtd/$fator_conversao;  
				}
				
				//$qtd = $qtd);
				
				
				mysql_query($t=" UPDATE estoque_transferencia_item SET qtd_enviada = '$qtd', unidade_tipo='$unidade_tipo' WHERE produto_id = '$produto' AND transferencia_id = '$transferencia_id' AND vkt_id = '$vkt_id' AND id = '$item_id'");	
				
				echo $_POST['qtd'];
				
		}
		
		if($_GET['acao'] == 'exclui'){
				$produto = $_POST['produto'];
				$item_id = $_POST['item_id'];
				mysql_query(" DELETE FROM estoque_transferencia_item WHERE id = '".$item_id."' AND vkt_id = '$vkt_id' ");	
		}
		
		if($_GET['acao'] == 'cancelar'){
				$trans_id = $_POST['trans_id'];
				mysql_query(" UPDATE estoque_transferencia SET status = '3' WHERE id = '".$trans_id."' AND vkt_id = '$vkt_id' ");
				//mysql_query(" DELETE FROM estoque_transferencia_item WHERE transferencia_id = '".$trans_id."'");
		}
		if($_GET['acao'] == 'oc_pedido'){
				$trans_id  = $_POST['trans_id'];
				$oc_pedido = $_POST['oc_pedido'];
				mysql_query(" UPDATE estoque_transferencia SET ocorrencia_pedido = '$oc_pedido' WHERE id='$trans_id' AND vkt_id = '$vkt_id' ");
		} // atualiza ocorrencia item do pedido
		if($_GET['acao'] == 'oc_pedido_item'){
				
				$oc_item          = iconv('utf-8','iso-8859-1',$_POST['oc_item']);
				$produto_id       = $_POST['p'];
				$item_id          = $_POST['item_id'];
				$transferencia_id = $_POST['trans_id'];
				
				mysql_query($t=" UPDATE estoque_transferencia_item SET ocorrencia = '$oc_item' WHERE produto_id = '$produto_id' AND transferencia_id = '$transferencia_id' AND vkt_id = '$vkt_id' AND id = '$item_id'
				");	
				
		}
?>
		