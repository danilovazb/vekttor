<?php
// Muda o Status de cada Equipamento para disponivel caso o status for selecionado como Cancelado ou Devolvido
function StatusDisponivel(array $itens){ 
							//print_r($itens);
							//status 1=disponível, 2=indisponível
							for($i=0;$i < sizeof($itens);$i++){
									$update = mysql_query(" UPDATE aluguel_equipamentos_itens SET status = '1' WHERE id = '$itens[$i]'");
									//echo $update.'<br/>';
							}
							
}
function StatusIndisponivel(array $itens){ 
					//print_r($itens);
					//status 1=disponível, 2=indisponível
					for($i=0;$i < sizeof($itens);$i++){
							$update = mysql_query(" UPDATE aluguel_equipamentos_itens SET status = '2' WHERE id = '$itens[$i]'");
									//echo $update.'<br/>';
					}
							
}
// Muda o Status de cada Equipamento para devolvido caso o status for selecionado como Cancelado ou Devolvido
function StatusDevolvido(array $itens){
	 			//status_item 1='Locado',2='Devolvido'
				for($i=0;$i < sizeof($itens);$i++){
					 $update = mysql_query(" UPDATE aluguel_locacao_itens SET status_item = '2' WHERE id = '$itens[$i]'");
					 //echo $update.'<br/>';
				}
}
// Aqui quando ele Atualiza o Status para Locaçao
function StatusLocado(array $itens){
				for($i=0;$i < sizeof($itens);$i++){
						mysql_query(" UPDATE aluguel_locacao_itens SET status_item = '1' WHERE id = '$itens[$i]' ");
				}
}
// Aqui Funcao para Cancelar Aluguel e normalizar os itens da mesma
function Cancelamento($campos){
					   //echo $campos['id'];
						
						
						
						$selectItens = (mysql_query(" SELECT * FROM aluguel_locacao_itens WHERE locacao_id = '".$campos['id']."' "));
								while($itemDevolvido=mysql_fetch_object($selectItens)){
									/* Aqui seta o status como 2 = Devolvido */
									mysql_query(" UPDATE aluguel_locacao_itens SET status_item = '2' WHERE id = '".$itemDevolvido->id."'");
									mysql_query(" UPDATE aluguel_equipamentos_itens SET status = '1' WHERE id = '".$itemDevolvido->item_equipamento_id."'");
									  				
								}
						
						/* Aqui seta o status como 4 = Cancelado */
						mysql_query(" UPDATE aluguel_locacao 
														SET 
															status_locacao = '4',
															motivo_cancelamento = '$campos[motivoCancelamento]' 
														WHERE 
															id = '".$campos['id']."' "); 
						
}


function deletar_locacao($id){
				
				$sql = mysql_query(" SELECT * FROM aluguel_locacao_itens WHERE locacao_id = '$id' ");
						
						while($item=mysql_fetch_object($sql)){
								$id_item_equip[] = $item->item_equipamento_id;
						}
						
				for($i=0;$i<sizeof($id_item_equip);$i++){
								mysql_query(" UPDATE aluguel_equipamentos_itens SET status = '1' WHERE id = '$id_item_equip[$i]' ");
				}
				
				mysql_query(" DELETE FROM aluguel_locacao_itens WHERE locacao_id = '$id'");
				mysql_query(" DELETE FROM aluguel_locacao WHERE id = '$id' ");
				mysql_query($t="DELETE FROM aluguel_custos WHERE locacao_id='$id'");
}

function insere_aluguel_equipamento($campos){
				global $vkt_id;	
					
						$status_locacao   = $campos['status_locacao'];
						$sql=" INSERT INTO aluguel_locacao
												SET
													vkt_id               = '$vkt_id',
													cliente_id           = '$campos[cliente_id]',
													descricao            = '$campos[descricao]',
													data_locacao         = '".dataBrToUsa($campos['data_locacao'])."',
													data_devolucao       = '".dataBrToUsa($campos['data_devolucao'])."',
													data_reserva         = '".dataBrToUsa($campos['data_reserva'])."',
													qtd_dias             = '$campos[dias]',
													obervacao_locacao    = '$campos[obervacao_locacao]',
													observacao_devolucao = '$campos[observacao_devolucao]',
													status_locacao       = '$campos[StatusLocacao]',
													desconto             = '".moedaBrToUsa($campos['desconto'])."',
													acrescimo            = '".moedaBrToUsa($campos['acrescimo'])."',
													valor_total          = '".moedaBrToUsa($campos['TotalGeral'])."',
													forma_pagamento      = '$campos[forma_pagamento]',
													obs_pagamento        = '$campos[obs_pagamento]',
													pago                 = 'nao',
													contrato             = '$campos[texto]',
													comissao_vendedor    = '".moedaBrToUsa($campos['comissao_vendedor'])."'
						";
						//echo $sql;
						mysql_query($sql);
						$locacao_id = mysql_insert_id();
						//echo "<br/>".$id_equipamento;
									
									
									$id_equipamento   = $campos['id_equipamento'];
									$valor_item       = $campos['valor_item'];
									$valor_total_item = $campos['valor_total_item'];
									
									if(($status_locacao == '4') or ($status_locacao == '2')){
											//AtualizaStatus($id_equipamento);								
									}	
										for($i=0;$i<sizeof($id_equipamento);$i++){
											if($id_equipamento[$i] != '0'){
												$sql_item = " INSERT INTO aluguel_locacao_itens
																	SET
																  vkt_id              = '$vkt_id',
																  locacao_id          = '".$locacao_id."',
																  item_equipamento_id = '".$id_equipamento[$i]."',
																  valor_unitario      = '".moedaBrToUsa($valor_item[$i])."',
																  valor_total         = '".moedaBrToUsa($valor_total_item[$i])."',
																  status_item         = '1'
															";
															mysql_query($sql_item);
															mysql_query(" UPDATE aluguel_equipamentos_itens 
																							SET
																								status = '2'
																							WHERE id = '".$id_equipamento[$i]."'");
											}
											
										}
							
							$c=0;
							if(!empty($campos[id_despesa])){
								
								foreach($campos[despesas_tbl] as $despesas){
									//echo $despesas."<br>";
									if($despesas!=-1){
										insere_despesas($locacao_id,$despesas,$campos[qtd_despesas][$c],$campos[valor_despesa][$c],$vkt_id);
										$c++;
									}
								}
							}
							if($campos['imprimir_ok'] == '1'){
								echo "<script>
										window.open('modulos/aluguel/locacao_devolucao/impressao_locacao.php?id=$locacao_id','_BLANK');
						      		  </script>";	
							}
							
} /* final da funçao */



function altera_aluguel_equipamento($campos){
				global $vkt_id;
				$status_locacao   = $campos['status_locacao'];
				$todos            = $campos['todos'];
				$sql=" UPDATE aluguel_locacao
												SET
													cliente_id           = '$campos[cliente_id]',
													descricao            = '$campos[descricao]',
													data_locacao         = '".dataBrToUsa($campos['data_locacao'])."',
													data_devolucao       = '".dataBrToUsa($campos['data_devolucao'])."',
													data_reserva         = '".dataBrToUsa($campos['data_reserva'])."',
													qtd_dias             = '$campos[dias]',
													obervacao_locacao    = '$campos[obervacao_locacao]',
													observacao_devolucao = '$campos[observacao_devolucao]',
													status_locacao       = '$campos[StatusLocacaoUpdate]',
													desconto             = '".moedaBrToUsa($campos['desconto'])."',
													acrescimo            = '".moedaBrToUsa($campos['acrescimo'])."',
													valor_total          = '".moedaBrToUsa($campos['TotalGeral'])."',
													forma_pagamento      = '$campos[forma_pagamento]',
													obs_pagamento        = '$campos[obs_pagamento]',
													contrato             = '$campos[texto]',
													comissao_vendedor    = '".moedaBrToUsa($campos['comissao_vendedor'])."'
												WHERE 
													id = '$campos[id]'
						";
						//echo $sql;
						mysql_query($sql);
						$locacao_id     = $campos['id'];
						$id_equipamento = $campos['id_equipamento'];
							
							
						
						if(sizeof($id_equipamento) > 0){
							$valor_item       = $campos['valor_item'];
							$valor_total_item = $campos['valor_total_item'];
							
							for($i=0;$i<sizeof($id_equipamento);$i++){
									if($id_equipamento[$i] != '0'){
												$sql_item = " INSERT INTO aluguel_locacao_itens
																	SET
																  vkt_id              = '$vkt_id',
																  locacao_id          = '".$locacao_id."',
																  item_equipamento_id = '".$id_equipamento[$i]."',
																  valor_unitario      = '".moedaBrToUsa($valor_item[$i])."',
																  valor_total         = '".moedaBrToUsa($valor_total_item[$i])."',
																  status_item         = '1'
															";
															//echo $sql_item;
															mysql_query($sql_item);
															mysql_query(" UPDATE aluguel_equipamentos_itens 
																							SET
																								status = '2'
																							WHERE 
																								id = '".$id_equipamento[$i]."'																			
												");
									}
											
							}
						} /* Fim if Sizeof */
						
						$val_total_item  = $campos['val_total_item'];
						/* id da tabela aluguel_locacao_itens */
						$id_equip_update = $campos['id_equip_update'];
						
						/* id da Tabela aluguel_equipamentos_itens para atualizar, caso o Status cancelado ou devolvido */
						$id_item_equip   = $campos['id_item_equip'];  
						
						for($j=0; $j < sizeof($id_equip_update);$j++){
									if($val_total_item[$j] == '0'){
									mysql_query(" UPDATE aluguel_equipamentos_itens SET status = '1' WHERE id = '$id_item_equip[$j]'");
									$sql_delete = " DELETE FROM aluguel_locacao_itens WHERE id = '$id_equip_update[$j]' ";	
									mysql_query($sql_delete);	
									}
						}
						/*
						* Se os status for igual a 'Cancelado' ou 'Devolvido' Atualiza as informaçoes do equipamento para disponivel
						*/
										
							if(($status_locacao == '4')||($status_locacao == '2')){
											if(sizeof($id_item_equip) > 0){
												StatusDisponivel($id_item_equip); // Atualiza Status para disponivel
											}
											if(sizeof($id_equip_update) > 0){
												StatusDevolvido($id_equip_update);
											}
							}
							if($status_locacao == '1'){
									if(sizeof($id_item_equip) > 0){
											StatusIndisponivel($id_item_equip);
									}
									if(sizeof($id_equip_update) > 0){
											StatusLocado($id_equip_update);
									}
							}
							
							if(!empty($todos)){
								    $select = mysql_query(" SELECT * FROM aluguel_locacao_itens WHERE locacao_id = '$todos' ");
											while($item=mysql_fetch_object($select)){
														$item_equip_id[] = $item->item_equipamento_id;
											}
									StatusDisponivel($item_equip_id);
									mysql_query(" UPDATE aluguel_locacao_itens SET status_item = '2' WHERE locacao_id = '$todos'");	
							}
					$c=0;
					if(!empty($campos[id_despesa])){					
					foreach($campos[id_despesa] as $id_despesa){
						//echo $id_despesa."<br>";
						
						//alert($id_despesa);
						if($campos[despesas_tbl][$c]==-1){
							deleta_despesa($id_despesa);							
						}else if($id_despesa=='novo'){
							//alert($c);
							//if($despesas!=-1){
								insere_despesas($locacao_id,$campos[despesas_tbl][$c],$campos[qtd_despesas][$c],$campos[valor_despesa][$c],$vkt_id);
							//}
						}
						$c++;
					}
					}
						
}

function insere_despesas($locacao_id,$despesa,$qtd,$valor,$vkt_id){
	//print_r($campos[despesas]);
	mysql_query($t="INSERT INTO aluguel_custos SET nome='$despesa',locacao_id='".$locacao_id."', qtd='".$qtd."',valor='".$valor."',vkt_id='$vkt_id'");
	//echo $t;
}

function deleta_despesa($id_despesa){
	mysql_query("DELETE FROM aluguel_custos WHERE id='$id_despesa'");
	//echo $t;
}
function Pagamento($campos){ 
	
			global $vkt_id;
			
					
					$sqlPag = mysql_query(" UPDATE aluguel_locacao SET 
														pago          = 'sim'
												  WHERE 
												  		id = '$campos[id]'");
					
					/*if($campos['forEntrega'] > 0){
						Entrega($campos);		
					}*/
					
				
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
?>