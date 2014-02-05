<?php

function deletar_ordem_servico($id){
					mysql_query(" DELETE FROM os_item where os_id = '$id' ");
					mysql_query(" DELETE FROM os WHERE id = '$id' ");
}

function insere_ordem_servico($campos){
	global $login_id;
	global $vkt_id;
				
				//if($campos['ApAndSalve'] > 0){
							
				//}
				
				if($campos['orcado'] > 0){
						$orcado = 'sim';	
					} else{
						$orcado = 'nao';	
					}
					
					$numero_sequencial = mysql_fetch_object(mysql_query("
		SELECT 
			* 
		FROM os 
		WHERE
			vkt_id= '$vkt_id'
			ORDER BY id	DESC
			LIMIT 1
			"));
	$numero_sequencial = $numero_sequencial->numero_sequencial_empresa+1;
	
	$sql = "INSERT INTO os 
			SET 
				cliente_id          = '{$campos['cliente_id']}',
				vkt_id              = '$vkt_id',
				vendedor_id         = '{$campos['vendedor_id']}', 
				descricao           = '{$campos['descricao']}',
				tipo_atendimento    = '{$campos['tipo_atendimento']}',
				garantia            = '{$campos['garantia']}',
				data_final_garantia = '".dataBrToUsa($campos['data_final_garantia'])."',
				local_atendimento   = '{$campos['local_atendimento']}',
				defeito_reclamado   = '{$campos['defeito_reclamado']}',
				reparo_manutencao   = '{$campos['reparo_manutencao']}',
				data_cadastro       = '".dataBrToUsa($campos['data_cadastro'])."',
				data_entrega        = '".dataBrToUsa($campos['data_entrega'])."',
				data_aprovacao      = '".dataBrToUsa($campos['data_aprovacao'])."',
				data_execucao       = '".dataBrToUsa($campos['data_execucao'])."',
				nota_fiscal_produtos = '{$campos['nota_fiscal_produtos']}',
				nota_fiscal_servico  = '{$campos['nota_fiscal_servico']}',
				valor_deslocamento   = '".moedaBrToUsa($campos['valor_deslocamento'])."',
				desconto             = '".moedaBrToUsa($campos['desconto'])."',
				acrescimo            = '".moedaBrToUsa($campos['acrescimo'])."',
				valor_total          = '".moedaBrToUsa($campos['ostotal'])."',
				subtotal             = '".moedaBrToUsa($campos['subtotal'])."',
				orcado               = '$orcado',
				data_orcamento       = '".dataBrToUsa($campos['data_orcado'])."',
				situacao             = '{$campos['situacao_orcamento']}',
				comissao_vendedor    = '".moedaBrToUsa($campos['comissao_vendedor'])."',
				os_obs				 = '".$campos['os_obs']."',
				qtd_parcelas_resumo  = '".$campos['parcelas_resumo']."',
				forma_pagamento		 = '".$campos['forma_pagamento_resumo']."',
				numero_sequencial_empresa = '$numero_sequencial',
				qtd_dias             = '".$campos['dias']."' 
		   ";
				//echo $sql;
				$result = mysql_query($sql);
				$os_id = mysql_insert_id();
				
					$servico     = $campos['array_servico_id'];
					$produto     = $campos['array_produto_id'];
					
					$funcionario = $campos['array_funcionario_id'];
					$valor_und_produto = $campos['array_valor_produto'];
					$qtd_produto       = $campos['array_qtd_produto'];
					
					$valor_und_servico = $campos['array_valor_servico'];
					$valor_funcionario = $campos['valor_tecnico'];
					$qtd_servico       = $campos['array_qtd_servico'];
					$obsServico        = $campos['obsItem']; 
					$obs_producao	   = $campos['obsProducao'];
					$altura            = $campos['altura_item'];
					$largura           = $campos['largura_item'];				
					//$count_servico = sizeof($servico);
					//$count_produto = sizeof($produto);
					
					for($i=0; $i < sizeof($servico); $i++){
								if($servico[$i] != '0'){	
									$servico_item_os = " INSERT INTO os_item 
													SET
														vkt_id          = '$vkt_id',
														os_id           = '$os_id',
														servico_id      = '$servico[$i]',
														valor_servico   = '".moedaBrToUsa($valor_und_servico[$i])."',
														valor_funcionario = '".moedaBrToUsa($valor_funcionario[$i])."',
														qtd_servico     = '$qtd_servico[$i]',
														funcionario_id  = '$funcionario[$i]',
														altura_servico  = '$altura[$i]',
														largura_servico = '$largura[$i]',
														obs_item_servico = '$obsServico[$i]',
														obs_item_producao = '$obs_producao[$i]',
														status            = '1'
														";
										//echo $servico_item_os."<br/>";	
										mysql_query($servico_item_os);
								}
					}
					for($i=0; $i < sizeof($produto); $i++){
								if($produto[$i] != '0'){
									$produto_item_os = " INSERT INTO os_item_produto
													SET
														vkt_id          = '$vkt_id',
														os_id           = '$os_id',
														produto_id      = '$produto[$i]',
														valor_produto   = '".moedaBrToUsa($valor_und_produto[$i])."',
														qtd_produto     = '$qtd_produto[$i]',
														status          = '1'
														";			
									//echo $produto_item_os.'<br/>';
									mysql_query($produto_item_os);
								}
					}
					if($campos['imprimir_ok'] == '1'){
						echo "<script>
									window.open('modulos/ordem_servico/ordem_servico/rel_os.php?id=$os_id','_BLANK');
						      </script>";	
					}
					
					$total_item_depesa = $campos['total_item_despesa'];
					$descricao_despesa = $campos['descricao_despesas_item'];
					$qtd_despesa       = $campos['qtd_despesas_item'];
					$valor_despesa     = $campos['valor_despesas_item'];
					
						for($i=0;$i< sizeof($total_item_depesa); $i++){
									//echo '<div id="conteudo">'.$total_item_depesa[$i].'</div>';
									$sql_despesa = " INSERT INTO os_custo SET
																	vkt_id     = '$vkt_id',
																	os_id      = '$os_id',
																	descricao  = '$descricao_despesa[$i]',
																	qtd        = '$qtd_despesa[$i]',
																	valor      = '".moedaBrToUsa($valor_despesa[$i])."',
																	total_item = '".moedaBrToUsa($total_item_depesa[$i])."'
															";
									mysql_query($sql_despesa);
						}
						
			if($campos['aprSim'] > 0){
				$sqlAprova = mysql_query(" UPDATE os 
										SET 
											situacao  = '2',
											status_os = '1'
										WHERE 
											id = '$os_id'
										");
				echo "<script> 
						window.open('modulos/ordem_servico/ordem_servico/form.php?id=$os_id','carregador');
					 	
					 </script>";
			}
		if($result){
		
		} else{
					//mysql_error($result);	
		}
		
		if(strlen($_FILES['arquivo_modelo']['name'])>0){
			upload_arquivo_modelo($os_id);
		}
	
}



function altera_ordem_servico($campos){
	global $login_id;
	global $vkt_id;
	
	$select = mysql_query("SELECT * FROM os_item WHERE os_id = '".$campos['id']."' AND vkt_id = '$vkt_id' ORDER BY id ASC");
					
	while($consulta=mysql_fetch_array($select)){
				if($consulta['produto_id'] != 0){
					$bd_produto[] = $consulta['produto_id'];
				}
				if($consulta['servico_id'] != 0){
					$bd_servico[] = $consulta['servico_id'];
				}
	}
	
	if($campos['orcado'] > 0){
		$orcado = 'sim';	
	} else{
		$orcado = 'nao';	
	}
	if(!empty($campos['data_aprovacao'])){
		$data_aprovacao = "data_aprovacao      = '".dataBrToUsa($campos['data_aprovacao'])."',";
	}else{
		$data_aprovacao = "";
	}
	
	
	$sql = "UPDATE os 
			SET 
				cliente_id          = '{$campos['cliente_id']}',
				vkt_id              = '$vkt_id',
				vendedor_id         = '{$campos['vendedor_id']}', 
				descricao           = '{$campos['descricao']}',
				tipo_atendimento    = '{$campos['tipo_atendimento']}',
				garantia            = '{$campos['garantia']}',
				data_final_garantia = '".dataBrToUsa($campos['data_final_garantia'])."',
				local_atendimento   = '{$campos['local_atendimento']}',
				defeito_reclamado   = '{$campos['defeito_reclamado']}',
				reparo_manutencao   = '{$campos['reparo_manutencao']}',
				data_cadastro       = '".dataBrToUsa($campos['data_cadastro'])."',
				data_entrega        = '".dataBrToUsa($campos['data_entrega'])."',
				$data_aprovacao
				data_execucao       = '".dataBrToUsa($campos['data_execucao'])."',
				nota_fiscal_produtos = '{$campos['nota_fiscal_produtos']}',
				nota_fiscal_servico  = '{$campos['nota_fiscal_servico']}',
				valor_deslocamento   = '".moedaBrToUsa($campos['valor_deslocamento'])."',
				desconto             = '".moedaBrToUsa($campos['desconto'])."',
				acrescimo            = '".moedaBrToUsa($campos['acrescimo'])."',
				valor_total          = '".moedaBrToUsa($campos['ostotal'])."',
				subtotal             = '".moedaBrToUsa($campos['subtotal'])."',
				orcado               = '$orcado',
				data_orcamento       = '".dataBrToUsa($campos['data_orcado'])."',
				obs_pagamento        = '{$campos['obs_pagamento']}',
				comissao_vendedor    = '".moedaBrToUsa($campos['comissao_vendedor'])."',
				os_obs               = '".$campos['os_obs']."',
				qtd_parcelas_resumo  = '".$campos['parcelas_resumo']."',
				forma_pagamento		 = '".$campos['forma_pagamento_resumo']."',
				qtd_dias             = '".$campos['dias']."' 
			WHERE 
				id = '{$campos['id']}'
		   ";
		  //echo $sql;
		   mysql_query($sql);
		   
		   	if(strlen($_FILES['arquivo_modelo']['name'])>0){
				upload_arquivo_modelo($campos['id']);
			}
		//echo mysql_error();	 
				/*- SCRIPT PARA INSERIR SERVICO -*/
					$servico    = $campos['array_servico_id'];
					$valServico = $campos['array_valor_servico'];
					$valFunc    = $campos['valor_tecnico'];
					$qtdServico = $campos['array_qtd_servico'];
					$funcID     = $campos['array_funcionario_id']; 
					$altura     = $campos['altura_item'];
					$largura    = $campos['largura_item'];
					$obsServico = $campos['obsItem'];
					$obs_producao = $campos['obsProducao'];
					
					for($i=0; $i < sizeof($servico); $i++){
									if($servico[$i] != '0'){
									$servico_item_os = " INSERT INTO os_item 
													SET
														vkt_id          = '$vkt_id',
														os_id           = '$campos[id]',
														servico_id      = '$servico[$i]',
														valor_servico   = '".moedaBrToUsa($valServico[$i])."',
														valor_funcionario = '".moedaBrToUsa($valFunc[$i])."',
														qtd_servico     = '$qtdServico[$i]',
														funcionario_id  = '$funcID[$i]',
														altura_servico  = '".moedaBrToUsa($altura[$i])."',
														largura_servico = '".moedaBrToUsa($largura[$i])."',
														obs_item_servico = '$obsServico[$i]',
														obs_item_producao = '$obs_producao[$i]',
														status            = '1'
														";
										
										//echo $servico_item_os."";	
										mysql_query($servico_item_os);
										//echo mysql_error();
									}
					}
					/*- SCRIPT PARA EXCLUIR SERVICO -*/
					$edit_osID      = $campos['edit_osID'];
					$id_ItemServico = $campos['id_ItemServico'];
						for($i=0;$i < sizeof($edit_osID);$i++){
								if($edit_osID[$i] == '0'){
										$sql_ServicoDel = " DELETE FROM os_item WHERE id = '$id_ItemServico[$i]' ";
										mysql_query($sql_ServicoDel);	
								}
						}
					/*- Muda o status do serviço -*/
					$check_edit_servico = $campos['check_edit_servico'];
						 for($i=0;$i < sizeof($check_edit_servico);$i++){
										 $s_status = " UPDATE os_item 
																	SET 
																		status = '$check_edit_servico[$i]'																			
																	WHERE 
																			id = '$id_ItemServico[$i]' 
																	 ";
														//echo $s_status.' / '.$i."<br/>";
														mysql_query($s_status);
							}
				
				
					/*- SCRIPT PARA INSERIR PRODUTO -*/
					$produto    = $campos['array_produto_id'];
					$valProduto = $campos['array_valor_produto'];
					$qtdProduto = $campos['array_qtd_produto'];
					for($i=0; $i < sizeof($produto); $i++){
								if($produto[$i] != '0'){
									$produto_item_os = " INSERT INTO os_item_produto
													SET
														vkt_id          = '$vkt_id',
														os_id           = '$campos[id]',
														produto_id      = '$produto[$i]',
														valor_produto   = '".moedaBrToUsa($valProduto[$i])."',
														qtd_produto     = '$qtdProduto[$i]',
														status          = '1'
														";			
									//echo $produto_item_os.'<br/>';
									mysql_query($produto_item_os);
								}
					}	
					
					/*- SCRIPT PARA EXCLUIR PRODUTO -*/
					$IDItemProduto = $campos['IDItemProduto'];
					$osIDProduto   = $campos['osIDProduto'];
					
						for($i=0;$i < sizeof($osIDProduto);$i++){
								if($osIDProduto[$i] == '0'){
										$sql_ProdutoDel = " DELETE FROM os_item_produto WHERE id = '$IDItemProduto[$i]' ";
										mysql_query($sql_ProdutoDel);	
								}
						}						
				
			
				
/*----------------- SCRIPT PARA DESPEAS ----------------------*/	
				
				$total_cad_ItemDespesa = $campos['total_item_despesa'];
				$descricao_despesa     = $campos['descricao_despesas_item'];
				$qtd_despesa           = $campos['qtd_despesas_item'];
				$valor_despesa         = $campos['valor_despesas_item'];						
						if(sizeof($total_cad_ItemDespesa) > 0){
								for($i=0;$i<sizeof($total_cad_ItemDespesa);$i++){
											$sql_despesa = " INSERT INTO os_custo SET
																	vkt_id    = '$vkt_id',
																	os_id     = '$campos[id]',
																	descricao = '$descricao_despesa[$i]',
																	qtd        = '$qtd_despesa[$i]',
																	valor      = '".moedaBrToUsa($valor_despesa[$i])."',
																	total_item = '".moedaBrToUsa($total_cad_ItemDespesa[$i])."'
															";
									mysql_query($sql_despesa);
								}	
						}
				
				$total_itemDespesa = $campos['total_itemDespesaEdit'];
				$id_itemDespesa    = $campos['id_item_despesa'];
					for($i=0; $i < sizeof($total_itemDespesa);$i++){
									if($total_itemDespesa[$i] == '0'){
										$sql = "
													DELETE FROM os_custo WHERE  id =  '$id_itemDespesa[$i]';
										";	
										mysql_query($sql);
									}
					}
						
}

	function Aprovar($campos){
			global $vkt_id;
				$executado = $campos['executado'];
					if($executado > 0)
						$statusOS = $executado;
					else 
						$statusOS = '1'; 
					if($campos['orcado'] > 0){
						$orcado = 'sim';	
					} else{
						$orcado = 'nao';	
					}
			$sql=" UPDATE os 
						SET 
							data_aprovacao  = '".dataBrToUsa($campos['data_aprovacao'])."',
							data_orcamento   = '".dataBrToUsa($campos['data_orcado'])."',
							obs_aprovacao	= '$campos[obs_aprovacao]',
							orcado          = '$orcado',
							situacao		= '$campos[situacao_aprovado]',
							status_os		= '$statusOS'
						WHERE 
							id = '$campos[id]'
							";
			//echo $sql;		
			mysql_query($sql);
	}
/*- FUNCAO PARA FORMA DE PAGAMENTO COM INTEGRAÇAO AO FINANCEIRO -*/

	function Entrega($campos){
				$sqlEntrega = " UPDATE os SET 
										 status_os   = '4',
										 obs_entrega = '".$campos['infoFinais']."'
									 WHERE 
									 	id = '".$campos['id']."'";
				mysql_query($sqlEntrega);	
	}
	
	function Pagamento($campos){ 
	
			global $vkt_id;
					
						if(empty($campos['ContaID'])){
								echo "<script> alert('Selecione uma Conta');</script>";
								exit;
						}
					
					if($campos['executado'] == 0){ $campos['executado']='3'; }
					$sqlPag = mysql_query(" UPDATE os SET 
														pago          = 'sim', 
														status_os     = '$campos[executado]', 
														data_execucao = '".dataBrToUsa($campos['data_execucao'])."'
												  WHERE 
												  		id = '$campos[id]'");
					
					
					if($campos['forEntrega'] > 0){
						Entrega($campos);		
					}
					
				
			$contaID       = $campos['conta_id'];
			$centroCustoID = $campos['centro_custo_id'];
			$plContaID     = $campos['plano_de_conta_id'];
			
			$valorParcela = $campos['valor_parcela'];
			$desParcela   = $campos['descricao_parcela'];
			$dataVencimento = $campos['data_vencimento_parcela'];
			$aMes = date('Y/m');
			//echo "<div id='conteudo'>aqui esta a afuncao</div>";
				for($i=0;$i < sizeof($valorParcela);$i++){
											$sql = " INSERT INTO financeiro_movimento 
												SET
													cliente_id        = '$vkt_id',
													conta_id		  = '$contaID',
													internauta_id	  = '".$campos['cliente_id']."',
													data_registro     = '".dataBrToUsa($campos['data_aprovacao'])."',
													data_vencimento	  = '".dataBrToUsa($dataVencimento[$i])."',
													ano_mes_referencia = '$aMes',
													descricao		  = '".$desParcela[$i]."',
													doc				  = '".$campos['id']."',
													forma_pagamento   = '".$campos['forma_pagamento']."',
													valor_cadastro    = '".moedaBRToUsa($valorParcela[$i])."',
													tipo              = 'receber',
													status            = '0' 
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
	}
	
	
	
	function CancelarOs($campos){
		
			$sql="UPDATE os SET
								motivo_cancelamento	= '$campos[motivo_cancelamento]',
								situacao            = '3'
							WHERE 
								id = '$campos[id]'";
			mysql_query($sql);	
	}

function upload_arquivo_modelo($os_id){
	
	$filis_autorizados = array('jpg','gif','png','pdf','jpeg');
	
	if(strlen($_FILES['arquivo_modelo']['name'])>4){
	  $pasta 	= 'upload/ordem_servico/arquivos_modelos/';
	  $extensao = strtolower(substr($_FILES['arquivo_modelo']['name'],-3));
	  $arquivo 	= $pasta.$os_id.'.'.$extensao;
	  $arquivodel= $pasta.$os_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['arquivo_modelo'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE os SET extensao_img='$extensao' WHERE id='$os_id'");
			 
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}

}

function verifica_parcelas($campos){
	
	global $vkt_id;
	
	$parcelas = mysql_query($t="SELECT 
								* 
							 FROM 
							 	financeiro_movimento 
							 WHERE 
							 	cliente_id='$vkt_id' AND
								doc='$campos[id]'
								ORDER BY id DESC
							 ");
	$qtd_parcelas = mysql_num_rows($parcelas);
							 
	if(sizeof($campos['descricao_parcela']) < $qtd_parcelas){
		
		$c=$qtd_parcelas-1;
		
		while($parcela = mysql_fetch_object($parcelas)){
				
			if($parcela->status !='1'){
				mysql_query($t="DELETE FROM financeiro_movimento WHERE id='$parcela->id'");
				//echo $t."<br>";
			}
			
			$c--;
			
			if($c<sizeof($campos['descricao_parcela'])){
				break;
			}
			
			
				
		}
	}
		
	if(sizeof($campos['descricao_parcela'])>$qtd_parcelas){
	
		//$quantidade_novas_parcelas = sizeof($campos['descricao_parcela']) - $qtd_parcelas;
		$contaID       = $campos['conta_id'];
		$centroCustoID = $campos['centro_custo_id'];
		$plContaID     = $campos['plano_de_conta_id'];
		
		$valorParcela = $campos['valor_parcela'];
		$desParcela   = $campos['descricao_parcela'];
		$dataVencimento = $campos['data_vencimento_parcela'];
		$aMes = date('Y/m');
		
		for($c=$qtd_parcelas;$c<=sizeof($campos['descricao_parcela'])-1;$c++){
			//echo "$c: Data de Vencimento: ".$dataVencimento[$c]."<br>";
			mysql_query($t="INSERT INTO financeiro_movimento 
				SET
					cliente_id        = '$vkt_id',
					conta_id		  = '$contaID',
					internauta_id	  = '".$campos['cliente_id']."',
					data_registro     = '".dataBrToUsa($campos['data_aprovacao'])."',
					data_vencimento	  = '".dataBrToUsa($dataVencimento[$c])."',
					ano_mes_referencia= '$aMes',
					descricao		  = '".$desParcela[$c]."',
					doc				  = '".$campos['id']."',
					forma_pagamento   = '".$campos['forma_pagamento']."',
					valor_cadastro    = '".moedaBRToUsa($valorParcela[$c])."',
					tipo              = 'receber',
					status            = '0' 
					
					
				");
				//echo $t."<br>";
		}
	
	}
}
function altera_status_impresso($dados){
	global $vkt_id;
	$id     = $dados['os_id'];		
	$status = $dados['status']; 
		
	mysql_query($t="UPDATE os SET impresso='$status' WHERE id='$id' AND vkt_id='$vkt_id'");
	//echo $t;
}
?>