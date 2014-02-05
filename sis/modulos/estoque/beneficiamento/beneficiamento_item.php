<?php
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");

	if($_GET['acao'] == 'cad_beneficiado'){
		
			$produto_beneficiado_id = $_POST['produto_beneficiado_id'];
			$produto                = $_POST['produto'];
			$qtd_pedida             = $_POST['qtd_beneficiado'];
			$data_pedido            = $_POST['data_pedido'];
			
			
			/* Cadastro na tabela estoque_beneficiamento_pedido */
			$data_pedido = dataBrToUsa($data_pedido );
			
				$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id=$produto_beneficiado_id"));
								
				$item_compra = mysql_query($c="SELECT *,i.id as id_compra 
												FROM estoque_compras_item as i,
												estoque_compras as c,
												cliente_fornecedor cf 
														WHERE
															i.vkt_id='$vkt_id' AND
															c.fornecedor_id = cf.id AND  
															c.id=i.pedido_id
														AND 
															i.produto_id = ".$produto_beneficiado_id);
				//echo $c."<br>";									
				$item_compra2 = mysql_query($c="SELECT *,i.id as id_compra FROM estoque_compras_item as i,estoque_compras as c 
	
														WHERE 
															c.id=i.pedido_id
														AND 
															i.produto_id = ".$produto_beneficiado_id);
				
				$selecionado = mysql_fetch_object(mysql_query("SELECT * FROM estoque_compras_item as i 
	
											JOIN estoque_compras as c on c.id=i.pedido_id

													WHERE i.produto_id = ".$produto_beneficiado_id." limit 1 "));

													
					//echo $selecionado->pedido_id;
										
				?>
						 
                         <label>Pedido
         					<select name="pedido_id" id="pedido_id">
                            		<option value="0">Selecione</option>
                    				<?
                        				while($itens_pedido=mysql_fetch_object($item_compra)){
												if($selecionado->pedido_id == $itens_pedido->pedido_id){$sel='selected="selected"';}else{$sel='';}
												
									?>
                        
                  <option  <?=$sel?> value="<?=$itens_pedido->id_compra?>"><?=$itens_pedido->pedido_id." - ".utf8_encode($itens_pedido->marca)." ".utf8_encode($itens_pedido->razao_social)?></option>
                    				<?
										}
						$sql_fornecedor=mysql_fetch_object(mysql_query($f="SELECT * FROM cliente_fornecedor WHERE id = ".$selecionado->fornecedor_id));
									?>
                    		</select>
        
         				
                        </label><!-- fim pedido --><br><br> 
                      <div id="info_pedido">
                        
                          
                                    
                            <label id="cd_data" style="width:70px;">Data Pedido
                                <input type="text" size="6" name="data_pedido" id="data_pedido" value="<?=dataUsaToBr($selecionado->data_inicio)?>">
                            </label><br><br/>
                            
                           
                                <input type="hidden" size="6" name="pedido_beneficiamento_id" id="pedido_beneficiamento_id" value="<?=$selecionado->pedido_id?>">
                            
                        
                		</div>
 				         
                
				<?
				
				
	} /* fim de if Cad Beneficiado */
	
		if($_GET['acao'] == 'pedido_info'){
				
					$pedido_id = $_POST['pedido_id'];
				
					$sql_pedido  = mysql_fetch_object(mysql_query($p="SELECT * FROM estoque_compras_item i
																		JOIN estoque_compras c on i.pedido_id=c.id
																			WHERE i.id =".$pedido_id));
					$sql_fornecedor=mysql_fetch_object(mysql_query($f="SELECT * FROM cliente_fornecedor WHERE id = ".$sql_pedido->fornecedor_id));
					//alert($p);
					
					$t= "<label id='cd_data' style='width:70px;'>Data Pedido
                              <input type='text' name='data_pedido' id='data_pedido' value=".dataUsaToBr($sql_pedido->data_inicio).">
                       </label><br></br><br/>                      
                        
                                <input type='hidden' size='6' name='pedido_beneficiamento_id' id='pedido_beneficiamento_id' value='$sql_pedido->pedido_id?>'>
                            
                       <div style='clear:both'></div>";
					   echo $t;
									
		} /* Fim de if */
	
		if($_GET['acao'] == 'cad_derivado'){
				
				$produto    = $_POST['produto_derivado'];
				$id_pedido  = $_POST['id_pedido'];
				$produto_id = $_POST['produto_id'];
				$qtd_pedida = $_POST['qtd_derivado'];
				$und        = $_POST['und'];
				$fatorconversao  = $_POST['fatorconversao'];
				$conversao2 = $_POST['conversao2']; 
				$qtd_unidade_uso = $qtd_pedida * $fatorconversao;
				
				
				$total_beneficiado = $_POST['total_beneficiado'];
				$qtd_total_derivado += $qtd_pedida;
				
				$obs_derivado = iconv("UTF-8", "ISO-8859-1", $_POST['obs_derivado']);
				
				
				echo '
				<tr>
				  <td width="200" style="border-left:1px solid #CACACA">
				  	 <input type="hidden" name="produto_derivado_id[]" id="produto_derivado_id" value="'.$produto_id.'">
				     '.$produto.'
				  </td>
				  <td width="100" ><span class="qtd_pedida">'.moedaUsaToBr($qtd_pedida)."</span> ".substr($und,0,2)." - <span class='qtd_pedida_uso'>".moedaUsaToBr($qtd_unidade_uso)."</span>  ".substr($conversao2,0,2).'
				  	<input type="hidden" name="qtd_derivado[]" id="qtd_derivado" size="5" style="height:10px;font-size:11px;" value="'.$qtd_pedida.'">
				  </td>
				 
				  <td>'.$_POST['obs_derivado'].'
				  	<input type="hidden" name="obs_derivado1[]" id="obs_derivado1" value="'.$_POST['obs_derivado'].'">
				  </td>
				  <td width="20">
				  <a href="#" class="delete_derivado"><img src="modulos/estoque/transferencia/menos.png"></a>
				  </td>
				</tr>';
				
				
		}
		
		if($_GET['acao'] == 'exclui_pedido'){
		
					$id_pedido = $_POST['id_pedido'];
					
					mysql_query(" DELETE FROM estoque_beneficiamento_pedido WHERE id = ".$id_pedido);
			
		}
		
		if($_GET['acao'] == 'update_qtd_beneficiado'){
			
				$id = $_POST['id_pedido'];
				$qtd = $_POST['qtd'];
				
					mysql_query(" UPDATE estoque_beneficiamento_pedido 
									SET 
										qtd_pedido = '$qtd'
									WHERE id = '$id'
									");	
		}
		if($_GET['acao'] == 'exclui_derivado_item'){
		
				$id = $_POST['id'];
				
					mysql_query("
					
								DELETE FROM estoque_beneficiamento_item
									WHERE id = '$id'
					");	
		}
		if($_GET['acao'] == 'delete_item'){
				
					$id = $_POST['id'];
					
						mysql_query(" DELETE FROM estoque_beneficiamento_item WHERE id = '$id'");
			
		}
		if($_GET['acao'] == 'cancelar'){
				$status = $_POST['status'];
				$id     = $_POST['beneficiamento'];
				
					$sql=" UPDATE estoque_beneficiamento_pedido 
								SET
									status = '$status'
								WHERE 
									id = '$id'
					";
					//echo $sql;
					mysql_query($sql);
		}

?>
 