<?php
// Muda o Status de cada Equipamento para disponivel caso o status for selecionado como Cancelado ou Devolvido
function StatusDisponivel(array $itens){ 
							//print_r($itens);
							//status 1=disponível, 2=indisponível
							for($i=0;$i < sizeof($itens);$i++){
									$update = mysql_query(" UPDATE aluguel_equipamentos_itens SET status = '1' WHERE id = '$itens[$i]'");
									////echo $update.'<br/>';
							}
							
}
function StatusIndisponivel(array $itens){ 
					//print_r($itens);
					//status 1=disponível, 2=indisponível
					for($i=0;$i < sizeof($itens);$i++){
							$update = mysql_query(" UPDATE aluguel_equipamentos_itens SET status = '2' WHERE id = '$itens[$i]'");
									////echo $update.'<br/>';
					}
							
}
// Muda o Status de cada Equipamento para devolvido caso o status for selecionado como Cancelado ou Devolvido
function StatusDevolvido(array $itens){
	 			//status_item 1='Locado',2='Devolvido'
				for($i=0;$i < sizeof($itens);$i++){
					 $update = mysql_query(" UPDATE aluguel_locacao_itens SET status_item = '2' WHERE id = '$itens[$i]'");
					 ////echo $update.'<br/>';
				}
}
// Aqui quando ele Atualiza o Status para Locaçao
function StatusLocado(array $itens){
				for($i=0;$i < sizeof($itens);$i++){
						mysql_query(" UPDATE aluguel_locacao_itens SET status_item = '1' WHERE id = '$itens[$i]' ");
				}
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
													status_locacao       = '7',
													desconto             = '$campos[desconto]',
													acrescimo            = '$campos[acrescimo]',
													valor_total          = '".moedaBrToUsa($campos['valor_total'])."',
													forma_pagamento      = '".$campos['forma_pagamento']."',
													qpPagamento          = '".$campos['parcelas']."',
													contrato             = '$campos[texto]'
						";
						//echo $sql;
						mysql_query($sql);
						$locacao_id = mysql_insert_id();
						////echo "<br/>".$id_equipamento;
									
								
									$id_equipamento_item   = $campos['id_equipamento_item'];
									
									$valor_item       = $campos['valor_item'];
									$valor_total_item = $campos['valor_total_item'];
									$periodo_equipamento = $campos['periodo_equipamento']; 
									
									if(($status_locacao == '4') or ($status_locacao == '2')){
											//AtualizaStatus($id_equipamento);								
									}
									
										for($i=0;$i<sizeof($id_equipamento_item);$i++){
													
											if($id_equipamento[$i] != '0'){
												$vlr_item_locacao = $campos[dias]*moedaBrToUsa($valor_item[$i])/$periodo_equipamento[$i];
												$sql_item = " INSERT INTO aluguel_locacao_itens
																	SET
																  vkt_id              = '$vkt_id',
																  locacao_id          = '".$locacao_id."',
																  item_equipamento_id = '".$id_equipamento_item[$i]."',
																  valor_unitario      = '".moedaBrToUsa($valor_item[$i])."',
																  valor_total         = '".$vlr_item_locacao."',
																  status_item         = '1'
															";
															////echo $sql_item;															
															mysql_query($sql_item);
															/*mysql_query(" UPDATE aluguel_equipamentos_itens 
																							SET
																								status = '2'
																							WHERE id = '".$id_equipamento[$i]."'");*/
											}
											
										}
							
							$c=0;
							if(!empty($campos[id_despesa])){
							foreach($campos[despesas_tbl] as $despesas){
								if($despesas!=-1){
									insere_despesas($locacao_id,$despesas,$campos[qtd_despesas][$c],$campos[valor_despesa][$c],$vkt_id);
									$c++;
								}
							}
							}
							
							if(!empty($campos[descricao_parcela])){
								$c=0;
								foreach($campos[descricao_parcela] as $parcela){
										insere_parcela($locacao_id,$parcela,$campos[valor_parcela][$c],$campos[data_vencimento_parcela][$c],$vkt_id);
										$c++;
								}
							
							}
}



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
													status_locacao       = '7',
													desconto             = '".moedaBrToUsa($campos[	desconto])."',
													acrescimo            = '".moedaBrToUsa($campos[acrescimo])."',
													valor_total          = '".moedaBrToUsa($campos['valor_total'])."',
													forma_pagamento      = '".$campos['forma_pagamento']."',
													qpPagamento          = '".$campos[parcelas]."',													
													contrato             = '$campos[texto]'
												WHERE 
													id = '$campos[id]'
						";
						////echo $sql;
						mysql_query($sql);
						$locacao_id     = $campos['id'];
						$id_equipamento = $campos['id_equipamento_item'];
						$periodo_equipamento = $campos['periodo_equipamento'];
							
						
						if(sizeof($id_equipamento) > 0){
							$valor_item       = $campos['valor_item'];
							$valor_total_item = $campos['valor_total_item'];
							
							$vlr_item_locacao = moedaBrToUsa($campos['valor_total'])/sizeof($id_equipamento);
							for($i=0;$i<sizeof($id_equipamento);$i++){
									if($id_equipamento[$i] != '0'){
												$vlr_item_locacao = $campos[dias]*moedaBrToUsa($valor_item[$i])/$periodo_equipamento[$i];
												$sql_item = " INSERT INTO aluguel_locacao_itens
																	SET
																  vkt_id              = '$vkt_id',
																  locacao_id          = '".$locacao_id."',
																  item_equipamento_id = '".$id_equipamento[$i]."',
																  valor_unitario      = '".moedaBrToUsa($valor_item[$i])."',
																  valor_total         = '".$vlr_item_locacao."',
																  status_item         = '1'
															";
															////echo $sql_item;
															mysql_query($sql_item);
															/*mysql_query(" UPDATE aluguel_equipamentos_itens 
																							SET
																								status = '2'
																							WHERE 
																								id = '".$id_equipamento[$i]."'																			
												");*/
									}
											
							}
						} /* Fim if Sizeof */
						
						//$val_total_locacao = $campos['locacao_valor_total_item'];
						//$locacao_equipamento_id = $campos['locacao_valor_total_item'];
						
						$val_total_item  = $campos['val_total_item'];
						/* id da tabela aluguel_locacao_itens */
						$id_equip_update = $campos['id_equip_update'];
						
						/* id da Tabela aluguel_equipamentos_itens para atualizar, caso o Status cancelado ou devolvido */
						$id_item_equip   = $campos['id_item_equip'];  
						
						//if($status_locacao==2||$status_locacao==4){
							for($j=0; $j < sizeof($id_equip_update);$j++){
									
									if($val_total_item[$j] == '0'){
									mysql_query($t="UPDATE aluguel_equipamentos_itens SET status = '1' WHERE id = '$id_equip_update[$j]'");
									////echo $t;
									$sql_delete = "DELETE FROM aluguel_locacao_itens WHERE id = '$id_item_equip[$j]' ";	
									//alert($sql_delete);
									mysql_query($sql_delete);	
									}
							}
						//}
						/*
						* Se os status for igual a 'Cancelado' ou 'Devolvido' Atualiza as informaçoes do equipamento para disponivel
						*/
										
							if(($status_locacao == '4')){
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
						////echo $id_despesa."<br>";
						
						//alert($id_despesa);
						if($campos[despesas_tbl][$c]==-1){
							deleta_despesa($id_despesa);							
						}else if($id_despesa=='novo'){
							//alert($c);
							insere_despesas($locacao_id,$campos[despesas_tbl][$c],$campos[qtd_despesas][$c],$vkt_id);
						}
						$c++;
					}
					}
					
					if(!empty($campos[descricao_parcela])){
								//seleciona as parcelas
									altera_parcela($locacao_id,$campos[descricao_parcela],$campos[data_vencimento_parcela],$campos[valor_parcela],$vkt_id);						//$c++;
															
					}
						
}

function insere_despesas($locacao_id,$despesa,$qtd,$valor,$vkt_id){
	//print_r($campos[despesas]);
	mysql_query($t="INSERT INTO aluguel_custos SET nome='$despesa',locacao_id='".$locacao_id."', qtd='".$qtd."',valor='".$valor."',vkt_id='$vkt_id'");
	////echo $t;
}

function deleta_despesa($id_despesa){
	mysql_query("DELETE FROM aluguel_custos WHERE id='$id_despesa'");
	////echo $t;
}

function realiza_locacao($dados,$vkt_id){
	mysql_query($t="UPDATE aluguel_locacao SET status_locacao='1',pago='nao' WHERE id='$dados[id]'");
	//mysql_query($t="UPDATE aluguel_equipamentos_itens SET status = '2' WHERE locacao_id = '$dados[id]'");
	////echo $t."<br>";
	if(!empty($dados['id_item_equip'])){
		StatusIndisponivel($dados['id_item_equip']);
	}
	
}
function insere_parcela($locacao_id,$parcela,$valor_parcela,$data_vencimento,$vkt_id){
	
	$inicio = "INSERT INTO";
	$fim    = "";

	$sql = mysql_query($t="$inicio aluguel_pagamento_parcela SET descricao_parcela='$parcela',data_vencimento_parcela='".DataBrToUsa($data_vencimento)."',valor_parcela='".MoedaBrToUsa($valor_parcela)."',status_parcela='2',locacao_id='$locacao_id',vkt_id='$vkt_id' $fim");	
	////echo $t;
}

function altera_parcela($locacao_id,$parcelas,$datas_vencimento,$valores_parcela,$vkt_id){
	
	//seleciona id das parcelas do banco
	$parcelas_banco = mysql_query($t="SELECT * FROM  aluguel_pagamento_parcela WHERE locacao_id='$locacao_id' ORDER BY id");
	////echo $t;
	//quantidade retornada da consulta
	$num_parcelas   = mysql_num_rows($parcelas_banco);
	//tamenho da array parcelas
	$tam_parcelas = sizeof($parcelas);
	//print_r($parcelas)."<br>";
	$c=0;		
	while($parcela_banco = mysql_fetch_object($parcelas_banco)){
		 //verifica se índice existe no array $parcelas, caso exista, atualiza,
		 //caso nao exista, insere 
	 	if($c<$tam_parcelas){
			mysql_query($t="UPDATE aluguel_pagamento_parcela SET descricao_parcela='$parcelas[$c]',data_vencimento_parcela='".DataBrToUsa($datas_vencimento[$c])."',valor_parcela='".MoedaBrToUsa($valores_parcela[$c])."',locacao_id='$locacao_id',vkt_id='$vkt_id' WHERE id = '$parcela_banco->id' AND vkt_id='$vkt_id'");
		}
		////echo $t."<br>";	
		$c++;
	}
	//insere novas parcelas caso $parcelas seja maior que $num_parcelas;
	//caso o número de parcelas seja menor, retira parcelas
	if($tam_parcelas>$num_parcelas){
		for($i=$c;$i<$tam_parcelas;$i++){
			insere_parcela($locacao_id,$parcelas[$i],$valores_parcela[$i],$datas_vencimento[$i],$vkt_id);
		}
	}else{
		$direfenca = $num_parcelas - $tam_parcelas;
		//seleciona parcelas a serem deletadas
		$parcelas_deletar = mysql_query($t="SELECT * FROM aluguel_pagamento_parcela WHERE locacao_id = '$locacao_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT $direfenca");
		while($parcela_deletar=mysql_fetch_object($parcelas_deletar)){
			mysql_query($t="DELETE FROM aluguel_pagamento_parcela WHERE id='$parcela_deletar->id'");
		}
		
		//echo $t."<br>";
	}
	
	
}
?>