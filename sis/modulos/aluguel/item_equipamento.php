<?php
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");

	$acao = $_GET['acao'];
	global $vkt_id;
	
function AtualizaLocacao($id){
		mysql_query($i=" UPDATE aluguel_locacao SET status_locacao = '2' WHERE id = '$id' ");
}
		if($acao == 'equipamento'){
				$equipamento_id = $_POST['equipamento_id'];
				$qtd            = $_POST['qtd'];
				$dias           = $_POST['dias'];
				
					if(!empty($equipamento_id)){
						$item_equipamento = (mysql_query(" SELECT * FROM aluguel_equipamentos_itens WHERE equipamento_id = '$equipamento_id' AND status = '1' AND vkt_id = '$vkt_id' "));
								while($equipamentos=mysql_fetch_array($item_equipamento)){
												$equipamento[] = $equipamentos; 
								}	
								
								for( $i=0;$i < $qtd;$i++){
									
									
									$descricao = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_equipamentos WHERE id = '".$equipamento[$i]['equipamento_id']."'"));
										$v_total = ((($dias) / ($descricao->periodo)) * $descricao->vlr_aluguel);
								echo ' <tr id="'.$equipamento->id.'">
										  <td style="border-left:1px solid #CCC;">
										  	<input type="hidden" name="id_equipamento[]" id="id_equipamento" value='.$equipamento[$i]['id'].' size="5">
											'.$descricao->descricao.' - '.$equipamento[$i]['numero_serie'].'
										  </td>
										  <td>1</td>
										  <td>
										  	<input type="hidden" name="valor_item[]" id="id_item" value="'.moedaUsaToBr($descricao->vlr_aluguel).'" style="width:50px">
											'.moedaUsaToBr($descricao->vlr_aluguel).'
										  </td>
										  <td>
										  	  <input type="hidden" name="valor_total_item[]" id="valor_total_item" style="width:50px" value="'.moedaUsaToBr($v_total).'">
											  '.moedaUsaToBr($v_total).'
										  </td>
										  <td style="width:45px;">
										  	<img src="../fontes/img/menos.png" id="click_equipamento_excluir" style="padding-left:4px;">
										  </td>
									  </tr>';
								}
								//print_r($equipamento);
					}
		}
		
/*--------------------- TESTE -----------------------*/
	if($acao == 'calculadias'){
		// Define os valores a serem usados
		$data_inicial = $_POST['data_loc'];
		$data_final   = $_POST['data_dev'];
			
			// Cria uma funçao que retorna o timestamp de uma data no formato DD/MM/AAAA
			/*function geraTimestamp($data) {
				$partes = explode('/', $data);
				return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
			}
			 
			// Usa a funçao criada e pega o timestamp das duas datas:
			if(!empty($data_inicial) and !empty($data_final)){
				$time_inicial = geraTimestamp($data_inicial);
			}
			if(!empty($data_inicial) and !empty($data_final)){
				$time_final = geraTimestamp($data_final);
			}
			// Calcula a diferença de segundos entre as duas datas:
			$diferenca = $time_final - $time_inicial; // 19522800 segundos
			// Calcula a diferença de dias
			$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
			 
			// Exibe uma mensagem de resultado:
			/*if($dias){
				echo 0;
			}
			echo '0';*/
			$dias = mysql_fetch_object(mysql_query("SELECT DATEDIFF('".dataBrToUsa($data_final)."','".dataBrToUsa($data_inicial)."') as dias"));
			echo $dias->dias; 
			// A diferença entre as datas 23/03/2009 e 04/11/2009 é de 225 dias
	}
	if($acao == 'devolver'){
			$id = $_POST['id'];
			$locacao = $_POST['locacao'];
					
						$select = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_locacao_itens WHERE id = '$id' "));
						mysql_query(" UPDATE aluguel_locacao SET status_locacao = 2 WHERE id = '$select->locacao_id' ");
						mysql_query(" UPDATE aluguel_equipamentos_itens SET status = '1' WHERE id = '$select->item_equipamento_id' ");
						$result = mysql_query(" UPDATE aluguel_locacao_itens SET status_item = '2' WHERE id = '$id'");
						$qtd = mysql_fetch_object(mysql_query("SELECT count(id) as qtd FROM aluguel_locacao_itens WHERE locacao_id = '".$locacao."' AND status_item = '1' "));
						
						echo $result.'-'.$qtd->qtd;						
						
	}
?>