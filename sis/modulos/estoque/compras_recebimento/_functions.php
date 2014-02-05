<?
function cadastraPedido($fornecedor_id,$vkt_id){
	$query = mysql_query($t="INSERT INTO estoque_compras SET vkt_id='$vkt_id',fornecedor_id='".$fornecedor_id."', unidade_id='5', data_inicio='".date("Y-m-d")."', status='Em aberto', obs_pedido='', obs_chegada=''");
	echo mysql_error();
	$ultimo_id = mysql_insert_id();
	
	return $ultimo_id;
	//for($i=0;$i<sizeof($dados['produto_id']);$i++){
		//cadastraItem($vkt_id,$dados['produto_id'][$i],$ultimo_id,$dados['qtd'][$i],moedaBrtoUsa($dados['vlr'][$i]),$dados['unidade'][$i],$dados['conversao'][$i],$dados['conversao1']);
	//}
}
function cadastraItem($vkt_id,$dados){
	$query = mysql_query($t="INSERT INTO estoque_compras_item SET vkt_id='$vkt_id', produto_id='".$dados['produto_id']."',pedido_id='".$dados['pedido_id']."',qtd_pedida='".$dados['qtd'].",valor_ini='".$dados['vlr'].",
	unidade='".$dados['unidade']."', fatorconversao='".$dados['conversao1']."', recebido='nao'");
	//echo $t."<br>";
	//echo mysql_error();
}

function MandarFinanceiro($campos){
	
		global $vkt_id;
					
		//if(empty($campos['conta_id'])){
			//	echo "<script> alert('Selecione uma Conta');";
				//return false;
		//}
		if(empty($campos['valor_parcela'])){
			$campos['valor_parcela'] = $campos['valor_total'];
		}
		if(empty($campos['data_vencimento_parcela'])){
			$campos['data_vencimento_parcela'] = $campos['pri_parcela'];
		}
		if(empty($campos['descricao_parcela'])){
			$campos['descricao_parcela'] = array('Parcela Unica');
		}
								
		$contaID       = $campos['conta_id'];
		$centroCustoID = $campos['centro_custo_id'];
		$plContaID     = $campos['plano_de_conta_id'];
		
		if($campos['parcelas'] > 1){
		
			$valorParcela = $campos['valor_parcela'];
		
		}else{
			
			$valorParcela = $campos['valor_total'];
				
		}
		$desParcela   = $campos['descricao_parcela'];
		$dataVencimento = $campos['data_vencimento_parcela'];
			$aMes = date('Y/m');
			$dataRegistro = date('Y-m-d H:i:s');
			
			//echo "<div id='conteudo'>aqui esta a afuncao</div>";
				for($i=0;$i < sizeof($valorParcela);$i++){
											
											$sql = " INSERT INTO financeiro_movimento 
												  SET
													cliente_id        = '$vkt_id',
													conta_id		  = '$contaID',
													internauta_id	  = '".$campos['fornecedor_id']."',
													data_registro     = '".$dataRegistro."',
													data_vencimento	  = '".dataBrToUsa($dataVencimento[$i])."',
													ano_mes_referencia= '$aMes',
													descricao		  = '".$desParcela[$i]."',
													doc				  = '".$campos['nro_nota_fiscal']."',
													origem_id         = '".$campos['id']."',
													forma_pagamento   = '".$campos['forma_pagamento']."',
													valor_cadastro    = '".moedaBRToUsa($valorParcela[$i])."',
													tipo              = 'pagar',
													status            = '0',
													movimentacao      = 'Ordem de Compra',
													origem_tipo       = 'compra' 
												";
												//echo $sql;
												mysql_query($sql);
												$movID = mysql_insert_id();
												
												/*- SQL PARA TABELA financeiro_centro_has_movimento -*/
												$sqlCentroAsMov = " INSERT INTO financeiro_centro_has_movimento
																		SET
																			movimento_id = '$movID',
																			plano_id     = '$centroCustoID[$i]',
																			valor        = '".moedaBRToUsa($valorParcela[$i])."'";
												mysql_query($sqlCentroAsMov); 
												//echo $sqlCentroAsMov;
												
												/*- SQL PARA A TABELA financeiro_plano_has_movimento -*/ 
												 $sqlPlanoAsMov = " INSERT INTO financeiro_plano_has_movimento 
												 						SET
																			movimento_id = '$movID',
																			plano_id     = '$plContaID[$i]',
																			valor        = '".moedaBRToUsa($valorParcela[$i])."'
																		";
												mysql_query($sqlPlanoAsMov);
												//echo $sqlPlanoAsMov;
				}
				
	//$compra_q=mysql_query($t="SELECT * FROM estoque_compras WHERE id='".$_POST['compra_id']."' AND status !='Finalizado'");
	$compra_q=mysql_query($t="SELECT * FROM estoque_compras WHERE id='".$_POST['compra_id']."'");
	$compra=mysql_fetch_object($compra_q);
	Finalizar($compra->id,$compra->unidade_id, 'pago');
	
}/*fim da função*/

function Finalizar($compra_id,$unidade_id, $status='Finalizado'){	
	$query= mysql_query($t="UPDATE estoque_compras SET status='$status', data_recebimento=NOW() WHERE id='".$compra_id."'");
	
	global $vkt_id;
	global $usuario_id;
	//
	if($compra_id>0){
	//faz a movimentaçao no estoque
	$pedido_itens = mysql_query("SELECT * FROM estoque_compras_item WHERE pedido_id='".$compra_id."'");
	
	while($item=mysql_fetch_object($pedido_itens)){
		
		//verica se qual o ultimo estoque do produto para ser adicionado;
				
		$mov_estoque=mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_mov WHERE  almoxarifado_id ='$unidade_id' AND  produto_id ='".$item->produto_id."' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
		//echo $t." ".$item->produto_id." - Estoque Anterior: $mov_estoque->saldo - ";
		//consulta unidades do produto 
		$produto_unidade=mysql_query("SELECT * FROM produto where id='".$item->produto_id."'");
		
		
		//verifica a conversão
		if($item->unidade_tipo=="compra"){
			if($item->qtd_enviada>0){
				$qtd   = 0+($item->qtd_enviada*$item->fatorconversao*$item->fatorconversao2);
				
			}else{
				$qtd = 0+($item->qtd_pedida*$item->fatorconversao*$item->fatorconversao2);
			}
			if($item->valor_fim>0){
				$vlr_unidade = $item->valor_fim;				
			}else{
				$vlr_unidade = $item->valor_ini;
			}
			//echo "Compra $qtd";
		}
		if($item->unidade_tipo=="embalagem"){
			if($item->qtd_enviada>0){
				$qtd=0+($item->qtd_enviada*$item->fatorconversao2);
			}else{
				$qtd=0+($item->qtd_pedida*$item->fatorconversao2);
			}
			if($item->valor_fim>0){
				$vlr_unidade   = $item->valor_fim*$item->fatorconversao;				
			}else{
				$vlr_unidade   = $item->valor_ini*$item->fatorconversao;
			}
			//echo "Embalagem $qtd";
		}
		if($item->unidade_tipo=="uso"){
			if($item->qtd_enviada>0){
				$qtd=0+$item->qtd_enviada;
			}else{
				$qtd=0+$item->qtd_pedida;
			}
			if($item->valor_fim>0){
				$vlr_unidade   = $item->valor_fim*$item->fatorconversao2*$item->fatorconversao;				
			}else{
				$vlr_unidade   = $item->valor_ini*$item->fatorconversao2*$item->fatorconversao;
			}
			//echo "Uso $qtd";
		}
		
		if($item->valor_fim>0){
				$valor_item_compra   = $item->valor_fim;				
			}else{
				$valor_item_compra   = $item->valor_ini;
			}

		$saldo =$mov_estoque->saldo+$qtd;
		//echo " - Novo Saldo: $saldo <br>";
		//
		if($qtd>0){
			
			mysql_query($t="UPDATE 
					estoque_compras_item 
				SET
					qtd_enviada='$qtd',
					valor_fim='$valor_item_compra'
				WHERE id='$item->id'");
				//echo $t."<br>";	
			mysql_query($t="INSERT INTO estoque_mov SET 
				produto_id='".$item->produto_id."', 
				almoxarifado_id='".$unidade_id."', 
				usuario_id='$usuario_id',
				data_hora=NOW(), 
				entrada='$qtd', 
				saldo='$saldo',
				vkt_id='$vkt_id', 
				doc_id='".$compra_id."', 
				doc_tipo='compra'");
			//echo $t."<br>";
			//echo mysql_error();
			
			
			
			mysql_query($t="UPDATE produto SET custo='$vlr_unidade' WHERE id='".$item->produto_id."'");
			//echo $t;
		}
	}
	//
	}
}

?>