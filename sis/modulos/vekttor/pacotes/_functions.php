<?php
function CadPacote($campos){
				global $vkt_id;		
				$sql = " INSERT INTO pacotes 	
											SET 
										nome = '".$campos['nome']."',
										valor_implantacao = '".moedaBrToUsa($campos['valor_implantacao'])."',
 										valor_mensalidade = '".moedaBrToUsa($campos['valor_mensalidade'])."',
										valor_treinamento = '".moedaBrToUsa($campos['valor_treinamento'])."',
										observacao        = '".$campos['obs']."'
										";
					mysql_query($sql);
					$pacoteID = mysql_insert_id();
					
					$ArrayModulo = $campos['modulo_id'];
						for($i=0;$i < sizeof($ArrayModulo); $i++){
								$SPacoteItem = "  INSERT INTO  pacote_item SET sis_modulo_id = '$ArrayModulo[$i]', pacote_id = '$pacoteID'";
																	
											//$sqlTeste = " INSERT INTO ";
											//echo $SPacoteItem;
											//$UsuarioTipo = " INSERT INTO usuario_tipo_modulo SET";
											mysql_query($SPacoteItem);
						}
					
		
}

function UpdadePacote($campos){
				global $vkt_id;		
				$sql = " UPDATE pacotes 	
											SET 
												nome = '".$campos['nome']."',
												valor_implantacao = '".moedaBrToUsa($campos['valor_implantacao'])."',
												valor_mensalidade = '".moedaBrToUsa($campos['valor_mensalidade'])."',
												valor_treinamento = '".moedaBrToUsa($campos['valor_treinamento'])."',
												observacao        = '".$campos['obs']."'
											WHERE 
												id = '$campos[id]'
										";
					mysql_query($sql);

						$sqlDelete=" DELETE FROM pacote_item WHERE pacote_id = '$campos[id]'";
					
					$ArrayModulo = $campos['modulo_id'];
					for($i=0;$i < sizeof($ArrayModulo); $i++){
							$SPacoteItem = "  INSERT INTO  pacote_item SET sis_modulo_id = '$ArrayModulo[$i]', pacote_id = '$campos[id]'";
							mysql_query($SPacoteItem);
					}
						
		
}

function Deleta($id){
			$sql = " DELETE FROM pacotes WHERE id = '$id' ";
			mysql_query($sql);
}

?>