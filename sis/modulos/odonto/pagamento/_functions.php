<?php
  
  /* === 
  	Função criada por Jaime Neves, antes de alterar qualquer linha desta função fale com o autor  
  === */
  function atualiza_item_procedimento(array $item){
	  
	   $todos_item       = $item['todos_item'];
	   $checkboxMarcado  = $item['marcar'];
	   $totalItem        = count($todos_item);  
	   	
		for($i = 0 ; $i < $totalItem; $i++){
		  if (in_array($checkboxMarcado[$i], $todos_item)) {   
			  mysql_query(" UPDATE odontologo_atendimento_item SET financeiro = 'sim' WHERE id = '$checkboxMarcado[$i]' ");
			  $chave = array_search($checkboxMarcado[$i], $todos_item);
			  unset($todos_item[$chave]); 
		  } 
		}
		
		$itens_false_tam = count($todos_item);
		$itens_false = array_values($todos_item); // Pega somente os itens restantes do array
		
		for($j=0; $j < $itens_false_tam; $j++){
			mysql_query(" UPDATE odontologo_atendimento_item SET financeiro = 'nao', status = '3' WHERE id = '$itens_false[$j]' ");	  
		}
		  
  }
  
  /* === 
  	Função criada por Jaime Neves, antes de alterar qualquer linha desta função fale com o autor 
  === */
  function MandarFinanceiro($campos){
	  
		  global $vkt_id;
					  
		  if(empty($campos['conta_id'])){
				  echo "<script> alert('Selecione uma Conta'); </script>";
				  exit;
		  }
		  if(empty($campos['valor_parcela']))
			  $campos['valor_parcela'] = $campos['valor_total'];
		  
		  if(empty($campos['data_vencimento_parcela']))
			  $campos['data_vencimento_parcela'] = $campos['pri_parcela'];
		  
		  if(empty($campos['descricao_parcela']))
			  $campos['descricao_parcela'] = array('Parcela Única');
		  					  
		  $contaID       = $campos['conta_id'];
		  $centroCustoID = $campos['centro_custo_id'];
		  $plContaID     = $campos['plano_de_conta_id'];
		  $valorParcela  = $campos['valor_parcela'];
		  $desParcela    = $campos['descricao_parcela'];
		  $dataVencimento = $campos['data_vencimento_parcela'];
		  
		  $checkboxMarcado  = $campos['marcar'];
		  if(count($checkboxMarcado) > 0)
		  		atualiza_item_procedimento($campos);
		  
		  $aMes = date('Y/m');
			  
		  //echo "<div id='conteudo'>aqui esta a afuncao</div>";
			  for($i=0;$i < sizeof($valorParcela);$i++){
				$sql = " INSERT INTO financeiro_movimento SET
				  cliente_id        = '$vkt_id',
				  conta_id		    = '$contaID',
				  internauta_id	    = '".$campos['cliente_id']."',
				  data_registro     = now(),
				  data_vencimento	= '".dataBrToUsa($dataVencimento[$i])."',
				  ano_mes_referencia = '$aMes',
				  descricao		     = '".$desParcela[$i]."',
				  doc				= '".$campos['id']."',
				  forma_pagamento   = '".$campos['forma_pagamento']."',
				  valor_cadastro    = '".moedaBRToUsa($valorParcela[$i])."',
				  tipo              = 'receber',
				  status            = '0',
				  movimentacao      = 'financeiro',
				  origem_id         = '".$campos['id']."',
				  origem_tipo       = 'odonto' ";
											  
				  mysql_query($sql);
				  $movID = mysql_insert_id();
											  
				  // SQL PARA TABELA financeiro_centro_has_movimento
				  $sqlCentroAsMov = " INSERT INTO financeiro_centro_has_movimento SET
					movimento_id = '$movID',
					plano_id     = '$centroCustoID[$i]',
					valor        = '".moedaBRToUsa($valorParcela[$i])."'";
					
				  mysql_query($sqlCentroAsMov); 
				  
				  //SQL PARA A TABELA financeiro_plano_has_movimento
				   $sqlPlanoAsMov = " INSERT INTO financeiro_plano_has_movimento SET
					movimento_id = '$movID',
					plano_id     = '$plContaID[$i]',
					valor        = '".moedaBRToUsa($valorParcela[$i])."' ";
					
				  mysql_query($sqlPlanoAsMov);
			  }
	  
	  
  }/*fim da função*/

	function cadastra($campos){
			global $vkt_id;			
		
	}/*fim da função*/

	function excluir($id){}/*fim da função*/

?>