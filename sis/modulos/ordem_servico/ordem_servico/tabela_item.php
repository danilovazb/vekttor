<?php
include("../../../_config.php");
include("../../../_functions_base.php");



		$acao = $_GET['acao'];
			
			if($acao == 'produto'){
					
					$produto    = $_POST['produto'];
					$produto_id = $_POST['produto_id'];	
					$qtd        = $_POST['qtd'];
					
					if($produto != NULL and $produto_id != NULL){
						
						$sql_produto = mysql_fetch_object(mysql_query(" SELECT * FROM produto WHERE vkt_id = '$vkt_id' AND id = '$produto_id'"));
						$total = $qtd * $sql_produto->preco_venda; 
						
						echo '
						<tr id="'.$produto_id.'">
						      <td style="display:none">
								<input type="hidden" name="item_produto[]" value="">
								<input type="text" name="array_produto_id[]" id="array_produto_id" value="'.$produto_id.'" size="5">
							  </td>
							  <td width="340" style="border-left:1px solid #CCC;">
								'.$produto.'
							  </td>
							  <td width="50">
							  	<input type="hidden" name="array_qtd_produto[]" id="array_qtd_produto" value="'.$qtd.'" size="3">
								'.$qtd.'
							  </td>
							  <td width="80">
							  	<input type="hidden" name="array_valor_produto[]" id="array_valor_produto" value="'.moedaUsaToBr($sql_produto->preco_venda).'" size="5">
								'.moedaUsaToBr($sql_produto->preco_venda).'
							  </td>
							  <td width="80">
							  <input type="hidden" name="v_total_produto[]" id="v_total_produto" value="'.moedaUsaToBr($total).'" size="5">
								'.moedaUsaToBr($total).'
							  </td>
							  <td width="30" style="padding-left:3px;">
							  <img src="../fontes/img/menos.png" id="click_produto_excluir" style="padding-left:4px;">
							  </td>
						</tr>';
					} else{
						echo 'error';	
					}
			} /* Fim de IF */
			
			else if($acao == 'servico'){
					$total = 0;
					$total_final_servico = 0;
					$servico        = $_POST['servico'];
					$servico_id     = $_POST['servico_id'];	
					$qtd            = $_POST['qtd'];
					$funcionario_id = $_POST['funcionario_id'];
					$obsProducao    = $_POST['obsProducao'];
					$marcador       = $_POST['marcador'];
					$altura			= $_POST['altura'];
					$largura		= $_POST['largura'];
					$obsItem        =  !empty($altura) ? $altura." x ".$largura." ".$_POST['obsItem'] : $_POST['obsItem'];
					$valor			= $_POST['valor'];
					 
					 if(!empty($funcionario_id)){
						$funcionario = mysql_fetch_object(mysql_query(" SELECT * FROM rh_funcionario WHERE id = '$funcionario_id' AND vkt_id = '$vkt_id'"));
					 }
					if(($servico != NULL)){
						
						$sql_servico = mysql_fetch_object(mysql_query(" SELECT * FROM servico WHERE vkt_id = '$vkt_id' AND id = '$servico_id' "));
						$valor_servico = $sql_servico->valor_normal;
						$total = moedaBrToUsa($qtd) * $valor;
							
					echo '
						 <tr id="'.$servico_id.'">
						      <td style="display:none;">
							    <input type="text" name="item_servico_cad[]" value="">
							  	<input type="text" name="array_servico_id[]" id="array_servico_id" value="'.$servico_id.'" size="4">
							  </td>
							  <td width="20" style="padding-left:4px;display:none;">
							  	<input type="checkbox" checked="checked" name="marcado_cad_servico[]" id="marcado_cad_servico" value="1">
							  	<input type="hidden" name="check_cad_servico[]" id="check_cad_servico" size="5" value="2">
								<input type="hidden" name="altura_item[]" id="altura" value="'.$altura.'">
								<input type="hidden" name="largura_item[]" id="largura" value="'.$largura.'">
							  </td>
							  <td style="border-left:0px solid #CCC;"><span rel="tip" title="'.$servico.'">'.LimitarString($servico,20).'</span></td>
							  <td style="width:161px;">
							  	<input type="hidden" name="array_funcionario_id[]" id="array_funcionario_id" value="'.$funcionario_id.'" size="5">
								'.iconv("iso-8859-2","utf-8",LimitarString($funcionario->nome,18)).'
							  </td>
							  <td width="160">
							  	<input type="text" style="height:10px;" name="obsItem[]" id="obsItem" value="'.$obsItem.'">
							  </td>
							  <td width="160">
							  	<input type="text" style="height:10px;" name="obsProducao[]" id="obsProducao" value="'.$obsProducao.'">
							  </td>
							  <td style="width:42px;">
							  	<input type="hidden" name="array_qtd_servico[]" id="array_qtd_servico" class="array_servico_qtd" value="'.$qtd.'" size="2">
								'.$qtd.'
							  </td>
							  <td >
							  	<input type="hidden" name="valor_tecnico[]" id="valor_tecnico" value="'.moedaUsaToBr($sql_servico->valor_colaborador).'" size="4">
								<input type="text" name="array_valor_servico[]" id="array_valor_servico" class="array_servico_valor" value="'.moedaUsaToBr($valor).'" size="4" decimal="2">
								
							  </td>
							  <td>
							  	<input type="hidden" name="v_total_servico" id="v_total_servico" value="'.moedaUsaToBr($total).'" size="4">
							  	<span class="total_servico_item">'.moedaUsaToBr($total).'</span>
							  </td>
							  
							  <td>
							  <img src="../fontes/img/menos.png" id="click_servico_excluir">
							  </td>
                    	 </tr>
					'; 
					} else{
						echo 'error';	
					}
					
			} /*Fim de else if */
			else if($acao == 'atl_cliente'){
					$nome =  utf8_decode($_POST['nome']);	
				
					if(!empty($_POST['tipo'])){
							$tipo = $_POST['tipo'];	
					} else{ $tipo = "Cliente"; }
					
					if($_POST['tipo_cadastro'] == '1'){
						$tipo_cliente = "Físico";
					}else{ $tipo_cliente = "Jurídico"; }
					
				mysql_query($r=" INSERT INTO cliente_fornecedor 
								   SET 
								   cliente_vekttor_id = '$vkt_id', 
								   usuario_id         = '$usuario_id', 
								   razao_social       = '".$nome."', 
								   nome_fantasia      = '".$nome."',
								   nome_contato       = '".$nome."', 
								   cnpj_cpf           = '".$_POST['cnpjCpf']."', 
								   tipo               = '$tipo',
								   tipo_cadastro      = '$tipo_cliente' ");
					$id = mysql_insert_id();
					echo $id; 
			}
			else if($acao == 'excluir_item'){
				
						 $produto_id = $_POST['produto_id'];
						 $os_id      = $_POST['os_id'];
						
						//echo '<input type="text" name="produto_excluir[]" id="produto_excluir" value="'.$produto_id.'"><br/>';
																
			}
			else if($acao == 'upObsItem'){
					//$obs = $_POST['obs'];
					$id  = $_POST['id'];
					$observacao = iconv('utf-8','iso-8859-1',$_POST['obs']);
					$sql=" UPDATE  os_item SET obs_item_servico = '".$observacao."' WHERE id = '$id' ";
					mysql_query($sql);
			}
			else if($acao == 'upObsProducao'){
					//$obs = $_POST['obs'];
					$id  = $_POST['id'];
					$observacao = iconv('utf-8','iso-8859-1',$_POST['obs']);
					$sql=" UPDATE  os_item SET obs_item_producao = '".$observacao."' WHERE id = '$id' ";
					mysql_query($sql);
			}else
			if($acao == 'calcularDias'){
						//A data deve estar no formato dd/mm/yyyy
						$data    = $_POST['dataRef'];
						$periodo = $_POST['diasCont'];						
						//Separaçao dos valores (dia, mes e ano)
						$arr = explode("/", $data);
 
							$dia = $arr[0];
							$mes = $arr[1];
							$ano = $arr[2];
						
						//Somar Data
						$data_inc = date('d/m/Y', mktime(0, 0, 0, $mes, $dia + $periodo, $ano));
						
						echo $data_inc.'<br/>';
			}
					
			//echo SomarData(”11/02/2009”, 1, 2, 1);
			function SomarData($data, $dias, $meses, $ano){
				//A data deve estar no formato dd/mm/yyyy
				$data = explode("/", $data);
				$newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano) );
				return $newData;
			}
			
   
?>
