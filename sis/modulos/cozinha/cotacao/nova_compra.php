<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include('_functions.php');
	
	global $vkt_id;
	$item_cotacao_id = $_GET['item_cot_id'];
	$item_cotacao_id = explode(",",$item_cotacao_id);
	$almoxarifado	 = $_GET['almoxarifado_id'];
	
	//Seleciona as cotaçoes e os seus itens escolhidos
	
	foreach($item_cotacao_id as $item_cotacao){
		$cotacao=mysql_fetch_object(mysql_query($t="SELECT * FROM 
														cozinha_cotacao cc,
														cozinha_cotacao_item cci,
														cozinha_necessidade_item cni
													WHERE 
														cci.vkt_id = '$vkt_id' AND
														cci.produto_id=cni.produto_id AND
														cci.necessidade_id=cni.necessidade_id AND
														cc.id = cci.cotacao_id AND
														cni.qtd_digitada>0 AND
														cni.cotar='sim' AND 
														cci.id='".$item_cotacao."'"));
		
		if($cotacao->id>0){
			$fornecedor_id[]=$cotacao->fornecedor_id;
			$cotacao_id[]=$cotacao->cotacao_id;
			$produto_id[]=$cotacao->produto_id;
		}
	}
	
	// print_r($fornecedor_id);
	$result = array_unique($fornecedor_id);
	$cotacao_id = array_unique($cotacao_id);
	$produto_id = array_unique($produto_id);
	$data_padrao = mysql_fetch_object(mysql_query("SELECT DATE_ADD(CURDATE(), INTERVAL 2 DAY) as data_padrao"));
	
	foreach($result as $resul){
		$query = mysql_query($t="INSERT INTO estoque_compras SET vkt_id='$vkt_id',fornecedor_id='".$resul."', unidade_id='$almoxarifado', data_inicio='".date("Y-m-d")."', status='Em aberto', obs_pedido='', obs_chegada='', data_chegada_prevista='$data_padrao->data_padrao'");
		//echo "Foernecedor: ".$resul."---";
		$ultimo = mysql_insert_id();
		
		foreach($cotacao_id as $cotacao){
			$cont=0;
			foreach($item_cotacao_id as $item_cotacao){
				
				$query_it=mysql_fetch_object(mysql_query($t="SELECT 
																* FROM 
															cozinha_cotacao cc, 
															cozinha_cotacao_item cci,
															cozinha_necessidade_item cni
																WHERE 
																cci.necessidade_id=cni.necessidade_id AND
																cci.id='".$item_cotacao."' AND 
																cci.cotacao_id = '$cotacao' AND 
																cc.fornecedor_id='".$resul."' AND 
																cni.qtd_digitada>0 AND
																cni.cotar='sim' AND
																cni.produto_id='".$produto_id[$cont]."' AND
																cci.cotacao_id=cc.id"));
				//	   
					   if($query_it->id>0){
							   		
							$query_i = mysql_query($t="INSERT INTO estoque_compras_item SET vkt_id='$vkt_id', produto_id='".$query_it->produto_id."',pedido_id='".$ultimo."',qtd_pedida='".$query_it->qtd_pedida."',valor_ini='".$query_it->valor_ini."', unidade='".$query_it->unidade."', marca='".$query_it->marca."', fatorconversao='".$query_it->fatorconversao."', fatorconversao2='".$query_it->fatorconversao2."', unidade_tipo='".$query_it->unidade_tipo."'");
						
					   }
			$cont++;
			}
		}
		
	}
	//alert("oi");
	echo "<script>top.location='http://vkt.srv.br/~nv/sis/?tela_id=110'</script>";
?>